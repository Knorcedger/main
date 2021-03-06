<?php
function wk_core_textfield($level, $name, $translation, $default, $size, $object_id = '', $object_type = 'post') {

	if($object_type == 'post'){
		if($object_id != 0){
			//check if it is the post_title, the tags, or a post meta
			if($name == 'post_title'){
				//fetch the post we are trying to edit
				$post = query_posts('p='.$object_id);
				$value = $post[0]->post_title;
			}elseif($name == 'tags_input'){
				$value = '';
				foreach(get_the_tags($object_id) as $tag) {
					$value .= $tag->name . ', ';
				}
				//remove trailing ,
				$value = substr($value, 0, strlen($value)-2);
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
	
	
	if(check_user_level($level)){ ?>
		<p class="<?php echo $name; ?>">
			<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
			<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value; ?>" size="<?php echo $size; ?>" />
		</p>
	<?php	
	}else{
		echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
	}
}
?>
