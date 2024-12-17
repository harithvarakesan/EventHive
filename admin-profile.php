
<?php include 'admin-header.php'; ?>
<?php
include './operations/db_connection.php';

// Get the user_id from the session
$userId = $_SESSION['host_id'];

// Fetch user details from the database
$sql = "SELECT username, name, emailid, mobile_number, city FROM faculty WHERE id = ?";
$stmt = $conn->prepare($sql);

// Debugging: Check if prepare() returns false
if ($stmt === false) {
    die("Error preparing the SQL query: " . $conn->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data was found
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="./assets/css/admin-profile.css">
</head>
<body>
    <main class="profile-container">
        <div class="profile-box">
            <h2>Admin Profile</h2>
            <form  method="POST" action="operations/admin_update_profile.php">
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['emailid']); ?>">
                
                <label for="number">Mobile Number:</label>
                <input type="tel" id="number" name="number" value="<?php echo htmlspecialchars($user['mobile_number']); ?>">

                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>">

                <div class="btndiv">
                    <button type="submit" class="update-btn">Update Profile</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

