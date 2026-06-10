<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institute of Science - Ganpat University</title>
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
        .lost-found-section {
            margin-top: 48px;
            padding: 32px;
            background: #f8f8f8;
            border-radius: 12px;
        }
        .lost-found-section h3 {
            color: #222;
            margin-bottom: 24px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .table th, .table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .table th {
            background: #f4f4f4;
            font-weight: 600;
            color: #333;
        }
        .alert {
            padding: 16px;
            border-radius: 8px;
            background: #e3f2fd;
            color: #1565c0;
            margin-top: 16px;
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
                <li><a href="#">Report Lost Item</a></li>
                <li><a href="#">Find Lost Item</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register_student.php">Register</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <div class="institute-title">Institute of Science</div>
        <div class="institute-image">
            <img src="images/science_building.jpg" alt="Institute of Science Building">
        </div>
        <div class="institute-info">
            <p>
                The Institute of Science (MUIS) at Ganpat University is a premier institution dedicated to advancing scientific knowledge and fostering research excellence. Our institute provides a dynamic learning environment where students engage in cutting-edge research and practical applications of scientific principles. MUIS is committed to producing skilled scientists and researchers who contribute to scientific advancement and innovation.
            </p>
            <h3>Key Features</h3>
            <ul>
                <li>Advanced research laboratories with modern equipment</li>
                <li>Highly qualified faculty with extensive research experience</li>
                <li>Collaborations with national and international research institutions</li>
                <li>Regular scientific workshops, seminars, and conferences</li>
                <li>Focus on experimental learning and research methodology</li>
                <li>Strong industry connections for practical exposure</li>
            </ul>
            <h3>Programs Offered</h3>
            <ul>
                <li>B.Sc. in Chemistry</li>
                <li>B.Sc. in Physics</li>
                <li>B.Sc. in Mathematics</li>
                <li>M.Sc. in Chemistry (Organic/Inorganic/Physical/Analytical)</li>
                <li>M.Sc. in Physics (Electronics/Material Science)</li>
                <li>M.Sc. in Mathematics</li>
                <li>Ph.D. in Pure & Applied Sciences</li>
            </ul>
            <h3>Research Areas</h3>
            <ul>
                <li>Material Science and Nanotechnology</li>
                <li>Theoretical and Computational Physics</li>
                <li>Organic Synthesis and Drug Design</li>
                <li>Environmental Chemistry and Analysis</li>
                <li>Pure and Applied Mathematics</li>
                <li>Quantum Computing and Information Theory</li>
            </ul>
            <h3>Campus Life</h3>
            <p>
                Students at MUIS enjoy a vibrant academic environment with access to state-of-the-art facilities, research opportunities, and various scientific events. The institute promotes a culture of scientific inquiry and innovation through regular seminars, workshops, and research projects.
            </p>
        </div>
        <div class="institute-contact">
            <h4>Contact Information</h4>
            <p><strong>Website:</strong> <a href="https://muis.guni.ac.in" target="_blank">muis.guni.ac.in</a></p>
            <p><strong>Email:</strong> info.science@ganpatuniversity.ac.in</p>
            <p><strong>Phone:</strong> +91-2762-286080</p>
            <p><strong>Address:</strong> Ganpat University Campus, Mehsana-Gozaria Highway, Mehsana, Gujarat, India</p>
        </div
            ?>
        </div>
    </div>
</body>
</body>

</html>
