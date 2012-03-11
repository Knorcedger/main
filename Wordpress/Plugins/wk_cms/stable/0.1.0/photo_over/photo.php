<?php
$name = $_GET['name'];
$translation = $_GET['translation'];
$width = $_GET['width'];
$height = $_GET['height'];
$size = $_GET['size'];
$status = $_GET['status'];
$filename = $_GET['filename'];
$type = $_GET['type'];
$language = $_GET['language'];
$object_id = $_GET['object_id'];
$object_type = $_GET['object_type'];
$thumb = $_GET['thumb'];
$thumb_width = $_GET['thumb_width'];
$thumb_height = $_GET['thumb_height'];
$cropratio =  $_GET['cropratio'];
$temp_photo_path =  $_GET['temp_photo_path'];
//set base
$base = "/wp-content/plugins/wk_cms/";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Photo upload</title>
		<link rel="stylesheet" href="/wp-content/plugins/wk_cms/photo_over/style.css" type="text/css" media="screen" />
	</head>
	<body>
		<div class="<?php echo $name; ?> iframe_image">
<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_cms/languages/' . $language . '.php';

//we delete the hidden input here because we cant add it in
//photo_delete.php because it is not an html file, but has pure php
if($status == 'photo_deleted'){
	//empty temp_photo_path becaseu its already filled by the get above
	$temp_photo_path = '';
	?>
	<script type="text/javascript">
		photo_path = "";
		window.parent.add_hidden_<?php echo $name; ?>(photo_path);
	</script>
<?php
}


//if we just uploaded it OR we uploaded it, closed the greybox and just reopened it
if($status == "photo_upload_success" || $temp_photo_path != ''){
	//display the thumb
	//first get filename, photo_path
	if($temp_photo_path != ''){
		$photo_path = $temp_photo_path;
		//and extract the filename
		$filename_array = explode('/', $photo_path);
		$filename = $filename_array[4];
	}else{
		$filename = $_GET['filename'];
		$photo_path = $_GET['photo_path'];
	}
	//create the thumb url
	$thumb_url = $base."image.php/".$filename."/?width=".$thumb_width."&height=".$thumb_height."&image=".$photo_path."&cropratio=".$cropratio."&nocache";
	$delete_url = $base . 'photo_over/photo_delete.php?object_id=' . $object_id . '&object_type=' . $object_type . '&name=' . $name . '&photo_path=' . $photo_path;
	//check if we need to display a thumb or not
	if($thumb){
		echo '<span class="' . $name . '-thumb-info"><span class="photo-thumb"><img src="' . $thumb_url . '" alt="' . $name . '" /></span><span class="photo-name"><a href="' . $photo_path . '" target="_blank">' . $filename . '</a></span><span class="photo-delete"><a href="' . $delete_url . '">Delete</a></span></span>';
	}else{
		echo '<span class="' . $name . '-thumb-info"><span class="photo-name"><a href="' . $photo_path . '" target="_blank">' . $filename . '</a></span><span class="photo-delete"><a href="' . $delete_url . '">Delete</a></span></span>';
	}
	//sent the hidden input to parent if we just uploaded it
	if($status == 'photo_upload_success'){
	?>
		<script type="text/javascript">
			photo_path = "<?php echo $photo_path; ?>";
			window.parent.add_hidden_<?php echo $name; ?>(photo_path);
		</script>
<?php
	}
}elseif($status == "photo_upload_error_1"){
	echo "Unknown error";
}elseif($status == "photo_upload_error_2"){
	echo "The photo has to be smaller than $width x $height pixels";
}elseif($status == "photo_upload_error_3"){
	echo "The photo has to be smaller than $size kb";
}elseif($status == "photo_upload_error_4"){
	echo "The photo has to be .gif, .jpg or .png";
}else{
	//if either status=photo_deleted or we just display the form
	if($status == 'photo_deleted'){
		//display the form
		include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_cms/photo_over/photo_form.php';
	?>
		<!--script type="text/javascript">
			photo_path = "";
			window.parent.add_hidden(photo_path);
		</script-->
		<?php
	}elseif($status == ''){
		if($object_id != 0){
			//also check if it is a user or a post
			if($object_type == 'post'){
				$photo_path = get_post_meta($object_id, $name, TRUE);
			}else{
				$photo_path = get_usermeta($object_id, $name);
			}
			//and extract the filename
			$filename_array = explode('/', $photo_path);
			$filename = $filename_array[4];
			//check if there is a photo to display, or show the form
			if($photo_path != ''){
				//display the thumb	
				//create the thumb url
				$thumb_url = $base."image.php/".$filename."/?width=".$thumb_width."&height=".$thumb_height."&image=".$photo_path."&cropratio=".$cropratio."&nocache";
				$delete_url = $base . 'photo_over/photo_delete.php?object_id=' . $object_id . '&object_type=' . $object_type . '&name=' . $name . '&photo_path=' . $photo_path;
				//check if we need to display a thumb or not
				if($thumb){
					echo '<span class="' . $name . '-thumb-info"><span class="photo-thumb"><img src="' . $thumb_url . '" alt="' . $name . '" /></span><span class="photo-name"><a href="' . $photo_path . '" target="_blank">' . $filename . '</a></span><span class="photo-delete"><a href="' . $delete_url . '">Delete</a></span></span>';
				}else{
					echo '<span class="' . $name . '-thumb-info"><span class="photo-name"><a href="' . $photo_path . '" target="_blank">' . $filename . '</a></span><span class="photo-delete"><a href="' . $delete_url . '">Delete</a></span></span>';
				}
				//sent the hidden input to parent
				?>
				<script type="text/javascript">
					photo_path = "<?php echo $_GET['photo_path']; ?>";
					window.parent.add_hidden_<?php echo $name; ?>(photo_path);
				</script>
			<?php
			}else{
				//display the form
				include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_cms/photo_over/photo_form.php';
			}
		}else{
			//display the form
			include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_cms/photo_over/photo_form.php';
		}
	}
?>

	
	
<?php
}
?>



	</div>
	</body>
</html>

<?php

?>
