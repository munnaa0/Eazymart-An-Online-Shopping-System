<?php
session_start();
include '../connection.php';
include '../functions.php';

$check_user = check_login($con);

// Get user's name for display
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EazyMart - Orders</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="orders.css" />
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
            <a href="../Products/products.php">Products</a>
            <a href="orders.php" class="active">Orders</a>
            <a href="../Profile/profile.php">Profile</a>
            <a href="../Cart/cart.php">Cart</a>
            <a href="../feedback/feedback.php">Feedback</a>
          </div>
          <div class="search-box">
            <input type="text" placeholder="Search products..." />
            <button type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
          <div class="profile-section">
            <img src="../images/team2.jpg" alt="Profile" class="profile-image" />
            <div class="profile-info">
              <div class="profile-text"><?php echo $user_name; ?></div>
              <a href="../login/logout.php" class="logout-btn">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main>
      <h1>Your Orders</h1>
      <div class="orders-container">
        <!-- Order Card 1 -->
        <div class="order-card">
          <div class="order-header">
            <div>
              <span class="order-id">Order #ORD-2024-001</span>
              <span class="order-date">March 15, 2024</span>
            </div>
            <span class="order-status status-delivered">Delivered</span>
          </div>

          <div class="order-items">
            <div class="order-item">
              <img src="../images/eggs.jpg" alt="Fresh Eggs" />
              <div class="item-details">
                <h3 class="item-name">Fresh Eggs X4</h3>
                <p class="item-price">$10.99</p>
                <p class="item-quantity">Quantity: 2</p>
              </div>
            </div>
            <div class="order-item">
              <img src="../images/milk.jpg" alt="Dairy Milk" />
              <div class="item-details">
                <h3 class="item-name">Dairy Milk</h3>
                <p class="item-price">$15.99</p>
                <p class="item-quantity">Quantity: 1</p>
              </div>
            </div>
          </div>

          <div class="order-summary">
            <div class="total-amount">Total: $37.97</div>
            <div class="order-actions">
              <button class="action-btn track-btn">
                <i class="fas fa-truck"></i> Track Order
              </button>
              <button class="action-btn reorder-btn">
                <i class="fas fa-redo"></i> Reorder
              </button>
            </div>
          </div>
        </div>

        <!-- Order Card 2 -->
        <div class="order-card">
          <div class="order-header">
            <div>
              <span class="order-id">Order #ORD-2024-002</span>
              <span class="order-date">March 10, 2024</span>
            </div>
            <span class="order-status status-processing">Processing</span>
          </div>

          <div class="order-items">
            <div class="order-item">
              <img src="../images/cheese.jpg" alt="Cheese" />
              <div class="item-details">
                <h3 class="item-name">Cheese</h3>
                <p class="item-price">$8.99</p>
                <p class="item-quantity">Quantity: 1</p>
              </div>
            </div>
          </div>

          <div class="order-summary">
            <div class="total-amount">Total: $8.99</div>
            <div class="order-actions">
              <button class="action-btn track-btn">
                <i class="fas fa-truck"></i> Track Order
              </button>
              <button class="action-btn reorder-btn">
                <i class="fas fa-redo"></i> Reorder
              </button>
            </div>
          </div>
        </div>
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
          <a href="../Products/products.php">Products</a>
          <a href="orders.php">Orders</a>
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
  </body>
</html>
