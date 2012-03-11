<?php
/* 
 Plugin Name: wk_top commentators
 Plugin URI: http://o-some.com
 Description: Displays the top commentators
 Version: 0.2.7
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Displays the top commentators
 * 
 * @example wk_top_commentators(30, 5, '', '<ul>', '</ul>', '<li><a href="the_author_url">the_author_name</a> (comments_posted)</li>', 'http://www.google.com/search?q=the_author_name');
 * 
 * @return 
 * @param int $days_counting Fetch posts that are ... days old
 * @param int $user_limit The number of users to display
 * @param string $prefix 
 * @param string $suffix
 * @param string $between Using the vars: the_author_name, the_author_url, comments_posted, the_author_email
 * @param string alternative_url[optional] Display this url if the author has no url
 */
function wk_top_commentators($days_counting, $user_limit, $exclude, $prefix = '<ul>', $suffix = '</ul>', $between = '<li><a href="the_author_url">the_author_name</a> (comments_posted)</li>', $alternative_url = '') {
	global $wpdb;
	$sql = "SELECT comment_author, comment_author_url, comment_author_email, COUNT(*) AS comments_posted FROM $wpdb->comments 
	WHERE DATEDIFF(NOW(), comment_date) < '$days_counting' ";
	foreach ($exclude as $val) {
		$sql .= "AND comment_author!='$val' ";
	}
	$sql .= "GROUP BY comment_author ORDER BY comments_posted DESC LIMIT $user_limit";
	
	$commentators = $wpdb->get_results($sql);
	//create final string
	$final = $prefix;
	for ($i = 0; $i < sizeof($commentators); $i++) {
		//create vars to replace
		$the_author_name = $commentators[$i]->comment_author;
		$the_author_url = $commentators[$i]->comment_author_url;
		$the_author_email = $commentators[$i]->comment_author_email;
		$comments_posted = $commentators[$i]->comments_posted;
		//replace dummy vars with the real ones
		if($the_author_url == ''){
			//
			if($alternative_url == ''){
				//remove <a href=... but leave the text inside the link
				$link_extract = "/<a href=.*?>/i";
				preg_match_all($link_extract, $between, $links, PREG_SET_ORDER);
				$link = $links[0][0];
				$temp = str_replace($link, '', $between);
				//remove </a>
				$temp = str_replace('</a>', '', $temp);
			}else{
				$temp = str_replace('the_author_url', $alternative_url, $between);
			}
		}else{
			$temp = str_replace('the_author_url', $the_author_url, $between);
		}
		$temp = str_replace('the_author_name', $the_author_name, $temp);
		$temp = str_replace('the_author_email', $the_author_email, $temp);
		$temp = str_replace('comments_posted', $comments_posted, $temp);
		$final .= $temp;
	}
	$final .= $suffix;
	echo $final;
}
?>
