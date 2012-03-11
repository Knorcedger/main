<?php
include_once "../../../wp-config.php";

$username = $_POST['username'];
$password = $_POST['password'];
$remember = $_POST['remember'];
$redirect_success = $_POST['redirect_success'];
$redirect_fail = $_POST['redirect_fail'];

//credentials array for wp_signon
$credentials = array ('user_login'=>$username, 'user_password'=>$password, 'remember'=>$remember);
//login
$result = wp_signon($credentials);

//if user_login not empty, you have successfully logged in
if ($result->user_login != '') {
	$redirect = $redirect_success;
	$status = 'logged_in';
} else {
	$redirect = $redirect_fail;
	$status = 'login_error';
}

$home = get_bloginfo('home');
$location = $home . $redirect . '?status=' . $status;
header("Location: $location");

?>
