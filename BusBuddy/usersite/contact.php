<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Bus Management System</title>
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
            animation: fadeBody 0.6s ease-in;
        }
        @keyframes fadeBody {
            from { opacity: 0; }
            to { opacity: 1; }
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
            z-index: 1000;
            transform: translateY(-100%);
            animation: slideNav 0.6s ease forwards;
        }
        @keyframes slideNav {
            to { transform: translateY(0); }
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

        /* HEADER SECTION */
        .header {
            text-align: center;
            padding: 60px 20px;
            background: #ffebee;
            animation: fadeIn 1s ease-in-out;
        }
        .header h1 {
            font-size: 36px;
            color: #d32f2f;
            margin-bottom: 10px;
            animation: popIn 0.8s ease-in-out;
        }
        .header p {
            color: #555;
            font-size: 18px;
        }

        /* CONTACT CONTENT */
        .contact-container {
            max-width: 700px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            animation: slideUp 1s ease-in-out;
        }
        .contact-container h2 {
            color: #d32f2f;
            margin-bottom: 15px;
            text-align: center;
        }
        .contact-container p {
            margin: 10px 0;
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            text-align: center;
        }

        /* MAP */
        .map {
            margin: 40px auto;
            max-width: 1000px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            animation: fadeIn 1s ease-in-out;
        }
        iframe {
            width: 100%;
            height: 350px;
            border: none;
        }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: white;
            margin-top: 40px;
            animation: fadeFooter 1s ease-in;
        }

        /* ANIMATIONS */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes popIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes fadeFooter {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
    <h1>Contact Us</h1>
    <p>Get in touch with our team for support or inquiries</p>
</div>

<!-- CONTACT DETAILS ONLY -->
<div class="contact-container">
    <h2>Our Office</h2>
    <p><strong>Location:</strong> Ahmednagar, Maharashtra, India</p>
    <p><strong>Email:</strong> support@busmanagement.com</p>
    <p><strong>Phone:</strong> +91 80104 14120</p>
    <p><strong>Phone:</strong> +91 96993 45059</p>
    <p><strong>Phone:</strong> +91 87674 50204</p>
    <p>We are here to assist you with any questions related to bookings, routes, or feedback.</p>
</div>

<!-- MAP (Ahmednagar) -->
<div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.7412100887774!2d74.73366307496546!3d19.094826151468465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bdc9c15dcf2f3a5%3A0x5c83a8f96d6e95f4!2sAhmednagar%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1706509462513!5m2!1sen!2sin" allowfullscreen="" loading="lazy"></iframe>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Bus Management System | All Rights Reserved</p>
</footer>

</body>
</html>
<p><strong>Phone:</strong> +91 87674 50204</p>