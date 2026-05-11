-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2026 at 07:34 PM
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
-- Database: `chams_ticketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `T_ID` int(11) NOT NULL,
  `ticket_num` varchar(50) DEFAULT NULL,
  `Title` varchar(255) NOT NULL,
  `T_description` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `t_type` int(50) DEFAULT NULL,
  `Priority` enum('Unlabeled','Low','Medium','High') NOT NULL DEFAULT 'Unlabeled',
  `Status` enum('Unresolved','Resolved','Ongoing') NOT NULL DEFAULT 'Unresolved',
  `Created_By` int(11) NOT NULL,
  `Assigned_To` int(11) DEFAULT NULL,
  `Dept_ID` int(11) NOT NULL,
  `issued_item_id` int(11) DEFAULT NULL,
  `issued_qty` int(11) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `due_date` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `resolved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`T_ID`, `ticket_num`, `Title`, `T_description`, `attachment`, `t_type`, `Priority`, `Status`, `Created_By`, `Assigned_To`, `Dept_ID`, `issued_item_id`, `issued_qty`, `created_at`, `due_date`, `updated_at`, `resolved_at`) VALUES
(1, 'TICKET-6DE58F', 'penge item', 'test', NULL, 5, 'Medium', 'Resolved', 3, 2, 4, 2, 191, '2026-04-12 19:46:18', NULL, '2026-04-21 00:43:13', '2026-04-12 22:06:39'),
(2, 'TICKET-3C2E65', 'test 2', 'test 2', NULL, 5, 'Low', 'Resolved', 3, 5, 4, 3, 200, '2026-04-12 19:48:11', NULL, '2026-04-12 22:12:25', '2026-04-12 22:06:39'),
(3, 'TICKET-8068CE', 'test 3', 'test 3', NULL, 5, 'Low', 'Resolved', 3, 2, 4, 3, 5, '2026-04-12 19:48:17', NULL, '2026-04-12 22:07:44', '2026-04-18 19:33:20'),
(4, 'TICKET-1F726D', 'test3', 'test3', NULL, 4, 'High', 'Resolved', 3, NULL, 4, 3, 20, '2026-04-12 22:15:12', '2026-04-13 22:19:00', '2026-04-17 21:11:35', '2026-04-18 19:33:20'),
(5, 'TICKET-8F02E4', 'he', 'test', NULL, 3, 'Medium', 'Resolved', 3, 2, 4, 3, 20, '2026-04-12 22:53:02', NULL, '2026-04-17 21:09:12', '2026-04-18 19:33:20'),
(6, 'TICKET-02B7D8', 'test', 'test', NULL, 2, 'Medium', 'Resolved', 3, 5, 4, 2, 5, '2026-04-18 00:29:09', NULL, '2026-04-21 01:20:14', '2026-04-21 01:20:14'),
(7, 'TICKET-FC6A25', 'test', 'test', NULL, 5, 'High', 'Resolved', 4, 2, 2, 1, 1, '2026-04-18 00:52:12', '2026-04-17 00:54:00', '2026-04-21 00:55:54', '2026-04-18 19:33:20'),
(8, 'TICKET-06D044', 'aaaaaa', 'aa', NULL, 4, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 18:07:00', NULL, '2026-04-26 20:50:13', '2026-04-26 20:50:13'),
(9, 'TICKET-B8D69B', '', '', 'CHAMS_69eb40d638825.jpg', NULL, '', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 18:07:18', NULL, '2026-04-24 19:13:47', '2026-04-24 19:13:47'),
(10, 'TICKET-280887', 'e', 'e', NULL, 4, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 19:14:07', NULL, '2026-04-26 20:50:06', '2026-04-26 20:50:06'),
(11, 'TICKET-C02F7B', 'test', 'test', 'CHAMS_69eb508ee3f6e.jpg', 4, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 19:14:22', NULL, '2026-04-26 20:11:30', '2026-04-26 20:11:30'),
(12, 'TICKET-C6D87B', 'hello', 'hi', NULL, 3, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 19:14:29', NULL, '2026-04-26 20:10:47', '2026-04-26 20:10:47'),
(13, 'TICKET-3157D7', 'lol', 'lol', NULL, 4, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 19:14:35', NULL, '2026-04-26 19:03:28', '2026-04-26 19:03:28'),
(14, 'TICKET-5BB716', 'test ajax', 'test', NULL, 5, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-27 19:06:19', NULL, '2026-04-27 23:44:32', '2026-04-27 23:44:32'),
(15, 'TICKET-621295', 'asdf', 'asf', NULL, 4, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-27 19:32:03', NULL, '2026-04-28 15:57:48', '2026-04-28 15:57:48'),
(16, 'TICKET-D33C21', 'afs', 'afs', NULL, 4, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-27 19:32:52', NULL, '2026-04-28 15:57:51', '2026-04-28 15:57:51'),
(17, 'TICKET-5F3D15', 'sasa', 'asas', NULL, 4, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-28 15:35:54', NULL, '2026-04-28 16:09:24', '2026-04-28 16:09:24'),
(18, 'TICKET-231E57', 'ra', 'ra', NULL, 5, 'Unlabeled', 'Resolved', 3, 5, 4, NULL, 1, '2026-04-28 15:58:01', NULL, '2026-04-28 16:08:44', '2026-04-28 16:08:44'),
(19, 'TICKET-0912B1', 'fafa', 'fafa', NULL, 3, 'Unlabeled', 'Resolved', 3, 5, 4, NULL, 1, '2026-04-28 15:58:18', NULL, '2026-04-28 16:08:41', '2026-04-28 16:08:41'),
(20, 'TICKET-5C773F', 'sa', 'sa', NULL, 4, 'Unlabeled', 'Resolved', 3, 5, 4, NULL, 1, '2026-04-28 16:01:07', NULL, '2026-04-28 16:08:29', '2026-04-28 16:08:29'),
(23, 'TICKET-E077B5', 'asd', 'asd', NULL, 4, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-28 20:52:38', NULL, '2026-04-30 16:45:59', '2026-04-30 16:45:59'),
(24, 'TICKET-4F1F7A', 'asd', 'asd', NULL, 4, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-28 20:52:43', NULL, '2026-04-30 16:38:08', '2026-04-30 16:38:08'),
(25, 'TICKET-C127A8', 'das', 'das', NULL, 2, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-28 20:53:02', NULL, '2026-04-30 16:38:02', '2026-04-28 20:58:49'),
(28, 'TICKET-F1127E', 'asd', 'asd', NULL, 4, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 13:18:45', NULL, '2026-04-30 16:32:39', '2026-04-30 16:32:39'),
(29, 'TICKET-43F9A5', 'test dash', 'test dash', NULL, 5, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-30 13:45:02', NULL, '2026-04-30 16:33:00', '2026-04-30 16:33:00'),
(30, 'TICKET-133AE7', 'ASD', 'ASD', NULL, 4, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 18:56:17', NULL, '2026-04-30 19:02:55', '2026-05-08 22:21:58'),
(31, 'TICKET-D03FC5', 'sad', 'asd', NULL, 5, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:05:14', NULL, '2026-04-30 19:30:40', '2026-04-30 19:30:40'),
(32, 'TICKET-8D41FF', 'testimh', 'test img', 'CHAMS_69f33780eb817.jpg', 1, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:05:36', NULL, '2026-04-30 19:31:48', '2026-04-30 19:31:48'),
(33, 'TICKET-C16975', 'asd', 'asd', NULL, 4, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:08:03', NULL, '2026-04-30 19:30:47', '2026-04-30 19:30:47'),
(34, 'TICKET-53FBE7', 'asd', 'asd', NULL, 4, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:12:20', NULL, '2026-04-30 19:22:32', '2026-04-30 19:22:32'),
(35, 'TICKET-56BE6E', 'asd', 'asd', NULL, 5, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:22:42', NULL, '2026-05-01 23:55:49', '2026-05-01 23:55:49'),
(36, 'TICKET-A495D9', 'asd', 'asd', NULL, 5, 'High', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:29:08', '2026-05-07 22:10:00', '2026-05-08 22:17:41', '2026-05-08 22:17:46'),
(37, 'TICKET-6DA9CC', 'test', 'test', NULL, 4, 'High', 'Resolved', 3, 2, 4, NULL, 1, '2026-05-05 19:28:00', '2026-05-07 18:54:00', '2026-05-11 11:16:21', '2026-05-11 11:16:21'),
(39, 'TICKET-4BF79F', 'test', 'test', NULL, 4, 'Unlabeled', 'Resolved', 3, 6, 4, NULL, 1, '2026-05-11 11:37:36', NULL, '2026-05-11 11:40:55', '2026-05-11 11:40:55'),
(40, 'TICKET-0F675C', 'test', 'test', NULL, 4, 'Unlabeled', 'Resolved', 3, 6, 4, NULL, 1, '2026-05-11 11:44:23', NULL, '2026-05-11 12:07:37', '2026-05-11 12:07:37'),
(43, 'TICKET-D8AB38', 'ss', 'ss', NULL, 4, 'High', 'Resolved', 3, 5, 4, 6, 200, '2026-05-11 14:09:31', '2026-05-11 23:15:00', '2026-05-11 23:09:59', '2026-05-11 23:09:59'),
(44, 'TICKET-B7D3BC', '', '20 005', NULL, 5, 'Unlabeled', 'Resolved', 3, 2, 4, 6, 300, '2026-05-11 23:03:48', NULL, '2026-05-11 23:55:26', '2026-05-11 23:55:26'),
(45, 'TICKET-22654F', '', 'test', NULL, 4, 'Unlabeled', 'Unresolved', 3, NULL, 4, NULL, 0, '2026-05-12 00:05:14', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_categories`
--

CREATE TABLE `ticket_categories` (
  `TC_ID` int(11) NOT NULL,
  `categ_name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_categories`
--

INSERT INTO `ticket_categories` (`TC_ID`, `categ_name`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'Technical Support', '2026-03-31 00:00:00', NULL, 1),
(2, 'Software Issue', '2026-03-31 00:00:00', NULL, 1),
(3, 'Hardware Issue', '2026-03-31 00:00:00', NULL, 1),
(4, 'Network/Internet', '2026-03-31 00:00:00', NULL, 1),
(5, 'Request Consumables', '2026-04-10 20:01:42', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_comments`
--

CREATE TABLE `ticket_comments` (
  `id` int(11) NOT NULL,
  `T_ID` int(11) DEFAULT NULL,
  `U_ID` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_comments`
--

INSERT INTO `ticket_comments` (`id`, `T_ID`, `U_ID`, `comment_text`, `created_at`) VALUES
(1, 44, 2, 'test', '2026-05-11 15:47:08'),
(2, 37, 2, 'test2', '2026-05-11 15:54:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`T_ID`),
  ADD UNIQUE KEY `ticket_num` (`ticket_num`),
  ADD KEY `Assigned_To` (`Assigned_To`),
  ADD KEY `tickets_ibfk_2` (`Created_By`),
  ADD KEY `t_type` (`t_type`),
  ADD KEY `Dept_ID` (`Dept_ID`),
  ADD KEY `issued_item_id` (`issued_item_id`);

--
-- Indexes for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD PRIMARY KEY (`TC_ID`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `T_ID` (`T_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `T_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `TC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`Assigned_To`) REFERENCES `chams_users`.`users` (`U_ID`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`Created_By`) REFERENCES `chams_users`.`users` (`U_ID`),
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`t_type`) REFERENCES `ticket_categories` (`TC_ID`),
  ADD CONSTRAINT `tickets_ibfk_4` FOREIGN KEY (`Dept_ID`) REFERENCES `chams_users`.`departments` (`D_ID`),
  ADD CONSTRAINT `tickets_ibfk_5` FOREIGN KEY (`issued_item_id`) REFERENCES `chams_inventory`.`inventory_items` (`I_ID`);

--
-- Constraints for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD CONSTRAINT `ticket_categories_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `chams_users`.`users` (`U_ID`);

--
-- Constraints for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  ADD CONSTRAINT `ticket_comments_ibfk_1` FOREIGN KEY (`T_ID`) REFERENCES `tickets` (`T_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
