-- Create database
CREATE DATABASE IF NOT EXISTS lostandfound_DB;
USE lostandfound_DB;

-- 1. Student Registration Table
CREATE TABLE stu_register (
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    enrollment VARCHAR(50) NOT NULL UNIQUE,
    student_email VARCHAR(100) NOT NULL,
    department VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    college_id_card VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Lost Items Table
CREATE TABLE lost_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    item_type VARCHAR(100) NOT NULL,
    lost_date DATE NOT NULL,
    lost_place VARCHAR(255) NOT NULL,
    item_description TEXT NOT NULL,
    item_photo VARCHAR(255) NOT NULL,
    reporter_name VARCHAR(255) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    enrollment_number VARCHAR(50) NOT NULL,
    department VARCHAR(100) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    class VARCHAR(50) NOT NULL,
    report_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Found Items Table
CREATE TABLE found_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    item_type VARCHAR(100) NOT NULL,
    found_place VARCHAR(255) NOT NULL,
    found_date DATE NOT NULL,
    item_description TEXT NOT NULL,
    finder_name VARCHAR(255) NOT NULL,
    mobile_number VARCHAR(15) NOT NULL,
    enrollment_number VARCHAR(50) NOT NULL,
    department VARCHAR(100) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    class VARCHAR(50) NOT NULL,
    item_photo VARCHAR(255) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 4. Admin Users Table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Extended Admins Table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'admin',
    status VARCHAR(20) DEFAULT 'active',
    last_login DATETIME NULL,
    failed_attempts INT DEFAULT 0,
    last_failed_attempt DATETIME NULL,
    deleted_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    permissions TEXT,
    auth_token VARCHAR(255),
    token_expiry DATETIME
);

-- 6. Admin Activity Logs
CREATE TABLE admin_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_admin_id (admin_id),
    INDEX idx_created_at (created_at)
);

-- 7. Admin Sessions Management
CREATE TABLE admin_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    ip_address VARCHAR(45),
    user_agent TEXT,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1,
    INDEX idx_admin_id (admin_id),
    INDEX idx_session_token (session_token),
    INDEX idx_expires_at (expires_at)
);

-- 8. Admin Login Attempts Tracking
CREATE TABLE admin_login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    success TINYINT(1) DEFAULT 0,
    attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_ip_address (ip_address),
    INDEX idx_attempted_at (attempted_at)
);

-- Insert Default Admin Account
INSERT INTO admin (name, email, password) VALUES 
('Super Admin', 'admin@guni.ac.in', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert Default Extended Admin Account
INSERT INTO admins (name, email, password, role, status, permissions) VALUES 
('Super Admin', 'admin@guni.ac.in', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin', 'active', 
'{"users": ["view", "create", "edit", "delete"], "lost_items": ["view", "edit", "delete"], "found_items": ["view", "edit", "delete"], "reports": ["view", "generate"], "settings": ["view", "edit"]}');

-- Create indexes for better performance
CREATE INDEX idx_enrollment ON stu_register(enrollment);
CREATE INDEX idx_student_email ON stu_register(student_email);
CREATE INDEX idx_lost_items_status ON lost_items(status);
CREATE INDEX idx_lost_items_date ON lost_items(lost_date);
CREATE INDEX idx_found_items_status ON found_items(status);
CREATE INDEX idx_found_items_date ON found_items(found_date);
CREATE INDEX idx_admin_email ON admin(email);
CREATE INDEX idx_admins_email ON admins(email);
CREATE INDEX idx_admins_status ON admins(status);