<?php
function wk_edit_profile_date($name, $translation){
	global $current_user;
	get_currentuserinfo();
	$temp = $name.'_day';
	$day = $current_user->$temp;
	$temp = $name.'_month';
	$month = $current_user->$temp;
	$temp = $name.'_year';
	$year = $current_user->$temp;
?>
	<p class="<?php echo $name; ?>">
		Day:
		<select name="<?php echo $name; ?>_day">
			<?php
			for($i=1; $i<32; $i++){ ?>
				<option value="<?php echo $i; ?>" <?php if($i == $day){echo 'selected="true"';}?>><?php echo $i; ?></option>
			<?php } ?>
		</select>
		Month:
		<select name="<?php echo $name; ?>_month">
			<?php
			for($i=1; $i<13; $i++){ ?>
				<option value="<?php echo $i; ?>" <?php if($i == $month){echo 'selected="true"';}?>><?php echo $i; ?></option>
			<?php } ?>
		</select>
		Year:
		<select name="<?php echo $name; ?>_year">
			<?php
			for($i=2009; $i>1900; $i--){ ?>
				<option value="<?php echo $i; ?>" <?php if($i == $year){echo 'selected="true"';}?>><?php echo $i; ?></option>
			<?php } ?>
		</select>
	</p>
<?php } ?>