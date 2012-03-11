<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

$destination_input = $_POST['destination_input'];
$field_id = $_POST['field_id'];
$post_id = $_POST['post_id'];


//if its an edit, fetch all these
if($post_id != ''){
	$level1_destination0 = get_post_meta($post_id, 'level1_destination0', true);
	$level1_destination1 = get_post_meta($post_id, 'level1_destination1', true);
	$level1_destination2 = get_post_meta($post_id, 'level1_destination2', true);
	$level1_destination3 = get_post_meta($post_id, 'level1_destination3', true);
	$level2_destination0 = get_post_meta($post_id, 'level2_destination0', true);
	$level2_destination1 = get_post_meta($post_id, 'level2_destination1', true);
	$level2_destination2 = get_post_meta($post_id, 'level2_destination2', true);
	$level2_destination3 = get_post_meta($post_id, 'level2_destination3', true);
	$level2_destination4 = get_post_meta($post_id, 'level2_destination4', true);
	$level3_destination0 = get_post_meta($post_id, 'level3_destination0', true);
	$level3_destination1 = get_post_meta($post_id, 'level3_destination1', true);
	$level3_destination2 = get_post_meta($post_id, 'level3_destination2', true);
	$level3_destination3 = get_post_meta($post_id, 'level3_destination3', true);
	$level3_destination4 = get_post_meta($post_id, 'level3_destination4', true);
}else{

	global $wpdb;
	$query = "SELECT wpostmeta2.meta_value
					FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta, $wpdb->postmeta wpostmeta2
					WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id
					AND
					(
						(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'destination')
					)
					AND 
					(
						(wpostmeta2.meta_key = 'level1_destination' AND wpostmeta2.meta_value != '')
						OR (wpostmeta2.meta_key = 'level2_destination' AND wpostmeta2.meta_value != '')
					)
				
					AND wposts.post_title = '".$destination_input."'
					AND wposts.post_status = 'publish' 
					AND wposts.post_type = 'post' 
					ORDER BY wposts.post_date DESC";
				
	$result = $wpdb->get_results($query);


	if(sizeof($result) != 0){
		$level1_destination = $result[0]->meta_value;
		$level2_destination = $result[1]->meta_value;
	}
}


//if its an edit, return all these
if($post_id != ''){
	echo json_encode(array("level1_destination0"=>"$level1_destination0", "level1_destination1"=>"$level1_destination1","level1_destination2"=>"$level1_destination2","level1_destination3"=>"$level1_destination3", "level1_destination4"=>"$level1_destination4", "level2_destination0"=>"$level2_destination0", "level2_destination1"=>"$level2_destination1", "level2_destination2"=>"$level2_destination2", "level2_destination3"=>"$level2_destination3", "level2_destination4"=>"$level2_destination4", "level3_destination0"=>"$level3_destination0", "level3_destination1"=>"$level3_destination1", "level3_destination2"=>"$level3_destination2", "level3_destination3"=>"$level3_destination3", "level3_destination4"=>"$level3_destination4", "destination_input"=>"$destination_input", "field_id"=>"$field_id"));
}else{
	echo json_encode(array("level1_destination"=>"$level1_destination", "level2_destination"=>"$level2_destination", "destination_input"=>"$destination_input", "field_id"=>"$field_id"));
}
?>
