<?php
// notifications.php - User notifications page (demo)
$pageTitle = "Notifications - EventHive";
include 'header.php';
?>
<div class="flex-1 flex flex-col items-center justify-start py-12">
  <div class="w-full max-w-2xl bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-6">
      <i data-lucide="bell" class="w-7 h-7 text-orange-500"></i>
      Notifications
    </h2>
    <ul class="divide-y divide-orange-100 dark:divide-gray-700">
      <li class="py-4 flex items-center gap-3">
        <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
        <span class="text-gray-800 dark:text-gray-100">Your registration for <b>CodeFest</b> was successful!</span>
        <span class="ml-auto text-xs text-gray-500">2h ago</span>
      </li>
      <li class="py-4 flex items-center gap-3">
        <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
        <span class="text-gray-800 dark:text-gray-100">Leaderboard updated. Check your new rank!</span>
        <span class="ml-auto text-xs text-gray-500">5h ago</span>
      </li>
      <li class="py-4 flex items-center gap-3">
        <span class="inline-block w-2 h-2 bg-orange-300 rounded-full"></span>
        <span class="text-gray-700 dark:text-gray-300">New event <b>Design Sprint</b> is live.</span>
        <span class="ml-auto text-xs text-gray-500">1d ago</span>
      </li>
    </ul>
  </div>
</div>
</div>
<?php // Close sidebar/layout div from header.php ?>
<script>if(window.lucide) lucide.createIcons();</script>
