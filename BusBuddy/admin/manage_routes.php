<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}
include 'config.php';

// Fetch buses for dropdown
$buses = $conn->query("SELECT id, bus_name FROM buses");

// Add route
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_route'])) {
    $bus_id = intval($_POST['bus_id']);
    $route_name = trim($_POST['route_name']);
    $distance_km = floatval($_POST['distance_km']);
    $estimated_time = trim($_POST['estimated_time']);

    $stmt = $conn->prepare("INSERT INTO routes (bus_id, route_name, distance_km, estimated_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isds", $bus_id, $route_name, $distance_km, $estimated_time);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_routes.php");
    exit();
}

// Delete route
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM routes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_routes.php");
    exit();
}

// Fetch routes with bus name
$routes = $conn->query("SELECT routes.id, routes.route_name, routes.distance_km, routes.estimated_time, buses.bus_name 
                        FROM routes 
                        JOIN buses ON routes.bus_id = buses.id
                        ORDER BY routes.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Routes</title>
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
    form input[type="number"],
    form select {
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
<h1>Manage Routes</h1>

<!-- Add Route Form -->
<form method="POST">
    <select name="bus_id" required>
        <option value="">Select Bus</option>
        <?php while($bus = $buses->fetch_assoc()): ?>
            <option value="<?= $bus['id']; ?>"><?= htmlspecialchars($bus['bus_name']); ?></option>
        <?php endwhile; ?>
    </select>
    <input type="text" name="route_name" placeholder="Route Name" required>
    <input type="number" step="0.01" name="distance_km" placeholder="Distance (km)" required>
    <input type="text" name="estimated_time" placeholder="Estimated Time (e.g., 5 hours)" required>
    <input type="submit" name="add_route" value="Add Route">
</form>

<!-- Routes Table -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Bus Name</th>
            <th>Route Name</th>
            <th>Distance (km)</th>
            <th>Estimated Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $routes->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['bus_name']); ?></td>
                <td><?= htmlspecialchars($row['route_name']); ?></td>
                <td><?= $row['distance_km']; ?></td>
                <td><?= htmlspecialchars($row['estimated_time']); ?></td>
                <td>
                    <a href="edit_route.php?id=<?= $row['id']; ?>" class="edit-btn">Edit</a>
                    <a href="?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</body>
</html>
