<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$success = '';
$error = '';
$edit_mode = false;

// Handle form submission for profile update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $student_email = trim($_POST['student_email']);
    $department = trim($_POST['department']);
    $address = trim($_POST['address']);
    $current_enrollment = $_SESSION['enrollment'];
    
    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else if (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $error = "Invalid mobile number format";
    } else {
        // Check if new email already exists (excluding current user)
        $check_query = "SELECT * FROM stu_register WHERE (email = ? OR student_email = ?) AND enrollment != ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("sss", $email, $student_email, $current_enrollment);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Email or Student Email already exists";
        } else {
            // Handle ID card upload if new file is provided
            $id_card_filename = $_SESSION['college_id_card']; // Keep current filename by default
            
            if (isset($_FILES['college_id_card']) && $_FILES['college_id_card']['error'] == UPLOAD_ERR_OK) {
                $target_dir = "uploads/idcards/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_name = uniqid() . "_" . basename($_FILES["college_id_card"]["name"]);
                $target_file = $target_dir . $file_name;
                
                if (move_uploaded_file($_FILES["college_id_card"]["tmp_name"], $target_file)) {
                    // Delete old file if it exists
                    if (file_exists($target_dir . $id_card_filename)) {
                        unlink($target_dir . $id_card_filename);
                    }
                    $id_card_filename = $file_name;
                } else {
                    $error = "Failed to upload new ID card.";
                }
            }
            
            if (empty($error)) {
                // Update user profile
                $update_query = "UPDATE stu_register SET name = ?, email = ?, mobile = ?, student_email = ?, department = ?, address = ?, college_id_card = ? WHERE enrollment = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("ssssssss", $name, $email, $mobile, $student_email, $department, $address, $id_card_filename, $current_enrollment);
                
                if ($stmt->execute()) {
                    // Update session variables
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['mobile'] = $mobile;
                    $_SESSION['student_email'] = $student_email;
                    $_SESSION['department'] = $department;
                    $_SESSION['address'] = $address;
                    $_SESSION['college_id_card'] = $id_card_filename;
                    
                    $success = "Profile updated successfully!";
                } else {
                    $error = "Error updating profile: " . $stmt->error;
                }
            }
        }
    }
}

// Handle password change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (strlen($new_password) < 6) {
        $error = "New password must be at least 6 characters";
    } else if ($new_password !== $confirm_password) {
        $error = "New passwords don't match";
    } else {
        // Verify current password
        $verify_query = "SELECT password FROM stu_register WHERE enrollment = ?";
        $stmt = $conn->prepare($verify_query);
        $stmt->bind_param("s", $_SESSION['enrollment']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_data = $result->fetch_assoc();
        
        if (password_verify($current_password, $user_data['password'])) {
            // Update password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE stu_register SET password = ? WHERE enrollment = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ss", $hashed_new_password, $_SESSION['enrollment']);
            
            if ($stmt->execute()) {
                $success = "Password changed successfully!";
            } else {
                $error = "Error changing password: " . $stmt->error;
            }
        } else {
            $error = "Current password is incorrect";
        }
    }
}

// Check if edit mode is requested
if (isset($_GET['edit']) && $_GET['edit'] == '1') {
    $edit_mode = true;
}

