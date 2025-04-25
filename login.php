<?php $pageTitle = "Login - EventHive"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - EventHive</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="./assets/css/loader.css">
  <style>body { font-family: 'Inter', Arial, sans-serif; }</style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-inter">
  <!-- Loader overlay -->
  <div id="page-loader" class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-70 z-50 hidden">
    <div class="loadingspinner">
      <div id="square1"></div>
      <div id="square2"></div>
      <div id="square3"></div>
      <div id="square4"></div>
      <div id="square5"></div>
    </div>
  </div>
  <!-- Login/Register Card -->
  <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-orange-100">
    <div class="login-card" style="display:block;">
      <div class="flex flex-col items-center mb-6">
        <span class="text-2xl font-bold text-orange-500 mb-2">EventHive</span>
        <h2 class="text-xl font-semibold text-gray-800">Sign in to your account</h2>
      </div>
      <?php if(isset($_GET['error'])): ?>
        <div class="mb-4 text-red-600 bg-red-50 border border-red-200 rounded p-2 text-sm text-center"><?php echo htmlspecialchars($_GET['error']); ?></div>
      <?php endif; ?>
      <form id="loginForm" action="./operations/login_validation.php" method="POST" class="space-y-4">
        <div class="flex gap-4 justify-center items-center">
          <label class="font-normal flex items-center gap-1">
            <input type="radio" name="user_type" value="user" checked class="accent-orange-500"> User
          </label>
          <label class="font-normal flex items-center gap-1">
            <input type="radio" name="user_type" value="admin" class="accent-orange-500"> Admin
          </label>
        </div>
        <div>
          <label for="username" class="block text-gray-700 mb-1">Username or Email</label>
          <input type="text" id="username" name="username" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="password" class="block text-gray-700 mb-1">Password</label>
          <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <button id="loginBtn" type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition">Login</button>
        <div class="text-center text-sm text-gray-600 mt-2">
          Don't have an account? <a href="#" onclick="toggleForm(event)" class="text-orange-500 hover:underline">Register</a>
        </div>
      </form>
    </div>
    <div class="register-card" style="display:none;">
      <div class="flex flex-col items-center mb-6">
        <span class="text-2xl font-bold text-orange-500 mb-2">EventHive</span>
        <h2 class="text-xl font-semibold text-gray-800">Create an account</h2>
      </div>
      <form id="registerForm" action="./operations/register_user.php" method="POST" class="space-y-4">
        <div>
          <label for="reg-username" class="block text-gray-700 mb-1">Username</label>
          <input type="text" id="reg-username" name="username" placeholder="Choose a username" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="reg-password" class="block text-gray-700 mb-1">Password</label>
          <input type="password" id="reg-password" name="password" placeholder="Create a password" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="reg-name" class="block text-gray-700 mb-1">Full Name</label>
          <input type="text" id="reg-name" name="name" placeholder="Enter your full name" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="reg-rollnumber" class="block text-gray-700 mb-1">Roll Number</label>
          <input type="text" id="reg-rollnumber" name="rollnumber" placeholder="Enter your roll number" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="reg-emailid" class="block text-gray-700 mb-1">Email</label>
          <input type="email" id="reg-emailid" name="emailid" placeholder="Enter your email address" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="reg-mobile_number" class="block text-gray-700 mb-1">Mobile Number</label>
          <input type="tel" id="reg-mobile_number" name="mobile_number" placeholder="Enter your mobile number" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="reg-city" class="block text-gray-700 mb-1">City</label>
          <input type="text" id="reg-city" name="city" placeholder="Enter your city" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="reg-college" class="block text-gray-700 mb-1">College</label>
          <input type="text" id="reg-college" name="college" placeholder="Enter your college" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="reg-year" class="block text-gray-700 mb-1">Year</label>
          <input type="number" id="reg-year" name="year" placeholder="Enter your year" min="1" max="4" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="reg-dept" class="block text-gray-700 mb-1">Department</label>
          <input type="text" id="reg-dept" name="dept" placeholder="Enter your department" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <button id="registerBtn" type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition">Register</button>
        <div class="text-center text-sm text-gray-600 mt-2">
          Already have an account? <a href="#" onclick="toggleForm(event)" class="text-orange-500 hover:underline">Login</a>
        </div>
      </form>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Hide loader initially
      document.getElementById('page-loader').style.display = 'none';
      const loader = document.getElementById('page-loader');
      const showLoader = () => loader.style.display = 'flex';
      document.getElementById('loginBtn').addEventListener('click', showLoader);
      document.getElementById('registerBtn').addEventListener('click', showLoader);
      // Set initial form visibility
      document.querySelector('.login-card').style.display = 'block';
      document.querySelector('.register-card').style.display = 'none';
    });
    function toggleForm(event) {
      event.preventDefault();
      var loginCard = document.querySelector('.login-card');
      var registerCard = document.querySelector('.register-card');

      if (loginCard.style.display === 'block') {
        loginCard.style.display = 'none';
        registerCard.style.display = 'block';
      } else {
        loginCard.style.display = 'block';
        registerCard.style.display = 'none';
      }
    }
  </script>
</body>
</html>
