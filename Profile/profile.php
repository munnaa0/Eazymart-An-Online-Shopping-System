<?php
session_start();
include '../connection.php';
include '../functions.php';

$check_user = check_login($con);

$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';


$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


$first_name = '';
$last_name = '';
$email = '';
$phone = '';
$address = '';


if ($user_id) {
    $person_query = "SELECT p.FirstName, p.LastName, p.Address, pe.Email, pp.Phone 
                    FROM person p 
                    LEFT JOIN personemail pe ON p.PersonID = pe.PersonID 
                    LEFT JOIN personphone pp ON p.PersonID = pp.PersonID 
                    WHERE p.PersonID = (SELECT PersonID FROM users WHERE UserID = $user_id)";
    $result = mysqli_query($con, $person_query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $first_name = $row['FirstName'];
        $last_name = $row['LastName'];
        $email = $row['Email'];
        $phone = $row['Phone'];
        $address = $row['Address'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $new_first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $new_last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $new_email = mysqli_real_escape_string($con, $_POST['email']);
    $new_phone = mysqli_real_escape_string($con, $_POST['phone']);
    $new_address = mysqli_real_escape_string($con, $_POST['address']);
    
  
    $person_id_query = "SELECT PersonID FROM users WHERE UserID = $user_id";
    $person_result = mysqli_query($con, $person_id_query);
    $person_row = mysqli_fetch_assoc($person_result);
    $person_id = $person_row['PersonID'];
    
   
    $update_person = "UPDATE person SET FirstName = '$new_first_name', LastName = '$new_last_name', Address = '$new_address' 
                     WHERE PersonID = $person_id";
    mysqli_query($con, $update_person);
    
    $update_email = "UPDATE personemail SET Email = '$new_email' WHERE PersonID = $person_id";
    mysqli_query($con, $update_email);
    
    
    $update_phone = "UPDATE personphone SET Phone = $new_phone WHERE PersonID = $person_id";
    mysqli_query($con, $update_phone);
    
    
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>EazyMart - User Profile</title>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="profile.css" />
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
            <a href="profile.php" class="active">Profile</a>
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
    <main class="profile-container">
      <section class="profile-content">
        <div class="profile-header">
          <img src="../images/team1.jpg" alt="Profile Picture" class="profile-image" />
          <div class="profile-info">
            <h1><?php echo $first_name . ' ' . $last_name; ?></h1>
          </div>
          <button class="edit-btn" onclick="toggleEditMode()">
            <i class="fas fa-edit"></i> Edit Profile
          </button>
        </div>

        <div class="profile-details">
          <form method="POST" action="profile.php">
            <!-- Personal Info -->
            <div class="info-grid">
              <div class="info-item">
                <label>First Name</label>
                <input type="text" name="first_name" value="<?php echo $first_name; ?>" readonly pattern="[A-Za-z\s]+" title="Please enter only letters">
              </div>
              <div class="info-item">
                <label>Last Name</label>
                <input type="text" name="last_name" value="<?php echo $last_name; ?>" readonly pattern="[A-Za-z\s]+" title="Please enter only letters">
              </div>
              <div class="info-item">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>" readonly>
              </div>
              <div class="info-item">
                <label>Phone</label>
                <input type="tel" name="phone" value="<?php echo $phone; ?>" readonly maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)">
              </div>
              <div class="info-item full-width">
                <label>Address</label>
                <input type="text" name="address" value="<?php echo $address; ?>" readonly>
              </div>
            </div>
            <button type="submit" name="update_profile" class="save-btn" style="display: none;">Save Changes</button>
          </form>
        </div>
      </section>
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

    <script>
      function toggleEditMode() {
        const inputs = document.querySelectorAll('.info-item input');
        const saveBtn = document.querySelector('.save-btn');
        
        inputs.forEach(input => {
          input.readOnly = !input.readOnly;
        });
        
        saveBtn.style.display = saveBtn.style.display === 'none' ? 'block' : 'none';
      }
    </script>
  </body>
</html>
