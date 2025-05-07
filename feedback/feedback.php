<?php
session_start();
include '../connection.php';
include '../functions.php';

$check_user = check_login($con);

// Get user's name for display
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_feedback'])) {
        // Handle feedback deletion
        $feedback_id = mysqli_real_escape_string($con, $_POST['feedback_id']);
        mysqli_query($con, "DELETE FROM feedback WHERE FeedbackID = '$feedback_id'");


    } elseif (isset($_POST['update_feedback'])) {
        // Handle feedback update
        $feedback_id = mysqli_real_escape_string($con, $_POST['feedback_id']);
        $rating = mysqli_real_escape_string($con, $_POST['rating']);
        $feedback_text = mysqli_real_escape_string($con, $_POST['feedback_text']);
        
        mysqli_query($con, "UPDATE feedback SET Rating = '$rating', FeedbackText = '$feedback_text' 
                           WHERE FeedbackID = '$feedback_id'");
    } 
    
    
    elseif (isset($_POST['product_id'])) {
        // Handle new feedback submission
        $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
        $rating = mysqli_real_escape_string($con, $_POST['rating']);
        $feedback_text = mysqli_real_escape_string($con, $_POST['feedback_text']);
        $user_id = $_SESSION['user_id'];
        
        // Get person_id from users table
        $query = "SELECT PersonID FROM users WHERE UserID = '$user_id'";
        $result = mysqli_query($con, $query);
        $user_data = mysqli_fetch_assoc($result);
        $person_id = $user_data['PersonID'];
        
        // Insert feedback
        $insert_query = "INSERT INTO feedback (PersonID, ProductID, FeedbackText, Rating, Feedback_Date) 
                        VALUES ('$person_id', '$product_id', '$feedback_text', '$rating', CURDATE())";
        
        if (mysqli_query($con, $insert_query)) {
            $message = "Feedback submitted successfully!";
        } else {
            $error = "Error submitting feedback: " . mysqli_error($con);
        }
    }
}

// Fetch products from database
$products_query = "SELECT ProductID, Product_Name FROM product";
$products_result = mysqli_query($con, $products_query);

// Fetch user's feedback
$user_id = $_SESSION['user_id'];
$user_query = "SELECT PersonID FROM users WHERE UserID = '$user_id'";
$user_result = mysqli_query($con, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$person_id = $user_data['PersonID'];

$feedback_query = "SELECT f.*, p.Product_Name 
                  FROM feedback f 
                  JOIN product p ON f.ProductID = p.ProductID 
                  WHERE f.PersonID = '$person_id' 
                  ORDER BY f.Feedback_Date DESC";
$feedback_result = mysqli_query($con, $feedback_query);

// Get feedback messages if any
$message = isset($_SESSION['feedback_message']) ? $_SESSION['feedback_message'] : '';
$error = isset($_SESSION['feedback_error']) ? $_SESSION['feedback_error'] : '';

// Clear the messages
unset($_SESSION['feedback_message']);
unset($_SESSION['feedback_error']);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Feedback - EazyMart</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="feedback.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
  </head>
  <body>
    <!-- Existing Header -->
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
            <a href="feedback.php" class="active">Feedback</a>
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

    <!-- New Feedback Section -->
    <main class="feedback-main">
      <div class="feedback-container">
        <div class="feedback-hero">
          <h1>Share Your Experience</h1>
          <p>
            We value your feedback! Help us improve your EazyMart experience
          </p>
        </div>

        <?php if ($message): ?>
          <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="feedback-card">
          <form class="feedback-form" method="POST" action="">
            <div class="form-group">
              <label>Select Product</label>
              <select class="form-control" name="product_id" required>
                <option value="">Choose a product...</option>
                <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                  <option value="<?php echo $product['ProductID']; ?>">
                    <?php echo ($product['Product_Name']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group">
              <label>Your Rating (1-10)</label>
              <input 
                type="number" 
                name="rating" 
                class="form-control rating-input" 
                min="1" 
                max="10" 
                required
                placeholder="Enter rating (1-10)"
              >
            </div>

            <div class="form-group">
              <label>Detailed Feedback</label>
              <textarea
                class="form-control"
                name="feedback_text"
                placeholder="Tell us about your experience..."
                required
                style="resize: none;"
              ></textarea>
            </div>

            <button type="submit" class="submit-btn">Submit Feedback</button>
          </form>
        </div>

        <!-- Display User's Feedback -->
        <div class="user-feedback">
          <h2>Your Feedback History</h2>
          <?php if (mysqli_num_rows($feedback_result) > 0): ?>
            <?php while ($feedback = mysqli_fetch_assoc($feedback_result)): ?>
              <div class="feedback-item">
                <div class="feedback-header">
                  <h3><?php echo $feedback['Product_Name']; ?></h3>
                  <span class="feedback-date"><?php echo date('M d, Y', strtotime($feedback['Feedback_Date'])); ?></span>
                </div>
                <div class="feedback-rating">Rating: <?php echo $feedback['Rating']; ?>/10</div>
                <div class="feedback-text"><?php echo ($feedback['FeedbackText']); ?></div>
                <button class="update-btn" onclick="showUpdateForm(<?php echo $feedback['FeedbackID']; ?>)">Update</button>
                <form method="POST" style="display:inline">
                    <input type="hidden" name="feedback_id" value="<?php echo $feedback['FeedbackID']; ?>">
                    <input type="hidden" name="delete_feedback" value="1">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
                
                <!-- Update Form (Hidden by default) -->
                <div id="update-form-<?php echo $feedback['FeedbackID']; ?>" class="update-form" style="display: none;">
                  <form method="POST" action="">
                    <input type="hidden" name="feedback_id" value="<?php echo $feedback['FeedbackID']; ?>">
                    <input type="hidden" name="update_feedback" value="1">
                    
                    <div class="form-group">
                      <label>New Rating (1-10)</label>
                      <input 
                        type="number" 
                        name="rating" 
                        class="form-control rating-input" 
                        min="1" 
                        max="10" 
                        required
                        value="<?php echo $feedback['Rating']; ?>"
                      >
                    </div>
                    
                    <div class="form-group">
                      <label>New Feedback</label>
                      <textarea
                        class="form-control"
                        name="feedback_text"
                        required
                        style="resize: none;"
                      ><?php echo $feedback['FeedbackText']; ?></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Update Feedback</button>
                    <button type="button" class="cancel-btn" onclick="hideUpdateForm(<?php echo $feedback['FeedbackID']; ?>)">Cancel</button>
                  </form>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="no-feedback">You haven't submitted any feedback yet.</p>
          <?php endif; ?>
        </div>
      </div>
    </main>

    <!-- Existing Footer -->
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

    <script>
      function showUpdateForm(feedbackId) {
        document.getElementById('update-form-' + feedbackId).style.display = 'block';
      }
      
      function hideUpdateForm(feedbackId) {
        document.getElementById('update-form-' + feedbackId).style.display = 'none';
      }
    </script>
  </body>
</html>
