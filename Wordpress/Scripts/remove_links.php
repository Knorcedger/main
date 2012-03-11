<?php
 /**
  * Takes a text and removes any links inside it (starting with http and www
  * 
  * @version remove_links v0.1.0
  * 
  * @return string The text without the links
  * @param string $text The text to remove the links
  */
function linkify($text){
	//remove http://
	$linkExtract = "/http:\/\/[^ ]*/i";
	preg_match_all($linkExtract, $text, $links, PREG_SET_ORDER);
	foreach ($links as $val){
		$temp = $val[0];
		$text = str_replace($val[0], "", $text);
	}
	//remove www.
	$linkExtract = "/[^http:\/\/]www\.[^ ]*/i";
	preg_match_all($linkExtract, $text, $links, PREG_SET_ORDER);
	foreach ($links as $val){
		$temp = $val[0];
		$text = str_replace($val[0], "", $text);
	}
	
	return $text;
}

?>
