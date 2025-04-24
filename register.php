<?php $pageTitle = "Register - EventHive"; include 'header.php'; ?>
<style>
  .hide-sidebar { display: none !important; }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.fixed.top-0.left-0');
    if(sidebar) sidebar.classList.add('hide-sidebar');
  });
</script>
<div class="min-h-screen flex items-center justify-center bg-gray-50 font-inter py-12 px-4">
  <div class="w-full max-w-md bg-white rounded-xl shadow-md p-10 border border-orange-100">
    <div class="flex flex-col items-center mb-6">
      <span class="text-2xl font-bold text-orange-500 mb-2">EventHive</span>
      <h2 class="text-xl font-semibold text-gray-800">Create your account</h2>
    </div>
    <form action="./operations/register_validation.php" method="POST" class="space-y-4">
      <div>
        <label for="name" class="block text-gray-700 mb-1">Full Name</label>
        <input type="text" id="name" name="name" placeholder="Enter your full name" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="email" class="block text-gray-700 mb-1">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email address" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="username" class="block text-gray-700 mb-1">Username</label>
        <input type="text" id="username" name="username" placeholder="Choose a username" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="password" class="block text-gray-700 mb-1">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="confirm_password" class="block text-gray-700 mb-1">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter your password" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition">Register</button>
      <div class="text-center text-sm text-gray-600 mt-2">
        Already have an account? <a href="login.php" class="text-orange-500 hover:underline">Sign in</a>
      </div>
    </form>
  </div>
</div>
<!-- Toast Notification -->
<div id="toast" class="fixed bottom-6 right-6 z-50 hidden bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg font-medium"></div>
<script>
// Toast logic
function showToast(message, type = 'success') {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.className = `fixed bottom-6 right-6 z-50 px-6 py-3 rounded-lg shadow-lg font-medium bg-${type === 'success' ? 'green' : 'red'}-500 text-white animate-fadeIn`;
  toast.style.display = 'block';
  setTimeout(() => { toast.style.display = 'none'; }, 3500);
}
// Show toast if redirected with success or error
window.addEventListener('DOMContentLoaded', function() {
  const params = new URLSearchParams(window.location.search);
  if(params.get('success') === '1') {
    showToast('Registration successful! You can now sign in.', 'success');
  }
  if(params.get('error')) {
    showToast(params.get('error'), 'error');
  }
});
</script>
<style>
@keyframes fadeIn { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
.animate-fadeIn { animation: fadeIn 0.4s; }
</style>

<style>
  .hide-sidebar { display: none !important; }
</style>
<script>
  // Hide sidebar if present
  document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.fixed.top-0.left-0');
    if(sidebar) sidebar.classList.add('hide-sidebar');
  });
</script>
<div class="min-h-screen flex items-center justify-center bg-gray-50 font-inter py-12 px-4">
  <div class="w-full max-w-md bg-white rounded-xl shadow-md p-10 border border-orange-100">
    <div class="flex flex-col items-center mb-6">
      <span class="text-2xl font-bold text-orange-500 mb-2">EventHive</span>
      <h2 class="text-xl font-semibold text-gray-800">Create your account</h2>
    </div>
    <div class="bg-white rounded-xl shadow-md p-10 border border-orange-100 w-full max-w-md mt-12">
        <h2 class="text-2xl font-bold text-orange-500 mb-6 flex items-center gap-2"><i data-lucide="user-plus"></i> Sign Up</h2>
        <form action="#" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label for="email" class="block text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label for="password" class="block text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <button type="submit" class="w-full bg-orange-500 text-white rounded-lg py-2 font-semibold hover:bg-orange-600 transition flex items-center justify-center gap-2"><i data-lucide="arrow-right-circle"></i> Sign Up</button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-600">Already have an account? <a href="login.php" class="text-orange-500 hover:underline">Sign In</a></p>
    </div>
</div>
</body>
</html>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) lucide.createIcons();
      });
    </script>
</div>
</body>
</html>
