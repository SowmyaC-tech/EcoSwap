-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2026 at 02:36 PM
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
-- Database: `ecoswap`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Available',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `item_name`, `description`, `category`, `status`, `image`) VALUES
(5, 1, 'sowmya', 'money plant', 'eco friendly', 'Available', '1773222937_plant.jpeg'),
(9, 1, 'Wooden spoon', 'the best kitchen choice', 'Kitchen Items', 'Available', '1782568730_spoon.jpeg'),
(10, 1, 'novel books', 'The best book here!', 'Books', 'Available', '1782568810_book.jpeg'),
(11, 1, 'wooden board', 'copper board here!', 'Kitchen Items', 'Available', '1782568940_board.jpeg'),
(12, 1, 'glass bottle', 'eco bottle here!', 'Kitchen Items', 'Available', '1782569017_glassbottle.jpeg'),
(13, 1, 'Plant', 'Best one here!', 'Plants', 'Available', '1782569076_plant.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `requester_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `item_id`, `requester_id`, `status`) VALUES
(4, 5, 1, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `swap_requests`
--

CREATE TABLE `swap_requests` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `requester_id` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `swap_requests`
--

INSERT INTO `swap_requests` (`id`, `item_id`, `requester_id`, `status`) VALUES
(9, 6, 9, 'accepted'),
(10, 8, 9, 'accepted'),
(13, 6, 9, 'accepted'),
(16, 6, 9, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'sowmya', 'sowm@gmail.com', '$2y$10$CcO/L.HdPFM1qBrr.WvjaOsaiB/nb57KLrz4jO0DMEpU5V1u/fLoK'),
(3, 'sowmyaaaaa', 'aaaa@gmail.com', '$2y$10$kqlhuwyAwEJ940pFgPJMFOwh4q7d03BLZ0LQOZbLm1ucug57U2imC'),
(4, 'priya', 'priya@gmail.com', '$2y$10$g0LQc5wHWMsjYyF1O8RE..nQzOen4YWhMgKPOLGey/9./RM9ZQuJy'),
(5, 'pooja', 'pooja@gmail.com', '$2y$10$PreI7GtllVpUjAgAzenqR.jsDGRh60habv3r54vL7ILrAuwk18W7y'),
(6, 'chethan', 'chethan@gmail.com', '$2y$10$tI5SSA6SDL9Y7Ea7g0UzGObUYiVcQ0H3ngr4/bsnUXWboU3Qk8ex6'),
(9, 'pranitha', 'pranitha@gmail.com', '$2y$10$0Mo8bF2ob8bzgboe.5.aV.y5FuUoEwkJtO3pB6iCX65A/zROVAKY.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `requester_id` (`requester_id`);

--
-- Indexes for table `swap_requests`
--
ALTER TABLE `swap_requests`
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
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `swap_requests`
--
ALTER TABLE `swap_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
