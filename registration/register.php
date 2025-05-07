<?php
session_start();
include '../connection.php';
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $first_name = mysqli_real_escape_string($con, $_POST['firstname']);
    $last_name = mysqli_real_escape_string($con, $_POST['lastname']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Simple validation
    if ($password != $confirm_password) {
        $error = "Passwords do not match";
    } elseif (empty($first_name) || empty($last_name) || empty($address) || empty($email) || empty($phone) || empty($username) || empty($password)) {
        $error = "Please fill all required fields";
    } else {
        // Check if username exists
        $check = "SELECT UserID FROM users WHERE Username = '$username'";
        $result = mysqli_query($con, $check);
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Username already exists";
        } else {
            // Insert into person table
            $person_query = "INSERT INTO person (FirstName, LastName, Address) VALUES ('$first_name', '$last_name', '$address')";
            if (mysqli_query($con, $person_query)) {
                $person_id = mysqli_insert_id($con);
                
                // Insert phone
                $phone_query = "INSERT INTO personphone (PersonID, Phone) VALUES ('$person_id', '$phone')";
                mysqli_query($con, $phone_query);
                
                // Insert email
                $email_query = "INSERT INTO personemail (PersonID, Email) VALUES ('$person_id', '$email')";
                mysqli_query($con, $email_query);
                
                // Hash password and insert user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $user_query = "INSERT INTO users (PersonID, Username, PASSWORD) VALUES ('$person_id', '$username', '$hashed_password')";
                
                if (mysqli_query($con, $user_query)) {
                    $success = "Registration successful! You can now login.";
                    header("Location: ../login/login.php");
                } else {
                    $error = "Registration failed. Please try again.";
                }
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EazyMart - Register</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="register.css" />
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

    <!-- Registration Form -->
    <main class="register-container">
      <div class="register-box">
        <h2>Create an Account</h2>
        <?php if ($error): ?>
          <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form class="register-form" method="POST" action="">
          <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" required />
          </div>
          <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" id="lastname" name="lastname" required />
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" required />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required />
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" required />
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
          </div>
          <div class="form-group">
            <label for="confirm-password">Confirm Password</label>
            <input
              type="password"
              id="confirm-password"
              name="confirm-password"
              required
            />
          </div>
          <button type="submit" name="register" class="register-btn">Register</button>
          <p class="login-link">
            Already have an account?
            <a href="../login/login.php">Login here</a>
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
