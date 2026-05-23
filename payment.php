<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

?>

<?php
require_once 'config.php';

// Check if user has items in cart
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['message'] = "Your cart is empty!";
    $_SESSION['message_type'] = "warning";
    header("Location: cart.php");
    exit();
}

// Get cart items and calculate total
$cartItems = array();
$total = 0;

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $productIds = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products WHERE id IN ($productIds)";
    $result = mysqli_query($conn, $query);
    
    while ($product = mysqli_fetch_assoc($result)) {
        $quantity = $_SESSION['cart'][$product['id']];
        $subtotal = $product['price'] * $quantity;
        $total += $subtotal;
        
        $cartItems[] = array(
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $subtotal
        );
    }
}

$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

// Handle payment processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debug: Check what data is being received
    error_log("POST data received: " . print_r($_POST, true));
    
    if (isset($_POST['process_payment'])) {
        $bkashNumber = trim($_POST['bkash_number']);
        $pin = $_POST['bkash_pin'];
        
        // Simple validation
        if (empty($bkashNumber) || empty($pin)) {
            $error = "Please fill in all required fields.";
        } elseif (strlen($bkashNumber) != 11 || !is_numeric($bkashNumber)) {
            $error = "Please enter a valid 11-digit mobile number.";
        } elseif (strlen($pin) != 5 || !is_numeric($pin)) {
            $error = "bKash PIN must be exactly 5 digits.";
        } else {
            // Simulate payment processing (demo mode)
            sleep(2); // Simulate processing time
            
            $paymentSuccess = TRUE;

            if ($paymentSuccess) {
                // Generate transaction ID
                $transactionId = 'BKT' . date('Ymd') . rand(100000, 999999);
                
                // Clear cart
                $_SESSION['cart'] = array();
                
                // Set success message
                $_SESSION['payment_success'] = true;
                $_SESSION['transaction_id'] = $transactionId;
                $_SESSION['payment_amount'] = $total;
                
                // Debug: Log before redirect
                error_log("Attempting redirect to payment_success.php");
                
                header("Location: payment_success.php");
                exit();
            } else {
                $error = "Payment failed! Please try again or check your bKash account balance.";
            }
        }
    } else {
        // Debug: POST request without process_payment
        $error = "Invalid form submission. Please try again.";
        error_log("POST request received but no process_payment field");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bKash Payment - Simple Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .bkash-container {
            background: linear-gradient(135deg, #e2136e, #ff4081);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(226, 19, 110, 0.3);
        }
        .bkash-logo {
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
        }
        .payment-form {
            background: white;
            color: #333;
            padding: 2rem;
            border-radius: 10px;
            margin-top: 1rem;
        }
        .order-summary {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid #e2136e;
        }
        .payment-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .loader-content {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #f3f3f3;
            border-top: 6px solid #e2136e;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        body.dark-mode{
    background-color: #121212;
    color: white;
}
/* Full Page */

body.dark-mode,
body.dark-mode main,
body.dark-mode section,
body.dark-mode .container,
body.dark-mode .container-fluid{
    background-color: #121212 !important;
    color: white;
}

/* Navbar */

body.dark-mode .navbar{
    background-color: #000 !important;
}

body.dark-mode .navbar .nav-link,
body.dark-mode .navbar .navbar-brand,
body.dark-mode .navbar span,
body.dark-mode .navbar i{
    color: white !important;
}

/* Bootstrap Containers */

body.dark-mode .bg-light{
    background-color: #121212 !important;
}

body.dark-mode .bg-white{
    background-color: #1f1f1f !important;
}

/* Buttons */

body.dark-mode .btn-outline-dark{
    color: white;
    border-color: white;
}

body.dark-mode .btn-outline-dark:hover{
    background-color: white;
    color: black;
}

/* Cards */

body.dark-mode .card{
    background-color: #1f1f1f;
    color: white;
}

/* Payment Form */

body.dark-mode .payment-form{
    background-color: #1f1f1f;
    color: white;
}

/* Order Summary */

body.dark-mode .order-summary{
    background-color: #2a2a2a;
    color: white;
    border-left: 4px solid #ff4081;
}

/* Loader */

body.dark-mode .loader-content{
    background-color: #1f1f1f;
    color: white;
}

/* bKash Container */

body.dark-mode .bkash-container{
    background: linear-gradient(135deg, #9d174d, #be185d);
}

/* Inputs */

body.dark-mode .form-control{
    background-color: #2a2a2a;
    color: white;
    border: 1px solid #444;
}

body.dark-mode .form-control::placeholder{
    color: #bdbdbd;
}

body.dark-mode .form-control:focus{
    background-color: #2a2a2a;
    color: white;
    border-color: #6366f1;
    box-shadow: none;
}

/* Labels & Text */

body.dark-mode label,
body.dark-mode h1,
body.dark-mode h2,
body.dark-mode h3,
body.dark-mode h4,
body.dark-mode h5,
body.dark-mode h6,
body.dark-mode p,
body.dark-mode span{
    color: white;
}

/* Tables */

body.dark-mode .table{
    color: white;
}

body.dark-mode .table td,
body.dark-mode .table th{
    border-color: #444;
}

/* Bootstrap Helpers */

body.dark-mode .text-dark{
    color: white !important;
}

body.dark-mode .bg-white{
    background-color: #1f1f1f !important;
}

/* Footer */

footer{
    border-top: 2px solid #444;
    transition: 0.3s;
}

</style>

</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-shop"></i> Simple Store
            </a>
            
            <div class="d-flex">
                <a href="cart.php" class="btn btn-outline-light">
                    <i class="bi bi-cart"></i> Cart 
                    <?php if ($cartCount > 0): ?>
                        <span class="badge bg-warning text-dark"><?php echo $cartCount; ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bkash-container">
                    <div class="bkash-logo">
                        <i class="bi bi-phone"></i> bKash Payment
                    </div>
                    <p class="text-center mb-0">Secure payment gateway for Bangladesh</p>
                    
                    <div class="payment-form">
                        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> POST request received. Data: <?php echo json_encode($_POST); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle"></i> <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-md-7">
                                <h5 class="mb-3">Payment Details</h5>
                                <form method="POST" id="paymentForm">
                                    <div class="mb-3">
                                        <label for="bkash_number" class="form-label">bKash Account Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+880</span>
                                            <input type="text" class="form-control" id="bkash_number" name="bkash_number" 
                                                   placeholder="17XXXXXXXX" maxlength="11" required
                                                   value="<?php echo isset($_POST['bkash_number']) ? htmlspecialchars($_POST['bkash_number']) : ''; ?>">
                                        </div>
                                        <div class="form-text">Enter your 11-digit bKash mobile number</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="bkash_pin" class="form-label">bKash PIN</label>
                                        <input type="password" class="form-control" id="bkash_pin" name="bkash_pin" 
                                               placeholder="Enter 5-digit PIN" maxlength="5" required>
                                        <div class="form-text">Enter your bKash 5-digit PIN</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="agree_terms" required>
                                            <label class="form-check-label" for="agree_terms">
                                                I agree to the terms and conditions and authorize this payment
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="process_payment" value="1">
                                    <button type="submit" class="btn btn-danger w-100" id="payBtn">
                                        <i class="bi bi-credit-card"></i> Pay $<?php echo number_format($total, 2); ?>
                                    </button>
                                </form>
                            </div>
                            
                            <div class="col-md-5">
                                <div class="order-summary">
                                    <h5 class="mb-3">Order Summary</h5>
                                    <?php foreach ($cartItems as $item): ?>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><?php echo htmlspecialchars($item['product']['name']); ?> × <?php echo $item['quantity']; ?></span>
                                            <span>$<?php echo number_format($item['subtotal'], 2); ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total</span>
                                        <span>$<?php echo number_format($total, 2); ?></span>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <a href="cart.php" class="btn btn-outline-secondary w-100">
                                        <i class="bi bi-arrow-left"></i> Back to Cart
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Processing Loader -->
    <div class="payment-loader" id="paymentLoader">
        <div class="loader-content">
            <div class="spinner"></div>
            <h4 class="mb-3">Processing Payment</h4>
            <p class="text-muted mb-3">Please wait while we process your bKash payment...</p>
            <small class="text-muted">Do not close this window or press back button</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check if there's an error on page load and hide loader if needed
        <?php if (isset($error)): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('paymentLoader');
            if (loader) {
                loader.style.display = 'none';
            }
        });
        <?php endif; ?>
        
        // Format bKash number input
        document.getElementById('bkash_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) {
                value = value.substr(0, 11);
            }
            e.target.value = value;
        });
        
        // Format PIN input
        document.getElementById('bkash_pin').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substr(0, 5);
            }
            e.target.value = value;
        });
        
        // Handle form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            console.log('Form submission started');
            
            const loader = document.getElementById('paymentLoader');
            const payBtn = document.getElementById('payBtn');
            
            // Show loader immediately when form is submitted
            loader.style.display = 'flex';
            payBtn.disabled = true;
            
            // Allow the form to submit naturally
            // The loader will be visible during server processing
        });
    </script>

    <script>

function toggleDarkMode(){

    document.body.classList.toggle("dark-mode");

    if(document.body.classList.contains("dark-mode")){
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
}

if(localStorage.getItem("theme") === "dark"){
    document.body.classList.add("dark-mode");
}

</script>
</body>
</html>
