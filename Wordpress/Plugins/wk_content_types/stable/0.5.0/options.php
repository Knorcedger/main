<?php

//Γενικά όλα πρέπει να ακολουθούν την σειρά με την οποία έχουμε ορίσει τα content types στον πινακα $names

//$pages parent|Name|Name|capability|url
//$hide allowed values: postdivrich, postexcerpt, trackbacksdiv, postcustom, commentstatusdiv, authordiv, tagsdiv, categorydiv
//$box place:[side, normal], priority:[low, high], fields:by wk_submit

//our content types
$names = array('area', 'offer', 'gossip');
$pages = array('post-new.php|Area|Area|publish_posts|post-new.php?type=area','post-new.php|Offer|Offer|publish_posts|post-new.php?type=offer', 'post-new.php|Gossip|Gossip|import|post-new.php?type=gossip');
$hide = array('postexcerpt|trackbacksdiv|postcustom|commentstatusdiv|authordiv|tagsdiv|categorydiv', 'postexcerpt|trackbacksdiv|postcustom|commentstatusdiv|authordiv|tagsdiv|categorydiv', 'postexcerpt');

//the number of boxes that each page has
$boxes['area'] = 2;
$boxes['offer'] = 1;
$boxes['gossip'] = 0;

//first content type box
$box['0']['place'] = 'side';
$box['0']['priority'] = 'low';
$box['0']['name'] = "sidebox";
$box['0']['title'] = "Area box";
$box['0']['fields'] = array('3|textfield|areabox|Perioxi||30', '3|textfield|flipbox|Perioxi2||30');
//second content type box
$box['1']['place'] = 'side';
$box['1']['priority'] = 'low';
$box['1']['name'] = "storebox";
$box['1']['title'] = "Δοκιμαστικό κουτί";
$box['1']['fields'] = array('3|textfield|store|Mgazi||30');
//third content type box
$box['2']['place'] = 'normal';
$box['2']['priority'] = 'low';
$box['2']['name'] = "normalbox";
$box['2']['title'] = "Ακόμα ένα κουτάκι";
$box['2']['fields'] = array('3|textfield|store|Mgazi||30');

//general options
$language = 'gr';
?>