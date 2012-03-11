<?php
/* 
 Plugin Name: wk_submit
 Plugin URI: http://knorcedger.com
 Description: Submit and edit posts.
 Version: 0.8.10
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Submits a post (Default fields post_title, post_content, post_category, tags_input)
 * 
 * For a photo, the params are -> type|name|translation|width|height|size -> wk_edit_profile(array('photo|avatar|100|100|300'));
 * For a textfield, the params are -> type|name|translation|size -> wk_edit_profile(array('textfield|first_name|Όνομα|30'));
 * For categories, the params are -> type|name|translation -> wk_edit_profile(array('category|post_category|Κατηγορίες'));
 * For a textarea, the params are -> type|name|translation|cols|rows -> wk_edit_profile(array('textarea|description|Περιγραφή|30|20'));
 * For a date, the params are -> type|name|translation -> wk_edit_profile(array('date|delivery|Παράδοση'));
 * For a time, the params are -> type|name|translation|precision -> wk_edit_profile(array('time|delivery_time|Παράδοση|30'));  [precision=1-60]
 * For a dropdown, the params are -> type|name|translation|var_name~var_value~var_name~var_value -> wk_edit_profile(array('dropdown|custom_dd|Είδος|Μακρύ~long~Μεσαίο~middle~Κοντό~short'));
 * For a checkbox, the params are -> type|name|translation|var_name~var_value~var_name~var_value -> wk_edit_profile(array('checkbox|mycheckbox|Είδος|Μακρύ~long~Μεσαίο~middle~Κοντό~short'));
 * 
 * @example wk_submit('gr', 'publish', array('textarea|post_content|Παραγγελία|40|8', 'date|checkin|Ημερομηνία Παραλαβής', 'time|checkin_time|Ώρα Παραλαβής|30'), "entry_type|order|owner|$user_id|status|incomplete");
 * 
 * Explain: We create a vars array with the names of all the params of the form we sent
 * and then we sent it to submit.php.
 * The textfield has the special values post_title, tags_input and the rest simple fields
 * The textarea has the special value post_content
 * For the photo, we use an iframe, it uploads the photo and returns a status message.
 * When a user uploads a photo but doesnt submit the article, we have to delete that 
 * photo next time someone tries to submit an article, so the photo.php file checks 
 * if the custom field exists and empties it.
 * The checkbox adds everyone of its values to the post meta table but the 
 * checked values are empty, while the checked ones contain their names.
 * For the time we save two values: name.'_hour' and name.'_minute'
 * For the date we save 3 values $name.'_day', $name.'_month', $name.'_year'
 * The dropdown saves only the selected value inside a cell with its name
 * 
 * @return 
 * @param string $language
 * @param string $post_status [publish, pending]
 * @param array $fields
 * @param string $hidden Send hidden vars like entry_type, owner... [name|value|name|value|...] [Example: entry_type|order|owner|7]
 * 
 * 
 */
