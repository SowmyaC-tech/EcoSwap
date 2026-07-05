<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$user_id = $_SESSION['user_id'];

/* DELETE ITEM */

if(isset($_GET['delete'])){

$item_id = $_GET['delete'];

/* Check item belongs to logged in user */

$check = $conn->query("SELECT * FROM items WHERE id='$item_id' AND user_id='$user_id'");

if($check->num_rows > 0){
	//delete all related items
	$conn->query("DELETE FROM requests WHERE item_id='$item_id'");


$conn->query("DELETE FROM items WHERE id='$item_id'");

header("Location: manage_items.php");
exit();

}else{

$error = "You cannot delete other users' items.";

}

}

/* CANCEL SWAP REQUEST */

if(isset($_GET['cancel'])){

$request_id = $_GET['cancel'];

$conn->query("DELETE FROM swap_requests WHERE id='$request_id' AND requester_id='$user_id'");

header("Location: manage_items.php");
exit();

}

/* FETCH USER ITEMS */

$items = $conn->query("SELECT * FROM items WHERE user_id='$user_id'");

/* FETCH USER SWAP REQUESTS */

$requests = $conn->query("
SELECT swap_requests.*, items.item_name 
FROM swap_requests
JOIN items ON swap_requests.item_id = items.id
WHERE swap_requests.requester_id='$user_id'
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Manage My Items</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.container{
margin-top:40px;
}

.item-box{
border:1px solid #ddd;
border-radius:8px;
padding:15px;
margin-bottom:15px;
background:white;
}

.btn.btn-secondary.mt-4{
position:fixed;
top:20px;
right:30px;
background:grey;
color:white;
padding:8px 18px;
border-radius:5px;
text-decoration:none;
font-weight:bold;
z-index:1000;
}

</style>

<script>

function confirmDelete(){
return confirm("Are you sure you want to delete this item?");
}

function confirmCancel(){
return confirm("Cancel this swap request?");
}

</script>

</head>

<body>
	<a href="dashboard.php" class="btn btn-secondary mt-4">Back to Dashboard</a>

<div class="container">

<h2 class="mb-4">My Uploaded Items</h2>

<?php
if(isset($error)){
echo "<div class='alert alert-danger'>$error</div>";
}
?>

<?php
if($items->num_rows > 0){

while($row = $items->fetch_assoc()){
?>

<div class="item-box">

<h5><?php echo $row['item_name']; ?></h5>

<p><?php echo $row['description']; ?></p>

<a href="manage_items.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirmDelete();">

Delete Item

</a>

</div>

<?php
}

}else{

echo "<p>No items uploaded yet.</p>";

}
?>

<hr>

<h2 class="mt-5 mb-4">My Swap Requests</h2>

<?php

if($requests->num_rows > 0){

while($req = $requests->fetch_assoc()){
?>

<div class="item-box">


<p><b>Requested Item:</b> <?php echo $req['item_name']; ?></p>

<a href="manage_items.php?cancel=<?php echo $req['id']; ?>"
class="btn btn-warning btn-sm"
onclick="return confirmCancel();">

Cancel Request

</a>

</div>

<?php
}

}else{

echo "<p>No swap requests.</p>";

}

?>


</div>

</body>
</html>