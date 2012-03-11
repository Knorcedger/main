<?php

include_once '../../../wp-config.php';

$user_nicename = $_POST['user_nicename'];
$user_id = $_POST['user_id'];
$name = $_POST['name'];
$width = $_POST['width'];
$height = $_POST['height'];
$size = $_POST['size'];

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
	//http://www.w3schools.com/PHP/php_file_upload.asp
	if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/png"))) {
		if (($_FILES["file"]["size"] < $size * 1024)) {
			if ($_FILES["file"]["error"] > 0) {
				//echo "Παρουσιάστηκε άγνωστο σφάλμα";
				$status = "photo_upload_error_1";
				//header("Location: http://fun.o-some.com/edit_profile/?errorid=1");
			} else {
				$wh = getimagesize($_FILES["file"]["tmp_name"]);
				if ($wh[0] > $width || $wh[1] > $height) {
					//echo "Η φωτογραφία πρέπει να έχει διαστάσεις το πολύ 100x100 pixels";
					//header("Location: http://fun.o-some.com/edit_profile/?errorid=2");
					$status = "photo_upload_error_2";
				} else {
					//change file name to username to delete the previous picture
					//find file type
					$type = explode("/", $_FILES["file"]["type"]);
					if ($type[1] == "jpeg") {
						$type[1] = "jpg";
					}
					$filename = $user_nicename. "." . $type[1];
					if (file_exists("../../uploads/" . $name . '/' . $filename)) {
						//echo $_FILES["file"]["name"] . " already exists. ";
						unlink($filename);
					}
					//echo "Stored in: " . "../../../uploads/" . $_FILES["file"]["name"];
					move_uploaded_file($_FILES["file"]["tmp_name"], "../../uploads/" . $name . "/" . $filename);
					//save user info
					require_once ('../../../wp-config.php');
					update_usermeta($user_id, $name, $filename);
					//header("Location: http://fun.o-some.com/edit_profile");
					$status = "photo_upload_success";
				}
			}
		} else {
			//echo "Η φωτογραφία πρέπει να είναι μικρότερη από 30kb";
			//header("Location: http://fun.o-some.com/edit_profile/?errorid=3");
			$status = "photo_upload_error_3";
		}
	} else {
		//echo "Η φωτογραφία πρέπει να είναι .gif, .jpg ή png";
		//header("Location: http://fun.o-some.com/edit_profile/?errorid=4");
		$status = "photo_upload_error_4";
	}
}
//if redirect has params, use &
if (strstr($referer, '?')) {
	$char = '&';
} else {
	$char = '?';
}

$location = $referer . $char . 'status=' . $status;
header("Location: $location");
?>
