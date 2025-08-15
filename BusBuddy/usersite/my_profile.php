<?php
session_start();
include 'config.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT name, email, phone, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $phone, $created_at);
$stmt->fetch();
$stmt->close();

$message = "";

// Handle profile update
if (isset($_POST['update_profile'])) {
    $new_name = trim($_POST['name']);
    $new_phone = trim($_POST['phone']);

    if ($new_name && $new_phone) {
        $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_name, $new_phone, $user_id);
        if ($stmt->execute()) {
            $_SESSION['user_name'] = $new_name;
            $_SESSION['user_phone'] = $new_phone;
            $message = "Profile updated successfully!";
        } else {
            $message = "Error updating profile.";
        }
        $stmt->close();
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];

    // Verify current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_pass);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($current_pass, $hashed_pass)) {
        $new_hashed = password_hash($new_pass, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_hashed, $user_id);
        if ($stmt->execute()) {
            $message = "Password changed successfully!";
        } else {
            $message = "Error changing password.";
        }
        $stmt->close();
    } else {
        $message = "Current password is incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }
        nav {
            background: #d32f2f;
            color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav .logo {
            font-size: 22px;
            font-weight: bold;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }
        nav ul li a:hover {
            color: #ffccbc;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #d32f2f;
        }
        .message {
            text-align: center;
            color: green;
            margin-bottom: 10px;
        }
        form {
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #b71c1c;
        }
        .profile-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="logo">Bus Management</div>
    <ul>
        <li><a href="user_dashboard.php">Dashboard</a></li>
        <li><a href="profile.php">My Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div class="container">
    <h2>My Profile</h2>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>

    <div class="profile-info">
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Joined:</strong> <?php echo htmlspecialchars($created_at); ?></p>
    </div>

    <form method="POST">
        <h3>Edit Profile</h3>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
        <button type="submit" name="update_profile">Update Profile</button>
    </form>

    <form method="POST">
        <h3>Change Password</h3>
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit" name="change_password">Change Password</button>
    </form>
</div>

</body>
</html>
