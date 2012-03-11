<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';

$name = $_POST['name'];
$width = $_POST['width'];
$height = $_POST['height'];
$size = $_POST['size'];
$object_id = $_POST['object_id'];
$object_type = $_POST['object_type'];


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
					$temp = explode(".", $_FILES["file"]["name"]);
					$simple_name = $temp[0];
					if ($temp[1] == "jpeg") {
						$type = "jpg";
					}else{
						$type = $temp[1];
					}
					//$filename = $user_nicename. "." . $type[1];
					//if file exists, add a number after it
					if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $name . '/' . $_FILES["file"]["name"])) {
						//echo $_FILES["file"]["name"] . " already exists. ";
						//unlink($filename);
						for($i=2; $i<1000; $i++){
							$filename = $simple_name . '-' . $i . '.' . $type;
							if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $name . '/' . $filename)) {
								$i = 1000;
							}
						}
					}else{
						$filename = $_FILES["file"]["name"];
					}
					//echo "Stored in: " . "../../../uploads/" . $_FILES["file"]["name"];
					move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/wp-content/uploads/" . $name . "/" . $filename);
					//save user info
					//require_once ('../../../wp-config.php');
					//update_usermeta($user_id, $name, $filename);
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

//save the path to the photo
$photo_path = '/wp-content/uploads/' . $name . '/' . $filename;

//send data back to the iframe
$full_type = $_FILES["file"]["type"];
$size = $_FILES["file"]["size"];
$location = $referer . '&status=' . $status . '&filename=' . $filename. '&photo_path=' . $photo_path/* . '&type=' . $full_type . '&size=' . $size*/;
header("Location: $location");
?>
