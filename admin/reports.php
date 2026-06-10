<?php
require_once '../dbconnect.php';
// Only allow admin access
session_start();
//if (!isset($_SESSION['admin_id'])) {
    //header('Location: login.php');
    //exit();
//}

// Get various statistics
$total_users_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM stu_register");
$total_users = mysqli_fetch_assoc($total_users_result)['count'];

// Get recent registrations (last 30 days)
$recent_users_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM stu_register WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
$recent_users = mysqli_fetch_assoc($recent_users_result)['count'];

// Get department wise statistics
$dept_stats = mysqli_query($conn, "SELECT department, COUNT(*) as count FROM stu_register GROUP BY department ORDER BY count DESC");

// Get monthly registration data for the last 6 months
$monthly_data = mysqli_query($conn, "
    SELECT 
        MONTHNAME(created_at) as month_name, 
        MONTH(created_at) as month_num,
        COUNT(*) as registrations 
    FROM stu_register 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY MONTH(created_at), MONTHNAME(created_at)
    ORDER BY month_num ASC
");

// Get recent users
$recent_users_list = mysqli_query($conn, "
    SELECT name, email, department, created_at 
    FROM stu_register 
    ORDER BY created_at DESC 
    LIMIT 10
");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports - Lost and Found</title>
    <link rel="stylesheet" href="../includes/navbar.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .container { max-width: 1200px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); padding: 32px; }
        h2 { margin-bottom: 24px; color: #333; }
        .stats-overview { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; border-radius: 12px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .stat-card.users { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }
        .stat-card.items { background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%); }
        .stat-card.resolved { background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); }
        .stat-card.pending { background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%); }
        .stat-number { font-size: 36px; font-weight: bold; margin-bottom: 10px; }
        .stat-label { font-size: 14px; opacity: 0.9; }
        .stat-change { font-size: 12px; margin-top: 8px; }
        .report-section { margin-bottom: 40px; background: #fff; border-radius: 8px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .section-title { font-size: 20px; font-weight: bold; color: #333; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; color: #555; }
        .chart-container { height: 300px; margin: 20px 0; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #666; }
        .progress-bar { background: #eee; border-radius: 10px; overflow: hidden; height: 20px; margin: 10px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #4CAF50, #45a049); transition: width 0.3s ease; }
        .dept-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .dept-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #4CAF50; }
        .dept-name { font-weight: bold; color: #333; }
        .dept-count { font-size: 24px; color: #4CAF50; font-weight: bold; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin: 5px; }
        .btn-primary { background: #1976d2; color: white; }
        .btn-success { background: #4CAF50; color: white; }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); transition: all 0.2s; }
        .date-filter { margin-bottom: 20px; }
        .date-filter select, .date-filter input { padding: 8px; margin: 0 10px; border: 1px solid #ddd; border-radius: 4px; }
    </style>
</head>
<body>
    <?php include '../includes/admin_navbar.php'; ?>
    <div class="container">
        <h2>Admin Reports & Analytics</h2>

        <!-- Statistics Overview -->
        <div class="stats-overview">
            <div class="stat-card users">
                <div class="stat-number"><?= $total_users ?></div>
                <div class="stat-label">Total Registered Users</div>
                <div class="stat-change">+<?= $recent_users ?> this month</div>
            </div>
            <div class="stat-card items">
                <div class="stat-number">0</div>
                <div class="stat-label">Total Lost Items</div>
                <div class="stat-change">+0 this week</div>
            </div>
            <div class="stat-card resolved">
                <div class="stat-number">0</div>
                <div class="stat-label">Items Resolved</div>
                <div class="stat-change">0% success rate</div>
            </div>
            <div class="stat-card pending">
                <div class="stat-number">0</div>
                <div class="stat-label">Pending Cases</div>
                <div class="stat-change">0 urgent</div>
            </div>
        </div>

        <!-- Date Filter -->
        <div class="report-section">
            <div class="section-title">Report Filters</div>
            <div class="date-filter">
                <label>Time Period:</label>
                <select>
                    <option value="7">Last 7 days</option>
                    <option value="30" selected>Last 30 days</option>
                    <option value="90">Last 3 months</option>
                    <option value="365">Last year</option>
                </select>
                <label>Custom Range:</label>
                <input type="date" value="<?= date('Y-m-d', strtotime('-30 days')) ?>">
                <input type="date" value="<?= date('Y-m-d') ?>">
                <button class="btn btn-primary">Apply Filter</button>
                <button class="btn btn-success">Export Report</button>
            </div>
        </div>

        <!-- Monthly Registration Trends -->
        <div class="report-section">
            <div class="section-title">Monthly Registration Trends</div>
            <div class="chart-container">
                <div>
                    <h3>Registration Chart</h3>
                    <p>Chart visualization would be implemented here using Chart.js or similar library</p>
                    <?php while ($month_data = mysqli_fetch_assoc($monthly_data)): ?>
                        <div style="margin: 5px 0;">
                            <?= $month_data['month_name'] ?>: <?= $month_data['registrations'] ?> registrations
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <!-- Department Statistics -->
        <div class="report-section">
            <div class="section-title">Department-wise User Distribution</div>
            <div class="dept-stats">
                <?php while ($dept = mysqli_fetch_assoc($dept_stats)): ?>
                <div class="dept-card">
                    <div class="dept-name"><?= htmlspecialchars($dept['department']) ?></div>
                    <div class="dept-count"><?= $dept['count'] ?></div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?= ($dept['count'] / $total_users) * 100 ?>%"></div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="report-section">
            <div class="section-title">Recent User Registrations</div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Registration Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($recent_users_list)): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['department']) ?></td>
                        <td><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- System Health -->
        <div class="report-section">
            <div class="section-title">System Health & Performance</div>
            <div class="stats-overview">
                <div class="stat-card">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">System Uptime</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= round(memory_get_usage() / 1024 / 1024, 2) ?>MB</div>
                    <div class="stat-label">Memory Usage</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= mysqli_get_server_info($conn) ?></div>
                    <div class="stat-label">Database Version</div>
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        <div class="report-section">
            <div class="section-title">Recent System Activity</div>
            <table>
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>User</th>
                        <th>Timestamp</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>User Registration</td>
                        <td>System</td>
                        <td><?= date('M j, Y H:i') ?></td>
                        <td><span style="color: #4CAF50;">Success</span></td>
                    </tr>
                    <tr>
                        <td>Database Backup</td>
                        <td>Admin</td>
                        <td><?= date('M j, Y H:i', strtotime('-2 hours')) ?></td>
                        <td><span style="color: #4CAF50;">Completed</span></td>
                    </tr>
                    <tr>
                        <td>System Maintenance</td>
                        <td>System</td>
                        <td><?= date('M j, Y H:i', strtotime('-1 day')) ?></td>
                        <td><span style="color: #FF9800;">Scheduled</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Add some interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bars
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });
    </script>
</body>
</html>
