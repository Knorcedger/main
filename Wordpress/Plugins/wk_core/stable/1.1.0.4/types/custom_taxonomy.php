<?php
function wk_core_custom_taxonomy($display, $name, $translation, $default, $hierarchical, $object_id = '', $object_type = 'post') {
		
	if($display){
		add_action( 'init', 'custom_taxonomies', 0 );
	}else{
		echo '';
	}
}
function custom_taxonomies() {
	register_taxonomy( 'version', 'post', array( 'hierarchical' => false, 'label' => 'Version', 'query_var' => true, 'rewrite' => true ) );
}
?>
