<?php
function wk_core_textarea($level, $name, $translation, $default, $cols, $rows, $object_id = '', $object_type = 'post') {
	if($object_type == 'post'){
		if($object_id != '0'){
			//check if it is the post_content, or a post meta
			if($name == 'post_content'){
				//fetch the post we are trying to edit
				$post = query_posts('p='.$object_id);
				$value = $post[0]->post_content;
			}else{
				$value = get_post_meta($object_id, $name, true);
			}
		}else{
			$value = $default;
		}
	}else{
		//if user display then db value, or leave empty. Dont use the default value
		$user_info = get_userdata($object_id);
		$value = $user_info->$name;
	}
	
	if(check_user_level($level)){ ?>
		<p class="<?php echo $name; ?>">
			<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
			<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="<?php echo $cols; ?>" rows="<?php echo $rows; ?>"><?php echo $value; ?></textarea>
		</p>
	<?php
	}else{
		echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
	}
}
?>
