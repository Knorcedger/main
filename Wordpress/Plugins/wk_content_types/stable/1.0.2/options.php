<?php

//'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', and 'custom-fields'
//$box place:[side, normal], priority:[low, high], fields:by wk_submit

/*Χρήση custom: 
'fields' => array("destinations|level1_destination", "level2_destination|level3_destination"),
Η πρώτη μεταβλητή λέει πόσα loops πρέπει να κάνει το for για να μαζέψει μεταβλητές από τις μεταβλητές μετά το κόμμα.
Οι υπόλοιπες μεταβλητές πριν το κομμα, είναι απλές μεταβλητές.
Οι μεταβλητές μετά το κόμμα είναι του τύπου level2_destination0, level2_destination1...
*/

//our content types
$types = array(
	array('article', 'Articles', array('title', 'editor', 'comments', 'revisions', 'author', 'excerpt', 'thumbnail')), 
	array('offer', 'Hot Offers', array('title', 'editor', 'thumbnail'))
);

$boxes['article'] = array(
	array(
		'place' => 'side',
		'priority' => 'high',
		'name' => 'url_box',
		'title' => 'Article Source',
		'fields' => array('3|textfield|url|||25')
	), array(
		'place' => 'side',
		'priority' => 'high',
		'name' => 'review_rating_box',
		'title' => 'Rating',
		'fields' => array('3|dropdown|review_rating||1|*~2~**~4~***~6~****~8~*****~10')
	)
);
$boxes['offer'] = array(
	array(
		'place' => 'normal',
		'priority' => 'high',
		'name' => 'duration_box3',
		'title' => 'Διάρκεια Εκδρομής με αυτοκίνητο',
		'fields' => array('3|textfield|duration_days1|ΜέρεςS||2', '3|textfield|duration_nights2|ΝύχτεςS||2')
	), array(
		'place' => 'normal',
		'priority' => 'high',
		'name' => 'duration_box4',
		'title' => 'Ποια Εκδρομή;',
		'fields' => array('3|textfield|duration_days3|Μέρες||2', '3|textfield|duration_nights4|Νύχτες||2')
	)
);


//general options
$language = 'en';
?>
