<?php
function wk_core_date($level, $name, $translation, $default, $language, $object_id = '', $object_type = 'post'){
	if($object_type == 'post'){
		if($object_id  != '0'){
			$day = get_post_meta($object_id, $name.'_day', true);
			$month = get_post_meta($object_id, $name.'_month', true);
			$year = get_post_meta($object_id, $name.'_year', true);
		}else{
			$temp = explode('~', $default);
			$day = $temp[0];
			$month = $temp[1];
			$year = $temp[2];
		}
	}else{
		//if user display then db value, or leave empty. Dont use the default value
		$user_info = get_userdata($object_id);
		$temp = $name.'_day';
		$day = $user_info->$temp;
		$temp = $name.'_month';
		$month = $user_info->$temp;
		$temp = $name.'_year';
		$year = $user_info->$temp;
	}

	include 'languages/'.$language.'.php';
	
	if(check_user_level($level)){ ?>
		<p class="<?php echo $name; ?>">
			<?php echo $day_txt; ?>:
			<select name="<?php echo $name; ?>_day">
				<?php
				for($i=1; $i<32; $i++){ ?>
					<option value="<?php echo $i; ?>" <?php if($i == $day){echo 'selected="true"';}?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
			<?php echo $month_txt; ?>:
			<select name="<?php echo $name; ?>_month">
				<?php
				for($i=1; $i<13; $i++){ ?>
					<option value="<?php echo $i; ?>" <?php if($i == $month){echo 'selected="true"';}?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
			<?php echo $year_txt; ?>:
			<select name="<?php echo $name; ?>_year">
				<?php
				for($i=date('Y')+1; $i>1900; $i--){ ?>
					<option value="<?php echo $i; ?>" <?php if($i == $year){echo 'selected="true"';}?>><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</p>
	
	<?php
	}else{
		echo '<input type="hidden" name="'.$name.'_day" value="'.$day.'" />';
		echo '<input type="hidden" name="'.$name.'_month" value="'.$month.'" />';
		echo '<input type="hidden" name="'.$name.'_year" value="'.$year.'" />';
	}
}
?>