-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 03:39 PM
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
-- Database: `community_food_sharing_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `LogID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Activity` text DEFAULT NULL,
  `Timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`LogID`, `Name`, `Email`, `Activity`, `Timestamp`) VALUES
(31, 'Admin User', '', 'Set request #18 status to \'Accepted\'', '2025-11-14 21:38:50'),
(32, 'Admin User', '', 'Assigned volunteer #16 to request #18', '2025-11-14 21:39:00'),
(33, 'Admin User', '', 'Set request #19 status to \'Accepted\'', '2025-11-14 21:51:10'),
(34, 'Admin User', '', 'Set request #20 status to \'Accepted\'', '2025-11-14 21:51:11'),
(35, 'Admin User', '', 'Assigned volunteer #15 to request #19', '2025-11-14 21:51:23'),
(36, 'Admin User', '', 'Assigned volunteer #16 to request #20', '2025-11-14 21:51:27'),
(37, 'Admin User', '', 'Set request #21 status to \'Accepted\'', '2025-11-16 12:23:54'),
(38, 'Admin User', '', 'Assigned volunteer #16 to request #21', '2025-11-16 12:24:02'),
(39, 'Admin User', '', 'Set request #22 status to \'Accepted\'', '2025-11-16 12:29:24'),
(40, 'Admin User', '', 'Assigned volunteer #15 to request #22', '2025-11-16 12:30:01'),
(41, 'Admin User', '', 'Set request #23 status to \'Accepted\'', '2025-11-16 12:32:18'),
(42, 'Admin User', '', 'Assigned volunteer #16 to request #23', '2025-11-16 12:32:22'),
(43, 'Admin User', '', 'Set request #24 status to \'Accepted\'', '2025-11-16 13:02:51'),
(44, 'Admin User', '', 'Assigned volunteer #15 to request #24', '2025-11-16 13:02:55'),
(45, 'Admin User', '', 'Set request #25 status to \'Accepted\'', '2025-11-16 16:24:32'),
(46, 'Admin User', '', 'Assigned volunteer #15 to request #25', '2025-11-16 16:24:41'),
(47, 'Aidan', '', 'Marked pickup for request #25 as Picked Up.', '2025-11-16 16:25:34'),
(48, 'Aidan', '', 'Marked delivery for request #25 as Delivered.', '2025-11-16 16:26:13'),
(49, 'Admin User', '', 'Set request #26 status to \'Accepted\'', '2025-11-16 17:09:23'),
(50, 'Admin User', '', 'Set request #27 status to \'Declined\'', '2025-11-16 17:09:25'),
(51, 'Admin User', '', 'Assigned volunteer #16 to request #26', '2025-11-16 17:09:31'),
(52, 'Admin User', '', 'Set request #28 status to \'Accepted\'', '2025-11-16 18:58:32'),
(53, 'Admin User', '', 'Assigned volunteer #16 to request #28', '2025-11-16 18:59:07'),
(54, 'shane ', '', 'Marked pickup for request #26 as Picked Up.', '2025-11-16 18:59:54'),
(55, 'Admin User', '', 'Set request #29 status to \'Accepted\'', '2025-11-16 19:21:17'),
(56, 'Admin User', '', 'Assigned volunteer #15 to request #29', '2025-11-16 19:21:24'),
(57, 'Admin User', '', 'Set request #30 status to \'Accepted\'', '2025-11-16 19:22:17'),
(58, 'Admin User', '', 'Assigned volunteer #15 to request #30', '2025-11-16 19:22:21'),
(59, 'Aidan', '', 'Marked pickup for request #30 as Picked Up.', '2025-11-16 19:22:47'),
(60, 'Aidan', '', 'Marked delivery for request #30 as Delivered.', '2025-11-16 19:22:49'),
(61, 'Aidan', '', 'Marked pickup for request #29 as Picked Up.', '2025-11-16 19:23:38'),
(62, 'Aidan', '', 'Marked delivery for request #29 as Delivered.', '2025-11-16 19:23:38'),
(63, 'shane ', '', 'Marked delivery for request #26 as Delivered.', '2025-11-16 19:23:46'),
(64, 'shane ', '', 'Marked pickup for request #28 as Picked Up.', '2025-11-16 19:23:48'),
(65, 'shane ', '', 'Marked delivery for request #28 as Delivered.', '2025-11-16 19:23:48'),
(66, 'Admin User', '', 'Set request #31 status to \'Accepted\'', '2025-11-16 19:26:29'),
(67, 'Admin User', '', 'Assigned volunteer #15 to request #31', '2025-11-16 19:26:34'),
(68, 'Aidan', '', 'Marked pickup for request #31 as Picked Up.', '2025-11-16 19:26:59'),
(69, 'Aidan', '', 'Marked delivery for request #31 as Delivered.', '2025-11-16 19:27:00'),
(70, 'Admin User', '', 'Set request #32 status to \'Accepted\'', '2025-11-16 19:39:55'),
(71, 'Admin User', '', 'Assigned volunteer #16 to request #32', '2025-11-16 19:40:07'),
(72, 'shane ', '', 'Marked pickup for request #32 as Picked Up.', '2025-11-16 19:57:45'),
(73, 'shane ', '', 'Marked delivery for request #32 as Delivered.', '2025-11-16 19:58:05'),
(74, 'Admin User', '', 'Set request #33 status to \'Accepted\'', '2025-11-16 19:59:52'),
(75, 'Admin User', '', 'Assigned volunteer #15 to request #33', '2025-11-16 19:59:59');

