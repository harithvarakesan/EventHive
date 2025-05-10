<?php
// settings.php - User settings page (demo)
$pageTitle = "Settings - EventHive";
include '../header.php';
?>
<div class="flex-1 flex flex-col items-center justify-start py-12">
  <div class="w-full max-w-2xl bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-6">
      <i data-lucide="settings" class="w-7 h-7 text-orange-500"></i>
      Settings
    </h2>
    <form class="space-y-6">
      <div>
        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Email Notifications</label>
        <input type="checkbox" checked class="accent-orange-500 mr-2"> Receive updates about events and leaderboard
      </div>
      <div>
        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Dark Mode</label>
        <input id="settings-dark-toggle" type="checkbox" class="accent-orange-500 mr-2"> Enable dark mode
      </div>
      <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg">Save Settings</button>
    </form>
  </div>
</div>
</div>
<?php // Close sidebar/layout div from header.php ?>
<script>if(window.lucide) lucide.createIcons();
document.getElementById('settings-dark-toggle').addEventListener('change', function() {
  document.body.classList.toggle('dark', this.checked);
});
</script>
