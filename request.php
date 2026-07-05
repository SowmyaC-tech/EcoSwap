<?php
session_start();
include 'db.php';

$item_id = $_GET['id'];
$requester_id = $_SESSION['user_id'];

$conn->query("INSERT INTO requests (item_id, requester_id)
              VALUES ('$item_id', '$requester_id')");

echo "Request Sent!";
?>