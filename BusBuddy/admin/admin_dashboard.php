<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}
$admin_name = $_SESSION['admin_username'];

include 'config.php';

// Dynamic counts
$busCount = $conn->query("SELECT COUNT(*) AS total FROM buses")->fetch_assoc()['total'];
$routeCount = $conn->query("SELECT COUNT(*) AS total FROM routes")->fetch_assoc()['total'];
$bookingCount = $conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$userCount = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];

// Average rating
$avgRating = $conn->query("SELECT AVG(stars) AS avg_rating FROM ratings")->fetch_assoc()['avg_rating'];
$avgRating = $avgRating ? round($avgRating, 1) : 0;

// Total contact messages
$newMsgCount = $conn->query("SELECT COUNT(*) AS total FROM contact_messages")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(120deg, #1e3c72, #2a5298);
        color: #fff;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
    header {
        background: rgba(0,0,0,0.3);
        padding: 20px;
        text-align: center;
        font-size: 24px;
        letter-spacing: 1px;
        backdrop-filter: blur(6px);
        position: relative; /* Needed for clock positioning */
    }
    #clock {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 18px;
        font-weight: bold;
        background: rgba(255,255,255,0.2);
        padding: 5px 12px;
        border-radius: 8px;
    }
    .dashboard {
        flex: 1;
        display: flex;
        flex-direction: row;
    }
    .sidebar {
        width: 220px;
        background: rgba(0,0,0,0.25);
        backdrop-filter: blur(6px);
        display: flex;
        flex-direction: column;
        padding: 20px;
    }
    .sidebar h3 {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
        padding-bottom: 10px;
    }
    .sidebar a {
        text-decoration: none;
        color: #fff;
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
        transition: 0.3s ease;
    }
    .sidebar a:hover {
        background: rgba(255,255,255,0.2);
        transform: translateX(5px);
    }
    .content {
        flex: 1;
        padding: 30px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }
    .card {
        background: rgba(255,255,255,0.15);
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }
    .card h2 {
        font-size: 40px;
        margin: 10px 0;
    }
    .card p {
        margin: 0;
        font-size: 18px;
    }
    .logout {
        text-align: center;
        margin-top: auto;
    }
    .logout a {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 15px;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        background: #ff4b5c;
        transition: 0.3s ease;
    }
    .logout a:hover {
        background: #ff2e44;
    }
</style>
</head>
<body>
<header>
    Welcome, <?php echo htmlspecialchars($admin_name); ?> — Admin Dashboard
    <div id="clock"></div>
</header>

<div class="dashboard">
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <h3>Navigation</h3>
        <a href="manage_buses.php">Manage Buses and Routes</a> <!--here the manage routes can be given-->
        <a href="manage_bookings.php">Manage Bookings</a>
        <a href="manage_transactions.php">Manage Transactions</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_ratings.php">Manage Ratings</a>
        <a href="admin_messages.php">Contact Messages (<?php echo $newMsgCount; ?>)</a>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="content">
        <div class="card">
            <h2><?php echo $busCount; ?></h2>
            <p>Total Buses</p>
        </div>
        <div class="card">
            <h2><?php echo $routeCount; ?></h2>
            <p>Active Routes</p>
        </div>
        <div class="card">
            <h2><?php echo $bookingCount; ?></h2>
            <p>Bookings</p>
        </div>
        <div class="card">
            <h2><?php echo $userCount; ?></h2>
            <p>Registered Users</p>
        </div>
        <div class="card">
            <h2><?php echo $avgRating; ?>★</h2>
            <p>Average Rating</p>
        </div>
    </div>
</div>

<script>
function updateClock() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    document.getElementById('clock').textContent =' ${hours}:${minutes}:${seconds}';
}
setInterval(updateClock, 1000);
updateClock();
</script>

</body>
</html>