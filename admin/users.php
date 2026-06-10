<?php
require_once '../dbconnect.php';
// Only allow admin access
session_start();
//if (!isset($_SESSION['admin_id'])) {
    //header('Location: login.php');
    //exit();
//}

// Handle user management actions (delete, etc.)
if (isset($_GET['delete'])) {
    $enrollment = mysqli_real_escape_string($conn, $_GET['delete']);
    $delete_sql = "DELETE FROM stu_register WHERE enrollment = '$enrollment'";
    mysqli_query($conn, $delete_sql);
    header('Location: users.php');
    exit();
}

// Fetch all users
$sql = "SELECT 
            `name`, 
            `email`, 
            `mobile`, 
            `enrollment`, 
            `student_email`, 
            `department`, 
            `address`, 
            `college_id_card`, 
            `password`, 
            `created_at`
        FROM `stu_register`";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin</title>
    <link rel="stylesheet" href="../includes/navbar.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .container { max-width: 1200px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); padding: 32px; }
        h2 { margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 32px; }
        th, td { padding: 12px 16px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f4f4f4; }
        img.idcard { max-width: 120px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        .actions a { margin-right: 12px; color: #d32f2f; text-decoration: none; font-weight: bold; }
        .actions a:hover { text-decoration: underline; }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 0 4px;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn-delete:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
    <?php include '../includes/admin_navbar.php'; ?>
    <div class="container">
        <h2>All Registered Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Enrollment</th>
                    <th>Student Email</th>
                    <th>Department</th>
                    <th>Address</th>
                    <th>ID Card</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['mobile']) ?></td>
                    <td><?= htmlspecialchars($row['enrollment']) ?></td>
                    <td><?= htmlspecialchars($row['student_email']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td>
                        <?php if (!empty($row['college_id_card'])): ?>
                            <img class="idcard" src="../uploads/idcards/<?= htmlspecialchars($row['college_id_card']) ?>" alt="ID Card">
                        <?php else: ?>
                            <span style="color:#888;">No ID</span>
                        <?php endif; ?>
                    </td>
                    <td class="actions">
                        <a href="users.php?delete=<?= urlencode($row['enrollment']) ?>" onclick="return confirm('Are you sure you want to remove this user?');">Remove</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
