<?php
session_start();
include '../connection.php';

$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';

$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

// Base SQL query
$sql = "SELECT p.*, i.Stock 
        FROM product p 
        LEFT JOIN inventory i ON p.ProductID = i.ProductID";

// Add category filter if not 'all'
if ($category != 'all') {
    $sql .= " WHERE p.Category = '$category'";
}

// Add sorting based on price
if ($sort == 'price_low') {
    $sql .= " ORDER BY p.Price ASC";
} elseif ($sort == 'price_high') {
    $sql .= " ORDER BY p.Price DESC";
}

// Execute the query
$result = mysqli_query($con, $sql);

// Get all unique categories for the filter
$categories_query = "SELECT DISTINCT Category FROM product";
$categories_result = mysqli_query($con, $categories_query);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Products - EazyMart</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="products.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <!-- Navigation -->
    <nav class="top-nav">
      <div class="nav-container">
        <img src="../images/Eazy.png" alt="EazyMart Logo" class="logo" />
        <div class="nav-right">
          <div class="nav-links">
            <a href="../index.php">Home</a>
            <a href="products.php" class="active">Products</a>
            <a href="../Orders/orders.php">Orders</a>
            <a href="../Profile/profile.php">Profile</a>
            <a href="../Cart/cart.php">Cart</a>
            <a href="../feedback/feedback.php">Feedback</a>
          </div>
          <div class="search-box">
            <input
              type="text"
              placeholder="Search products..."
              id="searchInput"
            />
            <button type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
          <div class="profile-section">
            <img src="../images/team2.jpg" alt="Profile" class="profile-image" />
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
      <h1>Our Products</h1>

      <!-- Filters -->
      <div class="filters">
        <!-- Category Filter -->
        <div class="filter-group">
          <h3>Category</h3>
          <div class="category-filter">
            <a href="?category=all&sort=<?php echo $sort; ?>" 
               class="filter-btn <?php echo $category == 'all' ? 'active' : ''; ?>">
              All
            </a>
            <?php while ($cat = mysqli_fetch_assoc($categories_result)): ?>
              <a href="?category=<?php echo $cat['Category']; ?>&sort=<?php echo $sort; ?>" 
                 class="filter-btn <?php echo $category == $cat['Category'] ? 'active' : ''; ?>">
                <?php echo $cat['Category']; ?>
              </a>
            <?php endwhile; ?>
          </div>
        </div>

        <!-- Price Sort -->
        <div class="filter-group">
          <h3>Sort by Price</h3>
          <div class="sort-filter">
            <a href="?category=<?php echo $category; ?>&sort=default" 
               class="filter-btn <?php echo $sort == 'default' ? 'active' : ''; ?>">
              Default
            </a>
            <a href="?category=<?php echo $category; ?>&sort=price_low" 
               class="filter-btn <?php echo $sort == 'price_low' ? 'active' : ''; ?>">
              Low to High
            </a>
            <a href="?category=<?php echo $category; ?>&sort=price_high" 
               class="filter-btn <?php echo $sort == 'price_high' ? 'active' : ''; ?>">
              High to Low
            </a>
          </div>
        </div>
      </div>

      <!-- Product Grid -->
      <div class="product-grid">
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="product">
              <img src="<?php echo $row['product_image']; ?>" 
                   alt="<?php echo $row['Product_Name']; ?>">
              <h3><?php echo $row['Product_Name']; ?></h3>
              <p class="price">$<?php echo number_format($row['Price'], 2); ?></p>
              <p class="stock <?php echo $row['Stock'] > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                <i class="fas <?php echo $row['Stock'] > 0 ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                <?php echo $row['Stock'] > 0 ? 'In Stock' : 'Out of Stock'; ?>
              </p>
              <button onclick="addToCart(<?php echo $row['ProductID']; ?>)">Add to Cart</button>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p class="no-products">No products available in this category.</p>
        <?php endif; ?>
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
          <a href="../index.php">Home</a>
          <a href="products.php">Products</a>
          <a href="../Orders/orders.php">Orders</a>
          <a href="../Profile/profile.php">Profile</a>
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
        alert('Product ' + productId + ' added to cart!');
    }
    </script>
  </body>
</html>
