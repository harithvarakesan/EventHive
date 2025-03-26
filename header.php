<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <link rel="stylesheet" href="./assets/css/header.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">EventHive</div>
        <div class="menu-icon" onclick="toggleMenu()">☰</div>
        <ul class="nav-links" id="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="leaderboard.php">Leaderboard</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="registrations.php">Your Registrations</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- If user is logged in, show Logout button -->
                <li><a href="logout.php" class="logout">Logout</a></li>
            <?php else: ?>
                <!-- If user is not logged in, show Login button -->
                <li><a href="login.php" class="logout">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <script>
        function toggleMenu() {
            const navLinks = document.getElementById("nav-links");
            navLinks.classList.toggle("active");
        }
    </script>
</body>
</html>
