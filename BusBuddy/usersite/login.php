<?php
session_start();
include 'config.php';

$error = "";

// User Login Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: user_dashboard.php");
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Bus Management System</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        /* RESET */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        /* NAVBAR */
        .navbar {
            background-color: #d32f2f;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 10;
            transform: translateY(-100%);
            animation: slideDown 0.6s ease forwards;
        }
        @keyframes slideDown {
            to { transform: translateY(0); }
        }
        .navbar h1 {
            color: #fff;
            font-size: 22px;
        }
        .navbar a {
            background-color: #fff;
            color: #d32f2f;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 4px;
            font-weight: bold;
            transition: 0.3s;
        }
        .navbar a:hover {
            background-color: #b71c1c;
            color: #fff;
        }

        /* BACKGROUND */
        body {
            height: 100vh;
            background: url('login_bg.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 70px; /* avoid navbar overlap */
            animation: fadeBg 1s ease forwards;
        }
        @keyframes fadeBg {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* CONTAINER */
        .container {
            width: 400px;
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            padding: 25px;
            text-align: center;
            transform: scale(0.8);
            opacity: 0;
            animation: popUp 0.8s ease-out forwards;
        }
        @keyframes popUp {
            to { transform: scale(1); opacity: 1; }
        }

        /* FORM */
        .form h2 {
            margin-bottom: 20px;
            color: #d32f2f;
        }
        .form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form input:focus {
            border-color: #d32f2f;
            box-shadow: 0 0 8px #d32f2f;
            outline: none;
        }
        .form button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            background: #d32f2f;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .form button:hover {
            background: #b71c1c;
            transform: scale(1.05);
        }
        .form p {
            margin-top: 10px;
            font-size: 14px;
        }
        .form p a {
            color: #d32f2f;
            text-decoration: none;
        }

        /* ERROR MESSAGE */
        .error {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
            animation: shake 0.4s ease;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }

        /* RESPONSIVE */
        @media (max-width: 450px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h1>Bus Management System</h1>
    <a href="index.php">Home</a>
</div>

<div class="container">
    <div class="form">
        <h2>User Login</h2>
        <?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="user_login">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</div>

</body>
</html>
