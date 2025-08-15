<?php
session_start();
include 'config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Handle rating submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stars = intval($_POST['stars']);
    $feedback = trim($_POST['feedback']);

    if ($stars >= 1 && $stars <= 5) {
        $stmt = $conn->prepare("INSERT INTO ratings (user_id, stars, feedback) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $stars, $feedback);
        if ($stmt->execute()) {
            $message = "Thank you for your feedback!";
        } else {
            $message = "Error saving rating. Please try again.";
        }
        $stmt->close();
    } else {
        $message = "Please select a valid star rating.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rate Us - Bus Management</title>
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
        color: #333;
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

    /* HEADER */
    .header {
        text-align: center;
        padding: 30px 20px;
        background: #ffebee;
        animation: fadeIn 1s ease-in-out;
    }
    .header h1 {
        color: #d32f2f;
        margin-bottom: 10px;
        animation: popIn 0.8s ease-in-out;
    }
    .header p {
        color: #555;
    }

    /* RATING FORM */
    .rating-container {
        max-width: 450px;
        margin: 30px auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        animation: slideUp 1s ease-in-out;
    }
    .stars {
        display: flex;
        justify-content: center;
        gap: 5px;
        font-size: 30px;
        margin-bottom: 15px;
        cursor: pointer;
    }
    .stars input {
        display: none;
    }
    .stars label {
        color: #ccc;
        transition: color 0.3s;
    }
    .stars input:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label {
        color: #ff9800;
    }
    textarea {
        width: 100%;
        height: 80px;
        resize: none;
        margin-bottom: 15px;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button {
        width: 100%;
        padding: 10px;
        border: none;
        background: #d32f2f;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }
    button:hover {
        background: #b71c1c;
    }
    .message {
        text-align: center;
        margin-top: 10px;
        color: green;
        animation: fadeIn 0.5s ease-in;
    }

    /* FOOTER */
    footer {
        text-align: center;
        padding: 20px;
        background: #333;
        color: white;
        margin-top: 30px;
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
            <li><a href="routes.php">Routes</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="rateus.php">Rate Us</a></li>
            <li>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Log In</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

<!-- HEADER -->
<div class="header">
    <h1>Rate Our Service</h1>
    <p>We value your feedback. Please rate your experience.</p>
</div>

<!-- RATING FORM -->
<div class="rating-container">
    <?php if ($message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="stars">
            <input type="radio" name="stars" id="star5" value="5"><label for="star5">★</label>
            <input type="radio" name="stars" id="star4" value="4"><label for="star4">★</label>
            <input type="radio" name="stars" id="star3" value="3"><label for="star3">★</label>
            <input type="radio" name="stars" id="star2" value="2"><label for="star2">★</label>
            <input type="radio" name="stars" id="star1" value="1"><label for="star1">★</label>
        </div>

        <textarea name="feedback" placeholder="Write your feedback (optional)..."></textarea>
        <button type="submit">Submit Rating</button>
    </form>
</div>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Bus Management System | All Rights Reserved</p>
</footer>

</body>
</html>
