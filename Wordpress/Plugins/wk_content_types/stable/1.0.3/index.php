<?php
/* 
 Plugin Name: wk_content_types
 Plugin URI: http://knorcedger.com
 Description: Content type test
 Version: 1.0.3
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
function wk_content_types() {
}

add_action('init', 'types_register');

function types_register() {

	//fetch options
	require $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_content_types/options.php';
	
	foreach($types as $type){
		//print_r($type);
	 	$args = array(
		  	'label' => __($type[1]),
		  	'singular_label' => __('Product'),
		  	'public' => true,
		  	'show_ui' => true,
		  	'capability_type' => 'post',
		  	'hierarchical' => false,
		  	'rewrite' => true,
		  	'supports' => $type[2]
		  );

	 	register_post_type( $type[0] , $args );
	 	
	 }
}

//add external css and javascript
add_action("admin_footer", "add_external");
function add_external() {
	?>
	<link rel="stylesheet" href="/wp-content/plugins/wk_content_types/style.css" type="text/css" media="screen" charset="utf-8" />
<?php
	require $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_content_types/script.php';
}

//add the action of creating the meta box
$box_id = 0;
$ct = '';
add_action('admin_menu', 'add_box');
function add_box() {
	global $box_id;
	global $wpdb;
	global $ct;
	require $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_content_types/options.php';
	//add the boxes for this post type
	foreach($types as $type){
		//box_id is used to identify the box we are now displaying for each type
		$box_id = 0;
		for($i=0; $i<sizeof($boxes[$type[0]]); $i++){
			$box = $boxes[$type[0]][$i];
			$ct = $type[0];
			add_meta_box($box['name'], $box['title'], 'add_fields', $type[0], $box['place'], $box['priority']);
		}
	}
}

//add the meta boxes
function add_fields(){
	global $box_id;
	//find content type
	$ct = $_GET['post_type'];
	if($ct == ''){
		$ct = get_post_type($_GET['post']);
	}
	require $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_content_types/options.php';
	//define the box
	$box = $boxes[$ct][$box_id];
	//add the fields for this box
	$fields = $box['fields'];
	//core needed values
	$path = '../wp-content/plugins/wk_core/';
	//send object_id
	if($_GET['post'] != ''){
		$object_id = intval($_GET['post']);
	}else{
		$object_id = 0;
	}
	$object_type = 'post';
	$language = 'gr';
	include $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_core/field_loop.php';
	//include the custom (external) code
	if($box['custom'] != ''){
		include $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_content_types/custom/' . $box['custom'];
	}
	$box_id++;
}

//save data
add_action('save_post', 'save_data');
function save_data($post_ID) {
	global $wpdb;
	global $box_id;
	
	if(!wp_is_post_revision($post_ID) && is_admin()) {
		$ct = $_POST['post_type'];
		//require 'fire.php';
		$content_type = $_POST['content_type'];
		change_post_meta($post_ID, 'content_type', $content_type);
		//check all the boxes, and save the ones that have a value
		require $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/wk_content_types/options.php';
		for($i=0; $i<sizeof($boxes[$ct]); $i++){
			$box = $boxes[$ct][$i];
			$fields = $box['fields'];
			//print_r($box);
			//check if we have custom php file
			if($box['custom'] == ''){
				//each box can have multiple inputs, run through them
				for($j=0; $j<sizeof($box['fields']); $j++){
				
					$temp = explode('|', $box['fields'][$j]);
					$level = $temp[0];
					$type = $temp[1];
					$name = $temp[2];
					$translation = $temp[3];
					$default = $temp[4];
				
					//check the type and add the approprite custom fields
					if ($type == 'date') {
						$input = $_POST[$name.'_day'];
						change_post_meta($post_ID, $name.'_day', $input);
						$input = $_POST[$name.'_month'];
						change_post_meta($post_ID, $name.'_month', $input);
						$input = $_POST[$name.'_year'];
						change_post_meta($post_ID, $name.'_year', $input);
						//array_push($vars, $name.'_day', $name.'_month', $name.'_year');
					} elseif ($type == 'time') {
						$input = $_POST[$name.'_hour'];
						change_post_meta($post_ID, $name.'_hour', $input);
						$input = $_POST[$name.'_minute'];
						change_post_meta($post_ID, $name.'_minute', $input);
						//array_push($vars, $name.'_hour', $name.'_minute');
					} elseif ($type == 'checkbox') {
						//save and seperate checkbox values
						$allvalues = explode('~', $temp[5]);
						//find var_names to add to vars
						$k = 0;
						foreach ($allvalues as $val) {
							if ($k%2 == 0) {
								//do nothing
							} else {
								//var names are first (before values), so we have the value as input, and as the desired value inside the mysql key
								$input = $_POST[$val];
								//name = val is used to empty this cell
								if($input != ''){
									$name = $input;
								}else{
									$name = $val;
								}
								//empty values are not deleted, just left empty
								change_post_meta($post_ID, $name, $input);
							}
							$k++;
						}
					}else{
						$input = $_POST[$name];
						change_post_meta($post_ID, $name, $input);
					}
				}
			}else{
				//save the custom codes data
				//find the single values
				$temp = $box['fields'][0];
				$singles = explode('|', $temp);
				//save all singles
				foreach($singles as $single){
					$input = $_POST[$single];
					change_post_meta($post_ID, $single, $input);
				}
				
				//find the values that should be saved like date0, date1, date2...
				$temp2 = $b['fields'][1];
				$bases = explode('|', $temp2);
				//run through all the values of the custom
				//the first values indicates how many values we have for each value, example: first = 2, we have date0, date1
				$num = $_POST[$singles[0]];
				//echo $num;
				
				for($j=0; $j<$num; $j++){
					//read all fields
					foreach($bases as $base){
						$input = $_POST[$base.$j];
						//echo $base.$j . '=  ' . $input;
						change_post_meta($post_ID, $base.$j, $input);
					}
				}
				//require 'fire.php';
			}
		}
		//echo "</pre>";
		//require 'fire.php';
	}
}

//a function to simplify changing post meta
function change_post_meta($post_ID, $name, $input){
	if($name != ''){
		$add = add_post_meta($post_ID, $name, $input, TRUE);
		if($add){
			//value just added, do nothing
		}else{
			update_post_meta($post_ID, $name, $input);
		}
	}
}
?>
