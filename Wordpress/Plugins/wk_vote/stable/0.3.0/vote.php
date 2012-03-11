<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

//get data
$post_data = $_POST['post'];

//save data
$temp = explode(" ",$post_data);
$plugin_name = $temp[0];
$action = $temp[1];
$pid = $temp[2];
$temp2 = explode('-', $pid);
$pid = $temp2[1];
$user_status = $temp[3];
$uid = $temp[4];
$temp2 = explode('-', $uid);
$uid = $temp2[1];

//find the vote to add
if($action == 'vote-up'){
	$the_vote = 'up';
}else{
	$the_vote = 'down';
}

/* DATA STRUCTURE
wk_vote = [user_id => 'up', user_id => 'down'...]
*/

//update post meta
$wk_votes_serialized = get_post_meta($pid, 'wk_votes', true);
$wk_votes = unserialize($wk_votes_serialized);

if($wk_votes == ''){
	$wk_votes = array($uid => $the_vote);
	$wk_votes_serialized = serialize($wk_votes);
	add_post_meta($pid, 'wk_votes', $wk_votes_serialized, true);
}else{
	$wk_votes[$uid] = $the_vote;
	$wk_votes_serialized = serialize($wk_votes);
	update_post_meta($pid, 'wk_votes', $wk_votes_serialized);
}

//update user data
//get_usermeta unserializes too
$wk_voted = get_usermeta($uid, 'wk_voted');

if($wk_voted == ''){
	$wk_voted = array();
	$wk_voted[$pid] = $the_vote;
	$wk_voted_serialized = serialize($wk_voted);
	update_usermeta($uid, 'wk_voted', $wk_voted_serialized);
}else{
	$wk_voted[$pid] = $the_vote;
	$wk_voted_serialized = serialize($wk_voted);
	update_usermeta($uid, 'wk_voted', $wk_voted_serialized);
}

//find the aggregate of all votes
$votes = 0;
foreach($wk_votes as $vote){
	if($vote == 'up'){
		$votes++;
	}else{
		$votes--;
	}
}

echo json_encode(array("pid"=>"$pid", "uid"=>"$uid", "votes"=>"$votes"));
?>
