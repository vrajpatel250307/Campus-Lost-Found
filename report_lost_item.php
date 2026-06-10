<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get user details from session
$user_name = $_SESSION['name'];
$user_email = $_SESSION['email'];
$user_mobile = $_SESSION['mobile'];
$user_enrollment = $_SESSION['enrollment'];
$user_department = $_SESSION['department'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Lost Item - Campus Lost and Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            color: #111;
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('images/campus.jpg') no-repeat center center fixed;
            background-size: cover;
            opacity: 0.15;
            z-index: -2;
        }

        .page-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                rgba(255, 255, 255, 0.95),
                rgba(255, 255, 255, 0.98)
            );
            z-index: -1;
        }

        .header-section {
            background: #111;
            color: #fff;
            padding: 24px 0 16px 0;
        }

        .header-flex {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0;
        }

        .logo-container {
            margin-right: 18px;
            margin-left: 0;
            padding-left: 0;
            display: flex;
            align-items: center;
        }

        .logo-container img {
            width: 60px;
            height: 40px;
            object-fit: contain;
            object-position: center;
            filter: none;
            opacity: 1;
            box-shadow: 0 4px 16px rgba(0,0,0,0.10);
            border-radius: 8px;
            background: #fff;
            padding: 4px;
            display: block;
        }

        .site-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
            color: #fff;
        }

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

        .container {
            max-width: 800px;
            margin: 48px auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px 32px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #222;
            margin-bottom: 40px;
            font-size: 2em;
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
            font-family: Georgia, serif;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #111, transparent);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #222;
            font-weight: 500;
            font-size: 1.08rem;
            letter-spacing: 0.5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        input[type="text"],
        input[type="tel"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--input-border);
            border-radius: 8px;
            background: var(--input-bg);
            color: var(--text-color);
            font-size: 0.95em;
            transition: all 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%232c3e50' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        button[type="submit"] {
            background: var(--accent-color);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.15);
        }

        input[type="file"] {
            padding: 10px 0;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            display: none;
            margin-top: 12px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 30px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: 1;
            }
        }
           /* padding: 12px 16px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 8px;
            font-size: 16px;
            color: var(--text-color);
            transition: all 0.3s ease;
            box-sizing: border-box;*/
        input[type="file"] {
            padding: 12px;
            background: var(--input-bg);
            border: 2px dashed var(--input-border);
            border-radius: 8px;
            width: 100%;
            box-sizing: border-box;
            color: var(--text-color);
            cursor: pointer;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: transparent;
            color: var(--accent-color);
            padding: 14px 28px;
            border: 2px solid var(--accent-color);
            border-radius: 30px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--accent-color);
            transition: 0.5s ease;
            z-index: -1;
        }

        .submit-btn:hover {
            color: var(--primary-color);
        }

        .submit-btn:hover::before {
            width: 100%;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            h1 {
                font-size: 1.8em;
            }
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            margin-top: 15px;
            display: none;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border: 2px solid var(--input-border);
        }

        /* Animation for form elements */
        .form-group {
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stagger animation delay for form groups */
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-group:nth-child(5) { animation-delay: 0.5s; }
        .form-group:nth-child(6) { animation-delay: 0.6s; }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--primary-color);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--input-border);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-color);
        }
    </style>
</head>
<body>
    <div class="page-overlay"></div>
    <div class="content-wrapper">
        <header class="header-section">
            <div class="header-flex">
                <div class="logo-container" style="margin-left:0;">
                    <img src="images/Guni_Logo.png" alt="Campus Lost and Found Logo" width="60" height="40">
                </div>
                <h1 class="site-title" style="margin-left:24px;">Campus Lost and Found</h1>
            </div>
        </header>
        <div class="container-fluid">
            <?php include 'includes/navbar.php'; ?>
        </div>
        <div class="container">
            <h1>Report Lost Item</h1>
        <form action="process_lost_item.php" method="POST" enctype="multipart/form-data">
            <!-- Item Details -->
            <div class="form-group">
                <label for="item_name">Item Name *</label>
                <input type="text" id="item_name" name="item_name" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="item_type">Item Type *</label>
                    <select id="item_type" name="item_type" required>
                        <option value="">Select Item Type</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Documents">Documents</option>
                        <option value="Clothing">Clothing</option>
                        <option value="Accessories">Accessories</option>
                        <option value="Books">Books</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="lost_date">Date Lost *</label>
                    <input type="date" id="lost_date" name="lost_date" required>
                </div>
            </div>

            <div class="form-group">
                <label for="lost_place">Place Where Item Was Lost *</label>
                <input type="text" id="lost_place" name="lost_place" required placeholder="e.g., Library, Cafeteria, Classroom">
            </div>

            <div class="form-group">
                <label for="item_description">Item Description *</label>
                <textarea id="item_description" name="item_description" required placeholder="Please provide detailed description of the item including color, brand, distinguishing features, etc."></textarea>
            </div>

            <div class="form-group">
                <label for="item_photo">Item Photo</label>
                <input type="file" id="item_photo" name="item_photo" accept="image/*" onchange="previewImage(this)">
                <img id="preview" class="preview-image" alt="Preview">
            </div>

            <!-- Reporter Details -->
            <h2>Your Details</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="reporter_name">Your Name *</label>
                    <input type="text" id="reporter_name" name="reporter_name" required value="<?php echo htmlspecialchars($user_name); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="mobile_number">Mobile Number *</label>
                    <input type="tel" id="mobile_number" name="mobile_number" required pattern="[0-9]{10}" value="<?php echo htmlspecialchars($user_mobile); ?>" readonly>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="enrollment_number">Enrollment Number *</label>
                    <input type="text" id="enrollment_number" name="enrollment_number" required value="<?php echo htmlspecialchars($user_enrollment); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="department">Department *</label>
                    <select id="department" name="department" required disabled>
                        <option value="">Select Department</option>
                        <option value="Computer Engineering" <?php echo ($user_department == 'Computer Engineering') ? 'selected' : ''; ?>>Computer Engineering</option>
                        <option value="Information Technology" <?php echo ($user_department == 'Information Technology') ? 'selected' : ''; ?>>Information Technology</option>
                        <option value="Electronics & Communication" <?php echo ($user_department == 'Electronics & Communication') ? 'selected' : ''; ?>>Electronics & Communication</option>
                        <option value="Mechanical Engineering" <?php echo ($user_department == 'Mechanical Engineering') ? 'selected' : ''; ?>>Mechanical Engineering</option>
                        <option value="Civil Engineering" <?php echo ($user_department == 'Civil Engineering') ? 'selected' : ''; ?>>Civil Engineering</option>
                        <option value="Electrical Engineering" <?php echo ($user_department == 'Electrical Engineering') ? 'selected' : ''; ?>>Electrical Engineering</option>
                    </select>
                    <input type="hidden" name="department" value="<?php echo htmlspecialchars($user_department); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="semester">Semester *</label>
                    <select id="semester" name="semester" required>
                        <option value="">Select Semester</option>
                        <option value="1">1st Semester</option>
                        <option value="2">2nd Semester</option>
                        <option value="3">3rd Semester</option>
                        <option value="4">4th Semester</option>
                        <option value="5">5th Semester</option>
                        <option value="6">6th Semester</option>
                        <option value="7">7th Semester</option>
                        <option value="8">8th Semester</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="class">Class *</label>
                    <input type="text" id="class" name="class" required placeholder="e.g., CE-A, IT-B">
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="submit-btn">Submit Report</button>
            </div>
        </form>
    </div>
    <div class="copyright">
        © 2025 Campus Lost and Found. All Rights Reserved.
    </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
