<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Campus Lost and Found</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            color: #111;
            min-height: 100vh;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('../images/campus.jpg') no-repeat center center fixed;
            background-size: cover;
            opacity: 0.15;
            z-index: -2;
        }
        .page-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(255,255,255,0.95),rgba(255,255,255,0.98));
            z-index: -1;
        }
        .content-wrapper {
            position: relative;
            min-height: 100vh;
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
            border-radius: 8px;
        }
        .navbar a:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(255,255,255,0.8);
            transform: translateY(-2px);
            background: #222;
        }
        .navbar a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #fff;
            transition: width 0.3s ease;
        }
        .navbar a:hover::after {
            width: 100%;
        }
        
        /* Dropdown menu styles */
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
            border-radius: 0;
        }
        
        .submenu a:last-child {
            border-bottom: none;
            border-radius: 0 0 8px 8px;
        }
        
        .submenu a:hover {
            background: rgba(255,255,255,0.1);
            transform: none;
        }
        
        .submenu a::after {
            display: none;
        }
        
        .header-section {
            background: #111;
            color: #fff;
            padding: 24px 0 16px 0;
        }
        .header-flex {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0;
        }
        .logo-container {
            margin-right: 18px;
            margin-left: 0;
            padding-left: 0;
            display: flex;
            align-items: center;
        }
        .logo-container img {
            width: 60px;
            height: 40px;
            object-fit: contain;
            object-position: center;
            filter: none;
            opacity: 1;
            box-shadow: 0 4px 16px rgba(0,0,0,0.10);
            border-radius: 8px;
            background: #fff;
            padding: 4px;
            display: block;
        }
        .site-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
            color: #fff;
        }
        .container {
            max-width: 900px;
            margin: 48px auto;
            background: rgba(255,255,255,0.95);
            padding: 40px 32px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            text-align: center;
        }
        h2 {
            font-size: 2rem;
            margin-bottom: 24px;
            color: #2c3e50;
        }
        .admin-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 32px;
            margin-top: 32px;
        }
        .admin-btn {
            background: linear-gradient(135deg, #111 0%, #888 100%);
            color: #fff;
            border: none;
            border-radius: 16px;
            padding: 36px 0;
            font-size: 1.15rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .admin-btn i {
            font-size: 2.2rem;
            margin-bottom: 8px;
        }
        .admin-btn:hover {
            background: linear-gradient(135deg, #888 0%, #111 100%);
            box-shadow: 0 6px 24px rgba(0,0,0,0.13);
            transform: translateY(-2px) scale(1.03);
        }
        @media (max-width: 700px) {
            .container {
                padding: 18px 8px;
            }
            .admin-buttons {
                grid-template-columns: 1fr;
            }
        }
        .copyright {
            text-align: center;
            padding: 20px 0;
            color: #666;
            font-size: 0.9rem;
            margin-top: 40px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="page-overlay"></div>
    <div class="content-wrapper">
        <header class="header-section">
            <div class="header-flex">
                <div class="logo-container" style="margin-left:0;">
                    <img src="../images/Guni_Logo.png" alt="Campus Lost and Found Logo" width="60" height="40">
                </div>
                <h1 class="site-title" style="margin-left:24px;">Admin Panel</h1>
            </div>
        </header>
        <div class="container-fluid">
            <nav class="navbar">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li>
                        <a href="#">Manage</a>
                        <div class="submenu">
                            <a href="users.php">Users</a>
                            <a href="admins.php">Admins</a>
                        </div>
                    </li>
                    <li>
                        <a href="#">Items</a>
                        <div class="submenu">
                            <a href="lost-items.php">Lost Items</a>
                            <a href="found-items.php">Found Items</a>
                        </div>
                    </li>
                    <li><a href="reports.php">Reports</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="logout.php" style="color: #ff6b6b;">Logout</a></li>
                </ul>
            </nav>
        </div>
        <div class="container">
            <h2>Admin Functions</h2>
            <div class="admin-buttons">
                <a href="dashboard.php" class="admin-btn"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="users.php" class="admin-btn"><i class="fas fa-users"></i> Manage Users</a>
                <a href="lost-items.php" class="admin-btn"><i class="fas fa-search"></i> Lost Items</a>
                <a href="found-items.php" class="admin-btn"><i class="fas fa-box-open"></i> Found Items</a>
                <a href="reports.php" class="admin-btn"><i class="fas fa-chart-bar"></i> Reports</a>
                <a href="settings.php" class="admin-btn"><i class="fas fa-cog"></i> Settings</a>
                <a href="admins.php" class="admin-btn"><i class="fas fa-user-shield"></i> Manage Admins</a>
                <a href="logout.php" class="admin-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
        <div class="copyright">
            © 2025 Campus Lost and Found. All Rights Reserved.
        </div>
    </div>
</body>
</html>