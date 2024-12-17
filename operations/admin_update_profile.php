<?php
session_start();
include './db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['host_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit;
}

// Get user_id from session
$userId = $_SESSION['host_id'];

// Get updated user data from POST
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$mobileNumber = trim($_POST['number']);
$city = trim($_POST['city']);

// Prepare the SQL query to update the user's details
$sql = "UPDATE faculty SET name = ?, emailid = ?, mobile_number = ?, city = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $name, $email, $mobileNumber, $city, $userId);

// Execute the query
if ($stmt->execute()) {
    echo "Profile updated successfully!";
    // Optionally, redirect to a profile page or display a success message
    header("Location: ../admin-profile.php");
    exit();
} else {
    echo "<script>alert('Error: " . $stmt->error ."'); window.history.back();</script>";
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
