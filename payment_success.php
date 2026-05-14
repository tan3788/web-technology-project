<?php
require_once 'config.php';

// Check if payment was successful
if (!isset($_SESSION['payment_success']) || !$_SESSION['payment_success']) {
    header("Location: index.php");
    exit();
}

$transactionId = $_SESSION['transaction_id'];
$amount = $_SESSION['payment_amount'];

// Clear payment session data
unset($_SESSION['payment_success']);
unset($_SESSION['transaction_id']);
unset($_SESSION['payment_amount']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Simple Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .success-container {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
            text-align: center;
        }
        .success-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .transaction-details {
            background: white;
            color: #333;
            padding: 2rem;
            border-radius: 10px;
            margin-top: 2rem;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-shop"></i> Simple Store
            </a>
            
            <div class="d-flex">
                <a href="cart.php" class="btn btn-outline-light">
                    <i class="bi bi-cart"></i> Cart 
                    <span class="badge bg-warning text-dark">0</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="success-container">
                    <div class="success-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h1 class="mb-3">Payment Successful!</h1>
                    <p class="lead mb-0">Thank you for your purchase. Your order has been confirmed.</p>
                    
                    <div class="transaction-details">
                        <h5 class="mb-3">Transaction Details</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Transaction ID:</strong>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $transactionId; ?>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <strong>Amount Paid:</strong>
                            </div>
                            <div class="col-sm-6">
                                ৳<?php echo number_format($amount, 2); ?>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <strong>Payment Method:</strong>
                            </div>
                            <div class="col-sm-6">
                                bKash Mobile Banking
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <strong>Date & Time:</strong>
                            </div>
                            <div class="col-sm-6">
                                <?php echo date('F j, Y g:i A'); ?>
                            </div>
                        </div>
                        
                        <hr>
                        
                       
                        
                        <div class="d-grid gap-2">
                            <a href="index.php" class="btn btn-primary">
                                <i class="bi bi-house"></i> Continue Shopping
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
