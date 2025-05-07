<?php
session_start();
include 'connection.php';
include 'functions.php';

$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';

// Get all products with their stock information
$sql = "SELECT p.ProductID, p.Product_Name, p.Description, p.Price, p.product_image, p.Category, i.Stock 
        FROM product p 
        LEFT JOIN inventory i ON p.ProductID = i.ProductID";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EazyMart - Home</title>
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <!-- Navigation -->
    <nav class="top-nav">
      <div class="nav-container">
        <img src="images/Eazy.png" alt="EazyMart Logo" class="logo" />
        <div class="nav-right">
          <div class="nav-links">
            <a href="index.php" class="active">Home</a>
            <a href="Products/products.php">Products</a>
            <a href="Orders/orders.php">Orders</a>
            <a href="Profile/profile.php">Profile</a>
            <a href="Cart/cart.php">Cart</a>
            <a href="feedback/feedback.php">Feedback</a>
          </div>
          <div class="search-box">
            <input type="text" placeholder="Search products..." />
            <button type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
          <div class="profile-section">
            <img src="images/team2.jpg" alt="Profile" class="profile-image" />
            <div class="profile-info">
              <div class="profile-text"><?php echo $user_name; ?></div>
              <?php if ($user_name !== 'Guest') { ?>
                <a href="../login/logout.php" class="logout-btn">Logout</a>
              <?php } else { ?>
                <a href="../login/login.php" class="logout-btn">Login</a>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main>
      <h1>Welcome to EazyMart</h1>

      <!-- Product Grid -->
      <div class="product-grid">
        <?php
        // Check if we have products
        if (mysqli_num_rows($result) > 0) {
            // Loop through each product
            while ($row = mysqli_fetch_assoc($result)) {
                // Get stock information
                $stock = $row['Stock'];
                $stock_status = ($stock > 0) ? 'In Stock' : 'Out of Stock';
                $stock_class = ($stock > 0) ? 'in-stock' : 'out-of-stock';
                ?>
                <div class="product">
                    <img src="<?php echo $row['product_image']; ?>" alt="<?php echo $row['Product_Name']; ?>" />
                    <h3><?php echo $row['Product_Name']; ?></h3>
                    <p class="price">$<?php echo number_format($row['Price'], 2); ?></p>
                    <p class="stock <?php echo $stock_class; ?>">
                        <i class="fas <?php echo ($stock > 0) ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                        <?php echo $stock_status; ?> (<?php echo $stock; ?>)
                    </p>
                    <button onclick="addToCart(<?php echo $row['ProductID']; ?>)">Add to Cart</button>
                </div>
                <?php
            }
        } else {
            echo '<p class="no-products">No products available at the moment.</p>';
        }
        ?>
      </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
      <div class="footer-content">
        <div>
          <h3>About EazyMart</h3>
          <p>
            Your one-stop shop for all your daily needs. Quality products at
            affordable prices.
          </p>
        </div>
        <div>
          <h3>Quick Links</h3>
          <a href="index.php">Home</a>
          <a href="Products/products.php">Products</a>
          <a href="Orders/orders.php">Orders</a>
          <a href="Profile/profile.php">Profile</a>
        </div>
        <div>
          <h3>Contact</h3>
          <p>Email: meownna@eazymart.com</p>
          <p>Phone: +880-191-093-9833</p>
        </div>
      </div>
      <p class="copyright">&copy; 2025 EazyMart. All rights reserved.</p>
    </footer>

    <script>
    function addToCart(productId) {
        // You can implement the add to cart functionality here
        alert('Product added to cart!');
    }
    </script>
  </body>
</html>
