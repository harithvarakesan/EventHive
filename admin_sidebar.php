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
      <a href="admin-your-events.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="calendar" class="w-5 h-5 text-orange-400"></i> Your Events
      </a>
      <a href="admin-create-event.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="plus-square" class="w-5 h-5 text-orange-400"></i> Create Event
      </a>
      <a href="admin-profile.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="user" class="w-5 h-5 text-orange-400"></i> Profile
      </a>
      <!-- <a href="admin-event-detail.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="info" class="w-5 h-5 text-orange-400"></i> Event Details
      </a> -->
      <!-- <a href="admin-update-event.php" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-orange-50 text-gray-700 font-medium">
        <i data-lucide="edit-3" class="w-5 h-5 text-orange-400"></i> Update Event
      </a> -->
      
    </nav>
  </div>
  <div class="px-6 py-6 border-t border-orange-100 flex flex-col gap-2">
    <div class="flex items-center gap-3">
      <div>
        <div class="font-semibold text-gray-800">Signed in as:</div>
        <div class="text-sm text-orange-600 font-bold"><span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-orange-100 text-orange-600 font-bold text-xl"><?php echo strtoupper(substr($adminName,0,2)); ?></span></div>
      </div>
    </div>
    <a href="admin-logout.php" class="flex items-center gap-2 mt-4 px-4 py-2 rounded-lg hover:bg-orange-50 text-red-500 font-medium">
      <i data-lucide="log-out" class="w-5 h-5 text-red-400"></i> Logout
    </a>
    <!-- <button id="dark-mode-toggle" class="flex items-center gap-2 mt-4 px-4 py-2 rounded-lg hover:bg-orange-100 text-gray-700 font-medium bg-gray-100">
      <i data-lucide="moon" class="w-5 h-5 text-gray-500"></i> Dark Mode
    </button> -->
  </div>
</aside>
<script src="assets/js/uiux.js"></script>
<script src="assets/js/sidebar-effects.js"></script>
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
