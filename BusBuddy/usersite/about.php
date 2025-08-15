<?php
include 'config.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Bus Management System</title>
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

        /* CONTENT SECTION */
        .content {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            animation: slideUp 1s ease-in-out;
        }
        .content h2 {
            color: #d32f2f;
            margin-bottom: 20px;
            text-align: center;
        }
        .content p {
            line-height: 1.8;
            color: #444;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .content .mission,
        .content .vision {
            margin-bottom: 30px;
            background: #fff8f8;
            padding: 15px;
            border-left: 5px solid #d32f2f;
            border-radius: 5px;
            transition: 0.3s;
            opacity: 0;
            animation: fadeInUp 0.8s forwards;
        }
        .content .mission { animation-delay: 0.2s; }
        .content .vision { animation-delay: 0.4s; }
        .content .mission:hover,
        .content .vision:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* TEAM SECTION */
        .team {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .team-member {
            background: #fff8f8;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeInUp 1s forwards;
        }
        .team-member:nth-child(1) { animation-delay: 0.2s; }
        .team-member:nth-child(2) { animation-delay: 0.4s; }
        .team-member:nth-child(3) { animation-delay: 0.6s; }

        .team-member:hover {
            transform: scale(1.05) rotate(1deg);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .team-member h3 {
            margin-top: 10px;
            color: #d32f2f;
        }
        .team-member p {
            font-size: 14px;
            color: #555;
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
        @keyframes fadeFooter {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
        @keyframes fadeInUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* RESPONSIVE */
        @media (max-width: 600px) {
            nav { flex-direction: column; }
            nav ul { margin-top: 10px; flex-wrap: wrap; gap: 10px; }
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
    <h1>About Us</h1>
    <p>Know more about our vision, mission, and the team behind this platform</p>
</div>

<!-- CONTENT -->
<div class="content">
    <h2>Who We Are</h2>
    <p>
        Our Bus Management System is designed to simplify bus travel by offering a seamless booking experience.
        From searching buses to booking and managing tickets, we provide a user-friendly platform with accurate and real-time information.
    </p>

    <div class="mission">
        <h3>Our Mission</h3>
        <p>To revolutionize public transport booking by providing an easy, reliable, and affordable platform for all passengers.</p>
    </div>

    <div class="vision">
        <h3>Our Vision</h3>
        <p>To become the leading bus ticket booking platform ensuring comfort and trust for millions of travelers.</p>
    </div>

    <h2>Our Team</h2>
    <div class="team">
        <div class="team-member">
            <h3>Pramod Kadnar</h3>
            <p>Founder & Lead Developer</p>
        </div>
        <div class="team-member">
            <h3>Devesh Nehete</h3>
            <p>Frontend Designer</p>
        </div>
        <div class="team-member">
            <h3>Harshal Bhamre</h3>
            <p>Designer and PPT</p>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Bus Management System | All Rights Reserved</p>
</footer>

</body>
</html>
