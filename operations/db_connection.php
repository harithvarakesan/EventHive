<?php
// Database configuration
$servername = "localhost"; // Replace with your database server name or IP
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "eventhive"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
