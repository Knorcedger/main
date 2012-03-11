<?php
/* 
 Plugin Name: wk_twitter
 Plugin URI: http://o-some.com
 Description: Fetching and displaying twitter messages.
 Version: 0.4.3
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * Fetches and displays twitter messages
 * 
 * @example wk_twitter('en', 'TechblogGR', 3, '<h3>Twitter</h3><ul>', '</ul>', '<li>the_twit @ the_time</li>', 60);
 * 
 * @return The twits
 * @param string $language
 * @param string $username
 * @param int $messages[optional]
 * @param string $prefix[optional]
 * @param string $suffix[optional]
 * @param string $between[optional] Using the vars: the_twit, the_time
 * @param int $update_time[optional]
 */
function wk_twitter($language, $username, $messages = 1, $prefix = '', $suffix = '', $between = '', $update_time = 15) {
	//languages
	if ($language == 'en') {
		$ago = 'ago';
	} elseif ($language == 'gr') {
		$ago = 'πριν';
	}
	//include necessary files
	include_once 'time_ago.php';

	//fetch data from database
	//data in db are saved like that: updated_time . '~' . $alltwits . '~' . $alltimes
	$data = get_option('wk_twitter');
	//seperate to time, twits, times
	$data = explode('~', $data);
	$updated_time = $data[0];
	//seperate twits
	$mytwits = explode('|', $data[1]);
	//seperate times
	$mytimes = explode('|', $data[2]);
	//calculate current time
	$mytime = date('G')*60+date('i');
	//check if we should update twits
	if ($mytime > $updated_time + $update_time || ($mytime +$update_time < $updated_time)) {
		include_once 'update.php';
		wk_twitter_update($username, $messages);
	}

	//create final string
	$final = $prefix;
	for ($i = 0; $i < $messages; $i++) {
		//replace dummy vars with the real ones
		$temp = str_replace('the_twit', $mytwits[$i], $between);
		$temp = str_replace('the_time', time_ago($mytimes[$i], $language)." $ago", $temp);
		$final .= $temp;
	}
	$final .= $suffix;
	echo $final;
}
?>
