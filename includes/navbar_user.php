<?php
// Session is assumed to be started in the parent file
$user_name = 'Account';

if (isset($_SESSION['name'])) {
    $user_name = $_SESSION['name'];
} elseif (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
}

$is_admin = isset($_SESSION['user_id']) && !isset($_SESSION['enrollment']);
?>
<nav class="navbar">
    <ul>
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        
        <li>
            <a href="#">Reports</a>
            <div class="submenu">
                <a href="report_lost_item.php">Report Lost Item</a>
                <a href="report_found_item.php">Report Found Item</a>
                <a href="view_found_items.php">View Found Items</a>
            </div>
        </li>

        <li>
            <a href="#"><?php echo htmlspecialchars($user_name); ?></a>
            <div class="submenu">
                <a href="profile.php">My Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </li>
        <li>
            <a href="#">Help</a>
            <div class="submenu">
                <a href="faq.php">FAQ</a>
                <a href="guidelines.php">Guidelines</a>
                <a href="contact_us.php">Contact Us</a>
            </div>
        </li>
    </ul>
</nav>