-- --------------------------------------------------------

--
-- Table structure for table `food_donation`
--

CREATE TABLE `food_donation` (
  `DonationID` int(11) NOT NULL,
  `DonorID` int(11) DEFAULT NULL,
  `Item` varchar(100) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Available',
  `ExpiryTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_donation`
--

INSERT INTO `food_donation` (`DonationID`, `DonorID`, `Item`, `Quantity`, `Status`, `ExpiryTime`) VALUES
(12, 12, 'cake', 4, 'Requested', '2025-11-14 21:37:00'),
(13, 12, 'chocolate', 3, 'Requested', '2025-11-14 21:46:00'),
(14, 12, 'chicken', 5, 'Requested', '2025-11-15 21:49:00'),
(16, 12, 'banana', 1, 'Unavailable', '2025-11-18 12:21:00'),
(18, 12, 'chicken', 0, 'Unavailable', '2025-11-17 16:24:00'),
(19, 12, 'Rice', 0, 'Unavailable', '2025-11-17 17:15:00'),
(20, 12, 'Rice', 0, 'Unavailable', '2025-11-17 19:21:00'),
(21, 12, 'chocolate', 3, 'Available', '2025-11-17 19:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `food_request`
--

CREATE TABLE `food_request` (
  `RequestID` int(11) NOT NULL,
  `DonationID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Pending',
  `Timestamp` datetime DEFAULT current_timestamp(),
  `RequestedQty` int(11) DEFAULT 1,
  `VolunteerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_request`
--

INSERT INTO `food_request` (`RequestID`, `DonationID`, `ReceiverID`, `Status`, `Timestamp`, `RequestedQty`, `VolunteerID`) VALUES
(18, 12, 13, 'Delivered', '2025-11-14 21:38:32', 2, NULL),
(19, 13, 13, 'Delivered', '2025-11-14 21:47:07', 3, NULL),
(20, 14, 13, 'Delivered', '2025-11-14 21:49:48', 3, NULL),
(21, 16, 13, 'Delivered', '2025-11-16 12:22:31', 5, NULL),
(22, 16, 13, 'Delivered', '2025-11-16 12:29:11', 5, NULL),
(23, 16, 13, 'Delivered', '2025-11-16 12:31:56', 4, NULL),
(24, 16, 13, 'Delivered', '2025-11-16 12:44:38', 3, NULL),
(25, 16, 13, 'Delivered', '2025-11-16 16:23:28', 5, 15),
(26, 18, 13, 'Delivered', '2025-11-16 17:01:21', 4, 16),
(27, 18, 13, 'Declined', '2025-11-16 17:01:24', 1, NULL),
(28, 19, 13, 'Delivered', '2025-11-16 17:15:13', 3, 16),
(29, 19, 13, 'Delivered', '2025-11-16 19:21:04', 2, 15),
(30, 20, 13, 'Delivered', '2025-11-16 19:22:03', 3, 15),
(31, 20, 13, 'Delivered', '2025-11-16 19:26:15', 1, 15),
(32, 20, 13, 'Delivered', '2025-11-16 19:39:41', 1, 16),
(33, 21, 13, 'Assigned', '2025-11-16 19:59:29', 2, 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `Contact` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Name`, `Email`, `Password`, `Location`, `Role`, `Contact`) VALUES
(11, 'Admin User', 'admin@foodshare.com', '$2y$10$GJGfDqZosArSZg5AXhVcD.3J8R2Rd/ZA0/D4GCaustLhuw0ndirbC', 'panjim', 'Admin', '999999999'),
(12, 'John Donor', 'john.donor@foodshare.com', '$2y$10$DdiY5UqSRNiS6nUIDmr..Os0YxilBjmzg9pXd6fQJ1TOtDmHKTiuW', 'panjim', 'Donor', '1234567890'),
(13, 'Ashwin Monteiro', 'ashwin.receiver@foodshare.com', '$2y$10$vRiM9DizHdjd6qYKf9sRjOGYtxQ1pPQ20TRG9QJL.B.74uIyWWoBW', 'panjim', 'Receiver', '9923567810'),
(15, 'Aidan', 'aidan.volunteer@foodshare.com', '$2y$10$kCL4Qz0tJQcUDZSgKuv/Au7kHFm4UaobAU5rXdGRUr3K219dyB6K6', 'panjim', 'Volunteer', '9923567810'),
(16, 'shane ', 'shane.volunteer@foodshare.com', '$2y$10$pLbHbymIftHFog5tT4.B0.LKKsDklaQGpP2jxUMLCQhEEeMfyrHxO', 'panjim', 'Volunteer', '2222222222');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `VolunteerID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `LOC` varchar(100) DEFAULT NULL,
  `AssignedRequests` int(11) DEFAULT NULL,
  `PickupStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`VolunteerID`, `Name`, `Email`, `LOC`, `AssignedRequests`, `PickupStatus`) VALUES
(15, 'Aidan', 'aidan.volunteer@foodshare.com', 'panjim', NULL, 'In Progress'),
(16, 'shane ', 'shane.volunteer@foodshare.com', 'panjim', NULL, 'Available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`LogID`);

--
-- Indexes for table `food_donation`
--
ALTER TABLE `food_donation`
  ADD PRIMARY KEY (`DonationID`),
  ADD KEY `DonorID` (`DonorID`);

--
-- Indexes for table `food_request`
--
ALTER TABLE `food_request`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `DonationID` (`DonationID`),
  ADD KEY `ReceiverID` (`ReceiverID`),
  ADD KEY `fk_vol` (`VolunteerID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`VolunteerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `food_donation`
--
ALTER TABLE `food_donation`
  MODIFY `DonationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `food_request`
--
ALTER TABLE `food_request`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `VolunteerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food_donation`
--
ALTER TABLE `food_donation`
  ADD CONSTRAINT `food_donation_ibfk_1` FOREIGN KEY (`DonorID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `food_request`
--
ALTER TABLE `food_request`
  ADD CONSTRAINT `fk_vol` FOREIGN KEY (`VolunteerID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `food_request_ibfk_1` FOREIGN KEY (`DonationID`) REFERENCES `food_donation` (`DonationID`),
  ADD CONSTRAINT `food_request_ibfk_2` FOREIGN KEY (`ReceiverID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
