<?php
include 'config.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Bus Management System</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        /* RESET & BASE */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: #f5f5f5;
            scroll-behavior: smooth;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* NAVBAR */
        nav {
            background: #d32f2f;
            color: #fff;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
        }
        nav .logo {
            font-size: 24px;
            font-weight: bold;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }
        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: 0.3s;
        }
        nav ul li a:hover {
            color: #ffccbc;
        }

        /* HEADER */
        .header {
            text-align: center;
            padding: 50px 20px;
            background: #ffebee;
            animation: fadeIn 1s ease-in-out;
        }
        .header h1 {
            color: #d32f2f;
            margin-bottom: 10px;
        }
        .header p {
            color: #555;
            font-size: 16px;
        }

        /* FAQ CONTAINER */
        .faq-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
        }

        /* FAQ ITEM */
        .faq-item {
            background: white;
            border-radius: 8px;
            margin-bottom: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .faq-question {
            padding: 15px;
            cursor: pointer;
            background: #fff8f8;
            border-left: 5px solid #d32f2f;
            font-weight: 500;
            color: #d32f2f;
            position: relative;
        }
        .faq-question::after {
            content: '+';
            position: absolute;
            right: 20px;
            font-size: 18px;
            transition: transform 0.3s;
        }
        .faq-item.active .faq-question::after {
            transform: rotate(45deg);
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            background: #fff;
            padding: 0 15px;
            color: #444;
            font-size: 14px;
            transition: max-height 0.4s ease;
        }
        .faq-item.active .faq-answer {
            max-height: 200px;
            padding: 15px;
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: white;
            margin-top: auto;
        }

        /* ANIMATIONS */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav>
    <div class="logo">Bus Management</div>
    <ul>
        <?php if(isset($_SESSION['user_id'])): ?>
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="rateus.php">Rate Us</a></li>
            <li>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="index.php">Home</a></li>
            <li><a href="routes.php">Routes</a></li>
            <li><a href="login.php">Log In</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>


    <!-- HEADER -->
    <div class="header">
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to common questions about our bus management system</p>
    </div>

    <!-- FAQ SECTION -->
    <div class="faq-container">
        <div class="faq-item">
            <div class="faq-question">How do I book a bus ticket?</div>
            <div class="faq-answer">
                <p>Go to the Routes page, select your route, and proceed with booking. You'll receive a confirmation email after payment.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Can I cancel or modify my booking?</div>
            <div class="faq-answer">
                <p>Yes, cancellations and modifications are allowed up to 24 hours before departure. A small cancellation fee may apply.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Do you provide refund for canceled tickets?</div>
            <div class="faq-answer">
                <p>Refunds are processed within 3-5 working days to the original payment method, based on our refund policy.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Are there discounts for students or senior citizens?</div>
            <div class="faq-answer">
                <p>Yes, we provide special discounts. Please upload your valid ID during booking to avail the offer.</p>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">Is my payment secure?</div>
            <div class="faq-answer">
                <p>Yes, all payments are processed through secure gateways using encryption to ensure your data is safe.</p>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>&copy; 2025 Bus Management System | All Rights Reserved</p>
    </footer>

    <script>
        // Accordion toggle logic
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            item.querySelector('.faq-question').addEventListener('click', () => {
                item.classList.toggle('active');
            });
        });
    </script>

</body>
</html>
