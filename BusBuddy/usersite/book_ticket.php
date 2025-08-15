<?php
session_start();
include 'config.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ensure bus_id is provided
if (!isset($_GET['bus_id'])) {
    echo "Invalid request. No bus selected.";
    exit();
}

$bus_id = intval($_GET['bus_id']);
$user_id = $_SESSION['user_id'];
$message = "";

// Fetch bus details
$busQuery = $conn->prepare("SELECT * FROM buses WHERE id = ?");
$busQuery->bind_param("i", $bus_id);
$busQuery->execute();
$bus = $busQuery->get_result()->fetch_assoc();

if (!$bus) {
    echo "Bus not found.";
    exit();
}

// Fetch already booked seats for this bus
$bookedSeats = [];
$bookedQuery = $conn->prepare("SELECT seat_number FROM bookings WHERE bus_id = ? AND status = 'booked'");
$bookedQuery->bind_param("i", $bus_id);
$bookedQuery->execute();
$result = $bookedQuery->get_result();
while ($row = $result->fetch_assoc()) {
    $bookedSeats = array_merge($bookedSeats, explode(",", $row['seat_number']));
}

// Handle booking form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $seat_number = $_POST['seat_number'] ?? '';
    $booking_date = $_POST['booking_date'] ?? '';
    $fare = $_POST['fare'] ?? 0;

    if (empty($seat_number) || empty($booking_date)) {
        $message = "Please select seats and date.";
    } else {
        // Save booking with pending_payment
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, source, destination, fare, bus_id, seat_number, booking_date, status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, 'pending_payment')");
        $stmt->bind_param(
            "issdiss",
            $user_id,
            $bus['source'],
            $bus['destination'],
            $fare,
            $bus_id,
            $seat_number,
            $booking_date
        );

        if ($stmt->execute()) {
            $booking_id = $stmt->insert_id;
            // Redirect to QR payment page
            header("Location: qr_payment.php?booking_id=" . $booking_id);
            exit();
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Ticket</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #d32f2f;
        }
        .bus-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .bus-info p {
            margin: 5px 0;
            font-size: 16px;
        }
        .seat-layout {
            display: grid;
            grid-template-columns: repeat(4, 50px);
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
        }
        .seat {
            width: 50px;
            height: 50px;
            background: #ccc;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        .seat.selected {
            background: #4CAF50;
            color: white;
        }
        .seat.booked {
            background: #e53935;
            color: white;
            cursor: not-allowed;
        }
        .total-fare {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
            font-size: 18px;
        }
        input[type="date"], button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #d32f2f;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #b71c1c;
        }
        .message {
            text-align: center;
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Book Your Ticket</h2>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>

    <div class="bus-info">
        <p><b>Bus:</b> <?php echo htmlspecialchars($bus['bus_name']); ?></p>
        <p><b>Route:</b> <?php echo htmlspecialchars($bus['source']); ?> → <?php echo htmlspecialchars($bus['destination']); ?></p>
        <p><b>Fare per seat:</b> ₹<?php echo htmlspecialchars($bus['price']); ?></p>
    </div>

    <form method="POST">
        <!-- Seat layout -->
        <div class="seat-layout" id="seatLayout">
            <?php
            $totalSeats = $bus['total_seats'];
            for ($i = 1; $i <= $totalSeats; $i++):
                $seatNo = "S$i";
                $class = in_array($seatNo, $bookedSeats) ? "seat booked" : "seat";
                echo "<div class='$class' data-seat='$seatNo'>$seatNo</div>";
            endfor;
            ?>
        </div>

        <div class="total-fare">
            Selected Seats: <span id="selectedSeats">None</span><br>
            Total Fare: ₹<span id="totalFare">0</span>
        </div>

        <input type="hidden" name="seat_number" id="seatInput" required>
        <input type="hidden" name="fare" id="fareInput" value="<?php echo htmlspecialchars($bus['price']); ?>">
        <input type="date" name="booking_date" required>
        <button type="submit">Book & Pay</button>
    </form>
</div>

<script>
const seats = document.querySelectorAll('.seat');
const selectedSeatsEl = document.getElementById('selectedSeats');
const totalFareEl = document.getElementById('totalFare');
const seatInput = document.getElementById('seatInput');
const farePerSeat = parseFloat(document.getElementById('fareInput').value);

let selectedSeats = [];

seats.forEach(seat => {
    seat.addEventListener('click', () => {
        if (seat.classList.contains('booked')) return;

        seat.classList.toggle('selected');
        const seatNo = seat.dataset.seat;

        if (selectedSeats.includes(seatNo)) {
            selectedSeats = selectedSeats.filter(s => s !== seatNo);
        } else {
            selectedSeats.push(seatNo);
        }

        selectedSeatsEl.textContent = selectedSeats.length > 0 ? selectedSeats.join(', ') : 'None';
        totalFareEl.textContent = selectedSeats.length * farePerSeat;

        seatInput.value = selectedSeats.join(',');
        document.getElementById('fareInput').value = selectedSeats.length * farePerSeat;
    });
});
</script>
</body>
</html>
