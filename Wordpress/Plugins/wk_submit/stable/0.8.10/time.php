<?php
function wk_submit_time($name, $translation, $precision, $language, $post = ''){
	//check if its submit or edit
	if($post  != ''){
		$hour = get_post_meta($post->ID, $name.'_hour', true);
		$minute = get_post_meta($post->ID, $name.'_minute', true);
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