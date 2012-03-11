<?php
	include_once "time_ago.php";
	//echo time_ago();
	test('note=', null, array('a' => 99));
	
	function test($note, $extras = array('f' => 13, 'e' => 'no'), $extras2 = array('a' => 45, 'b' => 67)){
		echo $note;
		echo $extras['e'];
		echo $extras['f'];
		echo $extras2['a'];
	}
?>
