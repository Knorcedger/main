<?php
/**
 * Fetches twitter messages
 * 
 * @return The twitter messages
 * @param string $username
 * @param int $messages[optional]
 */
function wk_twitter_update($username, $messages = 1){
	//the link to fetch
	$link = 'http://search.twitter.com/search.rss?q=from:' . $username . '&rpp=' . $messages;
	$data = fetch_page($link);
	//include necessary files
	include_once 'linkify.php';
	//find twit
	$twitExtract = "/(?<=<title>).*(?=<\/title>)/i";
	preg_match_all($twitExtract, $data, $twits, PREG_SET_ORDER);
	for($i = 0; $i < $messages; $i++){
		//save twits and linkify
		$mytwits[$i] = linkify($twits[$i+1][0]);
	}
	//find time
	$timeExtract = "/(?<=<pubDate>).*(?=<\/pubDate>)/i";
	preg_match_all($timeExtract, $data, $times, PREG_SET_ORDER);
	for($i = 0; $i < $messages; $i++){
		//save times
		$mytimes[$i] = $times[$i+1][0];
	}
	//
	if($mytwits[0] != ''){
		//add option to db, if it exists, it does nothing
		add_option('wk_twitter', '');
		$alltwits = '';
		$alltimes = '';
		for($i = 0; $i < $messages; $i++){
			$alltwits .= $mytwits[$i];
			$alltimes .= $mytimes[$i];
			//if not last twit and time, add the seperator
			if($i + 1 != $messages){
				$alltwits .= '|';
				$alltimes .= '|';
			}
		}
		$mytime = date('G')*60+date('i');
		update_option('wk_twitter', $mytime . '~' . $alltwits . '~' . $alltimes);
	}

}
function fetch_page($page) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $page);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
?>