<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user details from session
    $reporter_name = $_SESSION['name'];
    $mobile_number = $_SESSION['mobile'];
    $enrollment_number = $_SESSION['enrollment'];
    $department = $_SESSION['department'];

    // Get form data
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_type = mysqli_real_escape_string($conn, $_POST['item_type']);
    $lost_date = mysqli_real_escape_string($conn, $_POST['lost_date']);
    $lost_place = mysqli_real_escape_string($conn, $_POST['lost_place']);
    $item_description = mysqli_real_escape_string($conn, $_POST['item_description']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $class = mysqli_real_escape_string($conn, $_POST['class']);

    // Handle file upload
    $photo_path = '';
    if (isset($_FILES['item_photo']) && $_FILES['item_photo']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['item_photo']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            // Create unique filename
            $newname = uniqid() . '.' . $filetype;
            $upload_path = 'uploads/lost_items/' . $newname;
            
            // Create directory if it doesn't exist
            if (!file_exists('uploads/lost_items/')) {
                mkdir('uploads/lost_items/', 0777, true);
            }
            
            if (move_uploaded_file($_FILES['item_photo']['tmp_name'], $upload_path)) {
                $photo_path = $upload_path;
            }
        }
    }

    // Insert into database
    $sql = "INSERT INTO lost_items (
        item_name, 
        item_type, 
        lost_date, 
        lost_place, 
        item_description, 
        item_photo, 
        reporter_name, 
        mobile_number, 
        enrollment_number, 
        department, 
        semester, 
        class
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", 
        $item_name,
        $item_type,
        $lost_date,
        $lost_place,
        $item_description,
        $photo_path,
        $reporter_name,
        $mobile_number,
        $enrollment_number,
        $department,
        $semester,
        $class
    );

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Lost item report submitted successfully!";
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error submitting report. Please try again.";
        header("Location: report_lost_item.php");
        exit();
    }
} else {
    header("Location: report_lost_item.php");
    exit();
}
?>
