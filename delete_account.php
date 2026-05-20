<?php

session_start();
include 'config.php';

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];

$sql = "DELETE FROM users WHERE id='$id'";

$result = mysqli_query($conn, $sql);

if($result){

    session_destroy();

    header("Location: register.php");
    exit();

} else {

    echo "Account deletion failed";
}

?>