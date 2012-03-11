<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';

$object_id = $_GET['object_id'];
$object_type = $_GET['object_type'];
$name = $_GET['name'];
$photo_path = $_GET['photo_path'];

/*
//fill with the value of cell that contains the photo path
//but if object_id = 0 then means we just uploaded it, so just delete the file
if($object_id != 0){
	if($object_type == 'post'){
		$photo_path = get_post_meta($object_id, $name, true);
	}else{
		$photo_path = get_usermeta($object_id, $name);
	}
}*/

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
	//delete the post meta if object_id != 0
	if($object_id != 0){
		delete_post_meta($object_id, $name);
	}
	//delete the file
	$filename = $_SERVER['DOCUMENT_ROOT'] . $photo_path;
	if(file_exists($filename)){
		unlink($filename);
	}
	
	$referer = $_SERVER['HTTP_REFERER'];
	//remove temp_photo_path if its an edit (temp_photo_path is the last param)
	$temp = explode('&temp_photo_path', $referer);
	$location = $temp[0];
	$location .= "&temp_photo_path=";
	//remove parameters added by photo_upload.php
	$temp = explode('&status', $location);
	$location = $temp[0];
	$location .= "&status=photo_deleted";
	
	header("Location: $location");
}
?>
