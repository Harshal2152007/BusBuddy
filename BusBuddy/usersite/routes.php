<?php
session_start();
include 'config.php';

// Disable caching so new admin data shows immediately
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");

// Capture search inputs
$fromQuery = isset($_GET['from']) ? trim($_GET['from']) : '';
$toQuery = isset($_GET['to']) ? trim($_GET['to']) : '';
$dateQuery = isset($_GET['date']) ? trim($_GET['date']) : '';

// Build SQL dynamically
$sql = "SELECT * FROM buses WHERE 1";
$params = [];
$types = "";

if ($fromQuery) {
    $sql .= " AND LOWER(source) = LOWER(?)";
    $params[] = $fromQuery;
    $types .= "s";
}
if ($toQuery) {
    $sql .= " AND LOWER(destination) = LOWER(?)";
    $params[] = $toQuery;
    $types .= "s";
}

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Buses - Bus Management</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif;}
        body{background:#f5f5f5;color:#333;overflow-x:hidden;}

        /* NAVBAR */
        nav{
            background:#d32f2f;color:#fff;padding:15px 40px;
            display:flex;justify-content:space-between;align-items:center;
            position:sticky;top:0;z-index:1000;
            transform:translateY(-100%);
            animation: navSlide 0.7s ease forwards;
        }
        @keyframes navSlide {
            to { transform: translateY(0); }
        }
        nav .logo{font-size:24px;font-weight:bold;}
        nav ul{list-style:none;display:flex;gap:25px;}
        nav ul li a{
            text-decoration:none;color:#fff;font-weight:500;transition:.3s;
            position:relative;
        }
        nav ul li a::after{
            content:"";position:absolute;width:0;height:2px;background:#ffccbc;
            left:0;bottom:-4px;transition:width .3s;
        }
        nav ul li a:hover{color:#ffccbc;}
        nav ul li a:hover::after{width:100%;}

        /* HEADER */
        .header{
            text-align:center;padding:30px 20px;background:#ffebee;
            animation: fadeScale 1s ease forwards;
        }
        @keyframes fadeScale {
            from{opacity:0;transform:scale(0.95);}
            to{opacity:1;transform:scale(1);}
        }
        .header h1{color:#d32f2f;margin-bottom:10px;}
        .header p{color:#555;}

        /* SEARCH BAR */
        .search-bar{
            display:flex;justify-content:center;gap:10px;padding:20px;flex-wrap:wrap;
            animation: fadeInUp 1s ease forwards;
        }
        @keyframes fadeInUp {
            from{opacity:0;transform:translateY(20px);}
            to{opacity:1;transform:translateY(0);}
        }
        .search-bar input,.search-bar button{
            padding:10px;border:1px solid #ccc;border-radius:5px;font-size:16px;
            transition:.3s;
        }
        .search-bar input:focus{border-color:#d32f2f;box-shadow:0 0 5px #d32f2f;}
        .search-bar input{width:200px;}
        .search-bar button{
            background:#d32f2f;color:white;border:none;cursor:pointer;
        }
        .search-bar button:hover{
            background:#b71c1c;
            transform:scale(1.05);
        }

        /* ROUTES CONTAINER + CARDS */
        .routes-container{
            display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
            gap:20px;padding:20px;max-width:1100px;margin:auto;
        }
        .card{
            background:white;padding:20px;border-radius:10px;
            box-shadow:0 2px 8px rgba(0,0,0,.1);
            transition:transform .3s ease, box-shadow .3s ease;
            opacity:0;transform:translateY(30px);
            animation: cardFade 0.6s ease forwards;
        }
        @keyframes cardFade {
            to {opacity:1;transform:translateY(0);}
        }
        .card:nth-child(1){animation-delay:0.1s;}
        .card:nth-child(2){animation-delay:0.2s;}
        .card:nth-child(3){animation-delay:0.3s;}
        .card:nth-child(4){animation-delay:0.4s;}
        .card:hover{
            transform:translateY(-5px) scale(1.02);
            box-shadow:0 6px 15px rgba(0,0,0,.2);
        }
        .card h3{color:#d32f2f;margin-bottom:10px;}
        .card p{font-size:14px;margin:4px 0;}

        /* BOOK BUTTON */
        .book-btn{
            display:inline-block;margin-top:10px;padding:10px 15px;
            background:#ff9800;color:#fff;text-decoration:none;border-radius:5px;
            transition:background .3s, transform .2s;
        }
        .book-btn:hover{
            background:#e68900;
            transform:scale(1.05);
        }

        /* FOOTER */
        footer{
            text-align:center;padding:20px;background:#333;color:white;margin-top:30px;
            opacity:0;animation: footerFade 1s ease forwards;
        }
        @keyframes footerFade {
            from {opacity:0;transform:translateY(20px);}
            to {opacity:1;transform:translateY(0);}
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
    <h1>Available Buses</h1>
    <?php if($fromQuery && $toQuery): ?>
        <p>Results for <b><?php echo htmlspecialchars($fromQuery); ?></b> to <b><?php echo htmlspecialchars($toQuery); ?></b> 
        <?php echo $dateQuery ? "on <b>".htmlspecialchars($dateQuery)."</b>" : ""; ?></p>
    <?php else: ?>
        <p>Browse all available buses below or search specific routes</p>
    <?php endif; ?>
</div>

<!-- SEARCH BAR -->
<div class="search-bar">
    <input type="text" id="source" placeholder="Source" value="<?php echo htmlspecialchars($fromQuery); ?>">
    <input type="text" id="destination" placeholder="Destination" value="<?php echo htmlspecialchars($toQuery); ?>">
    <input type="date" id="date" value="<?php echo htmlspecialchars($dateQuery); ?>">
    <button onclick="searchBus()">Search</button>
</div>

<!-- ROUTE CARDS -->
<div class="routes-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($row['bus_name']); ?></h3>
                <p><b>From:</b> <?php echo htmlspecialchars($row['source']); ?> → <b>To:</b> <?php echo htmlspecialchars($row['destination']); ?></p>
                <p><b>Departure:</b> <?php echo htmlspecialchars($row['departure_time']); ?> | <b>Arrival:</b> <?php echo htmlspecialchars($row['arrival_time']); ?></p>
                <p><b>Fare:</b> ₹<?php echo htmlspecialchars($row['price']); ?> | <b>Seats:</b> <?php echo htmlspecialchars($row['total_seats']); ?></p>
                <a class="book-btn" href="book_ticket.php?bus_id=<?php echo $row['id']; ?>&source=<?php echo urlencode($row['source']); ?>&destination=<?php echo urlencode($row['destination']); ?>&fare=<?php echo $row['price']; ?>&date=<?php echo urlencode($dateQuery); ?>">Book Now</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">No buses found for this route.</p>
    <?php endif; ?>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Bus Management System | All Rights Reserved</p>
</footer>

<script>
function searchBus() {
    let from = document.getElementById('source').value;
    let to = document.getElementById('destination').value;
    let date = document.getElementById('date').value;
    window.location.href = `routes.php?from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}&date=${encodeURIComponent(date)}`;
}
</script>

</body>
</html>
