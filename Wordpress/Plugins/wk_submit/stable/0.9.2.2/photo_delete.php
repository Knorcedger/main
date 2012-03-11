<?php

include_once '../../../wp-config.php';

$next_post_id = $_GET['next_post_id'];
$name = $_GET['name'];

$filename = get_post_meta($next_post_id, $name, true);
update_post_meta($next_post_id, $name, '');
//create the appropriate filename to delete the photo
$temp = explode('/', $filename);
$mytemp = '../../uploads/' . $temp[3] . '/' . $temp[4];
$filename = $mytemp;
unlink($filename);

$referer = $_SERVER['HTTP_REFERER'];
//remove parameters added by photo_upload.php
$temp = explode('&status', $referer);
$location = $temp[0];
header("Location: $location");
?>
