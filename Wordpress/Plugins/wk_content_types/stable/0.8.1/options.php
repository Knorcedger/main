<?php

//Γενικά όλα πρέπει να ακολουθούν την σειρά με την οποία έχουμε ορίσει τα content types στον πινακα $names

//$pages parent|Name|Name|capability|url
//$hide allowed values: postdivrich, postexcerpt, trackbacksdiv, postcustom, commentstatusdiv, commentsdiv (appears only in edit), authordiv, tagsdiv, categorydiv
//$box place:[side, normal], priority:[low, high], fields:by wk_submit


//our content types
$names = array('destination', 'travel', 'cruise', 'ship', 'type', 'provider');
$pages = array(
'post-new.php|Νέος Προορισμός|Νέος Προορισμός|publish_posts|post-new.php?type=destination',
'post-new.php|Νέα Εκδρομή|Νέα Εκδρομή|publish_posts|post-new.php?type=travel',
'post-new.php|Νέα Κρουαζιέρα|Νέα Κρουαζιέρα|publish_posts|post-new.php?type=cruise',
'post-new.php|Νέο Πλοίο|Νέο Πλοίο|publish_posts|post-new.php?type=ship',
'post-new.php|Νέος Τύπος Ταξιδιού|Νέος Τύπος Ταξιδιού|publish_posts|post-new.php?type=type',
'post-new.php|Νέος Προμηθευτής|Νέος Προμηθευτής|publish_posts|post-new.php?type=provider'
);
$hide = array(
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv'
);

//the number of boxes that each page has
$boxes['destination'] = 5;
$boxes['travel'] = 10;
$boxes['cruise'] = 8;
$boxes['ship'] = 2;
$boxes['type'] = 1;
$boxes['provider'] = 1;


