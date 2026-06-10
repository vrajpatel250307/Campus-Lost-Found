🔍 Campus Lost & Found Portal — Ganpat University
A full-stack web application that helps students and staff at Ganpat University report, search, and recover lost or found items across campus.
✨ Features
Student Side:

Register/login with college ID card verification
Report lost items with photo, location, date, description
Report found items with photo and details
Browse all found items
Update profile and reset password
Contact support

Admin Panel:

Secure admin login with session management and login attempt tracking
Dashboard with real-time stats (total users, lost/found items, pending/resolved counts)
Manage lost & found item reports (view, update status, delete)
User management (view, edit, delete students)
Multi-admin support with role-based permissions
Admin activity logs and session management
Reports section

Tech Stack:

Backend: PHP (procedural)
Database: MySQL
Frontend: HTML, CSS, JavaScript (vanilla)
Email: PHPMailer (SMTP)
Server: Apache / XAMPP

🗄️ Database Tables:
stu_register, lost_items, found_items, admin, admins, admin_logs, admin_sessions, admin_login_attempts
