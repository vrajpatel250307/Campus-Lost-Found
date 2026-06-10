<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    
    if ($action == 'update_profile') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile']);
        $student_email = trim($_POST['student_email']);
        $department = trim($_POST['department']);
        $address = trim($_POST['address']);
        $current_enrollment = $_SESSION['enrollment'];
        
        // Validate inputs
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = "Invalid email format";
        } else if (!preg_match("/^[0-9]{10}$/", $mobile)) {
            $response['message'] = "Invalid mobile number format";
        } else {
            // Check if new email already exists (excluding current user)
            $check_query = "SELECT * FROM stu_register WHERE (email = ? OR student_email = ?) AND enrollment != ?";
            $stmt = $conn->prepare($check_query);
            $stmt->bind_param("sss", $email, $student_email, $current_enrollment);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $response['message'] = "Email or Student Email already exists";
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
                        $response['message'] = "Failed to upload new ID card.";
                    }
                }
                
                if (empty($response['message'])) {
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
                        
                        $response['success'] = true;
                        $response['message'] = "Profile updated successfully!";
                    } else {
                        $response['message'] = "Error updating profile: " . $stmt->error;
                    }
                }
            }
        }
    }
    
    else if ($action == 'change_password') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        if (strlen($new_password) < 6) {
            $response['message'] = "New password must be at least 6 characters";
        } else if ($new_password !== $confirm_password) {
            $response['message'] = "New passwords don't match";
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
                    $response['success'] = true;
                    $response['message'] = "Password changed successfully!";
                } else {
                    $response['message'] = "Error changing password: " . $stmt->error;
                }
            } else {
                $response['message'] = "Current password is incorrect";
            }
        }
    }
    
    else if ($action == 'get_profile_data') {
        // Return current user profile data
        $response['success'] = true;
        $response['data'] = array(
            'name' => $_SESSION['name'],
            'email' => $_SESSION['email'],
            'mobile' => $_SESSION['mobile'],
            'enrollment' => $_SESSION['enrollment'],
            'student_email' => $_SESSION['student_email'],
            'department' => $_SESSION['department'],
            'address' => $_SESSION['address'],
            'college_id_card' => $_SESSION['college_id_card']
        );
    }
}

// Return JSON response for AJAX requests
if (isset($_POST['ajax']) && $_POST['ajax'] == '1') {
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Redirect back to profile page with status for regular form submissions
if ($response['success']) {
    header("Location: profile.php?success=" . urlencode($response['message']));
} else {
    header("Location: profile.php?error=" . urlencode($response['message']));
}
exit();
?>