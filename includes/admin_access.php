<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="admin-access">
    <?php if (isset($_SESSION['admin_id'])): ?>
        <a href="/admin/dashboard.php" class="admin-button">
            <i class="fas fa-user-shield"></i> Admin Panel
        </a>
    <?php else: ?>
        <div class="admin-buttons">
            <a href="/admin/login.php" class="admin-button">Admin Login</a>
            <a href="/admin/register.php" class="admin-button">Admin Register</a>
        </div>
    <?php endif; ?>
</div>

<style>
.admin-access {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}

.admin-buttons {
    display: flex;
    gap: 10px;
}

.admin-button {
    display: inline-block;
    padding: 8px 16px;
    background: #111;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    transition: background 0.3s;
}

.admin-button:hover {
    background: #333;
}

@media (max-width: 768px) {
    .admin-access {
        top: 10px;
        right: 10px;
    }
    
    .admin-button {
        padding: 6px 12px;
        font-size: 12px;
    }
}
</style>
