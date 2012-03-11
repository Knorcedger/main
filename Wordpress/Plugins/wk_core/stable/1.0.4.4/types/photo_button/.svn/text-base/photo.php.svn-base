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
$object_id = $_GET['object_id'];
$object_type = $_GET['object_type'];
$thumb = $_GET['thumb'];
$thumb_width = $_GET['thumb_width'];
$thumb_height = $_GET['thumb_height'];
$cropratio =  $_GET['cropratio'];
//find the base path depanding on plugin
$base = "/wp-content/plugins/wk_core/";
/*
if($object_type == 'post'){
	$base = "/wp-content/plugins/wk_submit/";
}else{
	$base = "/wp-content/plugins/wk_profiles/wk_submit/";
}*/
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

//used to define if we work on the next post
$next_post = 0;
//check if its edit or submit by checking for object id
if($object_id == '0'){
	//and then check the type
	if($object_type == 'post'){
		//if its a post submit, save the next post id as object_id
		global $wpdb;
		$result = $wpdb->get_results("SELECT MAX( ID ) AS myid FROM $wpdb->posts");
		$last_post_id = $result[0]->myid;
		$next_post_id = $last_post_id + 1;
		$object_id = $next_post_id;
		//used to define if we work on the next post
		$next_post = 1;
	}else{
		//object_id is the correct value because it contains the user id
	}
}else{
	//object_id is the correct value because it contains the user id or the post id
}

//fill with the value of cell that contains the photo path
if($object_type == 'post'){
	$photo_path = get_post_meta($object_id, $name, true);
}else{
	$photo_path = get_usermeta($object_id, $name);
}

//check if photo exists (uploaded before, and article not submitted)
//if photo already uploaded
if($photo_path != ''){
	//and if status not empty, means we just uploaded it, else, its old, delete the photo
	if($status != ''){
		//$full_filename = get_post_meta($next_post_id, $name, true);
		$filename_array = explode('/', $photo_path);
		$filename = $filename_array[4];
		//create the thumb url
		$thumb_url = $base."image.php/".$filename."/?width=".$thumb_width."&height=".$thumb_height."&image=".$photo_path."&cropratio=".$cropratio."&nocache";
		if($status == 'photo_upload_success'){ ?>
			<script type="text/javascript">
				thumb_url = "<?php echo $thumb_url; ?>";
				photo_name = "<?php echo $filename; ?>"
				photo_url = "<?php echo $photo_path; ?>";
				delete_url = "<?php echo $base; ?>photo_delete.php?object_id=<?php echo $object_id; ?>&object_type=<?php echo $object_type; ?>&name=<?php echo $name; ?>";
				window.parent.show_photo_info(thumb_url, photo_name, photo_url, delete_url, 1);
			</script>
		<?php	
		}
		?>
	<?php
	}else{
		//delete the post meta and the file
		//but delete it only if it is a post
		if($object_type == 'post' && $next_post == 1){
			$result = $wpdb->get_results("SELECT MAX( ID ) AS myid FROM $wpdb->posts");
			$last_post_id = $result[0]->myid;
			$next_post_id = $last_post_id + 1;
			$object_id = $next_post_id;
			//save the name of the file, its definetely a post
			$filename = get_post_meta($object_id, $name, true);
			//create the appropriate filename to delete the photo
			$temp = explode('/', $filename);
			$mytemp = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/uploads/' . $temp[3] . '/' . $temp[4];
			$filename = $mytemp;
			unlink($filename);
			//delete the post meta
			delete_post_meta($object_id, $name);
			//and empty photo_path var
			$photo_path = '';
		}elseif($object_type == 'post' && $next_post == 0){
			//its a post edit
			//$full_filename = get_post_meta($next_post_id, $name, true);
			$filename_array = explode('/', $photo_path);
			$filename = $filename_array[4];
			//create the thumb url
			$thumb_url = $base."image.php/".$filename."/?width=".$thumb_width."&height=".$thumb_height."&image=".$photo_path."&cropratio=".$cropratio."&nocache";
			?>
			<script type="text/javascript">
				thumb_url = "<?php echo $thumb_url; ?>";
				photo_name = "<?php echo $filename; ?>"
				photo_url = "<?php echo $photo_path; ?>";
				delete_url = "<?php echo $base; ?>photo_delete.php?object_id=<?php echo $object_id; ?>&object_type=<?php echo $object_type; ?>&name=<?php echo $name; ?>";
				window.parent.show_photo_info(thumb_url, photo_name, photo_url, delete_url, 0);
			</script>
		<?php	
		}
	} ?>
<?php
}

//if photo_path='' then there was either an error, or we just try to upload a new photo
if($photo_path == ''){
	if($status == "photo_upload_success"){
		//already handled by the above if (if photo already uploaded)
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
	
		<form id="photoform" name="photoform" class="<?php echo $name; ?>" action="<?php echo $base; ?>photo_upload.php" method="post" enctype="multipart/form-data">
			        
			<input type="file" name="file" id="file" onchange="upload_file();" />
			
			<input type="hidden" name="object_id" value="<?php echo $object_id; ?>" />
			<input type="hidden" name="object_type" value="<?php echo $object_type; ?>" />
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