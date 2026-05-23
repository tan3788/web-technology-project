<?php

include 'config.php';

$sql = "SELECT * FROM products ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Admin Dashboard</h2>

        <a href="add_product.php"
           class="btn btn-success">

           Add Product

        </a>
        <a href="admin_orders.php"
   class="btn btn-primary ms-2">

   View Orders

</a>

    </div>

    <table class="table table-bordered table-hover bg-white">

        <thead class="table-dark">

            <tr>

                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

        <?php while($product = mysqli_fetch_assoc($result)){ ?>

            <tr>

                <td>
                    <?php echo $product['id']; ?>
                </td>

                <td>

                    <img src="<?php echo $product['image']; ?>"
                         width="70">

                </td>

                <td>
                    <?php echo $product['name']; ?>
                </td>

                <td>
                    $<?php echo $product['price']; ?>
                </td>

                <td>
                    <?php echo $product['category']; ?>
                </td>

                <td>

                    <a href="edit_product.php?id=<?php echo $product['id']; ?>"
                       class="btn btn-primary btn-sm">

                       Edit

                    </a>

                    <a href="delete_product.php?id=<?php echo $product['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete this product?')">

                       Delete

                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>