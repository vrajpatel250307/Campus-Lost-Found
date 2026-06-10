<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Lost and Found - Ganpat University</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
        }

        .hero-section {
            background: linear-gradient(135deg, #111 0%, #333 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('images/campus.jpg') center/cover;
            opacity: 0.1;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .cta-btn {
            padding: 15px 30px;
            background: rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.2);
        }

        .cta-btn:hover {
            background: white;
            color: #111;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 50px;
            color: #111;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #111 0%, #555 100%);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #111 0%, #444 100%);
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #111;
        }

        .card p {
            color: #666;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .card-btn {
            background: #111;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .card-btn:hover {
            background: #333;
            transform: scale(1.05);
        }

        .stats-section {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            margin: 60px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            text-align: center;
        }

        .stat-item {
            padding: 20px;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            color: #666;
            font-weight: 500;
        }

        .university-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 60px 40px;
            margin: 60px 0;
        }

        .university-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .university-content h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: #111;
        }

        .university-content p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.8;
        }

        .university-features {
            list-style: none;
            margin: 30px 0;
        }

        .university-features li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            color: #555;
            font-size: 1.05rem;
        }

        .university-features li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .university-image {
            text-align: center;
        }

        .university-image img {
            max-width: 100%;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .features-section {
            margin: 80px 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 30px 25px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .feature-card h4 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #111;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        .footer-cta {
            background: linear-gradient(135deg, #111 0%, #333 100%);
            color: white;
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            margin-top: 80px;
        }

        .footer-cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .footer-cta p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .footer-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .footer-btn {
            padding: 15px 30px;
            background: rgba(255,255,255,0.1);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .footer-btn:hover {
            background: white;
            color: #111;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .cards-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .university-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .main-content {
                padding: 40px 15px;
            }
            
            .stats-section, .university-section, .footer-cta {
                padding: 40px 20px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container-fluid">
        <?php include 'includes/navbar.php'; ?>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Campus Lost & Found</h1>
            <p class="hero-subtitle">Your trusted platform to reunite lost items with their owners. Join thousands of students who have successfully found their belongings through our smart matching system.</p>
            <div class="cta-buttons">
                <a href="report_lost_item.php" class="cta-btn">📱 Report Lost Item</a>
                <a href="report_found_item.php" class="cta-btn">🔍 Report Found Item</a>
                <a href="view_found_items.php" class="cta-btn">👀 Browse Items</a>
            </div>
        </div>
    </section>

    <main class="main-content">
        <!-- Quick Actions Cards -->
        <section>
            <h2 class="section-title">How Can We Help You Today?</h2>
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon">📱</div>
                    <h3>Lost Something?</h3>
                    <p>Report your lost item with detailed description and photos. Our smart system will automatically search for matches and notify you when potential matches are found.</p>
                    <a href="report_lost_item.php" class="card-btn">Report Lost Item</a>
                </div>
                
                <div class="card">
                    <div class="card-icon">🔍</div>
                    <h3>Found Something?</h3>
                    <p>Help your fellow students by reporting found items. Upload clear photos and descriptions to help owners identify their belongings quickly and easily.</p>
                    <a href="report_found_item.php" class="card-btn">Report Found Item</a>
                </div>
                
                <div class="card">
                    <div class="card-icon">👀</div>
                    <h3>Browse Lost Items</h3>
                    <p>Search through our database of found items. Use filters by category, location, and date to quickly find what you're looking for. Updated in real-time.</p>
                    <a href="view_found_items.php" class="card-btn">Browse Items</a>
                </div>
            </div>
        </section>

        <!-- Statistics Section -->
        <section class="stats-section">
            <h2 class="section-title">Our Impact in Numbers</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Items Reunited</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Success Rate</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">2,000+</div>
                    <div class="stat-label">Active Users</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">System Availability</div>
                </div>
            </div>
        </section>

        <!-- University Section -->
        <section class="university-section">
            <div class="university-grid">
                <div class="university-content">
                    <h2>About Ganpat University</h2>
                    <p>Ganpat University is a premier educational institution established in 2005, located in Mehsana, Gujarat. With over 15,000 students across multiple disciplines, we are committed to excellence in education, research, and innovation.</p>
                    <p>Our Lost & Found system serves the entire university community, connecting students, faculty, and staff through technology to solve everyday problems and build a more connected campus community.</p>
                    <ul class="university-features">
                        <li>15+ Years of Educational Excellence</li>
                        <li>100+ Academic Programs</li>
                        <li>State-of-the-art Campus Facilities</li>
                        <li>Industry-Connected Learning</li>
                        <li>Research & Innovation Centers</li>
                        <li>Global Alumni Network</li>
                    </ul>
                    <a href="https://www.ganpatuniversity.ac.in" target="_blank" class="card-btn">Visit University Website</a>
                </div>
                <div class="university-image">
                    <img src="images/campus.jpg" alt="Ganpat University Campus" style="width: 100%; height: 300px; object-fit: cover;">
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <h2 class="section-title">Why Choose Our Platform?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🤖</div>
                    <h4>Smart Matching</h4>
                    <p>Our AI-powered system automatically matches lost and found items based on descriptions, locations, and timestamps.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📧</div>
                    <h4>Instant Notifications</h4>
                    <p>Get notified immediately when potential matches are found. Stay updated with email alerts and in-app notifications.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h4>Secure & Private</h4>
                    <p>Your personal information is protected. Contact details are shared only when there's a verified match.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h4>Mobile Friendly</h4>
                    <p>Access the platform from any device. Responsive design ensures great experience on phones, tablets, and desktops.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h4>Fast & Reliable</h4>
                    <p>Lightning-fast search and upload capabilities with 99.9% uptime. Your reports are processed instantly.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h4>Location-Based</h4>
                    <p>Find items based on specific campus locations. Detailed maps and building-specific search filters available.</p>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="footer-cta">
            <h2>Ready to Get Started?</h2>
            <p>Join thousands of students who trust our platform to reunite them with their lost belongings. It's free, secure, and designed specifically for our university community.</p>
            <div class="footer-buttons">
                <?php if (!isset($_SESSION['email'])): ?>
                    <a href="register_student.php" class="footer-btn">🎓 Register Now</a>
                    <a href="login.php" class="footer-btn">🔑 Login</a>
                <?php else: ?>
                    <a href="dashboard.php" class="footer-btn">📊 My Dashboard</a>
                    <a href="profile.php" class="footer-btn">👤 My Profile</a>
                <?php endif; ?>
                <a href="contact_us.php" class="footer-btn">📞 Contact Support</a>
            </div>
        </section>
    </main>

    <script>
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all cards and sections
        document.querySelectorAll('.card, .feature-card, .stat-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        // Counter animation for statistics
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target + (element.textContent.includes('%') ? '%' : '+');
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current) + (element.textContent.includes('%') ? '%' : '+');
                }
            }, 20);
        }

        // Trigger counter animation when stats section is visible
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.stat-number');
                    counters.forEach(counter => {
                        const target = parseInt(counter.textContent);
                        animateCounter(counter, target);
                    });
                    statsObserver.unobserve(entry.target);
                }
            });
        });

        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }
    </script>

    <!-- Footer -->
    <footer style="background: #111; color: #fff; text-align: center; padding: 20px 0; margin-top: 40px;">
        <p style="margin: 0; font-size: 14px; opacity: 0.8;">
            © 2025 Campus Lost and Found - Ganpat University. All Rights Reserved.
        </p>
    </footer>
</body>
</html>

