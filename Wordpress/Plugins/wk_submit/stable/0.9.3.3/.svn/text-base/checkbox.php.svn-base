<?php
function wk_submit_checkbox($name, $translation, $allvalues, $object_id = '', $object_type = 'post') {
	if($object_id != '' && $object_type == 'post'){
		$i = 0;
		foreach ($allvalues as $val) {
			$temp = explode('|', $val);
			$values[$i] = get_post_meta($object_id, $temp[1], true);
			$i++;
		}
	}
?>
<p class="<?php echo $name; ?>">
	<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
	<ul>
		<?php
		$i = 0;
		foreach ($allvalues as $val) {
			$temp = explode('|', $val);
			$var_name = $temp[0];
			$var_value = $temp[1];
			?>
				<li><input type="checkbox" name="<?php echo $var_value; ?>" value="<?php echo $var_value; ?>" <?php if($var_value == $values[$i]){echo 'checked="yes"';}?> /> <?php echo $var_name; ?></li>
		<?php
			$i++;
		}
		?>
	</ul>
</p>
<?php
}
?>
