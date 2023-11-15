-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Nov 14, 2023 at 07:30 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scholee`
--

-- --------------------------------------------------------

--
-- Table structure for table `additionalfiles`
--

CREATE TABLE `additionalfiles` (
  `user_id` int NOT NULL,
  `file_id` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `user_id` int NOT NULL,
  `organization` varchar(50) NOT NULL,
  `referral_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `user_id_student` int NOT NULL,
  `user_id_scholarship` int NOT NULL,
  `scholarship_id` int NOT NULL,
  `priority` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `user_id_reviewer` int NOT NULL,
  `user_id_student` int NOT NULL,
  `file_id` int NOT NULL,
  `review_status` enum('waiting','reviewed') DEFAULT NULL,
  `comment` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

CREATE TABLE `reviewer` (
  `user_id` int NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviewer`
--

INSERT INTO `reviewer` (`user_id`, `occupation`, `score`) VALUES
(2, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `scholarship`
--

CREATE TABLE `scholarship` (
  `user_id` int NOT NULL,
  `scholarship_id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` longtext,
  `short_description` varchar(255) DEFAULT NULL,
  `coverage` int NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `contact_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scholarshiptype`
--

CREATE TABLE `scholarshiptype` (
  `user_id` int NOT NULL,
  `scholarship_id` int NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `user_id` int NOT NULL,
  `university_id` int NOT NULL,
  `major` varchar(100) NOT NULL DEFAULT '',
  `level` enum('Undergraduate','Postgraduate','Doctoral') DEFAULT 'Undergraduate',
  `street` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `zipcode` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--
-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`user_id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

CREATE TABLE `university` (
  `university_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','super admin','reviewer') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'placeholder.jpg',
  `reset_token` varchar(64) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `verify_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `password`, `role`, `email`, `image`, `reset_token`, `is_verified`, `verify_token`) VALUES
(1, 'Scholee Edu', '$2y$10$YRVfk1MlclX56ldn05it6e/DpG1ncnKaJybJoasL56NmICWuNwsFW', 'super admin', 'scholeedu@gmail.com', 'placeholder.jpg', NULL, 1, NULL),
(2, 'Reviewer', '$2y$10$Sit9M654QvqhZaoGKeqXYuzyqQMUCJKxD12AvPfFNbJE2ByqsNova', 'reviewer', 'reviewer@gmail.com', 'placeholder.jpg', NULL, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additionalfiles`
--
ALTER TABLE `additionalfiles`
  ADD PRIMARY KEY (`user_id`,`file_id`);

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`user_id_student`,`user_id_scholarship`,`scholarship_id`),
  ADD KEY `user_id_scholarship` (`user_id_scholarship`,`scholarship_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`user_id_reviewer`,`user_id_student`,`file_id`),
  ADD KEY `user_id_student` (`user_id_student`,`file_id`);

--
-- Indexes for table `reviewer`
--
ALTER TABLE `reviewer`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `scholarship`
--
ALTER TABLE `scholarship`
  ADD PRIMARY KEY (`user_id`,`scholarship_id`);

--
-- Indexes for table `scholarshiptype`
--
ALTER TABLE `scholarshiptype`
  ADD PRIMARY KEY (`user_id`,`scholarship_id`,`type`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `university_id` (`university_id`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `university`
--
ALTER TABLE `university`
  ADD PRIMARY KEY (`university_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `superadmin`
--
ALTER TABLE `superadmin`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `university`
--
ALTER TABLE `university`
  MODIFY `university_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additionalfiles`
--
ALTER TABLE `additionalfiles`
  ADD CONSTRAINT `additionalfiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`user_id_student`) REFERENCES `student` (`user_id`),
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`user_id_scholarship`,`scholarship_id`) REFERENCES `scholarship` (`user_id`, `scholarship_id`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id_reviewer`) REFERENCES `reviewer` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id_student`,`file_id`) REFERENCES `additionalfiles` (`user_id`, `file_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviewer`
--
ALTER TABLE `reviewer`
  ADD CONSTRAINT `reviewer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `scholarship`
--
ALTER TABLE `scholarship`
  ADD CONSTRAINT `scholarship_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `administrator` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `scholarshiptype`
--
ALTER TABLE `scholarshiptype`
  ADD CONSTRAINT `scholarshiptype_ibfk_1` FOREIGN KEY (`user_id`,`scholarship_id`) REFERENCES `scholarship` (`user_id`, `scholarship_id`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`university_id`) REFERENCES `university` (`university_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD CONSTRAINT `superadmin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
