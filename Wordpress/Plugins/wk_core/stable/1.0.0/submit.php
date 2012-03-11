<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php';

/*
//user_id, object_type, post_status (when object_type=post), redirect (when object_type=user) are always sent as hidden values
$user_id = $_POST['user_id'];
$post_status = $_POST['post_status'];
$object_id = $_POST['object_id'];
$object_type = $_POST['object_type'];
//$redirect = $_POST['redirect'];


//those are the names of all the values we sent
$vars_send = $_POST['vars_send'];
$vars = explode('|', $vars_send);

//those are the names of all the hidden values we sent
$vars_hidden = $_POST['vars_hidden'];
$vars2 = explode('|', $vars_hidden);
*/

//we save the posted variables into a real array
$vars = $_POST;

//we save the vars that wont be stored
foreach ($vars as $key => $val) {
	//echo $key . "  $val<br>";
	if($key == 'user_id'){
		$user_id = $val;
	}elseif($key == 'object_id'){
		$object_id = $val;
	}elseif($key == 'object_type'){
		$object_type = $val;
	}
}
//echo $user_id.$object_id.$object_type;


//find the url of the current referer
$referer = $_SERVER['HTTP_REFERER'];
$end = strpos($referer, "/", 9);
if ($end != "") {
	$url = substr($referer, 0, $end);
} else {
	$url = $referer;
}
//echo $object_id;

//find the correct referer
$correct_referer = get_option('home');

if ($url == $correct_referer) {
	//check if it is a post or a user
	if($object_type == 'post'){
		//Create post object
		$mypost = array();
		$mypost['post_status'] = 'publish'; //$post_status;
		$mypost['post_author'] = $user_id;
		//add the special values
		foreach ($vars as $key => $val) {
			if($key == 'post_title'){
				$mypost['post_title'] = $val;
			}elseif($key == 'post_content'){
				$mypost['post_content'] = $val;
			}elseif($key == 'post_category'){
				$mypost['post_category'] = array($val);
			}elseif($key == 'tags_input'){
				$mypost['tags_input'] = $val;
			}
		}
		//post_title and post_content are necessary, so fill them if empty
		if($mypost['post_title'] == ''){
			$mypost['post_title'] = substr(md5(uniqid(microtime())), 0, 6);
		}
		if($mypost['post_content'] == ''){
			$mypost['post_content'] = 'empty';
		}
		
		//check if object_id=0 then its a new post, else its edit
		if($object_id == '0'){
			//echo 'in';
			//submit post
			$result = wp_insert_post( $mypost );
			if($result != 0){
				//add remaining fields here, because we need the post id
				foreach ($vars as $key => $val) {
					if($key != 'post_title' && $key != 'post_content' && $key != 'post_category' && $key != 'tags_input' && $key != 'user_id' && $key != 'object_id' && $key != 'object_type'){
						add_post_meta($result, $key, $val, true);
					}
				}
				/*
				//and now we have to add the hidden vars, but also create the param string to add to redirect url
				$params = '';
				foreach ($vars2 as $val) {
					add_post_meta($result, $val, $_POST[$val], true);
					$params .= '&' . $val . '=' . $_POST[$val];
				}
				*/
				//redirect
				header("Location: $correct_referer/?p=$result&status=submit_success$params");
			}else{
				header("Location: $correct_referer?status=submit_error");
			}
		}else{
			//echo 'in2';
			//add the post id we want to edit
			$mypost['ID'] = $object_id;
			//update post
			$result = wp_update_post( $mypost );
			//echo $result;
			if($result != 0){
				//add remaining fields here, because we need the post id
				foreach ($vars as $key => $val) {
					if($key != 'post_title' && $key != 'post_content' && $key != 'post_category' && $key != 'tags_input' && $key != 'user_id' && $key != 'object_id' && $key != 'object_type'){
						update_post_meta($result, $key, $val);
					}
				}
				/*
				//and now we have to add the hidden vars, but also create the param string to add to redirect url
				$params = '';
				foreach ($vars2 as $val) {
					update_post_meta($result, $val, $_POST[$val], true);
					$params .= '&' . $val . '=' . $_POST[$val];
				}
				*/
				//redirect
				header("Location: $correct_referer/?p=$result&status=edit_success$params");
			}else{
				header("Location: $correct_referer?status=edit_error");
			}
		}
	}elseif($object_type == 'user'){
		foreach ($vars as $key => $val) {
			//add data to usermeta
			update_usermeta($object_id, $key, $val);
		}
		/*
		//if redirect has params, use &
		if (strstr($redirect, '?')) {
			$char = '&';
		} else {
			$char = '?';
		}
		*/
		$base = get_option('home') . '/?author=' . $object_id;
		$location = $base . '&status=profile_updated';
		//$location = $redirect . $char . 'status=profile_updated';
		header("Location: $location");
	}
}
?>