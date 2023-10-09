-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: scholee
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator`
--

LOCK TABLES `administrator` WRITE;
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;
INSERT INTO `administrator` VALUES (3,''),(4,''),(5,'');
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
  CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id_reviewer`) REFERENCES `reviewer` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `review_ibfk_2` FOREIGN KEY (`user_id_student`, `file_id`) REFERENCES `additionalfiles` (`user_id`, `file_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
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
INSERT INTO `reviewer` VALUES (6,'',0);
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
  `short_description` varchar(255) DEFAULT NULL,
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
INSERT INTO `scholarship` VALUES (3,1,'Beasiswa Prestasi Akademik','Beasiswa ini diberikan kepada mahasiswa dengan prestasi akademik yang sangat baik.','Beasiswa prestasi akademik.',5000000,'John Doe','johndoe@example.com'),(3,2,'Beasiswa Kebutuhan Hidup','Beasiswa ini memberikan dukungan keuangan untuk biaya hidup sehari-hari.','Beasiswa ini memberikan dukungan keuangan untuk biaya hidup sehari-hari.',2000000,'Jane Smith','janesmith@example.com'),(3,3,'Beasiswa UKT','Beasiswa ini mengurangi biaya UKT (Uang Kuliah Tunggal) mahasiswa.','Beasiswa UKT.',3000000,'Michael Johnson','michaeljohnson@example.com'),(3,4,'Beasiswa Riset	','Beasiswa ini mendukung penelitian mahasiswa dalam bidang tertentu.	','Beasiswa untuk riset.	',10000000,'Sarah Brown','sarahbrown@example.com'),(3,5,'Beasiswa Kepemimpinan	','Beasiswa ini diberikan kepada mahasiswa yang memiliki bakat kepemimpinan.	','Beasiswa kepemimpinan.	',7500000,'David Wilson	','davidwilson@example.com'),(4,1,'Beasiswa Teknologi	','Beasiswa ini ditujukan untuk mahasiswa jurusan teknologi.	','Beasiswa untuk jurusan teknologi.	',4000000,'Laura Kim	','laurakim@example.com'),(4,2,'Beasiswa Teknologi	','Beasiswa ini ditujukan untuk mahasiswa jurusan teknologi.	','Beasiswa untuk jurusan teknologi.	',4000000,'Laura Kim	','laurakim@example.com'),(4,3,'Beasiswa Bahasa	','Beasiswa ini mendukung pengembangan kemampuan berbahasa.	','Beasiswa untuk pembelajaran bahasa.	',3500000,'Mark Smith	','marksmith@example.com'),(4,4,'Beasiswa Kesehatan	','Beasiswa ini diberikan kepada mahasiswa jurusan kesehatan.	','Beasiswa kesehatan.	',6000000,'Lisa Johnson	','lisajohnson@example.com'),(4,5,'Beasiswa Penelitian Medis	','Beasiswa ini mendukung penelitian medis yang inovatif.	','Beasiswa untuk penelitian medis.	',15000000,'Kevin Lee	','kevinlee@example.com'),(4,6,'Beasiswa Seni dan Budaya	','Beasiswa ini diberikan kepada mahasiswa yang memiliki bakat seni dan budaya.	','Beasiswa seni dan budaya.	',4500000,'Emma Davis	','emmadavis@example.com'),(5,1,'Beasiswa Olahraga	','Beasiswa ini mendukung prestasi olahraga mahasiswa.	','Beasiswa ini mendukung prestasi olahraga mahasiswa.	',5500000,'James Wilson	','jameswilson@example.com'),(5,2,'Beasiswa Olahraga	','Beasiswa ini mendukung prestasi olahraga mahasiswa.	','Beasiswa ini mendukung prestasi olahraga mahasiswa.	',5500000,'James Wilson	','jameswilson@example.com'),(5,3,'Beasiswa Pendidikan	','Beasiswa ini ditujukan untuk mahasiswa jurusan pendidikan.	','Beasiswa jurusan pendidikan.	',4000000,'Maria Rodriguez	','mariarodriguez@example.com'),(5,4,'Beasiswa Lingkungan	','Beasiswa ini mendukung proyek-proyek lingkungan yang berkelanjutan.	','Beasiswa lingkungan.	',8000000,'Robert Chen	','robertchen@example.com'),(5,5,'Beasiswa Ekonomi	','Beasiswa ini memberikan bantuan kepada mahasiswa yang menghadapi kesulitan ekonomi.	','Beasiswa ekonomi.	',2500000,'Mary Taylor	','marytaylor@example.com'),(5,6,'Beasiswa Pemrograman	','Beasiswa ini ditujukan untuk mahasiswa yang berminat dalam pemrograman komputer.	','Beasiswa pemrograman.	',4500000,'William Brown	','williambrown@example.com');
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
INSERT INTO `scholarshiptype` VALUES (3,1,'Prestasi'),(3,2,'Biaya Hidup'),(3,3,'UKT'),(3,4,'Riset'),(3,5,'Kepemimpinan'),(4,1,'Teknologi'),(4,2,'Teknologi'),(4,3,'Bahasa'),(4,4,'Kesehatan'),(4,5,'Medis'),(4,6,'Seni dan Budaya'),(5,1,'Olahraga'),(5,2,'Olahraga'),(5,3,'Pendidikan'),(5,4,'Lingkungan'),(5,5,'marytaylor@example.com'),(5,6,'Pemrograman');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `superadmin`
--

LOCK TABLES `superadmin` WRITE;
/*!40000 ALTER TABLE `superadmin` DISABLE KEYS */;
INSERT INTO `superadmin` VALUES (1);
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
  `reset_token` varchar(64) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `verify_token` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Scholee Edu','$2y$10$YRVfk1MlclX56ldn05it6e/DpG1ncnKaJybJoasL56NmICWuNwsFW','super admin','scholeedu@gmail.com','placeholder.jpg',NULL,1,NULL),(3,'Ahmad Nadil','$2y$10$z9qB.Ky8hYWbsOS613/qtObv9GsBnheQ3czWdKDH8.qmdjv/kutaW','admin','13521024@std.stei.itb.ac.id','placeholder.jpg',NULL,1,NULL),(4,'Matthew Mahendra','$2y$10$RjI9wvx5NYCAuHsPDgYUuutX3m68mM3brAyGsU1uGT7SrNqXIQwwu','admin','13521007@std.stei.itb.ac.id','placeholder.jpg',NULL,1,NULL),(5,'Henry Anand Septian R','$2y$10$EJ8x0uNsacE8qR9FOa269u2sYVcXg3abkMO/LWk0EnW9qssaDqFoG','admin','13521004@std.stei.itb.ac.id','placeholder.jpg',NULL,1,NULL),(6,'Reviewer','$2y$10$Sit9M654QvqhZaoGKeqXYuzyqQMUCJKxD12AvPfFNbJE2ByqsNova','reviewer','reviewer@gmail.com','placeholder.jpg',NULL,1,NULL);
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

-- Dump completed on 2023-10-08 14:27:08
