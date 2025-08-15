<?php 
include 'config.php'; // DB connection

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Validation
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
        $message = "All fields are required!";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $message = "Please enter a valid 10-digit phone number!";
    } elseif ($password !== $confirmPassword) {
        $message = "Passwords do not match!";
    } else {
        // Check if email already exists
        $checkEmail = $conn->prepare("SELECT * FROM users WHERE email=?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $result = $checkEmail->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already registered!";
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert into DB
            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $phone, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: login.php?msg=registered");
                exit;
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bus Management System</title>
   <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
   <style>
        /* Background */
        body {
            background: url('register_background.jpg') no-repeat center center/cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            animation: bgFade 1s ease forwards;
        }
        @keyframes bgFade {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Navbar */
        .navbar {
            background-color: #d32f2f;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            transform: translateY(-100%);
            animation: navSlide 0.6s ease forwards;
        }
        @keyframes navSlide {
            to { transform: translateY(0); }
        }
        .navbar h1 {
            margin: 0;
            color: white;
            font-size: 22px;
        }
        .navbar a {
            background-color: white;
            color: #d32f2f;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 4px;
            font-weight: bold;
            transition: 0.3s;
        }
        .navbar a:hover {
            background-color: #b71c1c;
            color: white;
        }

        /* Register box */
        .register-box {
            background: rgba(255,255,255,0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            width: 350px;
            margin: auto;
            animation: formSlide 0.8s ease-out forwards;
            transform: translateY(30px);
            opacity: 0;
        }
        @keyframes formSlide {
            to { transform: translateY(0); opacity: 1; }
        }
        h2 { 
            text-align: center; 
            color: #d32f2f; 
            margin-bottom: 20px; 
            animation: fadeIn 1s ease forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: 0.3s;
        }
        input:focus {
            border-color: #d32f2f;
            box-shadow: 0 0 5px #d32f2f;
            outline: none;
        }
        input.error {
            border: 1px solid red;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #d32f2f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.2s, background 0.3s;
        }
        button:hover { 
            background: #b71c1c; 
            transform: scale(1.05); 
        }
        p { text-align: center; }
        a { color: #d32f2f; text-decoration: none; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
        #pass_error { color: red; text-align: center; font-size: 14px; margin: 5px 0; }
    </style>
    <script>
        // Restrict phone input to digits only
        function validatePhoneInput(event) {
            event.target.value = event.target.value.replace(/[^0-9]/g, '');
        }

        // Check password match
        function checkPasswordMatch() {
            let password = document.querySelector('input[name="password"]').value;
            let confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            let errorMsg = document.getElementById('pass_error');
            let confirmInput = document.querySelector('input[name="confirm_password"]');

            if (confirmPassword && password !== confirmPassword) {
                errorMsg.textContent = "Passwords do not match!";
                confirmInput.classList.add('error');
            } else {
                errorMsg.textContent = "";
                confirmInput.classList.remove('error');
            }
        }
    </script>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h1>Bus Management System</h1>
    <a href="index.php">Home</a>
</div>

<div class="register-box">
    <h2>Create Account</h2>

    <?php if(!empty($message)) echo "<p class='error'>$message</p>"; ?>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number" maxlength="10" oninput="validatePhoneInput(event)" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required onblur="checkPasswordMatch()">
        <p id="pass_error"></p>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>
