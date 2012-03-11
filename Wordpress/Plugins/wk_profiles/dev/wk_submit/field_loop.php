<?php

//stores the names of vars sent to submit.php
$vars = array();

foreach ($fields as $val) {

	//seperate type and name
	$temp = explode('|', $val);
	$level = $temp[0];
	$type = $temp[1];
	$name = $temp[2];
	$translation = $temp[3];
	$default = $temp[4];

	//save names to send to form to be able to know how many vars to expect
	//add it only if level=1-5, else its added as hidden
	if(check_user_level($level)){
		//if date, add 3 values
		if ($type == 'date') {
			array_push($vars, $name.'_day', $name.'_month', $name.'_year');
		} elseif ($type == 'time') {
			array_push($vars, $name.'_hour', $name.'_minute');
		} elseif ($type == 'checkbox') {
			//save and seperate checkbox values
			$allvalues = explode('~', $temp[3]);
			//find var_names to add to vars
			$i = 0;
			foreach ($allvalues as $val) {
				if ($i%2 == 0) {
					//do nothing
				} else {
					//var names are first (before values)
					array_push($vars, $val);
				}
				$i++;
			}
		} else {
			array_push($vars, $name);
		}
	}

	if ($type == 'textfield') {
		//check if user can edit this
		if(check_user_level($level)){
			//include file
			include_once 'textfield.php';
			//save remaining vars
			$size = $temp[5];
			wk_submit_textfield($level, $name, $translation, $default, $size, $object_id, $object_type);
		}else{
			echo '<input type="hidden" name="'.$name.'" value="'.$default.'" />';
		}
	} elseif ($type == 'textarea') {
		//check if user can edit this
		if(check_user_level($level)){
			//include file
			include_once 'textarea.php';
			//save remaining vars
			$cols = $temp[5];
			$rows = $temp[6];
			wk_submit_textarea($level, $name, $translation, $default, $cols, $rows, $object_id, $object_type);
		}else{
			echo '<input type="hidden" name="'.$name.'" value="'.$default.'" />';
		}
	} elseif ($type == 'category') {
		//include file
		include_once 'category.php';
		wk_submit_category($name, $translation, $object_id, $object_type);
	} elseif ($type == 'date') {
		//check if user can edit this
		if(check_user_level($level)){
			//include file
			include_once 'date.php';
			wk_submit_date($level, $name, $translation, $default, $language, $object_id, $object_type);
		}else{
			$temp = explode('~', $default);
			$day = $temp[0];
			$month = $temp[1];
			$year = $temp[2];
			echo '<input type="hidden" name="'.$name.'_day" value="'.$day.'" />';
			echo '<input type="hidden" name="'.$name.'_month" value="'.$month.'" />';
			echo '<input type="hidden" name="'.$name.'_year" value="'.$year.'" />';
		}
	} elseif ($type == 'time') {
		//check if user can edit this
		if(check_user_level($level)){
			//include file
			include_once 'time.php';
			//save remaining vars
			$precision = $temp[5];
			wk_submit_time($level, $name, $translation, $default, $precision, $language, $object_id, $object_type);
		}else{
			echo '<input type="hidden" name="'.$name.'" value="'.$default.'" />';
		}
	} elseif ($type == 'dropdown') {
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
			if ($i%2 == 0) {
				$temp2 = $val;
			} else {
				$myvalues[$i/2] = $temp2.'|'.$val;
			}
			$i++;
		}
		wk_submit_dropdown($name, $translation, $myvalues, $object_id, $object_type);
	} elseif ($type == 'checkbox') {
		//include file
		include_once 'checkbox.php';
		//save remaining vars
		//save and seperate checkbox values
		$allvalues = explode('~', $temp[3]);
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
		wk_submit_checkbox($name, $translation, $myvalues, $object_id, $object_type);
	} elseif ($type == 'photo') {
		//save remaining vars
		$width = $temp[3];
		$height = $temp[4];
		$size = $temp[5];
		$thumb_details = explode('~', $temp[6]);
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
		if($object_type == 'post'){
			$source = '/wp-content/plugins/wk_submit/photo.php?';
		}elseif($object_type == 'user'){
			$source = '/wp-content/plugins/wk_profiles/wk_submit/photo.php?';
		}
		//save the iframe params
		$params = "name=$name&translation=$translation&width=$width&height=$height&size=$size&stylesheet=$stylesheet&object_id=$object_id&object_type=$object_type&thumb=$thumb&thumb_width=$thumb_width&thumb_height=$thumb_height&cropratio=$cropratio";
		//display the button and the iframe
		?>
		<div class="<?php echo $name; ?>-info">
			<style>
				div.<?php echo $name; ?>-button {
					background:transparent url(http://valums.com/wp-content/uploads/ajax-upload/button.png);
					color:#C7D92C;
					font-size:14px;
					height:29px;
					padding-top:15px;
					text-align:center;
					width:133px;
				}
			</style>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					//get height
					var height = jQuery("div.<?php echo $name; ?>-button").css("height");
					//remove px
					height = height.replace(/px/i, "");
					//make it a number
					height = parseInt(height);
					//get padding top
					var pt = jQuery("div.<?php echo $name; ?>-button").css("padding-top");
					//remove px
					pt = pt.replace(/px/i, "");
					//make it a number
					pt = parseInt(pt);
					//get padding bottom
					var pb = jQuery("div.<?php echo $name; ?>-button").css("padding-bottom");
					//remove px
					pb = pb.replace(/px/i, "");
					//make it a number
					pb = parseInt(pb);
					//add them
					height_all = height + pt + pb;
					//jQuery("iframe#<?php echo $name; ?>").css({"height" : height_all+"px"});
					
					//get width
					var width = jQuery("div.<?php echo $name; ?>-button").css("width");
					//remove px
					width = width.replace(/px/i, "");
					//make it a number
					width = parseInt(width);
					//get padding top
					var pl = jQuery("div.<?php echo $name; ?>-button").css("padding-left");
					//remove px
					pl = pl.replace(/px/i, "");
					//make it a number
					pl = parseInt(pl);
					//get padding bottom
					var pr = jQuery("div.<?php echo $name; ?>-button").css("padding-right");
					//remove px
					pr = pr.replace(/px/i, "");
					//make it a number
					pr = parseInt(pr);
					//add them
					width_all = width + pl + pr;
					//jQuery("iframe#<?php echo $name; ?>").css({"width" : width_all+"px"});
					
					//fix input
					jQuery("iframe#avatar .<?php echo $name; ?> input").css({"font-size" : height_all+"px"});
				});
			</script>
			<div class="<?php echo $name; ?>-button upload"><?php echo $translation; ?></div>
			<iframe id="<?php echo $name; ?>" name="<?php echo $name; ?>" frameborder="0" marginwidth="0px" marginheight="0px" scrolling="no" src ="<?php echo $source . $params; ?>" width="100%" height="100%">
			</iframe>
		</div>

		<?php
		if($object_type == 'post'){
			$base = "/wp-content/plugins/wk_submit/";
		}else{
			$base = "/wp-content/plugins/wk_profiles/wk_submit/";
		}
		?>

		<script type="text/javascript">
			function form_submitted(){
				//replace the button with the loading pic
				jQuery("div.<?php echo $name; ?>-info div.<?php echo $name; ?>-button").replaceWith("<img class='<?php echo $name; ?>-loading' src='/wp-content/plugins/wk_submit/loading.gif' alt='loading' />");
				//remove any errors
				jQuery("div.<?php echo $name; ?>-info span.<?php echo $name; ?>-error").hide();
			}
			function show_photo_info(thumb_url, photo_name, photo_url, delete_url, just_uploaded){
				//replace the loading pic with the info
				//if we just uploaded it, remove the loading img
				if(just_uploaded == 1){
					//check if we display a thumb
					<?php if($thumb){ ?>
						jQuery("div.<?php echo $name; ?>-info img.<?php echo $name; ?>-loading").replaceWith('<span class="<?php echo $name; ?>-thumb-info"><span class="photo-thumb"><img src="'+thumb_url+'" alt="<?php echo $name; ?>" /></span><span class="photo-name"><a href="'+photo_url+'" target="_blank">'+photo_name+'</a></span><span class="photo-delete"><a href="javascript:delete_this(\''+delete_url+'\');">Delete</a></span></span>');
					<?php }else{ ?>
						jQuery("div.<?php echo $name; ?>-info img.<?php echo $name; ?>-loading").replaceWith('<span class="<?php echo $name; ?>-thumb-info"><span class="photo-name"><a href="'+photo_url+'" target="_blank">'+photo_name+'</a></span><span class="photo-delete"><a href="javascript:delete_this(\''+delete_url+'\');">Delete</a></span></span>');
					<?php } ?>
				}else{
					//else remove the button
					//check if we display a thumb
					<?php if($thumb){ ?>
						jQuery("div.<?php echo $name; ?>-info div.<?php echo $name; ?>-button").replaceWith('<span class="<?php echo $name; ?>-thumb-info"><span class="photo-thumb"><img src="'+thumb_url+'" alt="<?php echo $name; ?>" /></span><span class="photo-name"><a href="'+photo_url+'" target="_blank">'+photo_name+'</a></span><span class="photo-delete"><a href="javascript:delete_this(\''+delete_url+'\');">Delete</a></span></span>');
					<?php }else{ ?>
						jQuery("div.<?php echo $name; ?>-info div.<?php echo $name; ?>-button").replaceWith('<span class="<?php echo $name; ?>-thumb-info"><span class="photo-name"><a href="'+photo_url+'" target="_blank">'+photo_name+'</a></span><span class="photo-delete"><a href="javascript:delete_this(\''+delete_url+'\');">Delete</a></span></span>');
					<?php } ?>
					
				}
				//remove the iframe
				jQuery("iframe#<?php echo $name; ?>").hide();
			}
			function show_error(message){
				//alert(message);
				jQuery("div.<?php echo $name; ?>-info img.<?php echo $name; ?>-loading").replaceWith('<span class="<?php echo $name; ?>-error">'+message+'</span><div class="<?php echo $name; ?>-button">Upload</div>')
				//reload the iframe to show the form
				window.<?php echo $name; ?>.location = "/wp-content/plugins/wk_submit/photo.php?<?php echo $params; ?>";
			}
			function delete_this(delete_url){
				//delete the file and the post meta
				jQuery.post(delete_url);
				//show the button again
				jQuery("div.<?php echo $name; ?>-info span.<?php echo $name; ?>-thumb-info").replaceWith('<div class="<?php echo $name; ?>-button">Upload</div>');
				//reshow the iframe
				jQuery("iframe#avatar").show();
				//reload the iframe to show the form
				window.avatar.location = "/wp-content/plugins/wk_submit/photo.php?<?php echo $params; ?>";
			}
		</script>
		
		<?php
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
