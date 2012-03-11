<script type="text/javascript">
	function form_submitted(){
		//replace the button with the loading pic
		jQuery("div.<?php echo $name; ?>-info div.<?php echo $name; ?>-button").replaceWith("<img class='<?php echo $name; ?>-loading' src='/wp-content/plugins/wk_core/loading.gif' alt='loading' />");
		//remove any errors
		jQuery("div.<?php echo $name; ?>-info span.<?php echo $name; ?>-error").hide();
	}
	function show_photo_info(thumb_url, photo_name, photo_url, delete_url, just_uploaded){
		//replace the loading pic with the info
		//if we just uploaded it, remove the loading img
		if(just_uploaded == 1){
			//check if we display a thumb
			<?php if($thumb){ ?>
				jQuery("div.<?php echo $name; ?>-info img.<?php echo $name; ?>-loading").replaceWith('<span class="<?php echo $name; ?>-thumb-info"><span class="photo-thumb"><img src="'+thumb_url+'" alt="<?php echo $name; ?>" /></span><span class="photo-name"><a href="'+photo_url+'" target="_blank">'+photo_name+'</a></span><span class="photo-delete"><a href="javascript:delete_this(\''+delete_url+'\');">Delete</a></span></span>');
			<?php }else{ ?>
				jQuery("div.<?php echo $name; ?>-info img.<?php echo $name; ?>-loading").replaceWith('<span class="<?php echo $name; ?>-thumb-info"><span class="photo-name"><a href="'+photo_url+'" target="_blank">'+photo_name+'</a></span><span class="photo-delete"><a href="javascript:delete_this(\''+delete_url+'\');">Delete</a></span></span>');
			<?php } ?>
		}else{
			//else remove the button
			//check if we display a thumb
			<?php if($thumb){ ?>
				jQuery("div.<?php echo $name; ?>-info div.<?php echo $name; ?>-button").replaceWith('<span class="<?php echo $name; ?>-thumb-info"><span class="photo-thumb"><img src="'+thumb_url+'" alt="<?php echo $name; ?>" /></span><span class="photo-name"><a href="'+photo_url+'" target="_blank">'+photo_name+'</a></span><span class="photo-delete"><a href="javascript:delete_this(\''+delete_url+'\');">Delete</a></span></span>');
			<?php }else{ ?>
				jQuery("div.<?php echo $name; ?>-info div.<?php echo $name; ?>-button").replaceWith('<span class="<?php echo $name; ?>-thumb-info"><span class="photo-name"><a href="'+photo_url+'" target="_blank">'+photo_name+'</a></span><span class="photo-delete"><a href="javascript:delete_this(\''+delete_url+'\');">Delete</a></span></span>');
			<?php } ?>
						
		}
		//remove the iframe
		jQuery("iframe#<?php echo $name; ?>").hide();
	}
	function show_error(message){
		//alert(message);
		jQuery("div.<?php echo $name; ?>-info img.<?php echo $name; ?>-loading").replaceWith('<span class="<?php echo $name; ?>-error">'+message+'</span><div class="<?php echo $name; ?>-button">Upload</div>')
		//reload the iframe to show the form
		window.<?php echo $name; ?>.location = "/wp-content/plugins/wk_core/types/photo_simple/photo.php?<?php echo $params; ?>";
	}
	function delete_this(delete_url){
		//delete the file and the post meta
		jQuery.post(delete_url);
		//show the button again
		jQuery("div.<?php echo $name; ?>-info span.<?php echo $name; ?>-thumb-info").replaceWith('<div class="<?php echo $name; ?>-button">Upload</div>');
		//reshow the iframe
		jQuery("iframe#avatar").show();
		//reload the iframe to show the form
		window.avatar.location = "/wp-content/plugins/wk_core/photo.php?<?php echo $params; ?>";
	}
</script>