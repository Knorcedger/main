<?php
function wk_submit_dropdown($name, $translation, $allvalues, $post = '') {
	if($post != ''){
		$value = get_post_meta($post->ID, $name, true);
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
