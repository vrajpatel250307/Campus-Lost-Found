<?php
// Admin Navbar Include
?>

<div class="admin-navbar-header">
    <img src="../images/Guni_Logo.png" alt="Ganpat University Logo" class="admin-logo">
    <span class="admin-site-title">Campus Lost and Found - Admin</span>
</div>
<nav class="navbar admin-navbar">
    <ul>
       <li><a href="index.php">Home</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="lost-items.php">Lost Items</a></li>
                    <li><a href="found-items.php">Found Items</a></li>
                    <li><a href="reports.php">Reports</a></li>
                    <li><a href="settings.php">Settings</a></li>
                    <li><a href="admins.php">Admins</a></li>
                    <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>
<style>
.admin-navbar-header {
    display: flex;
    align-items: center;
    background: #222;
    padding: 0 24px;
    height: 60px;
    border-bottom: 2px solid #ffffffff;
}
.admin-logo {
    height: 40px;
    margin-right: 16px;
}
.admin-site-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #fff;
    letter-spacing: 1px;
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
		.navbar a:hover {
			color: #fff;
			text-shadow: 0 0 10px rgba(255,255,255,0.8);
			transform: translateY(-2px);
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
</style>
