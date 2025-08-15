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
        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: #fff;
        padding: 20px;
        margin: 0;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 28px;
        font-weight: bold;
        color: #fff;
    }
    .table-container {
        max-width: 1200px;
        margin: 0 auto;
        background: rgba(255,255,255,0.05);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
    }
    th, td {
        padding: 12px 15px;
        text-align: center;
    }
    th {
        background: rgba(255,255,255,0.15);
        font-size: 16px;
        letter-spacing: 0.5px;
    }
    tr {
        transition: background 0.3s ease;
    }
    tr:nth-child(even) {
        background: rgba(255,255,255,0.05);
    }
    tr:hover {
        background: rgba(255,255,255,0.1);
    }
    .badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 14px;
        font-weight: bold;
    }
    .status-booked {
        background: #28a745;
        color: #fff;
    }
    .status-pending {
        background: #ffc107;
        color: #000;
    }
    .status-failed {
        background: #dc3545;
        color: #fff;
    }
</style>
</head>
<body>
    <h2>Manage Transactions</h2>
    <div class="table-container">
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
                    <td>
                        <span class="badge status-<?php echo strtolower($row['status']); ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
