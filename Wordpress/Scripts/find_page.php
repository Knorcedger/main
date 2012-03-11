<?php
/**
 * Finds the subpages of the current url
 * 
 * @version find_page v0.2.0
 * 
 * @return array An aray with the pages names
 * @param int $page_levels The number of the url subpages you want
 */
function find_page($page_levels) {
	$nowurl = explode("/", $_SERVER['REQUEST_URI']);
	for ($i = 0; $i < $page_levels; $i++) {
		$curpage[$i] = $nowurl[$i+1];
		//convert %xx to normal chars
		$curpage[$i] = htmlspecialchars(urldecode($curpage[$i]));
	}
	return $curpage;
}
?>
