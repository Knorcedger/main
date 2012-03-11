<form id="photoform" action="/wp-content/plugins/wk_cms/photo_over/photo_upload.php" method="post" enctype="multipart/form-data">
	       
	<label for="file">
		<?php echo $translation; ?>
		<small>
			(max <?php echo $width; ?>x<?php echo $height; ?>, <?php echo $size; ?>kb)
		</small>
	</label>
			        
	<input type="file" name="file" id="file" onchange="upload_file();" />
			
	<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
	<input type="hidden" name="name" value="<?php echo $name; ?>" />
	<input type="hidden" name="width" value="<?php echo $width; ?>" >
	<input type="hidden" name="height" value="<?php echo $height; ?>" />
	<input type="hidden" name="size" value="<?php echo $size; ?>" />
		
	<input type="submit" value="Upload" />
</form>
		
<!--script type="text/javascript">
	function upload_file(){
		//window.parent.form_submitted();
		document.photoform.submit();
	}
</script-->
