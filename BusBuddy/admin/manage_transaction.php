<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}
include 'config.php';

// Fetch transactions
$sql = "SELECT b.id, u.name AS user_name, b.source, b.destination, b.fare, b.seat_number, b.booking_date, b.transaction_id, b.status
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        ORDER BY b.id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Transactions</title>
<link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(120deg, #ff4b2b, #ff416c);
        color: #fff;
        padding: 20px;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(5px);
        border-radius: 10px;
        overflow: hidden;
    }
    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    th {
        background: rgba(255,255,255,0.2);
    }
    tr:hover {
        background: rgba(255,255,255,0.15);
    }
    .status-booked { color: #0f0; font-weight: bold; }
    .status-pending { color: #ff0; font-weight: bold; }
    .status-failed { color: #f00; font-weight: bold; }
</style>
</head>
<body>
    <h2>Transaction Records</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Route</th>
                <th>Seats</th>
                <th>Fare</th>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo $row['source']." → ".$row['destination']; ?></td>
                <td><?php echo htmlspecialchars($row['seat_number']); ?></td>
                <td>₹<?php echo $row['fare']; ?></td>
                <td><?php echo $row['transaction_id'] ?: 'N/A'; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td class="status-<?php echo strtolower($row['status']); ?>">
                    <?php echo ucfirst($row['status']); ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
