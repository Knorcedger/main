<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

$id = $_POST['id'];
$title = $_POST['title'];
$slug = $_POST['slug'];
$description = $_POST['description'];
$image = '';

//find the url of the current referer
$referer = $_SERVER['HTTP_REFERER'];
$end = strpos($referer, "/", 9);
if ($end != "") {
	$url = substr($referer, 0, $end);
} else {
	$url = $referer;
}

//find the correct referer
$correct_referer = get_option('home');

if ($url == $correct_referer) {

	$options_serialized = get_option('wk_cms');
	$options = unserialize($options_serialized);

	/*options structure
	$options = [0=>first_id, 1=>first_title, 2=>first_slug, 3=>first_description, 4=>first_image, 5=>second_title...]
	*/

	if($options == ''){
		$options = array();
		$id = 1;
		array_push($options, $id, $title, $slug, $description, $image);
		$options_serialized = serialize($options);
		add_option('wk_cms', $options_serialized);
	}else{
		//check if its an edit or a new one
		if($id != ''){
			$key = array_search($id, $options);
			$options[$key+1] = $title;
			$options[$key+2] = $slug;
			$options[$key+3] = $description;
			$options[$key+4] = $image;
		}else{
			$items = sizeof($options)/5;
			$id = $items+1;
			array_push($options, $id, $title, $slug, $description, $image);
		}
		//serialize and save
		$options_serialized = serialize($options);
		update_option('wk_cms', $options_serialized);
	}
}

$temp = explode('&', $referer);
$referer_simple = $temp[0];
header("Location: $referer_simple&status=saved");

?>
