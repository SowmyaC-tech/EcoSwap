<?php
session_start();
include 'db.php';

if(!isset($_GET['search'])){
    header("Location: dashboard.php");
    exit();
}

$search = $_GET['search'];

/* Search items by item_name */
$query = "SELECT * FROM items WHERE item_name LIKE '%$search%'";
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>
<head>

<title>Search Results</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>

body{
background:#f4f6f9;
font-family:Arial;
}

.item-container{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
gap:20px;
}

.item-box{
background:white;
border-radius:10px;
padding:10px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
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

<h2>Search Results for "<?php echo $search; ?>"</h2>

<a href="dashboard.php" class="btn btn-primary mb-3">Back to Dashboard</a>
<div class="item-container">

<?php

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){
?>

<div class="item-box">

<img src="uploads/<?php echo $row['image']; ?>">

<h5><?php echo $row['item_name']; ?></h5>

<p><?php echo $row['description']; ?></p>

<p><b>Category:</b> <?php echo $row['category']; ?></p>

</div>

<?php
}

}else{

echo "<p>No items found.</p>";

}

?>

</div>

</div>

</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         