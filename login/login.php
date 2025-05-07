<?php
session_start();
include '../connection.php';
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];
    
    
    // Login check
    $query = "SELECT u.UserID, u.Username, u.PASSWORD, p.FirstName, p.LastName 
              FROM users u 
              JOIN person p ON u.PersonID = p.PersonID 
              WHERE u.Username = '$username'";
    
    $result = mysqli_query($con, $query);
    
    if (!$result) {
        $error = "Database error: " . mysqli_error($con);
       
    } else if (mysqli_num_rows($result) == 0) {
        $error = "Invalid username";
        
    } else {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['PASSWORD'])) {
            $_SESSION['user_id'] = $row['UserID'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['name'] = $row['FirstName'] . ' ' . $row['LastName'];
            
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Invalid password";
            
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EazyMart - Login</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="login.css" />
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
            <a href="../Orders/orders.php">Orders</a>
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
            <img
              src="../images/team2.jpg"
              alt="Profile"
              class="profile-image"
            />
            <div class="profile-text"><?php echo $user_name; ?></div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Login Form -->
    <main class="login-container">
      <div class="login-box">
        <h2>Login to Your Account</h2>
        <?php if ($error): ?>
          <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form class="login-form" method="POST" action="">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
          </div>
          <button type="submit" class="login-btn">Login</button>
          <p class="register-link">
            Don't have an account?
            <a href="../registration/register.php">Register here</a>
          </p>
        </form>
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
