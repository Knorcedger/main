<?php
include_once '../../../wp-config.php';

//user_id and post_status and post_id are always sent as hidden values
$user_id = $_POST['user_id'];
$post_status = $_POST['post_status'];
$post_id = $_POST['post_id'];

//those are the names of all the values we sent
$vars_send = $_POST['vars_send'];
$vars = explode('|', $vars_send);

//find the url of the current referer
$referer = $_SERVER['HTTP_REFERER'];
$end = strpos($referer, "/", 9);
if ($end != "") {
	$url = substr($referer, 0, $end);
} else {
	$url = $referer;
}
//find the correct referer
$correct_referer = get_option('home');

if ($url == $correct_referer) {
	// Create post object
	$mypost = array();
	$mypost['ID'] = $post_id;
	$mypost['post_status'] = $post_status;
	$mypost['post_author'] = $user_id;
	//
	foreach ($vars as $val) {
		if($val == 'post_title'){
			$mypost['post_title'] = $_POST[$val];
		}elseif($val == 'post_content'){
			$mypost['post_content'] = $_POST[$val];
		}elseif($val == 'post_category'){
			$mypost['post_category'] = array($_POST[$val]);
		}elseif($val == 'tags_input'){
			$mypost['tags_input'] = $_POST[$val];
		}
	}
	//insert post
	$result = wp_update_post( $mypost );
	if($result != 0){
		//add remaining fields here, because we need the post id
		foreach ($vars as $val) {
			if($val != 'post_title' && $val != 'post_content' && $val != 'post_category' && $val != 'tags_input'){
				update_post_meta($result, $val, $_POST[$val]);
			}
		}
		//redirect
		header("Location: $correct_referer/?p=$result&status=edit_success");
	}else{
		header("Location: $correct_referer?status=edit_error");
	}
}
?>