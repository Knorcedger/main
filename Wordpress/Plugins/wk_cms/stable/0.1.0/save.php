<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-admin/admin.php');

//print_r($_POST);
//require 'fire.php';

$cat_ID = $_POST['cat_ID'];
$cat_name = $_POST['cat_name'];
$category_nicename = $_POST['category_nicename'];
$category_description = $_POST['category_description'];
$wk_cms = $_POST['wk_cms'];

$_POST['category_description'] .= '|'. $_POST['wk_cms'];


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

	
	if($_POST['cat_ID'] != '0'){
		wp_update_category($_POST);
	}else{

		$mycat = array('cat_name' => $_POST['cat_name'], 'category_description' => $_POST['category_description'], 'category_nicename' => $_POST['category_nicename'], 'category_parent' => '');

		// Create the category
		$mycat_id = wp_insert_category($mycat);
	}

	/*
	$options_serialized = get_option('wk_cms');
	$options = unserialize($options_serialized);

	/*options structure
	$options = [0=>first_id, 1=>first_title, 2=>first_slug, 3=>first_description, 4=>first_image, 5=>second_title...]
	*/
/*
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
	*/
}

$temp = explode('&', $referer);
$referer_simple = $temp[0];
header("Location: $referer_simple&status=saved");

?>
