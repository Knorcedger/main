<?php
include_once '../../../wp-config.php';

$user_id = $_POST['user_id'];
$post_status = $_POST['post_status'];

$vars_send = $_POST['vars_send'];
$vars = explode('|', $vars_send);

$vars_hidden = $_POST['vars_hidden'];
$vars2 = explode('|', $vars_hidden);

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
	// Create post object
	$mypost = array();
	$mypost['post_status'] = $post_status;
	$mypost['post_author'] = $user_id;
	//add the special values
	foreach ($vars as $val) {
		if($val == 'post_title'){
			$mypost['post_title'] = $_POST[$val];
		}elseif($val == 'post_content'){
			$mypost['post_content'] = $_POST[$val];
		}elseif($val == 'post_category'){
			$mypost['post_category'] = array($_POST[$val]);
		}elseif($val == 'tags_input'){
			$mypost['tags_input'] = $_POST[$val];
		}
	}
	//post_title and post_content are necessary, so fill them if empty
	if($mypost['post_title'] == ''){
		$mypost['post_title'] = substr(md5(uniqid(microtime())), 0, 6);
	}
	if($mypost['post_content'] == ''){
		$mypost['post_content'] = 'dummy content';
	}
	//insert post
	$result = wp_insert_post( $mypost );
	if($result != 0){
		//add remaining fields here, because we need the post id
		foreach ($vars as $val) {
			if($val != 'post_title' && $val != 'post_content' && $val != 'post_category' && $val != 'tags_input'){
				add_post_meta($result, $val, $_POST[$val], true);
			}
		}
		//and now we have to add the hidden vars, but also create the param string to add to redirect url
		$params = '';
		foreach ($vars2 as $val) {
			add_post_meta($result, $val, $_POST[$val], true);
			$params .= '&' . $val . '=' . $_POST[$val];
		}
		//add special value entry_type
		add_post_meta($result, 'entry_type', $entry_type, true);
		//redirect
		header("Location: $correct_referer/?p=$result&status=submit_success$params");
	}else{
		header("Location: $correct_referer?status=submit_error");
	}
}
?>