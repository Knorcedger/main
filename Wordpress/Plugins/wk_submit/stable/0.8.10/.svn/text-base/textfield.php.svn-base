<?php
function wk_submit_textfield($name, $translation, $size, $post = '') {
	if($post != ''){
		//check if it is the post_title, the tags, or a post meta
		if($name == 'post_title'){
			$value = $post->post_title;
		}elseif($name == 'tags_input'){
			$value = '';
			foreach(get_the_tags($post->ID) as $tag) {
				$value .= $tag->name . ', ';
			}
			//remove trailing ,
			$value = substr($value, 0, strlen($value)-2);
		}else{
			$value = get_post_meta($post->ID, $name, true);
		}
	}
?>
<p class="<?php echo $name; ?>">
	<label for="<?php echo $name; ?>"><?php echo $translation; ?>: </label>
	<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value; ?>" size="<?php echo $sise; ?>" />
</p>
<?php
}
?>
