<?php

//feedboiler v0.5.4

//$site = "http://www.adslgr.com";

//----------OPTIONS----------//
//titles
//$titleTags = array("\/span", "span", "a");
//links
//$linkTags = array("\/span", "span", "a");
//descriptions
//$descriptionTags = array("\/span", "br", "br", "span");
//dates
//$dateTags = array();

//feedboiler

//read the feed url
$url = $_GET["url"];

//read from mysql
$conn = mysql_connect('localhost', 'noodoxco_feeds', 'feeds4096') or die ('Error connecting to mysql');
mysql_select_db('noodoxco_feeds');
$result = mysql_query("SELECT * FROM feeds WHERE url='$url'");
//$row = mysql_fetch_array($result);
while($row = mysql_fetch_array($result)) {
	//OPTIONS
	//website to fetch
	$site = $row["site"];
	//strings to search for
	//titles
	$titleTags = $row["titleTags"];
	$titleTags = str_ireplace("/", "\/", $titleTags);
	//links
	$linkTags = $row["linkTags"];
	$linkTags = str_ireplace("/", "\/", $linkTags);
	//descriptions
	$descriptionTags = $row["descriptionTags"];
	$descriptionTags = str_ireplace("/", "\/", $descriptionTags);
	//dates
	$dateTags = $row["dateTags"];
	$dateTags = str_ireplace("/", "\/", $dateTags);
	//limit feed items
	$limit = $row["limit"];
}

//check if empty true, then dont explode because explode adds an empty value to array
if($titleTags != ""){
	$titleTags = explode(",", $titleTags);
}else{
	$titleTags = array();
}
if(linkTags != ""){
	$linkTags = explode(",", $linkTags);
}else{
	$linkTags = array();
}
if($descriptionTags != ""){
	$descriptionTags = explode(",", $descriptionTags);
}else{
	$descriptionTags = array();
}
if($dateTags != ""){
	$dateTags = explode(",", $dateTags);
}else{
	$dateTags = array();
}

//remove whitespaces from back and behind
$i = 0;
foreach($titleTags as $val){
	$titleTags[$i] = trim($val);
	$i++;
}

$i = 0;
foreach($linkTags as $val){
	$linkTags[$i] = trim($val);
	$i++;
}

$i = 0;
foreach($descriptionTags as $val){
	$descriptionTags[$i] = trim($val);
	$i++;
}

$i = 0;
foreach($dateTags as $val){
	$dateTags[$i] = trim($val);
	$i++;
}

//----------FETCH WEBPAGE----------//
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $site);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);

//change & char with &amp;
$site = str_ireplace("&", "&amp;", $site);

//----------CREATE SEARCH PATTERNS----------//
//create titles pattern
if(sizeof($titleTags) != 0){
	$titlesPattern = "/";
	for($i=0; $i<sizeof($titleTags)-1; $i++){
		if(sizeof($titleTags) != $i+2){
			$titlesPattern .= "<$titleTags[$i]" . "[^<]*";
		}else{
			$titlesPattern .= "<$titleTags[$i]";
		}
	}
	$titlesPattern .= "[^`]*?<$titleTags[$i]/i";
}else{
	$titlesPattern = "/ /";
}

//create links pattern
if(sizeof($linkTags) != 0){
	$linksPattern = "/";
	for($i=0; $i<sizeof($linkTags)-1; $i++){
		if(sizeof($linkTags) != $i+2){
			$linksPattern .= "<$linkTags[$i]" . "[^<]*";
		}else{
			$linksPattern .= "<$linkTags[$i]";
		}
	}
	$linksPattern .= "[^`]*?<$linkTags[$i]/i";
}else{
	$linksPattern = "/ /";
}

//create descriptions pattern
if(sizeof($descriptionTags) != 0){
	$descriptionsPattern = "/";
	for($i=0; $i<sizeof($descriptionTags)-1; $i++){
		if(sizeof($descriptionTags) != $i+2){
			$descriptionsPattern .= "<$descriptionTags[$i]" . "[^<]*";
		}else{
			$descriptionsPattern .= "<$descriptionTags[$i]";
		}
	}
	$descriptionsPattern .= "[^`]*?<$descriptionTags[$i]/i";
}else{
	$descriptionsPattern = "/ /";
}

//create dates pattern
if(sizeof($dateTags) != 0){
	$datesPattern = "/";
	for($i=0; $i<sizeof($dateTags)-1; $i++){
		if(sizeof($dateTags) != $i+2){
			$datesPattern .= "<$dateTags[$i]" . "[^<]*";
		}else{
			$datesPattern .= "<$dateTags[$i]";
		}
	}
	$datesPattern .= "[^`]*?<$dateTags[$i]/i";
}else{
	$datesPattern = "/ /";
}

