<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}
include 'config.php';

// Get bus ID
if (!isset($_GET['id'])) {
    header("Location: manage_buses.php");
    exit();
}

$bus_id = intval($_GET['id']);

// Fetch existing bus data
$stmt = $conn->prepare("SELECT * FROM buses WHERE id = ?");
$stmt->bind_param("i", $bus_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: manage_buses.php");
    exit();
}

$bus = $result->fetch_assoc();
$stmt->close();

// Update bus
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bus_name = trim($_POST['bus_name']);
    $source = trim($_POST['source']);
    $destination = trim($_POST['destination']);
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = floatval($_POST['price']);
    $total_seats = intval($_POST['total_seats']);

    $stmt = $conn->prepare("UPDATE buses SET bus_name=?, source=?, destination=?, departure_time=?, arrival_time=?, price=?, total_seats=? WHERE id=?");
    $stmt->bind_param("ssssdsii", $bus_name, $source, $destination, $departure_time, $arrival_time, $price, $total_seats, $bus_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_buses.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Bus</title>
<link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(120deg, #1e3c72, #2a5298);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .edit-box {
        background: rgba(255,255,255,0.15);
        padding: 20px;
        border-radius: 10px;
        width: 400px;
    }
    .edit-box h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .edit-box input[type="text"],
    .edit-box input[type="time"],
    .edit-box input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: none;
        outline: none;
    }
    .edit-box input[type="submit"] {
        width: 100%;
        padding: 10px;
        background: #28a745;
        border: none;
        color: #fff;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }
    .edit-box input[type="submit"]:hover {
        background: #218838;
    }
</style>
</head>
<body>
    <div class="edit-box">
        <h2>Edit Bus</h2>
        <form method="POST">
            <input type="text" name="bus_name" value="<?= htmlspecialchars($bus['bus_name']); ?>" required>
            <input type="text" name="source" value="<?= htmlspecialchars($bus['source']); ?>" required>
            <input type="text" name="destination" value="<?= htmlspecialchars($bus['destination']); ?>" required>
            <input type="time" name="departure_time" value="<?= $bus['departure_time']; ?>" required>
            <input type="time" name="arrival_time" value="<?= $bus['arrival_time']; ?>" required>
            <input type="number" step="0.01" name="price" value="<?= $bus['price']; ?>" required>
            <input type="number" name="total_seats" value="<?= $bus['total_seats']; ?>" required>
            <input type="submit" value="Update Bus">
        </form>
    </div>
</body>
</html>
