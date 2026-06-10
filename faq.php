<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Campus Lost and Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
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
            font-size: 1.1rem;
            line-height: 1.6;
            color: #222;
        }
        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 32px;
            letter-spacing: 1px;
            text-align: center;
        }
        .intro-text {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            color: #555;
        }
        .faq-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .category-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .category-card:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            border-color: #111;
        }
        .category-card.active {
            background: #111;
            color: white;
        }
        .category-card h3 {
            margin: 0 0 10px 0;
            font-size: 1.2rem;
        }
        .category-card p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        .faq-section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #111;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        .faq-item {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .faq-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .faq-question {
            padding: 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: #333;
            border-radius: 8px;
            transition: background 0.3s ease;
        }
        .faq-question:hover {
            background: #f8f9fa;
        }
        .faq-question.active {
            background: #111;
            color: white;
            border-radius: 8px 8px 0 0;
        }
        .faq-toggle {
            font-size: 1.5rem;
            font-weight: bold;
            transition: transform 0.3s ease;
        }
        .faq-question.active .faq-toggle {
            transform: rotate(45deg);
        }
        .faq-answer {
            display: none;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 0 0 8px 8px;
            line-height: 1.7;
        }
        .faq-answer.show {
            display: block;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
            }
            to {
                opacity: 1;
                max-height: 200px;
            }
        }
        .search-box {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 1rem;
            margin-bottom: 30px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        .search-box:focus {
            outline: none;
            border-color: #111;
        }
        .no-results {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        .contact-cta {
            background: #111;
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-top: 40px;
        }
        .contact-cta h3 {
            margin-top: 0;
            font-size: 1.4rem;
        }
        .contact-cta a {
            color: white;
            text-decoration: underline;
        }
        .contact-cta a:hover {
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
            .faq-categories {
                grid-template-columns: 1fr;
            }
            .page-title {
                font-size: 1.8rem;
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
        <h1 class="page-title">Frequently Asked Questions</h1>
        
        <div class="intro-text">
            <p>Welcome to our FAQ section! Find answers to commonly asked questions about the Campus Lost and Found system. Use the search box below or browse by category.</p>
        </div>

        <input type="text" class="search-box" id="searchBox" placeholder="🔍 Search for answers..." onkeyup="searchFAQs()">

        <div class="faq-categories">
            <div class="category-card active" onclick="filterFAQs('all')">
                <h3>All Questions</h3>
                <p>Browse all FAQs</p>
            </div>
            <div class="category-card" onclick="filterFAQs('general')">
                <h3>General</h3>
                <p>Basic information</p>
            </div>
            <div class="category-card" onclick="filterFAQs('reporting')">
                <h3>Reporting Items</h3>
                <p>Lost & found reports</p>
            </div>
            <div class="category-card" onclick="filterFAQs('account')">
                <h3>Account</h3>
                <p>Profile & security</p>
            </div>
        </div>

        <div id="faqContainer">
            <!-- General Questions -->
            <div class="faq-section" data-category="general">
                <h2 class="section-title">General Information</h2>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>What is the Campus Lost and Found system?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>The Campus Lost and Found system is a digital platform designed to help Ganpat University students and staff report lost items and claim found items efficiently. It connects people who have lost items with those who have found them, making the recovery process quick and easy.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>Who can use this system?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>The system is available to all registered students and staff members of Ganpat University. You need to create an account using your university email address and enrollment/employee number to access the features.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>Is the service free to use?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, the Campus Lost and Found system is completely free to use for all university members. There are no charges for reporting lost items, posting found items, or using any other features of the platform.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>How secure is my personal information?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>We take privacy and security seriously. Your personal information is encrypted and stored securely. We only share necessary contact information between users when there's a potential match between lost and found items, and only with your consent.</p>
                    </div>
                </div>
            </div>

            <!-- Reporting Items -->
            <div class="faq-section" data-category="reporting">
                <h2 class="section-title">Reporting Lost & Found Items</h2>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>How do I report a lost item?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>To report a lost item: 1) Log into your account, 2) Click "Report Lost Item" from the Reports menu, 3) Fill out the detailed form including description, location where lost, date, and upload photos if available, 4) Submit the report. You'll receive email notifications when potential matches are found.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>How do I report a found item?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>To report a found item: 1) Log into your account, 2) Click "Report Found Item" from the Reports menu, 3) Provide detailed description, location where found, date found, and upload clear photos, 4) Submit the report. The system will automatically check for matches with existing lost item reports.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>What information should I include in my report?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Include as much detail as possible: item description, brand/model, color, size, distinctive features, exact location where lost/found, date and approximate time, and any unique identifiers. Photos are extremely helpful for identification. The more details you provide, the better chance of a successful match.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>Can I edit my report after submitting it?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, you can edit your reports through your dashboard. Go to "My Profile" and then view your submitted reports. You can update descriptions, add more photos, or mark items as resolved when they're found or returned.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>How long do reports stay active?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Reports remain active for 90 days by default. After this period, they are archived but can be reactivated if needed. You can manually close a report earlier if your item is found or returned through other means.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>What happens when there's a potential match?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>When the system identifies a potential match, both parties receive email notifications with contact details. You can then coordinate directly to verify the item and arrange for return. Always meet in safe, public locations on campus for exchanges.</p>
                    </div>
                </div>
            </div>

            <!-- Account Questions -->
            <div class="faq-section" data-category="account">
                <h2 class="section-title">Account & Profile</h2>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>How do I create an account?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Click "Register" on the login page and fill out the registration form with your university details including name, enrollment number, university email, personal email, department, and upload your college ID card for verification. Your account will be activated once verified.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>I forgot my password. How can I reset it?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Click "Forgot Password" on the login page, enter your email address, and you'll receive a password reset link. Follow the instructions in the email to create a new password. If you don't receive the email, check your spam folder or contact support.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>How can I update my profile information?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Log into your account, go to "My Profile" from the user menu, and click "Edit Profile". You can update your contact information, address, and upload a new ID card if needed. Note that enrollment numbers cannot be changed as they're used for verification.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>Can I change my email address?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, you can update both your personal and student email addresses in your profile settings. However, changes to your university email may require additional verification to ensure account security.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>How do I delete my account?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>To delete your account, please contact our support team through the Contact Us page. Note that deleting your account will remove all your reports and cannot be undone. Consider temporarily deactivating instead if you might return.</p>
                    </div>
                </div>
            </div>

            <!-- Technical Issues -->
            <div class="faq-section" data-category="technical">
                <h2 class="section-title">Technical Support</h2>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>I'm having trouble uploading photos. What should I do?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Ensure your photos are in JPG, PNG, or GIF format and under 5MB in size. Try reducing the image size or using a different browser. Clear your browser cache and cookies if the problem persists. Contact support if you continue experiencing issues.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>The website is loading slowly. What can I do?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Try refreshing the page, clearing your browser cache, or using a different browser. Check your internet connection. If the issue persists, it might be temporary server maintenance. Contact support if the problem continues for an extended period.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span>I'm not receiving email notifications. Why?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Check your spam/junk folder first. Ensure your email address in your profile is correct. Add our system email to your contacts or safe sender list. If you still don't receive emails, contact support to verify your notification settings.</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="noResults" class="no-results" style="display: none;">
            <p>No FAQs found matching your search. Try different keywords or browse by category.</p>
        </div>

        <div class="contact-cta">
            <h3>Still Have Questions?</h3>
            <p>Can't find the answer you're looking for? Our support team is here to help!</p>
            <p><a href="contact_us.php">Contact Us</a> for personalized assistance.</p>
        </div>
    </div>

    <script>
        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            const isActive = element.classList.contains('active');
            
            // Close all other FAQs
            document.querySelectorAll('.faq-question.active').forEach(q => {
                q.classList.remove('active');
                q.nextElementSibling.classList.remove('show');
            });
            
            // Toggle current FAQ
            if (!isActive) {
                element.classList.add('active');
                answer.classList.add('show');
            }
        }

        function filterFAQs(category) {
            // Update active category card
            document.querySelectorAll('.category-card').forEach(card => {
                card.classList.remove('active');
            });
            event.target.closest('.category-card').classList.add('active');
            
            // Show/hide FAQ sections
            const sections = document.querySelectorAll('.faq-section');
            let visibleSections = 0;
            
            sections.forEach(section => {
                if (category === 'all' || section.dataset.category === category) {
                    section.style.display = 'block';
                    visibleSections++;
                } else {
                    section.style.display = 'none';
                }
            });
            
            // Close all open FAQs when filtering
            document.querySelectorAll('.faq-question.active').forEach(q => {
                q.classList.remove('active');
                q.nextElementSibling.classList.remove('show');
            });
        }

        function searchFAQs() {
            const searchTerm = document.getElementById('searchBox').value.toLowerCase();
            const faqItems = document.querySelectorAll('.faq-item');
            const sections = document.querySelectorAll('.faq-section');
            let visibleItems = 0;
            
            sections.forEach(section => {
                section.style.display = 'block';
                let sectionHasVisible = false;
                
                const sectionItems = section.querySelectorAll('.faq-item');
                sectionItems.forEach(item => {
                    const question = item.querySelector('.faq-question span').textContent.toLowerCase();
                    const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                    
                    if (question.includes(searchTerm) || answer.includes(searchTerm) || searchTerm === '') {
                        item.style.display = 'block';
                        visibleItems++;
                        sectionHasVisible = true;
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                // Hide section if no items are visible
                if (!sectionHasVisible && searchTerm !== '') {
                    section.style.display = 'none';
                }
            });
            
            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            if (visibleItems === 0 && searchTerm !== '') {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
            
            // Reset category filter when searching
            if (searchTerm !== '') {
                document.querySelectorAll('.category-card').forEach(card => {
                    card.classList.remove('active');
                });
                document.querySelector('.category-card').classList.add('active');
            }
        }

        // Close FAQ when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.faq-item')) {
                document.querySelectorAll('.faq-question.active').forEach(q => {
                    q.classList.remove('active');
                    q.nextElementSibling.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>