-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql200.infinityfree.com
-- Generation Time: Jul 05, 2026 at 10:49 PM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41961525_chams_central`
--

-- --------------------------------------------------------

--
-- Table structure for table `act_logs`
--

CREATE TABLE `act_logs` (
  `A_ID` int(11) NOT NULL,
  `U_ID` int(11) NOT NULL,
  `act` varchar(255) NOT NULL,
  `module` varchar(100) NOT NULL,
  `ref_ID` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `act_logs`
--

INSERT INTO `act_logs` (`A_ID`, `U_ID`, `act`, `module`, `ref_ID`, `created_at`) VALUES
(1, 1, 'Updated Category: Computers', '3', 0, '2026-04-09 23:39:03'),
(2, 1, 'Updated Category: Computers', '3', 0, '2026-04-09 23:39:30'),
(3, 1, 'Updated Category: Peripherals', '2', 0, '2026-04-09 23:39:41'),
(4, 1, 'Updated Category: Networking', '1', 0, '2026-04-09 23:40:06'),
(5, 1, 'Updated Category: Consumables', '4', 0, '2026-04-09 23:43:34'),
(6, 1, 'Updated Category: Networking', '1', 0, '2026-04-09 23:48:45'),
(7, 1, 'Updated Category: Computers', '3', 0, '2026-04-10 14:47:31'),
(8, 1, 'Updated Category: Computers', 'Inventory', 3, '2026-04-10 14:47:31'),
(9, 2, 'Accepted Ticket: hello', 'Ticketing', 12, '2026-04-10 15:02:03'),
(10, 2, 'Modified Ticket Status to Ongoing', 'Ticketing', 12, '2026-04-10 15:02:03'),
(11, 2, 'Resolved Ticket: hello', 'Ticketing', 12, '2026-04-10 15:02:07'),
(12, 2, 'Modified Ticket Status to Resolved', 'Ticketing', 12, '2026-04-10 15:02:07'),
(13, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 15, '2026-04-10 16:03:54'),
(14, 2, 'Accepted Ticket: 123', 'Ticketing', 16, '2026-04-10 22:01:04'),
(15, 2, 'Modified Ticket Status to Ongoing', 'Ticketing', 16, '2026-04-10 22:01:04'),
(16, 2, 'Resolved Ticket: 123', 'Ticketing', 16, '2026-04-10 22:01:22'),
(17, 2, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-10 22:01:22'),
(18, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 17, '2026-04-10 22:26:40'),
(19, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 17, '2026-04-10 22:28:12'),
(20, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 17, '2026-04-10 22:28:29'),
(21, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 17, '2026-04-10 22:28:59'),
(22, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 17, '2026-04-10 22:29:15'),
(23, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 17, '2026-04-10 22:29:33'),
(24, 2, 'Resolved Ticket: penge ink', 'Ticketing', 17, '2026-04-10 22:29:56'),
(25, 2, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-10 22:29:56'),
(26, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-10 22:48:20'),
(27, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-10 22:50:30'),
(28, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-10 22:51:44'),
(29, 1, 'Issued item to Ticket #17', 'Inventory', 3, '2026-04-10 23:23:25'),
(30, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-10 23:42:52'),
(31, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 14, '2026-04-11 00:11:43'),
(32, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:20:48'),
(33, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:20:49'),
(34, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:20:57'),
(35, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:20:57'),
(36, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:20:58'),
(37, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:20:59'),
(38, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:20:59'),
(39, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:21:00'),
(40, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:21:00'),
(41, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:21:01'),
(42, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:21:01'),
(43, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-11 00:31:08'),
(44, 1, 'Issued 200 units for Ticket #17', 'Inventory', 3, '2026-04-11 00:35:00'),
(45, 1, 'Issued 3 to Ticket #17', 'Inventory', 3, '2026-04-11 00:35:00'),
(46, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 17:24:53'),
(47, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 17:41:39'),
(48, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 17:44:26'),
(49, 1, 'Updated Category: DEPLETED', 'Inventory', 5, '2026-04-12 17:53:54'),
(50, 1, 'Updated Category: DEPLETED', 'Inventory', 5, '2026-04-12 17:54:23'),
(51, 1, 'Updated Category: DEPLETED', 'Inventory', 5, '2026-04-12 17:54:32'),
(52, 1, 'Updated Category: DEPLETED', 'Inventory', 5, '2026-04-12 17:57:40'),
(53, 1, 'Updated Item: 005', 'Inventory', 3, '2026-04-12 18:03:15'),
(54, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 18:06:52'),
(55, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 18:08:00'),
(56, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 18:11:15'),
(57, 1, 'Issued 1 units for Ticket #16', 'Inventory', 3, '2026-04-12 18:53:28'),
(58, 1, 'Issued 3 to Ticket #16', 'Inventory', 3, '2026-04-12 18:53:28'),
(59, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 18:53:46'),
(60, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 18:53:58'),
(61, 1, 'Increased issued qty by 50 for Ticket #16', 'Inventory', 3, '2026-04-12 18:59:53'),
(62, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 18:59:53'),
(63, 1, 'Increased issued qty by 50 for Ticket #16', 'Inventory', 3, '2026-04-12 19:04:35'),
(64, 1, 'Decreased issued qty by 1 for Ticket #16', 'Inventory', 3, '2026-04-12 19:07:02'),
(65, 1, 'Decreased issued qty by 1 for Ticket #16', 'Inventory', 3, '2026-04-12 19:07:12'),
(66, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:07:12'),
(67, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:07:20'),
(68, 1, 'Decreased issued qty by 49 for Ticket #16', 'Inventory', 3, '2026-04-12 19:07:31'),
(69, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:07:31'),
(70, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 19:07:52'),
(71, 1, 'Decreased issued qty by 50 for Ticket #17', 'Inventory', 2, '2026-04-12 19:08:12'),
(72, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 19:08:12'),
(73, 1, 'Increased issued qty by 49 for Ticket #16', 'Inventory', 3, '2026-04-12 19:08:26'),
(74, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:08:26'),
(75, 1, 'Decreased issued qty by 149 for Ticket #16', 'Inventory', 3, '2026-04-12 19:08:40'),
(76, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:08:40'),
(77, 1, 'Increased issued qty by 150 for Ticket #16', 'Inventory', 3, '2026-04-12 19:08:59'),
(78, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:08:59'),
(79, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:37:36'),
(80, 1, 'Decreased issued qty by 50 for Ticket #16', 'Inventory', 2, '2026-04-12 19:37:59'),
(81, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:37:59'),
(82, 1, 'Decreased issued qty by 51 for Ticket #16', 'Inventory', 2, '2026-04-12 19:38:39'),
(83, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:38:39'),
(84, 1, 'Increased issued qty by 49 for Ticket #17', 'Inventory', 2, '2026-04-12 19:39:05'),
(85, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 19:39:05'),
(86, 1, 'Increased issued qty by 1 for Ticket #17', 'Inventory', 2, '2026-04-12 19:39:14'),
(87, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 17, '2026-04-12 19:39:14'),
(88, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 16, '2026-04-12 19:39:34'),
(89, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 1, '2026-04-12 19:46:45'),
(90, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 2, '2026-04-12 19:50:27'),
(91, 1, 'Issued 101 units for Ticket #1', 'Inventory', 2, '2026-04-12 19:50:40'),
(92, 1, 'Issued 2 to Ticket #1', 'Inventory', 2, '2026-04-12 19:50:40'),
(93, 1, 'Issued 200 units for Ticket #2', 'Inventory', 3, '2026-04-12 19:50:53'),
(94, 1, 'Issued 3 to Ticket #2', 'Inventory', 3, '2026-04-12 19:50:53'),
(95, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 2, '2026-04-12 19:51:02'),
(96, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 2, '2026-04-12 19:51:10'),
(97, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 1, '2026-04-12 21:58:51'),
(98, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 2, '2026-04-12 21:59:42'),
(99, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 2, '2026-04-12 22:00:06'),
(100, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 2, '2026-04-12 22:00:15'),
(101, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 2, '2026-04-12 22:00:22'),
(102, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 3, '2026-04-12 22:07:44'),
(103, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 1, '2026-04-12 22:08:48'),
(104, 1, 'Adjusted Qty in Ticket #2: 100 -> 200', 'Ticketing', 2, '2026-04-12 22:12:25'),
(105, 1, 'Modified Ticket Status to Resolved', 'Ticketing', 2, '2026-04-12 22:12:25'),
(106, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 4, '2026-04-12 22:15:55'),
(107, 1, 'Modified Ticket Status to Unresolved', 'Ticketing', 4, '2026-04-12 22:16:00'),
(108, 1, 'Updated Ticket #4 (Priority)', 'Ticketing', 4, '2026-04-12 22:18:29'),
(109, 1, 'Updated Ticket #4 (Assigned Technician)', 'Ticketing', 4, '2026-04-12 22:18:43'),
(110, 1, 'Saved changes to Ticket #4', 'Ticketing', 4, '2026-04-12 22:19:26'),
(111, 1, 'Updated Ticket #4 (Status to Ongoing)', 'Ticketing', 4, '2026-04-12 22:19:36'),
(112, 1, 'Updated Ticket #4 (Assigned to Staff # 2)', 'Ticketing', 4, '2026-04-12 22:20:47'),
(113, 1, 'Updated Ticket #4 (Assigned to Staff # Array)', 'Ticketing', 4, '2026-04-12 22:23:56'),
(114, 1, 'Updated Ticket #4 (Assigned to Staff # staff staff)', 'Ticketing', 4, '2026-04-12 22:28:33'),
(115, 1, 'Updated Ticket #4 (Assigned to Unknown Staff)', 'Ticketing', 4, '2026-04-12 22:28:53'),
(116, 1, 'Updated Ticket #4 (Status to Unresolved, Assigned to .)', 'Ticketing', 4, '2026-04-12 22:29:53'),
(117, 1, 'Updated Ticket #4 (Status to Ongoing, Assigned to .)', 'Ticketing', 4, '2026-04-12 22:30:37'),
(118, 1, 'Updated Ticket #4 (Status to Unresolved)', 'Ticketing', 4, '2026-04-12 22:31:11'),
(119, 1, 'Updated Ticket #4 (Status to Resolved)', 'Ticketing', 4, '2026-04-12 22:31:26'),
(120, 1, 'Updated Ticket #4 (Assigned to staff staff.)', 'Ticketing', 4, '2026-04-12 22:31:33'),
(121, 3, 'Saved changes to Ticket #5', 'Ticketing', 5, '2026-04-12 22:53:20'),
(122, 1, 'Updated Item: 005', 'Inventory', 3, '2026-04-17 11:34:11'),
(123, 1, 'Updated Item: 005', 'Inventory', 3, '2026-04-17 11:51:31'),
(124, 1, 'Updated Item: 005', 'Inventory', 3, '2026-04-17 11:52:43'),
(125, 1, 'Updated Ticket #5 (Status to Resolved, Priority, Assigned to staff staff.)', 'Ticketing', 5, '2026-04-17 11:52:57'),
(126, 1, 'Issued 10 units for Ticket #4', 'Inventory', 3, '2026-04-17 13:58:55'),
(127, 1, 'Issued 3 to Ticket #4', 'Inventory', 3, '2026-04-17 13:58:55'),
(128, 1, 'Updated Item: 005', 'Inventory', 3, '2026-04-17 14:16:28'),
(129, 1, 'Issued 5 units for Ticket #5', 'Inventory', 3, '2026-04-17 14:16:35'),
(130, 1, 'Issued 3 to Ticket #5', 'Inventory', 3, '2026-04-17 14:16:35'),
(131, 1, 'Updated Item: 005', 'Inventory', 3, '2026-04-17 21:08:54'),
(132, 1, 'Adjusted Qty in Ticket #5: 5 -> 20', 'Ticketing', 5, '2026-04-17 21:09:12'),
(133, 1, 'Saved changes to Ticket #5', 'Ticketing', 5, '2026-04-17 21:09:12'),
(134, 1, 'Issued 5 units for Ticket #3', 'Inventory', 3, '2026-04-17 21:09:52'),
(135, 1, 'Issued 3 to Ticket #3', 'Inventory', 3, '2026-04-17 21:09:52'),
(136, 1, 'Updated Item: 005', 'Inventory', 3, '2026-04-17 21:11:18'),
(137, 1, 'Adjusted Qty in Ticket #4: 10 -> 0', 'Ticketing', 4, '2026-04-17 21:11:28'),
(138, 1, 'Saved changes to Ticket #4', 'Ticketing', 4, '2026-04-17 21:11:28'),
(139, 1, 'Saved changes to Ticket #4', 'Ticketing', 4, '2026-04-17 21:11:35'),
(140, 1, 'Issued 20 units for Ticket #4', 'Inventory', 3, '2026-04-17 21:11:43'),
(141, 1, 'Issued 3 to Ticket #4', 'Inventory', 3, '2026-04-17 21:11:43'),
(142, 1, 'Updated Ticket #6 (Status to Resolved, Priority, Assigned to another staff.)', 'Ticketing', 6, '2026-04-18 00:29:24'),
(143, 1, 'Issued 5 units for Ticket #6', 'Inventory', 4, '2026-04-18 00:29:30'),
(144, 1, 'Issued 4 to Ticket #6', 'Inventory', 4, '2026-04-18 00:29:30'),
(145, 1, 'Swapped Item in Ticket #6: from ID 4 to ID 2', 'Ticketing', 6, '2026-04-18 00:45:08'),
(146, 1, 'Saved changes to Ticket #6', 'Ticketing', 6, '2026-04-18 00:45:08'),
(147, 1, 'Saved changes to Ticket #6', 'Ticketing', 6, '2026-04-18 00:45:45'),
(148, 1, 'Issued 5 units for Ticket #6', 'Inventory', 4, '2026-04-18 00:47:11'),
(149, 1, 'Issued Item #4 to Ticket #6', 'Inventory', 4, '2026-04-18 00:47:12'),
(150, 1, 'Updated Ticket #7 (Priority, Assigned to staff staff.)', 'Ticketing', 7, '2026-04-18 00:52:37'),
(151, 1, 'Updated Ticket #7 (Status to Ongoing)', 'Ticketing', 7, '2026-04-18 00:52:42'),
(152, 1, 'Updated Ticket #7 (Status to Resolved)', 'Ticketing', 7, '2026-04-18 00:52:48'),
(153, 1, 'Saved changes to Ticket #7', 'Ticketing', 7, '2026-04-18 00:53:46'),
(154, 1, 'Updated Ticket #7 (Status to Ongoing)', 'Ticketing', 7, '2026-04-18 00:54:41'),
(155, 1, 'Updated Ticket #7 (Status to Resolved)', 'Ticketing', 7, '2026-04-18 01:00:04'),
(156, 1, 'Updated Ticket #1 (Status to N/A, Priority)', 'Ticketing', 1, '2026-04-19 14:46:13'),
(157, 1, 'Updated Ticket #1 (Status to N/A, Priority)', 'Ticketing', 1, '2026-04-19 14:46:19'),
(158, 1, 'Updated Ticket #1 (Status to N/A, Priority)', 'Ticketing', 1, '2026-04-19 14:46:23'),
(159, 1, 'Updated Maintenance #1', 'Maintenance', 1, '2026-04-19 14:58:57'),
(160, 1, 'Updated Maintenance #1', 'Maintenance', 1, '2026-04-19 14:59:05'),
(161, 1, 'Updated Maintenance #1', 'Maintenance', 1, '2026-04-19 14:59:09'),
(162, 1, 'Updated Maintenance #3', 'Maintenance', 3, '2026-04-20 21:02:45'),
(163, 1, 'Updated Maintenance #5', 'Maintenance', 5, '2026-04-20 21:05:22'),
(164, 1, 'Updated Maintenance #3', 'Maintenance', 3, '2026-04-20 21:21:01'),
(165, 1, 'Updated Maintenance #3', 'Maintenance', 3, '2026-04-20 21:21:09'),
(166, 1, 'Updated Maintenance #3', 'Maintenance', 3, '2026-04-20 21:24:53'),
(167, 1, 'Updated Maintenance #3', 'Maintenance', 3, '2026-04-20 21:24:57'),
(168, 1, 'Updated Maintenance #3', 'Maintenance', 3, '2026-04-20 21:36:03'),
(169, 1, 'Deleted Maintenance #3', 'Maintenance', 3, '2026-04-20 23:38:23'),
(170, 1, 'Updated Ticket #1 (Status to Resolved, Priority)', 'Ticketing', 1, '2026-04-21 00:43:13'),
(171, 1, 'Saved changes to Ticket #7', 'Ticketing', 7, '2026-04-21 00:55:54'),
(172, 1, 'Reopened Ticket #<br />\r\n<b>Warning</b>:  Undefined variable $ticket in <b>C:\\xampp\\htdocs\\CHAMS\\Modules\\view.php</b> on line <b>326</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\CHAMS\\Module', '', 0, '2026-04-21 01:09:30'),
(173, 1, 'Reopened Ticket #<br />\r\n<b>Warning</b>:  Undefined variable $ticket in <b>C:\\xampp\\htdocs\\CHAMS\\Modules\\view.php</b> on line <b>326</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\CHAMS\\Module', '', 0, '2026-04-21 01:10:05'),
(174, 1, 'Reopened Ticket #<br />\r\n<b>Warning</b>:  Undefined variable $ticket in <b>C:\\xampp\\htdocs\\CHAMS\\Modules\\view.php</b> on line <b>326</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\CHAMS\\Module', '', 0, '2026-04-21 01:10:09'),
(175, 1, 'Reopened Ticket #<br />\r\n<b>Warning</b>:  Undefined variable $ticket in <b>C:\\xampp\\htdocs\\CHAMS\\Modules\\view.php</b> on line <b>326</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\CHAMS\\Module', 'Ticketing', 0, '2026-04-21 01:12:55'),
(176, 1, 'Reopened Ticket #<br />\r\n<b>Warning</b>:  Undefined variable $ticket in <b>C:\\xampp\\htdocs\\CHAMS\\Modules\\view.php</b> on line <b>326</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\CHAMS\\Module', 'Ticketing', 0, '2026-04-21 01:13:46'),
(177, 1, 'Reopened Ticket #<br />\r\n<b>Warning</b>:  Undefined variable $ticket in <b>C:\\xampp\\htdocs\\CHAMS\\Modules\\view.php</b> on line <b>326</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\CHAMS\\Module', 'Ticketing', 0, '2026-04-21 01:13:53'),
(178, 1, 'Reopened Ticket #<br />\r\n<b>Warning</b>:  Undefined variable $ticket in <b>C:\\xampp\\htdocs\\CHAMS\\Modules\\view.php</b> on line <b>326</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\CHAMS\\Module', 'Ticketing', 0, '2026-04-21 01:13:58'),
(179, 1, 'Reopened Ticket #<br />\r\n<b>Warning</b>:  Undefined variable $ticket in <b>C:\\xampp\\htdocs\\CHAMS\\Modules\\view.php</b> on line <b>326</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\CHAMS\\Module', 'Ticketing', 0, '2026-04-21 01:14:05'),
(180, 1, 'Reopened Ticket #<br />\r\n<b>Warning</b>:  Undefined variable $ticket in <b>C:\\xampp\\htdocs\\CHAMS\\Modules\\view.php</b> on line <b>326</b><br />\r\n<br />\r\n<b>Warning</b>:  Trying to access array offset on value of type null in <b>C:\\xampp\\htdocs\\CHAMS\\Module', 'Ticketing', 0, '2026-04-21 01:16:41'),
(181, 1, 'Reopened Ticket #6', 'Ticketing', 6, '2026-04-21 01:19:07'),
(182, 1, 'Saved changes to Ticket #6', 'Ticketing', 6, '2026-04-21 01:19:58'),
(183, 1, 'Updated Ticket #6 (Status to Resolved)', 'Ticketing', 6, '2026-04-21 01:20:14'),
(184, 1, 'Issued 5 units for Ticket #6', 'Inventory', 2, '2026-04-21 01:23:04'),
(185, 1, 'Issued Item #2 to Ticket #6', 'Inventory', 2, '2026-04-21 01:23:04'),
(186, 1, 'Issued 1 units for Ticket #7', 'Inventory', 1, '2026-04-22 16:53:16'),
(187, 1, 'Issued Item #1 to Ticket #7', 'Inventory', 1, '2026-04-22 16:53:16'),
(188, 2, 'Accepted Ticket: ', 'Ticketing', 9, '2026-04-24 18:27:46'),
(189, 2, 'Accepted Ticket: ', 'Ticketing', 8, '2026-04-24 18:28:13'),
(190, 2, 'Accepted Ticket: ', 'Ticketing', 8, '2026-04-24 18:34:31'),
(191, 2, 'Accepted Ticket: ', 'Ticketing', 8, '2026-04-24 18:34:34'),
(192, 2, 'Accepted Ticket: ', 'Ticketing', 8, '2026-04-24 18:36:49'),
(193, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 18:45:06'),
(194, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 18:45:18'),
(195, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 19:01:07'),
(196, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 19:02:41'),
(197, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 19:06:37'),
(198, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 19:07:02'),
(199, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 19:11:39'),
(200, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 19:11:44'),
(201, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 19:11:50'),
(202, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 19:12:00'),
(203, 2, 'Accepted Ticket: aaaaaa', 'Ticketing', 8, '2026-04-24 19:12:12'),
(204, 2, 'Updated Ticket #8 (Status to Ongoing, Assigned to staff staff.)', 'Ticketing', 8, '2026-04-24 19:12:13'),
(205, 2, 'Resolved Ticket: ', 'Ticketing', 9, '2026-04-24 19:13:47'),
(206, 2, 'Updated Ticket #9 (Status to Resolved)', 'Ticketing', 9, '2026-04-24 19:13:47'),
(207, 2, 'Accepted Ticket: lol', 'Ticketing', 13, '2026-04-26 18:28:31'),
(208, 2, 'Updated Ticket #13 (Status to Ongoing, Assigned to staff staff.)', 'Ticketing', 13, '2026-04-26 18:28:31'),
(209, 2, 'Resolved Ticket: lol', 'Ticketing', 13, '2026-04-26 19:03:28'),
(210, 2, 'Updated Ticket #13 (Status to Resolved)', 'Ticketing', 13, '2026-04-26 19:03:28'),
(211, 2, 'Accepted Ticket: hello', 'Ticketing', 12, '2026-04-26 20:08:16'),
(212, 2, 'Updated Ticket #12 (Status to Ongoing, Assigned to staff staff.)', 'Ticketing', 12, '2026-04-26 20:08:16'),
(213, 2, 'Resolved Ticket: hello', 'Ticketing', 12, '2026-04-26 20:10:47'),
(214, 2, 'Updated Ticket #12 (Status to Resolved)', 'Ticketing', 12, '2026-04-26 20:10:47'),
(215, 2, 'Accepted Ticket: test', 'Ticketing', 11, '2026-04-26 20:11:22'),
(216, 2, 'Updated Ticket #11 (Status to Ongoing, Assigned to staff staff.)', 'Ticketing', 11, '2026-04-26 20:11:22'),
(217, 2, 'Resolved Ticket: test', 'Ticketing', 11, '2026-04-26 20:11:30'),
(218, 2, 'Updated Ticket #11 (Status to Resolved)', 'Ticketing', 11, '2026-04-26 20:11:30'),
(219, 2, 'Accepted Ticket: e', 'Ticketing', 10, '2026-04-26 20:50:05'),
(220, 2, 'Updated Ticket #10 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 10, '2026-04-26 20:50:05'),
(221, 2, 'Resolved Ticket: e', 'Ticketing', 10, '2026-04-26 20:50:06'),
(222, 2, 'Updated Ticket #10 (Status to Resolved)', 'Ticketing', 10, '2026-04-26 20:50:06'),
(223, 2, 'Resolved Ticket: aaaaaa', 'Ticketing', 8, '2026-04-26 20:50:13'),
(224, 2, 'Updated Ticket #8 (Status to Resolved)', 'Ticketing', 8, '2026-04-26 20:50:13'),
(225, 2, 'Accepted Ticket: afs', 'Ticketing', 16, '2026-04-27 22:22:14'),
(226, 2, 'Updated Ticket #16 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 16, '2026-04-27 22:22:14'),
(227, 2, 'Accepted Ticket: asdf', 'Ticketing', 15, '2026-04-27 22:43:09'),
(228, 2, 'Updated Ticket #15 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 15, '2026-04-27 22:43:09'),
(229, 2, 'Accepted Ticket: test ajax', 'Ticketing', 14, '2026-04-27 23:43:46'),
(230, 2, 'Updated Ticket #14 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 14, '2026-04-27 23:43:46'),
(231, 2, 'Resolved Ticket: test ajax', 'Ticketing', 14, '2026-04-27 23:44:32'),
(232, 2, 'Updated Ticket #14 (Status to Resolved)', 'Ticketing', 14, '2026-04-27 23:44:32'),
(233, 2, 'Accepted Ticket: sasa', 'Ticketing', 17, '2026-04-28 15:53:38'),
(234, 2, 'Updated Ticket #17 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 17, '2026-04-28 15:53:38'),
(235, 2, 'Resolved Ticket: asdf', 'Ticketing', 15, '2026-04-28 15:57:48'),
(236, 2, 'Updated Ticket #15 (Status to Resolved)', 'Ticketing', 15, '2026-04-28 15:57:48'),
(237, 2, 'Resolved Ticket: afs', 'Ticketing', 16, '2026-04-28 15:57:51'),
(238, 2, 'Updated Ticket #16 (Status to Resolved)', 'Ticketing', 16, '2026-04-28 15:57:51'),
(239, 5, 'Accepted Ticket: beep', 'Ticketing', 22, '2026-04-28 16:08:09'),
(240, 5, 'Updated Ticket #22 (Status to Ongoing, Assigned to another staff.)', 'Ticketing', 22, '2026-04-28 16:08:09'),
(241, 5, 'Resolved Ticket: beep', 'Ticketing', 22, '2026-04-28 16:08:13'),
(242, 5, 'Updated Ticket #22 (Status to Resolved)', 'Ticketing', 22, '2026-04-28 16:08:13'),
(243, 5, 'Accepted Ticket: sa', 'Ticketing', 20, '2026-04-28 16:08:28'),
(244, 5, 'Updated Ticket #20 (Status to Ongoing, Assigned to another staff.)', 'Ticketing', 20, '2026-04-28 16:08:28'),
(245, 5, 'Resolved Ticket: sa', 'Ticketing', 20, '2026-04-28 16:08:29'),
(246, 5, 'Updated Ticket #20 (Status to Resolved)', 'Ticketing', 20, '2026-04-28 16:08:29'),
(247, 5, 'Accepted Ticket: sasasa', 'Ticketing', 21, '2026-04-28 16:08:32'),
(248, 5, 'Updated Ticket #21 (Status to Ongoing, Assigned to another staff.)', 'Ticketing', 21, '2026-04-28 16:08:32'),
(249, 5, 'Resolved Ticket: sasasa', 'Ticketing', 21, '2026-04-28 16:08:33'),
(250, 5, 'Updated Ticket #21 (Status to Resolved)', 'Ticketing', 21, '2026-04-28 16:08:33'),
(251, 5, 'Accepted Ticket: fafa', 'Ticketing', 19, '2026-04-28 16:08:40'),
(252, 5, 'Updated Ticket #19 (Status to Ongoing, Assigned to another staff.)', 'Ticketing', 19, '2026-04-28 16:08:40'),
(253, 5, 'Resolved Ticket: fafa', 'Ticketing', 19, '2026-04-28 16:08:41'),
(254, 5, 'Updated Ticket #19 (Status to Resolved)', 'Ticketing', 19, '2026-04-28 16:08:41'),
(255, 5, 'Accepted Ticket: ra', 'Ticketing', 18, '2026-04-28 16:08:43'),
(256, 5, 'Updated Ticket #18 (Status to Ongoing, Assigned to another staff.)', 'Ticketing', 18, '2026-04-28 16:08:43'),
(257, 5, 'Resolved Ticket: ra', 'Ticketing', 18, '2026-04-28 16:08:44'),
(258, 5, 'Updated Ticket #18 (Status to Resolved)', 'Ticketing', 18, '2026-04-28 16:08:44'),
(259, 2, 'Resolved Ticket: sasa', 'Ticketing', 17, '2026-04-28 16:09:24'),
(260, 2, 'Updated Ticket #17 (Status to Resolved)', 'Ticketing', 17, '2026-04-28 16:09:24'),
(261, 1, 'Updated Ticket #29 (Assigned to anton coron Carimosanto .)', 'Ticketing', 29, '2026-04-30 16:04:18'),
(262, 2, 'Accepted Ticket: asd', 'Ticketing', 28, '2026-04-30 16:32:12'),
(263, 2, 'Updated Ticket #28 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 28, '2026-04-30 16:32:12'),
(264, 2, 'Resolved Ticket: asd', 'Ticketing', 28, '2026-04-30 16:32:39'),
(265, 2, 'Updated Ticket #28 (Status to Resolved)', 'Ticketing', 28, '2026-04-30 16:32:39'),
(266, 2, 'Resolved Ticket: test dash', 'Ticketing', 29, '2026-04-30 16:33:00'),
(267, 2, 'Updated Ticket #29 (Status to Resolved)', 'Ticketing', 29, '2026-04-30 16:33:00'),
(268, 2, 'Accepted Ticket: das', 'Ticketing', 25, '2026-04-30 16:37:59'),
(269, 2, 'Updated Ticket #25 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 25, '2026-04-30 16:37:59'),
(270, 2, 'Resolved Ticket: das', 'Ticketing', 25, '2026-04-30 16:38:01'),
(271, 2, 'Updated Ticket #25 (Status to Resolved)', 'Ticketing', 25, '2026-04-30 16:38:02'),
(272, 2, 'Accepted Ticket: asd', 'Ticketing', 24, '2026-04-30 16:38:06'),
(273, 2, 'Updated Ticket #24 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 24, '2026-04-30 16:38:06'),
(274, 2, 'Resolved Ticket: asd', 'Ticketing', 24, '2026-04-30 16:38:08'),
(275, 2, 'Updated Ticket #24 (Status to Resolved)', 'Ticketing', 24, '2026-04-30 16:38:08'),
(276, 2, 'Accepted Ticket: asd', 'Ticketing', 23, '2026-04-30 16:45:57'),
(277, 2, 'Updated Ticket #23 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 23, '2026-04-30 16:45:57'),
(278, 2, 'Resolved Ticket: asd', 'Ticketing', 23, '2026-04-30 16:45:59'),
(279, 2, 'Updated Ticket #23 (Status to Resolved)', 'Ticketing', 23, '2026-04-30 16:45:59'),
(280, 1, 'Updated Ticket #30 (Assigned to anton coron Carimosanto .)', 'Ticketing', 30, '2026-04-30 18:56:43'),
(281, 1, 'Updated Ticket #30 (Assigned to Unknown Staff.)', 'Ticketing', 30, '2026-04-30 19:02:30'),
(282, 1, 'Updated Ticket #30 (Assigned to anton coron Carimosanto .)', 'Ticketing', 30, '2026-04-30 19:02:55'),
(283, 2, 'Accepted Ticket: asd', 'Ticketing', 34, '2026-04-30 19:22:30'),
(284, 2, 'Updated Ticket #34 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 34, '2026-04-30 19:22:30'),
(285, 2, 'Resolved Ticket: asd', 'Ticketing', 34, '2026-04-30 19:22:32'),
(286, 2, 'Updated Ticket #34 (Status to Resolved)', 'Ticketing', 34, '2026-04-30 19:22:32'),
(287, 2, 'Accepted Ticket: asd', 'Ticketing', 36, '2026-04-30 19:29:27'),
(288, 2, 'Updated Ticket #36 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 36, '2026-04-30 19:29:27'),
(289, 2, 'Resolved Ticket: asd', 'Ticketing', 36, '2026-04-30 19:29:28'),
(290, 2, 'Updated Ticket #36 (Status to Resolved)', 'Ticketing', 36, '2026-04-30 19:29:28'),
(291, 2, 'Accepted Ticket: sad', 'Ticketing', 31, '2026-04-30 19:30:39'),
(292, 2, 'Updated Ticket #31 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 31, '2026-04-30 19:30:39'),
(293, 2, 'Resolved Ticket: sad', 'Ticketing', 31, '2026-04-30 19:30:40'),
(294, 2, 'Updated Ticket #31 (Status to Resolved)', 'Ticketing', 31, '2026-04-30 19:30:40'),
(295, 2, 'Accepted Ticket: asd', 'Ticketing', 33, '2026-04-30 19:30:46'),
(296, 2, 'Updated Ticket #33 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 33, '2026-04-30 19:30:46'),
(297, 2, 'Resolved Ticket: asd', 'Ticketing', 33, '2026-04-30 19:30:47'),
(298, 2, 'Updated Ticket #33 (Status to Resolved)', 'Ticketing', 33, '2026-04-30 19:30:47'),
(299, 2, 'Accepted Ticket: testimh', 'Ticketing', 32, '2026-04-30 19:31:46'),
(300, 2, 'Updated Ticket #32 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 32, '2026-04-30 19:31:46'),
(301, 2, 'Resolved Ticket: testimh', 'Ticketing', 32, '2026-04-30 19:31:48'),
(302, 2, 'Updated Ticket #32 (Status to Resolved)', 'Ticketing', 32, '2026-04-30 19:31:48'),
(303, 1, 'Updated Ticket #35 (Status to Resolved, Assigned to anton coron Carimosanto .)', 'Ticketing', 35, '2026-05-01 23:55:49'),
(304, 1, 'Reopened Ticket #36', 'Ticketing', 36, '2026-05-01 23:55:57'),
(305, 1, 'Updated Maintenance #5', 'Maintenance', 5, '2026-05-02 14:44:19'),
(306, 1, 'Updated Maintenance #4', 'Maintenance', 4, '2026-05-02 14:57:05'),
(307, 1, 'Updated Maintenance #2', 'Maintenance', 2, '2026-05-02 14:57:15'),
(308, 1, 'Deleted Maintenance #5', 'Maintenance', 5, '2026-05-02 15:19:25'),
(309, 1, 'Updated Maintenance #1', 'Maintenance', 1, '2026-05-02 15:19:33'),
(310, 2, 'Resolved Ticket: asd', 'Ticketing', 36, '2026-05-06 00:43:57'),
(311, 2, 'Updated Ticket #36 (Status to Resolved)', 'Ticketing', 36, '2026-05-06 00:43:57'),
(312, 2, 'Accepted Ticket: test', 'Ticketing', 37, '2026-05-06 01:08:17'),
(313, 2, 'Updated Ticket #37 (Status to Ongoing, Assigned to anton coron Carimosanto .)', 'Ticketing', 37, '2026-05-06 01:08:17'),
(314, 2, 'Resolved Ticket: test', 'Ticketing', 37, '2026-05-06 01:08:39'),
(315, 2, 'Updated Ticket #37 (Status to Resolved)', 'Ticketing', 37, '2026-05-06 01:08:39'),
(316, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 12:55:33'),
(317, 1, 'Created Category: Printers', 'Inventory', 6, '2026-05-08 12:56:59'),
(318, 1, 'Updated Item: LAN cables', 'Inventory', 10, '2026-05-08 13:07:59'),
(319, 1, 'Updated Item: LAN cables', 'Inventory', 10, '2026-05-08 13:08:23'),
(320, 1, 'Created Category: test', 'Inventory', 7, '2026-05-08 13:15:54'),
(321, 1, 'Updated Ticket #37 (Status to Resolved)', 'Ticketing', 37, '2026-05-08 13:34:00'),
(322, 1, 'Created Category: test', 'Inventory', 8, '2026-05-08 13:51:57'),
(323, 1, 'Updated Item: test', 'Inventory', 12, '2026-05-08 13:52:52'),
(324, 1, 'Updated Category: test1', 'Inventory', 7, '2026-05-08 13:53:04'),
(325, 1, 'Updated Item: ROG 5220', 'Inventory', 1, '2026-05-08 15:11:28'),
(326, 1, 'Saved changes to Ticket #38', 'Ticketing', 38, '2026-05-08 16:32:37'),
(327, 1, 'Reopened Ticket #38', 'Ticketing', 38, '2026-05-08 16:57:11'),
(328, 1, 'Reopened Ticket #38', 'Ticketing', 38, '2026-05-08 16:58:03'),
(329, 1, 'Reopened Ticket #38', 'Ticketing', 38, '2026-05-08 16:58:43'),
(330, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 16:58:47'),
(331, 1, 'Reopened Ticket #38', 'Ticketing', 38, '2026-05-08 16:59:15'),
(332, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 16:59:22'),
(333, 1, 'Reopened Ticket #38', 'Ticketing', 38, '2026-05-08 17:08:48'),
(334, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 17:08:53'),
(335, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 17:15:02'),
(336, 1, 'Reopened Ticket #38', 'Ticketing', 38, '2026-05-08 17:15:07'),
(337, 1, 'Reopened Ticket #38', 'Ticketing', 38, '2026-05-08 17:18:39'),
(338, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 17:18:41'),
(339, 1, 'Reopened Ticket #38', 'Ticketing', 38, '2026-05-08 17:19:44'),
(340, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 17:19:49'),
(341, 1, 'Reopened Ticket #38', 'Ticketing', 38, '2026-05-08 17:37:35'),
(342, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 17:37:38'),
(343, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 18:21:32'),
(344, 1, 'Updated Ticket #37 (Assigned to Unknown Staff.)', 'Ticketing', 37, '2026-05-08 18:21:42'),
(345, 1, 'Saved changes to Ticket #37', 'Ticketing', 37, '2026-05-08 18:54:39'),
(346, 1, 'Updated Ticket #37 (Priority)', 'Ticketing', 37, '2026-05-08 21:19:57'),
(347, 1, 'Reopened Ticket #36', 'Ticketing', 36, '2026-05-08 22:10:21'),
(348, 1, 'Updated Ticket #36 (Priority)', 'Ticketing', 36, '2026-05-08 22:10:30'),
(349, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-08 22:17:31'),
(350, 1, 'Reopened Ticket #36', 'Ticketing', 36, '2026-05-08 22:17:41'),
(351, 1, 'Reopened Ticket #37', 'Ticketing', 37, '2026-05-09 10:33:45'),
(352, 2, 'Accepted Ticket: test', 'Ticketing', 37, '2026-05-11 11:16:20'),
(353, 2, 'Updated Ticket #37 (Status to Ongoing, Assigned to Tech 1 MISD.)', 'Ticketing', 37, '2026-05-11 11:16:20'),
(354, 2, 'Resolved Ticket: test', 'Ticketing', 37, '2026-05-11 11:16:21'),
(355, 2, 'Updated Ticket #37 (Status to Resolved)', 'Ticketing', 37, '2026-05-11 11:16:21'),
(356, 6, 'Accepted Ticket: test', 'Ticketing', 39, '2026-05-11 11:37:47'),
(357, 6, 'Updated Ticket #39 (Status to Ongoing, Assigned to Tech 3 MISD.)', 'Ticketing', 39, '2026-05-11 11:37:47'),
(358, 6, 'Resolved Ticket: test', 'Ticketing', 39, '2026-05-11 11:40:55'),
(359, 6, 'Updated Ticket #39 (Status to Resolved)', 'Ticketing', 39, '2026-05-11 11:40:55'),
(360, 6, 'Accepted Ticket: test', 'Ticketing', 40, '2026-05-11 11:44:36'),
(361, 6, 'Updated Ticket #40 (Status to Ongoing, Assigned to Tech 3 MISD.)', 'Ticketing', 40, '2026-05-11 11:44:36'),
(362, 1, 'Updated Ticket #40 (Status to Unresolved, Assigned to Unknown Staff.)', 'Ticketing', 40, '2026-05-11 11:49:34'),
(363, 6, 'Accepted Ticket: test', 'Ticketing', 40, '2026-05-11 11:49:39'),
(364, 6, 'Updated Ticket #40 (Status to Ongoing, Assigned to Tech 3 MISD.)', 'Ticketing', 40, '2026-05-11 11:49:39'),
(365, 1, 'Updated Ticket #40 (Status to Unresolved, Assigned to Unknown Staff.)', 'Ticketing', 40, '2026-05-11 11:58:00'),
(366, 6, 'Accepted Ticket: test', 'Ticketing', 40, '2026-05-11 11:58:02'),
(367, 6, 'Updated Ticket #40 (Status to Ongoing, Assigned to Tech 3 MISD.)', 'Ticketing', 40, '2026-05-11 11:58:02'),
(368, 1, 'Updated Ticket #40 (Status to Unresolved, Assigned to Unknown Staff.)', 'Ticketing', 40, '2026-05-11 11:58:18'),
(369, 6, 'Accepted Ticket: test', 'Ticketing', 40, '2026-05-11 11:58:23'),
(370, 6, 'Updated Ticket #40 (Status to Ongoing, Assigned to Tech 3 MISD.)', 'Ticketing', 40, '2026-05-11 11:58:23'),
(371, 6, 'Resolved Ticket: test', 'Ticketing', 40, '2026-05-11 12:07:37'),
(372, 6, 'Updated Ticket #40 (Status to Resolved)', 'Ticketing', 40, '2026-05-11 12:07:37'),
(373, 2, 'Accepted Ticket: test', 'Ticketing', 41, '2026-05-11 12:10:36'),
(374, 2, 'Updated Ticket #41 (Status to Ongoing, Assigned to Tech 1 MISD.)', 'Ticketing', 41, '2026-05-11 12:10:36'),
(375, 2, 'Resolved Ticket: test', 'Ticketing', 41, '2026-05-11 12:23:11'),
(376, 2, 'Updated Ticket #41 (Status to Resolved)', 'Ticketing', 41, '2026-05-11 12:23:11'),
(377, 2, 'Accepted Ticket: test', 'Ticketing', 42, '2026-05-11 13:38:48'),
(378, 2, 'Updated Ticket #42 (Status to Ongoing, Assigned to Tech 1 MISD.)', 'Ticketing', 42, '2026-05-11 13:38:48'),
(379, 1, 'Updated Ticket #43 (Priority)', 'Ticketing', 43, '2026-05-11 14:09:46'),
(380, 1, 'Updated Ticket #43 (Status to Resolved, Assigned to Tech 2 MISD.)', 'Ticketing', 43, '2026-05-11 16:26:36'),
(381, 1, 'Reopened Ticket #43', 'Ticketing', 43, '2026-05-11 16:26:43'),
(382, 1, 'Updated Ticket #43 (Status to Resolved)', 'Ticketing', 43, '2026-05-11 16:28:10'),
(383, 1, 'Issued 200 units for Ticket #43', 'Inventory', 6, '2026-05-11 16:38:35'),
(384, 1, 'Issued Item #6 to Ticket #43', 'Inventory', 6, '2026-05-11 16:38:35'),
(385, 1, 'Reopened Ticket #43', 'Ticketing', 43, '2026-05-11 21:33:44'),
(386, 1, 'Updated Ticket #43 (Status to Resolved)', 'Ticketing', 43, '2026-05-11 23:03:25'),
(387, 1, 'Reopened Ticket #43', 'Ticketing', 43, '2026-05-11 23:04:33'),
(388, 1, 'Updated Ticket #43 (Status to Resolved)', 'Ticketing', 43, '2026-05-11 23:05:36'),
(389, 1, 'Reopened Ticket #43', 'Ticketing', 43, '2026-05-11 23:09:14'),
(390, 1, 'Updated Ticket #43 (Status to Resolved)', 'Ticketing', 43, '2026-05-11 23:09:21'),
(391, 1, 'Reopened Ticket #43', 'Ticketing', 43, '2026-05-11 23:09:24'),
(392, 1, 'Updated Ticket #43 (Status to Resolved)', 'Ticketing', 43, '2026-05-11 23:09:59'),
(393, 2, 'Accepted Ticket: ', 'Ticketing', 44, '2026-05-11 23:24:04'),
(394, 2, 'Updated Ticket #44 (Status to Ongoing, Assigned to Mon Flores.)', 'Ticketing', 44, '2026-05-11 23:24:04'),
(395, 2, 'Resolved Ticket: ', 'Ticketing', 44, '2026-05-11 23:25:54'),
(396, 2, 'Updated Ticket #44 (Status to Resolved)', 'Ticketing', 44, '2026-05-11 23:25:54'),
(397, 1, 'Issued 300 units for Ticket #44', 'Inventory', 6, '2026-05-11 23:29:03'),
(398, 1, 'Issued Item #6 to Ticket #44', 'Inventory', 6, '2026-05-11 23:29:03'),
(399, 2, 'Added a comment to Ticket #44', 'Ticketing', 44, '2026-05-11 23:47:08'),
(400, 2, 'Added a comment to Ticket #37', 'Ticketing', 37, '2026-05-11 23:54:34'),
(401, 1, 'Reopened Ticket #44', 'Ticketing', 44, '2026-05-11 23:55:14'),
(402, 2, 'Resolved Ticket: ', 'Ticketing', 44, '2026-05-11 23:55:26'),
(403, 2, 'Updated Ticket #44 (Status to Resolved)', 'Ticketing', 44, '2026-05-11 23:55:26'),
(404, 2, 'Accepted Ticket: ', 'Ticketing', 46, '2026-05-12 20:49:33'),
(405, 2, 'Updated Ticket #46 (Status to Ongoing, Assigned to Mon Flores.)', 'Ticketing', 46, '2026-05-12 20:49:33'),
(406, 2, 'Accepted Ticket: ', 'Ticketing', 45, '2026-05-12 20:51:11'),
(407, 2, 'Updated Ticket #45 (Status to Ongoing, Assigned to Mon Flores.)', 'Ticketing', 45, '2026-05-12 20:51:11'),
(408, 1, 'Saved changes to Ticket #45', 'Ticketing', 45, '2026-05-12 23:49:10'),
(409, 1, 'Deducted Item # 7', 'Inventory', 7, '2026-05-14 16:15:52'),
(410, 1, 'Updated Category: Computers', 'Inventory', 3, '2026-05-15 09:49:45'),
(411, 1, 'Updated Item: ROG 5220', 'Inventory', 1, '2026-05-15 09:50:00'),
(412, 1, 'Deducted Item # 6', 'Inventory', 6, '2026-05-15 09:51:31'),
(413, 1, 'Updated Category: Computers', 'Inventory', 3, '2026-05-15 10:35:03'),
(414, 1, 'Deducted Item # 5', 'Inventory', 5, '2026-05-15 10:40:04'),
(415, 1, 'Reopened Ticket #48', 'Ticketing', 48, '2026-05-18 18:50:08'),
(416, 2, 'Accepted Ticket: #', 'Ticketing', 48, '2026-05-18 23:04:32'),
(417, 2, 'Updated Ticket #48 (Status to Ongoing, Assigned to Mon Flores.)', 'Ticketing', 48, '2026-05-18 23:04:32'),
(418, 2, 'Resolved Ticket: #', 'Ticketing', 48, '2026-05-18 23:05:32'),
(419, 2, 'Updated Ticket #48 (Status to Resolved)', 'Ticketing', 48, '2026-05-18 23:05:32'),
(420, 1, 'Deducted Item # 2', 'Inventory', 2, '2026-05-19 04:18:35'),
(421, 1, 'Updated Maintenance #6', 'Maintenance', 6, '2026-05-19 04:19:15'),
(422, 2, 'Added a comment to Ticket #45', 'Ticketing', 45, '2026-05-19 06:10:14'),
(423, 1, 'Reopened Ticket #45', 'Ticketing', 45, '2026-05-19 06:10:40'),
(424, 2, 'Resolved Ticket: #', 'Ticketing', 45, '2026-05-19 06:13:07'),
(425, 2, 'Updated Ticket #45 (Status to Resolved)', 'Ticketing', 45, '2026-05-19 06:13:07'),
(426, 2, 'Accepted Ticket: #', 'Ticketing', 49, '2026-05-19 06:37:09'),
(427, 2, 'Updated Ticket #49 (Status to Ongoing, Assigned to Mon Gabriel Flores.)', 'Ticketing', 49, '2026-05-19 06:37:09'),
(428, 2, 'Resolved Ticket: #', 'Ticketing', 49, '2026-05-19 06:37:15'),
(429, 2, 'Updated Ticket #49 (Status to Resolved)', 'Ticketing', 49, '2026-05-19 06:37:15'),
(430, 1, 'Reopened Ticket #49', 'Ticketing', 49, '2026-05-19 07:15:07'),
(431, 2, 'Resolved Ticket: #', 'Ticketing', 49, '2026-05-19 07:25:01'),
(432, 2, 'Updated Ticket #49 (Status to Resolved)', 'Ticketing', 49, '2026-05-19 07:25:01'),
(433, 1, 'Reopened Ticket #49', 'Ticketing', 49, '2026-05-19 07:27:12'),
(434, 1, 'Updated Ticket #49 (Status to Resolved)', 'Ticketing', 49, '2026-05-19 07:30:29'),
(435, 1, 'Reopened Ticket #49', 'Ticketing', 49, '2026-05-19 07:34:47'),
(436, 1, 'Updated Ticket #49 (Status to Resolved, Priority)', 'Ticketing', 49, '2026-05-19 22:39:13'),
(437, 1, 'Updated Ticket #50 (Assigned to James Tapic.)', 'Ticketing', 50, '2026-05-19 23:11:41'),
(438, 2, 'Accepted Ticket: #', 'Ticketing', 51, '2026-05-20 23:33:10'),
(439, 2, 'Updated Ticket #51 (Status to Ongoing, Assigned to Mon Gabriel Flores.)', 'Ticketing', 51, '2026-05-20 23:33:10'),
(440, 2, 'Resolved Ticket: #', 'Ticketing', 51, '2026-05-20 23:33:23'),
(441, 2, 'Updated Ticket #51 (Status to Resolved)', 'Ticketing', 51, '2026-05-20 23:33:23'),
(442, 1, 'Reopened Ticket #44', 'Ticketing', 44, '2026-05-21 16:47:18'),
(443, 1, 'Issued 100 units for Ticket #51', 'Inventory', 6, '2026-05-21 16:48:13'),
(444, 1, 'Issued Item #6 to Ticket #51', 'Inventory', 6, '2026-05-21 16:48:13'),
(445, 1, 'Reopened Ticket #51', 'Ticketing', 51, '2026-05-21 16:48:35'),
(446, 1, 'Swapped Item in Ticket #51: from ID 6 to ID 1', 'Ticketing', 51, '2026-05-21 16:50:29'),
(447, 1, 'Saved changes to Ticket #51', 'Ticketing', 51, '2026-05-21 16:50:29'),
(448, 1, 'Updated Ticket #50 (Status to Resolved)', 'Ticketing', 50, '2026-05-21 17:03:40'),
(449, 1, 'Issued 500 units for Ticket #50', 'Inventory', 1, '2026-05-21 17:03:54'),
(450, 1, 'Issued Item #1 to Ticket #50', 'Inventory', 1, '2026-05-21 17:03:54'),
(451, 1, 'Reopened Ticket #50', 'Ticketing', 50, '2026-05-21 17:03:58'),
(452, 1, 'Reopened Ticket #50', 'Ticketing', 50, '2026-05-21 17:04:00'),
(453, 1, 'Adjusted Qty in Ticket #50: 500 -> 300', 'Ticketing', 50, '2026-05-21 17:12:40'),
(454, 1, 'Saved changes to Ticket #50', 'Ticketing', 50, '2026-05-21 17:12:40'),
(455, 1, 'Issued 900 units for Ticket #49', 'Inventory', 1, '2026-05-21 17:38:46'),
(456, 1, 'Issued Item #1 to Ticket #49', 'Inventory', 1, '2026-05-21 17:38:46'),
(457, 1, 'Reopened Ticket #49', 'Ticketing', 49, '2026-05-21 17:38:48'),
(458, 1, 'Issued 800 units for Ticket #45', 'Inventory', 1, '2026-05-21 17:39:43'),
(459, 1, 'Issued Item #1 to Ticket #45', 'Inventory', 1, '2026-05-21 17:39:43'),
(460, 1, 'Reopened Ticket #45', 'Ticketing', 45, '2026-05-21 17:43:20'),
(461, 1, 'Reopened Ticket #43', 'Ticketing', 43, '2026-05-21 17:43:53'),
(462, 1, 'Updated Category: Computers', 'Inventory', 3, '2026-05-21 17:52:59'),
(463, 1, 'Updated Item: 005', 'Inventory', 2, '2026-05-24 18:50:37'),
(464, 1, 'Updated Item: 005', 'Inventory', 2, '2026-05-24 18:51:36'),
(465, 1, 'Updated Ticket #52 (Assigned to Mon Gabriel Flores.)', 'Ticketing', 52, '2026-05-24 18:52:19'),
(466, 1, 'Updated Item: Laser Jet Pro', 'Inventory', 13, '2026-05-24 18:54:28'),
(467, 1, 'Created Category: Computer Case', 'Inventory', 9, '2026-05-24 18:56:35'),
(468, 1, 'Updated Category: Computer Case', 'Inventory', 9, '2026-05-24 19:05:13'),
(469, 1, 'Updated Ticket #53 (Priority, Assigned to Mon Gabriel Flores.)', 'Ticketing', 53, '2026-05-24 19:12:06'),
(470, 2, 'Resolved Ticket: #', 'Ticketing', 53, '2026-05-24 19:12:34'),
(471, 2, 'Updated Ticket #53 (Status to Resolved)', 'Ticketing', 53, '2026-05-24 19:12:34'),
(472, 2, 'Added a comment to Ticket #53', 'Ticketing', 53, '2026-05-24 19:13:15'),
(473, 1, 'Updated Category: Computers', 'Inventory', 3, '2026-05-24 19:23:58'),
(474, 1, 'Issued 5 units for Ticket #53', 'Inventory', 15, '2026-05-24 23:12:09'),
(475, 1, 'Issued Item #15 to Ticket #53', 'Inventory', 15, '2026-05-24 23:12:09'),
(476, 1, 'Reopened Ticket #53', 'Ticketing', 53, '2026-05-24 23:12:15'),
(477, 1, 'Adjusted Qty in Ticket #53: 5 -> 8', 'Ticketing', 53, '2026-05-24 23:22:14'),
(478, 1, 'Saved changes to Ticket #53', 'Ticketing', 53, '2026-05-24 23:22:14'),
(479, 1, 'Updated Item: 005', 'Inventory', 2, '2026-05-24 23:23:10'),
(480, 1, 'Updated Item: Mouse', 'Inventory', 14, '2026-06-06 22:14:58'),
(481, 1, 'Updated Item: Mouse', 'Inventory', 14, '2026-06-06 22:15:09'),
(482, 1, 'Deleted Maintenance #1', 'Maintenance', 1, '2026-06-10 23:30:15'),
(483, 2, 'Accepted Ticket: #', 'Ticketing', 55, '2026-06-12 18:44:58'),
(484, 2, 'Updated Ticket #55 (Status to Ongoing, Assigned to Mon Gabriel Flores.)', 'Ticketing', 55, '2026-06-12 18:44:58'),
(485, 2, 'Resolved Ticket: #', 'Ticketing', 55, '2026-06-12 18:45:01'),
(486, 2, 'Updated Ticket #55 (Status to Resolved)', 'Ticketing', 55, '2026-06-12 18:45:01'),
(487, 2, 'Added a comment to Ticket #55', 'Ticketing', 55, '2026-06-12 19:35:30'),
(488, 1, 'Soft-Deleted Ticket Reference: #55 (Moved to Archive Ledger)', 'Ticketing', 55, '2026-06-14 23:23:10'),
(489, 1, 'Soft-Deleted Ticket Reference: #55 (Moved to Archive Ledger)', 'Ticketing', 55, '2026-06-14 23:34:28'),
(490, 1, 'Soft-Deleted Ticket Reference: #55 (Moved to Archive Ledger)', 'Ticketing', 55, '2026-06-15 00:07:22'),
(491, 1, 'Soft-Deleted Ticket Reference: #40 (Moved to Archive Ledger)', 'Ticketing', 40, '2026-06-15 00:07:22'),
(492, 1, 'Soft-Deleted Ticket Reference: #55 (Moved to Archive Ledger)', 'Ticketing', 55, '2026-06-15 00:09:46'),
(493, 1, 'Soft-Deleted Ticket Reference: #55 (Moved to Archive Ledger)', 'Ticketing', 55, '2026-06-15 00:11:45'),
(494, 1, 'Soft-Deleted Ticket Reference: #40 (Moved to Archive Ledger)', 'Ticketing', 40, '2026-06-15 00:11:45'),
(495, 1, 'Soft-Deleted Ticket Reference: #39 (Moved to Archive Ledger)', 'Ticketing', 39, '2026-06-15 09:52:02'),
(496, 1, 'Soft-Deleted Ticket Reference: #55 (Moved to Archive Ledger)', 'Ticketing', 55, '2026-06-16 12:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `archive_ledger`
--

CREATE TABLE `archive_ledger` (
  `A_ID` int(11) NOT NULL,
  `Record_ID` int(11) NOT NULL,
  `Module_Type` varchar(50) NOT NULL,
  `Reference_Num` varchar(100) DEFAULT 'N/A',
  `JSON_Payload` longtext NOT NULL,
  `Deleted_By` int(11) NOT NULL,
  `Deleted_At` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `D_ID` int(11) NOT NULL,
  `Dept_Name` varchar(200) NOT NULL,
  `descript` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`D_ID`, `Dept_Name`, `descript`) VALUES
(1, 'MISD', ''),
(2, 'Radiology', ''),
(3, 'Laboratory', ''),
(4, 'Billing', ''),
(5, 'Executive Office', ''),
(6, 'HRMD Office', ''),
(7, 'Accounting division', ''),
(8, 'Administrative Services Department', ''),
(9, 'Admitting and Discharge Section', ''),
(10, 'Adult Nephrology Division', ''),
(11, 'Ambulatory Endoscopy and Urology Section', ''),
(12, 'Ambulatory Infusion Therapy Unit', ''),
(13, 'Anatomic Pathology Division', ''),
(14, 'Ancillary Service Department', ''),
(15, 'Anesthesia Division', ''),
(16, 'Bids and Awards Secretariat', ''),
(17, 'Billing and Claims Division', ''),
(18, 'Billing and Philhealth Section', ''),
(19, 'Blood Bank Section (BBK)', ''),
(20, 'Blood Donor Recruitment and Apheresis section (BDRA)', ''),
(21, 'Breast Center', ''),
(22, 'Budget Division', ''),
(23, 'Building Administration and Housekeeping', ''),
(24, 'Business Records Management', ''),
(25, 'Cardiac Catherization and Radiology Unit', ''),
(26, 'Cardiac Catheterization Laboratory Section', ''),
(27, 'Cardiovascular Laboratory Section', ''),
(28, 'Care Therapeutic Transplant Unit / HICU', ''),
(29, 'Cellular Immunology and Flow Cytometry Section', ''),
(30, 'Cellular Transplantation Section', ''),
(31, 'Central Supply and Sterilization Unit', ''),
(32, 'Clinical Chemistry Section (CCH)', ''),
(33, 'Clinical Immunology Section (CIS)', ''),
(34, 'Clinical Microscopy Section (CMI)', ''),
(35, 'Clinical Pathology Division', ''),
(36, 'Clinical Trial and Research Division', ''),
(37, 'COVID Lab', ''),
(38, 'Credit and Collection Section', ''),
(39, 'CT-SCAN', ''),
(40, 'Department Medical Imaging and Therapeutic Radiology', ''),
(41, 'Diagnostic Division', ''),
(42, 'Doctors Clinic', ''),
(43, 'Emergency Room Service', ''),
(44, 'Executive Office', ''),
(45, 'Finance Service Department', ''),
(46, 'WARD 2A', ''),
(47, 'WARD 2B', ''),
(48, 'WARD 2C', ''),
(49, 'WARD 2D', ''),
(50, 'WARD 2E', ''),
(51, 'WARD 2F', ''),
(52, 'WARD 2G', ''),
(53, 'WARD 3A', ''),
(54, 'WARD 3B', ''),
(55, 'WARD 3C', ''),
(56, 'WARD 3D', ''),
(57, 'WARD 3F', ''),
(58, 'WARD 3E', ''),
(60, 'Cashier', ''),
(61, 'Credit', ''),
(62, 'Operating Room', '');

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
(3, 'Computers', 'Consists of hardware items if not marked as consumables', '#fea9a9', '2026-03-31 19:00:37', NULL, 1),
(4, 'Consumables', '', '#c8bdff', '2026-03-31 19:00:37', NULL, 1),
(6, 'Printers', '', '#e3f2fd', '2026-05-08 12:56:59', NULL, 1);

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
(1, 3, 'ROG 5220', 3, 'ROG', 6800, 200, 'INTELI', 'No', '1234', '2026-04-05 18:15:00', NULL, '2026-04-05 18:16:20', '2026-05-15 09:50:00', 1),
(2, 4, '005', 1, 'brand', 67, 100, 'supplier', 'No', 'N/A', '2026-04-05 21:20:00', NULL, '2026-04-05 21:20:56', '2026-05-24 23:23:10', 1),
(3, 4, '005', 1, 'SONY', 0, 200, 'INTELI', 'No', NULL, '2026-04-05 21:20:00', NULL, '2026-04-05 21:40:16', '2026-04-17 21:11:18', 1),
(4, 4, '005', 1, 'Delta', 0, 2, 'supplier', 'No', NULL, '2026-04-17 21:47:00', NULL, '2026-04-17 21:48:25', NULL, 1),
(5, 4, '005', 1, '123', 200, 200, 'INTELI', 'No', NULL, '2026-04-29 21:22:00', NULL, '2026-04-29 21:22:36', NULL, 1),
(6, 4, '005', 1, '123', 400, 200, 'INTELI', 'No', NULL, '2026-04-30 20:56:00', NULL, '2026-04-30 20:56:41', NULL, 1),
(7, 4, '005', 1, '123', 10, 2, 'INFINI', 'No', NULL, '2026-04-30 22:43:00', NULL, '2026-04-30 22:43:19', NULL, 1),
(8, 6, 'LaserJet pro', 2, 'Delta', 150, 20, 'ErgoFurniture Ltd.', 'No', NULL, '2026-05-08 12:57:00', NULL, '2026-05-08 12:57:44', NULL, 1),
(9, 2, 'Intelli mouse', 2, 'Delta', 100, 20, 'ErgoFurniture Ltd.', 'No', NULL, '2026-05-08 12:59:00', NULL, '2026-05-08 12:59:30', NULL, 1),
(10, 1, 'LAN cables', 2, 'brand', 250, 20, 'ErgoFurniture Ltd.', 'No', 'N/A', '2026-05-08 13:06:00', NULL, '2026-05-08 13:07:14', '2026-05-08 13:08:23', 1),
(13, 3, 'Laser Jet Pro', 2, 'Dell', 100, 2, 'Dell', 'No', '89203', '2026-05-24 18:53:00', NULL, '2026-05-24 18:53:54', '2026-05-24 18:54:28', 1),
(14, 2, 'Mouse', 2, 'Logitech', 109, 99, 'INTELI', 'No', '09976', '2013-03-19 18:07:00', NULL, '2026-05-24 18:55:12', '2026-06-06 22:15:09', 1),
(15, 1, 'Flat Ethernet Cable', 2, 'PLDT', 25, 36, 'Shopee', 'Yes', NULL, '2023-05-24 18:56:00', NULL, '2026-05-24 18:57:45', NULL, 1),
(17, 3, 'Dell', 2, 'Delta', 100, 20, 'INTELI', 'No', NULL, '2026-06-06 22:15:00', NULL, '2026-06-06 22:16:14', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_tracker`
--

