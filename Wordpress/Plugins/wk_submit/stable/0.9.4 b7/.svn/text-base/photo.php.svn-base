<?php
$name = $_GET['name'];
$translation = $_GET['translation'];
$width = $_GET['width'];
$height = $_GET['height'];
$size = $_GET['size'];
$status = $_GET['status'];
$filename = $_GET['filename'];
$type = $_GET['type'];
$stylesheet = $_GET['stylesheet'];
$post_id = $_GET['post_id'];
$thumb = $_GET['thumb'];
$thumb_width = $_GET['thumb_width'];
$thumb_height = $_GET['thumb_height'];
$cropratio =  $_GET['cropratio'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Photo upload</title>
		<link rel="stylesheet" href="<?php echo $stylesheet; ?>" type="text/css" media="screen" />
	</head>
	<body>
		<div id="<?php echo $name; ?>">
<?php

//find the id of the next post
include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
//check if its edit or submit by checking for post id
if($post_id == ''){
	global $wpdb;
	$result = $wpdb->get_results("SELECT MAX( ID ) AS myid FROM $wpdb->posts");
	$last_post_id = $result[0]->myid;
	$next_post_id = $last_post_id + 1;
}else{
	$next_post_id = $post_id;
}

//check if photo exists (uploaded before, and article not submitted)
//if photo already uploaded
if(get_post_meta($next_post_id, $name, true) != ''){
	//and if status not empty, means we just uploaded it, else, its old, delete the photo
	if($status != ''){
		$full_filename = get_post_meta($next_post_id, $name, true);
		$filename = explode('/', $full_filename);
		//create the thumb url
		$thumb_url = "/wp-content/plugins/wk_submit/image.php/".$filename[4]."/?width=".$thumb_width."&height=".$thumb_height."&image=".$full_filename."&cropratio=".$cropratio."&nocache";
		if($status == 'photo_upload_success'){ ?>
			<script type="text/javascript">
				thumb_url = "<?php echo $thumb_url; ?>";
				photo_name = "<?php echo $filename[4]; ?>"
				photo_url = "<?php echo get_post_meta($next_post_id, $name, true); ?>";
				delete_url = "/wp-content/plugins/wk_submit/photo_delete.php?next_post_id=<?php echo $next_post_id; ?>&name=<?php echo $name; ?>";
				window.parent.show_photo_info(thumb_url, photo_name, photo_url, delete_url);
			</script>
		<?php	
		}
		?>
	<?php }else{
		//delete the post meta and the file
		$result = $wpdb->get_results("SELECT MAX( ID ) AS myid FROM $wpdb->posts");
		$last_post_id = $result[0]->myid;
		$next_post_id = $last_post_id + 1;
		//save the name of the file
		$filename = get_post_meta($next_post_id, $name, true);
		//create the appropriate filename to delete the photo
		$temp = explode('/', $filename);
		$mytemp = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/' . $temp[3] . '/' . $temp[4];
		$filename = $mytemp;
		unlink($filename);
		//delete the post meta
		delete_post_meta($next_post_id, $name);
	} ?>
<?php
}
if(get_post_meta($next_post_id, $name, true) == ''){
	if($status == "photo_upload_success"){
		//already handled by the ablove if (if photo already uploaded)
	}elseif($status == "photo_upload_error_1"){ ?>
		<script type="text/javascript">window.parent.show_error("Unknown error");</script>
		<?php
		//echo "Unknown error";
	}elseif($status == "photo_upload_error_2"){ ?>
	<script type="text/javascript">window.parent.show_error("The photo has to be smaller than <?php echo $width; ?> x <?php echo $height; ?> pixels");</script>
	<?php
		//echo "The photo has to be smaller than $width x $height pixels";
	}elseif($status == "photo_upload_error_3"){ ?>
	<script type="text/javascript">window.parent.show_error("The photo has to be smaller than <?php echo $size; ?> kb");</script>
		<?php
		//echo "The photo has to be smaller than $size kb";
	}elseif($status == "photo_upload_error_4"){ ?>
	<script type="text/javascript">window.parent.show_error("The photo has to be .gif, .jpg or .png");</script>
		<?php
		//echo "The photo has to be .gif, .jpg or .png";
	}else{ ?>
		<?php //echo $translation; ?>
			<!--small>
				(max <?php echo $width; ?>x<?php echo $height; ?>, <?php echo $size; ?>kb)
			</small-->
		<?php
		
	?>
	
	<form id="photoform" name="photoform" class="<?php echo $name; ?>" action="/wp-content/plugins/wk_submit/photo_upload.php" method="post" enctype="multipart/form-data">
		        
		<input type="file" name="file" id="file" onchange="upload_file();" />
		
		<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
		<input type="hidden" name="name" value="<?php echo $name; ?>" />
		<input type="hidden" name="width" value="<?php echo $width; ?>" >
		<input type="hidden" name="height" value="<?php echo $height; ?>" />
		<input type="hidden" name="size" value="<?php echo $size; ?>" />
		

	</form>
	
	<script type="text/javascript">
		function upload_file(){
			window.parent.form_submitted();
			document.photoform.submit();
		}
	</script>
<?php
	}
}
?>
	</div>
	</body>
</html>