function wk_submit($language, $post_status, $fields, $hidden = ''){
	
	include 'languages/'.$language.'.php';

	global $current_user;
	get_currentuserinfo();
	
	?>
	
	<div class="wk_submit">
		<form id="submitform" action="/wp-content/plugins/wk_submit/submit.php" method="post">

			<?php
			$path = '';
			include 'field_loop.php';
			/*
			foreach ($fields as $val) {
				//seperate type and name
				$temp = explode('|', $val);
				$type = $temp[0];
				$name = $temp[1];
				$translation = $temp[2];
				
				//save names to send to form to be able to know how many vars to expect
				//if date, add 3 values
				if($type == 'date'){
					array_push($vars, $name.'_day', $name.'_month', $name.'_year');
				}elseif($type == 'time'){
					array_push($vars, $name.'_hour', $name.'_minute');
				}elseif($type == 'checkbox'){
					//save and seperate checkbox values
					$allvalues = explode('~', $temp[3]);
					//find var_names to add to vars
					$i = 0;
					foreach ($allvalues as $val) {
						if($i%2 == 0){
							//do nothing
						}else{
							//var names are first (before values)
							array_push($vars, $val);
						}
						$i++;
					}
				}else{
					array_push($vars, $name);
				}

				if($type == 'textfield'){
					//include file
					include_once 'textfield.php';
					//save remaining vars
					$size = $temp[3];
					wk_submit_textfield($name, $translation, $size);
				}elseif($type == 'textarea'){
					//include file
					include_once 'textarea.php';
					//save remaining vars
					$cols = $temp[3];
					$rows = $temp[4];
					wk_submit_textarea($name, $translation, $cols, $rows);
				}elseif($type == 'category'){
					//include file
					include_once 'category.php';
					wk_submit_category($name, $translation);
				}elseif($type == 'date'){
					//include file
					include_once 'date.php';
					wk_submit_date($name, $translation, $language);
				}elseif($type == 'time'){
					//include file
					include_once 'time.php';
					//save remaining vars
					$precision = $temp[3];
					wk_submit_time($name, $translation, $precision, $language);
				}elseif($type == 'dropdown'){
					//include file
					include_once 'dropdown.php';
					//save remaining vars
					//empty arrys in order for the second dd not to remember values of the first
					$allvalues = '';
					$myvalues = '';
					//save and seperate dropdown values
					$allvalues = explode('~', $temp[3]);
					//format allvalues in couples to send to function
					$i = 0;
					foreach ($allvalues as $val) {
						if($i%2 == 0){
							$temp2 = $val;
						}else{
							$myvalues[$i/2] = $temp2 . '|' . $val;
						}
						$i++;
					}
					wk_submit_dropdown($name, $translation, $myvalues);
				}elseif($type == 'checkbox'){
					//include file
					include_once 'checkbox.php';
					//save remaining vars
					//save and seperate checkbox values
					$allvalues = explode('~', $temp[3]);
					//format allvalues in couples to send to function
					$i = 0;
					foreach ($allvalues as $val) {
						if($i%2 == 0){
							$temp2 = $val;
						}else{
							$myvalues[$i/2] = $temp2 . '|' . $val;
						}
						$i++;
					}
					wk_submit_checkbox($name, $translation, $myvalues);
				}elseif ($type == 'photo') {
					//save remaining vars
					$width = $temp[3];
					$height = $temp[4];
					$size = $temp[5];
					//add stylesheet url
					$stylesheet = get_bloginfo('stylesheet_url');
					//display the iframe
					$params = "name=$name&translation=$translation&width=$width&height=$height&size=$size&stylesheet=$stylesheet";
					?>
					<!--iframe name="<?php echo $name; ?>" frameborder="0" marginwidth="0px" marginheight="0px" scrolling="no" src ="/wp-content/plugins/wk_submit/photo.php?<?php echo $params; ?>" width="100%" height="50px"></iframe-->
					
					<?php
				/*	
				}
				
				
			}*/
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
			<?php
			//add hidden vars
			$hidden_array = explode('|', $hidden);
			$vars_hidden = '';
			for($i=0;$i<sizeof($hidden_array);$i++) { 
				if($i%2 == 0){
					$vars_hidden .= $hidden_array[$i] . '|';
				}else{ ?>
					<input type="hidden" name="<?php echo $hidden_array[$i-1]; ?>" value="<?php echo $hidden_array[$i]; ?>" />
				<?php
				}
			}
			//remove the last char which is |
			$vars_hidden = substr($vars_hidden, 0, strlen($vars_hidden)-1);
			?>
			<input type="hidden" name="vars_hidden" value="<?php echo $vars_hidden; ?>" />
			
			<input name="submit" type="submit" id="submit" value="<?php echo $submit_txt; ?>" />
		</form>
	</div>
	
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
	
	<div class="wk_submit">
		<form id="editform" action="/wp-content/plugins/wk_submit/edit.php" method="post">

			<?php
			
			foreach ($fields as $val) {
				//seperate type and name
				$temp = explode('|', $val);
				$type = $temp[0];
				$name = $temp[1];
				$translation = $temp[2];
				
				//save names to send to form to be able to know how many vars to expect
				//if date, add 3 values
				if($type == 'date'){
					array_push($vars, $name.'_day', $name.'_month', $name.'_year');
				}elseif($type == 'time'){
					array_push($vars, $name.'_hour', $name.'_minute');
				}elseif($type == 'checkbox'){
					//save and seperate checkbox values
					$allvalues = explode('~', $temp[3]);
					//find var_names to add to vars
					$i = 0;
					foreach ($allvalues as $val) {
						if($i%2 == 0){
							//do nothing
						}else{
							//var names are first (before values)
							array_push($vars, $val);
						}
						$i++;
					}
				}else{
					//dont add photos
					if($type != 'photo'){
						array_push($vars, $name);
					}
				}

				if($type == 'textfield'){
					//include file
					include_once 'textfield.php';
					//save remaining vars
					$size = $temp[3];
					wk_submit_textfield($name, $translation, $size, $post[0]);
				}elseif($type == 'textarea'){
					//include file
					include_once 'textarea.php';
					//save remaining vars
					$cols = $temp[3];
					$rows = $temp[4];
					wk_submit_textarea($name, $translation, $cols, $rows, $post[0]);
				}elseif($type == 'category'){
					//find the category id to send it to category.php
					$postcat = get_the_category($post[0]->ID);
					$category = $postcat[0]->cat_ID;
					//include file
					include_once 'category.php';
					wk_submit_category($name, $translation, $category);
				}elseif($type == 'date'){
					//include file
					include_once 'date.php';
					wk_submit_date($name, $translation, $language, $post[0]);
				}elseif($type == 'time'){
					//include file
					include_once 'time.php';
					//save remaining vars
					$precision = $temp[3];
					wk_submit_time($name, $translation, $precision, $language, $post[0]);
				}elseif($type == 'dropdown'){
					//include file
					include_once 'dropdown.php';
					//save remaining vars
					//save and seperate dropdown values
					$allvalues = explode('~', $temp[3]);
					//format allvalues in couples to send to function
					$i = 0;
					foreach ($allvalues as $val) {
						if($i%2 == 0){
							$temp2 = $val;
						}else{
							$myvalues[$i/2] = $temp2 . '|' . $val;
						}
						$i++;
					}
					wk_submit_dropdown($name, $translation, $myvalues, $post[0]);
				}elseif($type == 'checkbox'){
					//include file
					include_once 'checkbox.php';
					//save remaining vars
					//save and seperate checkbox values
					$allvalues = explode('~', $temp[3]);
					//format allvalues in couples to send to function
					//example :Array ( [0] => Parking|Parking [1] => Μετρό|Metro [2] => Καλοκαιρινό|Summer )
					$i = 0;
					foreach ($allvalues as $val) {
						if($i%2 == 0){
							$temp2 = $val;
						}else{
							$myvalues[$i/2] = $temp2 . '|' . $val;
						}
						$i++;
					}
					wk_submit_checkbox($name, $translation, $myvalues, $post[0]);
				}elseif ($type == 'photo') {
					//save remaining vars
					$width = $temp[3];
					$height = $temp[4];
					$size = $temp[5];
					//add stylesheet url
					$stylesheet = get_bloginfo('stylesheet_url');
					//display the iframe
					//add the id param to it for the edit and status to display the previous photo
					$post_id = $post[0]->ID;
					$params = "post_id=$post_id&name=$name&translation=$translation&width=$width&height=$height&size=$size&stylesheet=$stylesheet&status=editing";
					?>
					<iframe name="<?php echo $name; ?>" frameborder="0" marginwidth="0px" marginheight="0px" scrolling="no" src ="/wp-content/plugins/wk_submit/photo.php?<?php echo $params; ?>" width="100%" height="50px"></iframe>
					
					<?php
					
				}
				
				
			}
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
			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
			<input name="submit" type="submit" id="submit" value="<?php echo $submit_txt; ?>" />
		</form>
	</div>
	
<?php
}
?>