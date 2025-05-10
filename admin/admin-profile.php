
<?php
if (!isset($_SESSION)) session_start();
include '../operations/db_connection.php';
// Get the user_id from the session
$userId = $_SESSION['host_id'];
// Fetch user details from the database
$sql = "SELECT username, name, emailid, mobile_number, city FROM faculty WHERE id = ?";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <?php include '../admin/admin_sidebar.php'; ?>
    <div class="md:ml-60 flex flex-col min-h-screen transition-all duration-300">
        <header class="flex items-center justify-between px-6 py-6 border-b bg-white sticky top-0 z-40">
            <h1 class="text-2xl font-bold text-orange-600">Admin Profile</h1>
            <a href="../admin/admin-your-events.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-100 text-orange-700 hover:bg-orange-200 font-medium transition"><i data-lucide='arrow-left' class='w-5 h-5'></i> Back to Events</a>
        </header>
        <main class="flex-1 p-6 flex items-center justify-center">
            <div class="w-full max-w-xl bg-white rounded-xl shadow p-8 border border-orange-100">
                <div class="flex flex-col items-center mb-8">
                    <div class="w-24 h-24 rounded-full bg-orange-100 flex items-center justify-center text-4xl font-bold text-orange-600 mb-2">
                        <?php echo strtoupper(substr($user['name'],0,2)); ?>
                    </div>
                    <div class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($user['name']); ?></div>
                    <div class="text-sm text-gray-500">@<?php echo htmlspecialchars($user['username']); ?></div>
                </div>
                <form id="profile-form" method="POST" action="operations/admin_update_profile.php" class="space-y-5">
                    <div>
                        <label for="username" class="block font-semibold text-gray-700 mb-1">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" disabled class="w-full px-4 py-2 border border-orange-200 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="name" class="block font-semibold text-gray-700 mb-1">Full Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="email" class="block font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['emailid']); ?>" class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="number" class="block font-semibold text-gray-700 mb-1">Mobile Number</label>
                        <input type="tel" id="number" name="number" value="<?php echo htmlspecialchars($user['mobile_number']); ?>" class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="city" class="block font-semibold text-gray-700 mb-1">City</label>
                        <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 mt-4 rounded-lg bg-orange-500 text-white hover:bg-orange-600 font-semibold text-lg transition disabled:opacity-50" id="submit-btn">
                        <i data-lucide='save' class='w-5 h-5'></i> Update Profile
                    </button>
                </form>
            </div>
        </main>
    </div>
    <script>
    // Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) lucide.createIcons();
    });
    // Button loading state
    document.getElementById('profile-form').addEventListener('submit', function(e) {
        var btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2 text-white inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Updating...';
    });
    </script>
</body>
</html>

