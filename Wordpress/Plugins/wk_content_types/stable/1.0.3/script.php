<script type="text/javascript">
	jQuery(document).ready(function($) {
		//alert('yes');
		var a = jQuery("#menu-posts-article");
		a.remove();
		jQuery(a).insertBefore("#menu-posts");
		//var a = jQuery("#menu-posts-offer");
		//a.remove();
		//jQuery(a).insertBefore("#menu-posts");
		a.addClass("menu-top-first");
		<?php
		global $current_user;
		if ($current_user->ID == 1){ ?>
		jQuery("#menu-posts").removeClass("menu-top-first");
		<?php }else{ ?>
		jQuery("#menu-posts").remove();
		<?php } ?>
	})
</script>

<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';
require $_SERVER['DOCUMENT_ROOT'] . "/wp-content/plugins/wk_content_types/options.php";

$post_id = $_GET['post'];
if($post_id != ''){
	$content_type = get_post_type($post_id);
}else{
	$content_type = $_GET['post_type'];
}

//load only if we write or edit
if($content_type != ''){
?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
	
		//THIS IS NEEDED
		//jQuery("#screen-meta").remove();
		//jQuery(".postbox").addClass("postbox2");
		//jQuery(".postbox2").removeClass("postbox");

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
				//we use get post because it is inside a javascript function and executes later
				$temp = get_post_meta($_GET['post'], $inc, TRUE);
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
		
		<?php
		function field_group($field_num, $group_name, $field_names, $csss, $group_explain, $group_separator){

			$all_names = explode('|', $field_names);
			$all_csss = explode('|', $csss);
			//$all_explains = explode('|', $field_explains);
			//$all_separators = explode('|', $separators);
			
			$fields_per_group = sizeof($all_names);
			
			$existing = $field_num;
			for($i=2;$i<$field_num+1;$i++){
				$j = -1;
				$once = 1;
				foreach($all_names as $field_name){
					$j++;
					//check if the incremental value is not at the end, but indicated by a ? char
					$pos = strpos($field_name, '?');
					if(!$pos){
						$inc = $field_name.$i;
					}else{
						$inc = str_replace('?', $i, $field_name);
					}
					//we use get post because it is inside a javascript function and executes later
					$temp = get_post_meta($_GET['post'], $inc, TRUE);
					//save the first value of this group
					if($j == 0){
						$first = $temp;
					}
					//if the first value is empty, hide all the rest, else, hide none of the group
					if($first == ''){
						//reduce existing only once for each group field
						if($once == 1){
							$existing--;
							$once = 0;
						}
				?>
							jQuery("<?php echo $all_csss[$j].'.'.$inc; ?>").hide();
					<?php
					}
				}
			}
			//add button to add fields
			//check if the incremental value is not at the end, but indicated by a ? char
			$last = $all_names[$fields_per_group-1];
			$pos = strpos($last, '?');
			if(!$pos){
			?>
				jQuery("<a href='javascript:void(0);' class='add add-"+"<?php echo $group_name; ?>"+" button'>Add</a>").insertAfter('<?php echo $all_csss[$fields_per_group-1]; ?>'+'.'+'<?php echo $all_names[$fields_per_group-1]; ?>'+'<?php echo $field_num; ?>');
			<?php
			}else{
				$last = str_replace('?', $field_num, $all_names[$fields_per_group-1]);
			?>
				jQuery("<a href='javascript:void(0);' class='add add-"+"<?php echo $group_name; ?>"+" button'>Add</a>").insertAfter('<?php echo $all_csss[$fields_per_group-1]; ?>'+'.'+'<?php echo $last; ?>');
			<?php
			}
			?>

			//function for add button
			var i<?php echo $group_name; ?> = <?php echo $existing; ?>;
			jQuery(".add-"+'<?php echo $group_name; ?>').click(function(){
				i<?php echo $group_name; ?>++;
				<?php
				$counter++;
				$j = -1;
				foreach($all_names as $field_name){
					$j++;
					$pos = strpos($field_name, '?');
					if(!$pos){
				?>
						jQuery('<?php echo $all_csss[$j]; ?>'+'.'+'<?php echo $field_name; ?>'+i<?php echo $group_name; ?>).show();
				<?php
					}else{
				?>
						var t = '<?php echo $field_name; ?>';
						var temp = t.replace("?", i<?php echo $group_name; ?>);
						jQuery('<?php echo $all_csss[$j]; ?>'+'.'+temp).show();
				<?php
					}
				}
				?>

			});
			<?php
			if($group_explain != ''){
				if($group_separator == 1){
					$my_separator = 'separator';
				}else{
					$my_separator = '';
				}
				?>
				jQuery('<span class="howto <?php echo $my_separator; ?>">'+'<?php echo $group_explain; ?>'+'</span>').insertAfter('<?php echo $all_csss[$fields_per_group-1]; ?>'+'.'+'<?php echo $all_names[$fields_per_group-1]; ?>'+'<?php echo $field_num; ?>');
				<?php
			}
		}
		?>
		
		//change the add new post text
		<?php
		$l = 0;
		foreach($types as $type){
			$name = $type[0];
			if($name == $content_type){
				$ct_id = $l;
			}
			$l++;
		}
		$myname = $types[$ct_id][1];
		//check if its an add or an edit post
		if($post_id == ''){
		?>
			jQuery("#wpbody-content h2").text("<?php echo substr($myname, 0, -1); ?>");
		<?php
		}else{	
		?>
			jQuery("#wpbody-content h2").text("Επεξεργασία");
		<?php
		}
		?>
		
		
		var post_excerpt = jQuery("#postexcerpt");
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

		//for the homepage edit
		//first check if there is an temp[2] value, to not break js
		if(temp.length > 2){
			var t = temp[2];
			t = t.substring(0, 4);
			if(t == '1414'){
				//but first remove the currect form "edit"
				jQuery(".wp-submenu li a[href='edit.php']").parent("li").removeClass("current");
				jQuery(".wp-submenu li a[href='edit.php']").removeClass("current");
				jQuery(".wp-submenu li a[href='post.php?action=edit&post=1414']").parent("li").addClass("current dont-touch-me");
				jQuery(".wp-submenu li a[href='post.php?action=edit&post=1414']").addClass("current dont-touch-me");
			}
		}
		

		if(type == 'destination'){
			jQuery("#in-category-4").attr("checked", "checked");
			<?php
			field_group(10, "images", "photo_title|destination_photo", "p|div", "Φωτογραφίες του προορισμού", 1);
			field_group(10, "links", "title|link", "p|p", "Χρήσιμα links για τον προορισμό", 1);
			?>
		}else if(type == 'travel'){
			jQuery("#in-category-3").attr("checked", "checked");
			//move boxes
			jQuery("#duration_box").insertBefore("#submitdiv");
			jQuery("#destination_box").insertBefore("#submitdiv");
			jQuery("#photo_box").insertBefore("#submitdiv");
			jQuery("#additional_box").insertBefore("#submitdiv");
			jQuery("#provider_box").insertAfter("#submitdiv");
			<?php
			fields(15, "included", "p", "Στοιχεία που περιλαμβάνονται", 1);
			fields(10, "not_included", "p", "Στοιχεία που δεν περιλαμβάνονται", 1);
			fields(5, "travel_type", "p", "", 1);
			fields(5, "additional", "p", "Πρόσθετες πληροφορίες", 1);
			
			field_group(5, "hotel_additionals", "hotel|hotel_room_one|hotel_room_two|hotel_room_three|hotel_child|hotel_child_age|first_additional|first_additional_price|second_additional|second_additional_price|third_additional|third_additional_price", "p|p|p|p|p|p|p|p|p|p|p|p", "Στοιχεία για τα ξενοδοχεία", 1);
			field_group(5, "travel_additionals", "travel_additional|travel_additional_price", "p|p", "Επιπλέον για την εκδρομή", 1);
			?>
			jQuery('<span class="howto separator">Προορισμός Επιπέδου 1</span>').insertAfter("p.level1_destination");
			//jQuery('<span class="howto separator">Προορισμοί Επιπέδου 2</span>').insertAfter("p.level2_destination5");
			//change featured checkbox position.
			var status = jQuery("#misc-publishing-actions .misc-pub-section:first");
			jQuery("div.featured").insertBefore(status);
			jQuery("div.featured").addClass("misc-pub-section");
		}else if(type == 'cruise'){
			jQuery("#in-category-5").attr("checked", "checked");
			//move boxes
			jQuery("#additional_box").insertAfter(post_excerpt);
			jQuery("#not_included_box").insertAfter(post_excerpt);
			jQuery("#included_box").insertAfter(post_excerpt);
			jQuery("#prices_box").insertAfter(post_excerpt);
			<?php
			fields(10, "included", "p", "Στοιχεία που περιλαμβάνονται", 1);
			fields(10, "not_included", "p", "Στοιχεία που δεν περιλαμβάνονται", 1);
			field_group(5, "cruise_additionals", "cruise_additional|cruise_additional_price", "p|p", "Επιπλέον για τις καμπίνες", 1);
			field_group(5, "cabin_additionals", "cabin_additional|cabin_additional_price", "p|p", "Επιπλέον τύποι καμπίνας", 1);
			?>
		}else if(type == 'personal'){
			jQuery("#in-category-23").attr("checked", "checked");
			<?php
			field_group(4, "prices", "room_type|room_type?_period1|room_type?_period1_price|room_type?_period1_extra_night|room_type?_period1_food|room_type?_period2|room_type?_period2_price|room_type?_period2_extra_night|room_type?_period2_food|room_type?_period3|room_type?_period3_price|room_type?_period3_extra_night|room_type?_period3_food|room_type?_period4|room_type?_period4_price|room_type?_period4_extra_night|room_type?_period4_food", "p|p|p|p|div|p|p|p|div|p|p|p|div|p|p|p|div", "Τύποι ταξιδιού", 1);
			field_group(5, "personal_additionals", "personal_additional|personal_additional_price", "p|p", "Επιπλέον για το ατομικό ταξίδι", 1);
			fields(5, "personal_type", "p", "Στοιχεία που περιλαμβάνονται", 1);
			?>
			jQuery("#personal_additional_box").insertAfter("#postexcerpt");
			jQuery("#price_box").insertAfter("#postexcerpt");
			//price actions
			//jQuery().css("display", "none");
			//jQuery("<a href='javascript:void(0);' class='add add-room_type button'>Add</a>").insertAfter('.room_type2_period4_food');
		}else if(type == 'transport'){
			jQuery("#in-category-21").attr("checked", "checked");
		}else if(type == 'ship'){
			jQuery("#in-category-7").attr("checked", "checked");
			<?php
			fields(5, "additional", "p", "Πρόσθετες πληροφορίες", 1);
			fields(10, "photo", "div", "Φωτογραφίες του πλοίου", 1);
			?>
		}else if(type == 'hotel'){
			jQuery("#in-category-22").attr("checked", "checked");
		}else if(type == 'type'){
			jQuery("#in-category-8").attr("checked", "checked");
			//jQuery("#info_box").hide();
		}else if(type == 'provider'){
			jQuery("#in-category-6").attr("checked", "checked");
		}else if(type == 'new'){
			jQuery("#in-category-25").attr("checked", "checked");
			<?php
			fields(5, "destination", "p", "", 0);
			?>
		}else if(type == 'home'){
			jQuery("#aiosp").css("display", "none");
			<?php
			field_group(3, "photos", "photo_title|photo_link|homepage_photo", "p|p|div", "Φωτογραφίες αρχικής σελίδας", 1);
			fields(7, "popular_destination", "p", "", 0);
			field_group(5, "proposed_travels", "proposed_travel|proposed_title", "p|p", "", 0);
			field_group(8, "types", "type|type_title", "p|p", "", 0);
			field_group(10, "banners", "banner_title|banner_link|banner_photo|banner_active", "p|p|div|div", "", 0);
			?>
			jQuery("#banner_box").insertAfter("#titlediv");
		}
		
		

	});
	</script>
<?php
}
?>
