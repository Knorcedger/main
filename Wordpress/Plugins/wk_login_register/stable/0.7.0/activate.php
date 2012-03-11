<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';

$activation_hash = $_GET['hash'];

$temp = explode('|', $activation_hash);
$activation_hash = $temp[0];
$user_ID = $temp[1];

$user_info = get_userdata($user_ID);
if($activation_hash == $user_info->activation_hash){
	update_usermeta($user_ID, 'activated', 'yes');
	$status = 'activation_success';
}else{
	$status = 'activation_error';
}

$home = get_bloginfo('home');
$location = $home . '/?status=' . $status;
header("Location: $location");
?>
