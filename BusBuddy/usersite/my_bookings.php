<?php
session_start();
include 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM bookings WHERE user_id = $user_id ORDER BY booking_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #d32f2f;
            margin-bottom: 20px;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background: #d32f2f;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>My Bookings</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Seat Number</th>
            <th>Date</th>
            <th>Fare</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['source'] ?></td>
            <td><?= $row['destination'] ?></td>
            <td><?= $row['seat_number'] ?></td>
            <td><?= $row['booking_date'] ?></td>
            <td>₹<?= $row['fare'] ?></td>
            <td><?= ucfirst($row['status']) ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
