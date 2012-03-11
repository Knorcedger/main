<?php
/**
 * Displays fields to edit your user profile
 * 
 * @return 
 * @param string $language
 * @param string $name
 * @param int $width
 * @param int $height
 * @param int $size
 */
function wk_edit_profile_photo($language, $name, $width, $height, $size) {
	
	include 'languages/'.$language.'.php';

	global $current_user;
	get_currentuserinfo();
?>
<div class="wk_edit_profile_photo">
    <form id="photoform" action="/wp-content/plugins/wk_edit_profile/upload_photo.php" method="post" enctype="multipart/form-data">
        
        <label for="file">
            <?php echo $photo_txt; ?>
            <small>
                (max 
                <?php
                echo $width.'x'.$height.', '.$size.'kb)';
                ?>
            </small>
        </label>
        
        <input type="file" name="file" id="file" />

		<input type="hidden" name="user_nicename" value="<?php echo $current_user->user_nicename; ?>" />
		<input type="hidden" name="user_id" value="<?php echo $current_user->ID; ?>" />
		<input type="hidden" name="name" value="<?php echo $name; ?>" />
		<input type="hidden" name="width" value="<?php echo $width; ?>" >
		<input type="hidden" name="height" value="<?php echo $height; ?>" />
		<input type="hidden" name="size" value="<?php echo $size; ?>" />
		
        <input type="submit" name="submit" value="<?php echo $upload_txt; ?>" />
    </form>
    <div class="curpicture">
        <label for="curpicture">
            <?php echo $your_photo_txt; ?>
        </label>
        <br/>
        <br/>
        <?php
        $pic = get_usermeta($current_user->ID, $name);
        if ($pic == "") {
        	$pic = "/wp-content/uploads/" . $name . "/default.png";
        } else {
        	$pic = "/wp-content/uploads/" . $name . "/" . $pic . "?=" . time();
        }
        ?>
        <img src="<?php echo $pic; ?>" />
    </div>
</div>
<?php
}
?>