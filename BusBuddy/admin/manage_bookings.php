<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}
include 'config.php';

// Cancel booking
if (isset($_GET['cancel'])) {
    $id = intval($_GET['cancel']);
    $conn->query("UPDATE bookings SET status='cancelled' WHERE id=$id");
    header("Location: manage_bookings.php");
    exit();
}

// Delete booking
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM bookings WHERE id=$id");
    header("Location: manage_bookings.php");
    exit();
}

// Fetch bookings with user & bus details
$query = "SELECT bookings.id, users.name AS user_name, buses.bus_name,
                 bookings.source, bookings.destination, bookings.fare,
                 bookings.seat_number, bookings.booking_date, bookings.status
          FROM bookings
          JOIN users ON bookings.user_id = users.id
          JOIN buses ON bookings.bus_id = buses.id
          ORDER BY bookings.booking_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Bookings</title>
<link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: linear-gradient(120deg, #1e3c72, #2a5298);
        color: #fff;
        padding: 20px;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    table th, table td {
        padding: 12px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
        text-align: center;
    }
    table th {
        background: rgba(0,0,0,0.2);
    }
    a.cancel-btn {
        color: #ffc107;
        font-weight: bold;
        text-decoration: none;
        margin-right: 10px;
    }
    a.delete-btn {
        color: #ff4b5c;
        font-weight: bold;
        text-decoration: none;
    }
    a.cancel-btn:hover { color: #e0a800; }
    a.delete-btn:hover { color: #ff2e44; }
</style>
</head>
<body>
<h1>Manage Bookings</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Bus</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Seat(s)</th>
            <th>Fare</th>
            <th>Booking Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['user_name']); ?></td>
                <td><?= htmlspecialchars($row['bus_name']); ?></td>
                <td><?= htmlspecialchars($row['source']); ?></td>
                <td><?= htmlspecialchars($row['destination']); ?></td>
                <td><?= htmlspecialchars($row['seat_number']); ?></td>
                <td><?= $row['fare']; ?></td>
                <td><?= $row['booking_date']; ?></td>
                <td><?= $row['status']; ?></td>
                <td>
                    <?php if($row['status'] == 'booked'): ?>
                        <a href="?cancel=<?= $row['id']; ?>" class="cancel-btn" onclick="return confirm('Cancel this booking?')">Cancel</a>
                    <?php endif; ?>
                    <a href="?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Delete this booking?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