//----------FIND CONSTANTS----------//
//find pagetitle
$pagetitleExtract = "/(?<=<title>)[^`]*?(?=<\/title>)/i";
preg_match_all($pagetitleExtract, $data, $pagetitlea, PREG_SET_ORDER);
$pagetitle = trim($pagetitlea[0][0]);
$pagetitle = str_ireplace("& ", "&amp; ", $pagetitle);

//find charset
$languageExtract = "/(?<=lang=\").*?(?=\")/i";
preg_match_all($languageExtract, $data, $languagea, PREG_SET_ORDER);
$language = $languagea[0][0];
if($language == ""){$language="en";}

//find pagedescription
$pagedescriptionExtract = "/(?<=meta name=\"Description\" content=\")[^`]*?(?=\")/i";
preg_match_all($pagedescriptionExtract, $data, $pagedescriptiona, PREG_SET_ORDER);
$pagedescription = trim($pagedescriptiona[0][0]);
//if($pagedescription == ""){$pagedescription = "no description";}
$pagedescription = str_ireplace("& ", "&amp; ", $pagedescription);

//find charset
$charsetExtract = "/(?<=charset=).*?(?=\")/i";
preg_match_all($charsetExtract, $data, $charseta, PREG_SET_ORDER);
$charset = $charseta[0][0];

//----------REGEX IT BABY----------//
//find matching texts with regex
preg_match_all($titlesPattern, $data, $titles, PREG_SET_ORDER);
preg_match_all($linksPattern, $data, $links, PREG_SET_ORDER);
preg_match_all($descriptionsPattern, $data, $descriptions, PREG_SET_ORDER);
preg_match_all($datesPattern, $data, $dates, PREG_SET_ORDER);

//----------CREATE THE FEED----------//
$xmldata = getDetails() . getItems();

function getDetails(){
	global $site, $language, $pagetitle, $pagedescription, $charset;
	//check if charset is empty
	if($charset == ""){
		$charset = "UTF-8";
	}
	$details = '<?xml version="1.0" encoding="' . $charset . '" ?>
	<rss version="2.0">
		<channel>
			<title>'. $pagetitle .'</title>
			<link>'. $site .'</link>
			<description>'. $pagedescription .'</description>
			<language>'. $language .'</language>';
	return $details;
}

function getItems(){
	global $titles, $links, $descriptions, $dates, $titleTags, $linkTags, $descriptionTags, $dateTags, $site, $limit;
	$items = '';
	$i = -1;
	foreach ($titles as $val){
		$i++;
		if($i < $limit || $limit == 0){
			//title, remove reduntant text
			$title = trim(strip_tags($val[0]));
			//remove special characters (like: &nbsp;)
			$spacialCharExtract = "/&[^`]*?;/i";
			preg_match_all($spacialCharExtract, $title, $titlea, PREG_SET_ORDER);
			foreach($titlea as $val){
				$title = str_ireplace($val, "", $title);
			}
			//alse replace & with &amp;
			$title = str_ireplace("&", "&amp;", $title);
			//link, remove reduntant text
			$linkExtract = "/(?<=href=['|\"]).*?(?=['|\"])/i";
			preg_match_all($linkExtract, $links[$i][0], $linka, PREG_SET_ORDER);
			$link = trim($linka[0][0]);
			//if link starts with no http, then add it
			if(!stristr($link, "http://")){
				//check to avoid double / after the main domain, and then find the main url
				if(substr($link, 0, 1) != "/"){
					$link = "/" . $link;
				}
				$siteurlExtract = "/http:\/\/[^\/]*/i";
				preg_match_all($siteurlExtract, $site, $siteurl, PREG_SET_ORDER);
				//add the url before the link
				$link = $siteurl[0][0] . $link;
			}
			//replace & char with $amp;
			$link = str_ireplace("&", "&amp;", $link);
			//description, check if its empty and then remove reduntant text
			if(sizeof($descriptionTags) == 0){
				$description = "";
			}else{
				$description = trim(strip_tags($descriptions[$i][0]));
			}		
			//date
			$date = strip_tags($dates[$i][0]);
			//if date tags are empty, save current time
			if(sizeof($dateTags) == 0){
				$m = date("i", time());
				$m = $m + 10 - $i;
				//echo $m;
				$date = date("D, d M Y H:$m:s -0600", time());
			}
			//fill feed
			$items .= '
			<item>
				<title>'. $title .'</title>
				<link>'. $link .'</link>
				<description><![CDATA['. $description .']]></description>
				<pubDate>' . $date . '</pubDate>
			</item>';
		}
	}
	$items .= '
		</channel>
	</rss>';
	return $items;
}

//write to xml file
$filename = "feed/" . $url . ".xml";
$fp = fopen($filename, "w");
fwrite($fp, $xmldata);
fclose($fp);

echo $xmldata;

?>
