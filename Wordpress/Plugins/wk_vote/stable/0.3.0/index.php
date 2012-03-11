<?php
/* 
 Plugin Name: wk_vote
 Plugin URI: http://thinkdesquared.com
 Description: Voting system. Up/Down
 Version: 0.3.0
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * The main voting function
 * 
 * @param int $post_ID
 * @param boolean $down_button Also display a down button
 */
function wk_vote($post_ID, $down_button = 0) {
	
	include 'wp-content/plugins/wk_vote/options.php';
	?>
	
	<span class="votes post-<?php echo $post_ID; ?>">
		<?php
		$wk_votes_serialized = get_post_meta($post_ID, 'wk_votes', true);
		$wk_votes = unserialize($wk_votes_serialized);
		if(is_array($wk_votes)){
			$votes = 0;
			foreach($wk_votes as $vote){
				if($vote == 'up'){
					$votes++;
				}else{
					$votes--;
				}
			}
			echo $votes;
		}else{
			echo '0';
		}
		?>
	</span>
	
	<?php
	if(is_user_logged_in()){
		global $userdata;
    	get_currentuserinfo();
    	$uid = $userdata->ID;
	}
	//search users votes to see if he voted for this post
	if($uid){
		//get_usermeta unserializes too
		$wk_voted = get_usermeta($uid, 'wk_voted');
		if($wk_voted[$post_ID] == ''){
			$show_buttons = 1;
		}else{
			$show_buttons = 0;
		}
	}else{
		$show_buttons = 1;
	}
	if($show_buttons){
	?>
		<a href="javascript:void(0);" class="wk_vote vote-up post-<?php echo $post_ID; if($uid){echo ' loggedin user-' . $uid;} ?>">
			<?php echo $up_txt; ?>
		</a>
		<?php
		if($down_button){
		?>
			<a href="javascript:void(0);" class="wk_vote vote-down post-<?php echo $post_ID;  if($uid){echo ' loggedin user-' . $uid;} ?>">
				<?php echo $down_txt; ?>
			</a>
		<?php
		}
	}else{
	?>
		<span class="voted"><?php echo $voted_txt; ?></span>
	<?php
	}
}

wp_enqueue_script('jquery');
wp_enqueue_script('wk_vote', '/wp-content/plugins/wk_vote/wk_vote.js');
?>
