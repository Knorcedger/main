<?php
/* 
 Plugin Name: wk_recent_comments
 Plugin URI: http://o-some.com
 Description: Displays the most recent comments
 Version: 0.5.2
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Displays the most recent comments
 * 
 * @example wk_recent_comments(5, 60, '<ul>', '</ul>', '<li><a href="the_link">the_username</a> - the_text</li>');
 * 
 * @return 
 * @param int $comments_num Number of comments to display
 * @param int $comment_size The characters of each comment to display
 * @param string $prefix[optional] 
 * @param string $suffix[optional]
 * @param string $between[optional] Using the vars: the_link, the_username, the_text
 */
function wk_recent_comments($comments_num, $comment_size, $prefix = '<ul>', $suffix = '</ul>', $between = '<li><a href="the_link">the_username</a> - the_text</li>') {
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
comment_post_ID, comment_author, comment_date_gmt, comment_approved,
comment_type,comment_author_url,
SUBSTRING(comment_content,1,'$comment_size') AS com_excerpt
FROM $wpdb->comments
LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID =
$wpdb->posts.ID)
WHERE comment_approved = '1' AND comment_type = '' AND
post_password = ''
ORDER BY comment_date_gmt DESC
LIMIT $comments_num";
	$comments = $wpdb->get_results($sql);
	//create final string
	$final = $prefix;
	for ($i = 0; $i < sizeof($comments); $i++) {
		//create vars to replace
		$link = get_permalink($comments[$i]->ID)."#comment-".$comments[$i]->comment_ID;
		$username = strip_tags($comments[$i]->comment_author);
		$text = strip_tags($comments[$i]->com_excerpt);
		//replace dummy vars with the real ones
		$temp = str_replace('the_link', $link, $between);
		$temp = str_replace('the_username', $username, $temp);
		$temp = str_replace('the_text', $text, $temp);
		$final .= $temp;
	}
	$final .= $suffix;
	echo $final;
}
?>
