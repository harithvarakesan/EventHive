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
  <div class="relative z-10 w-full max-w-md bg-white rounded-xl shadow-lg p-8 border border-orange-100">
    <div class="login-card" style="display:block;">
      <div class="flex flex-col items-center mb-6">
        <span class="text-2xl font-bold text-orange-500 mb-2">EventHive</span>
        <h2 class="text-xl font-semibold text-gray-800">Sign in to your account</h2>
      </div>
      <?php if(isset($_GET['error'])): ?>
        <div class="mb-4 text-red-600 bg-red-50 border border-red-200 rounded p-2 text-sm text-center"><?php echo htmlspecialchars($_GET['error']); ?></div>
      <?php endif; ?>
      <form id="loginForm" action="operations/login_validation.php" method="POST" class="space-y-4">
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
      <form id="registerForm" action="operations/register_user.php" method="POST" class="space-y-4">
        <!-- Step 1 -->
        <div id="reg-step1">
          <div>
            <label for="reg-username" class="block text-gray-700 mb-1">Username</label>
            <input type="text" id="reg-username" name="username" placeholder="Epic Alias" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>
          <div>
            <label for="reg-password" class="block text-gray-700 mb-1">Password</label>
            <input type="password" id="reg-password" name="password" placeholder="Secret Sauce" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>
          <div>
            <label for="reg-name" class="block text-gray-700 mb-1">Full Name</label>
            <input type="text" id="reg-name" name="name" placeholder="Real You" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>
          <div>
            <label for="reg-rollnumber" class="block text-gray-700 mb-1">Roll Number</label>
            <input type="text" id="reg-rollnumber" name="rollnumber" placeholder="ID Please" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>
          <div>
            <label for="reg-emailid" class="block text-gray-700 mb-1">Email</label>
            <input type="email" id="reg-emailid" name="emailid" placeholder="Inbox Magic" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>
          <div>
            <label for="reg-mobile_number" class="block text-gray-700 mb-1">Mobile Number</label>
            <input type="tel" id="reg-mobile_number" name="mobile_number" placeholder="Ring Ring" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>
          <button type="button" id="reg-nextBtn" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition mt-4">Next</button>
        </div>
        <!-- Step 2 -->
        <div id="reg-step2" style="display:none;">
          <div>
            <label for="reg-city" class="block text-gray-700 mb-1">City</label>
            <input type="text" id="reg-city" name="city" placeholder="Enter your city" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
          </div>
          <div>
            <label for="reg-college" class="block text-gray-700 mb-1">College</label>
            <select id="reg-college" name="college" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
              <option value="">Select your college</option>
              <option value="IIT">IIT</option>
              <option value="NIT">NIT</option>
              <option value="IIIT">IIIT</option>
              <option value="BITS">BITS</option>
              <option value="VIT">VIT</option>
              <option value="SRM">SRM</option>
              <option value="Other">Other</option>
            </select>
            <input type="text" id="reg-college-other" name="college_other" placeholder="Type Here" class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 mt-2" style="display:none;">
          </div>
          <div>
            <label for="reg-year" class="block text-gray-700 mb-1">Year</label>
            <select id="reg-year" name="year" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" placeholder="Class Year">
              <option value="">Select year</option>
              <option value="1">1st Year</option>
              <option value="2">2nd Year</option>
              <option value="3">3rd Year</option>
              <option value="4">4th Year</option>
            </select>
          </div>
          <div class="mb-4">
            <label for="reg-dept" class="block text-gray-700 mb-1">Department</label>
            <select id="reg-dept" name="dept" required class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" placeholder="Dept Squad">
              <option value="">Select department</option>
              <option value="CSE">Computer Science & Engineering</option>
              <option value="ECE">Electronics & Communication</option>
              <option value="EEE">Electrical & Electronics</option>
              <option value="MECH">Mechanical</option>
              <option value="CIVIL">Civil</option>
              <option value="CHEM">Chemical</option>
              <option value="BIO">Biotechnology</option>
              <option value="Other">Other</option>
            </select>
            <input type="text" id="reg-dept-other" name="dept_other" placeholder="Type Dept" class="w-full px-4 py-2 border border-orange-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 mt-2" style="display:none;">
          </div>
          <button id="registerBtn" type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition mb-2">Register</button>
          <div class="text-center text-sm text-gray-600 mt-2">
            Already have an account? <a href="#" onclick="toggleForm(event)" class="text-orange-500 hover:underline">Login</a>
          </div>
        </div>
      </form>
      <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('reg-nextBtn').onclick = function() {
          // Validate first step fields
          const step1 = document.getElementById('reg-step1');
          const inputs = step1.querySelectorAll('input');
          let valid = true;
          inputs.forEach(input => {
            if (!input.value) {
              input.classList.add('ring-2','ring-red-400');
              valid = false;
            } else {
              input.classList.remove('ring-2','ring-red-400');
            }
          });
          if (valid) {
            step1.style.display = 'none';
            document.getElementById('reg-step2').style.display = 'block';
          }
          return false;
        };
      });
      </script>
      <script>
      // Show/hide 'Other' input for College and Department
      document.addEventListener('DOMContentLoaded', function() {
        var collegeSelect = document.getElementById('reg-college');
        var collegeOther = document.getElementById('reg-college-other');
        var deptSelect = document.getElementById('reg-dept');
        var deptOther = document.getElementById('reg-dept-other');
        function toggleOther(select, otherInput) {
          if (select.value === 'Other') {
            otherInput.style.display = 'block';
            otherInput.required = true;
          } else {
            otherInput.style.display = 'none';
            otherInput.required = false;
            otherInput.value = '';
          }
        }
        collegeSelect.addEventListener('change', function() {
          toggleOther(collegeSelect, collegeOther);
        });
        deptSelect.addEventListener('change', function() {
          toggleOther(deptSelect, deptOther);
        });
        // On page load, in case of back navigation
        toggleOther(collegeSelect, collegeOther);
        toggleOther(deptSelect, deptOther);
      });
      </script>
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
<script>
// Simple Perlin Noise Animation for Backdrop
const canvas = document.getElementById('perlin-bg');
const ctx = canvas.getContext('2d');
function resize() {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
}
window.addEventListener('resize', resize);
resize();
// Simple Perlin noise implementation
const p = new Uint8Array(512);
for (let i = 0; i < 256; ++i) p[i] = p[i + 256] = Math.floor(Math.random() * 256);
function fade(t){return t*t*t*(t*(t*6-15)+10);}
function lerp(a,b,t){return a+(b-a)*t;}
function grad(hash,x,y){const h=hash&3;return((h&1)?-x:x)+((h&2)?-y:y);}
function noise(x,y){
  const X=Math.floor(x)&255,Y=Math.floor(y)&255;
  x-=Math.floor(x); y-=Math.floor(y);
  const u=fade(x),v=fade(y);
  const A=p[X]+Y,AA=p[A],AB=p[A+1],B=p[X+1]+Y,BA=p[B],BB=p[B+1];
  return lerp(lerp(grad(p[AA],x,y),grad(p[BA],x-1,y),u),
              lerp(grad(p[AB],x,y-1),grad(p[BB],x-1,y-1),u),v);
}
function draw(t){
  const w=canvas.width,h=canvas.height;
  ctx.clearRect(0,0,w,h);
  for(let y=0;y<h;y+=4){
    for(let x=0;x<w;x+=4){
      const n = noise(x*0.008 + t*0.0002, y*0.008 + t*0.0002);
      const c = Math.floor(230 + 20*n); // orange to yellow
      ctx.fillStyle = `rgba(${c},${170+30*n},80,0.09)`;
      ctx.fillRect(x,y,4,4);
    }
  }
  requestAnimationFrame(draw);
}
draw(0);
</script>
</body>
</html>
