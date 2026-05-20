<?php
session_start();
?>

<?php
require_once 'config.php';

// Get search and category filters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Build query with filters
$query = "SELECT * FROM products WHERE 1=1";
if (!empty($search)) {
    $query .= " AND name LIKE '%$search%'";
}
if (!empty($category)) {
    $query .= " AND category = '$category'";
}
$query .= " ORDER BY name";

$result = mysqli_query($conn, $query);

// Get all categories for filter dropdown
$categoryQuery = "SELECT DISTINCT category FROM products ORDER BY category";
$categoryResult = mysqli_query($conn, $categoryQuery);

// Get cart item count
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple E-commerce Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<style>

body.dark-mode{
    background-color: #121212;
    color: white;
}

body.dark-mode .card{
    background-color: #1f1f1f;
    color: white;
}

body.dark-mode .navbar{
    background-color: #000 !important;
}

body.dark-mode .text-muted{
    color: #bdbdbd !important;
}

</style>

</head>



<body>
    <!-- Navigation -->
     <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
         <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-shop"></i> Simple Store
            </a>
            
             <div class="d-flex align-items-center">

                 <?php if(isset($_SESSION['username'])) { ?>

                     <a href="profile.php" class="btn btn-light me-2">
                        Profile
                     </a>

                     <a href="cart.php" class="btn btn-outline-light me-2">
                         <i class="bi bi-cart"></i> Cart 
                         <?php if ($cartCount > 0): ?>
                            <span class="badge bg-warning text-dark">
                               <?php echo $cartCount; ?>
                            </span>
                         <?php endif; ?>
                     </a>

                     <button onclick="toggleDarkMode()" 
                             class="btn btn-dark me-2">

                          Dark Mode
                     </button>

                     <a href="logout.php" class="btn btn-danger">
                         Logout
                     </a>

                 <?php } else { ?>

                     <a href="login.php" class="btn btn-light me-2">
                       Login
                     </a>

                     <a href="register.php" class="btn btn-success me-2">
                       Register
                     </a>

                     <a href="cart.php" class="btn btn-outline-light">
                        <i class="bi bi-cart"></i> Cart 
                         <?php if ($cartCount > 0): ?>
                             <span class="badge bg-warning text-dark">
                                 <?php echo $cartCount; ?>
                             </span>
                         <?php endif; ?>
                     </a>

                 <?php } ?>

             </div>
            
         </div>
     </nav>

    <div class="container py-4">
        <h1 class="mb-4">Our Products</h1>
        
        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form method="GET" class="d-flex">
                    <input type="text" class="form-control me-2" name="search" 
                           placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-4">
                <form method="GET">
                    <?php if (!empty($search)): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <?php endif; ?>
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <?php while ($cat = mysqli_fetch_assoc($categoryResult)): ?>
                            <option value="<?php echo $cat['category']; ?>" 
                                    <?php echo ($category == $cat['category']) ? 'selected' : ''; ?>>
                                <?php echo $cat['category']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 style="height: 200px; object-fit: cover; background-color: #f8f9fa;"
                                 onerror="this.onerror=null; this.src='placeholder.php?w=300&h=200&text=<?php echo urlencode($product['name']); ?>&bg=e9ecef&color=6c757d';"
                                 loading="lazy">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    <?php echo htmlspecialchars($product['description']); ?>
                                </p>
                                <div class="mb-2">
                                    <span class="badge bg-secondary"><?php echo $product['category']; ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="text-primary mb-0">৳<?php echo number_format($product['price'], 2); ?></h5>
                                    <button type="button" class="btn btn-primary btn-sm add-to-cart-btn" 
                                            data-product-id="<?php echo $product['id']; ?>"
                                            data-product-name="<?php echo htmlspecialchars($product['name']); ?>">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-search"></i> No products found.
                    </div>
                </div>
            <?php endif; ?>
        </div>
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
                Product added to cart successfully!
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize toast
        const toast = new bootstrap.Toast(document.getElementById('cartToast'));
        
        // Add to cart functionality with AJAX
        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const originalContent = this.innerHTML;
                
                // Show loading state
                this.innerHTML = '<i class="bi bi-hourglass-split"></i> Adding...';
                this.disabled = true;
                
                // Make AJAX request
                fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'product_id=' + productId + '&action=add'
                })
                .then(response => response.json())
                .then(data => {
                    // Restore button
                    this.innerHTML = originalContent;
                    this.disabled = false;
                    
                    if (data.success) {
                        // Update cart count in navbar
                        const cartLink = document.querySelector('a[href="cart.php"]');
                        const cartBadge = cartLink.querySelector('.badge');
                        
                        if (cartBadge) {
                            cartBadge.textContent = data.cartCount;
                        } else if (data.cartCount > 0) {
                            // Create badge if it doesn't exist
                            const badge = document.createElement('span');
                            badge.className = 'badge bg-warning text-dark';
                            badge.textContent = data.cartCount;
                            cartLink.appendChild(document.createTextNode(' '));
                            cartLink.appendChild(badge);
                        }
                        
                        // Show success toast
                        document.getElementById('toastMessage').textContent = 
                            `${productName} added to cart successfully!`;
                        document.querySelector('.toast-header i').className = 'bi bi-cart-check text-success me-2';
                        document.querySelector('.toast-header strong').textContent = 'Cart Updated';
                        toast.show();
                    } else {
                        // Show error toast
                        document.getElementById('toastMessage').textContent = 
                            data.message || 'Failed to add product to cart';
                        document.querySelector('.toast-header i').className = 'bi bi-exclamation-triangle text-danger me-2';
                        document.querySelector('.toast-header strong').textContent = 'Error';
                        toast.show();
                    }
                })
                .catch(error => {
                    // Restore button and show error
                    this.innerHTML = originalContent;
                    this.disabled = false;
                    
                    document.getElementById('toastMessage').textContent = 'Network error occurred';
                    document.querySelector('.toast-header i').className = 'bi bi-exclamation-triangle text-danger me-2';
                    document.querySelector('.toast-header strong').textContent = 'Error';
                    toast.show();
                });
            });
        });
    </script>

    <!-- DarkMode -->
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
