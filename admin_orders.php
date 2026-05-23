<?php

require_once 'config.php';

$sql = "SELECT * FROM orders ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Admin Orders - SimpleStore</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>

body{
    background: #f8f1e7;
    font-family: Arial, sans-serif;
}

.orders-container{

    width: 95%;

    margin: 40px auto;

    background: white;

    padding: 30px;

    border-radius: 20px;

    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.title{

    color: #4f46e5;

    margin-bottom: 30px;

    font-weight: bold;
}

.status-pending{
    color: orange;
    font-weight: bold;
}

.status-accepted{
    color: green;
    font-weight: bold;
}

.status-rejected{
    color: red;
    font-weight: bold;
}

</style>

</head>

<body>

<div class="orders-container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="title">

            Orders Management

        </h2>

        <a href="admin_dashboard.php"
           class="btn btn-secondary">

           Back to Dashboard

        </a>

    </div>

    <table class="table table-bordered table-hover">

        <thead class="table-dark">

            <tr>

                <th>ID</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Payment</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

        <?php while($order = mysqli_fetch_assoc($result)){ ?>

            <tr>

                <td>
                    <?php echo $order['id']; ?>
                </td>

                <td>
                    <?php echo $order['customer_name']; ?>
                </td>

                <td>
                    <?php echo $order['customer_email']; ?>
                </td>

                <td>
                    <?php echo $order['payment_method']; ?>
                </td>

                <td>
                    $<?php echo $order['total_amount']; ?>
                </td>

                <td>

<?php

$status = $order['order_status'];

if($status == "Pending"){

    echo "<span class='status-pending'>Pending</span>";

} elseif($status == "Accepted"){

    echo "<span class='status-accepted'>Accepted</span>";

} else {

    echo "<span class='status-rejected'>Rejected</span>";
}

?>

                </td>

                <td>
                    <?php echo $order['created_at']; ?>
                </td>

                <td>

                    <a href='update_order_status.php?id=<?php echo $order['id']; ?>&status=Accepted'
                       class='btn btn-success btn-sm'>

                       Accept

                    </a>

                    <a href='update_order_status.php?id=<?php echo $order['id']; ?>&status=Rejected'
                       class='btn btn-danger btn-sm'>

                       Reject

                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>