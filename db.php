<?php
$conn = new mysqli("localhost", "root", "", "ecoswap");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>