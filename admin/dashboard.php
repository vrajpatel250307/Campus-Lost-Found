<?php
session_start();
require_once '../dbconnect.php';

// Check if admin is logged in
//if (!isset($_SESSION['admin_id'])) {
    //header('Location: login.php');
    //exit();
//}

// Get admin info
$admin_id = 1; // Default admin ID for demo
$admin_query = "SELECT * FROM admin WHERE id = ?";
$stmt = $conn->prepare($admin_query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$admin_result = $stmt->get_result();
$admin = $admin_result->fetch_assoc();

// Get statistics
$stats = [];

// Total users
$users_query = "SELECT COUNT(*) as total FROM stu_register";
$users_result = $conn->query($users_query);
$stats['total_users'] = $users_result->fetch_assoc()['total'];

// Total lost items
$lost_query = "SELECT COUNT(*) as total FROM lost_items";
$lost_result = $conn->query($lost_query);
$stats['total_lost'] = $lost_result->fetch_assoc()['total'];

// Total found items
$found_query = "SELECT COUNT(*) as total FROM found_items";
$found_result = $conn->query($found_query);
$stats['total_found'] = $found_result->fetch_assoc()['total'];

// Pending lost items
$pending_lost_query = "SELECT COUNT(*) as total FROM lost_items WHERE status = 'Pending'";
$pending_lost_result = $conn->query($pending_lost_query);
$stats['pending_lost'] = $pending_lost_result->fetch_assoc()['total'];

// Pending found items
$pending_found_query = "SELECT COUNT(*) as total FROM found_items WHERE status = 'pending'";
$pending_found_result = $conn->query($pending_found_query);
$stats['pending_found'] = $pending_found_result->fetch_assoc()['total'];

// Resolved items
$resolved_lost_query = "SELECT COUNT(*) as total FROM lost_items WHERE status = 'Resolved'";
$resolved_lost_result = $conn->query($resolved_lost_query);
$stats['resolved_lost'] = $resolved_lost_result->fetch_assoc()['total'];

// Recent lost items
$recent_lost_query = "SELECT * FROM lost_items ORDER BY created_at DESC LIMIT 5";
$recent_lost_result = $conn->query($recent_lost_query);

// Recent found items
$recent_found_query = "SELECT * FROM found_items ORDER BY created_at DESC LIMIT 5";
$recent_found_result = $conn->query($recent_found_query);

// Recent registrations
$recent_users_query = "SELECT * FROM stu_register ORDER BY created_at DESC LIMIT 5";
$recent_users_result = $conn->query($recent_users_query);

// Monthly statistics
$monthly_lost_query = "SELECT MONTH(created_at) as month, COUNT(*) as count FROM lost_items WHERE YEAR(created_at) = YEAR(CURDATE()) GROUP BY MONTH(created_at) ORDER BY month";
$monthly_lost_result = $conn->query($monthly_lost_query);
$monthly_lost_data = [];
while ($row = $monthly_lost_result->fetch_assoc()) {
    $monthly_lost_data[] = $row;
}

$monthly_found_query = "SELECT MONTH(created_at) as month, COUNT(*) as count FROM found_items WHERE YEAR(created_at) = YEAR(CURDATE()) GROUP BY MONTH(created_at) ORDER BY month";
$monthly_found_result = $conn->query($monthly_found_query);
$monthly_found_data = [];
while ($row = $monthly_found_result->fetch_assoc()) {
    $monthly_found_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lost and Found</title>
    <link rel="stylesheet" href="../includes/navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; 
            background: #f8f9fa; 
            margin: 0; 
            line-height: 1.6;
        }
        
        .container { 
            max-width: 1400px; 
            margin: 40px auto; 
            background: #fff; 
            border-radius: 20px; 
            box-shadow: 0 4px 25px rgba(0,0,0,0.08); 
            padding: 40px; 
        }

        .header-info {
            background: linear-gradient(135deg, #212529 0%, #495057 100%);
            color: white;
            padding: 40px;
            border-radius: 16px;
            margin-bottom: 40px;
            text-align: center;
        }
        
        .header-info h2 { 
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 12px; 
            color: white;
            letter-spacing: -0.025em;
        }
        
        .admin-info { 
            opacity: 0.9; 
            font-size: 1.1rem;
            font-weight: 300;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            margin-bottom: 50px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            border: 1px solid #f1f3f4;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(135deg, #212529 0%, #495057 100%);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        }

        .stat-icon {
            font-size: 2.8rem;
            margin-bottom: 20px;
            color: #212529;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 200;
            margin-bottom: 12px;
            color: #000;
            letter-spacing: -0.02em;
        }

        .stat-label {
            color: #6c757d;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 50px;
        }

        .panel {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            border: 1px solid #f1f3f4;
        }

        .panel h3 {
            color: #212529;
            margin-bottom: 24px;
            font-size: 1.4rem;
            font-weight: 600;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .panel h3 i {
            color: #495057;
        }

        .recent-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #f8f9fa;
            transition: all 0.2s ease;
        }

        .recent-item:last-child { border-bottom: none; }

        .recent-item:hover {
            background: #f8f9fa;
            margin: 0 -16px;
            padding: 16px;
            border-radius: 8px;
        }

        .item-info h4 {
            color: #212529;
            margin-bottom: 6px;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .item-info p {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending { 
            background: #f8f9fa; 
            color: #495057; 
            border: 1px solid #dee2e6;
        }
        
        .status-resolved { 
            background: #212529; 
            color: white; 
        }
        
        .status-reviewed { 
            background: #495057; 
            color: white; 
        }

        .chart-container {
            grid-column: 1 / -1;
            height: 450px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 20px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            background: linear-gradient(135deg, #212529 0%, #495057 100%);
            color: white;
            padding: 24px 28px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .action-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(33, 37, 41, 0.25);
            background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        }

        .action-btn i {
            font-size: 1.2rem;
        }

        .empty-state {
            color: #6c757d; 
            text-align: center; 
            padding: 40px 20px;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .container { 
                margin: 20px; 
                padding: 24px; 
            }
            .content-grid { 
                grid-template-columns: 1fr; 
            }
            .stats-grid { 
                grid-template-columns: 1fr; 
            }
            .action-buttons { 
                grid-template-columns: 1fr; 
            }
            .header-info h2 {
                font-size: 2rem;
            }
            .recent-item:hover {
                margin: 0;
                padding: 16px 0;
                background: transparent;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/admin_navbar.php'; ?>
    
    <div class="container">
        <div class="header-info">
            <h2>Dashboard</h2>
            <div class="admin-info">
                <p>Welcome, <?php echo $admin ? htmlspecialchars($admin['name']) : 'Admin'; ?> | Lost and Found Management System</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-number"><?php echo $stats['total_users']; ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="stat-number"><?php echo $stats['total_lost']; ?></div>
                <div class="stat-label">Lost Items</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number"><?php echo $stats['total_found']; ?></div>
                <div class="stat-label">Found Items</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-number"><?php echo $stats['pending_lost'] + $stats['pending_found']; ?></div>
                <div class="stat-label">Pending Items</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-double"></i></div>
                <div class="stat-number"><?php echo $stats['resolved_lost']; ?></div>
                <div class="stat-label">Resolved Items</div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Lost Items -->
            <div class="panel">
                <h3><i class="fas fa-exclamation-triangle"></i> Recent Lost Items</h3>
                <?php if ($recent_lost_result->num_rows > 0): ?>
                    <?php while ($item = $recent_lost_result->fetch_assoc()): ?>
                        <div class="recent-item">
                            <div class="item-info">
                                <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                                <p><?php echo htmlspecialchars($item['reporter_name']); ?> • <?php echo date('M d, Y', strtotime($item['created_at'])); ?></p>
                            </div>
                            <span class="status-badge status-<?php echo strtolower($item['status']); ?>">
                                <?php echo $item['status']; ?>
                            </span>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="empty-state">No lost items reported yet</p>
                <?php endif; ?>
            </div>

            <!-- Recent Found Items -->
            <div class="panel">
                <h3><i class="fas fa-check-circle"></i> Recent Found Items</h3>
                <?php if ($recent_found_result->num_rows > 0): ?>
                    <?php while ($item = $recent_found_result->fetch_assoc()): ?>
                        <div class="recent-item">
                            <div class="item-info">
                                <h4><?php echo htmlspecialchars($item['item_name']); ?></h4>
                                <p><?php echo htmlspecialchars($item['finder_name']); ?> • <?php echo date('M d, Y', strtotime($item['created_at'])); ?></p>
                            </div>
                            <span class="status-badge status-<?php echo strtolower($item['status']); ?>">
                                <?php echo $item['status']; ?>
                            </span>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="empty-state">No found items reported yet</p>
                <?php endif; ?>
            </div>

            <!-- Recent Users -->
            <div class="panel">
                <h3><i class="fas fa-user-plus"></i> Recent Registrations</h3>
                <?php if ($recent_users_result->num_rows > 0): ?>
                    <?php while ($user = $recent_users_result->fetch_assoc()): ?>
                        <div class="recent-item">
                            <div class="item-info">
                                <h4><?php echo htmlspecialchars($user['name']); ?></h4>
                                <p><?php echo htmlspecialchars($user['department']); ?> • <?php echo date('M d, Y', strtotime($user['created_at'])); ?></p>
                            </div>
                            <span class="status-badge status-reviewed">Active</span>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="empty-state">No recent registrations</p>
                <?php endif; ?>
            </div>

            <!-- Monthly Chart -->
            <div class="panel chart-container">
                <h3><i class="fas fa-chart-line"></i> Monthly Statistics</h3>
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="action-buttons">
            <a href="users.php" class="action-btn">
                <i class="fas fa-users"></i>
                Manage Users
            </a>
            <a href="lost-items.php" class="action-btn">
                <i class="fas fa-exclamation-triangle"></i>
                Manage Lost Items
            </a>
            <a href="found-items.php" class="action-btn">
                <i class="fas fa-check-circle"></i>
                Manage Found Items
            </a>
            <a href="reports.php" class="action-btn">
                <i class="fas fa-chart-bar"></i>
                Generate Reports
            </a>
        </div>
    </div>

    <script>
        // Monthly Chart
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Lost Items',
                    data: <?php echo json_encode(array_column($monthly_lost_data, 'count')); ?>,
                    borderColor: '#212529',
                    backgroundColor: 'rgba(33, 37, 41, 0.1)',
                    tension: 0.4,
                    borderWidth: 2
                }, {
                    label: 'Found Items',
                    data: <?php echo json_encode(array_column($monthly_found_data, 'count')); ?>,
                    borderColor: '#6c757d',
                    backgroundColor: 'rgba(108, 117, 125, 0.1)',
                    tension: 0.4,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Lost vs Found Items',
                        color: '#212529',
                        font: {
                            size: 16,
                            weight: '500'
                        }
                    },
                    legend: {
                        labels: {
                            color: '#495057'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#6c757d'
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#6c757d'
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>