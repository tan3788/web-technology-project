<?php

include 'config.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    // Get image path first

    $select = "SELECT * FROM products WHERE id='$id'";

    $result = mysqli_query($conn, $select);

    $product = mysqli_fetch_assoc($result);

    // Delete image file

    if(file_exists($product['image'])){

        unlink($product['image']);
    }

    // Delete product from database

    $delete = "DELETE FROM products WHERE id='$id'";

    mysqli_query($conn, $delete);

    header("Location: admin_dashboard.php");
}

?>