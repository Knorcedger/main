<?php
function wk_display_feed_update($url, $name, $items_num) {
	$data = fetch_page($url);
	//add time comment to data
	//find time
	$mytime = date('G')*60+date('i');
	$data = str_replace('<channel>', '<channel><updated_time>'.$mytime.'</updated_time>', $data);
	if ($data != '') {
		$myFile = "./wp-content/plugins/wk_display_feed/cache/$name.xml";
		$fh = fopen($myFile, 'w') or die ("can't open file: $myFile");
		fwrite($fh, $data);
		fclose($fh);
		//set permissions to 777
		chmod($myFile, 0777);
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
