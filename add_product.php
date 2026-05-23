<?php

include 'config.php';

if(isset($_POST['add_product'])){

    $name = $_POST['name'];

    $description = $_POST['description'];

    $price = $_POST['price'];

    $category = $_POST['category'];

    $stock = $_POST['stock'];

    // Image Upload

    $image_name = $_FILES['image']['name'];

    $temp_name = $_FILES['image']['tmp_name'];

    $image = "images/" . $image_name;

    move_uploaded_file($temp_name, $image);

    // Insert Query

    $sql = "INSERT INTO products
            (name, description, price, image, category, stock)

            VALUES

            ('$name',
             '$description',
             '$price',
             '$image',
             '$category',
             '$stock')";

    $result = mysqli_query($conn, $sql);

    if($result){

        header("Location: admin_dashboard.php");

    } else {

        echo "

        <div class='alert alert-danger text-center m-4'>

            Failed to add product.

        </div>

        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Add Product - SimpleStore</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>

body{

    background: #f8f1e7;

    font-family: Arial, sans-serif;
}

.product-card{

    max-width: 700px;

    margin: 40px auto;

    background: white;

    padding: 35px;

    border-radius: 20px;

    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.title{

    color: #4f46e5;

    font-weight: bold;

    margin-bottom: 30px;

    text-align: center;
}

.form-control{

    border-radius: 12px;

    padding: 12px;
}

.btn-add{

    background: linear-gradient(135deg, #6366f1, #4338ca);

    color: white;

    border: none;

    padding: 12px;

    border-radius: 12px;

    width: 100%;

    font-size: 18px;

    font-weight: bold;

    transition: 0.3s;
}

.btn-add:hover{

    transform: translateY(-3px);

    color: white;
}

.back-btn{

    margin-top: 15px;

    display: inline-block;
}

</style>

</head>

<body>

<div class="container">

    <div class="product-card">

        <h2 class="title">

            Add New Product

        </h2>

        <form method="POST"
              enctype="multipart/form-data">

            <!-- Product Name -->

            <div class="mb-3">

                <label class="form-label">

                    Product Name

                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       required>

            </div>

            <!-- Description -->

            <div class="mb-3">

                <label class="form-label">

                    Description

                </label>

                <textarea name="description"
                          class="form-control"
                          rows="4"
                          required></textarea>

            </div>

            <!-- Price -->

            <div class="mb-3">

                <label class="form-label">

                    Price ($)

                </label>

                <input type="number"
                       step="0.01"
                       name="price"
                       class="form-control"
                       required>

            </div>

            <!-- Category -->

            <div class="mb-3">

                <label class="form-label">

                    Category

                </label>

                <input type="text"
                       name="category"
                       class="form-control"
                       required>

            </div>

            <!-- Stock -->

            <div class="mb-3">

                <label class="form-label">

                    Stock Quantity

                </label>

                <input type="number"
                       name="stock"
                       class="form-control"
                       required>

            </div>

            <!-- Image Upload -->

            <div class="mb-4">

                <label class="form-label">

                    Upload Product Image

                </label>

                <input type="file"
                       name="image"
                       class="form-control"
                       accept="image/*"
                       required>

            </div>

            <!-- Submit Button -->

            <button type="submit"
                    name="add_product"
                    class="btn btn-add">

                Add Product

            </button>

        </form>

        <a href="admin_dashboard.php"
           class="btn btn-secondary back-btn">

            Back to Dashboard

        </a>

    </div>

</div>

</body>
</html>