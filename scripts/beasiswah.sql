-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: beasiswah
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `additionalfiles`
--

DROP TABLE IF EXISTS `additionalfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `additionalfiles` (
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`,`file_id`),
  CONSTRAINT `additionalfiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additionalfiles`
--

LOCK TABLES `additionalfiles` WRITE;
/*!40000 ALTER TABLE `additionalfiles` DISABLE KEYS */;
INSERT INTO `additionalfiles` VALUES (4,1,'mp4','1696308347_2023-10-02 17-42-47.mp4');
/*!40000 ALTER TABLE `additionalfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrator` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator`
--

LOCK TABLES `administrator` WRITE;
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;
INSERT INTO `administrator` VALUES (1,'Metaverse Lab'),(6,'Institut Teknologi Bandung');
/*!40000 ALTER TABLE `administrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookmark`
--

DROP TABLE IF EXISTS `bookmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookmark` (
  `user_id_student` int(11) NOT NULL,
  `user_id_scholarship` int(11) NOT NULL,
  `scholarship_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`user_id_student`,`user_id_scholarship`,`scholarship_id`),
  KEY `user_id_scholarship` (`user_id_scholarship`,`scholarship_id`),
  CONSTRAINT `bookmark_ibfk_1` FOREIGN KEY (`user_id_student`) REFERENCES `student` (`user_id`),
  CONSTRAINT `bookmark_ibfk_2` FOREIGN KEY (`user_id_scholarship`, `scholarship_id`) REFERENCES `scholarship` (`user_id`, `scholarship_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookmark`
--

LOCK TABLES `bookmark` WRITE;
/*!40000 ALTER TABLE `bookmark` DISABLE KEYS */;
INSERT INTO `bookmark` VALUES (4,1,1,1);
/*!40000 ALTER TABLE `bookmark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review` (
  `user_id_reviewer` int(11) NOT NULL,
  `user_id_student` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `review_status` enum('waiting','reviewed') DEFAULT NULL,
  `comment` longtext DEFAULT NULL,
  PRIMARY KEY (`user_id_reviewer`,`user_id_student`,`file_id`),
  KEY `user_id_student` (`user_id_student`,`file_id`),
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id_reviewer`) REFERENCES `reviewer` (`user_id`),
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id_student`, `file_id`) REFERENCES `additionalfiles` (`user_id`, `file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (7,4,1,'reviewed','LGTM');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviewer`
--

DROP TABLE IF EXISTS `reviewer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviewer` (
  `user_id` int(11) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `reviewer_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviewer`
--

LOCK TABLES `reviewer` WRITE;
/*!40000 ALTER TABLE `reviewer` DISABLE KEYS */;
INSERT INTO `reviewer` VALUES (7,'',0);
/*!40000 ALTER TABLE `reviewer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scholarship`
--

DROP TABLE IF EXISTS `scholarship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scholarship` (
  `user_id` int(11) NOT NULL,
  `scholarship_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` longtext DEFAULT NULL,
  `coverage` int(11) NOT NULL,
  `contact_name` varchar(50) NOT NULL,
  `contact_email` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`,`scholarship_id`),
  CONSTRAINT `scholarship_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `administrator` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scholarship`
--

LOCK TABLES `scholarship` WRITE;
/*!40000 ALTER TABLE `scholarship` DISABLE KEYS */;
INSERT INTO `scholarship` VALUES (1,1,'Apalah','Uff',123123,'Ma','a@a.com'),(6,1,'ABC','123',123123123,'asdasda','hentot@uff.com'),(6,2,'Kiw Ares','Ahmad Nadil berjiwa Ksatria',90,'Ahmad Bedil','bedil@ares.sparta');
/*!40000 ALTER TABLE `scholarship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scholarshiptype`
--

DROP TABLE IF EXISTS `scholarshiptype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scholarshiptype` (
  `user_id` int(11) NOT NULL,
  `scholarship_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`,`scholarship_id`,`type`),
  CONSTRAINT `scholarshiptype_ibfk_1` FOREIGN KEY (`user_id`, `scholarship_id`) REFERENCES `scholarship` (`user_id`, `scholarship_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scholarshiptype`
--

LOCK TABLES `scholarshiptype` WRITE;
/*!40000 ALTER TABLE `scholarshiptype` DISABLE KEYS */;
INSERT INTO `scholarshiptype` VALUES (1,1,'A'),(1,1,'B'),(1,1,'C'),(6,1,'Babi'),(6,1,'Makan'),(6,2,'banget'),(6,2,'Gay'),(6,2,'Nadil');
/*!40000 ALTER TABLE `scholarshiptype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `university` varchar(100) NOT NULL DEFAULT '',
  `major` varchar(100) NOT NULL DEFAULT '',
  `level` enum('Undergraduate','Postgraduate','Doctoral') DEFAULT 'Undergraduate',
  `street` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `zipcode` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (4,'Institut Teknologi Bandung','Teknik Informatika','Undergraduate','','',0);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `superadmin`
--

DROP TABLE IF EXISTS `superadmin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `superadmin` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `superadmin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `superadmin`
--

LOCK TABLES `superadmin` WRITE;
/*!40000 ALTER TABLE `superadmin` DISABLE KEYS */;
INSERT INTO `superadmin` VALUES (2);
/*!40000 ALTER TABLE `superadmin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin','super admin','reviewer') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'placeholder.jpg',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Admin Beasiswa','$2y$10$o8EcCzkJN1id5X.Yja/hS.dLPHP7JQyOP.uZ0JKb3Fs1khgaEaeWm','admin','admin1@beasiswah.com','placeholder.jpg'),(2,'Jenderal Daemon','$2y$10$o8EcCzkJN1id5X.Yja/hS.dLPHP7JQyOP.uZ0JKb3Fs1khgaEaeWm','super admin','jenderal@daemon.sparta','1695737259_Haje Noorjamani - Haje Noorjamani.webp'),(4,'Matthew Mahendra','$2y$10$fPah2..w/zpcdS5JzELWUu6Dr6io3JV2UjeE6bV4/kIqOWItXPWWW','student','13521007@std.stei.itb.ac.id','1695737167_Materi dan Metode_13521007_Anggota.JPG'),(6,'Wikan Danar Sunindyo','$2y$10$Df.QXQXXccZNmAuB79iSfuF5e4cLWum2gobRg8o913z1QOoIpstSG','admin','wikan@itb.ac.id','1695737132_download.jpg'),(7,'Agung Dewandaru','$2y$10$XDGM1o4N3e6czxC2tC0iHe01chzAC3bFcMi//3SWVSuP/SKLeADzi','reviewer','agung@itb.ac.id','1696257696_download.jpeg');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-03 16:02:04
