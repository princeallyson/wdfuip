-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 06:11 AM
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
-- Database: `wdfuip`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign_signatory`
--

CREATE TABLE `assign_signatory` (
  `assign_id` int(11) NOT NULL,
  `document_id` int(11) DEFAULT NULL,
  `signatory_id` int(11) DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assign_signatory`
--

INSERT INTO `assign_signatory` (`assign_id`, `document_id`, `signatory_id`, `assigned_at`) VALUES
(1426, 26, 5, '2024-04-19 03:44:54'),
(1427, 26, 222, '2024-04-19 03:44:54'),
(1428, 25, 5, '2024-04-19 03:45:13'),
(1429, 25, 2, '2024-04-19 03:45:13');

-- --------------------------------------------------------

--
-- Table structure for table `college_components`
--

CREATE TABLE `college_components` (
  `id` int(11) NOT NULL,
  `program` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `college_components`
--

INSERT INTO `college_components` (`id`, `program`, `designation`, `department`) VALUES
(60, 'MS Information Technology', '', ''),
(61, '', 'Faculty', ''),
(62, '', '', 'DIT');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `document` varchar(255) NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `owner_id` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `document`, `document_type`, `owner_id`, `uploaded_at`) VALUES
(25, 'TDW Form No. 05.  Confidentiality and Non-Disclosure Agreement.pdf', 'Thesis/Dissertation Confidentiality Non-Disclosure Agreement', '3', '2024-04-18 21:43:57'),
(26, 'TDW Form No. 01.  Concept Paper Adviser Endorsement Form.pdf', 'Thesis/Dissertation Concept Paper Adviser Endorsement Form', '3', '2024-04-18 21:44:11');

-- --------------------------------------------------------

--
-- Table structure for table `document_status`
--

CREATE TABLE `document_status` (
  `document_id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL,
  `signatory_id` int(11) NOT NULL,
  `approval_status` enum('Pending','Approved','Rejected') DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `conversation` varchar(255) DEFAULT NULL,
  `approval_time` datetime DEFAULT NULL,
  `expiration` timestamp NOT NULL DEFAULT current_timestamp(),
  `archive_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_status`
--

INSERT INTO `document_status` (`document_id`, `assign_id`, `signatory_id`, `approval_status`, `comments`, `remarks`, `conversation`, `approval_time`, `expiration`, `archive_status`) VALUES
(25, 1428, 5, 'Rejected', 'Reject- Prince ', 'Reject- Prince ', NULL, '2024-04-19 11:50:44', '2024-04-25 21:45:13', 0),
(25, 1429, 2, 'Rejected', 'Rejected- By Prince', 'Rejected- By Prince', NULL, '2024-04-19 11:48:09', '2024-04-25 21:45:14', 0),
(26, 1426, 5, 'Approved', 'Approve - By Prince', 'Approve - By Prince', NULL, '2024-04-19 11:50:13', '2024-04-25 21:44:54', 0),
(26, 1427, 222, 'Approved', 'Approve- Prince', 'Approve- Prince', NULL, '2024-04-19 11:51:33', '2024-04-25 21:44:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `form_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `form_name`) VALUES
(30, 'ITEC-110-MIDTERM.docx');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `recipient_id`, `document_id`, `assign_id`, `created_at`, `is_read`) VALUES
(1407, 5, 26, 1426, '2024-04-19 03:44:54', 0),
(1408, 222, 26, 1427, '2024-04-19 03:44:55', 0),
(1409, 5, 25, 1428, '2024-04-19 03:45:13', 0),
(1410, 2, 25, 1429, '2024-04-19 03:45:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `thesis_document`
--

CREATE TABLE `thesis_document` (
  `id` int(11) NOT NULL,
  `uploader_name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `upload_date` datetime NOT NULL,
  `comments` text DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thesis_document`
--

INSERT INTO `thesis_document` (`id`, `uploader_name`, `file_name`, `upload_date`, `comments`, `user_id`) VALUES
(41, 'Prince Allyson O. Macalino', 'Page-1-of-2-2-Copies (2).pdf', '2024-04-18 10:20:32', 'asd', 2),
(42, 'Kylie Tuleg', 'Easter.pdf', '2024-04-19 05:04:24', '456', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `contactNumber` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `user_level` varchar(255) NOT NULL,
  `signature` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `program`, `designation`, `department`, `contactNumber`, `email`, `password`, `picture`, `user_level`, `signature`) VALUES
(1, 'Admin', '', '', '', '9178143913', 'renzcadaoas@gmail.com', '123', '', 'Admin', NULL),
(2, 'Prince Allyson O. Macalino', '', 'Faculty', 'DIT', '905 146 2480', 'allysonmacalino@gmail.com', '123', 'imresizer-1695091995565.jpg', 'Faculty', 'Macalino_Esignature.png'),
(3, 'Kylie Tuleg', 'MS Information Technology', '', 'DIT', '9456375501', 'allysonmacalino@gmail.com', '123123123', 'Screenshot 2021-12-13 121430.png', 'Student', NULL),
(4, 'Kylie Cuadra', 'MS Information Technology', '', 'DIT', '9456375501', 'allysonmacalino@gmail.com', '123123123', '423147603_400845872532893_6169783852817312014_n.jpg', 'Student', NULL),
(5, 'Allyson O. Macalino', '', 'Faculty', 'DIT', '905 146 2480', 'allysonmacalino@gmail.com', '123', 'DSC00438.JPG', 'Faculty', 'Macalino_Esignature.png'),
(222, 'Jericho V. Banaga', '', 'Faculty', 'DIT', '905 146 2480', 'forevergrateful107@gmail.com', '123', '431959458_432831295755287_1178444856197736355_n.jpg', 'Faculty', 'Macalino_Esignature.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_signatory`
--
ALTER TABLE `assign_signatory`
  ADD PRIMARY KEY (`assign_id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `signatory_id` (`signatory_id`);

--
-- Indexes for table `college_components`
--
ALTER TABLE `college_components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `document_status`
--
ALTER TABLE `document_status`
  ADD PRIMARY KEY (`document_id`,`assign_id`,`signatory_id`),
  ADD KEY `assign_id` (`assign_id`),
  ADD KEY `signatory_id` (`signatory_id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `recipient_id` (`recipient_id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `assign_id` (`assign_id`);

--
-- Indexes for table `thesis_document`
--
ALTER TABLE `thesis_document`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UC_thesis_document` (`file_name`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_signatory`
--
ALTER TABLE `assign_signatory`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1430;

--
-- AUTO_INCREMENT for table `college_components`
--
ALTER TABLE `college_components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1411;

--
-- AUTO_INCREMENT for table `thesis_document`
--
ALTER TABLE `thesis_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assign_signatory`
--
ALTER TABLE `assign_signatory`
  ADD CONSTRAINT `assign_signatory_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`),
  ADD CONSTRAINT `assign_signatory_ibfk_2` FOREIGN KEY (`signatory_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `documents` (`document_id`),
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`assign_id`) REFERENCES `assign_signatory` (`assign_id`);

--
-- Constraints for table `thesis_document`
--
ALTER TABLE `thesis_document`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
