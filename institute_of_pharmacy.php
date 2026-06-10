<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institute of Pharmacy - Ganpat University</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: none;
            color: #111;
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
            background: #fff;
            padding: 40px 32px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            text-align: center;
            font-size: 1.2rem;
            line-height: 1.7;
            color: #222;
        }
        .institute-title {
            font-size: 2rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 18px;
            letter-spacing: 1px;
        }
        .institute-image {
            text-align: center;
            margin-bottom: 24px;
        }
        .institute-image img {
            max-width: 340px;
            width: 100%;
            height: auto;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
        }
        .institute-info {
            text-align: left;
            margin: 0 auto;
            max-width: 650px;
        }
        .institute-info h3 {
            color: #222;
            font-size: 1.3rem;
            margin-top: 24px;
            margin-bottom: 10px;
        }
        .institute-info ul {
            margin-left: 18px;
            color: #444;
            font-size: 1.08rem;
            line-height: 1.7;
        }
        .institute-contact {
            margin-top: 32px;
            background: #f8f8f8;
            border-radius: 10px;
            padding: 18px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            text-align: left;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        .institute-contact h4 {
            margin-top: 0;
            color: #222;
            font-size: 1.1rem;
        }
        .institute-contact p {
            margin: 6px 0;
            font-size: 1rem;
            color: #444;
        }
    </style>
</head>
<body>
    <header class="header-section">
        <div class="header-flex">
            <div class="logo-container">
                <img src="images/Guni_Logo.png" alt="Ganpat University Logo" width="60" height="40">
            </div>
            <h1 class="site-title" style="margin-left:24px;">Campus Lost and Found</h1>
        </div>
    </header>
    <div class="container-fluid">
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
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
            </ul>
        </nav>
    </div>
    <div class="container">
        <div class="institute-title">Institute of Pharmacy</div>
        <div class="institute-image">
            <img src="images/pharmacy_building.jpg" alt="Institute of Pharmacy Building">
        </div>
        <div class="institute-info">
            <p>
                The Institute of Pharmacy at Ganpat University (SKPCPER) is a renowned center for pharmaceutical education and research in Gujarat. The institute offers undergraduate, postgraduate, and doctoral programs in pharmacy, focusing on academic excellence, research, and industry-oriented training. SKPCPER is committed to producing skilled pharmacy professionals who contribute to healthcare and pharmaceutical innovation.
            </p>
            <h3>Key Features</h3>
            <ul>
                <li>Modern laboratories and research facilities</li>
                <li>Experienced faculty with industry and research expertise</li>
                <li>Strong industry collaborations and placement support</li>
                <li>Active student chapters and professional development programs</li>
                <li>Focus on practical training and community health initiatives</li>
            </ul>
            <h3>Popular Programs</h3>
            <ul>
                <li>B.Pharm (Bachelor of Pharmacy)</li>
                <li>M.Pharm in Pharmaceutics, Quality Assurance, Pharmaceutical Chemistry, Pharmacology</li>
                <li>Ph.D. in Pharmaceutical Sciences</li>
            </ul>
            <h3>Campus Life</h3>
            <p>
                Students at the Institute of Pharmacy enjoy a vibrant campus life with access to modern amenities, seminars, workshops, and co-curricular activities. The institute encourages innovation, research, and holistic development through various student-driven initiatives.
            </p>
        </div>
        <div class="institute-contact">
            <h4>Contact Information</h4>
            <p><strong>Website:</strong> <a href="https://skpcper.guni.ac.in" target="_blank">skpcper.guni.ac.in</a></p>
            <p><strong>Email:</strong> info.pharmacy@ganpatuniversity.ac.in</p>
            <p><strong>Phone:</strong> +91-2762-286080</p>
            <p><strong>Address:</strong> Ganpat University Campus, Mehsana-Gozaria Highway, Mehsana, Gujarat, India</p>
        </div>
    </div>
</body>
</html>