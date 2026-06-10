<?php
session_start();
?>
<?php
require_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Found Items - Campus Lost and Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            color: #222;
        }
        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 36px 28px;
        }
        h2 {
            font-size: 2rem;
            margin-bottom: 24px;
            color: #2c3e50;
            text-align: center;
        }
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 32px;
            margin-top: 32px;
        }
        .item-card {
            background: linear-gradient(135deg, #fff 0%, #f4f6f8 100%);
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .item-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.13);
            transform: translateY(-2px) scale(1.03);
        }
        .item-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #007bff;
            margin-bottom: 10px;
            text-align: center;
        }
        .item-details {
            font-size: 1rem;
            color: #444;
            margin-bottom: 8px;
            text-align: center;
        }
        .item-img {
            width: 100%;
            max-width: 220px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .item-meta {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 6px;
            text-align: center;
        }
        .contact-btn {
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }
        .contact-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <?php include 'includes/navbar.php'; ?>
    </div>
    <div class="container">
        <h2>All Found Items</h2>
        <div class="items-grid">
            <?php
            $query = "SELECT `id`, `item_name`, `item_type`, `found_place`, `found_date`, `item_description`, `finder_name`, `mobile_number`, `enrollment_number`, `department`, `semester`, `class`, `item_photo`, `status`, `created_at`, `updated_at` FROM found_items ORDER BY found_date DESC";
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                while ($item = $result->fetch_assoc()) {
                    echo '<div class="item-card">';
                    // Show image from uploads path
                    $imgPath = !empty($item['item_photo']) ? 'uploads/found_items/' . ltrim($item['item_photo'], '/') : 'images/default_found.png';
                    echo '<img src="' . htmlspecialchars($imgPath) . '" class="item-img" alt="Found Item Image">';
                    // Show all info
                    echo '<div class="item-title">' . htmlspecialchars($item['item_name']) . '</div>';
                    echo '<div class="item-meta">Type: ' . htmlspecialchars($item['item_type']) . '</div>';
                    echo '<div class="item-meta">Place Found: ' . htmlspecialchars($item['found_place']) . '</div>';
                    echo '<div class="item-meta">Date Found: ' . htmlspecialchars($item['found_date']) . '</div>';
                    echo '<div class="item-details">' . htmlspecialchars($item['item_description']) . '</div>';
                    echo '<div class="item-meta">Finder Name: ' . htmlspecialchars($item['finder_name']) . '</div>';
                    echo '<div class="item-meta">Mobile: ' . htmlspecialchars($item['mobile_number']) . '</div>';
                    echo '<div class="item-meta">Enrollment: ' . htmlspecialchars($item['enrollment_number']) . '</div>';
                    echo '<div class="item-meta">Department: ' . htmlspecialchars($item['department']) . '</div>';
                    echo '<div class="item-meta">Semester: ' . htmlspecialchars($item['semester']) . '</div>';
                    echo '<div class="item-meta">Class: ' . htmlspecialchars($item['class']) . '</div>';
                    echo '<div class="item-meta">Status: ' . htmlspecialchars($item['status']) . '</div>';
                    echo '<div class="item-meta">Created: ' . htmlspecialchars($item['created_at']) . '</div>';
                    echo '<div class="item-meta">Updated: ' . htmlspecialchars($item['updated_at']) . '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div style="text-align:center; color:#888; font-size:1.2rem;">No found items yet.</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
