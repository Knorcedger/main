<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

$object_id = $_POST['object_id'];
$date_id = $_POST['date_id'];

$seats = get_post_meta($object_id, 'date_seats'.$date_id, true);
$return = get_post_meta($object_id, 'date_return'.$date_id, true);

echo json_encode(array("seats"=>"$seats", "return"=>"$return"));
?>
