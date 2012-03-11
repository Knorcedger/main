<?php
function wk_submit_dropdown($name, $translation, $allvalues, $object_id = '', $object_type = 'post') {
	if($object_id != '' && $object_type == 'post'){
		$value = get_post_meta($object_id, $name, true);
	}
?>
<p class="<?php echo $name; ?>">
	<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
	<SELECT NAME="<?php echo $name; ?>">
		<?php
		foreach ($allvalues as $val) {
			$temp = explode('|', $val);
			$var_name = $temp[0];
			$var_value = $temp[1];
			?>
			<option value="<?php echo $var_value; ?>" <?php if($var_value == $value){echo 'selected="true"';}?>><?php echo $var_name; ?></option>
			<?php
		}
		?>
	</SELECT>
</p>
<?php
}
?>
