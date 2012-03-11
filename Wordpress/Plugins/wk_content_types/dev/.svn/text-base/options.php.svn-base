<?php

//Γενικά όλα πρέπει να ακολουθούν την σειρά με την οποία έχουμε ορίσει τα content types στον πινακα $names

//$pages parent|Name|Name|capability|url
//$hide allowed values: postdivrich, postexcerpt, trackbacksdiv, postcustom, commentstatusdiv, authordiv, tagsdiv, categorydiv
//$box place:[side, normal], priority:[low, high], fields:by wk_submit

//our content types
$names = array('new', 'external-new', 'review', 'event', 'video', 'company', 'business-new', 'hot-offer');
$pages = array(
'post-new.php|Add Article|Add Article|publish_posts|post-new.php?type=new',
'post-new.php|Add Linked Article|Add Linked Article|publish_posts|post-new.php?type=external-new',
'post-new.php|Add Review|Add Review|publish_posts|post-new.php?type=review',
'post-new.php|Add Event|Add Event|publish_posts|post-new.php?type=event',
'post-new.php|Add Video|Add Video|publish_posts|post-new.php?type=video',
'post-new.php|Add Company|Add Company|publish_posts|post-new.php?type=company',
'post-new.php|Add Business New|Add Business New|publish_posts|post-new.php?type=business-new',
'post-new.php|Add Hot Offer|Add Hot Offer|publish_posts|post-new.php?type=hot-offer'
);
$hide = array(
'postexcerpt|trackbacksdiv|postcustom|commentstatusdiv|authordiv',
'postexcerpt|trackbacksdiv|postcustom|commentstatusdiv|authordiv',
'postexcerpt|trackbacksdiv|postcustom|commentstatusdiv|authordiv',
'postexcerpt|trackbacksdiv|postcustom|commentstatusdiv|authordiv|tagsdiv|categorydiv',
'postexcerpt|trackbacksdiv|postcustom|commentstatusdiv|authordiv',
'postexcerpt|trackbacksdiv|postcustom|commentstatusdiv|authordiv|tagsdiv|categorydiv',
'postexcerpt|trackbacksdiv|postcustom|commentstatusdiv|authordiv',
);

//the number of boxes that each page has
$boxes['new'] = 1;
$boxes['external-new'] = 2;
$boxes['review'] = 3;
$boxes['event'] = 3;
$boxes['video'] = 0;
$boxes['company'] = 2;
$boxes['business-new'] = 2;
$boxes['hot-offer'] = 0;


//
$box['0']['place'] = 'side';
$box['0']['priority'] = 'high';
$box['0']['name'] = "photo_box";
$box['0']['title'] = "Meta Images";
$box['0']['fields'] = array('3|photo_over|new_photo|Article Image||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|new_featured_photo|Featured Image||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|checkbox|featured|Featured|0|~featured');
//
$box['1']['place'] = 'side';
$box['1']['priority'] = 'high';
$box['1']['name'] = "photo_box";
$box['1']['title'] = "Article Image";
$box['1']['fields'] = array('3|photo_over|external_new_photo|Image||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1');
//
$box['2']['place'] = 'side';
$box['2']['priority'] = 'high';
$box['2']['name'] = "external_new_url_box";
$box['2']['title'] = "Article Source";
$box['2']['fields'] = array('3|textfield|external_new_url|||28');
//
$box['3']['place'] = 'side';
$box['3']['priority'] = 'high';
$box['3']['name'] = "photo_box";
$box['3']['title'] = "Photo Gallery";
$box['3']['fields'] = array('3|photo_over|review_photo1|1st Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo2|2nd Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo3|3rd Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo4|4th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo5|5th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo6|6th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo7|6th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo8|7th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo9|9th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo10|10th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo11|11st Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo12|12nd Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo13|13rd Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo14|14th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo15|15th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo16|16th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo17|17th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo18|18th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo19|19th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1', '3|photo_over|review_photo20|20th Photo||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1');
//
$box['4']['place'] = 'side';
$box['4']['priority'] = 'high';
$box['4']['name'] = "review_rating_box";
$box['4']['title'] = "Rating";
$box['4']['fields'] = array('3|dropdown|review_rating||1|*~1~**~2~***~3~****~4~*****~5');
//
$box['5']['place'] = 'side';
$box['5']['priority'] = 'high';
$box['5']['name'] = "review_company_box";
$box['5']['title'] = "Company";
$box['5']['fields'] = array('3|autocomplete|review_company|||30||post_title~company', '3|checkbox|featured|Featured|0|~featured');
//
$box['6']['place'] = 'side';
$box['6']['priority'] = 'high';
$box['6']['name'] = "event_place_box";
$box['6']['title'] = "Hosted";
$box['6']['fields'] = array('3|textfield|address|Address||28', '3|textfield|address_number|Number||28', '3|textfield|city|City||28', '3|textfield|general|General Name||28');
//
$box['7']['place'] = 'side';
$box['7']['priority'] = 'high';
$box['7']['name'] = "event_date_box";
$box['7']['title'] = "Dates";
$box['7']['fields'] = array('3|date|date_start|Start Date|', '3|date|date_end|End Date|', '3|date|date_single|or Single Date|');
//
$box['8']['place'] = 'side';
$box['8']['priority'] = 'high';
$box['8']['name'] = "event_company_box";
$box['8']['title'] = "Company";
$box['8']['fields'] = array('3|autocomplete|event_company|||30||post_title~company');
//video
//
$box['9']['place'] = 'side';
$box['9']['priority'] = 'high';
$box['9']['name'] = "photo_box";
$box['9']['title'] = "Logo";
$box['9']['fields'] = array('3|photo_over|company_photo|Image||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1');
//
$box['10']['place'] = 'side';
$box['10']['priority'] = 'high';
$box['10']['name'] = "company_url_box";
$box['10']['title'] = "Website";
$box['10']['fields'] = array('3|textfield|company_url|URL||28');
//
$box['11']['place'] = 'side';
$box['11']['priority'] = 'high';
$box['11']['name'] = "photo_box";
$box['11']['title'] = "Business article image";
$box['11']['fields'] = array('3|photo_over|business_new_photo|Image||Upload~Edit|400~150|1000|1000|300|1~80~80~1:1');
//
$box['12']['place'] = 'side';
$box['12']['priority'] = 'high';
$box['12']['name'] = "business_new_company_box";
$box['12']['title'] = "Company";
$box['12']['fields'] = array('3|autocomplete|business_new_company|||30||post_title~company');



//general options
$language = 'en';
?>