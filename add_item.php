<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['add'])){

    $name = $_POST['item_name'];
    $desc = $_POST['description'];
    $cat  = $_POST['category'];
    $user_id = $_SESSION['user_id'];

    /* ECO FRIENDLY VALIDATION */

    $eco_keywords = ["eco","reusable","Books","plant","organic","bamboo","cloth","jute","paper","steel","glass","wood","biodegradable"];

    $isEco = false;

    foreach($eco_keywords as $word){

        if(stripos($name,$word) !== false || stripos($desc,$word) !== false){
            $isEco = true;
            break;
        }

    }

    if(!$isEco){

        $error = "❌ Only eco-friendly items are allowed on EcoSwap.";

    }else{

        /* IMAGE UPLOAD */

        $imageName = $_FILES['image']['name'];
        $tempName  = $_FILES['image']['tmp_name'];

        $folder = "uploads/";

        /* Create uploads folder if not exists */
        if(!is_dir($folder)){
            mkdir($folder);
        }

        /* Get image extension */
        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        /* Allowed formats */
        $allowed = ['jpg','jpeg','png'];

        if(in_array($ext, $allowed)){

            /* Create unique image name */
            $newImageName = time()."_".$imageName;

            $targetFile = $folder.$newImageName;

            if(move_uploaded_file($tempName,$targetFile)){

                $sql = "INSERT INTO items (user_id, item_name, description, category, image)
                        VALUES ('$user_id','$name','$desc','$cat','$newImageName')";

                if($conn->query($sql)){
                    header("Location: dashboard.php");
                    exit();
                }else{
                    $error = "Database error!";
                }

            }else{
                $error = "Image upload failed!";
            }

        }else{
            $error = "Only JPG, JPEG, PNG allowed!";
        }

    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Add Item</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
}

.card{
max-width:500px;
margin:auto;
margin-top:60px;
}

</style>

</head>

<body>

<div class="card shadow p-4">

<h3 class="text-center mb-3">Add New Item</h3>

<?php
if(isset($error)){
    echo "<div class='alert alert-danger'>$error</div>";
}
?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<input type="text" name="item_name" class="form-control" placeholder="Item Name" required>
</div>

<div class="mb-3">
<textarea name="description" class="form-control" placeholder="Description" required></textarea>
</div>

<div class="mb-3">
<select name="category" class="form-control" required>
<option value="">Select Category</option>
<option value="Books">Books</option>
<option value="Plants">Plants</option>
<option value="Bags">Bags</option>
<option value="Kitchen Items">Kitchen Items</option>
<option value="Others">Others</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Upload Image</label>
<input type="file" name="image" class="form-control" required>
</div>

<button name="add" class="btn btn-primary w-100">Add Item</button>

<a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Back to Dashboard</a>

</form>

</div>

</body>
</html>                                                                                                                                                                                                                                                       