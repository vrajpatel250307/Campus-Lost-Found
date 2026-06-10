<?php
session_start();
?>
<?php
require_once 'dbconnect.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $enrollment = trim($_POST['enrollment']);
    $student_email = trim($_POST['student_email']);
    $department = trim($_POST['department']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    }
    // Validate mobile number (10 digits)
    else if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $error = "Invalid mobile number format";
    }
    // Validate password length
    else if (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    }
    // Validate file upload
    else if (!isset($_FILES['college_id_card']) || $_FILES['college_id_card']['error'] != UPLOAD_ERR_OK) {
        $error = "Please upload your college ID card";
    }
    else {
        // Check if email or student email already exists
        $check_query = "SELECT * FROM stu_register WHERE email = '$email' OR student_email = '$student_email' OR enrollment = '$enrollment'";
        $result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($result) > 0) {
            $error = "Email, Student Email, or Enrollment number already registered";
        } else {
            // Handle file upload
            $target_dir = "<uploads>idcards/";  // changed from "uploads/idcards/"
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $file_name = uniqid() . "_" . basename($_FILES["college_id_card"]["name"]);
            $target_file = $target_dir . $file_name;
            if (move_uploaded_file($_FILES["college_id_card"]["tmp_name"], $target_file)) {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new student
                $sql = "INSERT INTO `stu_register`(`name`, `email`, `mobile`, `enrollment`, `student_email`, `department`, `address`, `college_id_card`, `password`) 
                        VALUES ('$name', '$email', '$mobile', '$enrollment', '$student_email', '$department', '$address', '$file_name', '$hashed_password')";
                
                if (mysqli_query($conn, $sql)) {
                    $success = "Registration successful! Redirecting to login page...";
                    header("refresh:2;url=login.php");
                } else {
                    $error = "Error: " . mysqli_error($conn);
                }
            } else {
                $error = "Failed to upload ID card.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Campus Lost and Found</title>
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

        .register-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .register-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23111" stop-opacity="0.1"/><stop offset="100%" stop-color="%23111" stop-opacity="0"/></radialGradient></defs><circle cx="150" cy="150" r="80" fill="url(%23a)"/><circle cx="850" cy="250" r="120" fill="url(%23a)"/><circle cx="300" cy="750" r="100" fill="url(%23a)"/><circle cx="700" cy="600" r="90" fill="url(%23a)"/></svg>') no-repeat center;
            background-size: cover;
            opacity: 0.3;
            z-index: 0;
        }

        .content-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            position: relative;
            z-index: 1;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 0 80px rgba(17, 17, 17, 0.05);
            max-width: 550px;
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

        .register-card::before {
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

        .register-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #111 0%, #444 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .register-subtitle {
            font-size: 1rem;
            color: #666;
            margin-bottom: 30px;
        }

        .success-message {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            animation: pulse 0.5s ease-in-out;
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

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            position: relative;
        }

        .form-group.full-width {
            grid-column: span 2;
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

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 16px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
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

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            background: rgba(17, 17, 17, 0.05);
            border: 2px dashed #111;
            border-radius: 16px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-input-wrapper:hover {
            background: rgba(17, 17, 17, 0.1);
            border-color: #333;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: -9999px;
            opacity: 0;
        }

        .file-input-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .file-icon {
            font-size: 2.5rem;
            color: #111;
        }

        .file-text {
            font-size: 1rem;
            color: #666;
            font-weight: 500;
        }

        .file-subtext {
            font-size: 0.8rem;
            color: #999;
        }

        .register-btn {
            width: 100%;
            padding: 18px 24px;
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
            margin-top: 10px;
        }

        .register-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }

        .register-btn:hover::before {
            left: 100%;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(17, 17, 17, 0.3);
        }

        .register-btn:active {
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
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .form-links a:hover {
            background: rgba(17, 17, 17, 0.1);
            transform: translateY(-1px);
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
            animation: float 8s infinite ease-in-out;
        }

        .particle:nth-child(1) { left: 15%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 25%; animation-delay: 1.5s; }
        .particle:nth-child(3) { left: 35%; animation-delay: 3s; }
        .particle:nth-child(4) { left: 45%; animation-delay: 4.5s; }
        .particle:nth-child(5) { left: 55%; animation-delay: 6s; }
        .particle:nth-child(6) { left: 65%; animation-delay: 7.5s; }

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
            .register-card {
                margin: 20px;
                padding: 40px 30px;
                border-radius: 20px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .form-group.full-width {
                grid-column: span 1;
            }
            
            .register-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 480px) {
            .content-container {
                padding: 20px 10px;
            }
            
            .register-card {
                padding: 35px 25px;
            }
            
            .register-title {
                font-size: 1.6rem;
            }
        }

        /* Loading animation */
        .register-btn.loading {
            pointer-events: none;
        }

        .register-btn.loading::after {
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

        .progress-steps {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .step {
            width: 30px;
            height: 4px;
            background: #e1e5e9;
            margin: 0 5px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .step.active {
            background: linear-gradient(90deg, #111, #333);
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-fluid">
        <?php include 'includes/navbar.php'; ?>
    </div>

    <div class="register-wrapper">
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        
        <div class="content-container">
            <div class="register-card">
                <div class="logo-section">
                    <div class="logo-container">
                        <img src="images/Guni_Logo.png" alt="Ganpat University Logo">
                    </div>
                    <h1 class="register-title">Join Our Community</h1>
                    <p class="register-subtitle">Create your Campus Lost & Found account</p>
                </div>

                <div class="progress-steps">
                    <div class="step active"></div>
                    <div class="step"></div>
                    <div class="step"></div>
                </div>

                <?php if ($success): ?>
                    <div class="success-message">
                        <strong>✅ Success:</strong> <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="error-message">
                        <strong>⚠️ Error:</strong> <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="register_student.php" enctype="multipart/form-data" id="registerForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <div class="input-wrapper">
                                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="enrollment">Enrollment Number</label>
                            <div class="input-wrapper">
                                <input type="text" id="enrollment" name="enrollment" placeholder="Your enrollment number" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Personal Email</label>
                            <div class="input-wrapper">
                                <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="student_email">University Email</label>
                            <div class="input-wrapper">
                                <input type="email" id="student_email" name="student_email" placeholder="your@ganpatuniversity.ac.in" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <div class="input-wrapper">
                                <input type="tel" id="mobile" name="mobile" placeholder="10-digit mobile number" pattern="[0-9]{10}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department">Department</label>
                            <div class="input-wrapper">
                                <select id="department" name="department" required>
                                    <option value="">Select Department</option>
                                    <option value="Computer Science">Computer Science</option>
                                    <option value="Information Technology">Information Technology</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Mechanical">Mechanical</option>
                                    <option value="Civil">Civil</option>
                                    <option value="Management">Management</option>
                                    <option value="Pharmacy">Pharmacy</option>
                                    <option value="Science">Science</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label for="address">Address</label>
                            <div class="input-wrapper">
                                <textarea id="address" name="address" rows="3" placeholder="Enter your complete address" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrapper">
                                <input type="password" id="password" name="password" placeholder="At least 6 characters" minlength="6" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>College ID Card</label>
                            <div class="file-input-wrapper" onclick="document.getElementById('college_id_card').click()">
                                <input type="file" id="college_id_card" name="college_id_card" accept="image/*" required>
                                <div class="file-input-content">
                                    <div class="file-icon">📄</div>
                                    <div class="file-text">Upload ID Card</div>
                                    <div class="file-subtext">Click to select image file</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="register-btn" id="registerBtn">
                        Create Account
                    </button>
                </form>

                <div class="form-links">
                    <a href="login.php">🔑 Already have an account? Sign In</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add dynamic interactions
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const registerBtn = document.getElementById('registerBtn');
            const inputs = form.querySelectorAll('input, select, textarea');
            const steps = document.querySelectorAll('.step');
            const fileInput = document.getElementById('college_id_card');

            // Add loading state on form submission
            form.addEventListener('submit', function() {
                registerBtn.classList.add('loading');
                registerBtn.innerHTML = '';
            });

            // Progress steps animation based on form completion
            function updateProgress() {
                const totalFields = inputs.length;
                const completedFields = Array.from(inputs).filter(input => input.value.trim() !== '').length;
                const progress = Math.floor((completedFields / totalFields) * 3);
                
                steps.forEach((step, index) => {
                    if (index < progress) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });
            }

            // Enhanced input focus animations
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.parentNode.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentNode.parentNode.classList.remove('focused');
                    }
                    updateProgress();
                });

                input.addEventListener('input', updateProgress);

                // Auto-focus on first field
                if (input.id === 'name') {
                    setTimeout(() => input.focus(), 500);
                }
            });

            // File input enhancement
            fileInput.addEventListener('change', function() {
                const wrapper = this.parentNode;
                const content = wrapper.querySelector('.file-input-content');
                
                if (this.files.length > 0) {
                    const fileName = this.files[0].name;
                    content.innerHTML = `
                        <div class="file-icon">✅</div>
                        <div class="file-text">File Selected</div>
                        <div class="file-subtext">${fileName}</div>
                    `;
                    wrapper.style.background = 'rgba(40, 167, 69, 0.1)';
                    wrapper.style.borderColor = '#28a745';
                }
                updateProgress();
            });

            // Form validation enhancement
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.required && !this.value.trim()) {
                        this.style.borderColor = '#dc3545';
                        this.style.background = 'rgba(220, 53, 69, 0.05)';
                    } else if (this.checkValidity()) {
                        this.style.borderColor = '#28a745';
                        this.style.background = 'rgba(40, 167, 69, 0.05)';
                    }
                });

                input.addEventListener('focus', function() {
                    this.style.borderColor = '#111';
                    this.style.background = 'rgba(255, 255, 255, 0.8)';
                });
            });

            // Initial progress update
            updateProgress();
        });
    </script>
</body>
</html>
