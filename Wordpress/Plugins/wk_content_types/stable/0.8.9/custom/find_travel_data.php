<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

$object_id = $_POST['object_id'];
$date_id = $_POST['date_id'];

//if its an edit, fetch all these
if($object_id != ''){
	$date = get_post_meta($object_id, 'date'.$date_id, true);
	$seats = get_post_meta($object_id, 'date_seats'.$date_id, true);
	$date_return = get_post_meta($object_id, 'date_return'.$date_id, true);
	$seats_sold = get_post_meta($object_id, 'date_seats_sold'.$date_id, true);
	$type = get_post_meta($object_id, 'date_type'.$date_id, true);
	$on_request = get_post_meta($object_id, 'date_on_request'.$date_id, true);
	$closed = get_post_meta($object_id, 'date_closed'.$date_id, true);
	$transport = get_post_meta($object_id, 'date_transport'.$date_id, true);
	$transport_return = get_post_meta($object_id, 'date_transport_return'.$date_id, true);
}

global $wpdb;
$query = "SELECT wposts.post_title
				FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta, $wpdb->postmeta wpostmeta2
				WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id
				AND
				(
					(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'transport')
				)
				AND 
				(
					(wpostmeta2.meta_key = 'transport_type' AND wpostmeta2.meta_value = 'departure')
				)
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
				
$result = $wpdb->get_results($query);

if(sizeof($result[0]) != 0){
	$all_transport_departures = '';
	foreach ($result as $val){
		$all_transport_departures .= $val->post_title . "|";
	}
}

$query2 = "SELECT wposts.post_title
				FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta, $wpdb->postmeta wpostmeta2
				WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id
				AND
				(
					(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'transport')
				)
				AND 
				(
					(wpostmeta2.meta_key = 'transport_type' AND wpostmeta2.meta_value = 'return')
				)
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
				
$result = $wpdb->get_results($query2);

if(sizeof($result[0]) != 0){
	$all_transport_returns = '';
	foreach ($result as $val){
		$all_transport_returns .= $val->post_title . "|";
	}
}

//if its an edit, return all these
if($object_id != ''){
	echo json_encode(array("date"=>"$date", "seats"=>"$seats", "date_return"=>"$date_return", "seats_sold"=>"$seats_sold", "type"=>"$type", "on_request"=>"$on_request", "closed"=>"$closed", "transport"=>"$transport", "transport_return"=>"$transport_return", "all_transport_departures"=>"$all_transport_departures", "all_transport_returns"=>"$all_transport_returns"));
}else{
	echo json_encode(array("all_transport_departures"=>"$all_transport_departures", "all_transport_returns"=>"$all_transport_returns"));
}
?>