CREATE TABLE `inventory_tracker` (
  `IT_ID` int(11) NOT NULL,
  `I_ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `reference_ticket` int(11) DEFAULT NULL,
  `Input_by` int(11) NOT NULL,
  `Received_by` int(11) DEFAULT NULL,
  `D_ID` int(11) DEFAULT NULL,
  `date_received` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_tracker`
--

INSERT INTO `inventory_tracker` (`IT_ID`, `I_ID`, `Quantity`, `reference_ticket`, `Input_by`, `Received_by`, `D_ID`, `date_received`, `created_at`) VALUES
(1, 2, 191, 1, 1, 3, NULL, '2026-04-12 16:06:40', '2026-04-12 16:06:40'),
(2, 3, 200, 2, 1, 3, NULL, '2026-04-11 16:06:40', '2026-04-12 16:06:40'),
(3, 3, 0, 4, 1, 3, NULL, '2026-04-13 16:06:40', '2026-04-13 16:06:40'),
(4, 3, 20, 5, 1, 3, NULL, '2026-04-13 16:06:40', '2026-04-15 16:06:40'),
(5, 3, 5, 3, 1, 3, NULL, '2026-04-22 16:06:40', '2026-04-22 16:06:40'),
(6, 3, 20, 4, 1, 3, NULL, '2026-04-01 16:06:40', '2026-04-02 16:06:40'),
(7, 2, 5, 6, 1, 3, NULL, '2026-04-22 16:06:40', '2026-04-23 16:06:40'),
(8, 4, 5, 6, 1, 3, NULL, '2026-04-17 16:06:40', '2026-04-22 16:06:40'),
(9, 2, 5, 6, 1, 3, NULL, '2026-04-14 16:06:40', '2026-04-15 16:06:40'),
(10, 1, 1, 7, 1, 4, NULL, '2026-04-22 16:53:16', '0000-00-00 00:00:00'),
(11, 6, 200, 43, 1, 3, NULL, '2026-05-11 16:38:35', '0000-00-00 00:00:00'),
(12, 6, 300, 44, 1, 3, NULL, '2026-05-11 23:29:03', '0000-00-00 00:00:00'),
(15, 1, 500, NULL, 1, NULL, 23, '2026-05-14 15:26:27', '2026-05-14 15:26:27'),
(16, 1, 200, NULL, 1, NULL, 13, '2026-05-14 16:10:48', '2026-05-14 16:10:48'),
(17, 7, 2, NULL, 1, NULL, 21, '2026-05-14 16:14:18', '2026-05-14 16:14:18'),
(18, 7, 3, NULL, 1, NULL, 15, '2026-05-14 16:15:52', '2026-05-14 16:15:52'),
(19, 6, 300, NULL, 1, NULL, 20, '2026-05-15 09:51:31', '2026-05-15 09:51:31'),
(20, 5, 300, NULL, 1, NULL, 40, '2026-05-15 10:40:04', '2026-05-15 10:40:04'),
(21, 2, 15, NULL, 1, NULL, 19, '2026-05-19 04:18:35', '2026-05-19 04:18:35');

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

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `L_ID` int(11) NOT NULL,
  `U_ID` int(11) NOT NULL,
  `login_time` datetime NOT NULL DEFAULT current_timestamp(),
  `logout_time` datetime DEFAULT NULL,
  `stat` enum('success','failed','Login','Logout','Active') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`L_ID`, `U_ID`, `login_time`, `logout_time`, `stat`) VALUES
