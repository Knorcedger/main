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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Photo upload</title>
		<link rel="stylesheet" href="<?php echo $stylesheet; ?>" type="text/css" media="screen" />
	</head>
	<body>
		<div class="<?php echo $name; ?>">
<?php

//check if photo exists (uploaded before, and article not submitted)
//find the id of the next post
require_once('../../../wp-load.php');
//check if its edit or submit by checking for post id
if($post_id == ''){
	global $wpdb;
	$result = $wpdb->get_results("SELECT MAX( ID ) AS myid FROM $wpdb->posts");
	$last_post_id = $result[0]->myid;
	$next_post_id = $last_post_id + 1;
}else{
	$next_post_id = $post_id;
}


//if photo already uploaded
if(get_post_meta($next_post_id, $name, true) != ''){
	//and if status not empty, means we just uploaded it, else, its old, delete the photo
	if($status != ''){
		$filename = explode('/', get_post_meta($next_post_id, $name, true));
		//$filename = explode(',', $temp[4]);
		//$path = explode(',', get_post_meta($next_post_id, $name, true));
		?>
		Uploaded: <a href="<?php echo get_post_meta($next_post_id, $name, true); ?>" target="_blank"><?php echo $filename[4]; ?></a>
		<-- <a href="/wp-content/plugins/wk_submit/photo_delete.php?next_post_id=<?php echo $next_post_id; ?>&name=<?php echo $name; ?>">DELETE</a>
	<?php }else{
		//empty the cell and delete the file
		$result = $wpdb->get_results("SELECT MAX( ID ) AS myid FROM $wpdb->posts");
		$last_post_id = $result[0]->myid;
		$next_post_id = $last_post_id + 1;
		//
		$filename = get_post_meta($next_post_id, $name, true);
		update_post_meta($next_post_id, $name, '');
		//create the appropriate filename to delete the photo
		$temp = explode('/', $filename);
		$mytemp = '../../uploads/' . $temp[3] . '/' . $temp[4];
		$filename = $mytemp;
		unlink($filename);
	} ?>
<?php
}
if(get_post_meta($next_post_id, $name, true) == ''){
	if($status == "photo_upload_success"){
		//already handled by the ablove if (if photo already uploaded)
	}elseif($status == "photo_upload_error_1"){
		echo "Unknown error";
	}elseif($status == "photo_upload_error_2"){
		echo "The photo has to be smaller than $width x $height pixels";
	}elseif($status == "photo_upload_error_3"){
		echo "The photo has to be smaller than $size kb";
	}elseif($status == "photo_upload_error_4"){
		echo "The photo has to be .gif, .jpg or .png";
	}else{
	?>
	<script type="text/javascript">
		$(document).ready(function() {
			
		});
	</script>
	<form id="photoform" action="/wp-content/plugins/wk_submit/photo_upload.php" method="post" enctype="multipart/form-data">
	       
		<label for="file">
			<?php echo $translation; ?>
			<small>
				(max <?php echo $width; ?>x<?php echo $height; ?>, <?php echo $size; ?>kb)
			</small>
		</label>
		        
		<input type="file" name="file" id="file" />
		
		<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
		<input type="hidden" name="name" value="<?php echo $name; ?>" />
		<input type="hidden" name="width" value="<?php echo $width; ?>" >
		<input type="hidden" name="height" value="<?php echo $height; ?>" />
		<input type="hidden" name="size" value="<?php echo $size; ?>" />
		
		<input class="button" type="submit" name="submit" value="Upload" />
	</form>
<?php
	}
}
?>
	</div>
	</body>
</html>