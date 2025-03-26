<?php
session_start();
include './db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    $rollnumber = trim($_POST['rollnumber']);
    $emailid = trim($_POST['emailid']);
    $mobile_number = trim($_POST['mobile_number']);
    $city = trim($_POST['city']);
    $college = trim($_POST['college']);
    $year = intval($_POST['year']);
    $dept = trim($_POST['dept']);
    
    // Validate data
    $errors = [];
    
    // Check if username already exists
    $checkQuery = "SELECT id FROM user WHERE username = ? OR rollnumber = ?";
    $checkStmt = $conn->prepare($checkQuery);
    
    if (!$checkStmt) {
        $errors[] = "Query preparation failed: " . $conn->error;
    } else {
        $checkStmt->bind_param("ss", $username, $rollnumber);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            $errors[] = "Username already exists. Please choose a different username.";
        }
        
        $checkStmt->close();
    }
    
    // Validate email format
    if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    // Validate mobile number (basic validation)
    if (!preg_match("/^[0-9]{10}$/", $mobile_number)) {
        $errors[] = "Mobile number should be 10 digits.";
    }
    
    // Validate year
    if ($year < 1 || $year > 4) {
        $errors[] = "Year should be between 1 and 4.";
    }
    
    // If there are no errors, insert the user
    if (empty($errors)) {
        $insertQuery = "INSERT INTO user (username, password, name, rollnumber, emailid, mobile_number, city, college, year, dept) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        
        if (!$insertStmt) {
            echo "<script>alert('Query preparation failed: " . $conn->error . "'); window.history.back();</script>";
            exit();
        }
        
        $insertStmt->bind_param("ssssssssss", $username, $password, $name, $rollnumber, $emailid, $mobile_number, $city, $college, $year, $dept);
        
        if ($insertStmt->execute()) {
            // Registration successful
            echo "<script>
                alert('Registration successful! You can now login.');
                window.location.href = '../login.php';
            </script>";
        } else {
            echo "<script>alert('Registration failed: " . $insertStmt->error . "'); window.history.back();</script>";
        }
        
        $insertStmt->close();
    } else {
        // Display errors
        $errorMessage = implode("\\n", $errors);
        echo "<script>alert('Registration failed:\\n" . $errorMessage . "'); window.history.back();</script>";
    }
}

// Close the connection
$conn->close();
?>