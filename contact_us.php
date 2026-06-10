<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Ganpat University</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: none;
            color: #111;
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
            max-width: 1000px;
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
        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 32px;
            letter-spacing: 1px;
        }
        .university-info {
            text-align: left;
            margin: 0 auto 40px;
            max-width: 800px;
            padding: 30px;
            background: #f8f8f8;
            border-radius: 12px;
        }
        .university-info h2 {
            color: #222;
            font-size: 1.6rem;
            margin-bottom: 20px;
        }
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }
        .contact-card {
            background: #f8f8f8;
            padding: 24px;
            border-radius: 10px;
            text-align: left;
        }
        .contact-card h3 {
            color: #222;
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
        .contact-card p {
            margin: 8px 0;
            font-size: 1.1rem;
            color: #444;
        }
        .team-section {
            margin-top: 50px;
        }
        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 30px;
        }
        .team-member {
            background: #f8f8f8;
            padding: 24px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .team-member:hover {
            transform: translateY(-5px);
        }
        .team-member img {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            margin-bottom: 15px;
            object-fit: cover;
        }
        .team-member h4 {
            color: #222;
            font-size: 1.2rem;
            margin: 10px 0 5px;
        }
        .team-member p {
            color: #666;
            font-size: 1rem;
            margin: 5px 0;
        }
        .map-section {
            margin-top: 40px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }
        .map-section iframe {
            width: 100%;
            height: 400px;
            border: none;
        }
        @media (max-width: 768px) {
            .contact-grid, .team-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-fluid">
        <?php include 'includes/navbar.php'; ?>
    </div>

    <div class="container">
        <h1 class="page-title">Contact Us</h1>

        <div class="university-info">
            <h2>About Ganpat University</h2>
            <p>Ganpat University is a premier institution dedicated to excellence in education, research, and innovation. Established in 2005, the university has grown to become one of Gujarat's leading educational institutions, offering diverse programs across multiple disciplines.</p>
        </div>

        <div class="contact-grid">
            <div class="contact-card">
                <h3>Main Campus Address</h3>
                <p>Ganpat University</p>
                <p>Ganpat Vidyanagar, Mehsana-Gozaria Highway</p>
                <p>Mehsana - 384012, Gujarat, India</p>
            </div>
            <div class="contact-card">
                <h3>Contact Information</h3>
                <p><strong>Phone:</strong> +91-2762-286080</p>
                <p><strong>Email:</strong> info@ganpatuniversity.ac.in</p>
                <p><strong>Website:</strong> <a href="https://www.ganpatuniversity.ac.in" target="_blank">www.ganpatuniversity.ac.in</a></p>
            </div>
        </div>

                <div class="team-section">
            <h2>Meet The Developers</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="images/vraj_patel.jpg" alt="Vraj Patel">
                    <h4>Vraj Patel</h4>
                    <p>Lead Developer</p>
                    <p>Diploma Information Technology</p>
                    <p>23171371120</p>
                </div>
                </div>
            </div>
        </div>

        <div class="map-section">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14632.002613687539!2d72.44032865351012!3d23.53247890969875!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395c476c5013fd03%3A0xa1fe01d9ab30482!2sGanpat%20University%20(GUNI)%2C%20India!5e0!3m2!1sen!2sin!4v1756399159424!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>        </div>
    </div>
</body>
</html>
