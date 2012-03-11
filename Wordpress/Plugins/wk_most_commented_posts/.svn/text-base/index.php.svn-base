<?php
/* 
 Plugin Name: wk_most_commented_posts
 Plugin URI: http://o-some.com
 Description: Displays the most commented posts
 Version: 0.2.3
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Displays the most commented posts
 * 
 * @example wk_most_commented_posts(10, 60, '<ul>', '</ul>', '<li><a href="the_post_link">the_post_title</a> - the_comment_number comments</li>');
 * 
 * @return 
 * @param int $posts_num
 * @param int $posts_age In days
 * @param string $prefix[optional]
 * @param string $suffix[optional]
 * @param string $between[optional] Using the vars: the_post_link, the_comment_number, the_post_title, the_post_id, the_post_date
 */
function wk_most_commented_posts($posts_num, $posts_age, $prefix = '<ul>', $suffix = '</ul>', $between = '<li><a href="the_post_link">the_post_title</a> - the_comment_number comments</li>') {
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID,
comment_post_ID, comment_approved, comment_type, post_date, COUNT(comment_ID) AS comment_num 
FROM wp_comments
LEFT OUTER JOIN wp_posts ON (wp_comments.comment_post_ID = wp_posts.ID)
WHERE DATEDIFF(NOW(), post_date) < '$posts_age' 
AND comment_approved = '1' 
AND comment_type = '' 
AND post_password = '' 
GROUP BY ID
ORDER BY comment_num DESC
LIMIT 50";
	$most_commented_posts = $wpdb->get_results($sql);
	//create final string
	$final = $prefix;
	//check the size of the array fetched
	if($posts_num > sizeof($most_commented_posts)){
		$allposts = sizeof($most_commented_posts);
	}else{
		$allposts = $posts_num;
	}
	
	/*
	$myids = '';
	for ($i = 0; $i < sizeof($most_commented_posts); $i++) {
		$myids .= "'".$most_commented_posts[$i]->ID."',";
	}

	$myids = substr($myids, 0, strlen($myids)-1);
	echo $myids;
	*/
	
	
	// retrieve one post with an ID of 5
	query_posts(array('post__in' => array(5,12,2,14,7)));
	      
	//global $more;
	// set $more to 0 in order to only get the first part of the post
	//$more = 0; 
	
	// the Loop
	while (have_posts()) : the_post(); 
		// the content of the post
		the_content();
		echo "<br><br>";
	endwhile;
	
	/*
	for ($i = 0; $i < $allposts; $i++) {
		echo "cat=";
		the_category();
		//create vars to replace
		$the_post_link = get_permalink($most_commented_posts[$i]->ID);
		$the_comment_number = $most_commented_posts[$i]->comment_num;
		$the_post_title = $most_commented_posts[$i]->post_title;
		$the_post_id = $most_commented_posts[$i]->ID;
		$the_post_date = the_date('', '', '', FALSE);
		//replace dummy vars with the real ones
		$temp = str_replace('the_post_link', $the_post_link, $between);
		$temp = str_replace('the_comment_number', $the_comment_number, $temp);
		$temp = str_replace('the_post_title', $the_post_title, $temp);
		$temp = str_replace('the_post_id', $the_post_id, $temp);
		$temp = str_replace('the_post_date', $the_post_date, $temp);
		$final .= $temp;
	}
	$final .= $suffix;
	echo $final;*/
}
?>