$user = [
    'name' => $_SESSION['name'],
    'email' => $_SESSION['email'],
    'mobile' => $_SESSION['mobile'],
    'enrollment' => $_SESSION['enrollment'],
    'student_email' => $_SESSION['student_email'],
    'department' => $_SESSION['department'],
    'address' => $_SESSION['address'],
    'college_id_card' => $_SESSION['college_id_card']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Campus Lost and Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
            color: #333;
        }
        .navbar {
            background: #111;
            border-bottom: 1px solid #eee;
        }
        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .navbar li {
            flex: 1;
            position: relative;
        }
        .navbar a {
            display: block;
            color: #fff;
            text-align: center;
            padding: 12px 24px;
            text-decoration: none;
            font-weight: 500;
            letter-spacing: 0.5px;
            margin: 8px 6px;
            transition: all 0.3s ease;
            position: relative;
        }
        .navbar a:hover {
            background: rgba(255,255,255,0.1);
            border-radius: 5px;
        }
        .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 200px;
            background: #111;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .navbar li:hover .submenu {
            display: block;
        }
        .submenu a {
            padding: 12px 20px;
            margin: 0;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .submenu a:last-child {
            border-bottom: none;
            border-radius: 0 0 8px 8px;
        }
        .submenu a:hover {
            background: rgba(255,255,255,0.1);
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .profile-header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #111;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: bold;
            margin: 0 auto 20px;
        }
        .profile-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #111;
        }
        .btn {
            background: #111;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #333;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .profile-field {
            margin-bottom: 15px;
        }
        .profile-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }
        .profile-value {
            color: #111;
            font-size: 16px;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        .form-input:focus {
            outline: none;
            border-color: #111;
        }
        .alert {
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
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
        .id-card-preview {
            max-width: 200px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .tab.active {
            border-bottom-color: #111;
            background: #f8f9fa;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-fluid">
        <?php include 'includes/navbar_user.php'; ?>
    </div>
    
    <div class="container">
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="profile-header">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
            </div>
            <h1><?php echo htmlspecialchars($user['name']); ?></h1>
            <p style="color: #666; margin: 0;"><?php echo htmlspecialchars($user['department']); ?></p>
            <p style="color: #666; margin: 5px 0 0 0;">Enrollment: <?php echo htmlspecialchars($user['enrollment']); ?></p>
        </div>
        
        <div class="tabs">
            <div class="tab active" onclick="showTab('profile-info')">Profile Information</div>
            <div class="tab" onclick="showTab('security')">Security Settings</div>
        </div>
        
        <div id="profile-info" class="tab-content active">
            <div class="profile-section">
                <div class="section-header">
                    <h2 class="section-title">Personal Information</h2>
                    <?php if (!$edit_mode): ?>
                        <a href="profile.php?edit=1" class="btn">Edit Profile</a>
                    <?php else: ?>
                        <a href="profile.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </div>
                
                <?php if (!$edit_mode): ?>
                    <!-- View Mode -->
                    <div class="profile-grid">
                        <div class="profile-field">
                            <span class="profile-label">Full Name</span>
                            <div class="profile-value"><?php echo htmlspecialchars($user['name']); ?></div>
                        </div>
                        <div class="profile-field">
                            <span class="profile-label">Enrollment Number</span>
                            <div class="profile-value"><?php echo htmlspecialchars($user['enrollment']); ?></div>
                        </div>
                        <div class="profile-field">
                            <span class="profile-label">Personal Email</span>
                            <div class="profile-value"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>
                        <div class="profile-field">
                            <span class="profile-label">Student Email</span>
                            <div class="profile-value"><?php echo htmlspecialchars($user['student_email']); ?></div>
                        </div>
                        <div class="profile-field">
                            <span class="profile-label">Mobile Number</span>
                            <div class="profile-value"><?php echo htmlspecialchars($user['mobile']); ?></div>
                        </div>
                        <div class="profile-field">
                            <span class="profile-label">Department</span>
                            <div class="profile-value"><?php echo htmlspecialchars($user['department']); ?></div>
                        </div>
                    </div>
                    <div class="profile-field">
                        <span class="profile-label">Address</span>
                        <div class="profile-value"><?php echo htmlspecialchars($user['address']); ?></div>
                    </div>
                    <div class="profile-field">
                        <span class="profile-label">College ID Card</span>
                        <div class="profile-value">
                            <?php if ($user['college_id_card']): ?>
                                <img src="uploads/idcards/<?php echo htmlspecialchars($user['college_id_card']); ?>" 
                                     alt="College ID Card" class="id-card-preview">
                            <?php else: ?>
                                No ID card uploaded
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Edit Mode -->
                    <form method="POST" enctype="multipart/form-data">
                        <div class="profile-grid">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-input" 
                                       value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Enrollment Number</label>
                                <input type="text" class="form-input" 
                                       value="<?php echo htmlspecialchars($user['enrollment']); ?>" disabled>
                                <small style="color: #666;">Enrollment number cannot be changed</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Personal Email</label>
                                <input type="email" name="email" class="form-input" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Student Email</label>
                                <input type="email" name="student_email" class="form-input" 
                                       value="<?php echo htmlspecialchars($user['student_email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Mobile Number</label>
                                <input type="tel" name="mobile" class="form-input" 
                                       value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select name="department" class="form-input" required>
                                    <option value="Institute of Computer Technology" <?php echo ($user['department'] == 'Institute of Computer Technology') ? 'selected' : ''; ?>>Institute of Computer Technology</option>
                                    <option value="Institute of Technology" <?php echo ($user['department'] == 'Institute of Technology') ? 'selected' : ''; ?>>Institute of Technology</option>
                                    <option value="Institute of Management" <?php echo ($user['department'] == 'Institute of Management') ? 'selected' : ''; ?>>Institute of Management</option>
                                    <option value="Institute of Science" <?php echo ($user['department'] == 'Institute of Science') ? 'selected' : ''; ?>>Institute of Science</option>
                                    <option value="Institute of Pharmacy" <?php echo ($user['department'] == 'Institute of Pharmacy') ? 'selected' : ''; ?>>Institute of Pharmacy</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-input" rows="3" required><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">College ID Card</label>
                            <input type="file" name="college_id_card" class="form-input" accept="image/*">
                            <small style="color: #666;">Leave empty to keep current ID card</small>
                            <?php if ($user['college_id_card']): ?>
                                <div style="margin-top: 10px;">
                                    <img src="uploads/idcards/<?php echo htmlspecialchars($user['college_id_card']); ?>" 
                                         alt="Current ID Card" class="id-card-preview">
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="update_profile" class="btn">Update Profile</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        
        <div id="security" class="tab-content">
            <div class="profile-section">
                <div class="section-header">
                    <h2 class="section-title">Change Password</h2>
                </div>
                
                <form method="POST">
                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-input" 
                               minlength="6" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-input" 
                               minlength="6" required>
                    </div>
                    <button type="submit" name="change_password" class="btn">Change Password</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked tab
            event.target.classList.add('active');
        }
    </script>
</body>
</html>