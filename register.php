


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - EventHive</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>@font-face {
  font-family: "Geist";
  src: url("https://assets.codepen.io/605876/GeistVF.ttf") format("truetype");
}
* { box-sizing: border-box; }
:root { --size: 20px; }
body {
  display: grid;
  place-items: center;
  min-height: 100vh;
  background: hsl(0 0% 6%);
}
.el {
  background: conic-gradient(from 180deg at 50% 70%,hsla(0,0%,98%,1) 0deg,#eec32d 72.0000010728836deg,#ec4b4b 144.0000021457672deg,#709ab9 216.00000858306885deg,#4dffbf 288.0000042915344deg,hsla(0,0%,98%,1) 1turn);
  width: 100%;
  height: 100%;
  mask:
    radial-gradient(circle at 50% 50%, white 2px, transparent 2.5px) 50% 50% / var(--size) var(--size),
    url("https://assets.codepen.io/605876/noise-mask.png") 256px 50% / 256px 256px;
  mask-composite: intersect;
  animation: flicker 20s infinite linear;
}
h1 {
  position: fixed;
  top: 50%;
  left: 50%;
  translate: -50% -50%;
  margin: 0;
  font-size: clamp(6rem, 8vw + 1rem, 14rem);
  font-family: "Geist", sans-serif;
  font-weight: 140;
  color: hsl(0 0% 2%);
  mix-blend-mode: soft-light;
/*   -webkit-text-stroke: 2px hsl(0 0% 100% / 0.95); */
  filter: drop-shadow(0 0 2px white);
  text-shadow: 2px 2px white;
}
@keyframes flicker {
  to {
    mask-position: 50% 50%, 0 50%;
  }
}
body { font-family: 'Inter', Arial, sans-serif; }
</style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-inter">
  <div class="el" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:0;pointer-events:none;"></div>
  <canvas id="perlin-bg" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:0;pointer-events:none;"></canvas>
  <div class="relative z-10 w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-orange-100">
    <div class="flex flex-col items-center mb-6">
      <span class="text-2xl font-bold text-orange-500 mb-2">EventHive</span>
      <h2 class="text-xl font-semibold text-gray-800">Create your account</h2>
    </div>
    <form id="registerForm" action="./operations/register_user.php" method="POST" class="space-y-4">
      <!-- Step 1 -->
      <div id="step1">
        <div>
          <label for="username" class="block text-gray-700 mb-1">Username</label>
          <input type="text" id="username" name="username" placeholder="Choose a username" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="password" class="block text-gray-700 mb-1">Password</label>
          <input type="password" id="password" name="password" placeholder="Create a password" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="name" class="block text-gray-700 mb-1">Full Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your full name" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="rollnumber" class="block text-gray-700 mb-1">Roll Number</label>
          <input type="text" id="rollnumber" name="rollnumber" placeholder="Enter your roll number" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="emailid" class="block text-gray-700 mb-1">Email</label>
          <input type="email" id="emailid" name="emailid" placeholder="Enter your email address" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="mobile_number" class="block text-gray-700 mb-1">Mobile Number</label>
          <input type="tel" id="mobile_number" name="mobile_number" placeholder="Enter your mobile number" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <button type="button" id="nextBtn" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition mt-4">Next</button>
      </div>
      <!-- Step 2 -->
      <div id="step2" style="display:none;">
        <div>
          <label for="city" class="block text-gray-700 mb-1">City</label>
          <input type="text" id="city" name="city" placeholder="Enter your city" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="college" class="block text-gray-700 mb-1">College</label>
          <input type="text" id="college" name="college" placeholder="Enter your college" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="year" class="block text-gray-700 mb-1">Year</label>
          <input type="number" id="year" name="year" placeholder="Enter your year" min="1" max="4" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="dept" class="block text-gray-700 mb-1">Department</label>
          <input type="text" id="dept" name="dept" placeholder="Enter your department" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition mt-4">Register</button>
        <div class="text-center text-sm text-gray-600 mt-2">
          Already have an account? <a href="login.php" class="text-orange-500 hover:underline">Sign in</a>
        </div>
      </div>
      <!-- Step 1 -->
      <div id="step1">
        <div>
          <label for="username" class="block text-gray-700 mb-1">Username</label>
          <input type="text" id="username" name="username" placeholder="Choose a username" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="password" class="block text-gray-700 mb-1">Password</label>
          <input type="password" id="password" name="password" placeholder="Create a password" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="name" class="block text-gray-700 mb-1">Full Name</label>
          <input type="text" id="name" name="name" placeholder="Enter your full name" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="rollnumber" class="block text-gray-700 mb-1">Roll Number</label>
          <input type="text" id="rollnumber" name="rollnumber" placeholder="Enter your roll number" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="emailid" class="block text-gray-700 mb-1">Email</label>
          <input type="email" id="emailid" name="emailid" placeholder="Enter your email address" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="mobile_number" class="block text-gray-700 mb-1">Mobile Number</label>
          <input type="tel" id="mobile_number" name="mobile_number" placeholder="Enter your mobile number" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <button type="button" id="nextBtn" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition mt-4">Next</button>
      </div>
      <!-- Step 2 -->
      <div id="step2" style="display:none;">
        <div>
          <label for="city" class="block text-gray-700 mb-1">City</label>
          <input type="text" id="city" name="city" placeholder="Enter your city" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="college" class="block text-gray-700 mb-1">College</label>
          <input type="text" id="college" name="college" placeholder="Enter your college" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="year" class="block text-gray-700 mb-1">Year</label>
          <input type="number" id="year" name="year" placeholder="Enter your year" min="1" max="4" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>
        <div>
          <label for="dept" class="block text-gray-700 mb-1">Department</label>
        <input type="text" id="rollnumber" name="rollnumber" placeholder="Enter your roll number" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="emailid" class="block text-gray-700 mb-1">Email</label>
        <input type="email" id="emailid" name="emailid" placeholder="Enter your email address" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="mobile_number" class="block text-gray-700 mb-1">Mobile Number</label>
        <input type="tel" id="mobile_number" name="mobile_number" placeholder="Enter your mobile number" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="city" class="block text-gray-700 mb-1">City</label>
        <input type="text" id="city" name="city" placeholder="Enter your city" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="college" class="block text-gray-700 mb-1">College</label>
        <input type="text" id="college" name="college" placeholder="Enter your college" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="year" class="block text-gray-700 mb-1">Year</label>
        <input type="number" id="year" name="year" placeholder="Enter your year" min="1" max="4" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <div>
        <label for="dept" class="block text-gray-700 mb-1">Department</label>
        <input type="text" id="dept" name="dept" placeholder="Enter your department" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>
      <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition">Register</button>
      <div class="text-center text-sm text-gray-600 mt-2">
        Already have an account? <a href="login.php" class="text-orange-500 hover:underline">Sign in</a>
      </div>
    </form>
  </div>
</body>
</html>
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
