<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}
include 'config.php';

// Delete user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: manage_users.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Users</title>
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
    a.delete-btn {
        color: #ff4b5c;
        font-weight: bold;
        text-decoration: none;
    }
    a.delete-btn:hover {
        color: #ff2e44;
    }
</style>
</head>
<body>
<h1>Manage Users</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['phone']); ?></td>
                <td><?= $row['created_at']; ?></td>
                <td>
                    <a href="?delete=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
