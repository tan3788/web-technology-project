<?php
require_once 'config.php';

// Handle cart updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $productId => $quantity) {
            $quantity = (int)$quantity;
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$productId]);
            } else {
                $_SESSION['cart'][$productId] = $quantity;
            }
        }
        $_SESSION['message'] = "Cart updated successfully!";
        $_SESSION['message_type'] = "success";
    }
    
    if (isset($_POST['remove_item'])) {
        $productId = (int)$_POST['product_id'];
        unset($_SESSION['cart'][$productId]);
        $_SESSION['message'] = "Item removed from cart!";
        $_SESSION['message_type'] = "info";
    }
    
    if (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['message'] = "Cart cleared!";
        $_SESSION['message_type'] = "info";
    }
    
    header("Location: cart.php");
    exit();
}

// Get cart items
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Simple Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Shopping Cart</h1>
            <a href="index.php" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Continue Shopping
            </a>
        </div>

        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show">
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <?php if (!empty($cartItems)): ?>
            <form method="POST">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="<?php echo htmlspecialchars($item['product']['image']); ?>" 
                                                         alt="<?php echo htmlspecialchars($item['product']['name']); ?>"
                                                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover; background-color: #f8f9fa;"
                                                         onerror="this.onerror=null; this.src='placeholder.php?w=60&h=60&text=<?php echo urlencode($item['product']['name']); ?>&bg=e9ecef&color=6c757d';"
                                                         loading="lazy">
                                                    <div>
                                                        <h6 class="mb-0"><?php echo htmlspecialchars($item['product']['name']); ?></h6>
                                                        <small class="text-muted"><?php echo $item['product']['category']; ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>৳<?php echo number_format($item['product']['price'], 2); ?></td>
                                            <td>
                                                <input type="number" 
                                                       name="quantity[<?php echo $item['product']['id']; ?>]" 
                                                       value="<?php echo $item['quantity']; ?>" 
                                                       min="1" max="99" 
                                                       class="form-control quantity-input" 
                                                       style="width: 80px;"
                                                       data-product-id="<?php echo $item['product']['id']; ?>"
                                                       data-price="<?php echo $item['product']['price']; ?>">
                                            </td>
                                            <td class="subtotal-cell" data-product-id="<?php echo $item['product']['id']; ?>">
                                                ৳<?php echo number_format($item['subtotal'], 2); ?>
                                            </td>
                                            <td>
                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-sm remove-item-btn"
                                                        data-product-id="<?php echo $item['product']['id']; ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <button type="submit" name="clear_cart" class="btn btn-outline-secondary">
                            <i class="bi bi-trash"></i> Clear Cart
                        </button>
    
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Order Summary</h5>
                                <div class="d-flex justify-content-between">
                                    <span>Total Items:</span>
                                    <span id="total-items"><?php echo $cartCount; ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <strong>Total Amount:</strong>
                                    <strong id="total-amount">৳<?php echo number_format($total, 2); ?></strong>
                                </div>
                                <hr>
                                <a href="payment.php" class="btn btn-success w-100">
                                    <i class="bi bi-phone"></i> Pay with bKash
                                </a>
                                <small class="text-muted mt-2 d-block text-center">
                                    Secure payment via bKash Mobile Banking
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                <h3 class="mt-3">Your cart is empty</h3>
                <p class="text-muted">Start shopping to add items to your cart.</p>
                <a href="index.php" class="btn btn-primary">
                    <i class="bi bi-shop"></i> Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-cart-check text-success me-2"></i>
                <strong class="me-auto">Cart Updated</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Cart updated successfully!
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize toast
        const toast = new bootstrap.Toast(document.getElementById('cartToast'));
        
        // Function to show toast with message
        function showToast(message, isError = false) {
            document.getElementById('toastMessage').textContent = message;
            const icon = document.querySelector('.toast-header i');
            const title = document.querySelector('.toast-header strong');
            
            if (isError) {
                icon.className = 'bi bi-exclamation-triangle text-danger me-2';
                title.textContent = 'Error';
            } else {
                icon.className = 'bi bi-cart-check text-success me-2';
                title.textContent = 'Cart Updated';
            }
            
            toast.show();
        }
        
        // Function to update cart display
        function updateCartDisplay(data) {
            // Update total items and amount
            document.getElementById('total-items').textContent = data.cartCount;
            document.getElementById('total-amount').textContent = '৳' + data.total.toFixed(2);
            
            // Update navbar cart count
            const cartLink = document.querySelector('a[href="cart.php"]');
            const cartBadge = cartLink.querySelector('.badge');
            
            if (cartBadge) {
                if (data.cartCount > 0) {
                    cartBadge.textContent = data.cartCount;
                } else {
                    cartBadge.remove();
                }
            } else if (data.cartCount > 0) {
                const badge = document.createElement('span');
                badge.className = 'badge bg-warning text-dark';
                badge.textContent = data.cartCount;
                cartLink.appendChild(document.createTextNode(' '));
                cartLink.appendChild(badge);
            }
            
            // Update individual subtotals
            data.cartItems.forEach(item => {
                const subtotalCell = document.querySelector(`.subtotal-cell[data-product-id="${item.id}"]`);
                if (subtotalCell) {
                    subtotalCell.textContent = '৳' + item.subtotal.toFixed(2);
                }
            });
        }
        
        // Function to remove row from table
        function removeCartRow(productId) {
            // Find the row by looking for any element with the product ID and traversing up to the row
            const element = document.querySelector(`[data-product-id="${productId}"]`);
            if (element) {
                const row = element.closest('tr');
                if (row) {
                    row.remove();
                }
            }
            
            // Check if cart is empty
            const tableBody = document.querySelector('tbody');
            if (tableBody && tableBody.children.length === 0) {
                // Show empty cart message instead of reloading
                showEmptyCartMessage();
            }
        }
        
        // Function to show empty cart message
        function showEmptyCartMessage() {
            // Hide the cart table and buttons
            const cartTable = document.querySelector('.card');
            const cartButtons = document.querySelector('.row.mt-4');
            
            if (cartTable) cartTable.style.display = 'none';
            if (cartButtons) cartButtons.style.display = 'none';
            
            // Create empty cart message
            const container = document.querySelector('.container');
            const emptyMessage = document.createElement('div');
            emptyMessage.innerHTML = `
                <div class="text-center py-5">
                    <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
                    <h3 class="mt-3">Your cart is empty</h3>
                    <p class="text-muted">Start shopping to add items to your cart.</p>
                    <a href="index.php" class="btn btn-primary">
                        <i class="bi bi-shop"></i> Start Shopping
                    </a>
                </div>
            `;
            
            // Add the empty message after the header
            const header = document.querySelector('.d-flex.justify-content-between.align-items-center.mb-4');
            if (header) {
                header.insertAdjacentElement('afterend', emptyMessage);
            }
        }
        
        // Quantity input change handlers
        document.querySelectorAll('.quantity-input').forEach(input => {
            let timeoutId;
            
            input.addEventListener('input', function() {
                clearTimeout(timeoutId);
                const productId = this.getAttribute('data-product-id');
                const quantity = parseInt(this.value) || 0;
                
                // Debounce the API call
                timeoutId = setTimeout(() => {
                    updateCartItem(productId, quantity, 'update_quantity');
                }, 500);
            });
        });
        
        // Remove item button handlers
        document.querySelectorAll('.remove-item-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    updateCartItem(productId, 0, 'remove_item');
                }
            });
        });
        
        // Function to update cart item via AJAX
        function updateCartItem(productId, quantity, action) {
            const formData = new FormData();
            formData.append('action', action);
            formData.append('product_id', productId);
            if (quantity > 0) {
                formData.append('quantity', quantity);
            }
            
            fetch('update_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (action === 'remove_item' || quantity === 0) {
                        removeCartRow(productId);
                        // Still need to update the display for remaining items
                        updateCartDisplay(data);
                        showToast('Item removed from cart');
                    } else {
                        updateCartDisplay(data);
                        showToast('Cart updated successfully');
                    }
                } else {
                    showToast(data.message || 'Failed to update cart', true);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Network error occurred', true);
            });
        }
        
        // Clear cart functionality (keep the existing form submission for this)
        const clearCartBtn = document.querySelector('button[name="clear_cart"]');
        if (clearCartBtn) {
            clearCartBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (confirm('Are you sure you want to clear the entire cart?')) {
                    updateCartItem(0, 0, 'clear_cart');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });
        }
    </script>
</body>
</html>
