<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}

include 'config.php';

// Fetch all ratings with user details
$sql = "SELECT r.id, r.stars, r.feedback, r.created_at, u.name AS username 
        FROM ratings r 
        JOIN users u ON r.user_id = u.id 
        ORDER BY r.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Ratings</title>
<link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        margin: 0;
        padding: 20px;
    }
    h1 {
        text-align: center;
        color: #2a5298;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }
    th {
        background: #1e3c72;
        color: #fff;
    }
    tr:nth-child(even) {
        background: #e9e9e9;
    }
    .stars {
        color: #ff9800;
        font-size: 18px;
    }
    .delete-btn {
        color: red;
        text-decoration: none;
        font-weight: bold;
    }
</style>
</head>
<body>

<h1>User Ratings & Feedback</h1>
<table>
    <tr>
        <th>User</th>
        <th>Rating</th>
        <th>Feedback</th>
        <th>Date</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td class="stars"><?php echo str_repeat("★", $row['stars']); ?></td>
                <td><?php echo htmlspecialchars($row['feedback']); ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" style="text-align:center;">No ratings available yet.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>
