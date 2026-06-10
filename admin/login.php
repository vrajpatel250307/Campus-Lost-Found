<?php
session_start();
require_once '../dbconnect.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $sql = "SELECT id, name, email, password FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['name'];
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid password.';
        }
    } else {
        $error = 'Admin not found.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Campus Lost and Found</title>
    <style>
        body {
            background: #f5f5f5 url('../images/campus.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
        }
        .login-container {
            max-width: 400px;
            margin: 60px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.10);
            padding: 40px 32px;
            position: relative;
            z-index: 1;
        }
        .logo { display: flex; align-items: center; justify-content: center; margin-bottom: 24px; }
        .logo img { height: 60px; margin-right: 16px; }
        .site-title { font-size: 1.6rem; font-weight: 600; color: #222; letter-spacing: 1px; }
        h2 { text-align: center; margin-bottom: 32px; color: #1976d2; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
        input[type="email"], input[type="password"] { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc; font-size: 1rem; }
        button { width: 100%; padding: 12px; background: #1976d2; color: #fff; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: background 0.2s; margin-bottom: 16px; }
        button:hover { background: #1565c0; }
        .back-btn { 
            background: white; 
            color: #495057;
            border: 2px solid #e9ecef;
            text-decoration: none; 
            display: inline-block; 
            text-align: center;
            box-sizing: border-box;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .back-btn:hover { 
            background: #f8f9fa;
            border-color: #6c757d;
            color: #212529;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .error { color: #d32f2f; text-align: center; margin-bottom: 16px; }
        .button-group { margin-top: 16px; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="../images/Guni_Logo.png" alt="Ganpat University Logo">
            <span class="site-title">Campus Lost and Found</span>
        </div>
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="button-group">
            <a href="../index.php" class="back-btn">← Back to Main Website</a>
        </div>
    </div>
</body>
</html>
