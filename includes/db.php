<?php
// Database credentials
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "bloodbank";

// Define SITEURL only once
if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost/Blood_bank_management_system/');
}

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set character set to utf8 for better compatibility
$conn->set_charset("utf8");
?>
