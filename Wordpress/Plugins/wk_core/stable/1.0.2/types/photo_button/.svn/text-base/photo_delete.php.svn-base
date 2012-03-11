<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';

$object_id = $_GET['object_id'];
$object_type = $_GET['object_type'];
$name = $_GET['name'];

//fill with the value of cell that contains the photo path
if($object_type == 'post'){
	$photo_path = get_post_meta($object_id, $name, true);
}else{
	$photo_path = get_usermeta($object_id, $name);
}

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
	//delete the post meta
	delete_post_meta($object_id, $name);
	//create the appropriate filename to delete the photo
	$temp = explode('/', $photo_path);
	$mytemp = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/' . $temp[3] . '/' . $temp[4];
	$filename = $mytemp;
	unlink($filename);
	
	$referer = $_SERVER['HTTP_REFERER'];
	//remove parameters added by photo_upload.php
	$temp = explode('&status', $referer);
	$location = $temp[0];
	header("Location: $location");
}
?>
