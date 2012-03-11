<?php
/* 
 Plugin Name: wk_submit
 Plugin URI: http://knorcedger.com
 Description: Submit and edit posts.
 Version: 1.0.0 b1
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Submits a post (Default fields post_title, post_content, post_category, tags_input)
 * 
 * For a photo, the params are -> type|name|translation|width|height|size|thumb~thumbwidth~thumbheight~cropratio -> wk_edit_profile(array('photo|avatar|Photo|100|100|300|1~80~80~1:1'));
 * For a textfield, the params are -> type|name|translation|size -> wk_edit_profile(array('textfield|first_name|Όνομα|30'));
 * For categories, the params are -> type|name|translation -> wk_edit_profile(array('category|post_category|Κατηγορίες'));
 * For a textarea, the params are -> type|name|translation|cols|rows -> wk_edit_profile(array('textarea|description|Περιγραφή|30|20'));
 * For a date, the params are -> type|name|translation -> wk_edit_profile(array('date|delivery|Παράδοση'));
 * For a time, the params are -> type|name|translation|precision -> wk_edit_profile(array('time|delivery_time|Παράδοση|30'));  [precision=1-60]
 * For a dropdown, the params are -> type|name|translation|var_name~var_value~var_name~var_value -> wk_edit_profile(array('dropdown|custom_dd|Είδος|Μακρύ~long~Μεσαίο~middle~Κοντό~short'));
 * For a checkbox, the params are -> type|name|translation|var_name~var_value~var_name~var_value -> wk_edit_profile(array('checkbox|mycheckbox|Είδος|Μακρύ~long~Μεσαίο~middle~Κοντό~short'));
 * 
 * @example wk_submit('gr', 'publish', array('textarea|post_content|Παραγγελία|40|8', 'date|checkin|Ημερομηνία Παραλαβής', 'time|checkin_time|Ώρα Παραλαβής|30'), "entry_type|order|owner|$user_ID|status|incomplete");
 * 
 * Explain: We create a vars array with the names of all the params of the form we sent
 * and then we sent it to submit.php.
 * - The TEXTFIELD has the special values post_title, tags_input and the rest simple fields
 * - The TEXTAREA has the special value post_content
 * - For the PHOTO, we use an iframe, it uploads the photo and returns a status message.
 * When a user uploads a photo but doesnt submit the article, we have to delete that 
 * photo next time someone tries to submit an article, so the photo.php file checks 
 * if the custom field exists and empties it.
 * - The CHECKBOX adds everyone of its values to the post meta table and the 
 * not checked values are empty, while the checked ones contain their names.
 * - For the TIME we save two values: name.'_hour' and name.'_minute'
 * - For the DATE we save 3 values $name.'_day', $name.'_month', $name.'_year'
 * - The DROPDOWN saves only the selected value inside a cell with its name
 * 
 * @return 
 * @param string $language
 * @param string $post_status [publish, pending]
 * @param array $fields
 * @param string $hidden Send hidden vars like entry_type, owner... [name|value|name|value|...] [Example: entry_type|order|owner|7]
 * 
 * 
 */
wp_enqueue_script('jquery');

function wk_submit($language, $post_status, $post_id, $fields/*, $hidden = ''*/){
	
	include 'languages/'.$language.'.php';

	global $current_user;
	get_currentuserinfo();
	
	?>
	
	<form class="submitform" action="/wp-content/plugins/wk_submit/submit.php" method="post">

		<?php
		//include field_loop
		//$path = '';
		$object_id = '';
		$object_type = 'post';
		include 'field_loop.php';
			
		//transform the vars to send to update_profile.php
		$vars_send = '';
		foreach ($vars as $val) {
			$vars_send .= $val . '|';
		}
		//remove the last char which is |
		$vars_send = substr($vars_send, 0, strlen($vars_send)-1);
		?>
	
		<input type="hidden" name="vars_send" value="<?php echo $vars_send; ?>" />
		<input type="hidden" name="user_id" value="<?php echo $current_user->ID; ?>" />
		<input type="hidden" name="post_status" value="<?php echo $post_status; ?>" />
		<input type="hidden" name="object_type" value="<?php echo $object_type; ?>" />
		<?php
		//add hidden vars
		/*
		$hidden_array = explode('|', $hidden);
		$vars_hidden = '';
		for($i=0;$i<sizeof($hidden_array);$i++) { 
			if($i%2 == 0){
				$vars_hidden .= $hidden_array[$i] . '|';
			}else{*/ ?>
				<!--input type="hidden" name="<?php echo $hidden_array[$i-1]; ?>" value="<?php echo $hidden_array[$i]; ?>" /-->
			<?php
			/*
			}
		}
		//remove the last char which is |
		$vars_hidden = substr($vars_hidden, 0, strlen($vars_hidden)-1);
		*/
		?>
		<!--input type="hidden" name="vars_hidden" value="<?php echo $vars_hidden; ?>" /-->
		
		<input name="submit" type="submit" id="submit" value="<?php echo $submit_txt; ?>" />
	</form>

	
<?php
}

/**
 * Edit a post
 * 
 * Only post_status = publish is supported for now
 * When someone edits the picture, it saves it when he uploads it, not on submit
 * 
 * @return 
 * @param string $language
 * @param int $post_id
 * @param string $post_status [publish]
 * @param array $fields
 */
function wk_submit_edit($language, $post_id, $post_status, $fields){
	
	include 'languages/'.$language.'.php';

	global $current_user;
	get_currentuserinfo();
	//stores the names of vars sent to submit.php
	$vars = array();
	//fetch the post we are trying to edit
	$post = query_posts('p='.$post_id);
	?>
	
	<form class="editform" action="/wp-content/plugins/wk_submit/edit.php" method="post">

		<?php
		//include field_loop
		//$path = '';
		$object_id = $post_id;
		$object_type = 'post';
		include 'field_loop.php';
			
		//transform the vars to send to update_profile.php
		$vars_send = '';
		foreach ($vars as $val) {
			$vars_send .= $val . '|';
		}
		//remove the last char which is |
		$vars_send = substr($vars_send, 0, strlen($vars_send)-1);
		?>
	
		<input type="hidden" name="vars_send" value="<?php echo $vars_send; ?>" />
		<input type="hidden" name="user_id" value="<?php echo $current_user->ID; ?>" />
		<input type="hidden" name="post_status" value="<?php echo $post_status; ?>" />
		<input type="hidden" name="object_id" value="<?php echo $object_id; ?>" />
		<input name="submit" type="submit" id="submit" value="<?php echo $submit_txt; ?>" />
	</form>
	
<?php
}
?>