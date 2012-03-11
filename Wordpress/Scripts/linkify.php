<?php
 /**
  * Takes a text and returns it with the appropriate html tags to make the links inside it, links.
  * 
  * @version linkify v0.2.2
  * 
  * @return string The linkified text
  * @param string $text The text to linkify
  * @param string $target[optional] Where the links will open
  */
function linkify($text, $target = "_blank"){
	//linkify http://
	$linkExtract = "/http:\/\/[^ ]*/i";
	preg_match_all($linkExtract, $text, $links, PREG_SET_ORDER);
	foreach ($links as $val){
		$temp = $val[0];
		$text = str_replace($val[0], "<a href='$temp' target='$target'>$val[0]</a>", $text);
	}
	//linkify www.
	$linkExtract = "/[^http:\/\/]www\.[^ ]*/i";
	preg_match_all($linkExtract, $text, $links, PREG_SET_ORDER);
	foreach ($links as $val){
		$temp = $val[0];
		$text = str_replace($val[0], "<a href='$temp' target='$target'>$val[0]</a>", $text);
	}
	
	return $text;
}

?>