<?php
function wk_core_time($level, $name, $translation, $default, $precision, $language, $object_id = '', $object_type = 'post'){
	if($object_type == 'post'){
		if($object_id != '0'){
			$hour = get_post_meta($object_id, $name.'_hour', true);
			$minute = get_post_meta($object_id, $name.'_minute', true);
		}else{
			$temp = explode('~', $default);
			$hour = $temp[0];
			$minute = $temp[1];
		}
	}else{
		//if user display then db value, or leave empty. Dont use the default value
		$user_info = get_userdata($object_id);
		$temp = $name.'_hour';
		$hour = $user_info->$temp;
		$temp = $name.'_minute';
		$minute = $user_info->$temp;
	}
	include 'languages/'.$language.'.php';
	
	if(check_user_level($level)){ ?>
		<p class="<?php echo $name; ?>">
			<?php echo $hour_txt; ?>:
			<select name="<?php echo $name;?>_hour">
				<?php
				for($i=0; $i<24; $i++){ ?>
					<option value="<?php echo $i; ?>" <?php if($i == $hour){echo 'selected="true"';}?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
			<?php echo $minute_txt; ?>:
			<select name="<?php echo $name; ?>_minute">
				<?php
				for($i=0; $i<60; $i+=$precision){ ?>
					<option value="<?php echo $i; ?>" <?php if($i == $minute){echo 'selected="true"';}?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</p>
	
	<?php
	}else{
		echo '<input type="hidden" name="'.$name.'_hour" value="'.$hour.'" />';
		echo '<input type="hidden" name="'.$name.'_minute" value="'.$minute.'" />';
	}
}
?>