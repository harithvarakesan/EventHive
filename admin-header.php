<?php
session_start();
if (!isset($_SESSION['host_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!-- Modernized Admin Header with Tailwind CSS -->
<!-- Place this include at the top of your admin pages -->
<!-- No duplicate <html> or <body> tags, just the header -->
<!-- Tailwind CSS & Lucide Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide-static@0.343.0/font/lucide.css">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<header class="w-full bg-white border-b shadow-sm sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <div class="flex items-center gap-2">
            <span class="text-orange-600 font-bold text-xl tracking-tight flex items-center gap-1">
                <i data-lucide="layout-dashboard" class="w-6 h-6"></i> Admin Panel
            </span>
        </div>
        <div class="hidden md:flex gap-6 items-center">
            <a href="admin-profile.php" class="text-gray-700 hover:text-orange-600 font-medium transition">Profile</a>
            <a href="admin-create-event.php" class="text-gray-700 hover:text-orange-600 font-medium transition">Create Event</a>
            <a href="admin-your-events.php" class="text-gray-700 hover:text-orange-600 font-medium transition">Your Events</a>
            <a href="admin-logout.php" class="flex items-center gap-1 px-3 py-1 rounded-lg bg-orange-100 text-orange-700 hover:bg-orange-200 font-medium transition"><i data-lucide="log-out" class="w-5 h-5"></i> Logout</a>
        </div>
        <!-- Mobile menu button -->
        <button class="md:hidden flex items-center justify-center p-2 rounded hover:bg-orange-50 transition" id="admin-menu-btn" aria-label="Open Menu">
            <i data-lucide="menu" class="w-7 h-7"></i>
        </button>
    </nav>
    <!-- Mobile menu -->
    <div id="admin-mobile-menu" class="md:hidden hidden px-4 pb-4 bg-white border-b">
        <a href="admin-profile.php" class="block py-2 text-gray-700 hover:text-orange-600 font-medium">Profile</a>
        <a href="admin-create-event.php" class="block py-2 text-gray-700 hover:text-orange-600 font-medium">Create Event</a>
        <a href="admin-your-events.php" class="block py-2 text-gray-700 hover:text-orange-600 font-medium">Your Events</a>
        <a href="admin-logout.php" class="flex items-center gap-1 py-2 text-orange-700 hover:text-orange-800 font-medium"><i data-lucide="log-out" class="w-5 h-5"></i> Logout</a>
    </div>
</header>
<script>
// Lucide icons
if (window.lucide) lucide.createIcons();
// Mobile menu toggle
const menuBtn = document.getElementById('admin-menu-btn');
const mobileMenu = document.getElementById('admin-mobile-menu');
if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
}
</script>
