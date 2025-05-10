<?php
// User Sidebar for EventHive
if (!isset($_SESSION)) session_start();
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
?>
<!-- Mobile Hamburger -->
<div class="md:hidden flex items-center p-4 bg-white border-b border-orange-100 sticky top-0 z-50">
  <button id="sidebar-toggle" class="mr-3 focus:outline-none">
    <i data-lucide="menu" class="w-7 h-7 text-orange-500"></i>
  </button>
  <span class="text-2xl font-bold text-orange-600">EventHive</span>
</div>
<aside id="user-sidebar" class="hidden md:flex flex-col justify-between h-screen w-60 bg-white border-r border-orange-100 fixed left-0 top-0 z-50 transition-transform duration-300 md:translate-x-0 -translate-x-full md:translate-x-0 dashboard-widget">

  <div>
    <div class="flex items-center gap-3 px-6 py-8">
      <i data-lucide="flame" class="w-8 h-8 text-orange-500"></i>
      <span class="text-2xl font-bold text-orange-600">EventHive</span>
    </div>
    <nav class="flex flex-col gap-2 mt-4 px-4">
      <a href="dashboard.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="layout-dashboard" class="w-5 h-5 text-orange-400"></i> Dashboard
      </a>
      <a href="events.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="calendar" class="w-5 h-5 text-orange-400"></i> Events
      </a>
      <a href="leaderboard.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="trophy" class="w-5 h-5 text-orange-400"></i> Leaderboard
      </a>
      <a href="registrations.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="list-checks" class="w-5 h-5 text-orange-400"></i> My Registrations
      </a>
      <a href="profile.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="user" class="w-5 h-5 text-orange-400"></i> Profile
      </a>
      <a href="notifications.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium relative">
        <i data-lucide="bell" class="w-5 h-5 text-orange-400"></i> Notifications
        <span class="absolute right-3 top-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">3</span>
      </a>
      <!-- <a href="settings.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="settings" class="w-5 h-5 text-orange-400"></i> Settings
      </a> -->
    </nav>
  </div>
  <div class="px-6 py-6 border-t border-orange-100 flex flex-col gap-2">

    <div class="flex items-center gap-3">
      <div>
        <div class="flex flex-col items-center mt-2">
          <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-orange-100 text-orange-600 font-bold text-2xl mb-2 border-2 border-orange-200 shadow">
            <i data-lucide="user" class="w-7 h-7"></i>
          </div>
          <div class="bg-orange-50 rounded-xl px-4 py-3 w-full text-center shadow-sm flex flex-col items-center">
            <div class="text-xs text-orange-700 font-semibold bg-orange-100 rounded-full px-2 py-1 inline-block mt-1">User</div>
          </div>
        </div>
      </div>
    </div>
    <a href="admin-logout.php" class="flex items-center gap-2 mt-4 px-4 py-2 rounded-lg hover:bg-orange-50 text-red-500 font-medium">
      <i data-lucide="log-out" class="w-5 h-5 text-red-400"></i> Logout
    </a>
    <!-- <button id="dark-mode-toggle" class="flex items-center gap-2 mt-4 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 font-medium bg-gray-100">
      <i data-lucide="moon" class="w-5 h-5 text-gray-500"></i> Dark Mode
    </button> -->
  </div>
  <div class="px-6 pb-4 text-xs text-gray-400 text-center select-none">User logged in</div>
</aside>
<script src="assets/js/uiux.js"></script>
<script src="assets/js/sidebar-effects.js"></script>
<script>
// Mobile sidebar toggle
const sidebar = document.getElementById('user-sidebar');
const toggle = document.getElementById('sidebar-toggle');
if (toggle && sidebar) {
  toggle.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('-translate-x-full');
    sidebar.classList.toggle('md:translate-x-0');
  });
}
// Lucide icons
// Ensure icons are rendered after DOM is ready
if (window.lucide) {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
      lucide.createIcons();
    });
  } else {
    lucide.createIcons();
  }
}
// Demo dark mode toggle
const darkToggle = document.getElementById('dark-mode-toggle');
darkToggle && darkToggle.addEventListener('click', () => {
  document.body.classList.toggle('dark');
  localStorage.setItem('darkMode', document.body.classList.contains('dark'));
});
// On load, set dark mode if previously enabled
if (localStorage.getItem('darkMode') === 'true') {
  document.body.classList.add('dark');
}

</script>
