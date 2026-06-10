<?php
require_once '../dbconnect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Unique key to identify user (adjust if you use something else)
    $enrollment_key = $_POST['enrollment_key'];

    $name           = $_POST['name'];
    $email          = $_POST['email'];
    $mobile         = $_POST['mobile'];
    $enrollment     = $_POST['enrollment'];
    $student_email  = $_POST['student_email'];
    $department     = $_POST['department'];
    $address        = $_POST['address'];
    $college_id_card = $_POST['college_id_card']; // or handle upload
    $password       = $_POST['password'];         // ideally already hashed
    $created_at     = $_POST['created_at'];

    $sql = "UPDATE `stu_register` SET
                `name` = ?,
                `email` = ?,
                `mobile` = ?,
                `enrollment` = ?,
                `student_email` = ?,
                `department` = ?,
                `address` = ?,
                `college_id_card` = ?,
                `password` = ?,
                `created_at` = ?
            WHERE `enrollment` = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssss",
        $name,
        $email,
        $mobile,
        $enrollment,
        $student_email,
        $department,
        $address,
        $college_id_card,
        $password,
        $created_at,
        $enrollment_key
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: users.php?msg=updated");
        exit;
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}
?>