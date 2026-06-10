<?php
require_once '../dbconnect.php';
// Only allow admin access
session_start();
//if (!isset($_SESSION['admin_id'])) {
    //header('Location: login.php');
    //exit();
//}

// Handle admin management actions
if (isset($_GET['toggle_status'])) {
    $admin_id = mysqli_real_escape_string($conn, $_GET['toggle_status']);
    $current_status_result = mysqli_query($conn, "SELECT status FROM admins WHERE id = '$admin_id'");
    $current_status = mysqli_fetch_assoc($current_status_result)['status'];
    $new_status = ($current_status == 'active') ? 'inactive' : 'active';
    
    $update_sql = "UPDATE admins SET status = '$new_status', updated_at = NOW() WHERE id = '$admin_id'";
    mysqli_query($conn, $update_sql);
    header('Location: admins.php');
    exit();
}

if (isset($_GET['reset_attempts'])) {
    $admin_id = mysqli_real_escape_string($conn, $_GET['reset_attempts']);
    $reset_sql = "UPDATE admins SET failed_attempts = 0, last_failed_attempt = NULL, updated_at = NOW() WHERE id = '$admin_id'";
    mysqli_query($conn, $reset_sql);
    header('Location: admins.php');
    exit();
}

// Fetch all admins
$sql = "SELECT 
            `id`, 
            `name`, 
            `email`, 
            `password`, 
            `role`, 
            `status`, 
            `last_login`, 
            `failed_attempts`, 
            `last_failed_attempt`, 
            `deleted_at`, 
            `created_at`, 
            `updated_at`, 
            `permissions`, 
            `auth_token`, 
            `token_expiry`
        FROM `admins` 
        WHERE deleted_at IS NULL
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

$total_admins = mysqli_num_rows($result);
$active_admins = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM admins WHERE status = 'active' AND deleted_at IS NULL"))['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins - Admin Panel</title>
    <link rel="stylesheet" href="../includes/navbar.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .container { max-width: 1400px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); padding: 32px; }
        h2 { margin-bottom: 24px; color: #333; }
        .stats-overview { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; text-align: center; }
        .stat-card.total { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }
        .stat-card.active { background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); }
        .stat-card.inactive { background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%); }
        .stat-number { font-size: 28px; font-weight: bold; }
        .stat-label { font-size: 14px; margin-top: 5px; opacity: 0.9; }
        .table-container { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 32px; font-size: 14px; }
        th, td { padding: 12px 8px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8f9fa; font-weight: 600; color: #555; position: sticky; top: 0; }
        .status-badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .status-active { background: #e8f5e8; color: #2e7d32; }
        .status-inactive { background: #fff3e0; color: #f57c00; }
        .role-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; background: #e3f2fd; color: #1976d2; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 12px; margin: 2px; }
        .btn-primary { background: #1976d2; color: white; }
        .btn-warning { background: #ff9800; color: white; }
        .btn-success { background: #4CAF50; color: white; }
        .btn-danger { background: #f44336; color: white; }
        .btn:hover { opacity: 0.8; }
        .failed-attempts { color: #f44336; font-weight: bold; }
        .last-login { color: #666; font-size: 12px; }
        .permissions-list { max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .add-admin-btn { background: #4CAF50; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; margin-bottom: 20px; }
        .password-masked { font-family: monospace; letter-spacing: 2px; }
    </style>
</head>
<body>
    <?php include '../includes/admin_navbar.php'; ?>
    <div class="container">
        <h2>Admin Management</h2>
        
        <!-- Statistics Overview -->
        <div class="stats-overview">
            <div class="stat-card total">
                <div class="stat-number"><?= $total_admins ?></div>
                <div class="stat-label">Total Admins</div>
            </div>
            <div class="stat-card active">
                <div class="stat-number"><?= $active_admins ?></div>
                <div class="stat-label">Active Admins</div>
            </div>
            <div class="stat-card inactive">
                <div class="stat-number"><?= $total_admins - $active_admins ?></div>
                <div class="stat-label">Inactive Admins</div>
            </div>
        </div>

        <button class="add-admin-btn" onclick="alert('Add new admin functionality would be implemented here')">+ Add New Admin</button>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Failed Attempts</th>
                        <th>Permissions</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($admin = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($admin['id']) ?></td>
                        <td><?= htmlspecialchars($admin['name']) ?></td>
                        <td><?= htmlspecialchars($admin['email']) ?></td>
                        <td>
                            <span class="role-badge"><?= htmlspecialchars($admin['role']) ?></span>
                        </td>
                        <td>
                            <span class="status-badge status-<?= $admin['status'] ?>">
                                <?= ucfirst($admin['status']) ?>
                            </span>
                        </td>
                        <td class="last-login">
                            <?php if ($admin['last_login']): ?>
                                <?= date('M j, Y H:i', strtotime($admin['last_login'])) ?>
                            <?php else: ?>
                                <span style="color: #999;">Never</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($admin['failed_attempts'] > 0): ?>
                                <span class="failed-attempts"><?= $admin['failed_attempts'] ?></span>
                                <?php if ($admin['last_failed_attempt']): ?>
                                    <br><small><?= date('M j H:i', strtotime($admin['last_failed_attempt'])) ?></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <span style="color: #4CAF50;">0</span>
                            <?php endif; ?>
                        </td>
                        <td class="permissions-list" title="<?= htmlspecialchars($admin['permissions']) ?>">
                            <?= !empty($admin['permissions']) ? htmlspecialchars(substr($admin['permissions'], 0, 20)) . '...' : 'Default' ?>
                        </td>
                        <td><?= date('M j, Y', strtotime($admin['created_at'])) ?></td>
                        <td><?= date('M j, Y', strtotime($admin['updated_at'])) ?></td>
                        <td>
                            <a href="admins.php?toggle_status=<?= $admin['id'] ?>" 
                               class="btn <?= $admin['status'] == 'active' ? 'btn-warning' : 'btn-success' ?>"
                               onclick="return confirm('Change admin status?')">
                                <?= $admin['status'] == 'active' ? 'Deactivate' : 'Activate' ?>
                            </a>
                            
                            <?php if ($admin['failed_attempts'] > 0): ?>
                            <a href="admins.php?reset_attempts=<?= $admin['id'] ?>" 
                               class="btn btn-primary"
                               onclick="return confirm('Reset failed login attempts?')">
                                Reset Attempts
                            </a>
                            <?php endif; ?>
                            
                            <button class="btn btn-danger" 
                                    onclick="if(confirm('Are you sure you want to delete this admin?')) alert('Delete functionality would be implemented here')">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Admin Details Modal (Hidden by default) -->
        <div id="adminModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; max-width: 500px; width: 90%;">
                <h3>Admin Details</h3>
                <div id="adminDetails"></div>
                <button onclick="closeModal()" style="margin-top: 20px; padding: 10px 20px; background: #666; color: white; border: none; border-radius: 4px;">Close</button>
            </div>
        </div>
    </div>

    <script>
        function viewAdminDetails(adminId, name, email, role, permissions, tokenExpiry) {
            const modal = document.getElementById('adminModal');
            const details = document.getElementById('adminDetails');
            
            details.innerHTML = `
                <p><strong>ID:</strong> ${adminId}</p>
                <p><strong>Name:</strong> ${name}</p>
                <p><strong>Email:</strong> ${email}</p>
                <p><strong>Role:</strong> ${role}</p>
                <p><strong>Permissions:</strong> ${permissions || 'Default'}</p>
                <p><strong>Token Expiry:</strong> ${tokenExpiry || 'Not set'}</p>
            `;
            
            modal.style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('adminModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        document.getElementById('adminModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>
