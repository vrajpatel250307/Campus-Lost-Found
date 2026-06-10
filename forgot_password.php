<?php
session_start();
require_once 'dbconnect.php';

$message = '';
$error = '';
$step = 1; // 1: Verification, 2: Password Reset
$verified_user = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['verify_user'])) {
        // Step 1: Verify user identity
        $email = trim($_POST['email']);
        $enrollment = trim($_POST['enrollment']);
        $mobile = trim($_POST['mobile']);
        $name = trim($_POST['name']);

        // Check if all details match
        $sql = "SELECT * FROM stu_register WHERE email = ? AND enrollment = ? AND mobile = ? AND name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $email, $enrollment, $mobile, $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $verified_user = $row;
            $step = 2;
            $_SESSION['temp_user_id'] = $row['enrollment'];
            $message = "Identity verified successfully! You can now reset your password.";
        } else {
            $error = "The provided details do not match our records. Please check and try again.";
        }
    } elseif (isset($_POST['reset_password'])) {
        // Step 2: Reset password
        if (isset($_SESSION['temp_user_id'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if (strlen($new_password) < 6) {
                $error = "Password must be at least 6 characters long.";
                $step = 2;
            } elseif ($new_password !== $confirm_password) {
                $error = "Passwords do not match.";
                $step = 2;
            } else {
                // Update password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE stu_register SET password = ? WHERE enrollment = ?";
                $update_stmt = mysqli_prepare($conn, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "ss", $hashed_password, $_SESSION['temp_user_id']);
                
                if (mysqli_stmt_execute($update_stmt)) {
                    unset($_SESSION['temp_user_id']);
                    $message = "Password updated successfully! Redirecting to login page...";
                    header("refresh:3;url=login.php");
                } else {
                    $error = "Failed to update password. Please try again.";
                    $step = 2;
                }
            }
        } else {
            $error = "Session expired. Please start over.";
            $step = 1;
        }
    }
}

// If we have a verified user in session, show step 2
if (isset($_SESSION['temp_user_id']) && $step == 1) {
    $step = 2;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Campus Lost and Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
            color: #111;
            min-height: 100vh;
        }
        .reset-container {
            max-width: 500px;
            width: 90%;
            background: #fff;
            padding: 40px 32px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
            text-align: center;
            margin: 40px auto;
        }
        .reset-container h2 {
            font-size: 1.8rem;
            margin: 20px 0 10px 0;
            color: #222;
            font-weight: 700;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 20px;
        }
        .step {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .step.active {
            background: #111;
            color: white;
        }
        .step.inactive {
            background: #e9ecef;
            color: #666;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .reset-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
            text-align: left;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }
        .reset-form input {
            padding: 14px 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s ease;
        }
        .reset-form input:focus {
            border-color: #111;
            box-shadow: 0 0 0 3px rgba(17, 17, 17, 0.1);
        }
        .reset-form button {
            padding: 14px 20px;
            border-radius: 8px;
            border: none;
            background: #111;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .reset-form button:hover {
            background: #333;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .reset-links {
            margin-top: 25px;
            font-size: 0.95rem;
        }
        .reset-links a {
            color: #111;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .reset-links a:hover {
            color: #333;
            text-decoration: underline;
        }
        .help-text {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }
        .security-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #856404;
        }
        .password-requirements {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }
        .password-requirements h4 {
            margin: 0 0 10px 0;
            font-size: 0.9rem;
            color: #333;
        }
        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
            font-size: 0.85rem;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="reset-container">
        
        <h2>Reset Password</h2>
        
        <div class="step-indicator">
            <div class="step <?php echo $step == 1 ? 'active' : 'inactive'; ?>">1. Verify Identity</div>
            <div class="step <?php echo $step == 2 ? 'active' : 'inactive'; ?>">2. New Password</div>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($step == 1): ?>
            <!-- Step 1: Verify Identity -->
            <p class="subtitle">To reset your password, please verify your identity by providing the following registration details:</p>
            
            <div class="security-note">
                <strong>🔒 Security Check:</strong> We need to verify your identity before allowing password reset. All details must match our records exactly.
            </div>
            
            <form class="reset-form" method="post" action="forgot_password.php">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" placeholder="Enter your full name as registered" required>
                    <div class="help-text">Exactly as it appears in your student registration</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Enrollment Number</label>
                    <input type="text" name="enrollment" placeholder="Enter your enrollment number" required>
                    <div class="help-text">Your unique student enrollment number</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Registered Email</label>
                    <input type="email" name="email" placeholder="Enter your registered email address" required>
                    <div class="help-text">The email address you used during registration</div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Mobile Number</label>
                    <input type="tel" name="mobile" placeholder="Enter your 10-digit mobile number" pattern="[0-9]{10}" required>
                    <div class="help-text">10-digit mobile number linked to your account</div>
                </div>
                
                <button type="submit" name="verify_user">Verify Identity & Continue</button>
            </form>

        <?php else: ?>
            <!-- Step 2: Reset Password -->
            <p class="subtitle">Identity verified successfully! Please enter your new password below:</p>
            
            <form class="reset-form" method="post" action="forgot_password.php">
                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" placeholder="Enter your new password" minlength="6" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" placeholder="Confirm your new password" minlength="6" required>
                </div>
                
                <div class="password-requirements">
                    <h4>Password Requirements:</h4>
                    <ul>
                        <li>At least 6 characters long</li>
                        <li>Use a combination of letters, numbers, and symbols</li>
                        <li>Avoid using common words or personal information</li>
                        <li>Different from your previous password</li>
                    </ul>
                </div>
                
                <button type="submit" name="reset_password">Update Password</button>
            </form>
        <?php endif; ?>

        <div class="reset-links">
            <a href="login.php">← Back to Login</a>
            <?php if ($step == 2): ?>
                <span style="margin: 0 10px;">|</span>
                <a href="forgot_password.php">Start Over</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>