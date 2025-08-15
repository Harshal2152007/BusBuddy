<?php
session_start();
include 'config.php';

// Handle POST (payment confirmation)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);
    $transaction_id = $_POST['transaction_id'] ?? '';

    $stmt = $conn->prepare("UPDATE bookings SET status='booked', transaction_id=? WHERE id=?");
    $stmt->bind_param("si", $transaction_id, $booking_id);
    $stmt->execute();
    $stmt->close();

    header("Location: ticket.php?booking_id=".$booking_id);
    exit();
}

// Validate booking ID
if (!isset($_GET['booking_id'])) {
    die("Invalid request");
}

$booking_id = intval($_GET['booking_id']);
$booking = $conn->query("SELECT * FROM bookings WHERE id=$booking_id")->fetch_assoc();
if (!$booking) die("Booking not found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Ticket</title>
<link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: #f8f8f8;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        animation: fadeBg 1s ease-in-out forwards;
    }

    /* Card container */
    .ticket-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        width: 380px;
        padding: 25px;
        text-align: center;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    h2 {
        color: #d32f2f;
        margin-bottom: 15px;
        font-size: 26px;
    }

    .ticket-info {
        text-align: left;
        font-size: 16px;
    }

    .ticket-info p {
        margin: 8px 0;
        border-bottom: 1px solid #eee;
        padding-bottom: 4px;
    }

    .highlight {
        font-weight: bold;
        color: #444;
    }

    /* Buttons */
    .btn-container {
        margin-top: 20px;
    }
    .btn {
        text-decoration: none;
        background: #d32f2f;
        color: #fff;
        padding: 10px 18px;
        border-radius: 6px;
        font-weight: bold;
        transition: all 0.3s ease;
        margin: 5px;
        display: inline-block;
    }
    .btn:hover {
        background: #b71c1c;
        transform: scale(1.05);
    }

    /* Animations */
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeBg {
        0% { background-color: #ffffff; }
        100% { background-color: #f8f8f8; }
    }
</style>
</head>
<body>
    <div class="ticket-card">
        <h2>Bus Ticket</h2>
        <div class="ticket-info">
            <p><span class="highlight">Booking ID:</span> <?php echo $booking['id']; ?></p>
            <p><span class="highlight">Route:</span> <?php echo htmlspecialchars($booking['source']); ?> → <?php echo htmlspecialchars($booking['destination']); ?></p>
            <p><span class="highlight">Seats:</span> <?php echo htmlspecialchars($booking['seat_number']); ?></p>
            <p><span class="highlight">Date:</span> <?php echo htmlspecialchars($booking['booking_date']); ?></p>
            <p><span class="highlight">Total Fare:</span> ₹<?php echo htmlspecialchars($booking['fare']); ?></p>
            <p><span class="highlight">Status:</span> <?php echo ucfirst($booking['status']); ?></p>
            <?php if (!empty($booking['transaction_id'])): ?>
                <p><span class="highlight">Transaction ID:</span> <?php echo htmlspecialchars($booking['transaction_id']); ?></p>
            <?php endif; ?>
        </div>

        <div class="btn-container">
            <a href="index.php" class="btn">Back to Home</a>
            <a href="#" class="btn" onclick="window.print()">Print Ticket</a>
        </div>
    </div>
</body>
</html>
