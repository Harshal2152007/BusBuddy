<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
include 'config.php';
$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Bus Management System</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        /* RESET & BASE */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            animation: fadeBg 0.8s ease-in;
        }
        @keyframes fadeBg {
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
            transform: translateY(-100%);
            animation: slideDown 0.6s ease forwards;
        }
        @keyframes slideDown {
            to { transform: translateY(0); }
        }
        nav .logo { font-size: 22px; font-weight: bold; }
        nav ul { list-style: none; display: flex; gap: 20px; }
        nav ul li a {
            color: #fff; text-decoration: none;
            transition: 0.3s;
        }
        nav ul li a:hover { color: #ffccbc; }

        /* DASHBOARD */
        .dashboard {
            flex: 1;
            padding: 40px 20px;
            max-width: 1000px;
            margin: auto;
            text-align: center;
            animation: fadeIn 0.8s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .dashboard h1 {
            margin-bottom: 20px;
            color: #d32f2f;
            animation: popUp 0.8s ease-out;
        }
        @keyframes popUp {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .dashboard p {
            color: #555;
            margin-bottom: 40px;
            font-size: 18px;
        }

        /* CARDS */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            opacity: 0;
            transform: translateY(20px);
            animation: cardFade 0.6s ease forwards;
        }
        .card:nth-child(1){ animation-delay: 0.3s; }
        .card:nth-child(2){ animation-delay: 0.5s; }
        .card:nth-child(3){ animation-delay: 0.7s; }
        @keyframes cardFade {
            to { opacity: 1; transform: translateY(0); }
        }
        .card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        .card h3 {
            margin-bottom: 10px;
            color: #d32f2f;
        }
        .card p {
            font-size: 14px;
            color: #666;
        }

        /* FOOTER */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: auto;
            animation: fadeUp 0.8s ease-in;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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

<!-- DASHBOARD -->
<div class="dashboard">
    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h1>
    <p>Manage your bookings, explore routes, and enjoy hassle-free travel.</p>

    <div class="cards">
        <div class="card" onclick="location.href='routes.php'">
            <h3>Book a Ticket</h3>
            <p>Search available routes and reserve your seats.</p>
        </div>
        <div class="card" onclick="location.href='my_bookings.php'">
            <h3>My Bookings</h3>
            <p>View and manage your current and past bookings.</p>
        </div>
        <div class="card" onclick="location.href='my_profile.php'">
            <h3>My Profile</h3>
            <p>Update personal details and account settings.</p>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Bus Management System | All Rights Reserved</p>
</footer>

</body>
</html>
