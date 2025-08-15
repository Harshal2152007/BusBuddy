<?php
session_start();
include 'config.php'; // DB connection

$error = "";

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Login success
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;

        header("Location: admin_dashboard.php"); // Redirect to admin panel
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        /* Body with background image space */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('login_bg.jpg') no-repeat center center/cover; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }

        /* Overlay to darken background for readability */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }

        /* Login box container */
        .login-box {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(6px);
            padding: 35px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Heading */
        .login-box h2 {
            font-size: 24px;
            margin-bottom: 25px;
            color: #2c3e50;
            font-weight: bold;
        }

        /* Input fields */
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .login-box input[type="text"]:focus,
        .login-box input[type="password"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0,123,255,0.3);
        }

        /* Submit button */
        .login-box input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #ff4b2b, #ff416c);
            border: none;
            color: #fff;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.3s ease;
        }

        .login-box input[type="submit"]:hover {
            transform: translateY(-2px);
            background: linear-gradient(90deg, #ff416c, #ff4b2b);
        }

        /* Error message */
        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 15px;
            background: rgba(231, 76, 60, 0.1);
            padding: 8px;
            border-radius: 5px;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
