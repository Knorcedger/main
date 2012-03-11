<?php
function wk_submit_textarea($name, $translation, $cols, $rows, $post = '') {
	if($post != ''){
		//check if it is the post_content, or a post meta
		if($name == 'post_content'){
			$value = $post->post_content;
		}else{
			$value = get_post_meta($post->ID, $name, true);
		}
	}
?>
<p class="<?php echo $name; ?>">
	<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
	<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="<?php echo $cols; ?>" rows="<?php echo $rows; ?>"><?php echo $value; ?></textarea>
</p>
<?php
}
?>
