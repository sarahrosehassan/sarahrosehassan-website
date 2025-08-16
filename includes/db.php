<?php
// Database connection
$host = "localhost";
$username = "saranplc";
$password = "3MPqX6SzZCDp7je@";
$database = "saranplc_website_db";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>