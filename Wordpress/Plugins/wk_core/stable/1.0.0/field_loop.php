<?php

//stores the names of vars sent to submit.php
//$vars = array();

foreach ($fields as $val) {

	//seperate type and name
	$temp = explode('|', $val);
	$level = $temp[0];
	$type = $temp[1];
	$name = $temp[2];
	$translation = $temp[3];
	$default = $temp[4];


	if ($type == 'textfield') {
		//save remaining vars
		$size = $temp[5];
		include_once 'textfield.php';
		wk_core_textfield($level, $name, $translation, $default, $size, $object_id, $object_type);
	} elseif ($type == 'textarea') {
		//save remaining vars
		$cols = $temp[5];
		$rows = $temp[6];
		include_once 'textarea.php';
		wk_core_textarea($level, $name, $translation, $default, $cols, $rows, $object_id, $object_type);
	} elseif ($type == 'category') {
		//include file
		include_once 'category.php';
		wk_submit_category($name, $translation, $object_id, $object_type);
	} elseif ($type == 'date') {
		include_once 'date.php';
		wk_core_date($level, $name, $translation, $default, $language, $object_id, $object_type);
	} elseif ($type == 'time') {
		//save remaining vars
		$precision = $temp[5];
		include_once 'time.php';
		wk_core_time($level, $name, $translation, $default, $precision, $language, $object_id, $object_type);
	} elseif ($type == 'dropdown') {
		//save remaining vars
		//empty arrays in order for the second dd not to remember values of the first
		$allvalues = '';
		$myvalues = '';
		//save and seperate dropdown values
		$allvalues = explode('~', $temp[5]);
		//format allvalues in couples to send to function
		$i = 0;
		foreach ($allvalues as $val) {
			if ($i%2 == 0) {
				$temp2 = $val;
			} else {
				$myvalues[$i/2] = $temp2.'|'.$val;
			}
			$i++;
		}
		include_once 'dropdown.php';
		wk_core_dropdown($level, $name, $translation, $default, $myvalues, $object_id, $object_type);
	} elseif ($type == 'checkbox') {
		//save remaining vars
		//save and seperate checkbox values
		$allvalues = explode('~', $temp[5]);
		//format allvalues in couples to send to function
		$i = 0;
		foreach ($allvalues as $val) {
			if ($i%2 == 0) {
				$temp2 = $val;
			} else {
				$myvalues[$i/2] = $temp2.'|'.$val;
			}
			$i++;
		}

		include_once 'checkbox.php';
		wk_core_checkbox($level, $name, $translation, $default, $myvalues, $object_id, $object_type);
	} elseif ($type == 'photo') {
		//save remaining vars
		$width = $temp[5];
		$height = $temp[6];
		$size = $temp[7];
		$thumb_details = explode('~', $temp[8]);
		$thumb = $thumb_details[0];
		if($thumb){
			$thumb_width = $thumb_details[1];
			$thumb_height = $thumb_details[2];
			$cropratio = $thumb_details[3];
		}else{
			$thumb_width = 0;
			$thumb_height = 0;
		}
		//add stylesheet url
		$stylesheet = get_bloginfo('stylesheet_url');
		//iframe source
		$base = '/wp-content/plugins/wk_core/photo.php?';
		//save the iframe params
		$params = "name=$name&translation=$translation&width=$width&height=$height&size=$size&stylesheet=$stylesheet&object_id=$object_id&object_type=$object_type&thumb=$thumb&thumb_width=$thumb_width&thumb_height=$thumb_height&cropratio=$cropratio";
		//check if user can edit this
		if(check_user_level($level)){
			//display the button and the iframe
			?>
			<div class="<?php echo $name; ?>-info">
				<?php include 'photo_css.php'; ?>
				<div class="<?php echo $name; ?>-button upload"><?php echo $translation; ?></div>
				<iframe id="<?php echo $name; ?>" name="<?php echo $name; ?>" frameborder="0" marginwidth="0px" marginheight="0px" scrolling="no" src ="<?php echo $base . $params; ?>" width="100%" height="100%">
				</iframe>
			</div>

			<?php
			include 'photo_js.php';
		}
	}
}

function check_user_level($level){
	if($level == 5){
		if(current_user_can('read')){
			return true;
		}
	}elseif($level == 4){
		if(current_user_can('edit_posts')){
			return true;
		}
	}elseif($level == 3){
		if(current_user_can('publish_posts')){
			return true;
		}
	}elseif($level == 2){
		if(current_user_can('publish_pages')){
			return true;
		}
	}elseif($level == 1){
		if(current_user_can('import')){
			return true;
		}
	}else{
		return false;
	}
}
?>
