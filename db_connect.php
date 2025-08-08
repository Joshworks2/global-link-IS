<?php
// Database connection settings
$host = "localhost";
$db_user = "root";
$db_password = ""; // Default is blank in XAMPP
$db_name = "globallink_db"; // Make sure this matches your DB name in phpMyAdmin

// Create connection
$conn = new mysqli($host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
