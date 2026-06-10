<?php
require_once '../dbconnect.php';
session_start();
// Handle status update
if (isset($_POST['update_status'])) {
    $item_id = intval($_POST['item_id']);
    $new_status = $_POST['status'];
    $update_sql = "UPDATE lost_items SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('si', $new_status, $item_id);
    $stmt->execute();
}

// Fetch all lost items
$sql = "SELECT `id`, `item_name`, `item_type`, `lost_date`, `lost_place`, `item_description`, `item_photo`, `reporter_name`, `mobile_number`, `enrollment_number`, `department`, `semester`, `class`, `report_date`, `status`, `created_at` FROM `lost_items` WHERE 1";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Lost Items</title>
    <link rel="stylesheet" href="../includes/navbar.css">
    <style>
        body { font-family: 'Poppins', Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .container {
            width: 100vw;
            max-width: none;
            margin: 40px 0 0 0;
            background: #fff;
            border-radius: 0;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            padding: 32px 0;
        }
        .container > h2 {
            margin-left: 32px;
        }
        .container table {
            width: 96%;
            margin: 0 auto 32px auto;
        }
        h2 { margin-bottom: 24px; }
        table { border-collapse: collapse; }
        th, td { padding: 12px 16px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f4f4f4; }
        img.item-img { max-width: 120px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        .status-form select { padding: 6px 12px; border-radius: 6px; border: 1px solid #ccc; }
        .status-form button { padding: 6px 16px; border-radius: 6px; background: #1976d2; color: #fff; border: none; font-weight: 500; cursor: pointer; margin-left: 8px; }
        .status-form button:hover { background: #1565c0; }
    </style>
</head>
<body>
    <?php include '../includes/admin_navbar.php'; ?>
    <div class="container">
        <h2>All Lost Items</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Type</th>
                    <th>Lost Date</th>
                    <th>Lost Place</th>
                    <th>Description</th>
                    <th>Photo</th>
                    <th>Reporter Name</th>
                    <th>Mobile</th>
                    <th>Enrollment</th>
                    <th>Department</th>
                    <th>Semester</th>
                    <th>Class</th>
                    <th>Report Date</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['item_name']) ?></td>
                    <td><?= htmlspecialchars($row['item_type']) ?></td>
                    <td><?= htmlspecialchars($row['lost_date']) ?></td>
                    <td><?= htmlspecialchars($row['lost_place']) ?></td>
                    <td><?= htmlspecialchars($row['item_description']) ?></td>
                    <td>
                        <?php if (!empty($row['item_photo'])): ?>
                            <img class="item-img" src="../uploads/<?= htmlspecialchars($row['item_photo']) ?>" alt="Lost Item">
                        <?php else: ?>
                            <span style="color:#888;">No Photo</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['reporter_name']) ?></td>
                    <td><?= htmlspecialchars($row['mobile_number']) ?></td>
                    <td><?= htmlspecialchars($row['enrollment_number']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['semester']) ?></td>
                    <td><?= htmlspecialchars($row['class']) ?></td>
                    <td><?= htmlspecialchars($row['report_date']) ?></td>
                    <td>
                        <form method="post" class="status-form">
                            <input type="hidden" name="item_id" value="<?= $row['id'] ?>">
                            <select name="status">
                                <option value="Pending" <?= $row['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Reviewed" <?= $row['status'] == 'Reviewed' ? 'selected' : '' ?>>Reviewed</option>
                                <option value="Resolved" <?= $row['status'] == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                            </select>
                            <button type="submit" name="update_status">Update</button>
                        </form>
                    </td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td>
                        <a href="view_lost_item.php?id=<?= $row['id'] ?>" class="edit">View</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
