<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
// Set a default title if not provided
if (!isset($pageTitle)) {
    $pageTitle = "EventHive";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <!-- Tailwind CSS (Official CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js"></script>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Animation Libraries -->
    <script src="assets/js/anime.js"></script>
    <script src="assets/js/gsap.js"></script>
    <script src="assets/js/three.js"></script>
    <script src="assets/js/lottie.js"></script>
    <script src="assets/js/popmotion.js"></script>
    <script src="assets/js/scrollmagic.js"></script>
</head>
<body>
<?php
if (isset($_SESSION['user_id'])) {
    include 'user_sidebar.php';
    echo '<div class="md:ml-60 flex min-h-screen bg-orange-50">';
} else {
    include 'sidebar.php';
    echo '<div class="flex min-h-screen bg-orange-50">';
}
?>

<!-- Main content continues... -->
