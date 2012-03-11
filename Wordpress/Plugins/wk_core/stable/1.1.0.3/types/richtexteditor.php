<?php
function wk_core_richtexteditor($display, $name, $translation, $default, $media_buttons, $object_id = '', $object_type = 'post') {
		
	if($object_type == 'post'){
		if($object_id != 0){
			//check if it is the post_title, the tags, or a post meta
			if($name == 'post_content'){
				//fetch the post we are trying to edit
				$post = query_posts('p='.$object_id);
				$value = $post[0]->post_title;
			}else{
				$value = get_post_meta($object_id, $name, true);
			}
		}else{
			$value = $default;
		}
	}else{
		//if user display then db value, or leave empty.
		//We dont use the default value because 1) object_id will never be 0
		//2) we dont want to fill a field that the user left empty
		$user_info = get_userdata($object_id);
		$value = $user_info->$name;
	}
	
	
	if($display){ ?>
		<p class="<?php echo $name; ?>">
			<label for="<?php echo $name; ?>"><?php echo $translation; ?></label>
			<?php the_editor($value, $name, '', $media_buttons, 0); ?>
		</p>
	<?php	
	}else{
		echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
	}
}
?>
