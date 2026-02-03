-- phpMyAdmin SQL Dump
-- version 5.2.3-1.el10_2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2026 at 02:58 AM
-- Server version: 10.11.15-MariaDB
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `np03cs4a240235`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `organizer` varchar(100) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `max_participants` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `category`, `organizer`, `event_date`, `location`, `max_participants`) VALUES
(15, 'Holi Fest', 'Festive', 'HCK', '2026-03-12', 'HCK Basketball Ground', 0),
(16, 'Dashain Fest', 'Festive', 'HCK', '2026-04-12', 'WLV Ground', 0),
(17, 'CODEATHON', 'Academic, Fun', 'CODERSMANIA', '2026-05-23', 'ING Lecture Hall', 70),
(18, 'USBHCK', 'Academic', 'EthicalHCK', '2026-10-01', 'SR-04', 20),
(19, 'Chakra Chitra', 'Artistic', 'UI Visuals', '2026-09-09', 'Wolves, WLV Block', 45),
(20, 'AIMANIA', 'AI, Fun', 'AI Learners', '2026-02-02', 'Bantok', 45),
(21, 'BizMela', 'Business', 'Bizcore', '2026-02-24', 'Gahanapokhari, HCK Block', 55),
(22, 'DEVFEST2.0', 'Fun', 'HCK', '2026-12-12', 'HCK Basketball Ground', 0),
(23, 'OKay', 'okay', 'okay', '2026-02-20', 'okay', 23);

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `event_title` varchar(255) DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `user_id`, `username`, `event_id`, `event_title`, `registered_at`) VALUES
(28, 7, 'Rean', 10, 'FUNkey', '2026-02-01 08:10:22'),
(29, 4, 'Deepson Shrestha', 14, 'FUNUS', '2026-02-01 08:15:04'),
(30, 1, 'mirajan_shrestha', 14, 'FUNUS', '2026-02-01 08:16:41'),
(31, 4, 'Deepson Shrestha', 18, 'USBHCK', '2026-02-01 08:44:49'),
(32, 4, 'Deepson Shrestha', 22, 'DEVFEST', '2026-02-01 09:22:36'),
(33, 4, 'Deepson Shrestha', 21, 'BizMela', '2026-02-01 09:22:46'),
(34, 4, 'Deepson Shrestha', 19, 'Chakra Chitra', '2026-02-01 09:22:52'),
(35, 4, 'Deepson Shrestha', 15, 'Holi Fest', '2026-02-01 09:50:41'),
(36, 4, 'Deepson Shrestha', 16, 'Dashain Fest', '2026-02-01 09:50:46'),
(37, 4, 'Deepson Shrestha', 20, 'AIMANIA', '2026-02-01 10:56:46'),
(38, 4, 'Deepson Shrestha', 17, 'CODEATHON', '2026-02-01 11:03:43'),
(39, 8, 'russ', 20, 'AIMANIA', '2026-02-02 07:44:10'),
(40, 8, 'russ', 15, 'Holi Fest', '2026-02-02 07:44:12'),
(41, 8, 'russ', 18, 'USBHCK', '2026-02-02 07:44:13'),
(42, 1, 'mirajan_shrestha', 21, 'BizMela', '2026-02-03 01:56:25'),
(43, 1, 'mirajan_shrestha', 15, 'Holi Fest', '2026-02-03 02:52:43'),
(44, 1, 'mirajan_shrestha', 19, 'Chakra Chitra', '2026-02-03 02:52:45'),
(45, 9, 'prasanna', 19, 'Chakra Chitra', '2026-02-03 02:56:03'),
(46, 9, 'prasanna', 21, 'BizMela', '2026-02-03 02:56:15'),
(47, 9, 'prasanna', 23, 'OKay', '2026-02-03 02:56:18'),
(48, 9, 'prasanna', 20, 'AIMANIA', '2026-02-03 02:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'mirajan_shrestha', '$2y$10$i4DsWeUeKXbxocz.Iky0pu5K9a7RlfOKWFUKZnzPB2LLKtTQjmM1O', 'user'),
(3, 'prachi_malla', '$2y$10$rMxaxoaRyS/8kjRXH6Vl8OeglQKRQrHOJTB.U2NhNwdpWHWxbNCUa', 'user'),
(4, 'Deepson Shrestha', '$2y$10$8twzBAh5gLhoatfSncLMi.88BM/xZ97qVWGuT1ttDn2tnlCE33./a', 'admin'),
(5, 'Subashna', '$2y$10$hrg2BIGbyVMYQGBjtQnv0.JtNDFxkESHps7tW8ubB7zQke8p9H/Y6', 'user'),
(6, 'Deepshikha Gautam', '$2y$10$/oXaopYEehPea8lpdH.o3.I5fKkfBP9Nj5hyoULXjA.KQiW8PF9Ku', 'user'),
(7, 'Rean', '$2y$10$B17tg4lrRgKHAqXyWKfPkeTncb1lu0UVAr1SRw3XBV6bkt9Syu75G', 'user'),
(8, 'russ', '$2y$10$15W6WDwNrISE3CeKThS/s.VsYPJYTq/DMqKtdvhDhfUgeY2MMeZvK', 'user'),
(9, 'prasanna', '$2y$10$Ay.Seo7nyA6QXqnjmTjeS.o8dr0p.v7Et7gWQGPk9NylkWAO2hsSi', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_registration` (`user_id`,`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
