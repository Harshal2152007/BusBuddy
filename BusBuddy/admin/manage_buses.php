<?php
include 'auth.php';   // Centralized admin authentication
include 'config.php';

// Add Bus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_bus'])) {
    $bus_name = trim($_POST['bus_name']);
    $source = trim($_POST['source']);
    $destination = trim($_POST['destination']);
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = floatval($_POST['price']);
    $total_seats = intval($_POST['total_seats']);

    $stmt = $conn->prepare("INSERT INTO buses (bus_name, source, destination, departure_time, arrival_time, price, total_seats) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssddi", $bus_name, $source, $destination, $departure_time, $arrival_time, $price, $total_seats);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_buses.php");
    exit();
}

// Delete Bus
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM buses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_buses.php");
    exit();
}

// Fetch Buses
$buses = $conn->query("SELECT * FROM buses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Buses</title>
<link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background: linear-gradient(120deg, #1e3c72, #2a5298);
        color: #fff;
        min-height: 100vh;
        padding: 20px;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    form {
        background: rgba(255,255,255,0.15);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px;
    }
    form input[type="text"],
    form input[type="time"],
    form input[type="number"] {
        padding: 10px;
        border-radius: 5px;
        border: none;
        outline: none;
    }
    form input[type="submit"] {
        grid-column: span 2;
        padding: 10px;
        background: #28a745;
        border: none;
        color: #fff;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }
    form input[type="submit"]:hover {
        background: #218838;
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
    a.delete-btn {
        color: #ff4b5c;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }
    a.delete-btn:hover {
        color: #ff2e44;
    }
    a.edit-btn {
        color: #ffc107;
        text-decoration: none;
        font-weight: bold;
        margin-right: 10px;
    }
    a.edit-btn:hover {
        color: #e0a800;
    }
</style>
</head>
<body>
<h1>Manage Buses</h1>

<!-- Add Bus Form -->
<form method="POST">
    <input type="text" name="bus_name" placeholder="Bus Name" required>
    <input type="text" name="source" placeholder="Source" required>
    <input type="text" name="destination" placeholder="Destination" required>
    <input type="time" name="departure_time" required>
    <input type="time" name="arrival_time" required>
    <input type="number" step="0.01" name="price" placeholder="Price" required>
    <input type="number" name="total_seats" placeholder="Total Seats" required>
    <input type="submit" name="add_bus" value="Add Bus">
</form>

<!-- Bus Table -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Bus Name</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Price</th>
            <th>Seats</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $buses->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['bus_name']); ?></td>
                <td><?= htmlspecialchars($row['source']); ?></td>
                <td><?= htmlspecialchars($row['destination']); ?></td>
                <td><?= $row['departure_time']; ?></td>
                <td><?= $row['arrival_time']; ?></td>
                <td><?= $row['price']; ?></td>
                <td><?= $row['total_seats']; ?></td>
                <td>
                    <a href="edit_bus.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                    <a href="?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</body>
</html>
