<?php
// Database connection parameters
$dbhost = "localhost";
$dbuser = 'root';
$dbpass = '';
$dbname = 'eazymart';

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");

?>

