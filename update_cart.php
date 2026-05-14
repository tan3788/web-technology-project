<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$action = $_POST['action'] ?? '';
$productId = (int)($_POST['product_id'] ?? 0);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

switch ($action) {
    case 'update_quantity':
        $quantity = (int)($_POST['quantity'] ?? 0);
        
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
        
        break;
        
    case 'remove_item':
        unset($_SESSION['cart'][$productId]);
        break;
        
    case 'clear_cart':
        $_SESSION['cart'] = array();
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit();
}

// Calculate updated cart data
$cartItems = array();
$total = 0;
$cartCount = 0;

if (!empty($_SESSION['cart'])) {
    $productIds = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products WHERE id IN ($productIds)";
    $result = mysqli_query($conn, $query);
    
    while ($product = mysqli_fetch_assoc($result)) {
        if (isset($_SESSION['cart'][$product['id']])) {
            $quantity = $_SESSION['cart'][$product['id']];
            $subtotal = $product['price'] * $quantity;
            $total += $subtotal;
            $cartCount += $quantity;
            
            $cartItems[] = array(
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'subtotal' => $subtotal
            );
        }
    }
}

echo json_encode([
    'success' => true,
    'cartItems' => $cartItems,
    'total' => $total,
    'cartCount' => $cartCount,
    'message' => 'Cart updated successfully'
]);
?>
