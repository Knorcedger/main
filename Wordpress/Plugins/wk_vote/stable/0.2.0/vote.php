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
	$the_vote = 1;
}else{
	$the_vote = -1;
}
//find the old votes
$old_votes = get_post_meta($pid, 'votes', true);
$old_voters = get_post_meta($pid, 'voters', true);
if($old_votes == ''){
	$new_votes = $the_vote;
	//save votes number
	add_post_meta($pid, 'votes', $new_votes, true);
	//save who voted
	add_post_meta($pid, 'voters', $uid, true);
}else{
	$new_votes = $old_votes + $the_vote;
	update_post_meta($pid, 'votes', $new_votes);
	//save who voted
	$voters = $voters . ',' . $uid;
	add_post_meta($pid, 'voters', $voters, true);
}
//update user data
$voted = get_usermeta($uid, 'voted');
if($voted == ''){
	update_usermeta($uid, 'voted', $pid);
}else{
	$voted = $voted . ',' . $pid;
	update_usermeta($uid, 'voted', $voted);
}

echo json_encode(array("pid"=>"$pid", "uid"=>"$uid", "votes"=>"$new_votes"));
?>
