<?php

//Γενικά όλα πρέπει να ακολουθούν την σειρά με την οποία έχουμε ορίσει τα content types στον πινακα $names

//$pages parent|Name|Name|capability|url
//$hide allowed values: postdivrich, postexcerpt, trackbacksdiv, postcustom, commentstatusdiv, commentsdiv (appears only in edit), authordiv, tagsdiv-post_tag, categorydiv
//$box place:[side, normal], priority:[low, high], fields:by wk_submit

/*Χρήση custom: 
'fields' => array("destinations|level1_destination", "level2_destination|level3_destination"),
Η πρώτη μεταβλητή λέει πόσα loops πρέπει να κάνει το for για να μαζέψει μεταβλητές από τις μεταβλητές μετά το κόμμα.
Οι υπόλοιπες μεταβλητές πριν το κομμα, είναι απλές μεταβλητές.
Οι μεταβλητές μετά το κόμμα είναι του τύπου level2_destination0, level2_destination1...
*/

//our content types
$names = array('destination', 'travel', 'cruise', 'personal', 'transport', 'ship', 'hotel', 'type', 'provider', 'new', 'home');
$pages = array(
'post-new.php|Νέος Προορισμός|Νέος Προορισμός|publish_posts|post-new.php?type=destination',
'post-new.php|Νέα Εκδρομή|Νέα Εκδρομή|publish_posts|post-new.php?type=travel',
'post-new.php|Νέα Κρουαζιέρα|Νέα Κρουαζιέρα|publish_posts|post-new.php?type=cruise',
'post-new.php|Νέο Ατομικό|Νέο Ατομικό|publish_posts|post-new.php?type=personal',
'post-new.php|Νέα Μεταφορά|Νέα Μεταφορά|publish_posts|post-new.php?type=transport',
'post-new.php|Νέο Πλοίο|Νέο Πλοίο|publish_posts|post-new.php?type=ship',
'post-new.php|Νέο Ξενοδοχείο|Νέο Ξενοδοχείο|publish_posts|post-new.php?type=hotel',
'post-new.php|Νέος Τύπος Ταξιδιού|Νέος Τύπος Ταξιδιού|publish_posts|post-new.php?type=type',
'post-new.php|Νέος Προμηθευτής|Νέος Προμηθευτής|publish_posts|post-new.php?type=provider', 
'post-new.php|Νέο Άρθρο|Νέο Άρθρο|publish_posts|post-new.php?type=new', 
'post.php|Edit Homepage|Edit Homepage|publish_posts|post.php?action=edit&post=1414'
);
$hide = array(
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postdivrich|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv|tagsdiv-post_tag',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv',
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv', 
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv', 
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv|categorydiv|tagsdiv-post_tag|postdivrich'
);

