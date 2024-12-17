
<?php include './header.php'; ?>
<?php
include './operations/db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit;
}

// Get the user_id from the session
$userId = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT username, name, emailid, mobile_number, rollnumber, city, college, year FROM user WHERE id = ?";
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
    <title>Profile Page</title>
    <link rel="stylesheet" href="./assets/css/profile.css">
</head>
<body>

    <main class="profile-container">
        <header class="profile-header">
            <div class="profile-picture">
                <div class="avatar">
                    <span id="profile-letter"><?php echo strtoupper($user['username'][0]); ?></span>
                </div>
            </div>
            <h1>User Profile</h1>
        </header>

        <section class="profile-details">
            <h2>Your Details</h2>
            <form id="profile-form" method="POST" action="operations/update_profile.php">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
                
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['emailid']); ?>">
                
                <label for="number">Mobile Number:</label>
                <input type="tel" id="number" name="number" value="<?php echo htmlspecialchars($user['mobile_number']); ?>">
                
                <label for="rollnumber">Roll Number:</label>
                <input type="text" id="rollnumber" name="rollnumber" value="<?php echo htmlspecialchars($user['rollnumber']); ?>" disabled>
                
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>">
                
                <label for="college">College:</label>
                <input type="text" id="college" name="college" value="<?php echo htmlspecialchars($user['college']); ?>">
                
                <label for="year">Year:</label>
                <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($user['year']); ?>" min="1" max="4">
                
                <button type="submit" class="update-btn">Update</button>
            </form>
        </section>
    </main>

</body>
</html>
