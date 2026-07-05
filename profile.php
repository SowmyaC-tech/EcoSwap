<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Fetch user details */
$user_query = "SELECT * FROM users WHERE id='$user_id'";
$user_result = mysqli_query($conn,$user_query);
$user = mysqli_fetch_assoc($user_result);

/* Fetch items uploaded by user */
$item_query = "SELECT * FROM items WHERE user_id='$user_id'";
$items = mysqli_query($conn,$item_query);

/* Fetch swap requested items */
$request_query = "
SELECT items.*, users.name 
FROM swap_requests
JOIN items ON swap_requests.item_id = items.id
JOIN users ON items.user_id = users.id
WHERE swap_requests.requester_id = '$user_id'
";

$requests = mysqli_query($conn,$request_query);

?>

<!DOCTYPE html>
<html>
<head>

<title>My Profile</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>

body{
background:#f4f6f9;
font-family:Arial;
}

/* top header */

.header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;
}

/* item grid */

.item-container{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
gap:20px;
}

/* item card */

.item-box{
background:white;
border-radius:10px;
padding:10px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
transition:0.3s;
}

.item-box:hover{
transform:scale(1.03);
}

.item-box img{
width:100%;
height:160px;
object-fit:cover;
border-radius:6px;
margin-bottom:10px;
}

</style>

</head>

<body>

<div class="container mt-4">

<!-- HEADER -->

<div class="header">

<h2><?php echo $user['name']; ?>'s Profile 👤</h2>

<div>

<a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>

<a href="logout.php" class="btn btn-danger">Logout</a>

</div>

</div>

<!-- MY UPLOADED ITEMS -->

<div class="card p-4 mb-5">

<h4 class="mb-4">My Uploaded Items 📦</h4>

<div class="item-container">

<?php

if(mysqli_num_rows($items) > 0){

while($row = mysqli_fetch_assoc($items)){

?>

<div class="item-box">

<img src="uploads/<?php echo $row['image']; ?>">

<h5><?php echo $row['item_name']; ?></h5>

<p><?php echo $row['description']; ?></p>

</div>

<?php

}

}else{

echo "<p>No items uploaded yet.</p>";

}

?>

</div>

</div>

<!-- REQUESTED ITEMS -->

<div class="card p-4">

<h4 class="mb-4">Items I Requested to Swap 🔁</h4>

<div class="item-container">

<?php

if(mysqli_num_rows($requests) > 0){

while($row = mysqli_fetch_assoc($requests)){

?>

<div class="item-box">

<img src="uploads/<?php echo $row['image']; ?>">

<h5><?php echo $row['item_name']; ?></h5>

<p>Owner: <?php echo $row['name']; ?></p>

</div>

<?php

}

}else{

echo "<p>No swap requests sent.</p>";

}

?>

</div>

</div>

</div>

</body>
</html>                                                                                                                                                                                                                                                        