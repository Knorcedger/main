<?php
include_once "../../../wp-config.php";

$username = $_POST['username'];
$password = $_POST['password'];
$remember = $_POST['remember'];
$redirect_success = $_POST['redirect_success'];
$redirect_fail = $_POST['redirect_fail'];
$account_activation = $_POST['account_activation'];

//credentials array for wp_signon
$credentials = array ('user_login'=>$username, 'user_password'=>$password, 'remember'=>$remember);
if($account_activation == 1){
	//check if user is activated
	$user_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_login = '$username' LIMIT 1");
	$user_info = get_userdata($user_ID);
	if($user_info->activated != 'no'){
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
	}else{
		$redirect = $redirect_fail;
		$status = 'activation_error';
	}
}else{
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
}

//remove status from redirect
$temp = explode('?', $redirect);
$redirect = $temp[0];

$home = get_bloginfo('home');
$location = $home . $redirect . '?status=' . $status;
header("Location: $location");

?>
