<?php
include_once '../../../wp-config.php';

$user_id = $_POST['user_id'];
$redirect = $_POST['redirect'];

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

//value to save all birthday values
$birthday = '';

if ($url == $correct_referer) {
	foreach ($vars as $val) {
		//add data to usermeta
		update_usermeta($user_id, $val, $_POST[$val]);
	}
	//if redirect has params, use &
	if (strstr($redirect, '?')) {
		$char = '&';
	} else {
		$char = '?';
	}
	$location = $redirect . $char . 'status=profile_updated';
	header("Location: $location");
}
?>