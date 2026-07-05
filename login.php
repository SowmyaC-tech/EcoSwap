<?php
session_start();
include 'db.php';

$error = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['id'];

            header("Location: dashboard.php");
            exit();

        }else{
            $error = "Invalid email or password!";
        }

    }else{
        $error = "User not found!";
    }

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Eco Swap Login</title>

<!-- Link to eco style -->
<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-box">

<h2>Eco Swap Login</h2>

<?php if($error != ""){ ?>
<p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

</form>

<a href="register.php">New user? Register here</a>

</div>

</body>
</html>