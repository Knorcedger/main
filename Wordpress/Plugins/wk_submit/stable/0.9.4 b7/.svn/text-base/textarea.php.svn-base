<?php
function wk_submit_textarea($name, $translation, $cols, $rows, $object_id = '', $object_type = 'post') {
	if($object_id != '' && $object_type == 'post'){
		//check if it is the post_content, or a post meta
		if($name == 'post_content'){
			//fetch the post we are trying to edit
			$post = query_posts('p='.$object_id);
			$value = $post[0]->post_content;
		}else{
			$value = get_post_meta($object_id, $name, true);
		}
	}elseif($object_type == 'user'){
		//then the $current_user was already checked and has the value we want
		global $current_user;
		$value = $current_user->$name;
	}
?>
<p class="<?php echo $name; ?>">
	<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
	<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="<?php echo $cols; ?>" rows="<?php echo $rows; ?>"><?php echo $value; ?></textarea>
</p>
<?php
}
?>
