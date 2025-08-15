<?php
session_start();
include 'config.php';

if (!isset($_GET['bus_id']) || !isset($_GET['date'])) {
    die("Invalid request");
}

$bus_id = intval($_GET['bus_id']);
$journey_date = $_GET['date'];

// Fetch bus details
$stmt = $conn->prepare("SELECT * FROM buses WHERE id = ?");
$stmt->bind_param("i", $bus_id);
$stmt->execute();
$bus = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$bus) {
    die("Bus not found.");
}

// Get booked seats for this bus & date
$bookedSeats = [];
$bookedQuery = $conn->prepare("SELECT seat_number FROM bookings WHERE bus_id = ? AND booking_date = ? AND status='booked'");
$bookedQuery->bind_param("is", $bus_id, $journey_date);
$bookedQuery->execute();
$result = $bookedQuery->get_result();
while ($row = $result->fetch_assoc()) {
    $bookedSeats[] = $row['seat_number'];
}
$bookedQuery->close();

$totalSeats = $bus['total_seats'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Select Seats</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        h2 { color: #d32f2f; }
        .bus-info {
            margin-bottom: 20px;
            text-align: center;
        }
        .seat-grid {
            display: grid;
            grid-template-columns: repeat(4, 50px);
            gap: 10px;
            margin: 20px 0;
        }
        .seat {
            width: 50px;
            height: 50px;
            background: #ddd;
            border-radius: 5px;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
        }
        .seat.booked {
            background: #999;
            cursor: not-allowed;
        }
        .seat.selected {
            background: #ff9800;
            color: white;
        }
        button {
            padding: 10px 20px;
            background: #d32f2f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="bus-info">
        <h2><?php echo htmlspecialchars($bus['bus_name']); ?></h2>
        <p><?php echo htmlspecialchars($bus['source']); ?> → <?php echo htmlspecialchars($bus['destination']); ?></p>
        <p>Fare: ₹<?php echo htmlspecialchars($bus['price']); ?></p>
        <p>Date: <?php echo htmlspecialchars($journey_date); ?></p>
    </div>

    <form method="POST" action="book_ticket.php">
        <input type="hidden" name="bus_id" value="<?php echo $bus_id; ?>">
        <input type="hidden" name="date" value="<?php echo htmlspecialchars($journey_date); ?>">
        <input type="hidden" name="seat_number" id="seatInput" value="">

        <div class="seat-grid">
            <?php for ($i = 1; $i <= $totalSeats; $i++): 
                $seatNo = "S".$i;
                $isBooked = in_array($seatNo, $bookedSeats);
            ?>
                <div class="seat <?php echo $isBooked ? 'booked' : ''; ?>" data-seat="<?php echo $seatNo; ?>">
                    <?php echo $i; ?>
                </div>
            <?php endfor; ?>
        </div>

        <button type="submit">Book Selected Seat</button>
    </form>

    <script>
        const seats = document.querySelectorAll('.seat:not(.booked)');
        const seatInput = document.getElementById('seatInput');

        seats.forEach(seat => {
            seat.addEventListener('click', () => {
                seats.forEach(s => s.classList.remove('selected'));
                seat.classList.add('selected');
                seatInput.value = seat.dataset.seat;
            });
        });

        document.querySelector('form').addEventListener('submit', (e) => {
            if (!seatInput.value) {
                alert("Please select a seat!");
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
