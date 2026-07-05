<?php
include 'db.php';

$message = "";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    /* CHECK IF EMAIL ALREADY EXISTS */

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");

    if($check->num_rows > 0){

        $message = "Email already registered! Please login.";

    }else{

        $sql = "INSERT INTO users (name, email, password) 
                VALUES ('$name', '$email', '$password')";

        if($conn->query($sql)){

            header("Location: login.php");
            exit();

        }else{

            $message = "Registration failed! Please try again.";

        }

    }

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Eco Swap Register</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="form-box">

<h2>Create Account</h2>

<?php if($message != ""){ ?>
<p style="color:red;"><?php echo $message; ?></p>
<?php } ?>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="register">Register</button>

</form>

<a href="login.php">Already have an account? Login</a>

</div>

</body>
</html>                                                                                                                                                                                                                        