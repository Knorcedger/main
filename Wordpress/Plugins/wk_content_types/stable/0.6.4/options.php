<?php

//Γενικά όλα πρέπει να ακολουθούν την σειρά με την οποία έχουμε ορίσει τα content types στον πινακα $names

//$pages parent|Name|Name|capability|url
//$hide allowed values: postdivrich, postexcerpt, trackbacksdiv, postcustom, commentstatusdiv, authordiv, tagsdiv, categorydiv
//$box place:[side, normal], priority:[low, high], fields:by wk_submit

//our content types
$names = array('new', 'external_new', 'blog', 'suggested_link', 'news_topic', 'topics_menu', 'home_feeds');
$pages = array(
'post-new.php|Νέα Είδηση|Νέα Είδηση|publish_posts|post-new.php?type=new',
'post-new.php|Νέο Link σε Είδηση|Νέο Link σε Είδηση|publish_posts|post-new.php?type=external_new',
'post-new.php|Νέο Blog Post|Νέο Blog Post|edit_posts|post-new.php?type=blog',
'post-new.php|Νεο User Link|Νεο User Link|publish_posts|post-new.php?type=suggested_link',
'post-new.php|Νέο Θέμα|Νέο Θέμα|publish_posts|post-new.php?type=news_topic',
'post-new.php|Menu Επικαιρότητας|Menu Επικαιρότητας|publish_posts|post.php?action=edit&post=3',
'post-new.php|Homepage Feeds|Homepage Feeds|publish_posts|post.php?action=edit&post=107'
);
$hide = array(
'trackbacksdiv|postcustom',
'trackbacksdiv|postcustom',
'postexcerpt|trackbacksdiv|postcustom',
'postexcerpt|trackbacksdiv|postcustom|tagsdiv|categorydiv|postdivrich',
'postexcerpt|trackbacksdiv|postcustom',
'postexcerpt|trackbacksdiv|postcustom|tagsdiv|categorydiv|postdivrich|commentstatusdiv|authordiv',
'postexcerpt|trackbacksdiv|postcustom|tagsdiv|categorydiv|postdivrich|commentstatusdiv|authordiv',
);

//the number of boxes that each page has
$boxes['new'] = 2;
$boxes['external_new'] = 3;
$boxes['blog'] = 1;
$boxes['suggested_link'] = 2;
$boxes['news_topic'] = 2;
$boxes['topics_menu'] = 1;
$boxes['home_feeds'] = 2;


//new
$box['0'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'news_topic_box',
'title' => 'Θέμα Επικαιρότητας',
'fields' => array('3|autocomplete|news_topic|||25||post_title~news_topic', '3|autocomplete|news_topic_2|||25||post_title~news_topic', '3|autocomplete|news_topic_3|||25||post_title~news_topic')
);
//new
$box['1'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "photo_box",
'title' => "Αντιπροσωπευτικές Εικόνες",
'fields' => array('3|photo_over|photo|Φωτογραφία Είδησης||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|featured_photo|Featured Φωτογραφία Είδησης||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|checkbox|featured|Featured:|0|~featured')
);
//external-new
$box['2'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "news_topic_box",
'title' => "Θέματα Επικαιρότητας",
'fields' => array('3|autocomplete|news_topic|||25||post_title~news_topic', '3|autocomplete|news_topic_2|||25||post_title~news_topic', '3|autocomplete|news_topic_3|||25||post_title~news_topic')
);
//external-new
$box['3'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "photo_box",
'title' => "Αντιπροσωπευτική Εικόνα",
'fields' => array('3|photo_over|photo|Φωτογραφία Είδησης||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|featured_photo|Featured Φωτογραφία Είδησης||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|checkbox|featured|Featured:|0|~featured')
);
//external-new
$box['4'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "url_box",
'title' => "Πηγή Άρθρου",
'fields' => array('3|textfield|url|||28')
);
//blog
$box['5'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "news_topic_box",
'title' => "Θέματα Επικαιρότητας",
'fields' => array('3|autocomplete|news_topic|||25||post_title~news_topic', '3|autocomplete|news_topic_2|||25||post_title~news_topic', '3|autocomplete|news_topic_3|||25||post_title~news_topic')
);
//suggested-link
$box['6'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "news_topic_box",
'title' => "Θέματα Επικαιρότητας",
'fields' => array('3|autocomplete|news_topic|||25||post_title~news_topic', '3|autocomplete|news_topic_2|||25||post_title~news_topic', '3|autocomplete|news_topic_3|||25||post_title~news_topic')
);
//suggested-link
$box['7'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "url_box",
'title' => "Διεύθυνση Συνδέσμου",
'fields' => array('3|textfield|url|||28')
);
//news-topic
$box['8'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "feeds_box",
'title' => "Feeds",
'fields' => array('3|textfield|twitter|Twitter||28', '3|textfield|sync|Sync||28')
);
//news-topic
$box['9'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "photo_box",
'title' => "Αντιπροσωπευτική Εικόνα",
'fields' => array('3|photo_over|photo|Φωτογραφία Θέματος||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1')
);
//topics-menu

