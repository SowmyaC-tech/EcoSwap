<!doctype html>
<html>
<head>
	<title>Form</title>
	</head>
	<body>
		<h2>Form submission</h2>
	<?php

    if($_SERVER['REQUEST_METHOD']=='POST'){

	    $name=$_POST['name'];
	    $email=$_POST['email'];
	    $message=$_POST['message'];

	echo"Name:$name";
	echo"Email:$email";
	echo"message:$message";

}
?>
</body>
</html>