//destination
$querystr = "SELECT wposts.*
				FROM wp_posts wposts, wp_postmeta wpostmeta, wp_postmeta wpostmeta2
				WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id
				AND 
				(
					(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'destination')
					AND (wpostmeta2.meta_key = 'level1_destination' AND wpostmeta2.meta_value = '')
				)
				AND wposts.post_status = 'publish'
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
$box['0'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'level1_destination_box',
'title' => 'Κατηγοριοποίηση επιπέδου 1',
'fields' => array("3|autocomplete|level1_destination|||30|$querystr|post_title|10|1", '1|textfield|post_category|Κατηγορία|4|2', '1|textfield|content_type|Content_type|destination|25')
);
//destination
$querystr = "SELECT wposts.*
				FROM wp_posts wposts, wp_postmeta wpostmeta, wp_postmeta wpostmeta2, wp_postmeta wpostmeta3
				WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id AND wposts.ID = wpostmeta3.post_id
				AND 
				(
					(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'destination')
					AND (wpostmeta2.meta_key = 'level1_destination' AND wpostmeta2.meta_value != '')
					AND (wpostmeta3.meta_key = 'level2_destination' AND wpostmeta3.meta_value = '')
				)
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
$box['1'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'level2_destination_box',
'title' => 'Κατηγοριοποίηση επιπέδου 2',
'fields' => array("3|autocomplete|level2_destination|||30|$querystr|post_title|10|1")
);
//destination
$box['2'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'destination_photo_box',
'title' => 'Φωτογραφία',
'fields' => array('3|photo_over|destination_photo|Φωτογραφία||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1')
);
//destination
$box['3'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'destination_info_box',
'title' => 'Επιπλέον Πληροφορίες',
'fields' => array('3|textfield|additional1|Πληροφορία 1||25', '3|textfield|additional2|Πληροφορία 2||25', '3|textfield|additional3|Πληροφορία 3||25', '3|textfield|additional4|Πληροφορία 4||25', '3|textfield|additional5|Πληροφορία 5||25')
);
//destination
$box['4'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'links_box',
'title' => 'Χρήσιμα Links',
'fields' => array('3|textfield|link1|Link 1||25', '3|textfield|link2|Link 2||25', '3|textfield|link3|Link 3||25', '3|textfield|link4|Link 4||25', '3|textfield|link5|Link 5||25', '3|textfield|link6|Link 6||25', '3|textfield|link7|Link 7||25', '3|textfield|link8|Link 8||25', '3|textfield|link9|Link 9||25', '3|textfield|link10|Link 10||25')
);
//travel
$box['5'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'duration_box',
'title' => 'Διάρκεια Εκδρομής',
'fields' => array('3|textfield|duration_days|Μέρες||2', '3|textfield|duration_nights|Νύχτες||2', '1|textfield|post_category|Κατηγορία|3|2', '1|textfield|content_type|Content_type|travel|25')
);
//travel
$box['6'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "departure_box",
'title' => "Ημερομηνία Αναχώρησης",
'fields' => array("dates_num|date_start|date_end|date_monday|date_tuesday|date_wednesday|date_thursday|date_friday|date_saturday|date_sunday", "date|date_seats"),
'custom' => 'custom.php'
);
//travel
$box['7'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "included_box",
'title' => "Περιλαμβάνονται",
'fields' => array("3|autocomplete|included1|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included2|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included3|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included4|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included5|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included6|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included7|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included8|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included9|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included10|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1")
);
//travel
$box['8'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "not_included_box",
'title' => "Δεν Περιλαμβάνονται",
'fields' => array("3|autocomplete|not_included1|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included2|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included3|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included4|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included5|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included6|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included7|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included8|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included9|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included10|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1")
);
//travel
$box['9'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "flights_box",
'title' => "Πτήσεις",
'fields' => array('3|textfield|flight_company|Αεροπορική εταιρία||25', '3|textfield|original_city1|Πόλη Αναχώρησης||25', '3|textfield|arrival_city1|Πόλη Προορισμού||25', '3|date|flight_departure_date1|Ημερομηνία Αναχώρησης|3~12~2009', '3|time|flight_departure_time1|Ώρα Αναχώρησης|7~30|5', '3|date|flight_arrival_date1|Ημερομηνίας Άφιξης|', '3|time|flight_arrival_time1|Ώρα Άφιξης|7~30|5', '3|textfield|original_city2|Πόλη Αναχώρησης||25', '3|textfield|arrival_city2|Πόλη Προορισμού||25', '3|date|flight_departure_date2|Ημερομηνία Αναχώρησης|3~12~2009', '3|time|flight_departure_time2|Ώρα Αναχώρησης|7~30|5', '3|date|flight_arrival_date2|Ημερομηνία Άφιξης|3~12~2009', '3|time|flight_arrival_time2|Ώρα Άφιξης|7~30|5')
);
//travel
$box['10'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "additional_box",
'title' => "Πρόσθετες Πληροφορίες",
'fields' => array('3|textarea|additional_text|||20|5', "3|autocomplete|additional1|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value|10|1", "3|autocomplete|additional2|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value|10|1", "3|autocomplete|additional3|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value|10|1", "3|autocomplete|additional4|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value|10|1", "3|autocomplete|additional5|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value|10|1")
);
//travel
$box['11'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "prices_box",
'title' => "Τιμοκατάλογος",
'fields' => array('3|textfield|hotel1|Ξενοδοχείο||25', '3|dropdown|stars1|Αστέρων|1|-~empty~*~1~**~2~***~3~****~4~*****~5', '3|dropdown|stars_multi1|Αστέρων|1|-~empty~*/**~12~**/***~23~***/****~34~****/*****~45', '3|textfield|hotel1_link|Ιστοσελίδα Ξενοδοχείου||25', '3|textfield|hotel1_room1|Μονόκλινο||25', '3|textfield|hotel1_room2|Δίκλινο||25', '3|textfield|hotel1_room3|Τρίκλινο||25', '3|textfield|hotel1_child|Παιδικό||25', '3|textfield|hotel1_child_age|Παιδική ηλικία||25', '3|textfield|hotel1_airport_taxes|Φόροι Αεροδρομίου||25', '3|textfield|hotel_additional1|Επιπλέον||25', '3|textfield|hotel_additional1_price1|Τιμή||28', '3|textfield|collected|Προμήθεια||28')
);
//travel
$querystr = "SELECT wposts.*
				FROM wp_posts wposts, wp_postmeta wpostmeta, wp_postmeta wpostmeta2
				WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id
				AND 
				(
					(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'destination')
					AND (wpostmeta2.meta_key = 'level1_destination' AND wpostmeta2.meta_value = '')
				)
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
$box['12'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'level1_destination_box',
'title' => 'Προορισμός επιπέδου 1',
'fields' => array("3|autocomplete|level1_destination|||30|$querystr|post_title|10|1")
);
//travel
$querystr = "SELECT wposts.*
				FROM wp_posts wposts, wp_postmeta wpostmeta, wp_postmeta wpostmeta2, wp_postmeta wpostmeta3
				WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id AND wposts.ID = wpostmeta3.post_id
				AND 
				(
					(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'destination')
					AND (wpostmeta2.meta_key = 'level1_destination' AND wpostmeta2.meta_value != '')
					AND (wpostmeta3.meta_key = 'level2_destination' AND wpostmeta3.meta_value = '')
				)
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
$box['13'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'level2_destination_box',
'title' => 'Προορισμός επιπέδου 2',
'fields' => array("3|autocomplete|level2_destination|||30|$querystr|post_title|10|1")
);
//cruise
$box['14'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "provider_box",
'title' => "Προμηθευτής",
'fields' => array("3|autocomplete|travel_provider|||30||post_title~provider|10|1")
);
//cruise
$box['15'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'duration_box',
'title' => 'Διάρκεια Κρουαζιέρας',
'fields' => array('3|textfield|duration_days|Μέρες||2', '3|textfield|duration_nights|Νύχτες||2', '1|textfield|post_category|Κατηγορία|5|2', '1|textfield|content_type|Content_type|cruise|25')
);
//cruise
$box['16'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "departure_box",
'title' => "Ημερομηνία Αναχώρησης",
'fields' => array("dates_num|date_start|date_end|date_monday|date_tuesday|date_wednesday|date_thursday|date_friday|date_saturday|date_sunday", "date|date_seats"),
'custom' => 'custom.php'
);
//cruise
$box['17'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "included_box",
'title' => "Περιλαμβάνονται",
'fields' => array("3|autocomplete|included1|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included2|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included3|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included4|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included5|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included6|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included7|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included8|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included9|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1", "3|autocomplete|included10|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value|10|1")
);
//cruise
$box['18'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "not_included_box",
'title' => "Δεν Περιλαμβάνονται",
'fields' => array("3|autocomplete|not_included1|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included2|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included3|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included4|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included5|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included6|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included7|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included8|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included9|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1", "3|autocomplete|not_included10|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value|10|1")
);
//cruise
$box['19'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "cruise_ship_box",
'title' => "Στοιχεία εκδρομής",
'fields' => array("3|autocomplete|cruise_ship|Κρουαζιερόπλοιο||30||post_title~ship|10|1", "3|autocomplete|company|Εταιρία||30|SELECT * FROM wp_postmeta WHERE meta_key = 'company'|meta_value|10|1")
);
//cruise
$querystr = "SELECT wposts.*
				FROM wp_posts wposts, wp_postmeta wpostmeta, wp_postmeta wpostmeta2
				WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id
				AND 
				(
					(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'destination')
					AND (wpostmeta2.meta_key = 'level1_destination' AND wpostmeta2.meta_value = '')
				)
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
$box['20'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'level1_destination_box',
'title' => 'Προορισμός επιπέδου 1',
'fields' => array("3|autocomplete|level1_destination|||30|$querystr|post_title|10|1")
);
//cruise
$querystr = "SELECT wposts.*
				FROM wp_posts wposts, wp_postmeta wpostmeta, wp_postmeta wpostmeta2, wp_postmeta wpostmeta3
				WHERE wposts.ID = wpostmeta.post_id AND wposts.ID = wpostmeta2.post_id AND wposts.ID = wpostmeta3.post_id
				AND 
				(
					(wpostmeta.meta_key = 'content_type' AND wpostmeta.meta_value = 'destination')
					AND (wpostmeta2.meta_key = 'level1_destination' AND wpostmeta2.meta_value != '')
					AND (wpostmeta3.meta_key = 'level2_destination' AND wpostmeta3.meta_value = '')
				)
				AND wposts.post_status = 'publish' 
				AND wposts.post_type = 'post' 
				ORDER BY wposts.post_date DESC";