(1, 1, '2026-04-10 13:06:21', '2026-04-10 13:27:55', 'Logout'),
(2, 3, '2026-04-10 13:27:58', '2026-04-10 13:28:08', 'Logout'),
(3, 1, '2026-04-10 13:28:11', '2026-04-10 16:00:24', 'Logout'),
(4, 3, '2026-04-10 15:01:37', '2026-04-10 15:01:44', 'Logout'),
(5, 2, '2026-04-10 15:01:47', NULL, 'Login'),
(6, 3, '2026-04-10 15:55:27', '2026-04-10 15:55:43', 'Logout'),
(7, 2, '2026-04-10 15:55:47', NULL, 'Login'),
(8, 3, '2026-04-10 15:56:35', '2026-04-10 15:56:39', 'Logout'),
(9, 2, '2026-04-10 15:56:48', '2026-04-10 17:29:22', 'Logout'),
(10, 4, '2026-04-10 16:00:29', '2026-04-10 16:01:21', 'Logout'),
(11, 1, '2026-04-10 16:01:23', '2026-04-10 22:00:58', 'Logout'),
(12, 2, '2026-04-10 22:01:01', '2026-04-10 22:02:19', 'Logout'),
(13, 1, '2026-04-10 22:02:21', NULL, 'Login'),
(14, 4, '2026-04-10 22:06:46', '2026-04-10 22:29:48', 'Logout'),
(15, 2, '2026-04-10 22:29:50', NULL, 'Login'),
(16, 1, '2026-04-12 15:08:37', '2026-04-12 19:45:04', 'Logout'),
(17, 3, '2026-04-12 19:45:09', '2026-04-12 19:46:21', 'Logout'),
(18, 1, '2026-04-12 19:46:23', '2026-04-12 19:48:00', 'Logout'),
(19, 3, '2026-04-12 19:48:04', '2026-04-12 19:48:19', 'Logout'),
(20, 1, '2026-04-12 19:48:20', '2026-04-12 22:15:00', 'Logout'),
(21, 3, '2026-04-12 22:15:03', '2026-04-12 22:15:15', 'Logout'),
(22, 1, '2026-04-12 22:15:17', '2026-04-12 22:49:32', 'Logout'),
(23, 3, '2026-04-12 22:49:37', '2026-04-12 22:54:20', 'Logout'),
(24, 2, '2026-04-12 22:54:22', '2026-04-12 23:02:17', 'Logout'),
(25, 1, '2026-04-12 23:02:19', '2026-04-13 00:01:57', 'Logout'),
(26, 1, '2026-04-17 11:24:31', '2026-04-18 00:28:59', 'Logout'),
(27, 3, '2026-04-18 00:29:02', '2026-04-18 00:29:11', 'Logout'),
(28, 1, '2026-04-18 00:29:13', '2026-04-18 00:52:03', 'Logout'),
(29, 4, '2026-04-18 00:52:06', '2026-04-18 00:52:15', 'Logout'),
(30, 1, '2026-04-18 00:52:17', '2026-04-18 01:24:40', 'Logout'),
(31, 1, '2026-04-18 17:25:05', '2026-04-19 01:48:14', 'Logout'),
(32, 1, '2026-04-19 14:05:27', '2026-04-19 14:26:53', 'Logout'),
(33, 2, '2026-04-19 14:26:57', '2026-04-19 14:27:56', 'Logout'),
(34, 1, '2026-04-19 14:27:58', '2026-04-19 14:28:03', 'Logout'),
(35, 3, '2026-04-19 14:28:06', '2026-04-19 14:28:16', 'Logout'),
(36, 1, '2026-04-19 14:28:18', NULL, 'Login'),
(37, 1, '2026-04-20 21:02:23', NULL, 'Login'),
(38, 1, '2026-04-21 00:36:18', '2026-04-21 01:44:26', 'Logout'),
(39, 1, '2026-04-22 13:53:14', '2026-04-23 00:56:50', 'Logout'),
(40, 1, '2026-04-24 17:37:06', '2026-04-24 17:58:06', 'Logout'),
(41, 2, '2026-04-24 17:58:09', '2026-04-24 18:01:31', 'Logout'),
(42, 1, '2026-04-24 18:01:33', '2026-04-24 18:03:39', 'Logout'),
(43, 2, '2026-04-24 18:03:42', '2026-04-24 18:06:48', 'Logout'),
(44, 3, '2026-04-24 18:06:51', '2026-04-24 18:06:52', 'Logout'),
(45, 4, '2026-04-24 18:06:55', '2026-04-24 18:07:20', 'Logout'),
(46, 2, '2026-04-24 18:07:22', '2026-04-24 19:13:58', 'Logout'),
(47, 4, '2026-04-24 19:14:02', '2026-04-24 19:14:38', 'Logout'),
(48, 2, '2026-04-24 19:14:42', '2026-04-24 19:20:31', 'Logout'),
(49, 1, '2026-04-24 19:20:33', '2026-04-24 21:16:35', 'Logout'),
(50, 2, '2026-04-24 21:16:38', '2026-04-24 23:01:06', 'Logout'),
(51, 1, '2026-04-24 23:01:08', '2026-04-24 23:52:15', 'Logout'),
(52, 2, '2026-04-24 23:52:18', '2026-04-25 00:11:10', 'Logout'),
(53, 1, '2026-04-25 00:11:12', NULL, 'Login'),
(54, 1, '2026-04-26 16:53:59', '2026-04-26 18:29:16', 'Logout'),
(55, 2, '2026-04-26 18:28:24', '2026-04-26 20:11:31', 'Logout'),
(56, 3, '2026-04-26 18:29:19', '2026-04-26 18:29:25', 'Logout'),
(57, 4, '2026-04-26 18:29:28', '2026-04-26 20:12:40', 'Logout'),
(58, 1, '2026-04-26 20:12:42', '2026-04-26 20:53:35', 'Logout'),
(59, 3, '2026-04-26 20:49:56', '2026-04-26 20:49:59', 'Logout'),
(60, 2, '2026-04-26 20:50:02', '2026-04-26 21:34:03', 'Logout'),
(61, 3, '2026-04-26 20:53:41', '2026-04-26 20:53:45', 'Logout'),
(62, 4, '2026-04-26 20:53:48', '2026-04-26 22:03:08', 'Logout'),
(63, 1, '2026-04-26 21:53:03', '2026-04-26 22:02:57', 'Logout'),
(64, 2, '2026-04-26 22:29:40', '2026-04-26 22:44:34', 'Logout'),
(65, 2, '2026-04-26 22:44:37', '2026-04-26 23:03:00', 'Logout'),
(66, 1, '2026-04-26 23:03:03', '2026-04-26 23:36:59', 'Logout'),
(67, 1, '2026-04-27 18:56:29', '2026-04-27 21:32:49', 'Logout'),
(68, 3, '2026-04-27 19:06:11', '2026-04-27 19:14:22', 'Logout'),
(69, 3, '2026-04-27 19:31:59', NULL, 'Login'),
(70, 2, '2026-04-27 20:34:58', '2026-04-27 20:36:36', 'Logout'),
(71, 2, '2026-04-27 21:32:54', '2026-04-28 00:57:23', 'Logout'),
(72, 1, '2026-04-27 22:21:00', NULL, 'Login'),
(73, 1, '2026-04-28 00:47:10', '2026-04-28 00:57:16', 'Logout'),
(74, 1, '2026-04-28 00:57:26', NULL, 'Login'),
(75, 1, '2026-04-28 00:58:15', '2026-04-28 01:41:32', 'Logout'),
(76, 1, '2026-04-28 14:46:13', '2026-04-28 23:50:03', 'Logout'),
(77, 3, '2026-04-28 15:35:45', '2026-04-28 15:38:45', 'Logout'),
(78, 2, '2026-04-28 15:48:51', '2026-04-28 15:57:53', 'Logout'),
(79, 3, '2026-04-28 15:57:56', '2026-04-28 15:58:20', 'Logout'),
(80, 3, '2026-04-28 15:58:24', '2026-04-28 16:06:05', 'Logout'),
(81, 3, '2026-04-28 16:06:07', '2026-04-28 16:06:09', 'Logout'),
(82, 5, '2026-04-28 16:06:18', '2026-04-28 16:09:07', 'Logout'),
(83, 2, '2026-04-28 16:09:12', '2026-04-28 16:09:56', 'Logout'),
(84, 3, '2026-04-28 16:09:59', '2026-04-28 17:21:56', 'Logout'),
(85, 4, '2026-04-28 20:52:33', '2026-04-28 20:52:45', 'Logout'),
(86, 4, '2026-04-28 20:52:58', '2026-04-28 22:57:55', 'Logout'),
(87, 1, '2026-04-29 20:15:28', '2026-04-29 21:37:01', 'Logout'),
(88, 1, '2026-04-30 13:14:40', '2026-04-30 19:05:07', 'Logout'),
(89, 3, '2026-04-30 13:15:14', '2026-04-30 13:44:30', 'Logout'),
(90, 2, '2026-04-30 13:44:36', '2026-04-30 13:44:51', 'Logout'),
(91, 4, '2026-04-30 13:44:54', '2026-04-30 13:49:52', 'Logout'),
(92, 4, '2026-04-30 15:16:03', '2026-04-30 16:04:31', 'Logout'),
(93, 2, '2026-04-30 16:04:35', '2026-04-30 17:03:18', 'Logout'),
(94, 3, '2026-04-30 17:03:22', '2026-04-30 18:56:28', 'Logout'),
(95, 3, '2026-04-30 18:56:31', '2026-04-30 18:57:12', 'Logout'),
(96, 2, '2026-04-30 18:57:15', '2026-04-30 22:46:19', 'Logout'),
(97, 3, '2026-04-30 19:05:10', '2026-04-30 20:17:53', 'Logout'),
(98, 1, '2026-04-30 20:17:55', '2026-04-30 22:56:09', 'Logout'),
(99, 1, '2026-05-01 20:53:19', '2026-05-02 00:20:50', 'Logout'),
(100, 1, '2026-05-02 14:04:53', '2026-05-02 16:36:43', 'Logout'),
(101, 2, '2026-05-02 16:36:45', '2026-05-02 16:38:12', 'Logout'),
(102, 1, '2026-05-02 16:38:13', '2026-05-02 23:41:28', 'Logout'),
(103, 1, '2026-05-05 19:27:21', '2026-05-05 19:27:29', 'Logout'),
(104, 2, '2026-05-05 19:27:35', '2026-05-05 19:27:52', 'Logout'),
(105, 3, '2026-05-05 19:27:54', '2026-05-05 19:28:02', 'Logout'),
(106, 2, '2026-05-05 19:28:06', '2026-05-05 19:28:21', 'Logout'),
(107, 3, '2026-05-05 19:28:23', '2026-05-05 19:28:34', 'Logout'),
(108, 1, '2026-05-05 19:28:36', '2026-05-05 19:31:28', 'Logout'),
(109, 2, '2026-05-05 19:31:31', '2026-05-05 19:31:40', 'Logout'),
(110, 1, '2026-05-05 19:31:43', '2026-05-05 19:45:23', 'Logout'),
(111, 2, '2026-05-05 19:45:26', '2026-05-05 19:47:44', 'Logout'),
(112, 3, '2026-05-05 19:47:46', '2026-05-05 19:50:21', 'Logout'),
(113, 1, '2026-05-05 19:54:50', '2026-05-06 00:43:02', 'Logout'),
(114, 2, '2026-05-06 00:43:05', '2026-05-06 00:43:28', 'Logout'),
(115, 1, '2026-05-06 00:43:31', '2026-05-06 00:43:38', 'Logout'),
(116, 2, '2026-05-06 00:43:43', '2026-05-06 00:44:24', 'Logout'),
(117, 1, '2026-05-06 01:02:34', '2026-05-06 01:06:43', 'Logout'),
(118, 2, '2026-05-06 01:06:46', '2026-05-06 01:27:01', 'Logout'),
(119, 3, '2026-05-06 01:27:04', '2026-05-06 01:31:08', 'Logout'),
(120, 1, '2026-05-08 12:47:55', '2026-05-08 15:21:35', 'Logout'),
(121, 2, '2026-05-08 12:50:17', '2026-05-08 12:51:40', 'Logout'),
(122, 2, '2026-05-08 12:56:29', '2026-05-08 16:17:59', 'Logout'),
(123, 1, '2026-05-08 16:31:12', '2026-05-08 16:31:54', 'Logout'),
(124, 3, '2026-05-08 16:31:59', '2026-05-08 16:32:07', 'Logout'),
(125, 2, '2026-05-08 16:32:12', '2026-05-08 16:32:23', 'Logout'),
(126, 1, '2026-05-08 16:32:25', '2026-05-08 16:32:44', 'Logout'),
(127, 2, '2026-05-08 16:32:47', '2026-05-08 16:56:02', 'Logout'),
(128, 1, '2026-05-08 16:56:04', NULL, 'Login'),
(129, 1, '2026-05-08 17:18:33', NULL, 'Login'),
(130, 1, '2026-05-08 17:37:28', '2026-05-08 23:01:25', 'Logout'),
(131, 1, '2026-05-08 23:01:51', '2026-05-08 23:02:09', 'Logout'),
(132, 2, '2026-05-09 10:33:34', '2026-05-09 10:38:41', 'Logout'),
(133, 1, '2026-05-09 10:33:37', '2026-05-09 10:37:26', 'Logout'),
(134, 3, '2026-05-09 10:38:44', '2026-05-09 10:39:45', 'Logout'),
(135, 1, '2026-05-09 10:54:08', NULL, 'Login'),
(136, 1, '2026-05-11 11:07:55', NULL, 'failed'),
(137, 1, '2026-05-11 11:15:30', '2026-05-11 11:15:51', 'Logout'),
(138, 7, '2026-05-11 11:15:58', '2026-05-11 11:16:07', 'Logout'),
(139, 2, '2026-05-11 11:16:17', '2026-05-11 11:16:37', 'Logout'),
(140, 3, '2026-05-11 11:16:42', '2026-05-11 11:16:45', 'Logout'),
(141, 4, '2026-05-11 11:16:49', '2026-05-11 11:16:51', 'Logout'),
(142, 5, '2026-05-11 11:17:02', '2026-05-11 11:17:26', 'Logout'),
(143, 6, '2026-05-11 11:17:31', '2026-05-11 11:24:38', 'Logout'),
(144, 1, '2026-05-11 11:24:43', '2026-05-11 11:27:20', 'Logout'),
(145, 3, '2026-05-11 11:27:22', '2026-05-11 11:27:28', 'Logout'),
(146, 2, '2026-05-11 11:27:33', '2026-05-11 11:34:16', 'Logout'),
(147, 2, '2026-05-11 11:34:21', '2026-05-11 11:36:22', 'Logout'),
(148, 5, '2026-05-11 11:36:25', '2026-05-11 11:36:28', 'Logout'),
(149, 6, '2026-05-11 11:36:35', '2026-05-11 11:37:24', 'Logout'),
(150, 3, '2026-05-11 11:37:30', '2026-05-11 11:37:39', 'Logout'),
(151, 6, '2026-05-11 11:37:41', '2026-05-11 11:44:14', 'Logout'),
(152, 3, '2026-05-11 11:44:19', '2026-05-11 11:44:25', 'Logout'),
(153, 6, '2026-05-11 11:44:30', '2026-05-11 12:09:45', 'Logout'),
(154, 1, '2026-05-11 11:49:20', '2026-05-11 12:10:05', 'Logout'),
(155, 2, '2026-05-11 12:09:48', '2026-05-11 12:23:58', 'Logout'),
(156, 3, '2026-05-11 12:10:10', NULL, 'failed'),
(157, 3, '2026-05-11 12:10:13', '2026-05-11 12:10:20', 'Logout'),
(158, 5, '2026-05-11 12:10:25', '2026-05-11 12:23:59', 'Logout'),
(159, 3, '2026-05-11 13:16:07', NULL, 'failed'),
(160, 3, '2026-05-11 13:16:47', '2026-05-11 13:25:57', 'Logout'),
(161, 1, '2026-05-11 13:19:54', '2026-05-11 13:45:45', 'Logout'),
(162, 3, '2026-05-11 13:26:40', '2026-05-11 13:35:26', 'Logout'),
(163, 2, '2026-05-11 13:35:33', '2026-05-11 13:45:43', 'Logout'),
(164, 1, '2026-05-11 13:55:13', '2026-05-11 16:43:43', 'Logout'),
(165, 3, '2026-05-11 14:09:22', '2026-05-11 16:22:20', 'Logout'),
(166, 7, '2026-05-11 16:22:46', '2026-05-11 16:43:50', 'Logout'),
(167, 1, '2026-05-11 16:43:45', '2026-05-12 01:05:06', 'Logout'),
(168, 7, '2026-05-11 16:43:53', '2026-05-11 17:19:57', 'Logout'),
(169, 3, '2026-05-11 18:46:58', '2026-05-11 19:46:24', 'Logout'),
(170, 2, '2026-05-11 21:28:45', '2026-05-11 21:46:48', 'Logout'),
(171, 2, '2026-05-11 21:46:51', '2026-05-11 23:03:33', 'Logout'),
(172, 3, '2026-05-11 23:03:36', '2026-05-11 23:03:58', 'Logout'),
(173, 2, '2026-05-11 23:04:02', '2026-05-11 23:56:19', 'Logout'),
(174, 3, '2026-05-11 23:56:24', '2026-05-11 23:56:43', 'Logout'),
(175, 2, '2026-05-11 23:56:47', '2026-05-11 23:59:35', 'Logout'),
(176, 3, '2026-05-12 00:05:09', '2026-05-12 00:24:34', 'Logout'),
(177, 1, '2026-05-12 01:05:08', '2026-05-12 01:11:04', 'Logout'),
(178, 1, '2026-05-12 01:11:06', '2026-05-12 01:16:26', 'Logout'),
(179, 1, '2026-05-12 01:16:28', '2026-05-12 01:27:33', 'Logout'),
(180, 1, '2026-05-12 01:27:35', '2026-05-12 01:27:44', 'Logout'),
(181, 1, '2026-05-12 01:27:46', NULL, 'failed'),
(182, 1, '2026-05-12 01:27:49', '2026-05-12 01:34:53', 'Logout'),
(183, 1, '2026-05-12 20:47:23', '2026-05-12 20:48:48', 'Logout'),
(184, 3, '2026-05-12 20:48:54', '2026-05-12 20:49:19', 'Logout'),
(185, 2, '2026-05-12 20:49:07', '2026-05-12 20:50:56', 'Logout'),
(186, 1, '2026-05-12 20:49:21', '2026-05-13 00:07:05', 'Logout'),
(187, 3, '2026-05-12 20:50:58', '2026-05-12 20:51:06', 'Logout'),
(188, 2, '2026-05-12 20:51:08', '2026-05-12 22:05:09', 'Logout'),
(189, 3, '2026-05-12 22:33:26', '2026-05-12 22:48:53', 'Logout'),
(190, 3, '2026-05-12 22:48:56', NULL, 'Login'),
(191, 1, '2026-05-14 10:32:52', '2026-05-14 11:39:03', 'Logout'),
(192, 1, '2026-05-14 11:39:06', '2026-05-14 16:06:04', 'Logout'),
(193, 1, '2026-05-14 16:09:09', '2026-05-14 16:17:09', 'Logout'),
(194, 1, '2026-05-15 00:50:39', '2026-05-15 00:50:42', 'Logout'),
(195, 1, '2026-05-15 09:49:26', '2026-05-15 10:01:59', 'Logout'),
(196, 2, '2026-05-15 10:02:05', '2026-05-15 10:08:53', 'Logout'),
(197, 1, '2026-05-15 10:08:58', '2026-05-15 10:09:12', 'Logout'),
(198, 1, '2026-05-15 10:09:43', '2026-05-15 10:10:41', 'Logout'),
(199, 2, '2026-05-15 10:10:47', '2026-05-15 10:12:00', 'Logout'),
(200, 3, '2026-05-15 10:12:04', '2026-05-15 10:15:13', 'Logout'),
(201, 1, '2026-05-15 10:31:21', '2026-05-15 10:47:51', 'Logout'),
(202, 2, '2026-05-15 10:47:55', '2026-05-15 10:48:02', 'Logout'),
(203, 3, '2026-05-15 10:48:05', '2026-05-15 10:50:00', 'Logout'),
(204, 2, '2026-05-15 10:50:03', '2026-05-15 10:54:30', 'Logout'),
(205, 2, '2026-05-15 10:50:03', NULL, 'Login'),
(206, 1, '2026-05-15 10:56:33', '2026-05-15 11:03:38', 'Logout'),
(207, 1, '2026-05-17 15:06:33', NULL, 'Login'),
(208, 2, '2026-05-17 15:06:47', '2026-05-17 15:07:02', 'Logout'),
(209, 1, '2026-05-18 17:24:38', '2026-05-18 17:25:24', 'Logout'),
(210, 2, '2026-05-18 17:25:27', '2026-05-18 17:25:36', 'Logout'),
(211, 1, '2026-05-18 17:25:38', '2026-05-18 17:50:56', 'Logout'),
(212, 3, '2026-05-18 17:51:00', '2026-05-18 18:15:18', 'Logout'),
(213, 2, '2026-05-18 18:15:20', '2026-05-18 18:16:37', 'Logout'),
(214, 1, '2026-05-18 18:16:46', '2026-05-18 18:25:13', 'Logout'),
(215, 1, '2026-05-18 18:25:40', '2026-05-18 19:17:05', 'Logout'),
(216, 3, '2026-05-18 19:17:38', '2026-05-18 19:25:26', 'Logout'),
(217, 2, '2026-05-18 19:25:28', '2026-05-18 22:29:25', 'Logout'),
(218, 1, '2026-05-18 22:29:28', '2026-05-18 23:03:20', 'Logout'),
(219, 2, '2026-05-18 23:03:22', '2026-05-18 23:34:55', 'Logout'),
(220, 1, '2026-05-18 23:34:57', '2026-05-18 23:39:42', 'Logout'),
(221, 2, '2026-05-18 23:39:47', '2026-05-18 23:43:16', 'Logout'),
(222, 1, '2026-05-18 23:43:18', '2026-05-18 23:58:20', 'Logout'),
(223, 3, '2026-05-18 23:58:23', '2026-05-19 01:03:44', 'Logout'),
(224, 1, '2026-05-19 03:03:40', NULL, 'Login'),
(225, 1, '2026-05-19 03:35:48', NULL, 'Login'),
(226, 1, '2026-05-19 03:37:07', NULL, 'Login'),
(227, 1, '2026-05-19 03:37:10', '2026-05-19 06:03:01', 'Logout'),
(228, 1, '2026-05-19 06:03:17', '2026-05-19 06:03:24', 'Logout'),
(229, 2, '2026-05-19 06:03:28', NULL, 'Login'),
(230, 2, '2026-05-19 06:04:54', NULL, 'Login'),
(231, 2, '2026-05-19 06:05:16', '2026-05-19 06:31:12', 'Logout'),
(232, 2, '2026-05-19 06:07:30', '2026-05-19 06:07:45', 'Logout'),
(233, 1, '2026-05-19 06:08:56', '2026-05-19 07:12:36', 'Logout'),
(234, 3, '2026-05-19 06:25:27', '2026-05-19 06:36:37', 'Logout'),
(235, 3, '2026-05-19 06:32:12', '2026-05-19 06:35:31', 'Logout'),
(236, 1, '2026-05-19 06:35:34', '2026-05-19 07:03:37', 'Logout'),
(237, 2, '2026-05-19 06:36:42', '2026-05-19 07:22:49', 'Logout'),
(238, 2, '2026-05-19 07:11:19', '2026-05-19 07:13:25', 'Logout'),
(239, 1, '2026-05-19 07:13:43', '2026-05-20 09:58:53', 'Logout'),
(240, 1, '2026-05-19 07:14:53', '2026-05-19 22:44:04', 'Logout'),
(241, 2, '2026-05-19 07:24:36', NULL, 'Login'),
(242, 3, '2026-05-19 22:44:08', '2026-05-19 22:47:01', 'Logout'),
(243, 1, '2026-05-19 22:47:05', '2026-05-19 23:17:51', 'Logout'),
(244, 1, '2026-05-19 23:18:38', '2026-05-19 23:19:51', 'Logout'),
(245, 2, '2026-05-20 09:45:12', NULL, 'Login'),
(246, 2, '2026-05-20 09:48:33', NULL, 'Login'),
(247, 1, '2026-05-20 09:49:45', '2026-05-20 09:52:56', 'Logout'),
(248, 2, '2026-05-20 09:53:30', NULL, 'Login'),
(249, 2, '2026-05-20 21:03:44', '2026-05-20 21:27:11', 'Logout'),
(250, 3, '2026-05-20 21:27:14', '2026-05-20 21:27:54', 'Logout'),
(251, 2, '2026-05-20 21:27:26', NULL, 'Login'),
(252, 1, '2026-05-20 21:27:57', '2026-05-20 21:30:42', 'Logout'),
(253, 3, '2026-05-20 21:30:45', '2026-05-20 21:33:44', 'Logout'),
(254, 2, '2026-05-20 23:32:07', '2026-05-20 23:36:31', 'Logout'),
(255, 3, '2026-05-20 23:36:34', '2026-05-21 00:23:20', 'Logout'),
(256, 3, '2026-05-21 14:04:04', '2026-05-21 14:04:08', 'Logout'),
(257, 1, '2026-05-21 14:06:52', NULL, 'Login'),
(258, 1, '2026-05-21 16:47:00', NULL, 'Login'),
(259, 2, '2026-05-21 16:48:19', NULL, 'Login'),
(260, 1, '2026-05-21 16:49:45', '2026-05-21 17:44:05', 'Logout'),
(261, 1, '2026-05-23 21:37:18', NULL, 'Login'),
(262, 1, '2026-05-23 21:55:15', '2026-05-23 22:35:56', 'Logout'),
(263, 1, '2026-05-23 23:36:10', '2026-05-23 23:36:36', 'Logout'),
(264, 2, '2026-05-23 23:36:39', '2026-05-23 23:37:07', 'Logout'),
(265, 1, '2026-05-24 18:44:20', NULL, 'Login'),
(266, 3, '2026-05-24 18:50:23', '2026-05-24 19:00:43', 'Logout'),
(267, 1, '2026-05-24 18:51:35', '2026-05-24 18:58:36', 'Logout'),
(268, 1, '2026-05-24 19:00:54', '2026-05-24 19:08:10', 'Logout'),
(269, 2, '2026-05-24 19:09:31', '2026-05-24 19:28:01', 'Logout'),
(270, 3, '2026-05-24 19:11:04', '2026-05-24 19:11:31', 'Logout'),
(271, 1, '2026-05-24 19:11:39', NULL, 'Login'),
(272, 1, '2026-05-24 22:57:39', '2026-05-24 23:24:12', 'Logout'),
(273, 1, '2026-05-25 18:30:54', NULL, 'Login'),
(274, 2, '2026-05-28 15:12:51', '2026-05-28 15:13:39', 'Logout'),
(275, 1, '2026-05-28 15:13:47', '2026-05-28 15:18:12', 'Logout'),
(276, 1, '2026-06-01 15:46:32', '2026-06-01 15:48:10', 'Logout'),
(277, 2, '2026-06-01 15:48:16', '2026-06-01 15:48:53', 'Logout'),
(278, 3, '2026-06-01 15:49:00', '2026-06-01 15:49:20', 'Logout'),
(279, 1, '2026-06-01 18:16:11', NULL, 'Login'),
(280, 3, '2026-06-03 16:56:14', '2026-06-03 16:59:25', 'Logout'),
(281, 1, '2026-06-03 17:14:54', NULL, 'Login'),
(282, 1, '2026-06-04 17:53:54', '2026-06-04 17:54:09', 'Logout'),
(283, 1, '2026-06-06 17:16:02', NULL, 'Login'),
(284, 1, '2026-06-06 17:16:13', NULL, 'Login'),
(285, 2, '2026-06-06 17:20:04', NULL, 'Login'),
(286, 2, '2026-06-06 17:21:22', NULL, 'Login'),
(287, 1, '2026-06-06 22:12:27', '2026-06-06 22:29:39', 'Logout'),
(288, 1, '2026-06-06 22:29:45', NULL, 'Login'),
(289, 2, '2026-06-06 23:11:33', NULL, 'Login'),
(290, 1, '2026-06-10 22:51:52', '2026-06-11 00:16:11', 'Logout'),
(291, 1, '2026-06-11 21:45:40', NULL, 'Login'),
(292, 1, '2026-06-12 08:19:26', NULL, 'Login'),
(293, 1, '2026-06-12 18:11:01', '2026-06-12 23:09:25', 'Logout'),
(294, 2, '2026-06-12 18:40:42', '2026-06-12 18:41:01', 'Logout'),
(295, 3, '2026-06-12 18:41:05', '2026-06-12 18:44:44', 'Logout'),
(296, 2, '2026-06-12 18:44:47', '2026-06-12 23:04:36', 'Logout'),
(297, 1, '2026-06-12 23:09:30', '2026-06-13 01:08:40', 'Logout'),
(298, 2, '2026-06-12 23:54:22', NULL, 'failed'),
(299, 2, '2026-06-12 23:54:54', '2026-06-12 23:54:56', 'Logout'),
(300, 1, '2026-06-13 10:02:49', NULL, 'Login'),
(301, 1, '2026-06-14 15:56:12', '2026-06-14 16:42:19', 'Logout'),
(302, 1, '2026-06-14 17:27:20', '2026-06-15 00:17:28', 'Logout'),
(303, 1, '2026-06-15 09:36:52', '2026-06-15 09:45:52', 'Logout'),
(304, 2, '2026-06-15 09:45:59', '2026-06-15 09:47:28', 'Logout'),
(305, 1, '2026-06-15 09:47:35', NULL, 'Login'),
(306, 1, '2026-06-16 12:54:56', '2026-06-16 12:55:35', 'Logout'),
(307, 1, '2026-06-16 12:55:52', '2026-06-16 13:03:40', 'Logout'),
(308, 3, '2026-06-16 12:57:45', NULL, 'Login'),
(309, 2, '2026-06-16 13:00:40', NULL, 'failed'),
(310, 2, '2026-06-16 13:00:50', NULL, 'failed'),
(311, 11, '2026-06-16 15:28:07', '2026-06-16 15:28:26', 'Logout'),
(312, 12, '2026-06-16 16:04:17', NULL, 'Login'),
(313, 13, '2026-06-17 11:10:07', '2026-06-17 11:10:45', 'Logout'),
(314, 14, '2026-06-17 11:41:47', NULL, 'Login');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `M_ID` int(11) NOT NULL,
  `Asset_name` varchar(100) NOT NULL,
  `Dept_ID` int(11) DEFAULT NULL,
  `M_type` enum('Preventive','Corrective','Predetermined','Condition-based','Predictive','Reactive') DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `next_m` datetime DEFAULT NULL,
  `Priority` varchar(20) DEFAULT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Pending',
  `T_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`M_ID`, `Asset_name`, `Dept_ID`, `M_type`, `desc`, `created_at`, `next_m`, `Priority`, `Status`, `T_description`) VALUES
(2, 's', NULL, 'Predictive', '', '2026-04-20 21:18:24', '2027-05-02 14:57:15', NULL, 'Resolved', NULL),
(4, 'sa', NULL, 'Preventive', '', '2026-04-20 23:39:01', '2026-08-02 14:57:05', NULL, 'Resolved', NULL),
(6, 'test', 9, 'Preventive', 'test', '2026-05-12 21:38:30', '2027-05-19 19:19:14', 'Medium', 'Resolved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `N_ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`N_ID`, `user_id`, `message`, `type`, `ref_id`, `is_read`, `created_at`) VALUES
(1, 4, 'Your ticket #13 has been accepted.', 'ticket', 13, 1, '2026-04-26 18:28:31'),
(7, 4, 'Your ticket #10 has been accepted.', 'ticket', 10, 0, '2026-04-26 20:50:05'),
(8, 4, 'Your ticket #10 has been resolved.', 'ticket', 10, 0, '2026-04-26 20:50:06'),
(9, 4, 'Your ticket #8 has been resolved.', 'ticket', 8, 0, '2026-04-26 20:50:13'),
(10, 3, 'Your ticket #16 has been accepted.', 'ticket', 16, 0, '2026-04-27 22:22:14'),
(11, 3, 'Your ticket #15 has been accepted.', 'ticket', 15, 0, '2026-04-27 22:43:09'),
(12, 3, 'Your ticket #14 has been accepted.', 'ticket', 14, 0, '2026-04-27 23:43:46'),
(13, 3, 'Your ticket #14 has been resolved.', 'ticket', 14, 0, '2026-04-27 23:44:32'),
(14, 3, 'ticket #14 has been resolved by Staff', 'ticket', 14, 0, '2026-04-27 23:44:32'),
(15, 1, 'Ticket #14 has been marked as Resolved by Staff', 'ticket', 14, 0, '2026-04-27 23:44:32'),
(16, 3, 'Your ticket #17 has been accepted.', 'ticket', 17, 0, '2026-04-28 15:53:38'),
(17, 3, 'Your ticket #15 has been resolved.', 'ticket', 15, 0, '2026-04-28 15:57:48'),
(18, 3, 'ticket #15 has been resolved by Staff', 'ticket', 15, 0, '2026-04-28 15:57:48'),
(19, 1, 'Ticket #15 has been marked as Resolved by Staff', 'ticket', 15, 0, '2026-04-28 15:57:48'),
(20, 3, 'Your ticket #16 has been resolved.', 'ticket', 16, 0, '2026-04-28 15:57:51'),
(21, 3, 'ticket #16 has been resolved by Staff', 'ticket', 16, 0, '2026-04-28 15:57:51'),
(22, 1, 'Ticket #16 has been marked as Resolved by Staff', 'ticket', 16, 0, '2026-04-28 15:57:51'),
(23, 3, 'Your ticket #22 has been accepted.', 'ticket', 22, 0, '2026-04-28 16:08:09'),
(24, 3, 'Your ticket #22 has been resolved.', 'ticket', 22, 0, '2026-04-28 16:08:13'),
(25, 3, 'ticket #22 has been resolved by Staff', 'ticket', 22, 0, '2026-04-28 16:08:13'),
(26, 1, 'Ticket #22 has been marked as Resolved by Staff', 'ticket', 22, 0, '2026-04-28 16:08:13'),
(27, 3, 'Your ticket #20 has been accepted.', 'ticket', 20, 0, '2026-04-28 16:08:28'),
(28, 3, 'Your ticket #20 has been resolved.', 'ticket', 20, 0, '2026-04-28 16:08:29'),
(29, 3, 'ticket #20 has been resolved by Staff', 'ticket', 20, 0, '2026-04-28 16:08:29'),
(30, 1, 'Ticket #20 has been marked as Resolved by Staff', 'ticket', 20, 0, '2026-04-28 16:08:29'),
(31, 3, 'Your ticket #21 has been accepted.', 'ticket', 21, 0, '2026-04-28 16:08:32'),
(32, 3, 'Your ticket #21 has been resolved.', 'ticket', 21, 0, '2026-04-28 16:08:33'),
(33, 3, 'ticket #21 has been resolved by Staff', 'ticket', 21, 0, '2026-04-28 16:08:33'),
(34, 1, 'Ticket #21 has been marked as Resolved by Staff', 'ticket', 21, 0, '2026-04-28 16:08:33'),
(35, 3, 'Your ticket #19 has been accepted.', 'ticket', 19, 0, '2026-04-28 16:08:40'),
(36, 3, 'Your ticket #19 has been resolved.', 'ticket', 19, 0, '2026-04-28 16:08:41'),
(37, 3, 'ticket #19 has been resolved by Staff', 'ticket', 19, 0, '2026-04-28 16:08:41'),
(38, 1, 'Ticket #19 has been marked as Resolved by Staff', 'ticket', 19, 0, '2026-04-28 16:08:41'),
(39, 3, 'Your ticket #18 has been accepted.', 'ticket', 18, 0, '2026-04-28 16:08:43'),
(40, 3, 'Your ticket #18 has been resolved.', 'ticket', 18, 0, '2026-04-28 16:08:44'),
(41, 3, 'ticket #18 has been resolved by Staff', 'ticket', 18, 0, '2026-04-28 16:08:44'),
(42, 1, 'Ticket #18 has been marked as Resolved by Staff', 'ticket', 18, 0, '2026-04-28 16:08:44'),
(43, 3, 'Your ticket #17 has been resolved.', 'ticket', 17, 0, '2026-04-28 16:09:24'),
(44, 3, 'ticket #17 has been resolved by Staff', 'ticket', 17, 0, '2026-04-28 16:09:24'),
(45, 1, 'Ticket #17 has been marked as Resolved by Staff', 'ticket', 17, 0, '2026-04-28 16:09:24'),
(46, 3, 'Your ticket #28 has been accepted.', 'ticket', 28, 0, '2026-04-30 16:32:12'),
(47, 3, 'Your ticket #28 has been resolved.', 'ticket', 28, 0, '2026-04-30 16:32:39'),
(48, 3, 'ticket #28 has been resolved by Staff', 'ticket', 28, 0, '2026-04-30 16:32:39'),
(49, 4, 'Your ticket #29 has been resolved.', 'ticket', 29, 0, '2026-04-30 16:33:00'),
(50, 4, 'ticket #29 has been resolved by Staff', 'ticket', 29, 0, '2026-04-30 16:33:00'),
(51, 4, 'Your ticket #25 has been accepted.', 'ticket', 25, 0, '2026-04-30 16:37:59'),
(52, 4, 'Your ticket #25 has been resolved.', 'ticket', 25, 0, '2026-04-30 16:38:02'),
(53, 4, 'ticket #25 has been resolved by Staff', 'ticket', 25, 0, '2026-04-30 16:38:02'),
(54, 4, 'Your ticket #24 has been accepted.', 'ticket', 24, 0, '2026-04-30 16:38:06'),
(55, 4, 'Your ticket #24 has been resolved.', 'ticket', 24, 0, '2026-04-30 16:38:08'),
(56, 4, 'ticket #24 has been resolved by Staff', 'ticket', 24, 0, '2026-04-30 16:38:08'),
(57, 4, 'Your ticket #23 has been accepted.', 'ticket', 23, 0, '2026-04-30 16:45:57'),
(58, 4, 'Your ticket #23 has been resolved.', 'ticket', 23, 0, '2026-04-30 16:45:59'),
(59, 4, 'ticket #23 has been resolved by Staff', 'ticket', 23, 0, '2026-04-30 16:45:59'),
(60, 0, 'New Assignment: You have been assigned to Ticket #30 (ASD).', 'assignment', 30, 0, '2026-04-30 19:02:30'),
(61, 2, 'New Assignment: You have been assigned to Ticket #30 (ASD).', 'assignment', 30, 0, '2026-04-30 19:02:55'),
(62, 3, 'Your ticket #34 has been accepted.', 'ticket', 34, 0, '2026-04-30 19:22:30'),
(63, 2, 'New Assignment: You have been assigned to Ticket #34 (asd).', 'assignment', 34, 0, '2026-04-30 19:22:30'),
(64, 3, 'Your ticket #34 has been resolved.', 'ticket', 34, 0, '2026-04-30 19:22:32'),
(65, 3, 'ticket #34 has been resolved by Staff', 'ticket', 34, 0, '2026-04-30 19:22:32'),
(66, 3, 'Your ticket #36 has been accepted.', 'ticket', 36, 0, '2026-04-30 19:29:27'),
(67, 2, 'New Assignment: You have been assigned to Ticket #36 (asd).', 'assignment', 36, 0, '2026-04-30 19:29:27'),
(68, 3, 'Your ticket #36 has been resolved.', 'ticket', 36, 0, '2026-04-30 19:29:28'),
(69, 3, 'ticket #36 has been resolved by Staff', 'ticket', 36, 0, '2026-04-30 19:29:28'),
(70, 3, 'Your ticket #31 has been accepted.', 'ticket', 31, 0, '2026-04-30 19:30:39'),
(71, 2, 'New Assignment: You have been assigned to Ticket #31 (sad).', 'assignment', 31, 0, '2026-04-30 19:30:39'),
(72, 3, 'Your ticket #31 has been resolved.', 'ticket', 31, 0, '2026-04-30 19:30:40'),
(73, 3, 'ticket #31 has been resolved by Staff', 'ticket', 31, 0, '2026-04-30 19:30:40'),
(74, 3, 'Your ticket #33 has been accepted.', 'ticket', 33, 0, '2026-04-30 19:30:46'),
(75, 2, 'New Assignment: You have been assigned to Ticket #33 (asd).', 'assignment', 33, 0, '2026-04-30 19:30:46'),
(76, 3, 'Your ticket #33 has been resolved.', 'ticket', 33, 0, '2026-04-30 19:30:47'),
(77, 3, 'ticket #33 has been resolved by Staff', 'ticket', 33, 0, '2026-04-30 19:30:47'),
(78, 3, 'Your ticket #32 has been accepted.', 'ticket', 32, 0, '2026-04-30 19:31:46'),
(79, 2, 'New Assignment: You have been assigned to Ticket #32 (testimh).', 'assignment', 32, 0, '2026-04-30 19:31:46'),
(80, 3, 'Your ticket #32 has been resolved.', 'ticket', 32, 0, '2026-04-30 19:31:48'),
(81, 3, 'ticket #32 has been resolved by Staff', 'ticket', 32, 0, '2026-04-30 19:31:48'),
(82, 2, 'New Assignment: You have been assigned to Ticket #35 (asd).', 'assignment', 35, 0, '2026-05-01 23:55:49'),
(83, 3, 'ticket #35 has been resolved by Staff', 'ticket', 35, 0, '2026-05-01 23:55:49'),
(84, 3, 'Your ticket #36 has been resolved.', 'ticket', 36, 0, '2026-05-06 00:43:57'),
(85, 3, 'ticket #36 has been resolved by Staff', 'ticket', 36, 0, '2026-05-06 00:43:57'),
(86, 3, 'Your ticket #37 has been accepted.', 'ticket', 37, 0, '2026-05-06 01:08:17'),
(87, 2, 'New Assignment: You have been assigned to Ticket #37 (test).', 'assignment', 37, 0, '2026-05-06 01:08:17'),
(88, 3, 'Your ticket #37 has been resolved.', 'ticket', 37, 0, '2026-05-06 01:08:39'),
(89, 3, 'ticket #37 has been resolved by Staff', 'ticket', 37, 0, '2026-05-06 01:08:39'),
(90, 3, 'ticket #37 has been resolved by Staff', 'ticket', 37, 0, '2026-05-08 13:34:00'),
(91, 0, 'New Assignment: You have been assigned to Ticket #37 (test).', 'assignment', 37, 0, '2026-05-08 18:21:42'),
(92, 3, 'Your ticket #37 has been accepted.', 'ticket', 37, 0, '2026-05-11 11:16:20'),
(93, 2, 'New Assignment: You have been assigned to Ticket #37 (test).', 'assignment', 37, 0, '2026-05-11 11:16:20'),
(94, 3, 'Your ticket #37 has been resolved.', 'ticket', 37, 0, '2026-05-11 11:16:21'),
(95, 3, 'ticket #37 has been resolved by Staff', 'ticket', 37, 0, '2026-05-11 11:16:21'),
(96, 3, 'Your ticket #39 has been accepted.', 'ticket', 39, 0, '2026-05-11 11:37:47'),
(97, 6, 'New Assignment: You have been assigned to Ticket #39 (test).', 'assignment', 39, 0, '2026-05-11 11:37:47'),
(98, 3, 'Your ticket #39 has been resolved.', 'ticket', 39, 0, '2026-05-11 11:40:55'),
(99, 3, 'ticket #39 has been resolved by Staff', 'ticket', 39, 0, '2026-05-11 11:40:55'),
(100, 3, 'Your ticket #40 has been accepted.', 'ticket', 40, 0, '2026-05-11 11:44:36'),
(101, 6, 'New Assignment: You have been assigned to Ticket #40 (test).', 'assignment', 40, 0, '2026-05-11 11:44:36'),
(102, 0, 'New Assignment: You have been assigned to Ticket #40 (test).', 'assignment', 40, 0, '2026-05-11 11:49:34'),
(103, 3, 'Your ticket #40 has been accepted.', 'ticket', 40, 0, '2026-05-11 11:49:39'),
(104, 6, 'New Assignment: You have been assigned to Ticket #40 (test).', 'assignment', 40, 0, '2026-05-11 11:49:39'),
(105, 0, 'New Assignment: You have been assigned to Ticket #40 (test).', 'assignment', 40, 0, '2026-05-11 11:58:00'),
(106, 3, 'Your ticket #40 has been accepted.', 'ticket', 40, 0, '2026-05-11 11:58:02'),
(107, 6, 'New Assignment: You have been assigned to Ticket #40 (test).', 'assignment', 40, 0, '2026-05-11 11:58:02'),
(108, 0, 'New Assignment: You have been assigned to Ticket #40 (test).', 'assignment', 40, 0, '2026-05-11 11:58:18'),
(109, 3, 'Your ticket #40 has been accepted.', 'ticket', 40, 0, '2026-05-11 11:58:23'),
(110, 6, 'New Assignment: You have been assigned to Ticket #40 (test).', 'assignment', 40, 0, '2026-05-11 11:58:23'),
(111, 3, 'Your ticket #40 has been resolved.', 'ticket', 40, 0, '2026-05-11 12:07:37'),
(112, 3, 'ticket #40 has been resolved by Staff', 'ticket', 40, 0, '2026-05-11 12:07:37'),
(113, 3, 'Your ticket #41 has been accepted.', 'ticket', 41, 0, '2026-05-11 12:10:36'),
(114, 2, 'New Assignment: You have been assigned to Ticket #41 (test).', 'assignment', 41, 0, '2026-05-11 12:10:36'),
(115, 3, 'Your ticket #41 has been resolved.', 'ticket', 41, 0, '2026-05-11 12:23:11'),
(116, 3, 'ticket #41 has been resolved by Staff', 'ticket', 41, 0, '2026-05-11 12:23:11'),
(117, 3, 'Your ticket #42 has been accepted.', 'ticket', 42, 0, '2026-05-11 13:38:48'),
(118, 2, 'New Assignment: You have been assigned to Ticket #42 (test).', 'assignment', 42, 0, '2026-05-11 13:38:48'),
(119, 5, 'New Assignment: You have been assigned to Ticket #43 (ss).', 'assignment', 43, 0, '2026-05-11 16:26:36'),
(120, 3, 'ticket #43 has been resolved by Staff', 'ticket', 43, 0, '2026-05-11 16:26:36'),
(121, 3, 'ticket #43 has been resolved by Staff', 'ticket', 43, 0, '2026-05-11 16:28:10'),
(122, 3, 'ticket #43 has been resolved by Staff', 'ticket', 43, 0, '2026-05-11 23:03:25'),
(123, 3, 'ticket #43 has been resolved by Staff', 'ticket', 43, 0, '2026-05-11 23:05:36'),
(124, 3, 'ticket #43 has been resolved by Staff', 'ticket', 43, 0, '2026-05-11 23:09:21'),
(125, 3, 'ticket #43 has been resolved by Staff', 'ticket', 43, 0, '2026-05-11 23:09:59'),
(126, 3, 'Your ticket #44 has been accepted.', 'ticket', 44, 0, '2026-05-11 23:24:04'),
(127, 2, 'New Assignment: You have been assigned to Ticket #44 ().', 'assignment', 44, 0, '2026-05-11 23:24:04'),
(128, 3, 'Your ticket #44 has been resolved.', 'ticket', 44, 0, '2026-05-11 23:25:54'),
(129, 3, 'ticket #44 has been resolved by Staff', 'ticket', 44, 0, '2026-05-11 23:25:54'),
(130, 3, 'Your ticket #44 has been resolved.', 'ticket', 44, 0, '2026-05-11 23:55:26'),
(131, 3, 'ticket #44 has been resolved by Staff', 'ticket', 44, 0, '2026-05-11 23:55:26'),
(132, 3, 'Your ticket #46 has been accepted.', 'ticket', 46, 0, '2026-05-12 20:49:33'),
(133, 2, 'New Assignment: You have been assigned to Ticket #46 ().', 'assignment', 46, 0, '2026-05-12 20:49:33'),
(134, 3, 'Your ticket #45 has been accepted.', 'ticket', 45, 0, '2026-05-12 20:51:11'),
(135, 2, 'New Assignment: You have been assigned to Ticket #45 ().', 'assignment', 45, 0, '2026-05-12 20:51:11'),
(136, 3, 'Your ticket #48 has been accepted.', 'ticket', 48, 0, '2026-05-18 23:04:32'),
(137, 2, 'New Assignment: You have been assigned to Ticket #48 .', 'assignment', 48, 0, '2026-05-18 23:04:32'),
(138, 3, 'Your ticket #48 has been resolved.', 'ticket', 48, 0, '2026-05-18 23:05:32'),
(139, 3, 'ticket #48 has been resolved by Staff', 'ticket', 48, 0, '2026-05-18 23:05:32'),
(140, 3, 'Your ticket #45 has been resolved.', 'ticket', 45, 0, '2026-05-19 06:13:07'),
(141, 3, 'ticket #45 has been resolved by Staff', 'ticket', 45, 0, '2026-05-19 06:13:07'),
(142, 3, 'Your ticket #49 has been accepted.', 'ticket', 49, 0, '2026-05-19 06:37:09'),
(143, 2, 'New Assignment: You have been assigned to Ticket #49 .', 'assignment', 49, 0, '2026-05-19 06:37:09'),
(144, 3, 'Your ticket #49 has been resolved.', 'ticket', 49, 0, '2026-05-19 06:37:15'),
(145, 3, 'ticket #49 has been resolved by Staff', 'ticket', 49, 0, '2026-05-19 06:37:15'),
(146, 3, 'Your ticket #49 has been resolved.', 'ticket', 49, 0, '2026-05-19 07:25:01'),
(147, 3, 'ticket #49 has been resolved by Staff', 'ticket', 49, 0, '2026-05-19 07:25:01'),
(148, 3, 'ticket #49 has been resolved by Staff', 'ticket', 49, 0, '2026-05-19 07:30:29'),
(149, 3, 'ticket #49 has been resolved by Staff', 'ticket', 49, 0, '2026-05-19 22:39:13'),
(150, 5, 'New Assignment: You have been assigned to Ticket #50 .', 'assignment', 50, 0, '2026-05-19 23:11:41'),
(151, 3, 'Your ticket #51 has been accepted.', 'ticket', 51, 0, '2026-05-20 23:33:10'),
(152, 2, 'New Assignment: You have been assigned to Ticket #51 .', 'assignment', 51, 0, '2026-05-20 23:33:10'),
(153, 3, 'Your ticket #51 has been resolved.', 'ticket', 51, 0, '2026-05-20 23:33:23'),
(154, 3, 'ticket #51 has been resolved by Staff', 'ticket', 51, 0, '2026-05-20 23:33:23'),
(155, 3, 'ticket #50 has been resolved by Staff', 'ticket', 50, 0, '2026-05-21 17:03:40'),
(156, 1, 'Item \'005\' is low on stock.', 'inventory', 2, 0, '2026-05-24 18:50:37'),
(157, 7, 'Item \'005\' is low on stock.', 'inventory', 2, 0, '2026-05-24 18:50:37'),
(158, 2, 'New Assignment: You have been assigned to Ticket #52 .', 'assignment', 52, 0, '2026-05-24 18:52:19'),
(159, 2, 'New Assignment: You have been assigned to Ticket #53 .', 'assignment', 53, 0, '2026-05-24 19:12:06'),
(160, 3, 'Your ticket #53 has been resolved.', 'ticket', 53, 0, '2026-05-24 19:12:34'),
(161, 3, 'ticket #53 has been resolved by Staff', 'ticket', 53, 0, '2026-05-24 19:12:34'),
(162, 3, 'Your ticket #55 has been accepted.', 'ticket', 55, 0, '2026-06-12 18:44:58'),
(163, 2, 'New Assignment: You have been assigned to Ticket #55 .', 'assignment', 55, 0, '2026-06-12 18:44:58'),
(164, 3, 'Your ticket #55 has been resolved.', 'ticket', 55, 0, '2026-06-12 18:45:01'),
(165, 3, 'ticket #55 has been resolved by Staff', 'ticket', 55, 0, '2026-06-12 18:45:01');

