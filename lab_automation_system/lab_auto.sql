-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 09:11 AM
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
-- Database: `lab_auto`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_type` varchar(100) DEFAULT NULL,
  `revise` varchar(50) DEFAULT NULL,
  `manufacture_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_id`, `name`, `product_type`, `revise`, `manufacture_date`, `remarks`, `created_at`) VALUES
(2, 'PRD0000002', 'Panadol', 'Medicine', 'Rev 1', '2025-10-07', 'Fever Tablet\"', '2025-10-07 06:51:59'),
(19, 'PRD0000003', 'Panadol', 'Medicine', 'Rev 1', '2025-09-20', 'Fever & Pain relief', '2025-10-07 07:00:13'),
(20, 'PRD0000004', 'Augmentin', 'Medicine', 'Rev 1', '2025-09-15', 'Antibiotic (Amoxicillin + Clavulanic Acid)', '2025-10-07 07:00:13'),
(21, 'PRD0000005', 'Calpol', 'Medicine', 'Rev 1', '2025-09-25', 'For mild fever in children', '2025-10-07 07:00:13'),
(22, 'PRD0000006', 'Flagyl', 'Medicine', 'Rev 1', '2025-09-10', 'Anti-bacterial & anti-protozoal', '2025-10-07 07:00:13'),
(23, 'PRD0000007', 'Brufen', 'Medicine', 'Rev 1', '2025-09-05', 'Pain & inflammation relief', '2025-10-07 07:00:13'),
(24, 'PRD0000008', 'Disprin', 'Medicine', 'Rev 1', '2025-09-12', 'Fast pain relief tablet', '2025-10-07 07:00:13'),
(25, 'PRD0000009', 'Ciproxin', 'Medicine', 'Rev 1', '2025-09-28', 'Broad-spectrum antibiotic', '2025-10-07 07:00:13'),
(26, 'PRD0000010', 'Ventolin', 'Medicine', 'Rev 1', '2025-09-30', 'Asthma inhaler medicine', '2025-10-07 07:00:13');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(11) NOT NULL,
  `test_id` varchar(30) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `test_type` varchar(100) DEFAULT NULL,
  `result` enum('Pass','Fail','Pending') DEFAULT 'Pending',
  `tester_name` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `test_id`, `product_id`, `test_type`, `result`, `tester_name`, `remarks`, `test_date`, `created_at`) VALUES
(2, 'PRD0000002001', 'PRD0000002', 'Stability Test', 'Pass', 'Syed', 'Stable under 40°C for 3 months', '2025-10-07', '2025-10-07 06:53:35'),
(3, 'PRD0000002002', 'PRD0000002', 'Temperature Test', 'Fail', 'ALi', 'Unstable under 40°C for 3 months', '2025-10-07', '2025-10-07 06:54:25'),
(13, 'TST000000003', 'PRD0000003', 'Stability Test', 'Pass', 'Ali', 'Stable at 25°C for 6 months', '2025-09-21', '2025-10-07 07:05:29'),
(14, 'TST000000004', 'PRD0000004', 'Temperature Test', 'Pass', 'Ahmed', 'No degradation under 40°C', '2025-09-21', '2025-10-07 07:05:29'),
(15, 'TST000000005', 'PRD0000005', 'Chemical Purity Test', 'Pass', 'Sana', '99% active ingredient', '2025-09-22', '2025-10-07 07:05:29'),
(16, 'TST000000006', 'PRD0000006', 'Dissolution Test', 'Pass', 'Bilal', 'Complete dissolution in 30 mins', '2025-09-22', '2025-10-07 07:05:29'),
(17, 'TST000000007', 'PRD0000007', 'Moisture Content Test', 'Fail', 'Ali', 'Moisture above 2% limit', '2025-09-23', '2025-10-07 07:05:29'),
(18, 'TST000000008', 'PRD0000008', 'Quality Test', 'Pass', 'Asma', 'Meets BP standards', '2025-09-23', '2025-10-07 07:05:29'),
(19, 'TST000000009', 'PRD0000009', 'Stability Test', 'Pass', 'Areeba', 'Shelf life stable for 12 months', '2025-09-24', '2025-10-07 07:05:29'),
(20, 'TST000000010', 'PRD0000010', 'Microbial Test', 'Pass', 'Taha', 'No contamination found', '2025-09-24', '2025-10-07 07:05:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_id` (`test_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
