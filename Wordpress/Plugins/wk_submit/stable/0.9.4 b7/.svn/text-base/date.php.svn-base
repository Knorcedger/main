<?php
function wk_submit_date($name, $translation, $language, $object_id = '', $object_type = 'post'){
	//check if its submit or edit
	if($object_id  != '' && $object_type == 'post'){
		$day = get_post_meta($object_id, $name.'_day', true);
		$month = get_post_meta($object_id, $name.'_month', true);
		$year = get_post_meta($object_id, $name.'_year', true);
	}elseif($object_type == 'user'){
		//then the $current_user was already checked and has the value we want
		global $current_user;
		$temp = $name.'_day';
		$day = $current_user->$temp;
		$temp = $name.'_month';
		$month = $current_user->$temp;
		$temp = $name.'_year';
		$year = $current_user->$temp;
	}
	include 'languages/'.$language.'.php';
?>
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
<?php } ?>