<?php
function wk_edit_profile_textarea($name, $translation, $cols, $rows) {
	global $current_user;
?>
<p class="<?php echo $name; ?>">
	<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
	<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="<?php echo $cols; ?>" rows="<?php echo $rows; ?>"><?php echo $current_user->$name; ?></textarea>
</p>
<?php
}
?>
