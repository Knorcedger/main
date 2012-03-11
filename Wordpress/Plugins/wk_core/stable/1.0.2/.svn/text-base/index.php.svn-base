<?php
/* 
 Plugin Name: wk_core
 Plugin URI: http://knorcedger.com
 Description: Submit and edit posts. Update user profiles
 Version: 1.0.2
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Submits a post (Default fields post_title, post_content, post_category, tags_input)
 * 
 * PHOTO, the params are -> level|type|name|translation|default|width|height|size|thumb~thumbwidth~thumbheight~cropratio -> 1|photo|avatar|Photo||1000|1000|300|1~80~80~1:1
 * PHOTO without a thumbnail -> 1|photo|avatar|Photo||1000|1000|300|0
 * TEXTFIELD, the params are -> level|type|name|translation|default|size -> 1|textfield|first_name|Όνομα|Default|30
 * CATEGORIES, the params are -> level|type|name|translation|default -> category|post_category|Κατηγορίες
 * TEXTAREA, the params are -> level|type|name|translation|default|cols|rows -> 1|textarea|description|Περιγραφή|Default|30|20
 * DATE, the params are -> level|type|name|translation|default -> 1|date|delivery|Παράδοση|3~12~2009
 * TIME, the params are -> level|type|name|translation|default|precision -> 1|time|delivery_time|Παράδοση|7~30|30  [precision=1-60]
 * DROPDOWN, the params are -> level|type|name|translation|default|var_name~var_value~var_name~var_value -> dropdown|custom_dd|Είδος|2|Μακρύ~long~Μεσαίο~middle~Κοντό~short
 * CHECKBOX, the params are -> level|type|name|translation|default|var_name~var_value~var_name~var_value -> checkbox|mycheckbox|Είδος|1~0~1|Μακρύ~long~Μεσαίο~middle~Κοντό~short
 * 
 * @example wk_submit('gr', 0, array('1|textfield|post_title|Title|default value|30', '0|textfield|fire|Φωτιά|Παντού|30', '1|textarea|post_content|Κείμενο|default value|30|5', '1|date|delivery|Παράδοση|3~12~2009', '0|time|delivery_time|Παράδοση|7~30|30', '1|dropdown|custom_dd|Είδος|2|Μακρύ~long~Μεσαίο~middle~Κοντό~short', '0|checkbox|mycheckbox|Είδος|1~0~1|Μακρύ~long~Μεσαίο~middle~Κοντό~short', '1|photo|avatar|Photo||1000|1000|300|1~80~80~1:1'));
 * 
 * EXPLAIN: We send all the vars with $_POST and then save all of them.
 * The hidden vars never reach submit.php, but inout is displayed with default value.
 * - The TEXTFIELD has the special values post_title and tags_input and the rest simple fields.
 * - The TEXTAREA has the special value post_content.
 * - For the PHOTO, we use an iframe, it uploads the photo and returns a status message.
 * When a user uploads a photo but doesnt submit the article, we have to delete that 
 * photo next time someone tries to submit an article, so the photo.php file checks 
 * if the custom field exists and empties it.
 * - The CHECKBOX adds to the post meta table only the vars whose values are checked 
 * and they contain their names.
 * - For the TIME we save two values: $name.'_hour' and $name.'_minute'
 * - For the DATE we save 3 values $name.'_day', $name.'_month', $name.'_year'
 * - The DROPDOWN saves only the selected value inside a cell with its name
 * 
 * @return 
 * @param string $language
 * @param array $fields
 * 
 * 
 */
wp_enqueue_script('jquery');

function wk_submit($language, $object_id, $fields){
	
	include 'languages/'.$language.'.php';

	global $current_user;
	get_currentuserinfo();
	
	?>
	
	<form class="submitform" action="/wp-content/plugins/wk_core/submit.php" method="post">

		<?php
		//include field_loop
		$object_type = 'post';
		include 'field_loop.php';
		?>

		<input type="hidden" name="user_id" value="<?php echo $current_user->ID; ?>" />
		<input type="hidden" name="object_id" value="<?php echo $object_id; ?>" />
		<input type="hidden" name="object_type" value="<?php echo $object_type; ?>" />
		
		<input type="submit" value="<?php echo $submit_txt; ?>" />
	</form>

<?php
}

/**
 * Displays the edit profile info we want (Default fields first_name, last_name, user_email, user_url, description)
 * 
 * EXPLAIN: Default values do nothing in profiles because
 * a user might wanna leave a field empty, and we would force
 * them to accept the default and they would see it the next
 * time they try to edit their profile
 * 
 * wk_profile('gr', 2, array('1|textfield|first_name|Όνομα||30', '0|textfield|fire|Φωτιά|Παντού|30', '0|textarea|test_text|Κείμενο|default value|30|5', '1|textarea|description|Κείμενο|default value|30|5', '1|date|delivery|Παράδοση|3~12~2009', '1|time|delivery_time|Παράδοση|7~30|30', '1|dropdown|custom_dd|Είδος|2|Μακρύ~long~Μεσαίο~middle~Κοντό~short', '1|checkbox|mycheckbox|Είδος|1~0~1|Μακρύ~long~Μεσαίο~middle~Κοντό~short', '1|photo|avatar|Photo||100|100|300|1~80~80~1:1'));
 * 
 * @return 
 * @param string $language
 * @param int $object_id The id of the user to edit
 * @param array $fields
 */

function wk_profile($language, $object_id, $fields) {
	
	include 'languages/'.$language.'.php';

	global $current_user;
	get_currentuserinfo();
	
	//if object_id=0, then we edit our profile
	if($object_id == 0){
		$object_id = $current_user->ID;
	}
	?>
	
	<form class="submitform" action="/wp-content/plugins/wk_core/submit.php" method="post">
	
		<?php
		//include field_loop
		$object_type = 'user';
		include 'field_loop.php';
		?>
	
		<input type="hidden" name="object_id" value="<?php echo $object_id; ?>" />
		<input type="hidden" name="object_type" value="<?php echo $object_type; ?>" />
		
		<input type="submit" value="<?php echo $submit_txt; ?>" />
	</form>
	
<?php
}
?>