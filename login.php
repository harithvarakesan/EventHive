<?php $pageTitle = "Login - EventHive"; include 'header.php'; ?>
<style>
  .hide-sidebar { display: none !important; }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.fixed.top-0.left-0');
    if(sidebar) sidebar.classList.add('hide-sidebar');
  });
</script>
<!-- Single, modern login form -->
<div class="min-h-screen flex items-center justify-center bg-gray-50 font-inter py-12 px-4">
  <div class="w-full max-w-md bg-white rounded-xl shadow-md p-10 border border-orange-100">
    <div class="flex flex-col items-center mb-6">
      <span class="text-2xl font-bold text-orange-500 mb-2">EventHive</span>
      <h2 class="text-xl font-semibold text-gray-800">Sign in to your account</h2>
    </div>
    <?php if(isset($_GET['error'])): ?>
      <div class="mb-4 text-red-600 bg-red-50 border border-red-200 rounded p-2 text-sm text-center"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    <form action="./operations/login_validation.php" method="POST" class="space-y-4">
      <div class="flex gap-4 items-center justify-center">
        <label class="flex items-center gap-1 cursor-pointer">
          <input type="radio" name="user_type" value="user" checked class="accent-orange-500"> User
        </label>
        <label class="flex items-center gap-1 cursor-pointer">
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
      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 text-sm">
          <input type="checkbox" id="remember" name="remember" class="accent-orange-500"> Remember me
        </label>
        <a href="#" class="text-orange-500 text-sm hover:underline">Forgot password?</a>
      </div>
      <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition">Login</button>
      <div class="text-center text-sm text-gray-600 mt-2">
        Don't have an account? <a href="register.php" class="text-orange-500 hover:underline">Sign up</a>
      </div>
    </form>
  </div>
</div>

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

                </div>
                <div class="input-group">
                    <label for="reg-name">Full Name</label>
                    <input type="text" id="reg-name" name="name" placeholder="Enter your full name" required>
                </div>
                <div class="input-group">
                    <label for="reg-rollnumber">Roll Number</label>
                    <input type="text" id="reg-rollnumber" name="rollnumber" placeholder="Enter your roll number" required>
                </div>
                <div class="input-group">
                    <label for="reg-email">Email</label>
                    <input type="email" id="reg-email" name="emailid" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="reg-mobile">Mobile Number</label>
                    <input type="tel" id="reg-mobile" name="mobile_number" placeholder="Enter your mobile number" required>
                </div>
                <div class="input-group">
                    <label for="reg-city">City</label>
                    <input type="text" id="reg-city" name="city" placeholder="Enter your city" required>
                </div>
                <div class="input-group">
                    <label for="reg-college">College</label>
                    <input type="text" id="reg-college" name="college" placeholder="Enter your college" required>
                </div>
                <div class="input-group">
                    <label for="reg-year">Year</label>
                    <input type="number" id="reg-year" name="year" placeholder="Enter your year" min="1" max="4" required>
                </div>
                <div class="input-group">
                    <label for="reg-dept">Department</label>
                    <input type="text" id="reg-dept" name="dept" placeholder="Enter your department" required>
                </div>
                <button type="submit" class="register-btn">Create Account</button>
                <div class="login-link">
                    <p>Already have an account? <a href="#" onclick="toggleRegister(event)">Login</a></p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>