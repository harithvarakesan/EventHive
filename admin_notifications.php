<?php
// admin_notifications.php - Admin notifications page
$pageTitle = "Admin Notifications - EventHive";
include 'admin-header.php';
?>
<div class="flex-1 flex flex-col items-center justify-start py-12">
  <div class="w-full max-w-2xl bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-8">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-2 mb-6">
      <i data-lucide="bell" class="w-7 h-7 text-orange-500"></i>
      Admin Notifications
    </h2>
    <ul id="admin-notif-list" class="divide-y divide-orange-100 dark:divide-gray-700"></ul>
  </div>
</div>
<script>
function timeAgo(dateString) {
  const now = new Date();
  const then = new Date(dateString);
  const diff = Math.floor((now - then) / 1000);
  if (diff < 60) return 'just now';
  if (diff < 3600) return Math.floor(diff/60) + 'm ago';
  if (diff < 86400) return Math.floor(diff/3600) + 'h ago';
  return Math.floor(diff/86400) + 'd ago';
}
function fetchAdminNotifications() {
  fetch('get_all_notifications.php')
    .then(res => res.json())
    .then(data => {
      const list = document.getElementById('admin-notif-list');
      list.innerHTML = '';
      if (data.notifications && data.notifications.length > 0) {
        data.notifications.forEach(n => {
          const li = document.createElement('li');
          li.className = 'py-4 flex items-center gap-3';
          li.innerHTML = `<span class="inline-block w-2 h-2 ${n.is_read == 0 ? 'bg-red-500' : 'bg-orange-300'} rounded-full"></span>` +
            `<span class="${n.is_read == 0 ? 'text-gray-800 dark:text-gray-100' : 'text-gray-700 dark:text-gray-300'}">${n.message}</span>` +
            `<span class="ml-auto text-xs text-gray-500">${timeAgo(n.created_at)}</span>`;
          list.appendChild(li);
        });
      } else {
        list.innerHTML = '<li class="py-4 text-gray-400">No notifications</li>';
      }
    });
}
fetchAdminNotifications();
setInterval(fetchAdminNotifications, 5000);
if(window.lucide) lucide.createIcons();
</script>
