<?php
require_once '../dbconnect.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $check_sql = "SELECT id FROM admin WHERE email = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'Email already registered.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = "INSERT INTO admin (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param('sss', $name, $email, $hashed_password);
            if ($stmt->execute()) {
                $success = 'Admin registered successfully! You can now login.';
            } else {
                $error = 'Registration failed.';
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
    <title>Admin Register - Campus Lost and Found</title>
    <link rel="stylesheet" href="../includes/navbar.css">
    <style>
        body { background: #f5f5f5; font-family: 'Poppins', Arial, sans-serif; margin: 0; }
        .register-container { max-width: 400px; margin: 60px auto; background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(0,0,0,0.10); padding: 40px 32px; }
        .logo { display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
        .logo img { height: 60px; margin-right: 16px; }
        .site-title { font-size: 1.6rem; font-weight: 600; color: #222; letter-spacing: 1px; }
        h2 { text-align: center; margin-bottom: 32px; color: #1976d2; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1rem; }
        button { width: 100%; padding: 12px; background: #1976d2; color: #fff; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        button:hover { background: #1565c0; }
        .error { color: #d32f2f; text-align: center; margin-bottom: 16px; }
        .success { color: #388e3c; text-align: center; margin-bottom: 16px; }
    </style>
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="register-container">
        <div class="logo">
            <img src="../images/Guni_Logo.png" alt="Ganpat University Logo">
            <span class="site-title">Campus Lost and Found</span>
        </div>
        <h2>Admin Register</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
