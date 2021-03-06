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
$account_activation = $_POST['account_activation'];

//check what to do
if ($username != "" && $password != "" && $email != '') {
	include_once "../../../wp-includes/registration.php";
	//check if username exists
	$user_ID = username_exists($username);
	//check if email exists
	$user_email = email_exists($email);
	//check if he is trying to register a not normal name
	$reserved_names = array ("wp-admin", "wp-includes", "wp-content", "top_users", "categories", "search", "help", "edit_profile", "about", "blog", "download", "mobile", "default");
	if (!in_array($username, $reserved_names)) {
		$reserved = false;
	} else {
		$reserved = true;
	}
	if (!$user_ID && !$user_email && !$reserved) {
		//define user role
		//save value from db
		$prev_role = get_option('default_role');
		//add the desired role to db
		update_option('default_role', $role);
		//add the user
		wp_create_user($username, $password, $email);
		//revert role to previous value
		update_option('default_role', $prev_role);
		//check for account activation
		$user_ID = $wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_login = '$username' LIMIT 1");
		if($account_activation == '1'){
			update_usermeta($user_ID, 'activated', 'no');
			$activation_hash = substr(md5(uniqid(microtime())), 0, 6);
			update_usermeta($user_ID, 'activation_hash', $activation_hash);
			$activation_link = get_bloginfo('home') . '/wp-content/plugins/wk_login_register/activate.php?hash=' . $activation_hash . '|' . $user_ID;
		}
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
//remove status from redirect
$temp = explode('?', $redirect);
$redirect = $temp[0];

$home = get_bloginfo('home');
$location = $home . $redirect . '?status=' . $status;
header("Location: $location");
?>
