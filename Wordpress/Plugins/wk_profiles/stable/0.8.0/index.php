<?php
/* 
 Plugin Name: wk_profiles
 Plugin URI: http://knorcedger.com
 Description: Adds the ability to edit a user profile. (Create the appropriate folders)
 Version: 0.8.0
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Displays the edit profile info we want (Default fields first_name, last_name, user_email, user_url, description)
 * 
 * For a photo, the params are -> type|name|width|height|size -> wk_edit_profile(array('photo|avatar|100|100|300'));
 * For a textfield, the params are -> type|name|translation|size -> wk_edit_profile(array('textfield|first_name|Όνομα|30'));
 * For a textarea, the params are -> type|name|translation|cols|rows -> wk_edit_profile(array('textarea|description|Περιγραφή|30|20'));
 * For a country, the params are -> type|name|translation -> wk_edit_profile(array('country|country|Χώρα'));
 * For a date, the params are -> type|name|translation -> wk_edit_profile(array('date|birthday|Γενεθλια'));
 * For a dropdown, the params are -> type|name|translation|var_name~var_value~var_name~var_value -> wk_edit_profile(array('dropdown|custom_dd|Είδος|Μακρύ~Long~Μεσαίο~Middle~Κοντό~Short'));
 * 
 * @return 
 * @param string $language
 * @param array $fields
 * @param int $uid The id of the user to edit
 */
function wk_profile($language, $fields, $uid = 0) {
	
	include 'languages/'.$language.'.php';

	global $current_user;
	get_currentuserinfo();

	//if uid is set, then we will edit this user and not the actual current user
	if($uid){
		wp_set_current_user($uid);
		$current_user->ID = $uid;
	}
	
	
	//stores the names of vars sent to update_profile.php
	$vars = array();
	//used to count the non photos to display the form for the rest
	$k = 0;
	//used to count the photo fields
	$l = 0;
	//find the number of fields we need to display
	$fields_size = sizeof($fields);

	foreach ($fields as $val) {
		//seperate type and name
		$temp = explode('|', $val);
		$type = $temp[0];
		$name = $temp[1];
		if ($type == 'photo') {
			//increase if photo
			$l++;
			//include file
			include_once 'photo.php';
			//save remaining vars
			$width = $temp[2];
			$height = $temp[3];
			$size = $temp[4];
			wk_edit_profile_photo($language, $name, $width, $height, $size);
		}else{
			//increase if non photo
			$k++;
			//save names to send to form to be able to know how many vars to expect
			//if date, add 3 values
			if($type == 'date'){
				array_push($vars, $name.'_day', $name.'_month', $name.'_year');
			}else{
				array_push($vars, $name);
			}
			//display the form for the rest if its the first non photo field
			if($k == 1){
			?>
				<div class="wk_edit_profile">
					<form id="profileform" action="/wp-content/plugins/wk_edit_profile/update_profile.php" method="post">
					<?php
			}
						if($type == 'textfield'){
							//include file
							include_once 'textfield.php';
							//save remaining vars
							$translation = $temp[2];
							$size = $temp[3];
							wk_edit_profile_textfield($name, $translation, $size);
						}elseif($type == 'textarea'){
							//include file
							include_once 'textarea.php';
							//save remaining vars
							$translation = $temp[2];
							$cols = $temp[3];
							$rows = $temp[4];
							wk_edit_profile_textarea($name, $translation, $cols, $rows);
						}elseif($type == 'country'){
							//include file
							include_once 'country.php';
							//save remaining vars
							$translation = $temp[2];
							wk_edit_profile_country($name, $translation);
						}elseif($type == 'date'){
							//include file
							include_once 'date.php';
							//save remaining vars
							$translation = $temp[2];
							wk_edit_profile_date($name, $translation);
						}elseif($type == 'dropdown'){
							//include file
							include_once 'dropdown.php';
							//save remaining vars
							$translation = $temp[2];
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
							wk_edit_profile_dropdown($name, $translation, $myvalues);
						}
						//if its the last field minus the photo fields
						if($k == $fields_size-$l){
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
						<input type="hidden" name="redirect" value="<?php echo get_option('home') . '/?author=' . $current_user->ID; ?>" />
						<input name="submit" type="submit" id="submit" value="<?php echo $submit_txt; ?>" />
					</form>
				</div>
		<?php
						}
		}
	}
}
?>
