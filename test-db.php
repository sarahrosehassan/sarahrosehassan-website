<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "127.0.0.1"; // Localhost for the SSH tunnel
$port = 5522; // Port forwarded by the SSH tunnel
$username = "sarapnlc_user"; // Your database username
$password = "MalZ~d6AJcLx"; // Your database password
$database = "sarapnlc_website_db"; // Your database name

$conn = new mysqli($host, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Database connection successful!";
?>