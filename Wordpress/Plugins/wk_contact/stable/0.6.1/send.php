<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';

$sender = $_POST['email'];
$sendername = $_POST['name'];
$sendto = $_POST['sendto'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$from = $_POST['from'];
$redirect = $_POST['redirect'];

//add from value to subject
if ($from != "") {
    $subject = $subject." ($from)";
}

//send email
wp_mail("$sendto", "$subject", "$message", "From: ".$sendername." <".$sender.">");

//if redirect is empty, send where he came from
if ($redirect == '') {
    $redirect = $_SERVER['HTTP_REFERER'];
}

//if redirect has params, use &
if (strstr($redirect, '?')) {
    $char = '&';
} else {
    $char = '?';
}

$location = $redirect . $char . 'status=email_sent';
header("Location: $location");

?>
