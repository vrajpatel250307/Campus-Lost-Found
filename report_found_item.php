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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $item_type = $_POST['item_type'];
    $found_place = $_POST['found_place'];
    $found_date = $_POST['found_date'];
    $item_description = $_POST['item_description'];
    // Use session data for user details
    $finder_name = $user_name;
    $mobile_number = $user_mobile;
    $enrollment_number = $user_enrollment;
    $department = $user_department;
    $semester = $_POST['semester'];
    $class = $_POST['class'];

    // Handle file upload
    $target_dir = __DIR__ . "/uploads/found_items/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        if (!@mkdir($target_dir, 0777, true)) {
            echo "<script>alert('Error creating upload directory. Please contact administrator.');</script>";
            $uploadOk = 0;
        }
    }

    // Check if directory is writable
    if (!is_writable($target_dir)) {
        echo "<script>alert('Upload directory is not writable. Please contact administrator.');</script>";
        $uploadOk = 0;
    }

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["item_photo"]["name"],PATHINFO_EXTENSION));
    
    // Generate unique filename
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;
    
    // Generate unique filename
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;

    // Check if image file is actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["item_photo"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["item_photo"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG & PNG files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["item_photo"]["tmp_name"], $target_file)) {
            try {
                // Insert into database
                $sql = "INSERT INTO found_items (item_name, item_type, found_place, found_date, item_description, 
                        finder_name, mobile_number, enrollment_number, department, semester, class, item_photo, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssssss", $item_name, $item_type, $found_place, $found_date, 
                                $item_description, $finder_name, $mobile_number, $enrollment_number, 
                                $department, $semester, $class, $new_filename);
                
                if ($stmt->execute()) {
                    echo "<script>alert('Found item report submitted successfully!'); window.location.href = 'dashboard.php';</script>";
                } else {
                    echo "<script>alert('Error submitting report. Please try again.');</script>";
                    // Remove uploaded file if database insert fails
                    @unlink($target_file);
                }
            } catch (Exception $e) {
                echo "<script>alert('Database error. Please try again.');</script>";
                // Remove uploaded file if database insert fails
                @unlink($target_file);
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Found Item - Campus Lost and Found</title>
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

        .form-group.full-width {
            grid-column: span 2;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #222;
            font-weight: 500;
            font-size: 1.08rem;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            color: #222;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #111;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23111111' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        button[type="submit"] {
            background: #111;
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            display: none;
            margin-top: 12px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .copyright {
            text-align: center;
            padding: 20px 0;
            color: #666;
            font-size: 0.9rem;
            margin-top: 40px;
            border-top: 1px solid #eee;
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
            <h1>Report Found Item</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="item_name">Item Name*</label>
                        <input type="text" id="item_name" name="item_name" required>
                    </div>

                    <div class="form-group">
                        <label for="item_type">Item Type*</label>
                        <select id="item_type" name="item_type" required>
                            <option value="">Select Type</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Documents">Documents</option>
                            <option value="Personal Accessories">Personal Accessories</option>
                            <option value="Books">Books</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="found_place">Found Place*</label>
                        <input type="text" id="found_place" name="found_place" required>
                    </div>

                    <div class="form-group">
                        <label for="found_date">Found Date*</label>
                        <input type="date" id="found_date" name="found_date" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="item_description">Item Description*</label>
                        <textarea id="item_description" name="item_description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="finder_name">Your Name</label>
                        <input type="text" id="finder_name" name="finder_name" value="<?php echo htmlspecialchars($user_name); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="mobile_number">Mobile Number</label>
                        <input type="tel" id="mobile_number" name="mobile_number" value="<?php echo htmlspecialchars($user_mobile); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="enrollment_number">Enrollment Number</label>
                        <input type="text" id="enrollment_number" name="enrollment_number" value="<?php echo htmlspecialchars($user_enrollment); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="department">Department</label>
                        <input type="text" id="department" name="department" value="<?php echo htmlspecialchars($user_department); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="semester">Semester*</label>
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
                        <label for="class">Class*</label>
                        <input type="text" id="class" name="class" required>
                    </div>

                    <div class="form-group">
                        <label for="item_photo">Item Photo*</label>
                        <input type="file" id="item_photo" name="item_photo" accept="image/jpeg,image/png,image/jpg" required>
                        <img id="preview" class="preview-image">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit">Submit Report</button>
                </div>
            </form>
        </div>
        <div class="copyright">
            © 2025 Campus Lost and Found. All Rights Reserved.
        </div>
    </div>

    <script>
        // Image preview
        document.getElementById('item_photo').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            if(file) {
                reader.readAsDataURL(file);
            }
        });

        // Mobile number validation
        document.getElementById('mobile_number').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });
    </script>
</body>
</html>
