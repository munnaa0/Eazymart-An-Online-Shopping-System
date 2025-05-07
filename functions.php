<?php

function check_login($con)
{
    if(isset($_SESSION['user_id']))
    {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE UserID = '$id' LIMIT 1";

        $result = mysqli_query($con,$query);

        if($result && mysqli_num_rows($result) > 0)
        {
            $check_user = mysqli_fetch_assoc($result);
            return $check_user;
        }
    }

    //Redirect to Login Page
    echo "Redirecting to login page...";
    header("Location: ../login/login.php");
    die();
}

