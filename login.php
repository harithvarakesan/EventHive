<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EventHive</title>
    <link rel="stylesheet" href="./assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container" id="loginContainer">
        <!-- Login Box -->
        <div class="login-box">
            <h2>Welcome Back</h2>
            <form action="./operations/login_validation.php" method="POST">
                <div class="user-type">
                    <label>
                        <input type="radio" name="user_type" value="user" checked> User Login
                    </label>
                    <label>
                        <input type="radio" name="user_type" value="admin"> Admin Login
                    </label>
                </div>
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username/email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <button type="submit" class="login-btn">Login</button>
                <div class="signup-link">
                    <p>Don't have an account? <a href="#" onclick="toggleRegister(event)">Sign up</a></p>
                </div>
            </form>
        </div>
        
        <!-- Image Side -->
        <div class="image-side">
            <img src="./assets/image/login.jpg" alt="Login Image">
            <div class="overlay">
                <h2>New Here?</h2>
                <p>Sign up and discover a great amount of new opportunities and events!</p>
                <button class="register-btn" onclick="toggleRegister(event)">Sign Up</button>
            </div>
        </div>
        
        <!-- Registration Form -->
        <div class="register-form">
            <h2>Create Account</h2>
            <form action="./operations/register_user.php" method="POST">
                <div class="input-group">
                    <label for="reg-username">Username</label>
                    <input type="text" id="reg-username" name="username" placeholder="Choose a username" required>
                </div>
                <div class="input-group">
                    <label for="reg-password">Password</label>
                    <input type="password" id="reg-password" name="password" placeholder="Create a password" required>
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

    <script>
        function toggleRegister(e) {
            e.preventDefault();
            document.getElementById('loginContainer').classList.toggle('register-active');
        }
    </script>
</body>
</html>