<?php
session_start();
include './db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit;
}

// Get user_id from session
$userId = $_SESSION['user_id'];

// Get updated user data from POST
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$mobileNumber = trim($_POST['number']);
$city = trim($_POST['city']);
$college = trim($_POST['college']);
$year = intval($_POST['year']);  // Ensure the year is an integer

// Prepare the SQL query to update the user's details
$sql = "UPDATE user SET name = ?, emailid = ?, mobile_number = ?, city = ?, college = ?, year = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $name, $email, $mobileNumber, $city, $college, $year, $userId);

// Execute the query
if ($stmt->execute()) {
    echo "Profile updated successfully!";
    // Optionally, redirect to a profile page or display a success message
    header("Location: ../profile.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
