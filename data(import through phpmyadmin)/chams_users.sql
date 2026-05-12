-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2026 at 06:08 PM
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
-- Database: `chams_users`
--

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
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`U_ID`, `employee_ID`, `FN`, `LN`, `email`, `pass_hash`, `role_id`, `Dept_ID`, `status`, `created_at`, `updated_at`) VALUES
(1, 111, 'Nathan', 'Rola', 'nathanrola316@gmail.com', '$2y$10$cT2KdFQHLZXJTOKlB3KNcOZZeEUmBj.uujpHvvD36e/oQcuQqczhG', 1, 1, 'active', '2026-03-22 08:15:21', '2026-03-22 08:15:21'),
(2, 211, 'Mon', 'Flores', 'nathanrola316@gmail.com', '$2y$10$CMtg1AAJfrKMsvh5YnB9FuKXvMjcfh3fS1Nl7FpbzhTr6.bk595nq', 2, 1, 'active', '2026-03-22 09:40:08', '2026-03-22 09:40:08'),
(3, 311, 'Ychezda', 'Chevy', 'nathanrola316@gmail.com', '$2y$10$ncfRbZIXd6K/hSOk3dmyJeFW4Y7nPUGewslmDJP/JjCjZ9lXuGvTG', 3, 4, 'active', '2026-03-22 09:40:08', '2026-03-22 09:40:08'),
(4, 312, 'Elena', 'Rodriguez', '22@gmail.com', '$2y$10$F.Rw4gtJ5VbxsebKlr6YvusH.gEZ1l/iAi4B4Jx1iPAbDEvt4j0L6', 3, 2, 'active', '2026-03-31 14:03:11', '2026-03-31 14:03:11'),
(5, 212, 'James', 'Tapic', '222@gmail.cpm', '$2y$10$XCw8yqkg03lKdJKZ9nkWielJizhxF504qYBvdg4vijUOct4GVgK7e', 2, 1, 'active', '2026-04-03 12:54:42', '2026-04-03 12:54:42'),
(6, 213, 'Mark', 'Ocasla', 'chamsmisd@gmail.com', '$2y$10$zu9UHP8raNTr8W5vet.Due7rjHNuiZBfatkXdAiHwbmxpNMglqQH2', 2, 1, 'active', '2026-05-11 05:13:27', '2026-05-11 05:13:27'),
(7, 112, 'Joshua', 'Lim', 'chamsmisd@gmail.com', '$2y$10$9714HWQShO/1eIDcqJtoiupFShKrdg.sPBInjQw.V4Gv9ZVe564d2', 1, 1, 'active', '2026-05-11 05:13:27', '2026-05-11 05:13:27'),
(8, 214, 'Clarice', 'Villafuerte', 'chamsmisd@gmail.com', '214', 2, 1, 'active', '2026-05-11 10:44:43', '2026-05-11 10:44:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`D_ID`),
  ADD KEY `D_ID` (`D_ID`),
  ADD KEY `D_ID_2` (`D_ID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`R_ID`);

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
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `D_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `R_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `U_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

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
