<?php
function wk_core_autocomplete($display, $name, $translation, $default, $size, $query, $search_field, $limit, $match_contains, $object_id = '', $object_type = 'post') {
	//a trial to make it work with $wpdb
	/*
	//$query = 'SELECT ID, post_title FROM ' . $wpdb->posts . ' WHERE post_author = 1';
	$a = explode(" ", $query);
	foreach ($a as $val) {
		if(strstr($val, "wpdb") != ''){
			$temp = str_ireplace('$wpdb->', '', $val);
			$temp = $wpdb-> '$temp';
		}
	}*/
	
	//use the content_type query, when the query param is empty	
	global $wpdb;
	if($query == ''){
		//split search_field, because it contains the content type too
		$temp = explode('~', $search_field);
		$content_type = $temp[1];
		$search_field = $temp[0];
		//this is the query to select the content types we want
		$query = "SELECT wposts.*
				FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
				WHERE wposts.ID = wpostmeta.post_id 
				AND wpostmeta.meta_key = 'content_type' 
				AND wpostmeta.meta_value = '".$content_type."'
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC
				LIMIT $limit";
	}
	?>
	
	<script>
		jQuery(document).ready(function() {
			var data = '<?php global $wpdb; $result = $wpdb->get_results($query); foreach ($result as $val){echo $val->$search_field . "|";} ?>'.split("|");
			jQuery("#<?php echo $name; ?>").autocomplete(data<?php if($match_contains){echo ', {matchContains: true}'; ?>);    
		});
	</script>
	<?php
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
	
	
	if($display){ ?>
		<p class="<?php echo $name; ?>">
			<label for="<?php echo $name; ?>"><?php echo $translation; ?></label>
			<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo $value; ?>" size="<?php echo $size; ?>" />
		</p>
	<?php	
	}else{
		echo '<input type="hidden" name="'.$name.'" value="'.$value.'" />';
	}
}
?>
