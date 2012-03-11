<?php

$conn = mysql_connect('localhost', 'noodoxco_feeds', 'feeds4096') or die ('Error connecting to mysql');
mysql_select_db('noodoxco_feeds');

ob_start();

$result = mysql_query("SELECT * FROM feeds");
while($row = mysql_fetch_array($result)) {
	$url = $row["url"];
	file("http://noodox.com/feeds/feedboiler.php?url=$url");
}

ob_end_clean();

?>
