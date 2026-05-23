<?php

require_once 'config.php';

if(isset($_GET['id']) && isset($_GET['status'])){

    $id = $_GET['id'];

    $status = $_GET['status'];

    // Update Order Status

    $sql = "UPDATE orders

            SET order_status='$status'

            WHERE id='$id'";

    $result = mysqli_query($conn, $sql);

    if($result){

        header("Location: admin_orders.php");

        exit();

    } else {

        echo "

        <div style='
            padding:20px;
            background:#ffdddd;
            color:red;
            font-family:Arial;
        '>

            Failed to update order status.

        </div>

        ";
    }
}

?>