-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2025 at 02:32 PM
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
(13, 'Admin User', '', 'Set request #13 as Accepted', '2025-11-09 18:47:51'),
(14, 'Admin User', '', 'Assigned volunteer #3 to request #13', '2025-11-09 18:47:55');

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
(7, 12, 'Rice', 10, 'Requested', '2025-11-10 18:40:00'),
(8, 12, 'Chicken', 15, 'Available', '2025-11-10 18:41:00');

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
  `RequestedQty` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_request`
--

INSERT INTO `food_request` (`RequestID`, `DonationID`, `ReceiverID`, `Status`, `Timestamp`, `RequestedQty`) VALUES
(13, 7, 13, 'Assigned', '2025-11-09 18:42:58', 2);

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
(14, 'Aidan Amaral', 'aidan.volunteer@foodshare.com', '$2y$10$dKt6rTg/4CBveBgoeyY0QOpuL1wuIxj9lLkjdeCODwyN/Fqfspexm', 'panjim', 'Volunteer', '2222222222');

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
(3, 'Aidan', 'aidan.volunteer@foodshare.com', 'panjim', 13, 'In Progress'),
(4, 'Shane', 'shane.volunteer@foodshare.com', 'panjim', 0, 'Pending');

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
  ADD KEY `ReceiverID` (`ReceiverID`);

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
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `food_donation`
--
ALTER TABLE `food_donation`
  MODIFY `DonationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `food_request`
--
ALTER TABLE `food_request`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `VolunteerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `food_request_ibfk_1` FOREIGN KEY (`DonationID`) REFERENCES `food_donation` (`DonationID`),
  ADD CONSTRAINT `food_request_ibfk_2` FOREIGN KEY (`ReceiverID`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
