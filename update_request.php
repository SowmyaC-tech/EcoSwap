<?php
include 'db.php';

$id = $_GET['id'];
$action = $_GET['action'];

if($action == "accept"){
    $status = "accepted";
}else{
    $status = "rejected";
}

mysqli_query($conn, "UPDATE swap_requests SET status='$status' WHERE id='$id'");

header("Location: notifications.php");
?>