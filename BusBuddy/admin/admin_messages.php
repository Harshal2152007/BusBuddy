<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}
$admin_name = $_SESSION['admin_username'];
include 'config.php';

// Delete message
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: admin_messages.php?msg=deleted");
    exit();
}

// Fetch messages
$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Messages</title>
<link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(120deg, #1e3c72, #2a5298);
        color: #fff;
        height: 100vh;
        display: flex;
        flex-direction: column;
    }
    header {
        background: rgba(0,0,0,0.3);
        padding: 20px;
        text-align: center;
        font-size: 24px;
        letter-spacing: 1px;
        backdrop-filter: blur(6px);
    }
    .dashboard {
        flex: 1;
        display: flex;
        flex-direction: row;
    }
    .sidebar {
        width: 220px;
        background: rgba(0,0,0,0.25);
        backdrop-filter: blur(6px);
        display: flex;
        flex-direction: column;
        padding: 20px;
    }
    .sidebar h3 {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
        padding-bottom: 10px;
    }
    .sidebar a {
        text-decoration: none;
        color: #fff;
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
        transition: 0.3s ease;
    }
    .sidebar a:hover {
        background: rgba(255,255,255,0.2);
        transform: translateX(5px);
    }
    .content {
        flex: 1;
        padding: 30px;
        overflow-y: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: rgba(255,255,255,0.15);
    }
    table, th, td {
        border: 1px solid #ddd;
        color: #fff;
    }
    th {
        background: #c62828;
        padding: 10px;
    }
    td {
        padding: 10px;
        text-align: center;
    }
    .btn {
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        color: white;
        cursor: pointer;
    }
    .btn-view { background: #1976d2; }
    .btn-delete { background: #e53935; }
    .btn-delete:hover { background: #b71c1c; }
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        padding-top: 50px;
    }
    .modal-content {
        background: #fff;
        margin: auto;
        padding: 20px;
        border-radius: 8px;
        width: 50%;
        color: #000;
        position: relative;
    }
    .close {
        color: #aaa;
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        cursor: pointer;
    }
</style>
</head>
<body>
<header>
    Welcome, <?php echo htmlspecialchars($admin_name); ?> — Contact Messages
</header>

<div class="dashboard">
    <div class="sidebar">
        <h3>Navigation</h3>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_buses.php">Manage Buses</a>
        <a href="manage_routes.php">Manage Routes</a>
        <a href="manage_bookings.php">Manage Bookings</a>
        <a href="manage_users.php">Manage Users</a>
        <a href="manage_ratings.php">Manage Ratings</a>
        <a href="admin_messages.php">Contact Messages</a>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="content">
        <h2>All Contact Messages</h2>
        <?php if(isset($_GET['msg']) && $_GET['msg']=='deleted'): ?>
            <p style="color:lightgreen;">Message deleted successfully!</p>
        <?php endif; ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Sent At</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $messages->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= htmlspecialchars($row['subject']); ?></td>
                <td><?= strlen($row['message']) > 30 ? substr(htmlspecialchars($row['message']),0,30).'...' : htmlspecialchars($row['message']); ?></td>
                <td><?= $row['created_at']; ?></td>
                <td>
                    <a href="#" class="btn btn-view" onclick="viewMessage('<?= htmlspecialchars($row['name']); ?>','<?= htmlspecialchars($row['email']); ?>','<?= htmlspecialchars($row['subject']); ?>','<?= htmlspecialchars($row['message']); ?>')">View</a>
                    <a href="?delete=<?= $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Delete this message?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="messageModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Message Details</h3>
        <p><strong>Name:</strong> <span id="modalName"></span></p>
        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
        <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
        <p><strong>Message:</strong> <span id="modalMessage"></span></p>
    </div>
</div>

<script>
function viewMessage(name,email,subject,message){
    document.getElementById('modalName').innerText = name;
    document.getElementById('modalEmail').innerText = email;
    document.getElementById('modalSubject').innerText = subject;
    document.getElementById('modalMessage').innerText = message;
    document.getElementById('messageModal').style.display = 'block';
}
function closeModal(){
    document.getElementById('messageModal').style.display = 'none';
}
window.onclick = function(event) {
    if (event.target == document.getElementById('messageModal')) {
        closeModal();
    }
}
</script>
</body>
</html>
