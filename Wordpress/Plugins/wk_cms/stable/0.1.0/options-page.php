<?php
echo '<script type="text/javascript" src="/wp-content/plugins/wk_cms/photo_over/greybox.js"></script>';
echo '<link href="/wp-content/plugins/wk_cms/photo_over/greybox.css" rel="stylesheet" type="text/css" media="all" />';
$add = 0;
?>

<div class="wrap">
	<div id="icon-options-general" class="icon32">
		<br/>
	</div>
	<h2>Add/Edit Items</h2>
	<div id="items">
		<?php
		$cat_ids = get_all_category_ids();
		$cats_size = sizeof($cat_ids);
		
		foreach($cat_ids as $id){
			$cat = get_category($id);
			//print_r($cat);
			$temp = explode('|', $cat->category_description);
			$desc = $temp[0];
			$temp_photo_path = $temp[1];
		/*
		$options_serialized = get_option('wk_cms');
		$options = unserialize($options_serialized);
		$loops = sizeof($options)/5;
		for($i=0; $i<$loops; $i++){
		*/
		?>
			<div class="edit-item">
				<a href="javascript:void(0);" class="title open"><?php echo $cat->name; ?></a>
				<div class="item-details">
					<form id="item-details-form" action="/wp-content/plugins/wk_cms/save.php" method="post">
						<div class="title item-detail">Τίτλος</div>
						<input class="regular-text cat_name" type="text" value="<?php echo $cat->cat_name; ?>" name="cat_name" />
						<div class="slug item-detail">Slug</div>
						<input class="regular-text category_nicename" type="text" value="<?php echo $cat->category_nicename; ?>" name="category_nicename" />
						<div class="description item-detail">Περιγραφή</div>
						<textarea class="large-text category_description" cols="10" rows="3" name="category_description"><?php echo $desc; ?></textarea>
						<!--div class="photo item-detail">Εικόνα</div-->
					
						<?php
						$language = 'gr';
						$name = 'wk_cms';
						$translation = 'Εικόνα';
						//save remaining vars
						$upload_text = 'Upload';
						$edit_text = 'Edit';
						//
						$greybox_width = 400;
						$greybox_height = 150;
						//
						$width = 512;
						$height = 512;
						$size = 1000;
						$thumb_width = 80;
						$thumb_height = 80;
						$cropratio = '1:1';

						//find the params
						$params = "name=$name&translation=$translation&width=$width&height=$height&size=$size&language=$language&object_id=$object_id&object_type=$object_type&thumb=$thumb&thumb_width=$thumb_width&thumb_height=$thumb_height&cropratio=$cropratio&temp_photo_path=";

						//we add it here to able to delete it later with javascript (because we use the variable $params for the iframe each time
						//and we dont want it to have the photo path everytime, even after delete)
						$params .= $temp_photo_path;
						?>
		
		
						<script type="text/javascript">
							var GB_ANIMATION = true;
							jQuery(document).ready(function(){
								//change the button text (upload/edit)
								photo_path = '<?php echo $temp_photo_path; ?>';
								if (photo_path == '') {
									name = '<?php echo $upload_text; ?>';
								} else {
									name = '<?php echo $edit_text; ?>';
								}
								ref2 = "a#<?php echo $name; ?>-<?php echo $cat->cat_ID; ?>";
								jQuery(ref2).text(name);
								//the greybox
								jQuery("a.greybox").click(function(){
									var t = this.title || $(this).text() || this.href;
									GB_show(t,this.href,<?php echo $greybox_height; ?>,<?php echo $greybox_width; ?>);
									return false;
								});
							});
						</script>
			
						<div class="photo item-detail">
							<?php echo $translation; ?>
							<a href="/wp-content/plugins/wk_cms/photo_over/photo.php?<?php echo $params; ?>" title="<?php echo $translation; ?>" class="greybox button" id="<?php echo $name; ?>-<?php echo $cat->cat_ID; ?>"><? echo $upload_text; ?></a>
				
							<p class="<?php echo $name; ?>-<?php echo $cat->cat_ID; ?>">
								<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $temp_photo_path; ?>" />
							</p>
						</div>
			
						<script type="text/javascript">
							function add_hidden_<?php echo $name; ?>(photo_path){
								//change hidden input
								ref = "p.<?php echo $name; ?>-<?php echo $cat->cat_ID; ?> input";
								alert(photo_path);
								jQuery(ref).attr({"value": photo_path});
								//change iframe params
								ref2 = "a#<?php echo $name; ?>-<?php echo $cat->cat_ID; ?>";
								var href = "/wp-content/plugins/wk_cms/photo_over/photo.php?<?php echo $params; ?>";
								href = href + photo_path;
								jQuery(ref2).attr({"href": href});
								//change upload button to edit
								if(photo_path == '') {
									name = '<?php echo $upload_text; ?>';
								}else{
									//temp = photo_path.split("/");
									//name = temp[4];
									name = '<?php echo $edit_text; ?>';
								}
								jQuery(ref2).text(name);
							}
						</script>
					
						<input type="hidden" value="<?php echo $cat->cat_ID; ?>" name="cat_ID"/>
						<input class="button-primary" type="submit" value="Αποθήκευση" name="Submit"/>
					</form>
				</div>
			</div>
			
			
			
		<?php
		}

		if($_GET['wk_action'] == 'add' && $add == 0){
			$add++;
			$temp_photo_path = '';
		?>
			<a href="javascript:void(0);" class="title new-item open">New item</a>
			<div class="item-details">
				<form id="item-details-form" action="/wp-content/plugins/wk_cms/save.php" method="post">
					<div class="title item-detail">Τίτλος</div>
					<input class="regular-text cat_name" type="text" value="" name="cat_name" />
					<div class="slug item-detail">Slug</div>
					<input class="regular-text category_nicename" type="text" value="" name="category_nicename" />
					<div class="description item-detail">Περιγραφή</div>
					<textarea class="large-text category_description" cols="10" rows="3" name="category_description"></textarea>
					<!--div class="photo item-detail">Εικόνα</div-->
					
					<?php
					$language = 'gr';
					$name = 'wk_cms';
					$translation = 'Εικόνα';
					//save remaining vars
					$upload_text = 'Upload';
					$edit_text = 'Edit';
					//
					$greybox_width = 400;
					$greybox_height = 150;
					//
					$width = 512;
					$height = 512;
					$size = 1000;
					$thumb_width = 80;
					$thumb_height = 80;
					$cropratio = '1:1';

					//find the params
					$params = "name=$name&translation=$translation&width=$width&height=$height&size=$size&language=$language&object_id=$object_id&object_type=$object_type&thumb=$thumb&thumb_width=$thumb_width&thumb_height=$thumb_height&cropratio=$cropratio&temp_photo_path=";

					//we add it here to able to delete it later with javascript (because we use the variable $params for the iframe each time
					//and we dont want it to have the photo path everytime, even after delete)
					$params .= $temp_photo_path;
					?>
		
		
					<script type="text/javascript">
						var GB_ANIMATION = true;
						jQuery(document).ready(function(){
							//change the button text (upload/edit)
							photo_path = '<?php echo $temp_photo_path; ?>';
							if (photo_path == '') {
								name = '<?php echo $upload_text; ?>';
							} else {
								name = '<?php echo $edit_text; ?>';
							}
							ref2 = "a#<?php echo $name; ?>-0";
							jQuery(ref2).text(name);
							//the greybox
							jQuery("a.greybox").click(function(){
								var t = this.title || $(this).text() || this.href;
								GB_show(t,this.href,<?php echo $greybox_height; ?>,<?php echo $greybox_width; ?>);
								return false;
							});
						});
					</script>
			
					<div class="photo item-detail">
						<?php echo $translation; ?>
						<a href="/wp-content/plugins/wk_cms/photo_over/photo.php?<?php echo $params; ?>" title="<?php echo $translation; ?>" class="greybox button" id="<?php echo $name; ?>-0"><? echo $upload_text; ?></a>
				
						<p class="<?php echo $name; ?>-0">
							<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $temp_photo_path; ?>" />
						</p>
					</div>
			
					<script type="text/javascript">
						function add_hidden_<?php echo $name; ?>(photo_path){
							//change hidden input
							ref = "p.<?php echo $name; ?>-0 input";
							alert(photo_path);
							jQuery(ref).attr({"value": photo_path});
							//change iframe params
							ref2 = "a#<?php echo $name; ?>-0";
							var href = "/wp-content/plugins/wk_cms/photo_over/photo.php?<?php echo $params; ?>";
							href = href + photo_path;
							jQuery(ref2).attr({"href": href});
							//change upload button to edit
							if(photo_path == '') {
								name = '<?php echo $upload_text; ?>';
							}else{
								//temp = photo_path.split("/");
								//name = temp[4];
								name = '<?php echo $edit_text; ?>';
							}
							jQuery(ref2).text(name);
						}
					</script>
				
					<input type="hidden" value="0" name="cat_ID"/>
					<input class="button-primary" type="submit" value="Αποθήκευση" name="Submit"/>
				</form>
			</div>
		<?php
		}
		
		if($_GET['wk_action'] == ''){
		?>
			<div class="add-item">
				<a class="button add-item-link" href="/wp-admin/options-general.php?page=wk_cms/options-page.php&wk_action=add">Add</a>
			</div>
		<?php
		}
		?>
	</div>
</div>