-- --------------------------------------------------------

--
-- Table structure for table `notification_dismissals`
--

CREATE TABLE `notification_dismissals` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `dismissed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_dismissals`
--

INSERT INTO `notification_dismissals` (`id`, `notification_id`, `user_id`, `dismissed_at`) VALUES
(1, 7, 1, '2026-04-26 13:53:10'),
(2, 8, 1, '2026-04-26 13:54:34'),
(3, 9, 4, '2026-04-26 14:01:31'),
(4, 8, 4, '2026-04-26 14:01:32'),
(5, 7, 4, '2026-04-26 14:01:33'),
(6, 1, 4, '2026-04-26 14:01:34'),
(7, 9, 1, '2026-04-26 14:02:20'),
(9, 1, 1, '2026-04-26 14:02:21'),
(10, 9, 2, '2026-04-26 14:44:23'),
(11, 8, 2, '2026-04-26 14:44:24'),
(12, 7, 2, '2026-04-26 14:44:25'),
(13, 1, 2, '2026-04-26 14:44:26'),
(14, 13, 1, '2026-04-27 17:02:01'),
(15, 14, 1, '2026-04-27 17:02:04'),
(16, 15, 1, '2026-04-27 17:02:05'),
(17, 12, 1, '2026-04-27 17:02:07'),
(18, 11, 1, '2026-04-27 17:30:16'),
(19, 10, 1, '2026-04-27 17:30:18'),
(20, 43, 3, '2026-04-28 08:12:33'),
(21, 44, 3, '2026-04-28 08:12:34'),
(22, 45, 3, '2026-04-28 08:12:35'),
(23, 40, 3, '2026-04-28 08:12:36'),
(24, 41, 3, '2026-04-28 08:12:37'),
(25, 42, 3, '2026-04-28 08:12:37'),
(26, 39, 3, '2026-04-28 08:12:38'),
(27, 36, 3, '2026-04-28 08:12:39'),
(28, 37, 3, '2026-04-28 08:12:40'),
(29, 38, 3, '2026-04-28 08:12:41'),
(30, 35, 3, '2026-04-28 08:12:41'),
(32, 32, 3, '2026-04-28 08:12:42'),
(33, 33, 3, '2026-04-28 08:12:44'),
(34, 34, 3, '2026-04-28 08:12:45'),
(35, 31, 3, '2026-04-28 08:12:45'),
(36, 28, 3, '2026-04-28 08:12:46'),
(37, 29, 3, '2026-04-28 08:12:47'),
(38, 30, 3, '2026-04-28 08:12:48'),
(39, 27, 3, '2026-04-28 08:12:49'),
(43, 16, 1, '2026-04-28 08:29:31'),
(44, 17, 1, '2026-04-28 08:29:31'),
(45, 18, 1, '2026-04-28 08:29:31'),
(46, 19, 1, '2026-04-28 08:29:31'),
(47, 20, 1, '2026-04-28 08:29:31'),
(48, 21, 1, '2026-04-28 08:29:31'),
(49, 22, 1, '2026-04-28 08:29:31'),
(50, 23, 1, '2026-04-28 08:29:31'),
(51, 24, 1, '2026-04-28 08:29:31'),
(52, 25, 1, '2026-04-28 08:29:31'),
(53, 26, 1, '2026-04-28 08:29:31'),
(54, 27, 1, '2026-04-28 08:29:31'),
(55, 28, 1, '2026-04-28 08:29:31'),
(56, 29, 1, '2026-04-28 08:29:31'),
(57, 30, 1, '2026-04-28 08:29:31'),
(58, 31, 1, '2026-04-28 08:29:31'),
(59, 32, 1, '2026-04-28 08:29:31'),
(60, 33, 1, '2026-04-28 08:29:31'),
(61, 34, 1, '2026-04-28 08:29:31'),
(62, 35, 1, '2026-04-28 08:29:31'),
(63, 36, 1, '2026-04-28 08:29:31'),
(64, 37, 1, '2026-04-28 08:29:31'),
(65, 38, 1, '2026-04-28 08:29:31'),
(66, 39, 1, '2026-04-28 08:29:31'),
(67, 40, 1, '2026-04-28 08:29:31'),
(68, 41, 1, '2026-04-28 08:29:31'),
(69, 42, 1, '2026-04-28 08:29:31'),
(70, 43, 1, '2026-04-28 08:29:31'),
(71, 44, 1, '2026-04-28 08:29:31'),
(72, 45, 1, '2026-04-28 08:29:31'),
(74, 1, 3, '2026-04-28 08:29:45'),
(75, 7, 3, '2026-04-28 08:29:45'),
(76, 8, 3, '2026-04-28 08:29:45'),
(77, 9, 3, '2026-04-28 08:29:45'),
(78, 10, 3, '2026-04-28 08:29:45'),
(79, 11, 3, '2026-04-28 08:29:45'),
(80, 12, 3, '2026-04-28 08:29:45'),
(81, 13, 3, '2026-04-28 08:29:45'),
(82, 14, 3, '2026-04-28 08:29:45'),
(83, 15, 3, '2026-04-28 08:29:45'),
(84, 16, 3, '2026-04-28 08:29:45'),
(85, 17, 3, '2026-04-28 08:29:45'),
(86, 18, 3, '2026-04-28 08:29:45'),
(87, 19, 3, '2026-04-28 08:29:45'),
(88, 20, 3, '2026-04-28 08:29:45'),
(89, 21, 3, '2026-04-28 08:29:45'),
(90, 22, 3, '2026-04-28 08:29:45'),
(91, 23, 3, '2026-04-28 08:29:45'),
(92, 24, 3, '2026-04-28 08:29:45'),
(93, 25, 3, '2026-04-28 08:29:45'),
(94, 26, 3, '2026-04-28 08:29:45'),
(96, 46, 3, '2026-04-30 10:56:26'),
(97, 47, 3, '2026-04-30 10:56:26'),
(98, 48, 3, '2026-04-30 10:56:26'),
(99, 61, 2, '2026-05-05 16:44:20'),
(100, 63, 2, '2026-05-05 16:44:20'),
(101, 67, 2, '2026-05-05 16:44:20'),
(102, 71, 2, '2026-05-05 16:44:20'),
(103, 75, 2, '2026-05-05 16:44:20'),
(104, 79, 2, '2026-05-05 16:44:20'),
(105, 82, 2, '2026-05-05 16:44:20'),
(106, 87, 2, '2026-05-08 05:45:20'),
(107, 115, 3, '2026-05-11 05:17:05'),
(108, 62, 3, '2026-05-11 05:17:07'),
(109, 64, 3, '2026-05-11 05:17:07'),
(110, 65, 3, '2026-05-11 05:17:07'),
(111, 66, 3, '2026-05-11 05:17:07'),
(112, 68, 3, '2026-05-11 05:17:07'),
(113, 69, 3, '2026-05-11 05:17:07'),
(114, 70, 3, '2026-05-11 05:17:07'),
(115, 72, 3, '2026-05-11 05:17:07'),
(116, 73, 3, '2026-05-11 05:17:07'),
(117, 74, 3, '2026-05-11 05:17:07'),
(118, 76, 3, '2026-05-11 05:17:07'),
(119, 77, 3, '2026-05-11 05:17:07'),
(120, 78, 3, '2026-05-11 05:17:07'),
(121, 80, 3, '2026-05-11 05:17:07'),
(122, 81, 3, '2026-05-11 05:17:07'),
(123, 83, 3, '2026-05-11 05:17:07'),
(124, 84, 3, '2026-05-11 05:17:07'),
(125, 85, 3, '2026-05-11 05:17:07'),
(126, 86, 3, '2026-05-11 05:17:07'),
(127, 88, 3, '2026-05-11 05:17:07'),
(128, 89, 3, '2026-05-11 05:17:07'),
(129, 90, 3, '2026-05-11 05:17:07'),
(130, 92, 3, '2026-05-11 05:17:07'),
(131, 94, 3, '2026-05-11 05:17:07'),
(132, 95, 3, '2026-05-11 05:17:07'),
(133, 96, 3, '2026-05-11 05:17:07'),
(134, 98, 3, '2026-05-11 05:17:07'),
(135, 99, 3, '2026-05-11 05:17:07'),
(136, 100, 3, '2026-05-11 05:17:07'),
(137, 103, 3, '2026-05-11 05:17:07'),
(138, 106, 3, '2026-05-11 05:17:07'),
(139, 109, 3, '2026-05-11 05:17:07'),
(140, 111, 3, '2026-05-11 05:17:07'),
(141, 112, 3, '2026-05-11 05:17:07'),
(142, 113, 3, '2026-05-11 05:17:07'),
(143, 116, 3, '2026-05-11 05:17:07'),
(144, 137, 2, '2026-05-19 13:12:51'),
(145, 135, 2, '2026-05-19 13:12:52'),
(146, 143, 2, '2026-05-19 14:25:16'),
(147, 133, 2, '2026-05-19 14:25:18'),
(148, 127, 2, '2026-05-19 14:25:19'),
(149, 118, 2, '2026-05-19 14:25:20'),
(150, 114, 2, '2026-05-19 14:25:21'),
(151, 93, 2, '2026-05-19 14:25:22'),
(152, 156, 1, '2026-05-24 10:58:20'),
(153, 159, 2, '2026-05-24 11:12:20'),
(155, 158, 2, '2026-05-24 11:12:21'),
(158, 152, 2, '2026-05-24 11:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `R_ID` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `descript` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`R_ID`, `role_name`, `descript`) VALUES
(1, 'Admin', 'Admin, Supervisor, Secretary'),
(2, 'Staff', 'Technicians (MISD STAFF)'),
(3, 'Gen_User', 'Not MISD Staff');

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
  `sub_type_id` int(11) DEFAULT NULL,
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

INSERT INTO `tickets` (`T_ID`, `ticket_num`, `Title`, `T_description`, `attachment`, `t_type`, `sub_type_id`, `Priority`, `Status`, `Created_By`, `Assigned_To`, `Dept_ID`, `issued_item_id`, `issued_qty`, `created_at`, `due_date`, `updated_at`, `resolved_at`) VALUES
(1, 'TICKET-6DE58F', 'penge item', 'test', NULL, 5, NULL, 'Medium', 'Resolved', 3, 2, 4, 2, 191, '2026-04-12 19:46:18', NULL, '2026-04-21 00:43:13', '2026-04-12 22:06:39'),
(2, 'TICKET-3C2E65', 'test 2', 'test 2', NULL, 5, NULL, 'Low', 'Resolved', 3, 5, 4, 3, 200, '2026-04-12 19:48:11', NULL, '2026-04-12 22:12:25', '2026-04-12 22:06:39'),
(3, 'TICKET-8068CE', 'test 3', 'test 3', NULL, 5, NULL, 'Low', 'Resolved', 3, 2, 4, 3, 5, '2026-04-12 19:48:17', NULL, '2026-04-12 22:07:44', '2026-04-18 19:33:20'),
(4, 'TICKET-1F726D', 'test3', 'test3', NULL, 4, NULL, 'High', 'Resolved', 3, NULL, 4, 3, 20, '2026-04-12 22:15:12', '2026-04-13 22:19:00', '2026-04-17 21:11:35', '2026-04-18 19:33:20'),
(5, 'TICKET-8F02E4', 'he', 'test', NULL, 3, NULL, 'Medium', 'Resolved', 3, 2, 4, 3, 20, '2026-04-12 22:53:02', NULL, '2026-04-17 21:09:12', '2026-04-18 19:33:20'),
(6, 'TICKET-02B7D8', 'test', 'test', NULL, 2, NULL, 'Medium', 'Resolved', 3, 5, 4, 2, 5, '2026-04-18 00:29:09', NULL, '2026-04-21 01:20:14', '2026-04-21 01:20:14'),
(7, 'TICKET-FC6A25', 'test', 'test', NULL, 5, NULL, 'High', 'Resolved', 4, 2, 2, 1, 1, '2026-04-18 00:52:12', '2026-04-17 00:54:00', '2026-04-21 00:55:54', '2026-04-18 19:33:20'),
(8, 'TICKET-06D044', 'aaaaaa', 'aa', NULL, 4, NULL, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 18:07:00', NULL, '2026-04-26 20:50:13', '2026-04-26 20:50:13'),
(9, 'TICKET-B8D69B', '', '', 'CHAMS_69eb40d638825.jpg', NULL, NULL, '', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 18:07:18', NULL, '2026-04-24 19:13:47', '2026-04-24 19:13:47'),
(10, 'TICKET-280887', 'e', 'e', NULL, 4, NULL, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 19:14:07', NULL, '2026-04-26 20:50:06', '2026-04-26 20:50:06'),
(11, 'TICKET-C02F7B', 'test', 'test', 'CHAMS_69eb508ee3f6e.jpg', 4, NULL, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 19:14:22', NULL, '2026-04-26 20:11:30', '2026-04-26 20:11:30'),
(12, 'TICKET-C6D87B', 'hello', 'hi', NULL, 3, NULL, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 19:14:29', NULL, '2026-04-26 20:10:47', '2026-04-26 20:10:47'),
(13, 'TICKET-3157D7', 'lol', 'lol', NULL, 4, NULL, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-24 19:14:35', NULL, '2026-04-26 19:03:28', '2026-04-26 19:03:28'),
(14, 'TICKET-5BB716', 'test ajax', 'test', NULL, 5, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-27 19:06:19', NULL, '2026-04-27 23:44:32', '2026-04-27 23:44:32'),
(15, 'TICKET-621295', 'asdf', 'asf', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-27 19:32:03', NULL, '2026-04-28 15:57:48', '2026-04-28 15:57:48'),
(16, 'TICKET-D33C21', 'afs', 'afs', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-27 19:32:52', NULL, '2026-04-28 15:57:51', '2026-04-28 15:57:51'),
(17, 'TICKET-5F3D15', 'sasa', 'asas', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-28 15:35:54', NULL, '2026-04-28 16:09:24', '2026-04-28 16:09:24'),
(18, 'TICKET-231E57', 'ra', 'ra', NULL, 5, NULL, 'Unlabeled', 'Resolved', 3, 5, 4, NULL, 1, '2026-04-28 15:58:01', NULL, '2026-04-28 16:08:44', '2026-04-28 16:08:44'),
(19, 'TICKET-0912B1', 'fafa', 'fafa', NULL, 3, NULL, 'Unlabeled', 'Resolved', 3, 5, 4, NULL, 1, '2026-04-28 15:58:18', NULL, '2026-04-28 16:08:41', '2026-04-28 16:08:41'),
(20, 'TICKET-5C773F', 'sa', 'sa', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 5, 4, NULL, 1, '2026-04-28 16:01:07', NULL, '2026-04-28 16:08:29', '2026-04-28 16:08:29'),
(23, 'TICKET-E077B5', 'asd', 'asd', NULL, 4, NULL, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-28 20:52:38', NULL, '2026-04-30 16:45:59', '2026-04-30 16:45:59'),
(24, 'TICKET-4F1F7A', 'asd', 'asd', NULL, 4, NULL, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-28 20:52:43', NULL, '2026-04-30 16:38:08', '2026-04-30 16:38:08'),
(25, 'TICKET-C127A8', 'das', 'das', NULL, 2, NULL, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-28 20:53:02', NULL, '2026-04-30 16:38:02', '2026-04-28 20:58:49'),
(28, 'TICKET-F1127E', 'asd', 'asd', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 13:18:45', NULL, '2026-04-30 16:32:39', '2026-04-30 16:32:39'),
(29, 'TICKET-43F9A5', 'test dash', 'test dash', NULL, 5, NULL, 'Unlabeled', 'Resolved', 4, 2, 2, NULL, 1, '2026-04-30 13:45:02', NULL, '2026-04-30 16:33:00', '2026-05-19 04:17:02'),
(30, 'TICKET-133AE7', 'ASD', 'ASD', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 18:56:17', NULL, '2026-04-30 19:02:55', '2026-05-08 22:21:58'),
(31, 'TICKET-D03FC5', 'sad', 'asd', NULL, 5, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:05:14', NULL, '2026-04-30 19:30:40', '2026-04-30 19:30:40'),
(32, 'TICKET-8D41FF', 'testimh', 'test img', 'CHAMS_69f33780eb817.jpg', 1, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:05:36', NULL, '2026-04-30 19:31:48', '2026-04-30 19:31:48'),
(33, 'TICKET-C16975', 'asd', 'asd', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:08:03', NULL, '2026-04-30 19:30:47', '2026-04-30 19:30:47'),
(34, 'TICKET-53FBE7', 'asd', 'asd', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:12:20', NULL, '2026-04-30 19:22:32', '2026-04-30 19:22:32'),
(35, 'TICKET-56BE6E', 'asd', 'asd', NULL, 5, NULL, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:22:42', NULL, '2026-05-01 23:55:49', '2026-05-01 23:55:49'),
(36, 'TICKET-A495D9', 'asd', 'asd', NULL, 5, NULL, 'High', 'Resolved', 3, 2, 4, NULL, 1, '2026-04-30 19:29:08', '2026-05-07 22:10:00', '2026-05-08 22:17:41', '2026-05-15 10:51:51'),
(37, 'TICKET-6DA9CC', 'test', 'test', NULL, 4, NULL, 'High', 'Resolved', 3, 2, 4, NULL, 1, '2026-05-05 19:28:00', '2026-05-07 18:54:00', '2026-05-11 11:16:21', '2026-05-15 10:51:51'),
(39, 'TICKET-4BF79F', 'test', 'test', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 6, 4, NULL, 1, '2026-05-11 11:37:36', NULL, '2026-05-11 11:40:55', '2026-05-11 11:40:55'),
(40, 'TICKET-0F675C', 'test', 'test', NULL, 4, NULL, 'Unlabeled', 'Resolved', 3, 6, 4, NULL, 1, '2026-05-11 11:44:23', NULL, '2026-05-11 12:07:37', '2026-05-11 12:07:37'),
(55, 'TICKET-037850', '', 'test', NULL, 3, 1, 'Unlabeled', 'Resolved', 3, 2, 4, NULL, 1, '2026-06-12 18:44:39', NULL, '2026-06-12 18:45:01', '2026-06-12 18:45:01');

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
(2, 37, 2, 'test2', '2026-05-11 15:54:34'),
(3, 45, 2, 'test', '2026-05-19 13:10:14'),
(4, 53, 2, 'The wire is the cause', '2026-05-24 11:13:15'),
(5, 55, 2, 'testing', '2026-06-12 11:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_subcategories`
--

CREATE TABLE `ticket_subcategories` (
  `sub_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_subcategories`
--

INSERT INTO `ticket_subcategories` (`sub_id`, `category_id`, `sub_name`) VALUES
(1, 3, 'Mouse/Keyboard'),
(2, 3, 'Monitor Display'),
(3, 3, 'Printer Issue'),
(4, 2, 'Login/Password Reset'),
(5, 2, 'Microsoft Office'),
(6, 2, 'CHAMS System Error'),
(7, 4, 'No Wifi'),
(8, 4, 'Not Connected');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `U_ID` int(11) NOT NULL,
  `employee_ID` int(50) NOT NULL,
  `FN` varchar(100) NOT NULL,
  `LN` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pass_hash` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `Dept_ID` int(11) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `account_status` int(11) DEFAULT 1 COMMENT '1=Active, 0=Inactive, 2=Retired',
  `contact_no` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`U_ID`, `employee_ID`, `FN`, `LN`, `email`, `pass_hash`, `role_id`, `Dept_ID`, `status`, `created_at`, `updated_at`, `account_status`, `contact_no`, `address`) VALUES
(1, 111, 'Nathan', 'Rola', 'nathanrola316@gmail.com', '$2y$10$jDqZTmUHVmFmvczaD5VsnOdvktDAZxhrKDqr939d1nyRInKZfZhaG', 1, 1, 'active', '2026-03-22 08:15:21', '2026-03-22 08:15:21', 1, '12345678910', '12|jan|lang sa|tabi tabi hehe'),
(2, 211, 'Mon Gabriel', 'Flores', 'nathanrola316@gmail.com', '$2y$10$ZOXrKxgh5EMuBmUk05yXX.W37g5lkigOtmcsQcj7xCfAVmzdJq4C6', 2, 1, 'active', '2026-03-22 09:40:08', '2026-03-22 09:40:08', 0, '09329332879', 'Blk 4 l 7|San Pedro|Brgy. Lorder|Batangas'),
(3, 311, 'Shazda', 'Chevy', 'nathanrola316@gmail.com', '$2y$10$ncfRbZIXd6K/hSOk3dmyJeFW4Y7nPUGewslmDJP/JjCjZ9lXuGvTG', 3, 4, 'active', '2026-03-22 09:40:08', '2026-03-22 09:40:08', 1, NULL, NULL),
(4, 312, 'Elena', 'Rodriguez', '22@gmail.com', '$2y$10$F.Rw4gtJ5VbxsebKlr6YvusH.gEZ1l/iAi4B4Jx1iPAbDEvt4j0L6', 3, 2, 'active', '2026-03-31 14:03:11', '2026-03-31 14:03:11', 1, NULL, NULL),
(5, 212, 'James', 'Tapic', '222@gmail.cpm', '$2y$10$XCw8yqkg03lKdJKZ9nkWielJizhxF504qYBvdg4vijUOct4GVgK7e', 2, 1, 'active', '2026-04-03 12:54:42', '2026-04-03 12:54:42', 2, NULL, NULL),
(6, 213, 'Mark', 'Ocasla', 'chamsmisd@gmail.com', '$2y$10$zu9UHP8raNTr8W5vet.Due7rjHNuiZBfatkXdAiHwbmxpNMglqQH2', 2, 1, 'active', '2026-05-11 05:13:27', '2026-05-11 05:13:27', 1, NULL, NULL),
(7, 112, 'Joshua', 'Lim', 'chamsmisd@gmail.com', '$2y$10$9714HWQShO/1eIDcqJtoiupFShKrdg.sPBInjQw.V4Gv9ZVe564d2', 1, 1, 'active', '2026-05-11 05:13:27', '2026-05-11 05:13:27', 1, NULL, NULL),
(8, 214, 'Clarice', 'Villafuerte', 'chamsmisd@gmail.com', '214', 2, 1, 'active', '2026-05-11 10:44:43', '2026-05-11 10:44:43', 1, NULL, NULL),
(11, 114, 'New', 'Acc', '114@gmail.com', '$2y$10$7G7Y6mhLaKvaX.ZUtmEAluh0O3mvwy1R0/ca0Aji5WLlKrA1YulrC', 2, 1, 'active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, NULL),
(12, 999, 'New', 'Acc', 'mongabrielflores@gmail.com', '$2y$10$UD6LnQLEF320zDi.sS6Dh.G5o9ZebGxjAQ0OAtpLHrxPejw7yV81C', 2, 1, 'active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, NULL),
(13, 888, 'New', 'Acc', 'mongabrielflores@gmail.com', '$2y$10$Ja9oZhY/WojoXz0saENL..tVEPAAKdMO9Iq3nHyRCxrWailSSW/hu', 2, 1, 'active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, NULL),
(14, 777, 'New', 'Acc', 'monruzelyvesflores@gmail.com', '$2y$10$TzmCqJ9a2S3DRWE3ldg1wOY2lk6LWxb7paItLqOniCJmCl9GlAPI.', 2, 1, 'active', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `act_logs`
--
ALTER TABLE `act_logs`
  ADD PRIMARY KEY (`A_ID`),
  ADD KEY `U_ID` (`U_ID`);

--
-- Indexes for table `archive_ledger`
--
ALTER TABLE `archive_ledger`
  ADD PRIMARY KEY (`A_ID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`D_ID`),
  ADD KEY `D_ID` (`D_ID`),
  ADD KEY `D_ID_2` (`D_ID`);

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
  ADD KEY `reference_ticket` (`reference_ticket`),
  ADD KEY `inventory_tracker_ibfk_5` (`D_ID`);

--
-- Indexes for table `inventory_type`
--
ALTER TABLE `inventory_type`
  ADD PRIMARY KEY (`IT_ID`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`L_ID`),
  ADD KEY `U_ID` (`U_ID`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`M_ID`),
  ADD KEY `Dept_ID` (`Dept_ID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`N_ID`);

--
-- Indexes for table `notification_dismissals`
--
ALTER TABLE `notification_dismissals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notification_id` (`notification_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`R_ID`);

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
-- Indexes for table `ticket_subcategories`
--
ALTER TABLE `ticket_subcategories`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`U_ID`),
  ADD KEY `Dept_ID` (`Dept_ID`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `act_logs`
--
ALTER TABLE `act_logs`
  MODIFY `A_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=497;

--
-- AUTO_INCREMENT for table `archive_ledger`
--
ALTER TABLE `archive_ledger`
  MODIFY `A_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `D_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `inventory_categories`
--
ALTER TABLE `inventory_categories`
  MODIFY `IC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `I_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `inventory_tracker`
--
ALTER TABLE `inventory_tracker`
  MODIFY `IT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `inventory_type`
--
ALTER TABLE `inventory_type`
  MODIFY `IT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `L_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `M_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `N_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `notification_dismissals`
--
ALTER TABLE `notification_dismissals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `R_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `T_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `TC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket_comments`
--
ALTER TABLE `ticket_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ticket_subcategories`
--
ALTER TABLE `ticket_subcategories`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `U_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `act_logs`
--
ALTER TABLE `act_logs`
  ADD CONSTRAINT `act_logs_ibfk_1` FOREIGN KEY (`U_ID`) REFERENCES `users` (`U_ID`);

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_ibfk_1` FOREIGN KEY (`U_ID`) REFERENCES `users` (`U_ID`);

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `departments` (`D_ID`);

--
-- Constraints for table `notification_dismissals`
--
ALTER TABLE `notification_dismissals`
  ADD CONSTRAINT `fk_notif_id` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`N_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_dismissals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`U_ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`Dept_ID`) REFERENCES `departments` (`D_ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`R_ID`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
