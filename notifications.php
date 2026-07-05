<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

/* 1. Requests RECEIVED (you are owner) */
$received = mysqli_query($conn,"
SELECT sr.*, i.item_name, u.name AS requester_name
FROM swap_requests sr
JOIN items i ON sr.item_id = i.id
JOIN users u ON sr.requester_id = u.id
WHERE i.user_id = '$user_id'
");

/* 2. Requests SENT (you are requester) */
$sent = mysqli_query($conn,"
SELECT sr.*, i.item_name, u.name AS owner_name
FROM swap_requests sr
JOIN items i ON sr.item_id = i.id
JOIN users u ON i.user_id = u.id
WHERE sr.requester_id = '$user_id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Notifications</title>

<style>
body{font-family:Arial;background:#f4f6f9;padding:20px;}
.box{background:white;padding:10px;margin-bottom:10px;border-radius:8px;}
.accept{background:green;color:white;border:none;padding:5px;}
.reject{background:red;color:white;border:none;padding:5px;}
.pending{color:orange;}
.accepted{color:green;}
.rejected{color:red;}
</style>

</head>

<body>

<h2>🔔 Notifications</h2>
<button onclick="window.location.href='dashboard.php'" style="
background:#bdc3c7;
color:black;
border:none;
padding:8px 18px;
border-radius:6px;
font-weight:bold;
cursor:pointer;
margin-bottom:15px;
">
 Back
</button>

<hr>

<!-- 📥 RECEIVED -->
<h3>Requests for Your Items</h3>

<?php while($row = mysqli_fetch_assoc($received)){ ?>

<div class="box">

<p>
<b><?php echo $row['requester_name']; ?></b> wants 
<b><?php echo $row['item_name']; ?></b>
</p>

<p>Status: <?php echo $row['status']; ?></p>

<?php if($row['status']=="pending"){ ?>
<a href="update_request.php?id=<?php echo $row['id']; ?>&action=accept">
<button class="accept">Accept</button>
</a>

<a href="update_request.php?id=<?php echo $row['id']; ?>&action=reject">
<button class="reject">Reject</button>
</a>
<?php } ?>

</div>

<?php } ?>

<hr>

<!-- 📤 SENT -->
<h3>Your Requests</h3>

<?php while($row = mysqli_fetch_assoc($sent)){ ?>

<div class="box">

<p>
You requested <b><?php echo $row['item_name']; ?></b>
from <b><?php echo $row['owner_name']; ?></b>
</p>

<p class="<?php echo $row['status']; ?>">
Status: <?php echo ucfirst($row['status']); ?>
</p>

</div>

<?php } ?>

</body>
</html>