//the number of boxes that each page has
$boxes['destination'] = 3;
$boxes['travel'] = 11;
$boxes['cruise'] = 8;
$boxes['personal'] = 5;
$boxes['transport'] = 2;
$boxes['ship'] = 3;
$boxes['hotel'] = 2;
$boxes['type'] = 1;
$boxes['provider'] = 1;
$boxes['new'] = 1;
$boxes['home'] = 5;


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
$querystr2 = "SELECT wposts.*
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
$box['0'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'level1_destination_box',
'title' => 'Κατηγοριοποίηση Προορισμού',
'fields' => array("3|autocomplete|level1_destination|Επίπεδο 1||30|$querystr|post_title|10|1","3|autocomplete|level2_destination|Επίπεδο 2||30|$querystr2|post_title|10|1", '1|textfield|content_type|Content_type|destination|25')
);
$box['1'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'image_box',
'title' => 'Φωτογραφίες',
'fields' => array("3|textfield|photo_title1|Title 1||25", "3|photo_over|destination_photo1|Φωτογραφία 1||Upload~Edit|400~150|460|300|2000|1~80~80~1:1", "3|textfield|photo_title2|Title 2||25", "3|photo_over|destination_photo2|Φωτογραφία 2||Upload~Edit|400~150|460|300|2000|1~80~80~1:1", "3|textfield|photo_title3|Title 3||25", "3|photo_over|destination_photo3|Φωτογραφία 3||Upload~Edit|400~150|460|300|2000|1~80~80~1:1", "3|textfield|photo_title4|Title 4||25", "3|photo_over|destination_photo4|Φωτογραφία 4||Upload~Edit|400~150|460|300|2000|1~80~80~1:1", "3|textfield|photo_title5|Title 5||25", "3|photo_over|destination_photo5|Φωτογραφία 5||Upload~Edit|400~150|460|300|2000|1~80~80~1:1", "3|textfield|photo_title6|Title 6||25", "3|photo_over|destination_photo6|Φωτογραφία 6||Upload~Edit|400~150|460|300|2000|1~80~80~1:1", "3|textfield|photo_title7|Title 7||25", "3|photo_over|destination_photo7|Φωτογραφία 7||Upload~Edit|400~150|460|300|2000|1~80~80~1:1", "3|textfield|photo_title8|Title 8||25", "3|photo_over|destination_photo8|Φωτογραφία 8||Upload~Edit|400~150|460|300|2000|1~80~80~1:1", "3|textfield|photo_title9|Title 9||25", "3|photo_over|destination_photo9|Φωτογραφία 9||Upload~Edit|400~150|460|300|2000|1~80~80~1:1", "3|textfield|photo_title10|Title 10||25", "3|photo_over|destination_photo10|Φωτογραφία 10||Upload~Edit|400~150|460|300|2000|1~80~80~1:1")
);
//destination
$box['2'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'links_box',
'title' => 'Χρήσιμα Links',
'fields' => array('3|textfield|title1|Title 1||25', '3|textfield|link1|Link 1||25', '3|textfield|title2|Title 2||25', '3|textfield|link2|Link 2||25', '3|textfield|title3|Title 3||25', '3|textfield|link3|Link 3||25', '3|textfield|title4|Title 4||25', '3|textfield|link4|Link 4||25', '3|textfield|title5|Title 5||25', '3|textfield|link5|Link 5||25', '3|textfield|title6|Title 6||25', '3|textfield|link6|Link 6||25', '3|textfield|title7|Title 7||25', '3|textfield|link7|Link 7||25', '3|textfield|title8|Title 8||25', '3|textfield|link8|Link 8||25', '3|textfield|title9|Title 9||25', '3|textfield|link9|Link 9||25', '3|textfield|title10|Title 10||25', '3|textfield|link10|Link 10||25')
);
//travel
$box['3'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => 'duration_box',
'title' => 'Διάρκεια Εκδρομής',
'fields' => array('3|textfield|duration_days|Μέρες||2', '3|textfield|duration_nights|Νύχτες||2', '1|textfield|content_type|Content_type|travel|25', '3|dropdown|featured|Featured|1|Όχι~no~Ναι~yes')
);
//travel
$box['4'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "departure_box",
'title' => "Στοιχεία Αναχωρήσεων",
'fields' => array("dates_num|date_start|date_end|date_monday|date_tuesday|date_wednesday|date_thursday|date_friday|date_saturday|date_sunday", "date|date_return|date_seats|date_seats_sold|date_type|date_on_request|date_closed|date_transport|date_transport_return"),
'custom' => 'travel_custom.php'
);
//travel
$query_included = "SELECT DISTINCT meta_value FROM wp_postmeta WHERE (meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10' OR  meta_key = 'included11' OR  meta_key = 'included12' OR  meta_key = 'included13' OR  meta_key = 'included14' OR  meta_key = 'included15') AND meta_value != ''";
$box['5'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "included_box",
'title' => "Περιλαμβάνονται",
'fields' => array("3|autocomplete|included1|||30|$query_included|meta_value|10|1", 
"3|autocomplete|included2|||30|$query_included|meta_value|100|1", 
"3|autocomplete|included3|||30|$query_included|meta_value|100|1", 
"3|autocomplete|included4|||30|$query_included|meta_value|100|1", 
"3|autocomplete|included5|||30|$query_included|meta_value|100|1", 
"3|autocomplete|included6|||30|$query_included|meta_value|100|1", 
"3|autocomplete|included7|||30|$query_included|meta_value|100|1", 
"3|autocomplete|included8|||30|$query_included|meta_value|100|1", 
"3|autocomplete|included9|||30|$query_included|meta_value|100|1", 
"3|autocomplete|included10|||30|$query_included|meta_value|100|1",
"3|autocomplete|included11|||30|$query_included|meta_value|100|1",
"3|autocomplete|included12|||30|$query_included|meta_value|100|1",
"3|autocomplete|included13|||30|$query_included|meta_value|100|1",
"3|autocomplete|included14|||30|$query_included|meta_value|100|1",
"3|autocomplete|included15|||30|$query_included|meta_value|100|1")
);
//travel
$query_not_included = "SELECT DISTINCT meta_value FROM wp_postmeta WHERE (meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10') AND meta_value != ''";
$box['6'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "not_included_box",
'title' => "Δεν Περιλαμβάνονται",
'fields' => array("3|autocomplete|not_included1|||30|$query_not_included|meta_value|10|1", 
"3|autocomplete|not_included2|||30|$query_not_included|meta_value|10|1", 
"3|autocomplete|not_included3|||30|$query_not_included|meta_value|10|1", 
"3|autocomplete|not_included4|||30|$query_not_included|meta_value|10|1", 
"3|autocomplete|not_included5|||30|$query_not_included|meta_value|10|1", 
"3|autocomplete|not_included6|||30|$query_not_included|meta_value|10|1", 
"3|autocomplete|not_included7|||30|$query_not_included|meta_value|10|1", 
"3|autocomplete|not_included8|||30|$query_not_included|meta_value|10|1", 
"3|autocomplete|not_included9|||30|$query_not_included|meta_value|10|1", 
"3|autocomplete|not_included10|||30|$query_not_included|meta_value|10|1")
);
//travel
$query_additional = "SELECT DISTINCT meta_value FROM wp_postmeta WHERE (meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5') AND meta_value != ''";
$box['7'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "additional_box",
'title' => "Πρόσθετες Πληροφορίες",
'fields' => array('3|textarea|additional_text|||20|5', "3|autocomplete|additional1|||30|$query_additional|meta_value|10|1", 
"3|autocomplete|additional2|||30|$query_additional|meta_value|10|1", 
"3|autocomplete|additional3|||30|$query_additional|meta_value|10|1", 
"3|autocomplete|additional4|||30|$query_additional|meta_value|10|1", 
"3|autocomplete|additional5|||30|$query_additional|meta_value|10|1")
);
//travel
$box['8'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "hotels_box",
'title' => "Ξενοδοχεία",
'fields' => array("3|autocomplete|hotel1|Ξενοδοχείο 1||30||post_title~hotel|10|1", '3|textfield|hotel_room_one1|Μονόκλινο||25', '3|textfield|hotel_room_two1|Δίκλινο||25', '3|textfield|hotel_room_three1|Τρίκλινο||25', '3|textfield|hotel_child1|Παιδικό||25', '3|textfield|hotel_child_age1|Παιδική ηλικία||25', '3|textfield|first_additional1|Επιπλέον 1||25', '3|textfield|first_additional_price1|Τιμή 1||28', '3|textfield|second_additional1|Επιπλέον 2||25', '3|textfield|second_additional_price1|Τιμή 2||28', '3|textfield|third_additional1|Επιπλέον 3||25', '3|textfield|third_additional_price1|Τιμή 3||28',
"3|autocomplete|hotel2|Ξενοδοχείο 2||30||post_title~hotel|10|1", '3|textfield|hotel_room_one2|Μονόκλινο||25', '3|textfield|hotel_room_two2|Δίκλινο||25', '3|textfield|hotel_room_three2|Τρίκλινο||25', '3|textfield|hotel_child2|Παιδικό||25', '3|textfield|hotel_child_age2|Παιδική ηλικία||25', '3|textfield|first_additional2|Επιπλέον 1||25', '3|textfield|first_additional_price2|Τιμή 1||28', '3|textfield|second_additional2|Επιπλέον 2||25', '3|textfield|second_additional_price2|Τιμή 2||28', '3|textfield|third_additional2|Επιπλέον 3||25', '3|textfield|third_additional_price2|Τιμή 3||28', 
"3|autocomplete|hotel3|Ξενοδοχείο 3||30||post_title~hotel|10|1", '3|textfield|hotel_room_one3|Μονόκλινο||25', '3|textfield|hotel_room_two3|Δίκλινο||25', '3|textfield|hotel_room_three3|Τρίκλινο||25', '3|textfield|hotel_child3|Παιδικό||25', '3|textfield|hotel_child_age3|Παιδική ηλικία||25', '3|textfield|first_additional3|Επιπλέον 1||25', '3|textfield|first_additional_price3|Τιμή 1||28', '3|textfield|second_additional3|Επιπλέον 2||25', '3|textfield|second_additional_price3|Τιμή 2||28', '3|textfield|third_additional3|Επιπλέον 3||25', '3|textfield|third_additional_price3|Τιμή 3||28',
"3|autocomplete|hotel4|Ξενοδοχείο 4||30||post_title~hotel|10|1", '3|textfield|hotel_room_one4|Μονόκλινο||25', '3|textfield|hotel_room_two4|Δίκλινο||25', '3|textfield|hotel_room_three4|Τρίκλινο||25', '3|textfield|hotel_child4|Παιδικό||25', '3|textfield|hotel_child_age4|Παιδική ηλικία||25', '3|textfield|first_additional4|Επιπλέον 1||25', '3|textfield|first_additional_price4|Τιμή 1||28', '3|textfield|second_additional4|Επιπλέον 2||25', '3|textfield|second_additional_price4|Τιμή 2||28', '3|textfield|third_additional4|Επιπλέον 3||25', '3|textfield|third_additional_price4|Τιμή 3||28',
"3|autocomplete|hotel5|Ξενοδοχείο 5||30||post_title~hotel|10|1", '3|textfield|hotel_room_one5|Μονόκλινο||25', '3|textfield|hotel_room_two5|Δίκλινο||25', '3|textfield|hotel_room_three5|Τρίκλινο||25', '3|textfield|hotel_child5|Παιδικό||25', '3|textfield|hotel_child_age5|Παιδική ηλικία||25', '3|textfield|first_additional5|Επιπλέον 1||25', '3|textfield|first_additional_price5|Τιμή 1||28', '3|textfield|second_additional5|Επιπλέον 2||25', '3|textfield|second_additional_price5|Τιμή 2||28', '3|textfield|third_additional5|Επιπλέον 3||25', '3|textfield|third_additional_price5|Τιμή 3||28',
'3|textfield|collected|Προμήθεια||28', '3|textfield|hotel1_airport_taxes|Φόροι Αεροδρομίου||25')
);
//travel
$box['9'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "travel_additional_box",
'title' => "Επιπλέον Στοιχεία Εκδρομής",
'fields' => array('3|textfield|travel_additional1|Επιπλέον 1||25', '3|textfield|travel_additional_price1|Τιμή 1||28', '3|textfield|travel_additional2|Επιπλέον 2||25', '3|textfield|travel_additional_price2|Τιμή 2||28', '3|textfield|travel_additional3|Επιπλέον 3||25', '3|textfield|travel_additional_price3|Τιμή 3||28', '3|textfield|travel_additional4|Επιπλέον 4||25', '3|textfield|travel_additional_price4|Τιμή 4||28', '3|textfield|travel_additional5|Επιπλέον 5||25', '3|textfield|travel_additional_price5|Τιμή 5||28')
);
//travel
$box['10'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "destination_box",
'title' => "Προορισμοί",
'fields' => array("destinations", "level1_destination|level2_destination|level3_destination"),
'custom' => 'destination_custom.php'
);
//travel
$box['11'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "photo_box",
'title' => "Φωτογραφία εκδρομής",
'fields' => array('3|photo_over|travel_photo|Φωτογραφία||Upload~Edit|400~150|940|300|2000|1~80~80~1:1', '3|textfield|photo_alt|Περιγραφή εικόνας||25'),
);
//travel
$box['12'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "type_box",
'title' => "Είδος Εκδρομής",
'fields' => array("3|autocomplete|travel_type1|Είδος 1||30||post_title~type|10|1", "3|autocomplete|travel_type2|Είδος 2||30||post_title~type|10|1", "3|autocomplete|travel_type3|Είδος 3||30||post_title~type|10|1", "3|autocomplete|travel_type4|Είδος 4||30||post_title~type|10|1", "3|autocomplete|travel_type5|Είδος 5||30||post_title~type|10|1")
);
//travel
$box['13'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "provider_box",
'title' => "Στοιχεία Προμηθευτή",
'fields' => array("3|autocomplete|travel_provider|Προμηθευτής||30||post_title~provider|10|1", '3|textfield|alternative_title|Εναλλακτικό όνομα εκδρομής||25')
);
//cruise
$box['14'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'duration_box',
'title' => 'Διάρκεια Κρουαζιέρας',
'fields' => array('3|textfield|duration_days|Μέρες||2', '3|textfield|duration_nights|Νύχτες||2', '1|textfield|post_category|Κατηγορία|5|2', '1|textfield|content_type|Content_type|cruise|25')
);
//cruise
$box['15'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "departure_box",
'title' => "Ημερομηνία Αναχώρησης",
'fields' => array("dates_num|date_start|date_end|date_monday|date_tuesday|date_wednesday|date_thursday|date_friday|date_saturday|date_sunday", "date|date_seats"),
'custom' => 'custom.php'
);
//cruise
$query_cruise_included = "SELECT DISTINCT meta_value FROM wp_postmeta WHERE (meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10') AND meta_value != ''";
$box['16'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "included_box",
'title' => "Περιλαμβάνονται",
'fields' => array("3|autocomplete|included1|||30|$query_cruise_included|meta_value|10|1", 
"3|autocomplete|included2|||30|$query_cruise_included|meta_value|10|1", 
"3|autocomplete|included3|||30|$query_cruise_included|meta_value|10|1", 
"3|autocomplete|included4|||30|$query_cruise_included|meta_value|10|1", 
"3|autocomplete|included5|||30|$query_cruise_included|meta_value|10|1", 
"3|autocomplete|included6|||30|$query_cruise_included|meta_value|10|1", 
"3|autocomplete|included7|||30|$query_cruise_included|meta_value|10|1", 
"3|autocomplete|included8|||30|$query_cruise_included|meta_value|10|1", 
"3|autocomplete|included9|||30|$query_cruise_included|meta_value|10|1", 
"3|autocomplete|included10|||30|$query_cruise_included|meta_value|10|1")
);
//cruise
$query_cruise_not_included = "SELECT DISTINCT meta_value FROM wp_postmeta WHERE (meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10') AND meta_value != ''";
$box['17'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "not_included_box",
'title' => "Δεν Περιλαμβάνονται",
'fields' => array("3|autocomplete|not_included1|||30|$query_cruise_not_included|meta_value|10|1", 
"3|autocomplete|not_included2|||30|$query_cruise_not_included|meta_value|10|1", 
"3|autocomplete|not_included3|||30|$query_cruise_not_included|meta_value|10|1", 
"3|autocomplete|not_included4|||30|$query_cruise_not_included|meta_value|10|1", 
"3|autocomplete|not_included5|||30|$query_cruise_not_included|meta_value|10|1", 
"3|autocomplete|not_included6|||30|$query_cruise_not_included|meta_value|10|1", 
"3|autocomplete|not_included7|||30|$query_cruise_not_included|meta_value|10|1", 
"3|autocomplete|not_included8|||30|$query_cruise_not_included|meta_value|10|1", 
"3|autocomplete|not_included9|||30|$query_cruise_not_included|meta_value|10|1", 
"3|autocomplete|not_included10|||30|$query_cruise_not_included|meta_value|10|1")
);
//cruise
$box['18'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "cruise_ship_box",
'title' => "Στοιχεία κρουαζιέρας",
'fields' => array("3|autocomplete|cruise_ship|Κρουαζιερόπλοιο||30||post_title~ship|10|1")
);
//cruise
$box['19'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "price_box",
'title' => "Τιμοκατάλογος",
'fields' => array('3|textfield|cabin_internal|Εσωτερική Καμπίνα||3', '3|textfield|cabin_internal_offer|Εσωτερική Καμπίνα (Προσφορά)||3', '3|textfield|cabin_see_view|Θέα στη θάλασσα||3', '3|textfield|cabin_see_view_offer|Θέα στη θάλασσα (Προσφορά)||3', '3|textfield|cabin_balcony|Με μπαλκόνι||3', '3|textfield|cabin_balcony_offer|Με μπαλκόνι (Προσφορά)||3', '3|textfield|cabin_suite|Σουίτα||3', '3|textfield|cabin_suite_offer|Σουίτα (Προσφορά)||3', 
'3|textfield|cabin_additional1|Επιπλέον 1||25', '3|textfield|cabin_additional_price1|Τιμή 1||28', '3|textfield|cabin_additional2|Επιπλέον 2||25', '3|textfield|cabin_additional_price2|Τιμή 2||28', '3|textfield|cabin_additional3|Επιπλέον 3||25', '3|textfield|cabin_additional_price3|Τιμή 3||28', '3|textfield|cabin_additional4|Επιπλέον 4||25', '3|textfield|cabin_additional_price4|Τιμή 4||28', '3|textfield|cabin_additional5|Επιπλέον 5||25', '3|textfield|cabin_additional_price5|Τιμή 5||28',
'3|textfield|cruise_additional1|Επιπλέον 1||25', '3|textfield|cruise_additional_price1|Τιμή 1||28', '3|textfield|cruise_additional2|Επιπλέον 2||25', '3|textfield|cruise_additional_price2|Τιμή 2||28', '3|textfield|cruise_additional3|Επιπλέον 3||25', '3|textfield|cruise_additional_price3|Τιμή 3||28', '3|textfield|cruise_additional4|Επιπλέον 4||25', '3|textfield|cruise_additional_price4|Τιμή 4||28', '3|textfield|cruise_additional5|Επιπλέον 5||25', '3|textfield|cruise_additional_price5|Τιμή 5||28')
);
//cruise
$box['20'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "destination_box",
'title' => "Προορισμοί",
'fields' => array("destinations", "level1_destination|level2_destination|level3_destination"),
'custom' => 'destination_custom.php'
);
//cruise
$box['21'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "provider_box",
'title' => "Προμηθευτής",
'fields' => array("3|autocomplete|cruise_provider|||30||post_title~provider|10|1")
);
//personal
$box['22'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "personal_type_box",
'title' => "Είδος Ταξιδιού",
'fields' => array('1|textfield|content_type|Content_type|personal|25', '3|autocomplete|personal_type1|Είδος 1||30||post_title~type|10|1', '3|autocomplete|personal_type2|Είδος 2||30||post_title~type|10|1', '3|autocomplete|personal_type3|Είδος 3||30||post_title~type|10|1', '3|autocomplete|personal_type4|Είδος 4||30||post_title~type|10|1', '3|autocomplete|personal_type5|Είδος 5||30||post_title~type|10|1')
);
//personal
$box['23'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "price_box",
'title' => "Τιμοκατάλογος",
'fields' => array(
'3|textfield|room_type1|Τύπος Δωματίου 1||30', 
'3|textfield|room_type1_period1|Περίοδος 1||10', '3|textfield|room_type1_period1_price|Δίκλινο||4', '3|textfield|room_type1_period1_extra_night|Extra νύχτα||4', '3|dropdown|room_type1_period1_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive', 
'3|textfield|room_type1_period2|Περίοδος 2||10', '3|textfield|room_type1_period2_price|Δίκλινο||4', '3|textfield|room_type1_period2_extra_night|Extra νύχτα||4', '3|dropdown|room_type1_period2_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type1_period3|Περίοδος 3||10', '3|textfield|room_type1_period3_price|Δίκλινο||4', '3|textfield|room_type1_period3_extra_night|Extra νύχτα||4', '3|dropdown|room_type1_period3_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type1_period4|Περίοδος 4||10', '3|textfield|room_type1_period4_price|Δίκλινο||4', '3|textfield|room_type1_period4_extra_night|Extra νύχτα||4', '3|dropdown|room_type1_period4_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type2|Τύπος Δωματίου 2||30', 
'3|textfield|room_type2_period1|Περίοδος 1||10', '3|textfield|room_type2_period1_price|Δίκλινο||4', '3|textfield|room_type2_period1_extra_night|Extra νύχτα||4', '3|dropdown|room_type2_period1_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive', 
'3|textfield|room_type2_period2|Περίοδος 2||10', '3|textfield|room_type2_period2_price|Δίκλινο||4', '3|textfield|room_type2_period2_extra_night|Extra νύχτα||4', '3|dropdown|room_type2_period2_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type2_period3|Περίοδος 3||10', '3|textfield|room_type2_period3_price|Δίκλινο||4', '3|textfield|room_type2_period3_extra_night|Extra νύχτα||4', '3|dropdown|room_type2_period3_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type2_period4|Περίοδος 4||10', '3|textfield|room_type2_period4_price|Δίκλινο||4', '3|textfield|room_type2_period4_extra_night|Extra νύχτα||4', '3|dropdown|room_type2_period4_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type3|Τύπος Δωματίου 3||30', 
'3|textfield|room_type3_period1|Περίοδος 1||10', '3|textfield|room_type3_period1_price|Δίκλινο||4', '3|textfield|room_type3_period1_extra_night|Extra νύχτα||4', '3|dropdown|room_type3_period1_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive', 
'3|textfield|room_type3_period2|Περίοδος 2||10', '3|textfield|room_type3_period2_price|Δίκλινο||4', '3|textfield|room_type3_period2_extra_night|Extra νύχτα||4', '3|dropdown|room_type3_period2_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type3_period3|Περίοδος 3||10', '3|textfield|room_type3_period3_price|Δίκλινο||4', '3|textfield|room_type3_period3_extra_night|Extra νύχτα||4', '3|dropdown|room_type3_period3_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type3_period4|Περίοδος 4||10', '3|textfield|room_type3_period4_price|Δίκλινο||4', '3|textfield|room_type3_period4_extra_night|Extra νύχτα||4', '3|dropdown|room_type3_period4_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type4|Τύπος Δωματίου 4||30', 
'3|textfield|room_type4_period1|Περίοδος 1||10', '3|textfield|room_type4_period1_price|Δίκλινο||4', '3|textfield|room_type4_period1_extra_night|Extra νύχτα||4', '3|dropdown|room_type4_period1_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive', 
'3|textfield|room_type4_period2|Περίοδος 2||10', '3|textfield|room_type4_period2_price|Δίκλινο||4', '3|textfield|room_type4_period2_extra_night|Extra νύχτα||4', '3|dropdown|room_type4_period2_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type4_period3|Περίοδος 3||10', '3|textfield|room_type4_period3_price|Δίκλινο||4', '3|textfield|room_type4_period3_extra_night|Extra νύχτα||4', '3|dropdown|room_type4_period3_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive',
'3|textfield|room_type4_period4|Περίοδος 4||10', '3|textfield|room_type4_period4_price|Δίκλινο||4', '3|textfield|room_type4_period4_extra_night|Extra νύχτα||4', '3|dropdown|room_type4_period4_food|Διατροφή||Όχι~no~Πρωινό~breakfast~Ημιδιατροφή~half~Πλήρης Διατροφή~full~All Inclusive~all_inclusive')
);
//personal
$box['24'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "destination_box",
'title' => "Προορισμοί",
'fields' => array("destinations", "level1_destination|level2_destination|level3_destination"),
'custom' => 'destination_custom.php'
);
//personal
$box['25'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "personal_additional_box",
'title' => "Επιπλέον Στοιχεία",
'fields' => array('3|textfield|personal_additional1|Επιπλέον 1||25', '3|textfield|personal_additional_price1|Τιμή 1||28', '3|textfield|personal_additional2|Επιπλέον 2||25', '3|textfield|personal_additional_price2|Τιμή 2||28', '3|textfield|personal_additional3|Επιπλέον 3||25', '3|textfield|personal_additional_price3|Τιμή 3||28', '3|textfield|personal_additional4|Επιπλέον 4||25', '3|textfield|personal_additional_price4|Τιμή 4||28', '3|textfield|personal_additional5|Επιπλέον 5||25', '3|textfield|personal_additional_price5|Τιμή 5||28')
);
//personal
$box['26'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "personal_hotel_box",
'title' => "Ξενοδοχείο",
'fields' => array('3|autocomplete|personal_hotel|||30||post_title~hotel|10|1')
);
//transport
$box['27'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "departure_box",
'title' => "Ημερομηνίες Αναχώρησης",
'fields' => array("dates_num|date_start|date_end|date_monday|date_tuesday|date_wednesday|date_thursday|date_friday|date_saturday|date_sunday", "date|date_return|date_seats"),
'custom' => 'transport_custom.php'
);
//transport
$box['28'] = array(
'place' => 'normal',
'priority' => 'high',
'name' => "info_box",
'title' => "Στοιχεία μεταφοράς",
'fields' => array('1|textfield|content_type|Content_type|transport|25', "3|textfield|company|Εταιρία||30", "3|textfield|departure_city|Πόλη αναχώρησης||20", "3|textfield|arrival_city|Πόλη προορισμού||20", "3|time|departure_time|Ώρα αναχώρησης|7~30|5", "3|time|arrival_time|Ώρα άφιξης|7~30|5", "3|textfield|connection_stop|Ενδιάμεσος Σταθμός||30", "3|dropdown|transport_type|Είδος Πτήσης|2|Αναχώρηση~departure~Επιστροφή~return"),
);
//ship
$box['29'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'company_box',
'title' => 'Εταιρία',
'fields' => array("3|autocomplete|company|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'company'|meta_value|10|1")
);
//ship
$box['30'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'destination_info_box',
'title' => 'Επιπλέον Πληροφορίες',
'fields' => array('3|textfield|additional1|Πληροφορία 1||25', '3|textfield|additional2|Πληροφορία 2||25', '3|textfield|additional3|Πληροφορία 3||25', '3|textfield|additional4|Πληροφορία 4||25', '3|textfield|additional5|Πληροφορία 5||25', '1|textfield|post_category|Κατηγορία|7|2', '1|textfield|content_type|Content_type|ship|25')
);
//ship
$box['31'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'photo_box',
'title' => 'Φωτογραφίες',
'fields' => array('3|photo_over|photo1|Φωτογραφία 1||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo2|Φωτογραφία 2||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo3|Φωτογραφία 3||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo4|Φωτογραφία 4||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo5|Φωτογραφία 5||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo6|Φωτογραφία 6||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo7|Φωτογραφία 7||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo8|Φωτογραφία 8||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo9|Φωτογραφία 9||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1', '3|photo_over|photo10|Φωτογραφία 10||Upload~Edit|400~150|2000|2000|2000|1~80~80~1:1')
);
//hotel
$box['32'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'info_box',
'title' => 'Πληροφορίες',
'fields' => array('1|textfield|content_type|Content_type|hotel|25', '3|dropdown|stars|Αστέρων|1|-~empty~*~1~**~2~***~3~****~4~*****~5', '3|checkbox|superior|Superior:|0|~superior', '3|textfield|hotel_link|Ιστοσελίδα Ξενοδοχείου||25')
);
//hotel
$box['33'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "destination_box",
'title' => "Προορισμοί",
'fields' => array("destinations", "level1_destination|level2_destination|level3_destination"),
'custom' => 'destination_custom.php'
);
//type
$box['34'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'info_box',
'title' => 'Πληροφορίες',
'fields' => array('1|textfield|content_type|Content_type|type|25')
);
//provider
$box['35'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'info_box',
'title' => 'Πληροφορίες',
'fields' => array('3|textfield|phone|Τηλέφωνο||25', '3|textfield|email|Email||25', '3|textfield|name|Όνομα||25', '1|textfield|content_type|Content_type|type|25')
);
//new
$box['36'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'destinations_box',
'title' => 'Σχετικοί Προορισμοί',
'fields' => array('1|textfield|content_type|Content_type|new|25', "3|autocomplete|destination1|Προορισμός 1||30||post_title~destination|1000|1", "3|autocomplete|destination2|Προορισμός 2||30||post_title~destination|1000|1", "3|autocomplete|destination3|Προορισμός 3||30||post_title~destination|1000|1", "3|autocomplete|destination4|Προορισμός 4||30||post_title~destination|1000|1", "3|autocomplete|destination5|Προορισμός 5||30||post_title~destination|1000|1")
);
//home
$box['37'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'image_box',
'title' => 'Φωτογραφίες',
'fields' => array("3|autocomplete|photo_title1|Title 1||30||post_title~travel|1000|1", "3|textfield|photo_link1|Link 1||25", "3|photo_over|homepage_photo1|Φωτογραφία 1||Upload~Edit|400~150|940|300|2000|1~80~80~1:1", "3|autocomplete|photo_title2|Title 2||30||post_title~travel|1000|1", "3|textfield|photo_link2|Link 2||25", "3|photo_over|homepage_photo2|Φωτογραφία 2||Upload~Edit|400~150|940|300|2000|1~80~80~1:1", "3|autocomplete|photo_title3|Title 3||30||post_title~travel|1000|1", "3|textfield|photo_link3|Link 3||25", "3|photo_over|homepage_photo3|Φωτογραφία 3||Upload~Edit|400~150|940|300|2000|1~80~80~1:1")
);
//home
$box['38'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'destinations_box',
'title' => 'Δημοφιλείς προορισμοί',
'fields' => array("3|autocomplete|popular_destination1|||30||post_title~destination|1000|1", "3|autocomplete|popular_destination2|||30||post_title~destination|1000|1", "3|autocomplete|popular_destination3|||30||post_title~destination|1000|1", "3|autocomplete|popular_destination4|||30||post_title~destination|1000|1", "3|autocomplete|popular_destination5|||30||post_title~destination|1000|1", "3|autocomplete|popular_destination6|||30||post_title~destination|1000|1", "3|autocomplete|popular_destination7|||30||post_title~destination|1000|1")
);
//home
$box['39'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'proposed_box',
'title' => 'Οι προτάσεις μας',
'fields' => array("3|autocomplete|proposed_travel1|Τίτλος 1||30||post_title~travel|1000|1", "3|textfield|proposed_title1|Εμφανιζόμενο Όνομα 1||25", "3|autocomplete|proposed_travel2|Τίτλος 2||30||post_title~travel|1000|1", "3|textfield|proposed_title2|Εμφανιζόμενο Όνομα 2||25", "3|autocomplete|proposed_travel3|Τίτλος 3||30||post_title~travel|1000|1", "3|textfield|proposed_title3|Εμφανιζόμενο Όνομα 3||25", "3|autocomplete|proposed_travel4|Τίτλος 4||30||post_title~travel|1000|1", "3|textfield|proposed_title4|Εμφανιζόμενο Όνομα 4||25", "3|autocomplete|proposed_travel5|Τίτλος 5||30||post_title~travel|1000|1", "3|textfield|proposed_title5|Εμφανιζόμενο Όνομα 5||25",)
);
//home
$box['40'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'types_box',
'title' => 'Είδη Ταξιδιού',
'fields' => array("3|autocomplete|type1|Είδος 1||30||post_title~type|1000|1", "3|textfield|type_title1|Εμφανιζόμενο Όνομα 1||25", "3|autocomplete|type2|Είδος 2||30||post_title~type|1000|1", "3|textfield|type_title2|Εμφανιζόμενο Όνομα 2||25", "3|autocomplete|type3|Είδος 3||30||post_title~type|1000|1", "3|textfield|type_title3|Εμφανιζόμενο Όνομα 3||25", "3|autocomplete|type4|Είδος 4||30||post_title~type|1000|1", "3|textfield|type_title4|Εμφανιζόμενο Όνομα 4||25", "3|autocomplete|type5|Είδος 5||30||post_title~type|1000|1", "3|textfield|type_title5|Εμφανιζόμενο Όνομα 5||25", "3|autocomplete|type6|Είδος 6||30||post_title~type|1000|1", "3|textfield|type_title6|Εμφανιζόμενο Όνομα 6||25", "3|autocomplete|type7|Είδος 7||30||post_title~type|1000|1", "3|textfield|type_title7|Εμφανιζόμενο Όνομα 7||25", "3|autocomplete|type8|Είδος 8||30||post_title~type|1000|1", "3|textfield|type_title8|Εμφανιζόμενο Όνομα 8||25")
);
//home
$box['41'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'banner_box',
'title' => 'Banners',
'fields' => array(
"3|textfield|banner_title1|Title 1||25", "3|textfield|banner_link1|Link 1||25", "3|photo_over|banner_photo1|Φωτογραφία 1||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active1|Χρήση|1|Ενεργό~active~Ανενεργό~disabled', 
"3|textfield|banner_title2|Title 2||25", "3|textfield|banner_link2|Link 2||25", "3|photo_over|banner_photo2|Φωτογραφία 2||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active2|Χρήση|1|Ενεργό~active~Ανενεργό~disabled', 
"3|textfield|banner_title3|Title 3||25", "3|textfield|banner_link3|Link 3||25", "3|photo_over|banner_photo3|Φωτογραφία 3||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active3|Χρήση|1|Ενεργό~active~Ανενεργό~disabled', 
"3|textfield|banner_title4|Title 4||25", "3|textfield|banner_link4|Link 4||25", "3|photo_over|banner_photo4|Φωτογραφία 4||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active4|Χρήση|1|Ενεργό~active~Ανενεργό~disabled', 
"3|textfield|banner_title5|Title 5||25", "3|textfield|banner_link5|Link 5||25", "3|photo_over|banner_photo5|Φωτογραφία 5||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active5|Χρήση|1|Ενεργό~active~Ανενεργό~disabled', 
"3|textfield|banner_title6|Title 6||25", "3|textfield|banner_link6|Link 6||25", "3|photo_over|banner_photo6|Φωτογραφία 6||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active6|Χρήση|1|Ενεργό~active~Ανενεργό~disabled',
"3|textfield|banner_title7|Title 7||25", "3|textfield|banner_link7|Link 7||25", "3|photo_over|banner_photo7|Φωτογραφία 7||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active7|Χρήση|1|Ενεργό~active~Ανενεργό~disabled', 
"3|textfield|banner_title8|Title 8||25", "3|textfield|banner_link8|Link 8||25", "3|photo_over|banner_photo8|Φωτογραφία 8||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active8|Χρήση|1|Ενεργό~active~Ανενεργό~disabled', 
"3|textfield|banner_title9|Title 9||25", "3|textfield|banner_link9|Link 9||25", "3|photo_over|banner_photo9|Φωτογραφία 9||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active9|Χρήση|1|Ενεργό~active~Ανενεργό~disabled', 
"3|textfield|banner_title10|Title 10||25", "3|textfield|banner_link10|Link 10||25", "3|photo_over|banner_photo10|Φωτογραφία 10||Upload~Edit|400~150|225|112|2000|1~80~80~1:1", '3|dropdown|banner_active10|Χρήση|1|Ενεργό~active~Ανενεργό~disabled')
);




//general options
$language = 'en';
?>
