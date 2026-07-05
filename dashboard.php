<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* SUCCESS MESSAGE CHECK */
$swapSuccess = false;

if(isset($_GET['swap']) && $_GET['swap']=="success"){
    $swapSuccess = true;
}

/* Fetch user name */
$user = $conn->query("SELECT name FROM users WHERE id='$user_id'")->fetch_assoc();

/* CATEGORY FILTER */

if(isset($_GET['category'])){

    $category = $_GET['category'];

    $result = $conn->query("SELECT items.*, users.name 
                            FROM items 
                            JOIN users ON items.user_id = users.id
                            WHERE category='$category'");

}else{

    $result = $conn->query("SELECT items.*, users.name 
                            FROM items 
                            JOIN users ON items.user_id = users.id");

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Eco Swap Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* PAGE LAYOUT */

body{
margin:0;
font-family:Arial;
background:#f4f6f9;
display:flex;
}

/* SIDEBAR */

.sidebar{
width:250px;
background:#2c3e50;
height:100vh;
color:white;
padding:20px;
position:fixed;
overflow-y:auto;   /* enables vertical scroll */
scroll-behavior:smooth;
}

.sidebar h3{
text-align:center;
margin-bottom:30px;
}

.sidebar a{
display:block;
color:white;
padding:12px;
margin-bottom:8px;
text-decoration:none;
border-radius:5px;
}

.sidebar a:hover{
background:#34495e;
}

.sidebar::-webkit-scrollbar{
width:6px;
}

.sidebar::-webkit-scrollbar-thumb{
background:#95a5a6;
border-radius:10px;
}

.sidebar::-webkit-scrollbar-track{
background:transparent;
}

/* MAIN CONTENT */

.main{
margin-left:260px;
padding:30px;
width:100%;
}

/* SEARCH BAR */

.search-box{
margin-top:15px;
margin-bottom:20px;
}

.search-box input{
padding:8px;
width:300px;
border:1px solid #ccc;
border-radius:5px;
}

.search-box button{
padding:8px 15px;
background:#27ae60;
color:white;
border:none;
border-radius:5px;
}

/* ITEM GRID */

.item-container{
display:grid;
grid-template-columns: repeat(auto-fill,minmax(220px,1fr));
gap:20px;
margin-top:20px;
}

/* ITEM CARD */

.item-box{
background:white;
border-radius:10px;
padding:10px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
text-align:center;
transition:0.3s;
}

.item-box:hover{
transform:scale(1.03);
}

.item-box img{
width:100%;
height:180px;
object-fit:cover;
border-radius:6px;
}

/* SUCCESS POPUP */

.success-popup{
position:fixed;
top:50%;
left:50%;
transform:translate(-50%,-50%);
background:#27ae60;
color:white;
padding:20px 40px;
font-size:20px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.3);
z-index:1000;
}
/* TOP RIGHT LOGOUT BUTTON */

.top-logout{
position:fixed;
top:20px;
right:30px;
background:#e74c3c;
color:white;
padding:8px 18px;
border-radius:5px;
text-decoration:none;
font-weight:bold;
z-index:1000;
}

.top-logout:hover{
background:#c0392b;
}

</style>

</head>

<body>
<a href="logout.php" class="top-logout">Logout</a>

<?php if($swapSuccess){ ?>

<div id="successPopup" class="success-popup">
Swap Request Sent Successfully ✓
</div>

<?php } ?>

<!-- SIDEBAR -->

<div class="sidebar">

<h3>Eco Swap</h3>

<p>Welcome,<br><b><?php echo $user['name']; ?></b></p>

<hr>

<a href="dashboard.php">🏠 Dashboard</a>

<a href="profile.php">👤 My Profile</a>

<a href="add_item.php">➕ Add Item</a>

<a href="notifications.php">🔔 Notifications</a>

<p class="mt-3"><b>Eco Categories</b></p>

<a href="dashboard.php?category=Books">📚 Books</a>

<a href="dashboard.php?category=Plants">🌱 Plants</a>

<a href="dashboard.php?category=Bags">👜 Bags</a>

<a href="dashboard.php?category=Kitchen Items">🍽 Kitchen Items</a>

<a href="dashboard.php?category=Others">Others</a>

<a href="manage_items.php">Manage My Items</a>
<hr>

<a href="logout.php" style="background:#e74c3c;">🚪 Logout</a>

</div>

<!-- MAIN CONTENT -->

<div class="main">

<h2>Available Eco-Friendly Items</h2>

<!-- SEARCH BAR -->

<form action="search.php" method="GET" class="search-box">

<input type="text" name="search" placeholder="Search items by name..." required>

<button type="submit">Search</button>

</form>

<div class="item-container">

<?php

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

?>

<div class="item-box">

<img src="uploads/<?php echo $row['image']; ?>" alt="item">

<h5 class="mt-2"><?php echo $row['item_name']; ?></h5>

<p><?php echo $row['description']; ?></p>

<p><b>Owner:</b> <?php echo $row['name']; ?></p>

<button onclick="confirmSwap(<?php echo $row['id']; ?>)" class="btn btn-success btn-sm">
Request Swap
</button>

</div>

<?php
}
}else{
echo "<p>No items available.</p>";
}

?>

</div>

</div>

<script>

/* CONFIRM SWAP */

function confirmSwap(itemId){

if(confirm("Are you sure you want to request this swap?")){

window.location.href="request_swap.php?item_id="+itemId;

}

}

/* SUCCESS POPUP HIDE AFTER 2 SEC */

setTimeout(function(){

var popup=document.getElementById("successPopup");

if(popup){
popup.style.display="none";
}

},2000);

</script>

</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       