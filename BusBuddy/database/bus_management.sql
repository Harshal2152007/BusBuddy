-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2025 at 09:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `fare` decimal(10,2) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `booking_date` date NOT NULL,
  `status` enum('booked','cancelled') DEFAULT 'booked',
  `transaction_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `source`, `destination`, `fare`, `bus_id`, `seat_number`, `booking_date`, `status`, `transaction_id`) VALUES
(8, 1, 'Mumbai', 'Pune', 500.00, 1, '1', '2025-07-30', 'booked', NULL),
(9, 1, 'Mumbai', 'Pune', 500.00, 1, '1', '2025-07-30', 'booked', NULL),
(10, 1, 'Mumbai', 'Pune', 500.00, 1, '1', '2025-07-30', 'booked', NULL),
(16, 1, 'Mumbai', 'Pune', 500.00, 1, '1', '2025-07-31', 'booked', NULL),
(21, 1, 'Mumbai', 'Pune', 500.00, 1, 'S4', '2025-07-31', 'booked', NULL),
(24, 1, 'Mumbai', 'Pune', 500.00, 1, 'S9', '2025-07-14', 'booked', NULL),
(25, 1, 'Mumbai', 'Pune', 500.00, 1, 'S9,S39,S40', '2025-07-14', 'booked', NULL),
(26, 1, 'Mumbai', 'Pune', 500.00, 1, 'S2', '2025-08-14', 'booked', NULL),
(27, 1, 'Goa', 'Bangalore', 900.00, 2, 'S26', '2025-08-05', 'booked', NULL),
(29, 1, 'Goa', 'Bangalore', 900.00, 2, 'S11,S19,S3', '2025-08-07', 'booked', NULL),
(30, 1, 'Mumbai', 'Pune', 500.00, 1, 'S31', '2025-08-05', 'booked', NULL),
(31, 1, 'Mumbai', 'Pune', 500.00, 1, 'S7,S6', '2025-08-06', 'booked', NULL),
(37, 1, 'Goa', 'Bangalore', 900.00, 2, 'S9', '2025-08-23', 'booked', ''),
(38, 1, 'Mumbai', 'Pune', 500.00, 4, 'S1', '2025-08-21', 'booked', ''),
(39, 1, 'Mumbai', 'Pune', 500.00, 4, 'S1', '2025-08-21', '', NULL),
(40, 1, 'Mumbai', 'Pune', 500.00, 1, 'S10', '2025-08-22', '', NULL),
(41, 1, 'Mumbai', 'Pune', 1000.00, 4, 'S2,S30', '2025-08-29', 'cancelled', '1234'),
(42, 5, 'Mumbai', 'Pune', 1500.00, 4, 'S22,S23,S2', '2025-08-13', 'booked', 'jcskchhckkjskkjsk'),
(43, 5, 'Goa', 'Bangalore', 900.00, 2, 'S14', '2025-08-10', 'booked', 'googlepay'),
(44, 5, 'Goa', 'Bangalore', 1800.00, 2, 'S7,S6', '2025-08-28', 'booked', 'googlepay'),
(45, 5, 'Mumbai', 'Pune', 1000.00, 1, 'S1,S5', '2025-08-27', 'booked', 'googlepay'),
(46, 5, 'Goa', 'Bangalore', 900.00, 2, 'S18', '2025-08-16', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `id` int(11) NOT NULL,
  `bus_name` varchar(100) NOT NULL,
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total_seats` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`id`, `bus_name`, `source`, `destination`, `departure_time`, `arrival_time`, `price`, `total_seats`) VALUES
(1, 'Volvo AC Sleeper', 'Mumbai', 'Pune', '08:00:00', '14:00:00', 500.00, 40),
(2, 'Luxury Express', 'Goa', 'Bangalore', '21:00:00', '07:00:00', 900.00, 36),
(4, 'Volvo Luxury', 'Mumbai', 'Pune', '08:00:00', '12:00:00', 500.00, 40);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `stars`, `feedback`, `created_at`) VALUES
(1, 1, 5, 'nice', '2025-07-30 17:46:58'),
(2, 1, 2, 'have a nice ui', '2025-07-30 18:17:19'),
(3, 1, 5, 'harhsal is very good', '2025-08-05 06:17:24'),
(4, 1, 4, '', '2025-08-05 07:16:43'),
(5, 5, 5, '', '2025-08-13 07:49:46');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `route_name` varchar(100) NOT NULL,
  `distance_km` decimal(10,2) NOT NULL,
  `estimated_time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `bus_id`, `route_name`, `distance_km`, `estimated_time`) VALUES
(1, 1, 'mumbai to pune', 300.00, '5'),
(2, 2, 'nannaj to sangamner', 15.00, '5');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'pramod', 'kadnarpramod1@gmail.com', '9699345059', '$2y$10$DaaFF3.Gyupsz1gIPt2yuuFTmUtvOGWh291eF1zLcnRHn84EnRCM6', '2025-07-29 18:49:44'),
(5, 'Harshal Bhamre', 'harshalbhamre05@gmail.com', '8767450204', '$2y$10$ziaoXBpsdo0PdRJZis8JPucl74LzUIFyV4NAaWIYOZEuRJCe7dEfq', '2025-08-06 17:26:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bus_id` (`bus_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `buses`
--
ALTER TABLE `buses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`bus_id`) REFERENCES `buses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
