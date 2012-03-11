<?php

//Γενικά όλα πρέπει να ακολουθούν την σειρά με την οποία έχουμε ορίσει τα content types στον πινακα $names

//$pages parent|Name|Name|capability|url
//$hide allowed values: postdivrich, postexcerpt, trackbacksdiv, postcustom, commentstatusdiv, commentsdiv (appears only in edit), authordiv, tagsdiv, categorydiv
//$box place:[side, normal], priority:[low, high], fields:by wk_submit


//our content types
$names = array('travel');
$pages = array(
'post-new.php|Νέα Εκδρομή|Νέα Εκδρομή|publish_posts|post-new.php?type=travel'
);
$hide = array(
'trackbacksdiv|postcustom|postexcerpt|commentstatusdiv|commentsdiv|authordiv'
);

//the number of boxes that each page has
$boxes['travel'] = 7;


//travel
$box['0'] = array(
'place' => 'side',
'priority' => 'high',
'name' => 'duration_box',
'title' => 'Διάρκεια Εκδρομής',
'fields' => array('3|textfield|duration_days|Μέρες||2', '3|textfield|duration_nights|Νύχτες||2', '1|textfield|post_category|Κατηγορία|3|2', '1|textfield|content_type|Content_type|travel|25')
);
//travel
$box['1'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "departure_box",
'title' => "Ημερομηνία Αναχώρησης",
'fields' => array("3|date|departure_date1||1~1~2009", "3|textfield|departure_day1|Μέρα||25")
);
//travel
$box['2'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "included_box",
'title' => "Περιλαμβάνονται",
'fields' => array("3|autocomplete|included1|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value", "3|autocomplete|included2|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value", "3|autocomplete|included3|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value", "3|autocomplete|included4|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value", "3|autocomplete|included5|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value", "3|autocomplete|included6|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value", "3|autocomplete|included7|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value", "3|autocomplete|included8|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value", "3|autocomplete|included9|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value", "3|autocomplete|included10|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'included1' OR  meta_key = 'included2' OR  meta_key = 'included3' OR  meta_key = 'included4' OR  meta_key = 'included5' OR  meta_key = 'included6' OR  meta_key = 'included7' OR  meta_key = 'included8' OR  meta_key = 'included9' OR  meta_key = 'included10'|meta_value")
);
//travel
$box['3'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "not_included_box",
'title' => "Δεν Περιλαμβάνονται",
'fields' => array("3|autocomplete|not_included1|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value", "3|autocomplete|not_included2|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value", "3|autocomplete|not_included3|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = 'not_included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value", "3|autocomplete|not_included4|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value", "3|autocomplete|not_included5|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value", "3|autocomplete|not_included6|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value", "3|autocomplete|not_included7|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value", "3|autocomplete|not_included8|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value", "3|autocomplete|not_included9|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value", "3|autocomplete|not_included10|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'not_included1' OR  meta_key = 'not_included2' OR  meta_key = 'not_included3' OR  meta_key = 'not_included4' OR  meta_key = 'not_included5' OR  meta_key = not_'included6' OR  meta_key = 'not_included7' OR  meta_key = 'not_included8' OR  meta_key = 'not_included9' OR  meta_key = 'not_included10'|meta_value")
);
//travel
$box['4'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "flights_box",
'title' => "Πτήσεις",
'fields' => array('3|textfield|flight_company|Αεροπορική εταιρία||25', '3|textfield|original_city1|Πόλη Αναχώρησης||25', '3|textfield|arrival_city1|Πόλη Προορισμού||25', '3|time|flight_departure1|Αναχώρηση|7~30|5', '3|time|flight_arrival1|Άφιξη|7~30|5', '3|textfield|original_city2|Πόλη Αναχώρησης||25', '3|textfield|arrival_city2|Πόλη Προορισμού||25', '3|time|flight_departure2|Αναχώρηση|7~30|5', '3|time|flight_arrival2|Άφιξη|7~30|5')
);
//travel
$box['5'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "additional_box",
'title' => "Πρόσθετες Πληροφορίες",
'fields' => array('3|textarea|additional_text|||20|5', "3|autocomplete|additional1|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value", "3|autocomplete|additional2|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value", "3|autocomplete|additional3|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value", "3|autocomplete|additional4|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value", "3|autocomplete|additional5|||30|SELECT * FROM wp_postmeta WHERE meta_key = 'additional1' OR  meta_key = 'additional2' OR  meta_key = 'additional3' OR  meta_key = 'additional4' OR  meta_key = 'additional5'|meta_value")
);
//travel
$box['6'] = array(
'place' => 'side',
'priority' => 'high',
'name' => "prices_box",
'title' => "Τιμοκατάλογος",
'fields' => array('3|textfield|hotel1|Ξενοδοχείο||25', '3|dropdown|stars1|Αστέρων|1|-~empty~*~1~**~2~***~3~****~4~*****~5', '3|dropdown|stars_multi1|Αστέρων|1|-~empty~*/**~12~**/***~23~***/****~34~****/*****~45', '3|textfield|hotel1_room1|Μονόκλινο||25', '3|textfield|hotel1_room2|Δίκλινο||25', '3|textfield|hotel1_room3|Τρίκλινο||25', '3|textfield|hotel1_child|Παιδικό||25', '3|textfield|hotel1_child_age|Παιδική ηλικία||25', '3|textfield|hotel1_airport_taxes|Φόροι Αεροδρομίου||25', '3|textfield|hotel1_additional1|Επιπλέον||25', '3|textfield|hotel1_additional1_price1|Τιμή||28')
);




//general options
$language = 'en';
?>
