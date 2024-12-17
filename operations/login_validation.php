<?php
session_start();
include './db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $userType = isset($_POST['user_type']) ? $_POST['user_type'] : 'user'; // Default to 'user'

    // Query and validate based on user type
    if ($userType === "user") {
        $query = "SELECT id, username, emailid, password FROM user WHERE username = ?";
    } else if ($userType === "admin") {
        $query = "SELECT id, username, emailid, password FROM faculty WHERE username = ?";
    } else {
        echo "<script>alert('Invalid user type.'); window.history.back();</script>";
        exit();
    }

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo "<script>alert('Query preparation failed.'); window.history.back();</script>";
        exit();
    }

    // Bind parameters and execute the query
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password (assuming passwords are hashed)
        if ($password == $row['password']) {
            // Set session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['emailid'] = $row['emailid'];
            $_SESSION['user_type'] = $userType;

            // Redirect to the appropriate dashboard
            if ($userType === "user") {
                $_SESSION['user_id'] = $row['id'];
                header("Location: ../home.php");
            } else if ($userType === "admin") {
                $_SESSION['host_id'] = $row['id'];
                header("Location: ../admin-your-events.php");
            }
            exit();
        } else {
            echo "<script>alert('Invalid password.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No user found with this username.'); window.history.back();</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
