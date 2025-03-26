<?php 
session_start();
if (!isset($_SESSION['host_id'])) {
    header("Location: login.php");  // Redirect to login page if not logged in
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Header</title>
    <link rel="stylesheet" href="./assets/css/header.css">
</head>
<body>
    <header class="admin-header">
        <nav class="navbar">
            <div class="logo">Admin Panel</div>
            <div class="menu-icon" onclick="toggleMenu()">☰</div>
            <ul class="nav-links" id="nav-links">
                <li><a href="admin-profile.php">Profile</a></li>
                <li><a href="admin-create-event.php">Create Event</a></li>
                <li><a href="admin-your-events.php">Your Events</a></li>
                <li><a href="admin-logout.php" class="logout">Logout</a></li>
            </ul>
        </nav>
    <script>
        function toggleMenu() {
            const navLinks = document.getElementById("nav-links");
            navLinks.classList.toggle("active");
        }
    </script>
    </header>
</body>
</html>
