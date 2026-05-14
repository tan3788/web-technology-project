<?php
// Simple database connection
$serverName = "127.0.0.1";
$userName = "root";
$password = "";
$dbName = "simple_ecommerce";

$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

// timezone setting
date_default_timezone_set('Asia/Dhaka');

// Start session for cart functionality
session_start();
?>
