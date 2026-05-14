<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
    $isAdd = isset($_POST['action']) && $_POST['action'] == 'add';
    
    // Verify product exists
    $query = "SELECT id, name FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        
        // Initialize cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        
        // Add or increment product in cart
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        } else {
            $_SESSION['cart'][$productId] = 1;
        }
        
        $cartCount = array_sum($_SESSION['cart']);
        
        if ($isAdd) {
            // Return JSON response for AJAX requests
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $product['name'] . ' added to cart successfully!',
                'cartCount' => $cartCount
            ]);
            exit();
        } else {
            // Set success message for regular form submissions
            $_SESSION['message'] = "Product added to cart successfully!";
            $_SESSION['message_type'] = "success";
        }
    } else {
        if ($isAdd) {
            // Return JSON error response for AJAX requests
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Product not found!'
            ]);
            exit();
        } else {
            $_SESSION['message'] = "Product not found!";
            $_SESSION['message_type'] = "danger";
        }
    }
}

// Redirect back to products page (for non-AJAX requests)
if (!isset($_POST['action']) || $_POST['action'] != 'add') {
    header("Location: index.php");
    exit();
}
?>
