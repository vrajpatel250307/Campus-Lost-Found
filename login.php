<?php
ob_start();
session_start();
include 'dbconnect.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_email = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $sql = "SELECT `name`, `email`, `mobile`, `enrollment`, `student_email`, `department`, `address`, `college_id_card`, `password` 
            FROM `stu_register` 
            WHERE email = '$login_email' OR student_email = '$login_email'";
    
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Password is correct, store all user details in session
            $_SESSION['user_id'] = $user['enrollment']; // Set user_id for navbar check
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['mobile'] = $user['mobile'];
            $_SESSION['enrollment'] = $user['enrollment'];
            $_SESSION['student_email'] = $user['student_email'];
            $_SESSION['department'] = $user['department'];
            $_SESSION['address'] = $user['address'];
            $_SESSION['college_id_card'] = $user['college_id_card'];
            
            // Clear any existing output and redirect
            ob_clean();
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Campus Lost and Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #333;
            line-height: 1.6;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .login-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23111" stop-opacity="0.1"/><stop offset="100%" stop-color="%23111" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>') no-repeat center;
            background-size: cover;
            opacity: 0.3;
            z-index: 0;
        }

        .content-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 80px rgba(17, 17, 17, 0.05);
            max-width: 450px;
            width: 100%;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transform: translateY(20px);
            animation: slideUp 0.8s ease-out forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
            }
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #111 0%, #555 50%, #111 100%);
            border-radius: 24px 24px 0 0;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-container {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .logo-container img {
            width: 50px;
            height: 35px;
            object-fit: contain;
            background: #fff;
            padding: 8px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #111 0%, #444 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .login-subtitle {
            font-size: 1rem;
            color: #666;
            margin-bottom: 30px;
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 16px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .form-group input:focus {
            border-color: #111;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(17, 17, 17, 0.1);
            transform: translateY(-2px);
        }

        .form-group input::placeholder {
            color: #999;
            transition: opacity 0.3s ease;
        }

        .form-group input:focus::placeholder {
            opacity: 0.5;
        }

        .login-btn {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #111 0%, #333 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(17, 17, 17, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .form-links {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .form-links a {
            color: #111;
            text-decoration: none;
            font-weight: 500;
            margin: 0 15px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .form-links a:hover {
            background: rgba(17, 17, 17, 0.1);
            transform: translateY(-1px);
        }

        .divider {
            display: inline-block;
            color: #ccc;
            margin: 0 10px;
        }

        /* Floating particles animation */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(17, 17, 17, 0.3);
            border-radius: 50%;
            animation: float 6s infinite ease-in-out;
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 5s; }

        @keyframes float {
            0%, 100% { 
                transform: translateY(100vh) rotate(0deg); 
                opacity: 0; 
            }
            10%, 90% { 
                opacity: 1; 
            }
            50% { 
                transform: translateY(50vh) rotate(180deg); 
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-card {
                margin: 20px;
                padding: 40px 30px;
                border-radius: 20px;
            }
            
            .login-title {
                font-size: 1.8rem;
            }
            
            .form-links a {
                display: block;
                margin: 10px 0;
            }
            
            .divider {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .content-container {
                padding: 20px 10px;
            }
            
            .login-card {
                padding: 35px 25px;
            }
            
            .login-title {
                font-size: 1.6rem;
            }
        }

        /* Loading animation */
        .login-btn.loading {
            pointer-events: none;
        }

        .login-btn.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-fluid">
        <?php include 'includes/navbar.php'; ?>
    </div>

    <div class="login-wrapper">
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        
        <div class="content-container">
            <div class="login-card">
                <div class="logo-section">
                    <div class="logo-container">
                        <img src="images/Guni_Logo.png" alt="Ganpat University Logo">
                    </div>
                    <h1 class="login-title">Welcome Back</h1>
                    <p class="login-subtitle">Sign in to your Campus Lost & Found account</p>
                </div>

                <?php if ($error): ?>
                    <div class="error-message">
                        <strong>⚠️ Error:</strong> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="login.php" id="loginForm">
                    <div class="form-group">
                        <label for="username">Email Address</label>
                        <div class="input-wrapper">
                            <input type="email" id="username" name="username" placeholder="Enter your email address" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                    </div>

                    <button type="submit" class="login-btn" id="loginBtn">
                        Sign In
                    </button>
                </form>

                <div class="form-links">
                    <a href="forgot_password.php">🔐 Forgot Password?</a>
                    <span class="divider">|</span>
                    <a href="register_student.php">📝 Create Account</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add dynamic interactions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const inputs = form.querySelectorAll('input');

            // Add loading state on form submission
            form.addEventListener('submit', function() {
                loginBtn.classList.add('loading');
                loginBtn.innerHTML = '';
            });

            // Enhanced input focus animations
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.parentNode.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentNode.parentNode.classList.remove('focused');
                    }
                });

                // Auto-focus on page load
                if (input.type === 'email') {
                    setTimeout(() => input.focus(), 500);
                }
            });

            // Add subtle parallax effect to background
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const background = document.querySelector('.login-wrapper::before');
                if (background) {
                    background.style.transform = `translateY(${scrolled * 0.5}px)`;
                }
            });

            // Add enter key navigation between fields
            inputs.forEach((input, index) => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && index < inputs.length - 1) {
                        e.preventDefault();
                        inputs[index + 1].focus();
                    }
                });
            });
        });
    </script>
</body>
</html>