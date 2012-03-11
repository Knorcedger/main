<?php
$post_id = $_GET['post'];
$type = get_post_meta($post_id, 'content_type', TRUE);
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	var post_content = jQuery("#postdivrich");
	//move tags, delete the br that causes an empty line.
	jQuery("#tagsdiv").insertAfter(post_content);
	jQuery("#tagsdiv .handlediv br").hide();
	//move categories, delete the br that causes an empty line.
	jQuery("#categorydiv").insertAfter(post_content);
	jQuery("#categorydiv .handlediv br").hide();
	
	//find the type to execute type specific code
	address = self.location.toString();
	temp = address.split("=");
	type = temp[1];
	//if action=edit, then save the correct type (edit&post is what it saves when in edit)
	if(type == 'edit&post'){
		type = '<?php echo $type; ?>';
	}


	if(type == 'new'){
		//change featured checkbox position.
		var status = jQuery("#misc-publishing-actions .misc-pub-section:first");
		jQuery("div.featured").insertBefore(status);
		jQuery("div.featured").addClass("misc-pub-section");
		//add class button to the upload buttons
		jQuery("a#new_photo").addClass("button");
		jQuery("a#new_featured_photo").addClass("button");
		//add the explanation text for the uploads
		jQuery('<span class="howto separator">Main article image, thumbnail etc.</span>').insertAfter("a#new_photo");
		jQuery('<span class="howto separator">Featured article image, not required</span>').insertAfter("a#new_featured_photo");
	}else if(type == 'external-new'){
		//add class button to the upload buttons
		jQuery("a#external_new_photo").addClass("button");
		jQuery("div.external_new_photo").addClass("new_photo");
		//add the explanation text
		jQuery('<span class="howto">Main article image, thumbnail etc.</span>').insertAfter("a#external_new_photo");
		jQuery('<span class="howto">Use the full article url</span>').insertAfter("input#external_new_url");
	}else if(type == 'review'){
		//add button class
		for(i=1;i<21;i++){
			jQuery("a#review_photo"+i).addClass("button");
		}
		//add new_photo class
		for(i=1;i<21;i++){
			jQuery("div.review_photo"+i).addClass("new_photo");
		}
		//hide buttons
		for(i=2;i<21;i++){
			jQuery("div.review_photo"+i).hide();
		}
		
		//add the explanation text
		
		//add "add photo" button
		jQuery("<a href='javascript:void(0);' class='add button'>Add</a>").insertAfter("div.review_photo10");
		//function for add button
		var i = 1;
		jQuery(".add").click(function(){
			i++;
			jQuery("div.review_photo"+i).show();
		});
		jQuery('<span class="howto separator">Press Add for more pictures</span>').insertAfter("div.review_photo10");
		jQuery('<span class="howto">If company doesn\'t appear, create it first</span>').insertAfter("input#review_company");
		//change featured checkbox position.
		var status = jQuery("#misc-publishing-actions .misc-pub-section:first");
		jQuery("div.featured").insertBefore(status);
		jQuery("div.featured").addClass("misc-pub-section");
	}else if(type == 'event'){
		//add the explanation text
		jQuery('<span class="howto">eg. Αδριανουπόλεως</span>').insertAfter("input#address");
		jQuery('<span class="howto">eg. 22 or 22Α</span>').insertAfter("input#address_number");
		jQuery('<span class="howto">eg. Χαλάνδρι, Αθήνα</span>').insertAfter("input#city");
		jQuery('<span class="howto">eg. Αίθουσα Συνεδρίων Hilton</span>').insertAfter("input#general");
		jQuery('<span class="howto">Date Format: Day/Month/Year</span>').insertAfter("p.date_single");
		jQuery('<span class="howto">If company doesnt appear, create it first</span>').insertAfter("input#event_company");
	}else if(type == 'company'){
		jQuery("a#company_photo").addClass("button");
		jQuery("div.company_photo").addClass("new_photo");
		jQuery('<span class="howto">Main article image, thumbnail etc.</span>').insertAfter("a#company_photo");
	}else if(type == 'business-new'){
		jQuery("a#business_new_photo").addClass("button");
		jQuery("div.business_new_photo").addClass("new_photo");
		jQuery('<span class="howto">Main article image, thumbnail etc.</span>').insertAfter("a#business_new_photo");
		jQuery('<span class="howto">If company doesnt appear, create it first</span>').insertAfter("input#business_new_company");
	}
	

});
</script>