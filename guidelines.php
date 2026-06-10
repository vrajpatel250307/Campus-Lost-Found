<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guidelines - Campus Lost and Found</title>
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
        .intro-section {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 5px solid #111;
        }
        .intro-section h2 {
            color: #111;
            margin-bottom: 15px;
            font-size: 1.4rem;
        }
        .section {
            margin-bottom: 40px;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }
        .section-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #111;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        .section-subtitle {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin: 25px 0 15px 0;
        }
        .guideline-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        .guideline-list li {
            padding: 15px 20px;
            margin: 10px 0;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #111;
            transition: all 0.3s ease;
        }
        .guideline-list li:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }
        .guideline-list li strong {
            color: #111;
        }
        .do-dont-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 20px 0;
        }
        .do-section, .dont-section {
            padding: 25px;
            border-radius: 10px;
        }
        .do-section {
            background: #d4edda;
            border-left: 5px solid #28a745;
        }
        .dont-section {
            background: #f8d7da;
            border-left: 5px solid #dc3545;
        }
        .do-section h4 {
            color: #155724;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        .dont-section h4 {
            color: #721c24;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        .do-section ul, .dont-section ul {
            list-style: none;
            padding: 0;
        }
        .do-section li {
            padding: 8px 0;
            color: #155724;
        }
        .dont-section li {
            padding: 8px 0;
            color: #721c24;
        }
        .do-section li:before {
            content: "✓ ";
            font-weight: bold;
            color: #28a745;
        }
        .dont-section li:before {
            content: "✗ ";
            font-weight: bold;
            color: #dc3545;
        }
        .highlight-box {
            background: #111;
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
            text-align: center;
        }
        .highlight-box h3 {
            margin-top: 0;
            font-size: 1.3rem;
        }
        .safety-tips {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
        }
        .safety-tips h4 {
            color: #856404;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        .safety-tips ul {
            color: #856404;
        }
        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .quick-link {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .quick-link:hover {
            background: #e9ecef;
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .quick-link a {
            text-decoration: none;
            color: #111;
            font-weight: 600;
        }
        .quick-link p {
            margin: 10px 0 0 0;
            font-size: 0.9rem;
            color: #666;
        }
        .footer-cta {
            background: #111;
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-top: 40px;
        }
        .footer-cta h3 {
            margin-top: 0;
            font-size: 1.4rem;
        }
        .footer-cta a {
            color: white;
            text-decoration: underline;
        }
        .footer-cta a:hover {
            text-decoration: none;
        }
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
            .do-dont-grid, .quick-links {
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
        <h1 class="page-title">Guidelines & Best Practices</h1>
        
        <div class="intro-section">
            <h2>Welcome to the Campus Lost and Found Guidelines</h2>
            <p>These guidelines will help you effectively use our system to report, find, and return lost items. Following these best practices ensures a better experience for everyone in our campus community.</p>
        </div>

        <!-- General Guidelines -->
        <div class="section">
            <h2 class="section-title">General Guidelines</h2>
            
            <h3 class="section-subtitle">Account Requirements</h3>
            <ul class="guideline-list">
                <li><strong>Valid University Email:</strong> Use your official university email address for registration and verification.</li>
                <li><strong>Accurate Information:</strong> Provide correct personal details including name, enrollment number, and contact information.</li>
                <li><strong>Profile Photo:</strong> Upload a clear photo of your college ID card for verification purposes.</li>
                <li><strong>Keep Information Updated:</strong> Regularly update your contact details to ensure you receive important notifications.</li>
            </ul>

            <h3 class="section-subtitle">System Usage</h3>
            <ul class="guideline-list">
                <li><strong>One Account Per Person:</strong> Create only one account per individual to avoid confusion and duplicate reports.</li>
                <li><strong>Respectful Communication:</strong> Maintain professional and courteous communication with other users.</li>
                <li><strong>Honest Reporting:</strong> Only report items that are genuinely lost or found - false reports waste everyone's time.</li>
                <li><strong>Timely Updates:</strong> Mark items as found or returned promptly to keep the database current.</li>
            </ul>
        </div>

        <!-- Reporting Lost Items -->
        <div class="section">
            <h2 class="section-title">Reporting Lost Items</h2>
            
            <h3 class="section-subtitle">Before You Report</h3>
            <ul class="guideline-list">
                <li><strong>Double-Check:</strong> Thoroughly search your usual locations before reporting an item as lost.</li>
                <li><strong>Contact Recent Locations:</strong> Call places you recently visited to check if your item was turned in.</li>
                <li><strong>Check with Friends:</strong> Ask friends or classmates if they've seen your item.</li>
                <li><strong>Review Campus Lost & Found:</strong> Browse existing found items to see if your item is already listed.</li>
            </ul>

            <h3 class="section-subtitle">Creating Your Report</h3>
            <ul class="guideline-list">
                <li><strong>Detailed Description:</strong> Include brand, model, color, size, and any unique identifying features.</li>
                <li><strong>Clear Photos:</strong> If available, upload high-quality photos of similar items or your item from before it was lost.</li>
                <li><strong>Precise Location:</strong> Specify exactly where you think you lost the item (building, room number, area).</li>
                <li><strong>Accurate Date/Time:</strong> Provide the most accurate date and time when you last had the item.</li>
                <li><strong>Contact Information:</strong> Ensure your contact details are current for potential match notifications.</li>
            </ul>
        </div>

        <!-- Reporting Found Items -->
        <div class="section">
            <h2 class="section-title">Reporting Found Items</h2>
            
            <h3 class="section-subtitle">What to Do When You Find Something</h3>
            <ul class="guideline-list">
                <li><strong>Secure the Item:</strong> Keep the found item in a safe place until the owner is located.</li>
                <li><strong>Don't Search Personal Items:</strong> Avoid going through wallets, bags, or phones to find identification.</li>
                <li><strong>Report Quickly:</strong> Submit your found item report as soon as possible while details are fresh.</li>
                <li><strong>Consider Campus Security:</strong> For valuable items, consider turning them in to campus security as well.</li>
            </ul>

            <h3 class="section-subtitle">Creating Found Item Reports</h3>
            <ul class="guideline-list">
                <li><strong>Comprehensive Photos:</strong> Take multiple clear photos from different angles.</li>
                <li><strong>Detailed Description:</strong> Describe all visible features, condition, and any identifying marks.</li>
                <li><strong>Exact Location Found:</strong> Note precisely where the item was discovered.</li>
                <li><strong>Safe Storage:</strong> Mention where you're keeping the item safe for the owner.</li>
                <li><strong>Response Availability:</strong> Indicate your availability for coordination with potential owners.</li>
            </ul>
        </div>

        <!-- Do's and Don'ts -->
        <div class="section">
            <h2 class="section-title">Do's and Don'ts</h2>
            
            <div class="do-dont-grid">
                <div class="do-section">
                    <h4>✓ DO</h4>
                    <ul>
                        <li>Provide accurate and detailed descriptions</li>
                        <li>Upload clear, high-quality photos</li>
                        <li>Respond promptly to match notifications</li>
                        <li>Meet in safe, public campus locations</li>
                        <li>Verify item ownership before returning</li>
                        <li>Update your reports when items are resolved</li>
                        <li>Be patient - finding matches takes time</li>
                        <li>Report suspicious activity to security</li>
                    </ul>
                </div>
                
                <div class="dont-section">
                    <h4>✗ DON'T</h4>
                    <ul>
                        <li>Share personal contact details publicly</li>
                        <li>Meet strangers in isolated locations</li>
                        <li>Give items to unverified claimants</li>
                        <li>Create multiple accounts</li>
                        <li>Post fake or misleading reports</li>
                        <li>Use the system for non-university items</li>
                        <li>Ignore match notifications</li>
                        <li>Leave found items unattended</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Safety Guidelines -->
        <div class="section">
            <h2 class="section-title">Safety & Security</h2>
            
            <div class="safety-tips">
                <h4>🛡️ Safety First</h4>
                <ul>
                    <li>Always meet in well-lit, public areas on campus</li>
                    <li>Bring a friend when meeting to exchange items</li>
                    <li>Verify the person's identity before handing over items</li>
                    <li>Trust your instincts - if something feels wrong, contact security</li>
                    <li>Don't share personal information like home address or phone number publicly</li>
                </ul>
            </div>

            <h3 class="section-subtitle">Identity Verification</h3>
            <ul class="guideline-list">
                <li><strong>Ask for Student ID:</strong> Request to see the person's university ID card when meeting.</li>
                <li><strong>Verify Details:</strong> Ask the claimant to describe unique features of their item that aren't in your report.</li>
                <li><strong>Check University Email:</strong> Communicate through university email addresses when possible.</li>
                <li><strong>When in Doubt:</strong> If you're unsure about a claimant's identity, contact campus security for assistance.</li>
            </ul>
        </div>

        <!-- Communication Guidelines -->
        <div class="section">
            <h2 class="section-title">Communication Best Practices</h2>
            
            <h3 class="section-subtitle">When You Receive a Match Notification</h3>
            <ul class="guideline-list">
                <li><strong>Respond Promptly:</strong> Reply to match notifications within 24-48 hours.</li>
                <li><strong>Be Professional:</strong> Use polite and professional language in all communications.</li>
                <li><strong>Ask Verification Questions:</strong> Request specific details about the item to confirm ownership.</li>
                <li><strong>Coordinate Safely:</strong> Arrange meetings in public campus locations during daylight hours.</li>
            </ul>

            <h3 class="section-subtitle">Successful Item Returns</h3>
            <ul class="guideline-list">
                <li><strong>Confirm Identity:</strong> Verify the person's university ID and ask them to describe the item.</li>
                <li><strong>Document the Return:</strong> Take a photo of the successful return if possible.</li>
                <li><strong>Update Your Report:</strong> Mark your report as "Resolved" immediately after the return.</li>
                <li><strong>Follow Up:</strong> Both parties should update their reports to help keep the system current.</li>
            </ul>
        </div>

        <!-- System Features -->
        <div class="section">
            <h2 class="section-title">Making the Most of System Features</h2>
            
            <h3 class="section-subtitle">Search and Browse</h3>
            <ul class="guideline-list">
                <li><strong>Regular Browsing:</strong> Check found items regularly, even if you haven't lost anything recently.</li>
                <li><strong>Use Search Filters:</strong> Utilize category, location, and date filters to narrow down results.</li>
                <li><strong>Keywords:</strong> Search using different keywords that might describe your item.</li>
                <li><strong>Similar Items:</strong> Look at items that are similar to yours, not just exact matches.</li>
            </ul>

            <h3 class="section-subtitle">Notifications and Updates</h3>
            <ul class="guideline-list">
                <li><strong>Email Notifications:</strong> Ensure your email notifications are enabled and check them regularly.</li>
                <li><strong>Profile Updates:</strong> Keep your contact information current to receive important updates.</li>
                <li><strong>Report Management:</strong> Regularly review and update your active reports.</li>
                <li><strong>Status Changes:</strong> Promptly mark items as found, returned, or no longer needed.</li>
            </ul>
        </div>

        <div class="highlight-box">
            <h3>Remember: Community Effort</h3>
            <p>The success of our Lost and Found system depends on everyone's participation and honesty. By following these guidelines, you help create a trustworthy and effective service for the entire campus community.</p>
        </div>

        <div class="section">
            <h2 class="section-title">Quick Action Links</h2>
            
            <div class="quick-links">
                <div class="quick-link">
                    <a href="report_lost_item.php">Report Lost Item</a>
                    <p>Submit a detailed report for your lost item</p>
                </div>
                
                <div class="quick-link">
                    <a href="report_found_item.php">Report Found Item</a>
                    <p>Help someone by reporting what you found</p>
                </div>
                
                <div class="quick-link">
                    <a href="view_found_items.php">Browse Found Items</a>
                    <p>Check if your lost item has been found</p>
                </div>
                
                <div class="quick-link">
                    <a href="faq.php">FAQ</a>
                    <p>Find answers to common questions</p>
                </div>
            </div>
        </div>

        <div class="footer-cta">
            <h3>Need Help or Have Questions?</h3>
            <p>If you need assistance or have questions about these guidelines, don't hesitate to reach out.</p>
            <p><a href="contact_us.php">Contact Our Support Team</a> | <a href="faq.php">Check Our FAQ</a></p>
        </div>
    </div>
</body>
</html>