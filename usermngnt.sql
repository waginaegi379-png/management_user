-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2025 at 02:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usermngnt`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `created`) VALUES
(1, 'Battery Laptop', 'Lithium-ion (Li-ion)', '2025-10-30 12:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `activation_token` varchar(100) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT 'inactive',
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `username`, `password`, `role`, `activation_token`, `reset_token`, `reset_token_expires`, `status`, `reg_date`, `modified`) VALUES
(1, 'Administrator Gudang', 'admin@gudang.com', '$2y$10$Ae/o6PK3NaRGtReDpLMzA.1fsOgepUsTXsUdnoyljVyJscGBsR2hi', 'admin', NULL, NULL, NULL, 'active', '2025-10-30 11:15:20', '2025-10-30 11:15:20'),
(2, 'Wagina egiana', 'waginaegiana379@gmail.com', '$2y$10$WESQtFMFcihHWvK3VRhRyOWeHVRSZZdOHTtpb1QWFJnKvCQLoblka', 'user', 'bab241d4c7785563642cfb8b74e9f94c4bed460a844b84b768c13df1411ef09e', NULL, NULL, 'inactive', '2025-10-30 11:15:46', '2025-10-30 11:15:46'),
(4, 'Wagina egiana', 'ginawagina@gmail.com', '$2y$10$O2Olg91enTYngEDeTXEmiOZtbgtPrYK2Sh1amMq3SmtSJCLkRDFkW', 'user', '6a5be4bb865f0277302ad40434934690c6a004ab66ea0aa60a8acee42fa4baf2', NULL, NULL, 'inactive', '2025-10-30 11:18:33', '2025-10-30 11:18:33'),
(5, 'Wagina egiana', 'anaegiana@gmail.com', '$2y$10$0.V97ygb56/hPaqim1qsIeYMfOmHl79E.4c/0Lx9gnaQj61cdIcuC', 'user', '52f0a8988a063987c2b8528c62bed1e1d820285e2c1fee7929cc22c963544c0a', NULL, NULL, 'inactive', '2025-10-30 11:23:01', '2025-10-30 11:23:01'),
(6, 'Wagina egiana', 'egiwagina@gmail.com', '$2y$10$2HMA2ndDmx/6M7oAUXHOleXAvbDrHrYr/9KngqMCakfnkUXZMPaKO', 'user', 'bc299e9c4d1ac4f54571170cd8956b391d49e40b0da4bb7efc54f40796684113', NULL, NULL, 'inactive', '2025-10-30 11:24:08', '2025-10-30 11:24:08'),
(7, 'Wagina egiana', 'egigina678@gmail.com', '$2y$10$Quo34DJ7Jxh5ce4eJNXtIOemxXg7cnDIPOJIcCtQZcXMitskLhOJK', 'user', NULL, NULL, NULL, 'active', '2025-10-30 11:44:03', '2025-10-30 11:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activation_code` varchar(100) DEFAULT NULL,
  `reset_code` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `activation_code`, `reset_code`, `is_active`, `created_at`) VALUES
(1, 'Administrator', 'admin@example.com', '$2y$10$prFLTzvMuCUBz0ZxsClM4eOjw40n/HjALMe0u21AFu3GljnuA0.Ai', NULL, NULL, 1, '2025-10-30 10:26:03'),
(2, 'Wagina egiana', 'waginaegiana379@gmail.com', '$2y$10$F3Hy4q0KS/oykxUZs9b4zO9YzOlp1eMxB6gdeX72F6VwLb/.xzaC6', 'ba69630b9c17cbab4377aa1c6586fe8680840c051b38c985549160e74fa30a80', NULL, 0, '2025-10-30 11:07:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
