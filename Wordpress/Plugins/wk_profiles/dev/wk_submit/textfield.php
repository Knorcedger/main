<?php
function wk_submit_textfield($level, $name, $translation, $default, $size, $object_id = '', $object_type = 'post') {
	if($object_id != ''){
		if($object_type == 'post'){
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
		}elseif($object_type == 'user'){
			//then the $current_user was already checked and has the value we want
			//global $current_user;
			if($object_id != ''){
				wp_set_current_user($object_id);
			}
			$value = $current_user->$name;
		}
	}else{
		$value = $default;
	}
?>
<p class="<?php echo $name; ?>">
	<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
	<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value; ?>" size="<?php echo $size; ?>" />
</p>
<?php
}
?>
