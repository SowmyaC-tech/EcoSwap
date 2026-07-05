<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$item_id = $_GET['item_id'];

/* Insert request */
mysqli_query($conn,"
INSERT INTO swap_requests (item_id, requester_id, status)
VALUES ('$item_id','$user_id','pending')
");

header("Location: dashboard.php?swap=success");
?>