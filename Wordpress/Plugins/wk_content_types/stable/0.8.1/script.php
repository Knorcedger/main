<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';
require $_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/wk_content_types/options.php";

$post_id = $_GET['post'];
if($post_id != ''){
	$content_type = get_post_meta($post_id, 'content_type', TRUE);
}else{
	$content_type = $_GET['type'];
}

//load only if we write or edit
if($content_type != ''){
?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		//THIS IS NEEDED
		jQuery("#screen-meta").remove();
		jQuery(".postbox").addClass("postbox2");
		jQuery(".postbox2").removeClass("postbox");

		<?php
		function fields($field_num, $field_name, $css, $field_explain, $separator){
		?>
			var existing = '<?php echo $field_num; ?>';
			var field_num = '<?php echo $field_num; ?>';
			var field_name = '<?php echo $field_name; ?>';
			var css = '<?php echo $css; ?>';
			var field_explain = '<?php echo $field_explain; ?>';
			var separator = '<?php echo $separator; ?>';
			<?php
			$existing = $field_num;
			for($i=2;$i<$field_num+1;$i++){
				$inc = $field_name.$i;
				$temp = get_post_meta($post_id, $inc, TRUE);
				if($temp == ''){
					$existing--;
			?>
					jQuery("<?php echo $css.'.'.$inc; ?>").hide();
				<?php
				}
			}
			?>
			//add "add included" button
			jQuery("<a href='javascript:void(0);' class='add add-"+"<?php echo $field_name; ?>"+" button'>Add</a>").insertAfter('<?php echo $css; ?>'+'.'+'<?php echo $field_name; ?>'+'<?php echo $field_num; ?>');
			//function for add button
			var i<?php echo $field_name; ?> = <?php echo $existing; ?>;
			jQuery(".add-"+'<?php echo $field_name; ?>').click(function(){
				i<?php echo $field_name; ?>++;
				jQuery('<?php echo $css; ?>'+'.'+'<?php echo $field_name; ?>'+i<?php echo $field_name; ?>).show();
			});
			<?php
			//add the explanation text for the uploads
			if($field_explain != ''){
				if($separator == 1){
					$separator = 'separator';
				}else{
					$separator = '';
				}
			?>
				jQuery('<span class="howto <?php echo $separator; ?>">'+'<?php echo $field_explain; ?>'+'</span>').insertAfter('<?php echo $css; ?>'+'.'+'<?php echo $field_name; ?>'+'<?php echo $field_num; ?>');
			<?php
			}
		}
		?>
	
		//find the type to execute type specific code
		address = self.location.toString();
		temp = address.split("=");
		type = temp[1];
		//if action=edit, then save the correct type (edit&post is what it saves when in edit)
		if(type == 'edit&post'){
			type = '<?php echo $content_type; ?>';
		}
		
		
		var post_excerpt = jQuery("#postexcerpt");
		

		if(type == 'destination'){
			jQuery("#in-category-4").attr("checked", "yes");
			<?php
			fields(5, "additional", "p", "Επιπλέον πληροφορίες", 1);
			fields(10, "link", "p", "Χρήσιμα links για τον προορισμό", 1);
			?>
		}else if(type == 'travel'){
			jQuery("#in-category-3").attr("checked", "yes");
			//move boxes
			jQuery("#additional_box").insertAfter(post_excerpt);
			jQuery("#not_included_box").insertAfter(post_excerpt);
			jQuery("#included_box").insertAfter(post_excerpt);
			jQuery("#prices_box").insertAfter(post_excerpt);
			<?php
			fields(10, "included", "p", "Στοιχεία που περιλαμβάνονται", 1);
			fields(10, "not_included", "p", "Στοιχεία που δεν περιλαμβάνονται", 1);
			fields(5, "additional", "p", "Πρόσθετες πληροφορίες", 1);
			?>
		}else if(type == 'cruise'){
			jQuery("#in-category-5").attr("checked", "yes");
			//move boxes
			jQuery("#additional_box").insertAfter(post_excerpt);
			jQuery("#not_included_box").insertAfter(post_excerpt);
			jQuery("#included_box").insertAfter(post_excerpt);
			jQuery("#prices_box").insertAfter(post_excerpt);
			<?php
			fields(10, "included", "p", "Στοιχεία που περιλαμβάνονται", 1);
			fields(10, "not_included", "p", "Στοιχεία που δεν περιλαμβάνονται", 1);
			?>
		}else if(type == 'ship'){
			jQuery("#in-category-7").attr("checked", "yes");
			<?php
			fields(5, "additional", "p", "Πρόσθετες πληροφορίες", 1);
			fields(10, "photo", "div", "Φωτογραφίες του πλοίου", 1);
			?>
		}else if(type == 'type'){
			jQuery("#in-category-8").attr("checked", "yes");
		}else if(type == 'provider'){
			jQuery("#in-category-6").attr("checked", "yes");
		}
			
	
		<?php
	
		//THIS IS NEEDED
		//if type of the entry
		//find the id of this post type (την σειρά δηλαδή με την οποία είναι στο options)
		for ($i = 0; $i < sizeof($names); $i++) {
			if($names[$i] == $content_type){
				$type_id = $i;
				break;
			}
		}
	
		//hide the fields
		$fields2hide = explode('|', $hide[$type_id]);
		foreach ($fields2hide as $fieldname) {
		?>
			jQuery("#<?php echo $fieldname; ?>").remove();
		<?php
		}
		?>
		
		
		
		
		
		

	});
	</script>
<?php
}
?>
