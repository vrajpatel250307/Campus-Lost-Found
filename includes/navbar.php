<nav class="navbar">
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
        <li>
            <a href="#">My Reports</a>
            <div class="submenu">
                <a href="report_lost_item.php">Report Lost Item</a>
                <a href="report_found_item.php">Report Found Item</a>
                <a href="my_lost_items.php">My Lost Items</a>
                <a href="my_found_items.php">My Found Items</a>
            </div>
        </li>
        <li>
            <a href="#">Browse Items</a>
            <div class="submenu">
                <a href="view_lost_items.php">Browse Lost Items</a>
                <a href="view_found_items.php">Browse Found Items</a>
                <a href="recent_matches.php">Recent Matches</a>
                <a href="search_items.php">Search Items</a>
            </div>
        </li>
        <li>
            <a href="#">My Account</a>
            <div class="submenu">
                <a href="dashboard.php">Dashboard</a>
                <a href="profile.php">My Profile</a>
                <a href="edit_profile.php">Edit Profile</a>
                <a href="my_notifications.php">Notifications</a>
                <a href="change_password.php">Change Password</a>
            </div>
        </li>
        <li>
            <a href="#">Help & Support</a>
            <div class="submenu">
                <a href="contact_us.php">Contact Us</a>
                <a href="faq.php">FAQ</a>
                <a href="guidelines.php">Guidelines</a>
                <a href="support_ticket.php">Support Ticket</a>
            </div>
        </li>
        <li><a href="logout.php" style="color: #ff6b6b;">Logout</a></li>
        <?php else: ?>
        <li><a href="report_lost_item.php">Report Lost Item</a></li>
        <li>
            <a href="#">Found Items</a>
            <div class="submenu">
                <a href="report_found_item.php">Post Found Item</a>
                <a href="view_found_items.php">See Found Items</a>
            </div>
        </li>
        <li><a href="contact_us.php">Contact Us</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register_student.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>
<style>
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