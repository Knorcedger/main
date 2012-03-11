<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';
require $_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/wk_content_types/options.php";

$post_id = $_GET['post'];
if($post_id != ''){
	$content_type = get_post_meta($post_id, 'content_type', TRUE);
}else{
	$content_type = $_GET['type'];
}
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	//THIS IS NEEDED
	jQuery("#screen-meta").remove();
	
	/*
	var post_excerpt = jQuery("#postexcerpt");
	//move tags, delete the br that causes an empty line.
	jQuery("#tagsdiv").insertAfter(post_excerpt);
	jQuery("#tagsdiv .handlediv br").hide();
	//move categories, delete the br that causes an empty line.
	jQuery("#categorydiv").insertAfter(post_excerpt);
	jQuery("#categorydiv .handlediv br").hide();
	*/
	
	
	//find the type to execute type specific code
	address = self.location.toString();
	temp = address.split("=");
	type = temp[1];
	//if action=edit, then save the correct type (edit&post is what it saves when in edit)
	if(type == 'edit&post'){
		type = '<?php echo $content_type; ?>';
	}
	
	
	if(type == 'travel'){
		/*
		//change positions
		jQuery("#additional_box").insertAfter("#postdivrich");
		jQuery("#commentstatusdiv").insertAfter("#postdivrich");
		jQuery("#authordiv").insertAfter("#submitdiv");
		//change featured checkbox position.
		var status = jQuery("#misc-publishing-actions .misc-pub-section:first");
		jQuery("div.featured").insertBefore(status);
		jQuery("div.featured").addClass("misc-pub-section");
		//add class button to the upload buttons
		jQuery("a#photo").addClass("button");
		jQuery("a#featured_photo").addClass("button");
		*/
		//hide included
		//hide website_url, website_photo, feed_name, feed_url
		var existing_included = 10;
		var existing_not_included = 10;
		<?php
		for($i=2;$i<11;$i++){
			$inc = "included".$i;
			$not_inc = "not_included".$i;
			$temp = get_post_meta($post_id, $inc, TRUE);
			if($temp == ''){
		?>
				existing_included--;
				jQuery("p.<?php echo $inc; ?>").hide();
				//jQuery("div.<?php echo $t; ?>").hide();
				//jQuery("p.<?php echo $t; ?>").hide();
			<?php
			}
			$temp = get_post_meta($post_id, $not_inc, TRUE);
			if($temp == ''){
			?>
				existing_not_included--;
				jQuery("p.<?php echo $not_inc; ?>").hide();
			<?php
			}
		}
		?>
		var existing_additional = 5;
		<?php
		for($i=2;$i<6;$i++){
			$add = "additional".$i;
			$temp = get_post_meta($post_id, $add, TRUE);
			if($temp == ''){
		?>
				existing_additional--;
				jQuery("p.<?php echo $add; ?>").hide();
				//jQuery("div.<?php echo $t; ?>").hide();
				//jQuery("p.<?php echo $t; ?>").hide();
			<?php
			}
			/*
			$temp = get_post_meta($post_id, "not_included".$i, TRUE);
			if($temp == ''){
			?>
				existing_not_included--;
				jQuery("p.<?php echo $not_inc; ?>").hide();
			<?php
			}*/
		}
		?>
		//add "add included" button
		jQuery("<a href='javascript:void(0);' class='add add-included button'>Add</a>").insertAfter("p.included10");
		jQuery("<a href='javascript:void(0);' class='add add-not_included button'>Add</a>").insertAfter("p.not_included10");
		jQuery("<a href='javascript:void(0);' class='add add-additional button'>Add</a>").insertAfter("p.additional5");
		//function for add button
		var i = existing_included;
		//alert(i);
		jQuery(".add-included").click(function(){
			i++;
			jQuery("p.included"+i).show();
		});
		//function for add button
		var i = existing_not_included;
		//alert(i);
		jQuery(".add-not_included").click(function(){
			i++;
			jQuery("p.not_included"+i).show();
		});
		//function for add button
		var i = existing_additional;
		//alert(i);
		jQuery(".add-additional").click(function(){
			i++;
			jQuery("p.additional"+i).show();
		});
		
		//add the explanation text for the uploads
		jQuery('<span class="howto separator">Επιπλέον στοιχεία για την εκδρομή</span>').insertAfter("p.included10");
		//jQuery('<span class="howto">Μεγάλη εικόνα, δεν είναι απαραίτητη</span>').insertAfter("a#featured_photo");
		//jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic");
		//jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic_2");
		//jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic_3");
		
		//change save draft
		//jQuery("#save-action input").attr('value', "Αποθήκευση");
	}/*else if(type == 'external_new'){
		//change positions
		jQuery("#news_topic_box").insertAfter("#categorydiv");
		jQuery("#url_box").insertAfter(post_excerpt);
		jQuery("#commentstatusdiv").insertAfter("#submitdiv");
		jQuery("#authordiv").insertAfter("#submitdiv");
		//change featured checkbox position.
		var status = jQuery("#misc-publishing-actions .misc-pub-section:first");
		jQuery("div.featured").insertBefore(status);
		jQuery("div.featured").addClass("misc-pub-section");
		//add class button to the upload buttons
		jQuery("a#photo").addClass("button");
		jQuery("a#featured_photo").addClass("button");
		jQuery("div.photo").addClass("photo");
		//hide news_topic_2, news_topic_3
		//check if it is an edit, how many fields to show
		//existing is used to make the add button work correctly
		var existing = 2;
		<?php
		//if its an edit
		if($post_id != ''){
			$temp = get_post_meta($post_id, "news_topic_2", TRUE);
			if($temp == ''){ ?>
				jQuery("p.news_topic_2").hide();
				existing--;
			<?php
			}
			$temp = get_post_meta($post_id, "news_topic_3", TRUE);
			if($temp == ''){ ?>
				jQuery("p.news_topic_3").hide();
				existing--;
			<?php
			}
		}else{ ?>
			//if it is a submit
			jQuery("p.news_topic_2").hide();
			jQuery("p.news_topic_3").hide();
			existing = 0;
		<?php
		}
		?>
		//add "add website" button
		jQuery("<a href='javascript:void(0);' class='add add-topic button'>Add</a>").insertAfter("p.news_topic_3");
		//function for add button
		var i = 1 + existing;
		jQuery(".add-topic").click(function(){
			i++;
			jQuery("p.news_topic_"+i).show();
		});
		//add the explanation text
		jQuery('<span class="howto separator">Βασική εικόνα της είδησης, thumbnail κτλ.</span>').insertAfter("a#photo");
		jQuery('<span class="howto">Μεγάλη εικόνα, δεν είναι απαραίτητη</span>').insertAfter("a#featured_photo");
		jQuery('<span class="howto">Χρησιμοποιείστε το πλήρες URL της πηγής</span>').insertAfter("input#url");
		jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic");
		jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic_2");
		jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic_3");
		//change save draft
		jQuery("#save-action input").attr('value', "Αποθήκευση");
	}else if(type == 'blog'){
		//change positions
		jQuery("#news_topic_box").insertAfter("#categorydiv");
		jQuery("#commentstatusdiv").insertAfter("#submitdiv");
		jQuery("#authordiv").insertAfter("#submitdiv");
		//hide news_topic_2, news_topic_3
		//check if it is an edit, how many fields to show
		//existing is used to make the add button work correctly
		var existing = 2;
		<?php
		//if its an edit
		if($post_id != ''){
			$temp = get_post_meta($post_id, "news_topic_2", TRUE);
			if($temp == ''){ ?>
				jQuery("p.news_topic_2").hide();
				existing--;
			<?php
			}
			$temp = get_post_meta($post_id, "news_topic_3", TRUE);
			if($temp == ''){ ?>
				jQuery("p.news_topic_3").hide();
				existing--;
			<?php
			}
		}else{ ?>
			//if it is a submit
			jQuery("p.news_topic_2").hide();
			jQuery("p.news_topic_3").hide();
			existing = 0;
		<?php
		}
		?>
		//add "add website" button
		jQuery("<a href='javascript:void(0);' class='add add-topic button'>Add</a>").insertAfter("p.news_topic_3");
		//function for add button
		var i = 1 + existing;
		jQuery(".add-topic").click(function(){
			i++;
			jQuery("p.news_topic_"+i).show();
		});
		//add the explanation text
		jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic");
		jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic_2");
		jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic_3");
		//change save draft
		jQuery("#save-action input").attr('value', "Αποθήκευση");
	}else if(type == 'suggested_link'){
		//change positions
		jQuery("#news_topic_box").insertAfter("#categorydiv");
		jQuery("#url_box").insertAfter("#titlediv");
		jQuery("#url_box .handlediv br").hide();
		jQuery("#commentstatusdiv").insertAfter("#submitdiv");
		jQuery("#authordiv").insertAfter("#submitdiv");
		//hide news_topic_2, news_topic_3
		//check if it is an edit, how many fields to show
		//existing is used to make the add button work correctly
		var existing = 2;
		<?php
		//if its an edit
		if($post_id != ''){
			$temp = get_post_meta($post_id, "news_topic_2", TRUE);
			if($temp == ''){ ?>
				jQuery("p.news_topic_2").hide();
				existing--;
			<?php
			}
			$temp = get_post_meta($post_id, "news_topic_3", TRUE);
			if($temp == ''){ ?>
				jQuery("p.news_topic_3").hide();
				existing--;
			<?php
			}
		}else{ ?>
			//if it is a submit
			jQuery("p.news_topic_2").hide();
			jQuery("p.news_topic_3").hide();
			existing = 0;
		<?php
		}
		?>
		//add "add website" button
		jQuery("<a href='javascript:void(0);' class='add add-topic button'>Add</a>").insertAfter("p.news_topic_3");
		//function for add button
		var i = 1 + existing;
		jQuery(".add-topic").click(function(){
			i++;
			jQuery("p.news_topic_"+i).show();
		});
		//add explanation text
		jQuery('<span class="howto">Χρησιμοποιείστε το πλήρες URL του συνδέσμου που προτείνετε</span>').insertAfter("input#url");
		jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic");
		jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic_2");
		jQuery('<span class="howto separator">Αν το θέμα δεν εμφανιστεί καθώς πληκτρολογείτε, <a href="/wp-admin/post-new.php?type=news_topic">δημιουργείστε το πρώτα</a></span>').insertAfter("input#news_topic_3");
		//change save draft
		jQuery("#save-action input").attr('value', "Αποθήκευση");
	}else if(type == 'news_topic'){
		//add class button to the upload buttons
		jQuery("a#photo").addClass("button");
		jQuery("div.photo").addClass("photo");
		jQuery("#commentstatusdiv").insertAfter("#submitdiv");
		jQuery("#authordiv").insertAfter("#submitdiv");
		//add the explanation text
		jQuery('<span class="howto">Βασική εικόνα της είδησης, thumbnail κτλ.</span>').insertAfter("a#photo");
		jQuery('<span class="howto separator">Αν δεν συμπληρωθεί, δημιουργείτε αυτόματα</span>').insertAfter("input#twitter");
		jQuery('<span class="howto">Αν δεν συμπληρωθεί, δημιουργείτε αυτόματα</span>').insertAfter("input#sync");
		//change save draft
		jQuery("#save-action input").attr('value', "Αποθήκευση");
	}else if(type == 'topics_menu'){
		//change positions
		jQuery("#topics_box").insertAfter("#categorydiv");
	}else if(type == 'home_feeds'){
		//change positions
		jQuery("#feeds_box").insertAfter("#titlediv");
		jQuery("#feeds_box .handlediv br").hide();
		jQuery("#websites_box").insertAfter("#titlediv");
		jQuery("#websites_box .handlediv br").hide();
		//add button class and add howto
		for(i=1;i<11;i++){
			jQuery("a#website_photo"+i).addClass("button");
			jQuery("a#feed_photo"+i).addClass("button");
			jQuery('<span class="howto separator">Χρησιμοποιείστε τον τίτλο του feed, το πλήρες URL και το λογότυπο της Ιστοσελίδας-Πηγής</span>').insertAfter("a#website_photo"+i);
			jQuery('<span class="howto separator">Χρησιμοποιείστε το username που εμφανίζεται στο feed, το πλήρες URL και το avatar του χρήστη.</span>').insertAfter("a#feed_photo"+i);
		}
		//hide website_url, website_photo, feed_name, feed_url
		<?php
		for($i=2;$i<11;$i++){
			$t = "website_url".$i;
			$temp = get_post_meta($post_id, $t, TRUE);
			if($temp == ''){
		?>
				jQuery("p.website_name<?php echo $i; ?>").hide();
				jQuery("div.website_photo<?php echo $i; ?>").hide();
				jQuery("p.website_url<?php echo $i; ?>").hide();
			<?php
			}
			$temp = get_post_meta($post_id, "feed_name".$i, TRUE);
			if($temp == ''){
			?>
				jQuery("p.feed_name<?php echo $i; ?>").hide();
				jQuery("p.feed_url<?php echo $i; ?>").hide();
				jQuery("div.feed_photo<?php echo $i; ?>").hide();
			<?php
			}
		}
		?>
		//add "add website" button
		jQuery("<a href='javascript:void(0);' class='add add-website button'>Add</a>").insertAfter("div.website_photo10");
		//function for add button
		var i = 1;
		jQuery(".add-website").click(function(){
			i++;
			jQuery("div.website_photo"+i).show();
			jQuery("p.website_url"+i).show();
			jQuery("p.website_name"+i).show();
		});
		//add "add feed" button
		jQuery("<a href='javascript:void(0);' class='add add-feed button'>Add</a>").insertAfter("div.feed_photo10");
		//function for add button
		var i = 1;
		jQuery(".add-feed").click(function(){
			i++;
			jQuery("p.feed_name"+i).show();
			jQuery("p.feed_url"+i).show();
			jQuery("div.feed_photo"+i).show();
		});
	}*/
	
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
