<?php
/* 
 Plugin Name: wk_cut_text
 Plugin URI: http://o-some.com
 Description: A simple text cutter
 Version: 0.3.0
 Author: Achilleas Tsoumitas
 Author URI: http://knorcedger.com
 */
?>
<?php
/**
 * A simple text cutter
 * 
 * @return string The cutten text
 * @param string $text
 * @param int $limit The characters to cut at
 * @param int $cut_on_space If to cut on a space or between words
 * @param string $allow The tags to allow (<br><a>...)
 */
function wk_cut_text($text, $limit, $cut_on_space = 1, $allow = '') {
	//strip tags
	$text = strip_tags($text, $allow);
	//check if we have to cut
	if (strlen($text) >= $limit) {
		//if cut_on_space
		if($cut_on_space){
			//find where to cut
			$cut = strpos($text, " ", $limit);
			if ($cut >= $limit) {
				$text = substr($text, 0, $cut);
				$text = $text.'...';
			}
		}else{
			$text = substr($text, 0, $limit);
			$text = $text.'...';
		}
	}
	return $text;
}
?>
