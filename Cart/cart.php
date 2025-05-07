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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cart - EazyMart</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="cart.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <!-- Header -->
    <nav class="top-nav">
      <div class="nav-container">
        <img src="../images/Eazy.png" alt="EazyMart Logo" class="logo" />
        <div class="nav-right">
          <div class="nav-links">
            <a href="../index.php">Home</a>
            <a href="../Products/products.php">Products</a>
            <a href="../Orders/orders.php">Orders</a>
            <a href="../Profile/profile.php">Profile</a>
            <a href="cart.php" class="active">Cart</a>
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
              <a href="../login/logout.php" class="logout-btn">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Cart Content -->
    <main class="main-content">
      <h1>Your Shopping Cart</h1>
      <div class="cart-container">
        <div class="cart-items">
          <!-- Item 1 -->
          <div class="cart-item">
            <img
              src="../images/eggs.jpg"
              alt="Fresh Eggs"
              class="cart-item-img"
            />
            <div class="item-details">
              <h3 class="item-title">Fresh Eggs X4</h3>
              <p class="item-price">$3.99</p>
              <div class="quantity-controls">
                <button class="quantity-btn minus">-</button>
                <input type="number" class="quantity-input" value="2" min="1" />
                <button class="quantity-btn plus">+</button>
              </div>
              <div class="item-actions">
                <button class="update-btn">Update</button>
                <button class="remove-btn">Remove</button>
              </div>
            </div>
          </div>

          <!-- Item 2 -->
          <div class="cart-item">
            <img
              src="../images/milk.jpg"
              alt="Dairy Milk"
              class="cart-item-img"
            />
            <div class="item-details">
              <h3 class="item-title">Dairy Milk</h3>
              <p class="item-price">$2.49</p>
              <div class="quantity-controls">
                <button class="quantity-btn minus">-</button>
                <input type="number" class="quantity-input" value="1" min="1" />
                <button class="quantity-btn plus">+</button>
              </div>
              <div class="item-actions">
                <button class="update-btn">Update</button>
                <button class="remove-btn">Remove</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
          <h2 class="summary-title">Order Summary</h2>
          <div class="summary-content">
            <div class="summary-item">
              <span>Subtotal (3 items)</span>
              <span>$10.47</span>
            </div>
            <div class="summary-item">
              <span>Shipping</span>
              <span>$2.99</span>
            </div>
            <div class="summary-item discount">
              <span>Discount</span>
              <span>-$1.00</span>
            </div>
            <div class="summary-item total">
              <span>Total</span>
              <span>$12.46</span>
            </div>
          </div>
          <button class="checkout-btn">
            Proceed to Checkout <i class="fas fa-arrow-right"></i>
          </button>
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
  </body>
</html>
