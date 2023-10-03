-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Sep 26, 2023 at 04:47 PM
-- Server version: 8.1.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_docker`
--

-- --------------------------------------------------------

--
-- Table structure for table `additionalFiles`
--

CREATE TABLE `additionalFiles` (
  `user_id` int NOT NULL,
  `file_id` int NOT NULL,
  `type` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `user_id` int NOT NULL,
  `organization` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`user_id`, `organization`) VALUES
(1, 'Metaverse Lab'),
(3, '');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `user_id_student` int NOT NULL,
  `user_id_scholarship` int NOT NULL,
  `scholarship_id` int NOT NULL,
  `priority` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

CREATE TABLE `reviewer` (
  `user_id` int NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scholarship`
--

CREATE TABLE `scholarship` (
  `user_id` int NOT NULL,
  `scholarship_id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` longtext,
  `coverage` int NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `contact_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `scholarship`
--

INSERT INTO `scholarship` (`user_id`, `scholarship_id`, `title`, `description`, `coverage`, `contact_name`, `contact_email`) VALUES
(1, 1, 'Beasiswa Aku', 'Ini beasiswanya punya aku', 100, 'Aku', 'aku@aku.com'),
(3, 1, 'Bewesiswa', 'asd', 1, 'aku', 'bewe@gmail.com'),
(3, 2, 'Bewesis', 'agg', 123, 'aku', 'bewe@gmail.com'),
(3, 3, 'hehe', 'agg', 123, 'aku', 'bewe@gmail.com'),
(3, 4, 'memek', 'agg', 123, 'aku', 'bewe@gmail.com'),
(3, 5, 'kontol', 'agg', 123, 'aku', 'bewe@gmail.com'),
(3, 6, 'jembiii', 'agg', 123, 'aku', 'bewe@gmail.com'),
(3, 7, 'jembu', 'agg', 123, 'aku', 'bewe@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `scholarshipType`
--

CREATE TABLE `scholarshipType` (
  `user_id` int NOT NULL,
  `scholarship_id` int NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `scholarshipType`
--

INSERT INTO `scholarshipType` (`user_id`, `scholarship_id`, `type`) VALUES
(1, 1, 'UKT'),
(3, 1, 'asd'),
(3, 2, 'asd'),
(3, 3, 'asd'),
(3, 4, 'asd'),
(3, 5, 'asd'),
(3, 6, 'asd'),
(3, 7, 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `user_id` int NOT NULL,
  `university` varchar(100) NOT NULL DEFAULT '',
  `major` varchar(100) NOT NULL DEFAULT '',
  `level` enum('Undergraduate','Postgraduate','Doctoral') DEFAULT 'Undergraduate',
  `street` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `zipcode` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`user_id`, `university`, `major`, `level`, `street`, `city`, `zipcode`) VALUES
(4, '', '', 'Undergraduate', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `superAdmin`
--

CREATE TABLE `superAdmin` (
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','super admin','reviewer') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'placeholder.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `password`, `role`, `email`, `image`) VALUES
(1, 'Admin Beasiswa', '$2y$10$o8EcCzkJN1id5X.Yja/hS.dLPHP7JQyOP.uZ0JKb3Fs1khgaEaeWm', 'admin', 'admin1@beasiswah.com', 'placeholder.jpg'),
(2, 'Jenderal Daemon', '$2y$10$o8EcCzkJN1id5X.Yja/hS.dLPHP7JQyOP.uZ0JKb3Fs1khgaEaeWm', 'super admin', 'jenderal@daemon.sparta', 'placeholder.jpg'),
(3, 'Bewe', '$2y$10$eL3MAd7yPhcsstdNF0Oxye9T/4kQ3htADqbpvCv7va01rXopl3Av.', 'admin', 'Bewe@ewe.com', 'placeholder.jpg'),
(4, 'Ahmad Nadil', '$2y$10$4L07/a1KyZfrYNxcLiBhp.XosPUDUOgW0bcoEfr11Y8sHngK4356G', 'student', 'nadil@lmao.com', 'placeholder.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additionalFiles`
--
ALTER TABLE `additionalFiles`
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
-- Indexes for table `scholarshipType`
--
ALTER TABLE `scholarshipType`
  ADD PRIMARY KEY (`user_id`,`scholarship_id`,`type`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `superAdmin`
--
ALTER TABLE `superAdmin`
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `superAdmin`
--
ALTER TABLE `superAdmin`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additionalFiles`
--
ALTER TABLE `additionalFiles`
  ADD CONSTRAINT `additionalFiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`user_id_scholarship`,`scholarship_id`) REFERENCES `scholarship` (`user_id`, `scholarship_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id_reviewer`) REFERENCES `reviewer` (`user_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id_student`,`file_id`) REFERENCES `additionalFiles` (`user_id`, `file_id`);

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
-- Constraints for table `scholarshipType`
--
ALTER TABLE `scholarshipType`
  ADD CONSTRAINT `scholarshipType_ibfk_1` FOREIGN KEY (`user_id`,`scholarship_id`) REFERENCES `scholarship` (`user_id`, `scholarship_id`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `superAdmin`
--
ALTER TABLE `superAdmin`
  ADD CONSTRAINT `superAdmin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
