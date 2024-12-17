-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 11:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventhive`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `host` int(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `long_description` longtext NOT NULL,
  `eligibility` longtext NOT NULL,
  `type` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `deadline_date` datetime NOT NULL,
  `coordinator` varchar(255) NOT NULL,
  `coordinator_number` varchar(255) NOT NULL,
  `coordinator_emailid` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `prize` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `host`, `short_description`, `long_description`, `eligibility`, `type`, `start_date`, `end_date`, `deadline_date`, `coordinator`, `coordinator_number`, `coordinator_emailid`, `location`, `prize`, `website`) VALUES
(1, 'Event Alpha', 1, 'This is a paper presentation event focused on AI innovations.', 'A detailed description of the event goes here.', 'Open to all students with an interest in AI.', 'Paper Presentation', '2024-01-01 10:00:00', '2024-01-02 17:00:00', '2024-12-14 23:59:59', 'John Doe', '1234567890', 'john.doe@example.com', 'Location A', 'Cash Prize', 'https://eventalpha.com'),
(2, 'Event new', 1, 'Short description of the event', 'Detailed description of the event', 'Eligibility details for the event', 'Event type', '2024-12-10 10:00:00', '2024-12-10 18:00:00', '2024-12-09 23:59:59', 'Coordinator Name', '1234567890', 'coordinator@example.com', 'Event location', 'Event prize details', 'http://eventwebsite.com'),
(4, 'lunara', 1, 'qwertyuiop', 'qwertghnxsrtyuiknss\r\nedrtfgvhbnm\r\nyftghvbn', 'aesrdftvgybhnjmkl', 'hackathon', '2024-12-28 20:09:00', '2024-12-29 20:09:00', '2024-12-23 20:09:00', 'asdfghj', '1234567890', 'xyz@gmail.com', 'atg', '123000', 'xyz.com');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `mobile_number` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `username`, `name`, `emailid`, `password`, `designation`, `city`, `mobile_number`) VALUES
(1, 'faculty1', 'faculty1', 'faculty@gmail.com', 'faculty1', 'ASP @ BIT', 'coimbatore', '9876543211');

-- --------------------------------------------------------

--
-- Table structure for table `participant`
--

CREATE TABLE `participant` (
  `id` int(255) NOT NULL,
  `participant_id` int(255) NOT NULL,
  `event_id` int(255) NOT NULL,
  `mark` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participant`
--

INSERT INTO `participant` (`id`, `participant_id`, `event_id`, `mark`) VALUES
(1, 1, 1, -1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rollnumber` varchar(255) NOT NULL,
  `emailid` varchar(255) NOT NULL,
  `mobile_number` varchar(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL,
  `year` int(255) NOT NULL,
  `dept` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `rollnumber`, `emailid`, `mobile_number`, `city`, `college`, `year`, `dept`) VALUES
(1, 'hari', 'hari', 'faculty1', '7376221CS169', 'faculty@gmail.com', '9876543211', 'coimbatore', 'BIT', 3, 'CSE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_event_host` (`host`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_participant_user` (`participant_id`),
  ADD KEY `fk_event_id` (`event_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `participant`
--
ALTER TABLE `participant`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_host` FOREIGN KEY (`host`) REFERENCES `faculty` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `fk_event_id` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_participant_user` FOREIGN KEY (`participant_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
