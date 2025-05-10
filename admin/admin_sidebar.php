<?php
// Admin Sidebar for EventHive
if (!isset($_SESSION)) session_start();
$adminName = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : '';
?>
<!-- Mobile Hamburger -->
<div class="md:hidden flex items-center p-4 bg-white border-b border-orange-100 sticky top-0 z-50">
  <button id="sidebar-toggle" class="mr-3 focus:outline-none">
    <i data-lucide="menu" class="w-7 h-7 text-orange-500"></i>
  </button>
  <span class="text-2xl font-bold text-orange-600">EventHive Admin</span>
</div>
<aside id="admin-sidebar" class="hidden md:flex flex-col justify-between h-screen w-60 bg-white border-r border-orange-100 fixed left-0 top-0 z-50 transition-transform duration-300 md:translate-x-0 -translate-x-full md:translate-x-0 dashboard-widget">
  <div>
    <div class="flex items-center gap-3 px-6 py-8">
      <i data-lucide="flame" class="w-8 h-8 text-orange-500"></i>
      <span class="text-2xl font-bold text-orange-600">EventHive Admin</span>
    </div>
    <nav class="flex flex-col gap-2 mt-4 px-4">
      <a href="admin_dashboard.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium<?php if(basename($_SERVER['PHP_SELF'])=='admin_dashboard.php'){echo ' bg-orange-100 text-orange-700';} ?>">
        <i data-lucide="layout-dashboard" class="w-5 h-5 text-orange-400"></i> Dashboard
      </a>
      <a href="admin-your-events.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="calendar" class="w-5 h-5 text-orange-400"></i> Your Events
      </a>
      <a href="admin-create-event.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="plus-square" class="w-5 h-5 text-orange-400"></i> Create Event
      </a>
      <a href="admin-profile.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="user" class="w-5 h-5 text-orange-400"></i> Profile
      </a>
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
            <div class="text-xs text-orange-700 font-semibold bg-orange-100 rounded-full px-2 py-1 inline-block mt-1">Admin</div>
          </div>
        </div>
      </div>
    </div>
    <a href="../logout.php" class="flex items-center gap-2 mt-4 px-4 py-2 rounded-lg hover:bg-orange-50 text-red-500 font-medium">
      <i data-lucide="log-out" class="w-5 h-5 text-red-400"></i> Logout
    </a>
    <!-- <button id="dark-mode-toggle" class="flex items-center gap-2 mt-4 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 font-medium bg-gray-100">
      <i data-lucide="moon" class="w-5 h-5 text-gray-500"></i> Dark Mode
    </button> -->
  </div>
  <div class="px-6 pb-4 text-xs text-gray-400 text-center select-none">Admin logged in</div>
</aside>

<script>
// Mobile sidebar toggle
const sidebar = document.getElementById('admin-sidebar');
const toggle = document.getElementById('sidebar-toggle');
if (toggle && sidebar) {
  toggle.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('-translate-x-full');
    sidebar.classList.toggle('md:translate-x-0');
  });
}
// Lucide icons
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
if (localStorage.getItem('darkMode') === 'true') {
  document.body.classList.add('dark');
}
</script>
