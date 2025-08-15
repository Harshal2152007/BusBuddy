<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Management System</title>
    <link rel="icon" type="image/jpg" href="bus_favicon.jpg"/>
    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: #f5f5f5;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        nav {
            background: #d32f2f;
            color: #fff;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            transform: translateY(-100%);
            animation: navSlide 0.6s ease-out forwards;
        }
        @keyframes navSlide {
            to { transform: translateY(0); }
        }
        nav .logo {
            font-size: 24px;
            font-weight: bold;
        }
        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }
        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: 0.3s;
            position: relative;
        }
        nav ul li a::after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            background: #ffccbc;
            left: 0;
            bottom: -4px;
            transition: width 0.3s;
        }
        nav ul li a:hover { color: #ffccbc; }
        nav ul li a:hover::after { width: 100%; }

        /* ===== HERO SECTION ===== */
        .hero {
            height: 70vh;
            background: url('main_background.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            color: white;
            position: relative;
            animation: fadeScale 1s ease forwards;
        }
        @keyframes fadeScale {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            width: 80%;
            animation: fadeUp 1s ease-out forwards;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hero h1 {
            font-size: 40px;
            margin-bottom: 20px;
        }
        .search-box {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .search-box input, .search-box button {
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            transition: 0.3s;
        }
        .search-box input {
            width: 200px;
        }
        .search-box input:focus {
            outline: none;
            box-shadow: 0 0 6px #ff9800;
        }
        .search-box button {
            background: #ff9800;
            color: white;
            cursor: pointer;
        }
        .search-box button:hover {
            background: #e68900;
            transform: scale(1.05);
        }

        /* ===== SECTION GENERIC ===== */
        section {
            padding: 40px 20px;
            text-align: center;
        }
        section h2 {
            margin-bottom: 20px;
            color: #333;
            animation: fadeIn 0.8s ease forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* ===== ROUTES ===== */
        .route-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
            animation: cardFade 0.6s ease forwards;
        }
        @keyframes cardFade {
            to { opacity: 1; transform: translateY(0); }
        }
        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }
        .card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
        }
        .card h3 {
            margin-bottom: 10px;
            color: #d32f2f;
        }

        /* ===== ABOUT ===== */
        .about {
            background: #fff;
            line-height: 1.8;
            color: #555;
            max-width: 900px;
            margin: auto;
            font-size: 16px;
            animation: fadeUp 0.8s ease forwards;
        }

        /* ===== CONTACT ===== */
        .contact form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            margin: auto;
            animation: fadeUp 0.8s ease forwards;
        }
        .contact input, .contact textarea, .contact button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: 0.3s;
        }
        .contact input:focus, .contact textarea:focus {
            border-color: #d32f2f;
            box-shadow: 0 0 5px #d32f2f;
        }
        .contact button {
            background: #d32f2f;
            color: white;
            border: none;
            cursor: pointer;
        }
        .contact button:hover {
            background: #b71c1c;
            transform: scale(1.05);
        }

        /* ===== RATE US ===== */
        .stars {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
            animation: fadeIn 0.8s ease forwards;
        }
        .stars .active {
            color: gold;
        }

        /* ===== FAQ ===== */
        .faq-item {
            background: #fff;
            padding: 15px;
            margin: 10px auto;
            max-width: 600px;
            border-radius: 8px;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
        }
        .faq-item:hover {
            transform: scale(1.02);
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        .faq-item p {
            display: none;
            color: #555;
            margin-top: 8px;
            animation: fadeIn 0.3s ease forwards;
        }

        /* ===== FOOTER ===== */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
            opacity: 0;
            animation: fadeIn 1s ease forwards;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <div class="logo">Bus Management</div>
    <ul>
        <?php if(isset($_SESSION['user_id'])): ?>
            <li><a href="user_dashboard.php">Dashboard</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="rateus.php">Rate Us</a></li>
            <li>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="index.php">Home</a></li>
            <li><a href="routes.php">Routes</a></li>
            <li><a href="login.php">Log In</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

<!-- HERO SECTION -->
<section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1>Book Your Bus Tickets Easily</h1>
        <div class="search-box">
            <input type="text" id="source" placeholder="From">
            <input type="text" id="destination" placeholder="To">
            <input type="date" id="journey-date">
            <button onclick="searchBus()">Search Buses</button>
        </div>
    </div>
</section>

<!-- POPULAR ROUTES -->
<section id="routes">
    <h2>Popular Routes</h2>
    <div class="route-cards">
        <div class="card"><h3>Mumbai → Pune</h3><p>Multiple daily buses with AC/Sleeper options.</p></div>
        <div class="card"><h3>Goa → Bangalore</h3><p>Comfortable overnight journeys available.</p></div>
        <div class="card"><h3>Nashik → Mumbai</h3><p>Frequent services and affordable fares.</p></div>
        <div class="card"><h3>Kerala → Chennai</h3><p>Luxury buses with reclining seats.</p></div>
    </div>
</section>

<!-- ABOUT -->
<section id="about" class="about">
    <h2>About Us</h2>
    <p>
        Our Bus Management System simplifies ticket booking and travel management by offering an intuitive platform.
        We aim to provide seamless bus travel experiences with real-time data, easy seat selection, and secure transactions.
    </p>
</section>

<!-- CONTACT -->
<section id="contact" class="contact">
    <h2>Contact Us</h2>
    <form onsubmit="sendMessage(event)">
        <input type="text" placeholder="Your Name" required>
        <input type="email" placeholder="Your Email" required>
        <textarea placeholder="Your Message" rows="4" required></textarea>
        <button type="submit">Send</button>
    </form>
</section>

<!-- RATE US -->
<section id="rate">
    <h2>Rate Us</h2>
    <div class="stars" id="starContainer">★ ★ ★ ★ ★</div>
    <p id="ratingText">Click on stars to rate</p>
</section>

<!-- FAQ -->
<section id="faq">
    <h2>Frequently Asked Questions</h2>
    <div class="faq-item" onclick="toggleFAQ(this)">
        <h4>How do I book a ticket?</h4>
        <p>Simply enter your source, destination, and date in the search bar and select your preferred bus.</p>
    </div>
    <div class="faq-item" onclick="toggleFAQ(this)">
        <h4>Can I cancel my booking?</h4>
        <p>Yes, bookings can be canceled through your dashboard with applicable cancellation charges.</p>
    </div>
    <div class="faq-item" onclick="toggleFAQ(this)">
        <h4>Do you offer student discounts?</h4>
        <p>Yes, special discounts are available for students on select routes.</p>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <p>&copy; 2025 Bus Management System | All rights reserved</p>
</footer>

<script>
    // Search bus
    function searchBus() {
        let from = document.getElementById("source").value;
        let to = document.getElementById("destination").value;
        let date = document.getElementById("journey-date").value;
        if (from && to && date) {
            window.location.href = `routes.php?from=${from}&to=${to}&date=${date}`;
        } else {
            alert("Please fill all fields!");
        }
    }

    function sendMessage(event) {
        event.preventDefault();
        alert("Message sent! We will contact you shortly.");
    }

    // Rate Us
    const stars = document.getElementById('starContainer').innerText.trim().split(' ');
    const container = document.getElementById('starContainer');
    container.innerHTML = '';

    stars.forEach((star, index) => {
        const span = document.createElement('span');
        span.innerHTML = star;
        span.addEventListener('click', () => {
            const allStars = container.querySelectorAll('span');
            allStars.forEach((s, i) => {
                s.classList.toggle('active', i <= index);
            });
            document.getElementById('ratingText').innerText = `You rated ${index + 1} star(s)`;
        });
        container.appendChild(span);
    });

    // FAQ toggle
    function toggleFAQ(faq) {
        const p = faq.querySelector('p');
        p.style.display = p.style.display === 'block' ? 'none' : 'block';
    }
</script>
</body>
</html>