$box['21'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'level2_destination_box',
'title' => 'Προορισμός επιπέδου 2',
'fields' => array("3|autocomplete|level2_destination|||30|$querystr|post_title|10|1")
);
//cruise
$box['22'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "provider_box",
'title' => "Προμηθευτής",
'fields' => array("3|autocomplete|cruise_provider|||30||post_title~provider|10|1")
);
//ship
$box['23'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'destination_info_box',
'title' => 'Επιπλέον Πληροφορίες',
'fields' => array('3|textfield|additional1|Πληροφορία 1||25', '3|textfield|additional2|Πληροφορία 2||25', '3|textfield|additional3|Πληροφορία 3||25', '3|textfield|additional4|Πληροφορία 4||25', '3|textfield|additional5|Πληροφορία 5||25', '1|textfield|post_category|Κατηγορία|7|2', '1|textfield|content_type|Content_type|ship|25')
);
//ship
$box['24'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'photo_box',
'title' => 'Φωτογραφίες',
'fields' => array('3|photo_over|photo1|Φωτογραφία 1||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo2|Φωτογραφία 2||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo3|Φωτογραφία 3||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo4|Φωτογραφία 4||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo5|Φωτογραφία 5||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo6|Φωτογραφία 6||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo7|Φωτογραφία 7||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo8|Φωτογραφία 8||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo9|Φωτογραφία 9||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo10|Φωτογραφία 10||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1')
);
//type
$box['25'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'info_box',
'title' => 'Πληροφορίες',
'fields' => array('1|textfield|post_category|Κατηγορία|8|2', '1|textfield|content_type|Content_type|type|25')
);
//provider
$box['26'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'info_box',
'title' => 'Πληροφορίες',
'fields' => array('3|textfield|phone|Τηλέφωνο||25', '3|textfield|email|Email||25', '3|textfield|name|Όνομα||25', '1|textfield|post_category|Κατηγορία|6|2', '1|textfield|content_type|Content_type|type|25')
);




//general options
$language = 'en';
?>
