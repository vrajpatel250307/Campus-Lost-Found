<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Set user_id for navbar functionality if not already set
if (!isset($_SESSION['user_id']) && isset($_SESSION['enrollment'])) {
    $_SESSION['user_id'] = $_SESSION['enrollment'];
}

// User details are already in session, no need to fetch from database again
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

// Get the user's enrollment from session since that's unique to each student
$user_enrollment = $_SESSION['enrollment'];

// Fetch user's lost items using prepared statement
$lost_items_sql = "SELECT * FROM lost_items WHERE enrollment_number = ?";
$stmt = $conn->prepare($lost_items_sql);
$stmt->bind_param("s", $user_enrollment);
$stmt->execute();
$lost_items_result = $stmt->get_result();

// Fetch user's found items using prepared statement
$found_items_sql = "SELECT * FROM found_items WHERE enrollment_number = ?";
$stmt = $conn->prepare($found_items_sql);
$stmt->bind_param("s", $user_enrollment);
$stmt->execute();
$found_items_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Campus Lost and Found</title>
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
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .items-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        .items-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .items-list {
            margin-top: 15px;
        }
        .item-entry {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .item-entry:last-child {
            border-bottom: none;
        }
        .action-buttons {
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #111;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #333;
            transform: translateY(-2px);
        }
        .logout-btn {
            background: #dc3545;
        }
        .logout-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container-fluid">
        <?php include 'includes/navbar.php'; ?>
    </div>

    <div class="dashboard-container">
        <div class="welcome-section">
            <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
            <div class="user-details">
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Student Email:</strong> <?php echo htmlspecialchars($user['student_email']); ?></p>
                <p><strong>Mobile:</strong> <?php echo htmlspecialchars($user['mobile']); ?></p>
                <p><strong>Enrollment:</strong> <?php echo htmlspecialchars($user['enrollment']); ?></p>
                <p><strong>Department:</strong> <?php echo htmlspecialchars($user['department']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Lost Items</h3>
                <p class="stat-number"><?php echo mysqli_num_rows($lost_items_result); ?></p>
            </div>
            <div class="stat-card">
                <h3>Found Items</h3>
                <p class="stat-number"><?php echo mysqli_num_rows($found_items_result); ?></p>
            </div>
        </div>

        <div class="items-section">
            <div class="items-card">
                <h3>Your Lost Items</h3>
                <div class="items-list">
                    <?php
                    if (mysqli_num_rows($lost_items_result) > 0) {
                        while ($item = mysqli_fetch_assoc($lost_items_result)) {
                            echo "<div class='item-entry'>";
                            echo "<h4>" . htmlspecialchars($item['item_name']) . "</h4>";
                            echo "<p>Status: " . htmlspecialchars($item['status']) . "</p>";
                            echo "<p>Date: " . htmlspecialchars($item['lost_date']) . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No lost items reported yet.</p>";
                    }
                    ?>
                </div>
            </div>

            <div class="items-card">
                <h3>Your Found Items</h3>
                <div class="items-list">
                    <?php
                    if (mysqli_num_rows($found_items_result) > 0) {
                        while ($item = mysqli_fetch_assoc($found_items_result)) {
                            echo "<div class='item-entry'>";
                            echo "<h4>" . htmlspecialchars($item['item_name']) . "</h4>";
                            echo "<p>Status: " . htmlspecialchars($item['status']) . "</p>";
                            echo "<p>Date: " . htmlspecialchars($item['found_date']) . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No found items reported yet.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="report_lost_item.php" class="btn">Report Lost Item</a>
            <a href="report_found_item.php" class="btn">Report Found Item</a>
            <a href="view_lost_items.php" class="btn">Browse Lost Items</a>
            <a href="view_found_items.php" class="btn">Browse Found Items</a>
        </div>
    </div>
</body>
</html>
