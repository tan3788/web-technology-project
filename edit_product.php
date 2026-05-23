<?php

include 'config.php';

$id = $_GET['id'];

$sql = "SELECT * FROM products WHERE id='$id'";

$result = mysqli_query($conn, $sql);

$product = mysqli_fetch_assoc($result);

if(isset($_POST['update_product'])){

    $name = $_POST['name'];

    $description = $_POST['description'];

    $price = $_POST['price'];

    $category = $_POST['category'];

    $stock = $_POST['stock'];

    // Image Upload

    if($_FILES['image']['name'] != ""){

        $image_name = $_FILES['image']['name'];

        $temp_name = $_FILES['image']['tmp_name'];

        $image = "images/" . $image_name;

        move_uploaded_file($temp_name, $image);

    } else {

        $image = $product['image'];
    }

    // Update Query

    $update = "UPDATE products

               SET

               name='$name',
               description='$description',
               price='$price',
               image='$image',
               category='$category',
               stock='$stock'

               WHERE id='$id'";

    $update_result = mysqli_query($conn, $update);

    if($update_result){

        header("Location: admin_dashboard.php");

    } else {

        echo "Failed to update product.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Product</title>

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

.btn-update{

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

.btn-update:hover{

    transform: translateY(-3px);

    color: white;
}

.current-image{

    width: 120px;

    border-radius: 10px;

    margin-top: 10px;
}

</style>

</head>

<body>

<div class="container">

    <div class="product-card">

        <h2 class="title">

            Edit Product

        </h2>

        <form method="POST"
              enctype="multipart/form-data">

            <div class="mb-3">

                <label class="form-label">

                    Product Name

                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="<?php echo $product['name']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Description

                </label>

                <textarea name="description"
                          class="form-control"
                          rows="4"
                          required><?php echo $product['description']; ?></textarea>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Price ($)

                </label>

                <input type="number"
                       step="0.01"
                       name="price"
                       class="form-control"
                       value="<?php echo $product['price']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Category

                </label>

                <input type="text"
                       name="category"
                       class="form-control"
                       value="<?php echo $product['category']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Stock Quantity

                </label>

                <input type="number"
                       name="stock"
                       class="form-control"
                       value="<?php echo $product['stock']; ?>"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Current Image

                </label>

                <br>

                <img src="<?php echo $product['image']; ?>"
                     class="current-image">

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Upload New Image

                </label>

                <input type="file"
                       name="image"
                       class="form-control"
                       accept="image/*">

            </div>

            <button type="submit"
                    name="update_product"
                    class="btn btn-update">

                Update Product

            </button>

        </form>

    </div>

</div>

</body>
</html>