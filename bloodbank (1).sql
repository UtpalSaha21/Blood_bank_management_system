-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2025 at 02:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloodbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `quantity` int(11) NOT NULL,
  `request_type` enum('donate','request') NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`id`, `user_id`, `blood_group`, `quantity`, `request_type`, `status`, `request_date`) VALUES
(6, 9, 'O+', 3, 'donate', 'approved', '2025-08-18 07:09:32'),
(7, 9, 'O+', 2, 'donate', 'approved', '2025-08-18 17:13:01'),
(8, 11, 'O-', 1, 'request', 'approved', '2025-08-18 17:13:34'),
(9, 12, 'B+', 1, 'request', 'approved', '2025-08-18 17:14:05'),
(10, 10, 'B+', 1, 'donate', 'approved', '2025-08-18 17:14:55'),
(11, 9, 'O-', 1, 'donate', 'approved', '2025-08-18 21:16:39'),
(12, 9, 'A-', 1, 'donate', 'approved', '2025-08-18 21:39:10'),
(13, 9, 'AB-', 1, 'donate', 'approved', '2025-08-18 21:41:07'),
(14, 11, 'A+', 1, 'request', 'approved', '2025-08-19 12:25:57'),
(15, 10, 'B+', 1, 'donate', 'approved', '2025-08-21 17:19:58'),
(16, 11, 'O-', 2, 'request', 'rejected', '2025-08-21 17:23:56'),
(17, 11, 'A-', 1, 'request', 'approved', '2025-08-21 20:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `blood_stock`
--

CREATE TABLE `blood_stock` (
  `id` int(11) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_stock`
--

INSERT INTO `blood_stock` (`id`, `blood_group`, `quantity`) VALUES
(1, 'A+', 0),
(2, 'A-', 3),
(3, 'B+', 1),
(4, 'B-', 1),
(5, 'AB+', 1),
(6, 'AB-', 5),
(7, 'O+', 3),
(8, 'O-', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','donor','recipient') NOT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `age`, `gender`, `phone`, `address`, `created_at`) VALUES
(1, 'Admin User', 'admin@bbms.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', NULL, NULL, NULL, NULL, '2025-07-13 18:24:32'),
(9, 'donor', 'donor@gmail.com', '3d939a14c04ae16c98e3bddf6e8e4dd7', 'donor', 23, 'Male', '01721088677', 'adaad', '2025-08-17 18:29:48'),
(10, 'donor 2', 'donor2@gmail.com', '3d939a14c04ae16c98e3bddf6e8e4dd7', 'donor', 23, 'Male', '+880 - 1414 - 681341', 'fasfa', '2025-08-17 18:31:31'),
(11, 'Reciepent', 'recipient@gmail.com', 'd6e41fc5d1bcfead1db3b6dc05774971', 'recipient', 23, 'Male', '+880 - 1414 - 681341', 'sfsaf', '2025-08-17 18:36:46'),
(12, 'Reciepent 2', 'recipient2@gmail.com', 'd6e41fc5d1bcfead1db3b6dc05774971', 'recipient', 23, 'Male', '1456 986236', 'gdsgsg', '2025-08-17 18:53:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `blood_stock`
--
ALTER TABLE `blood_stock`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `blood_stock`
--
ALTER TABLE `blood_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `blood_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
