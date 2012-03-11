<?php
function wk_submit_time($name, $translation, $precision, $language, $object_id = '', $object_type = 'post'){
	//check if its submit or edit
	if($object_id  != '' && $object_type == 'post'){
		$hour = get_post_meta($object_id, $name.'_hour', true);
		$minute = get_post_meta($object_id, $name.'_minute', true);
	}elseif($object_type == 'user'){
		//then the $current_user was already checked and has the value we want
		global $current_user;
		$temp = $name.'_hour';
		$hour = $current_user->$temp;
		$temp = $name.'_minute';
		$minute = $current_user->$temp;
	}
	include 'languages/'.$language.'.php';
?>
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
<?php } ?>