<?php
session_start();
include 'config.php';

// Validate booking ID
if (!isset($_GET['booking_id'])) {
    die("Invalid request");
}

$booking_id = intval($_GET['booking_id']);

// Fetch booking details
$booking = $conn->query("SELECT * FROM bookings WHERE id=$booking_id")->fetch_assoc();
if (!$booking) die("Booking not found");

$amount = $booking['fare'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay via QR Code</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* Card Style */
        .container {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            width: 350px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            animation: fadeSlide 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeSlide {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            margin-bottom: 10px;
            font-size: 26px;
            color: #dc3545;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        p.amount {
            font-size: 20px;
            margin: 15px 0;
            font-weight: bold;
            color: #333;
        }

        img {
            width: 200px;
            height: 200px;
            border: 3px solid #eee;
            border-radius: 10px;
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease-in-out;
        }

        img:hover {
            transform: scale(1.05);
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: #dc3545;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background: #dc3545;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        button:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .note {
            font-size: 14px;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Scan & Pay</h2>
        <p class="amount">Amount: ₹<?php echo $amount; ?></p>
        <img src="scanner.jpg" alt="QR Code">
        <p class="note">Use Paytm / GPay / PhonePe to complete payment</p>

        <form method="POST" action="ticket.php">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            <input type="text" name="transaction_id" placeholder="Enter Transaction ID (required)" required>
            <button type="submit">I Have Paid</button>
        </form>
    </div><br>


     <div class="container">
        <h2>Scan & Pay</h2>
        <p class="amount">Amount: ₹<?php echo $amount; ?></p>
        <img src="HarshalQR.jpg" alt="QR Code">
        <p class="note">Use Paytm / GPay / PhonePe to complete payment</p>

        <form method="POST" action="ticket.php">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            <input type="text" name="transaction_id" placeholder="Enter Transaction ID (required)" required>
            <button type="submit">I Have Paid</button>
        </form>
    </div>
</body>
</html>
