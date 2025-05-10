<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$pageTitle = "Profile - EventHive";
include '../header.php';
include '../operations/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT username, name, emailid, mobile_number, rollnumber, city, college, year FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing the SQL query: " . $conn->error);
}
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

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
    <title>Profile - EventHive</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="max-w-4xl mx-auto p-6">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="flex items-center gap-6 mb-6">
                <div class="w-20 h-20 rounded-full bg-blue-600 text-white flex items-center justify-center text-3xl font-bold">
                    <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                </div>
                <div>
                    <h1 class="text-2xl font-semibold">Your Profile</h1>
                    <p class="text-sm text-gray-500">Update your personal information</p>
                </div>
            </div>

            <form method="POST" action="operations/update_profile.php" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Username</label>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled class="bg-gray-100 border rounded-lg px-3 py-2 w-full" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="border rounded-lg px-3 py-2 w-full" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['emailid']); ?>" class="border rounded-lg px-3 py-2 w-full" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Mobile Number</label>
                    <input type="tel" name="number" value="<?php echo htmlspecialchars($user['mobile_number']); ?>" class="border rounded-lg px-3 py-2 w-full" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Roll Number</label>
                    <input type="text" name="rollnumber" value="<?php echo htmlspecialchars($user['rollnumber']); ?>" disabled class="bg-gray-100 border rounded-lg px-3 py-2 w-full" />
                </div>

                <div>
                    <label class="block text-sm font-medium">City</label>
                    <input type="text" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" class="border rounded-lg px-3 py-2 w-full" />
                </div>

                <div>
                    <label class="block text-sm font-medium">College</label>
                    <input type="text" name="college" value="<?php echo htmlspecialchars($user['college']); ?>" class="border rounded-lg px-3 py-2 w-full" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Year</label>
                    <input type="number" name="year" min="1" max="4" value="<?php echo htmlspecialchars($user['year']); ?>" class="border rounded-lg px-3 py-2 w-full" />
                </div>

                <div class="sm:col-span-2 mt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl transition duration-200">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
