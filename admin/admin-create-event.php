<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/bee-loader.css">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <div id="bee-loader" class="bee-loader-container" style="display:none">
      <div class="bee-loader">
        <div class="bee-wings">
          <div class="bee-wing left"></div>
          <div class="bee-wing right"></div>
        </div>
        <div class="bee-body"></div>
        <div class="bee-stripes">
          <span class="stripe1"></span>
          <span class="stripe2"></span>
          <span class="stripe3"></span>
        </div>
        <div class="bee-face">
          <div class="bee-eye"></div>
          <div class="bee-eye"></div>
        </div>
      </div>
    </div>
        <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
    <?php include '../admin/admin_sidebar.php'; ?>
    <div class="md:ml-60 flex flex-col min-h-screen transition-all duration-300">
        <header class="flex items-center justify-between px-6 py-6 border-b bg-white sticky top-0 z-40">
            <h1 class="text-2xl font-bold text-orange-600">Create New Event</h1>
            <a href="../admin/admin-your-events.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-orange-100 text-orange-700 hover:bg-orange-200 font-medium transition"><i data-lucide='arrow-left' class='w-5 h-5'></i> Back to Events</a>
        </header>
        <main class="flex-1 p-6 flex items-center justify-center">
            <div class="w-full max-w-2xl bg-white rounded-xl shadow p-8 border border-orange-100">
                <form action="operations/insert-event.php" method="POST" class="space-y-5" id="create-event-form">
                    <div>
                        <label for="event-name" class="block font-semibold text-gray-700 mb-1">Event Name</label>
                        <input type="text" id="event-name" name="name" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="short-description" class="block font-semibold text-gray-700 mb-1">Short Description</label>
                        <input type="text" id="short-description" name="short_description" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div>
                        <label for="long-description" class="block font-semibold text-gray-700 mb-1">Long Description</label>
                        <textarea id="long-description" name="long_description" rows="4" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50"></textarea>
                    </div>
                    <div>
                        <label for="eligibility" class="block font-semibold text-gray-700 mb-1">Eligibility</label>
                        <textarea id="eligibility" name="eligibility" rows="2" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50"></textarea>
                    </div>
                    <div>
                        <label for="type" class="block font-semibold text-gray-700 mb-1">Event Type</label>
                        <input type="text" id="type" name="type" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start-date" class="block font-semibold text-gray-700 mb-1">Start Date</label>
                            <input type="datetime-local" id="start-date" name="start_date" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                        </div>
                        <div>
                            <label for="end-date" class="block font-semibold text-gray-700 mb-1">End Date</label>
                            <input type="datetime-local" id="end-date" name="end_date" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                        </div>
                        <div>
                            <label for="deadline-date" class="block font-semibold text-gray-700 mb-1">Deadline Date</label>
                            <input type="datetime-local" id="deadline-date" name="deadline_date" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                        </div>
                        <div>
                            <label for="location" class="block font-semibold text-gray-700 mb-1">Location</label>
                            <input type="text" id="location" name="location" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="coordinator" class="block font-semibold text-gray-700 mb-1">Coordinator Name</label>
                            <input type="text" id="coordinator" name="coordinator" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                        </div>
                        <div>
                            <label for="coordinator-number" class="block font-semibold text-gray-700 mb-1">Coordinator Number</label>
                            <input type="text" id="coordinator-number" name="coordinator_number" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                        </div>
                        <div>
                            <label for="coordinator-email" class="block font-semibold text-gray-700 mb-1">Coordinator Email</label>
                            <input type="email" id="coordinator-email" name="coordinator_emailid" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                        </div>
                        <div>
                            <label for="prize" class="block font-semibold text-gray-700 mb-1">Prize</label>
                            <input type="text" id="prize" name="prize" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                        </div>
                    </div>
                    <div>
                        <label for="website" class="block font-semibold text-gray-700 mb-1">Event Website</label>
                        <input type="text" id="website" name="website" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none bg-gray-50">
                    </div>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 mt-4 rounded-lg bg-orange-500 text-white hover:bg-orange-600 font-semibold text-lg transition disabled:opacity-50" id="submit-btn">
                        <i data-lucide='plus-circle' class='w-5 h-5'></i> Create Event
                    </button>
                </form>
            </div>
        </main>
    </div>
    <script>
    // Lucide icons
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) lucide.createIcons();
    });
    // Button loading state
    document.getElementById('create-event-form').addEventListener('submit', function(e) {
        var btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2 text-white inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Creating...';
    });
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="assets/js/uiux.js"></script>
<script>
window.showBeeLoader = function(show = true) {
  const loader = document.getElementById('bee-loader');
  if (!loader) return;
  loader.style.display = show ? 'flex' : 'none';
}
</script>
<script>
// Toast utility
window.showToast = function(msg, type = 'info', duration = 3000) {
  const toast = document.createElement('div');
  toast.className = `px-4 py-2 rounded shadow text-white font-semibold toast-${type}`;
  toast.style.background = type === 'success' ? '#16a34a' : type === 'error' ? '#dc2626' : '#ea580c';
  toast.textContent = msg;
  document.getElementById('toast-container').appendChild(toast);
  setTimeout(() => toast.remove(), duration);
}
</script>
<style>.toast-info{background:#ea580c}.toast-success{background:#16a34a}.toast-error{background:#dc2626}</style>
</body>
</html>
