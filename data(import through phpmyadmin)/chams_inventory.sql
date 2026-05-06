-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2026 at 03:41 PM
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
-- Database: `chams_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory_categories`
--

CREATE TABLE `inventory_categories` (
  `IC_ID` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `IC_Desc` text NOT NULL,
  `category_color` varchar(7) NOT NULL DEFAULT '#e3f2fd',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_categories`
--

INSERT INTO `inventory_categories` (`IC_ID`, `category_name`, `IC_Desc`, `category_color`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'Networking', 'Lan cables, USB cables you name it\r\n', '#ec3cdd', '2026-03-31 19:00:37', NULL, 1),
(2, 'Peripherals', '', '#f4a357', '2026-03-31 19:00:37', NULL, 1),
(3, 'Computers', 'Consists of hardware items if not marked as consumables', '#f95d5d', '2026-03-31 19:00:37', NULL, 1),
(4, 'Consumables', '', '#c8bdff', '2026-03-31 19:00:37', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `I_ID` int(11) NOT NULL,
  `categ_ID` int(11) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_type` int(11) NOT NULL,
  `item_brand` varchar(150) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `Threshold` int(11) NOT NULL,
  `item_supplier` varchar(150) NOT NULL,
  `Defects` enum('Yes','No') NOT NULL,
  `Serial_number` varchar(100) DEFAULT NULL,
  `date_received` datetime NOT NULL,
  `collected_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_items`
--

INSERT INTO `inventory_items` (`I_ID`, `categ_ID`, `item_name`, `item_type`, `item_brand`, `Quantity`, `Threshold`, `item_supplier`, `Defects`, `Serial_number`, `date_received`, `collected_by`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 3, 'ROG 5220', 3, 'ROG', 1122, 200, 'INTELI', 'No', '1234', '2026-04-05 18:15:00', NULL, '2026-04-05 18:16:20', '2026-04-10 00:16:45', 1),
(2, 4, '005', 1, 'brand', 400, 100, 'supplier', 'No', NULL, '2026-04-05 21:20:00', NULL, '2026-04-05 21:20:56', NULL, 1),
(3, 4, '005', 1, 'SONY', 0, 200, 'INTELI', 'No', NULL, '2026-04-05 21:20:00', NULL, '2026-04-05 21:40:16', '2026-04-17 21:11:18', 1),
(4, 4, '005', 1, 'Delta', 0, 2, 'supplier', 'No', NULL, '2026-04-17 21:47:00', NULL, '2026-04-17 21:48:25', NULL, 1),
(5, 4, '005', 1, '123', 500, 200, 'INTELI', 'No', NULL, '2026-04-29 21:22:00', NULL, '2026-04-29 21:22:36', NULL, 1),
(6, 4, '005', 1, '123', 1000, 200, 'INTELI', 'No', NULL, '2026-04-30 20:56:00', NULL, '2026-04-30 20:56:41', NULL, 1),
(7, 4, '005', 1, '123', 15, 2, 'INFINI', 'No', NULL, '2026-04-30 22:43:00', NULL, '2026-04-30 22:43:19', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_tracker`
--

CREATE TABLE `inventory_tracker` (
  `IT_ID` int(11) NOT NULL,
  `I_ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `reference_ticket` int(11) NOT NULL,
  `Input_by` int(11) NOT NULL,
  `Received_by` int(11) NOT NULL,
  `date_received` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_tracker`
--

INSERT INTO `inventory_tracker` (`IT_ID`, `I_ID`, `Quantity`, `reference_ticket`, `Input_by`, `Received_by`, `date_received`, `created_at`) VALUES
(1, 2, 191, 1, 1, 3, '2026-04-12 16:06:40', '2026-04-12 16:06:40'),
(2, 3, 200, 2, 1, 3, '2026-04-11 16:06:40', '2026-04-12 16:06:40'),
(3, 3, 0, 4, 1, 3, '2026-04-13 16:06:40', '2026-04-13 16:06:40'),
(4, 3, 20, 5, 1, 3, '2026-04-13 16:06:40', '2026-04-15 16:06:40'),
(5, 3, 5, 3, 1, 3, '2026-04-22 16:06:40', '2026-04-22 16:06:40'),
(6, 3, 20, 4, 1, 3, '2026-04-01 16:06:40', '2026-04-02 16:06:40'),
(7, 2, 5, 6, 1, 3, '2026-04-22 16:06:40', '2026-04-23 16:06:40'),
(8, 4, 5, 6, 1, 3, '2026-04-17 16:06:40', '2026-04-22 16:06:40'),
(9, 2, 5, 6, 1, 3, '2026-04-14 16:06:40', '2026-04-15 16:06:40'),
(10, 1, 1, 7, 1, 4, '2026-04-22 16:53:16', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_type`
--

CREATE TABLE `inventory_type` (
  `IT_ID` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_type`
--

INSERT INTO `inventory_type` (`IT_ID`, `type`, `created_at`) VALUES
(1, 'Ink', '2026-04-05 14:42:02'),
(2, 'HardWare', '2026-04-05 14:42:02'),
(3, 'Cleaner', '2026-04-05 14:43:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  ADD PRIMARY KEY (`IC_ID`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`I_ID`),
  ADD KEY `categ_ID` (`categ_ID`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `item_type` (`item_type`);

--
-- Indexes for table `inventory_tracker`
--
ALTER TABLE `inventory_tracker`
  ADD PRIMARY KEY (`IT_ID`),
  ADD KEY `I_ID` (`I_ID`),
  ADD KEY `Input_by` (`Input_by`),
  ADD KEY `Received_by` (`Received_by`),
  ADD KEY `reference_ticket` (`reference_ticket`);

--
-- Indexes for table `inventory_type`
--
ALTER TABLE `inventory_type`
  ADD PRIMARY KEY (`IT_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  MODIFY `IC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `I_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory_tracker`
--
ALTER TABLE `inventory_tracker`
  MODIFY `IT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `inventory_type`
--
ALTER TABLE `inventory_type`
  MODIFY `IT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  ADD CONSTRAINT `inventory_categories_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `chams_users`.`users` (`U_ID`);

--
-- Constraints for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD CONSTRAINT `inventory_items_ibfk_1` FOREIGN KEY (`categ_ID`) REFERENCES `inventory_categories` (`IC_ID`),
  ADD CONSTRAINT `inventory_items_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `chams_users`.`users` (`U_ID`),
  ADD CONSTRAINT `inventory_items_ibfk_3` FOREIGN KEY (`item_type`) REFERENCES `inventory_type` (`IT_ID`);

--
-- Constraints for table `inventory_tracker`
--
ALTER TABLE `inventory_tracker`
  ADD CONSTRAINT `inventory_tracker_ibfk_1` FOREIGN KEY (`I_ID`) REFERENCES `inventory_items` (`I_ID`),
  ADD CONSTRAINT `inventory_tracker_ibfk_2` FOREIGN KEY (`Input_by`) REFERENCES `chams_users`.`users` (`U_ID`),
  ADD CONSTRAINT `inventory_tracker_ibfk_3` FOREIGN KEY (`Received_by`) REFERENCES `chams_users`.`users` (`U_ID`),
  ADD CONSTRAINT `inventory_tracker_ibfk_4` FOREIGN KEY (`reference_ticket`) REFERENCES `chams_ticketing`.`tickets` (`T_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
