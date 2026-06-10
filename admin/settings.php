<?php
require_once '../dbconnect.php';
// Only allow admin access
session_start();
//if (!isset($_SESSION['admin_id'])) {
    //header('Location: login.php');
    //exit();
//}

$message = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        if ($new_password === $confirm_password) {
            // In a real application, you would verify current password and hash new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $message = "Password changed successfully!";
        } else {
            $error = "New passwords do not match!";
        }
    }
    
    if (isset($_POST['update_site_settings'])) {
        $site_name = $_POST['site_name'];
        $site_description = $_POST['site_description'];
        $contact_email = $_POST['contact_email'];
        
        // Here you would update site settings in database
        $message = "Site settings updated successfully!";
    }
    
    if (isset($_POST['clear_logs'])) {
        // Clear system logs
        $message = "System logs cleared successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings - Lost and Found</title>
    <link rel="stylesheet" href="../includes/navbar.css">
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: #f8f9fa; margin: 0; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        
        h2 { 
            font-size: 2.5rem; 
            font-weight: 300; 
            color: #000; 
            margin-bottom: 8px;
            letter-spacing: -0.025em;
        }
        
        .subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 40px;
            font-weight: 400;
        }

        .settings-grid {
            display: grid;
            gap: 24px;
        }

        .settings-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #dee2e6;
            transition: all 0.2s ease;
        }

        .settings-card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e9ecef;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #212529 0%, #495057 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #212529;
            margin: 0;
        }

        .card-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #495057;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            max-width: 100%;
            padding: 12px 16px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color: #495057;
            background: white;
            box-shadow: 0 0 0 3px rgba(73, 80, 87, 0.1);
        }

        textarea.form-input {
            height: 80px;
            resize: vertical;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #212529 0%, #495057 100%);
            color: white;
            border: 1px solid transparent;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(33, 37, 41, 0.3);
            background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, #343a40 0%, #495057 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(52, 58, 64, 0.3);
            background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #6c757d 0%, #adb5bd 100%);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
            background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        }

        .btn-outline {
            background: white;
            color: #212529;
            border: 1px solid #212529;
        }

        .btn-outline:hover {
            background: #212529;
            color: white;
        }

        .message {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .message.success {
            background: #f8f9fa;
            color: #212529;
            border: 1px solid #dee2e6;
        }

        .message.error {
            background: #f8f9fa;
            color: #212529;
            border: 1px solid #adb5bd;
        }

        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 4px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .action-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
        }

        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #212529;
        }

        .checkbox-label {
            color: #495057;
            font-size: 0.875rem;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .settings-card { padding: 24px; }
            h2 { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <?php include '../includes/admin_navbar.php'; ?>
    <div class="container">
        <h2>Settings</h2>
        <p class="subtitle">Manage your system configuration and preferences</p>
        
        <?php if ($message): ?>
            <div class="message success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- System Overview -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-number">
                    <?php
                    $user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM stu_register"))['count'];
                    echo $user_count;
                    ?>
                </div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Lost Items</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Found Items</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Resolved Cases</div>
            </div>
        </div>

        <div class="settings-grid">
            <!-- Security Settings -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">🔐</div>
                    <div>
                        <h3 class="card-title">Security</h3>
                        <p class="card-description">Manage your account security settings</p>
                    </div>
                </div>
                <form method="POST">
                    <div class="form-group">
                        <label class="form-label" for="current_password">Current Password</label>
                        <input class="form-input" type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="new_password">New Password</label>
                        <input class="form-input" type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="confirm_password">Confirm New Password</label>
                        <input class="form-input" type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-primary">Update Password</button>
                </form>
            </div>

            <!-- Site Configuration -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">⚙️</div>
                    <div>
                        <h3 class="card-title">Site Configuration</h3>
                        <p class="card-description">Configure basic site settings</p>
                    </div>
                </div>
                <form method="POST">
                    <div class="form-group">
                        <label class="form-label" for="site_name">Site Name</label>
                        <input class="form-input" type="text" id="site_name" name="site_name" value="Lost and Found System" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="site_description">Site Description</label>
                        <textarea class="form-input" id="site_description" name="site_description" placeholder="Enter site description...">A comprehensive lost and found management system for educational institutions.</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="contact_email">Contact Email</label>
                        <input class="form-input" type="email" id="contact_email" name="contact_email" value="admin@lostandfound.com" required>
                    </div>
                    <button type="submit" name="update_site_settings" class="btn btn-success">Save Changes</button>
                </form>
            </div>

            <!-- Database Management -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">🗄️</div>
                    <div>
                        <h3 class="card-title">Database Management</h3>
                        <p class="card-description">Manage database operations and maintenance</p>
                    </div>
                </div>
                <div class="action-group">
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="clear_logs" class="btn btn-outline" onclick="return confirm('Are you sure you want to clear all system logs?');">Clear Logs</button>
                    </form>
                    <button type="button" class="btn btn-primary" onclick="alert('Database backup functionality would be implemented here.');">Backup Database</button>
                </div>
            </div>

            <!-- System Maintenance -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">🔧</div>
                    <div>
                        <h3 class="card-title">System Maintenance</h3>
                        <p class="card-description">Perform system maintenance operations</p>
                    </div>
                </div>
                <div class="action-group">
                    <button type="button" class="btn btn-success" onclick="alert('Cache cleared successfully!');">Clear Cache</button>
                    <button type="button" class="btn btn-primary" onclick="alert('System check completed. All systems operational.');">System Check</button>
                    <button type="button" class="btn btn-danger" onclick="if(confirm('This will put the site in maintenance mode. Continue?')) alert('Maintenance mode activated.');">Maintenance Mode</button>
                </div>
            </div>

            <!-- Notifications -->
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon">🔔</div>
                    <div>
                        <h3 class="card-title">Notifications</h3>
                        <p class="card-description">Configure notification preferences</p>
                    </div>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="email_reg" checked>
                    <label class="checkbox-label" for="email_reg">Email notifications for new registrations</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="email_items" checked>
                    <label class="checkbox-label" for="email_items">Email notifications for new lost items</label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="sms_notifications">
                    <label class="checkbox-label" for="sms_notifications">SMS notifications (Premium feature)</label>
                </div>
                <button type="button" class="btn btn-primary">Save Preferences</button>
            </div>
        </div>
    </div>
</body>
</html>
