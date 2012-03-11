<?php

include_once "../../../wp-config.php";

//get data
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$role = $_POST['role'];
$email_notification = $_POST['email_notification'];
$redirect_success = $_POST['redirect_success'];
$redirect_fail = $_POST['redirect_fail'];

//check what to do
if ($username != "" && $password != "" && $email != '') {
	include_once "../../../wp-includes/registration.php";
	//check if username exists
	$user_id = username_exists($username);
	//check if email exists
	$user_email = email_exists($email);
	//check if he is trying to register a not normal name
	$reserved_names = array ("wp-admin", "wp-includes", "wp-content", "top_users", "categories", "search", "help", "edit_profile", "about", "blog", "download", "mobile", "default");
	if (!in_array($username, $reserved_names)) {
		$reserved = false;
	} else {
		$reserved = true;
	}
	if (!$user_id && !$user_email && !$reserved) {
		//define user role
		//save value from db
		$prev_role = get_option('default_role');
		//add the desired role to db
		update_option('default_role', $role);
		//add the user
		$user_id = wp_create_user($username, $password, $email);
		//revert role to previous value
		update_option('default_role', $prev_role);
		//set status
		$status = "registration_success";
		//send welcome email
		if($email_notification){
			include_once 'options.php';
			wp_mail("$sendto", "$subject", "$message", "From: ".$sendername." <".$sender.">");
		}
	} else {
		$status = "registration_fail";
	}
}

//if the user was successfully registered
if ($status == 'registration_success') {
	$redirect = $redirect_success;
} else {
	$redirect = $redirect_fail;
}

$home = get_bloginfo('home');
$location = $home . $redirect . '?status=' . $status;
header("Location: $location");
?>
