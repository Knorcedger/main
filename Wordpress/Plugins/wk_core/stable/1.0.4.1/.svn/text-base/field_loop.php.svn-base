<?php
require_once 'functions.php';
//echo check_user_level(1);
require_once 'languages/'.$language.'.php';
//

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

	//check if current user can see this or its hidden
	if(check_user_level($level)){
		$display = 1;
	}else{
		$display = 0;
	}
	//echo "dis=".$display."<br>";


	if ($type == 'textfield') {
		//save remaining vars
		$size = $temp[5];
		include_once 'types/textfield.php';
		wk_core_textfield($display, $name, $translation, $default, $size, $object_id, $object_type);
	} elseif ($type == 'textarea') {
		//save remaining vars
		$cols = $temp[5];
		$rows = $temp[6];
		include_once 'types/textarea.php';
		wk_core_textarea($display, $name, $translation, $default, $cols, $rows, $object_id, $object_type);
	} elseif ($type == 'category') {
		//include file
		include_once 'category.php';
		wk_submit_category($name, $translation, $object_id, $object_type);
	} elseif ($type == 'date') {
		include_once 'types/date.php';
		wk_core_date($display, $name, $translation, $default, $txts, $object_id, $object_type);
	} elseif ($type == 'time') {
		//save remaining vars
		$precision = $temp[5];
		include_once 'types/time.php';
		wk_core_time($display, $name, $translation, $default, $precision, $txts, $object_id, $object_type);
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
		include_once 'types/dropdown.php';
		wk_core_dropdown($display, $name, $translation, $default, $myvalues, $object_id, $object_type);
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

		include_once 'types/checkbox.php';
		wk_core_checkbox($display, $name, $translation, $default, $myvalues, $object_id, $object_type);
	} elseif ($type == 'photo_button') {
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
		}js/
		//add stylesheet url
		$stylesheet = get_bloginfo('stylesheet_url');
		//iframe source
		$base = '/wp-content/plugins/wk_core/types/photo_button/photo.php?';
		//save the iframe params
		$params = "name=$name&translation=$translation&width=$width&height=$height&size=$size&stylesheet=$stylesheet&object_id=$object_id&object_type=$object_type&thumb=$thumb&thumb_width=$thumb_width&thumb_height=$thumb_height&cropratio=$cropratio";
		//check if user can edit this
		include_once 'functions.php';
		if($display){
			//display the button and the iframe
			?>
			<div class="<?php echo $name; ?>-info">
				<?php include 'types/photo_button/photo_css.php'; ?>
				<div class="<?php echo $name; ?>-button upload"><?php echo $translation; ?></div>
				<iframe id="<?php echo $name; ?>" name="<?php echo $name; ?>" frameborder="0" marginwidth="0px" marginheight="0px" scrolling="no" src ="<?php echo $base . $params; ?>" width="100%" height="100%">
				</iframe>
			</div>

			<?php
			include 'types/photo_button/photo_js.php';
		}
	}elseif($type == 'photo_simple'){
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
		//display the iframe
		$params = "name=$name&translation=$translation&width=$width&height=$height&size=$size&stylesheet=$stylesheet&language=$language&object_id=$object_id&object_type=$object_type&thumb=$thumb&thumb_width=$thumb_width&thumb_height=$thumb_height&cropratio=$cropratio";
		?>
		<iframe name="<?php echo $name; ?>" frameborder="0" marginwidth="0px" marginheight="0px" scrolling="no" src ="/wp-content/plugins/wk_core/types/photo_simple/photo.php?<?php echo $params; ?>" width="100%" height="250px">
		</iframe>
		<p class="<?php echo $name; ?>-info">
			<input type="hidden" name="<?php echo $name; ?>" value="" />
		</p>
		<script type="text/javascript">
			function add_hidden(photo_path){
				ref = "p.<?php echo $name; ?>-info input";
				jQuery(ref).attr({
					"value": photo_path
				});
			}
		</script>
		<?php
	}elseif($type == 'photo_over'){
		//save remaining vars
		$button_text = $temp[5];
		$width = $temp[6];
		$height = $temp[7];
		$size = $temp[8];
		$thumb_details = explode('~', $temp[9]);
		$thumb = $thumb_details[0];
		if($thumb){
			$thumb_width = $thumb_details[1];
			$thumb_height = $thumb_details[2];
			$cropratio = $thumb_details[3];
		}else{
			$thumb_width = 0;
			$thumb_height = 0;
		}
		//find the params
		$params = "name=$name&translation=$translation&width=$width&height=$height&size=$size&language=$language&object_id=$object_id&object_type=$object_type&thumb=$thumb&thumb_width=$thumb_width&thumb_height=$thumb_height&cropratio=$cropratio&temp_photo_path=";
		//save temp_photo_path
		$temp_photo_path = get_post_meta($object_id, $name, TRUE);
		//we add it here to able to delete it later with javascript (because we user the var params to recreate it)
		$params .= $temp_photo_path;
		?>
		
		<script type="text/javascript" src="/wp-content/plugins/wk_core/types/photo_over/greybox.js"></script>
		<link href="/wp-content/plugins/wk_core/types/photo_over/greybox.css" rel="stylesheet" type="text/css" media="all" />
		<script type="text/javascript">
			var GB_ANIMATION = true;
			jQuery(document).ready(function(){
				jQuery("a.greybox").click(function(){
					var t = this.title || $(this).text() || this.href;
					GB_show(t,this.href,470,600);
					return false;
				});
			});
		</script>
			
		<div class="<?php echo $name; ?>">
			<?php echo $translation; ?>
			<span class="filename"></span>
			<a href="/wp-content/plugins/wk_core/types/photo_over/photo.php?<?php echo $params; ?>" title="<?php echo $translation; ?>" class="greybox" id="<?php echo $name; ?>"><? echo $button_text; ?></a>
				
			<p class="<?php echo $name; ?>-info">
				<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $temp_photo_path; ?>" />
			</p>
		</div>
			
		<script type="text/javascript">
			function add_hidden_<?php echo $name; ?>(photo_path){
				//change hidden input
				ref = "div.<?php echo $name; ?> p.<?php echo $name; ?>-info input";
				jQuery(ref).attr({"value": photo_path});
				//change iframe params
				ref2 = "a#<?php echo $name; ?>";
				var href = "/wp-content/plugins/wk_core/types/photo_over/photo.php?<?php echo $params; ?>";
				href = href + photo_path;
				jQuery(ref2).attr({"href": href});
				//display photo name
				if(photo_path == '') {
					name = '';
				}else{
					temp = photo_path.split("/");
					name = temp[4];
				}
				ref3 = "div.<?php echo $name; ?> span.filename";
				jQuery(ref3).text(name);
			}
		</script>
		
	<?php
	}elseif ($type == 'autocomplete') {
		//save remaining vars
		$size = $temp[5];
		$query = $temp[6];
		$search_field = $temp[7];
		//$query = "SELECT ID, post_title FROM wp_posts WHERE post_author = 1";
		include_once 'types/autocomplete/autocomplete.php';
		wk_core_autocomplete($display, $name, $translation, $default, $size, $query, $search_field, $object_id, $object_type);
	}
}
?>