if($content_type == 'topics_menu'){
	include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';
	global $wpdb;
	$query = "SELECT wposts.*
				FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
				WHERE wposts.ID = wpostmeta.post_id 
				AND wpostmeta.meta_key = 'content_type' 
				AND wpostmeta.meta_value = 'news_topic'
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
	
	$result = $wpdb->get_results($query);
	$temp = '';
	foreach ($result as $val) {
		$temp .= '~' . $val->post_title . "~" . $val->ID;
	}
	$checkbox_options = substr($temp, 1);
}
//
$box['10'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'topics_box',
'title' => 'Θέματα Επικαιρότητας',
'fields' => array("3|checkbox|topics||1~0~1|$checkbox_options")
);
//home-feeds
$box['11'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "websites_box",
'title' => "Ιστοσελίδες-Πηγές",
'fields' => array(
	'3|textfield|website_name1|Όνομα||28', '3|textfield|website_url1|URL||28', '3|photo_over|website_photo1|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|website_name2|Όνομα||28', '3|textfield|website_url2|URL||28', '3|photo_over|website_photo2|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|website_name3|Όνομα||28', '3|textfield|website_url3|URL||28', '3|photo_over|website_photo3|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|website_name4|Όνομα||28', '3|textfield|website_url4|URL||28', '3|photo_over|website_photo4|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|website_name5|Όνομα||28', '3|textfield|website_url5|URL||28', '3|photo_over|website_photo5|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|website_name6|Όνομα||28', '3|textfield|website_url6|URL||28', '3|photo_over|website_photo6|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|website_name7|Όνομα||28', '3|textfield|website_url7|URL||28', '3|photo_over|website_photo7|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|website_name8|Όνομα||28', '3|textfield|website_url8|URL||28', '3|photo_over|website_photo8|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|website_name9|Όνομα||28', '3|textfield|website_url9|URL||28', '3|photo_over|website_photo9|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|website_name10|Όνομα||28', '3|textfield|website_url10|URL||28', '3|photo_over|website_photo10|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1'
	)
);
//home-feeds
$box['12'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "feeds_box",
'title' => "Twitter feeds",
'fields' => array(
	'3|textfield|feed_name1|Όνομα||28', '3|textfield|feed_url1|URL||28', '3|photo_over|feed_photo1|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|feed_name2|Όνομα||28', '3|textfield|feed_url2|URL||28', '3|photo_over|feed_photo2|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|feed_name3|Όνομα||28', '3|textfield|feed_url3|URL||28', '3|photo_over|feed_photo3|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|feed_name4|Όνομα||28', '3|textfield|feed_url4|URL||28', '3|photo_over|feed_photo4|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|feed_name5|Όνομα||28', '3|textfield|feed_url5|URL||28', '3|photo_over|feed_photo5|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|feed_name6|Όνομα||28', '3|textfield|feed_url6|URL||28', '3|photo_over|feed_photo6|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|feed_name7|Όνομα||28', '3|textfield|feed_url7|URL||28', '3|photo_over|feed_photo7|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|feed_name8|Όνομα||28', '3|textfield|feed_url8|URL||28', '3|photo_over|feed_photo8|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|feed_name9|Όνομα||28', '3|textfield|feed_url9|URL||28', '3|photo_over|feed_photo9|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	'3|textfield|feed_name10|Όνομα||28', '3|textfield|feed_url10|URL||28', '3|photo_over|feed_photo10|Λογότυπο||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', 
	)
);



//general options
$language = 'en';
?>
