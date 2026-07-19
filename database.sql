-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: mol_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('super_admin','admin','editor') NOT NULL DEFAULT 'admin',
  `access_level` varchar(50) NOT NULL DEFAULT 'view_only',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'superadmin','admin@gmail.com','$2y$10$ywnQbcv9xGJ7kNLRMXWcNuAw76F4rmNzH982ccivZ1ZTt5mgxKjxG','super_admin','full_access','2026-06-07 06:46:32','2026-06-07 06:46:32'),(2,'Test Admin','auth@gmail.com','$2y$10$7CacUf1rwQXcn/PQP9dXVegiJwb0v6zIPk3qdEnKyzKh17ujKx8M.','admin','view_only','2026-06-07 13:16:47','2026-06-07 13:16:47');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bungalow_name` varchar(100) NOT NULL,
  `applicant_name` varchar(150) NOT NULL,
  `designation` varchar(150) DEFAULT NULL,
  `is_retired` varchar(10) DEFAULT NULL,
  `workplace_address` text DEFAULT NULL,
  `private_workplace_info` text DEFAULT NULL,
  `nic` varchar(50) DEFAULT NULL,
  `passport_number` varchar(50) DEFAULT NULL,
  `residential_address` text DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `phone_office` varchar(50) DEFAULT NULL,
  `phone_home` varchar(50) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `applicant_category` varchar(100) DEFAULT NULL,
  `applicant_type` varchar(50) DEFAULT NULL,
  `room_type` varchar(100) NOT NULL,
  `no_of_rooms` int(11) NOT NULL DEFAULT 1,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `arrival_time` varchar(50) DEFAULT NULL,
  `departure_time` varchar(50) DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending',
  `recommendation_file` varchar(255) DEFAULT NULL,
  `entire_bungalow` varchar(10) DEFAULT 'No',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `booking_guests`
--

DROP TABLE IF EXISTS `booking_guests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_guests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `relationship` varchar(100) NOT NULL,
  `nic` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`),
  CONSTRAINT `booking_guests_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,'Ampara','Test','07000000','gallagevishwa@gmail.com','VIP Room',1,'2026-06-15','2026-06-22','Confirmed','2026-06-11 09:12:33'),(2,'Ampara','Test','07000000','gallagevishwa@gmail.com','A/C Triple Room',1,'2026-06-22','2026-06-29','Pending','2026-06-22 04:11:30');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `divisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `divisions`
--

LOCK TABLES `divisions` WRITE;
/*!40000 ALTER TABLE `divisions` DISABLE KEYS */;
INSERT INTO `divisions` VALUES (1,'administration','Administration',1),(2,'development','Policy Formulation & Foreign Relations',2),(3,'planning','Planning',3),(4,'finance','Finance',4),(5,'internal-audit','Internal Audit',5),(6,'foreign-relations','Foreign Relations',6),(7,'rti-officers','RTI Officers',7);
/*!40000 ALTER TABLE `divisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iau_updates`
--

DROP TABLE IF EXISTS `iau_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iau_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iau_updates`
--

LOCK TABLES `iau_updates` WRITE;
/*!40000 ALTER TABLE `iau_updates` DISABLE KEYS */;
INSERT INTO `iau_updates` VALUES (1,'test','<p>test</p>','Published','2026-07-10 08:05:56','2026-07-10 08:05:56');
/*!40000 ALTER TABLE `iau_updates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `learning_platforms_foreign`
--

DROP TABLE IF EXISTS `learning_platforms_foreign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `learning_platforms_foreign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `pdf_path` varchar(255) NOT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `learning_platforms_foreign`
--

LOCK TABLES `learning_platforms_foreign` WRITE;
/*!40000 ALTER TABLE `learning_platforms_foreign` DISABLE KEYS */;
INSERT INTO `learning_platforms_foreign` VALUES (1,'ILO International Labour Standards Guide','Global standards guidelines from the International Labour Organization.','uploads/learning_platforms/foreign_1.pdf','Published','2026-06-30 04:25:00','2026-06-30 04:25:00'),(2,'Global Employment Trends Report 2026','International employment and economic trends report.','uploads/learning_platforms/foreign_2.pdf','Published','2026-06-30 04:27:00','2026-06-30 04:27:00');
/*!40000 ALTER TABLE `learning_platforms_foreign` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `learning_platforms_local`
--

DROP TABLE IF EXISTS `learning_platforms_local`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `learning_platforms_local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `pdf_path` varchar(255) NOT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `learning_platforms_local`
--

LOCK TABLES `learning_platforms_local` WRITE;
/*!40000 ALTER TABLE `learning_platforms_local` DISABLE KEYS */;
INSERT INTO `learning_platforms_local` VALUES (1,'National Vocational Training Guide','Official vocational training guidelines and syllabus.','uploads/learning_platforms/local_1.pdf','Published','2026-06-30 04:20:00','2026-06-30 04:20:00'),(2,'Labour Laws and Regulations Handbook','Comprehensive guide to local labour laws and employee rights.','uploads/learning_platforms/local_2.pdf','Published','2026-06-30 04:22:00','2026-06-30 04:22:00');
/*!40000 ALTER TABLE `learning_platforms_local` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title_si` varchar(255) DEFAULT NULL,
  `title_ta` varchar(255) DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `publish_date` date DEFAULT NULL,
  `content` longtext NOT NULL,
  `content_si` longtext DEFAULT NULL,
  `content_ta` longtext DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `visibility` enum('public','private','hidden') NOT NULL DEFAULT 'public',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_special_notice` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `author_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,'38 New Labour Officers Receive Appointment Letters','╬▒ΓòóΓûÆ╬▒Γòû├ç ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓò£╬▒ΓòóΓûæ╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓûÆ╬▒Γòû├¿ 38 ╬▒Γòó┬╗╬▒Γòû├û╬▒ΓòóΓûÆ╬▒Γòû├û╬▒Γòó├£╬▒Γòû├╢╬▒Γòó┬║ ╬▒ΓòóΓöñ╬▒Γòó┬í╬▒Γòû├¿╬▒Γòû├ç╬▒Γòû├┤╬▒ΓòóΓòò╬▒Γòû├¿ ╬▒ΓòóΓò£╬▒Γòû├å╬▒ΓòóΓöñ╬▒Γòû├å ╬▒ΓòóΓò£╬▒Γòû├ë╬▒ΓòóΓòó╬▒Γòû├£','38 ╬▒┬½┬¼╬▒┬╗├╝╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½┬╗ ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├á╬▒┬½Γûô╬▒┬╗├╝╬▒┬½Γòí╬▒┬½Γûô╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├¼ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½┬½╬▒┬½ΓîÉ╬▒┬½├▓╬▒┬╗├¼ ╬▒┬½├▓╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├¬╬▒┬½┬¼╬▒┬╗├¼ ╬▒┬½┬¼╬▒┬╗├Ñ╬▒┬½ΓûÆ╬▒┬╗├╝╬▒┬½├▓╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬½ΓîÉ╬▒┬½Γûæ╬▒┬╗├¼','Media',NULL,'Appointment letters were presented to 38 newly recruited Labour Officers at a ceremony held on the morning of 16 February at the Labour Ministry Auditorium, Mehewara Piyasa Building, Narahenpita.\r\n\r\nThe event was held under the patronage of the Minister of Labour, Dr. Anil Jayantha Fernando, and the Deputy Minister of Labour, Mr. Mahinda Jayasinghe.\r\n\r\nThe newly appointed officers will undergo a comprehensive training programme comprising three months of institutional training followed by one month of field duty training at the National Institute of Labour Studies, functioning under the Ministry of Labour. The programme is designed to equip them with the necessary knowledge and practical exposure to effectively carry out their responsibilities in the field of labour administration and regulation.\r\n\r\nThe Secretary to the Ministry of Labour, Mr. S.M. Piyatissa, and the Commissioner General of Labour, Mrs. Nadeeka Wataliyadda, were also present at the ceremony, along with several senior officials of the Ministry.\r\n\r\nThe appointment of these officers marks a significant step towards further strengthening the labour administration framework and enhancing service delivery across the country.','╬▒ΓòóΓöñ╬▒Γòû├û╬▒ΓòóΓòó╬▒ΓòóΓòù╬▒Γòû├ç╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├å 16 ╬▒Γòû├ç╬▒Γòû├ë╬▒ΓòóΓûÆ╬▒Γòû├å ╬▒Γòó┬╗╬▒Γòû├å╬▒ΓòóΓûÆ ╬▒ΓòóΓöñ╬▒Γòû├û╬▒ΓòóΓòù╬▒Γòû├ç╬▒ΓòóΓòù╬▒Γòû├╢╬▒Γòû├ç╬▒Γòû├£ ╬▒ΓòóΓûÆ╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├à╬▒Γòû├ñ╬▒Γòû├£╬▒ΓòóΓûÆ╬▒Γòû├¿╬▒ΓòóΓöñ╬▒Γòû├å╬▒Γòó┬║ ╬▒ΓòóΓòò╬▒Γòû├û╬▒Γòû├ñ╬▒Γòû├û╬▒Γòû├ç╬▒ΓòóΓòù ╬▒ΓòóΓöñ╬▒Γòû├å╬▒ΓòóΓòæ╬▒Γòû├ó ╬▒Γòó┬ú╬▒Γòû┬ú╬▒ΓòóΓîÉ╬▒ΓòóΓûÆ╬▒Γòû├ë╬▒Γòó┬ú╬▒Γòû├å╬▒ΓòóΓò£╬▒Γòû├¿╬▒ΓòóΓò£╬▒Γòû├£ ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒Γòó├á╬▒ΓòóΓòò╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòæ╬▒Γòû├à╬▒Γòó├⌐╬▒Γòû├╝ ╬▒Γòû├╝╬▒Γòû├¿╬▒ΓòóΓòù╬▒Γòû├ç╬▒Γòó┬╜╬▒Γòû├à╬▒Γòó┬ú╬▒Γòû├à╬▒ΓòóΓòù╬▒ΓòóΓòæ╬▒Γòû├£╬▒Γòó┬╗╬▒Γòû├┤ ╬▒ΓòóΓöñ╬▒Γòû├ë╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬í╬▒Γòû├å ╬▒Γòó├»╬▒Γòó┬í╬▒Γòû├¿╬▒Γòû├ó╬▒Γòû├ç╬▒ΓòóΓòæ╬▒Γòó├£╬▒Γòó┬╗╬▒Γòû├┤ ╬▒Γòó├á╬▒ΓòóΓò£╬▒Γòû├╢╬▒Γòó┬í╬▒Γòû├å╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒ΓòóΓòó╬▒ΓòóΓöé╬▒Γòû├ç╬▒Γòû├à╬▒Γòó┬ú╬▒Γòó┬í╬▒Γòû├¿ ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓò£╬▒ΓòóΓûæ╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓûÆ╬▒Γòû├¿ 38 ╬▒Γòó┬╗╬▒Γòû├û╬▒ΓòóΓûÆ╬▒Γòó├£╬▒Γòû├╢ ╬▒Γòû├ó╬▒ΓòóΓöé╬▒Γòû├ñ╬▒Γòû├à ╬▒ΓòóΓöñ╬▒Γòó┬í╬▒Γòû├¿╬▒Γòû├ç╬▒Γòû├┤╬▒ΓòóΓòò╬▒Γòû├¿ ╬▒ΓòóΓò£╬▒Γòû├å╬▒ΓòóΓöñ╬▒Γòû├å ╬▒ΓòóΓöñ╬▒Γòû├¿╬▒ΓòóΓòù╬▒Γòó┬╗╬▒Γòû├à╬▒ΓòóΓûÆ╬▒ΓòóΓòæ ╬▒Γòó├£╬▒Γòû├û╬▒ΓòóΓòù╬▒Γòû├å╬▒Γòó┬╜╬▒Γòû├å.\r\n\r\n╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒Γòó├á╬▒ΓòóΓòò╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòæ ╬▒Γòó├Ñ╬▒Γòó├í╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├¿╬▒ΓòóΓòæ ╬▒Γòó├á╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓò£╬▒Γòû├¿ ╬▒Γòó├│╬▒ΓòóΓòæ╬▒ΓòóΓûÆ╬▒Γòû├¿╬▒Γòó┬í ╬▒ΓòóΓöñ╬▒Γòû├¿╬▒ΓòóΓòù╬▒ΓòóΓûÆ╬▒Γòû├à╬▒ΓòóΓûÆ╬▒Γòû├¿╬▒Γòó┬╗╬▒Γòû├╢ ╬▒ΓòóΓòò╬▒Γòû├ñ╬▒Γòó┬í╬▒Γòû├à╬▒Γòó┬ú╬▒Γòû├£ ╬▒Γòû├ó╬▒Γòû├ñ ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓòæ╬▒Γòû┬Ñ╬▒Γòó├│╬▒Γòû├¿╬▒ΓòóΓòæ ╬▒Γòó├á╬▒ΓòóΓòò╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòæ ╬▒ΓòóΓòò╬▒Γòû├ñ╬▒Γòû├å╬▒ΓòóΓûÆ╬▒Γòû├¿╬▒Γòó┬╗ ╬▒Γòó├│╬▒ΓòóΓòæ╬▒Γòû├ó╬▒Γòû├å╬▒Γòó├⌐╬▒Γòû├ñ ╬▒ΓòóΓòò╬▒Γòû├ñ╬▒Γòó┬í╬▒Γòû├à╬▒Γòó┬ú╬▒Γòû├£ ╬▒ΓòóΓöñ╬▒Γòû├¿╬▒ΓòóΓòù╬▒ΓòóΓûæ╬▒Γòû├à╬▒ΓòóΓûÆ╬▒Γòó┬í╬▒Γòû├¿╬▒Γòû├ç╬▒ΓòóΓòæ╬▒Γòû├û╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒ΓòóΓòò╬▒Γòû├û╬▒ΓòóΓòò ╬▒Γòó├»╬▒Γòó┬í╬▒Γòû├¿╬▒Γòû├ó╬▒Γòû├ç╬▒ΓòóΓòæ ╬▒ΓòóΓöñ╬▒Γòû├ë╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬í╬▒Γòû├¿╬▒Γòû├ç╬▒Γòû├å╬▒Γòó┬╜╬▒Γòû├å.\r\n\r\n╬▒Γòó├á╬▒ΓòóΓò£╬▒Γòû├╢╬▒Γòó┬í╬▒Γòû├å╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒ΓòóΓöñ╬▒Γòó┬í╬▒Γòû├¿ ╬▒Γòó├£╬▒ΓòóΓòù╬▒ΓòóΓûÆ ╬▒ΓòóΓò£╬▒Γòó┬╗ ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓò£╬▒ΓòóΓûæ╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒Γòó├á╬▒ΓòóΓòò╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòæ╬▒Γòû├à╬▒Γòó├⌐╬▒Γòû├╝╬▒ΓòóΓòæ ╬▒ΓòóΓòæ╬▒Γòó┬║╬▒Γòó┬í╬▒Γòû├£ ╬▒Γòó├£╬▒Γòû├¿╬▒ΓòóΓòù╬▒Γòû├å╬▒ΓòóΓòæ╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòò╬▒Γòó├£ ╬▒Γòû├ç╬▒ΓòóΓûÆ  ╬▒Γòó├│╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒Γòó├á╬▒ΓòóΓûæ╬▒Γòû├¿╬▒ΓòóΓòæ╬▒ΓòóΓòæ╬▒ΓòóΓûÆ ╬▒Γòó├Ñ╬▒ΓòóΓòæ╬▒Γòó┬í╬▒ΓòóΓûÆ╬▒ΓòóΓòæ╬▒Γòû├£ ╬▒ΓòóΓòò╬▒Γòû├à╬▒Γòû├ó ╬▒Γòó┬í╬▒Γòû├╢╬▒ΓòóΓûÆ╬▒Γòó├£ ╬▒Γòó├Ñ╬▒ΓòóΓòæ╬▒Γòó┬í╬▒ΓòóΓûÆ╬▒Γòû├å╬▒Γòó├£ ╬▒ΓòóΓöñ╬▒Γòû├╢╬▒Γòû├ñ╬▒Γòû├╢╬▒Γòó┬╜╬▒Γòû├╢╬▒Γòû├ç╬▒Γòó├£╬▒Γòû├å╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒ΓòóΓöñ╬▒Γòû├ó╬▒Γòû├╢╬▒Γòû├ç ╬▒ΓòóΓòò╬▒Γòû├à╬▒Γòû├ó╬▒ΓòóΓòæ╬▒Γòó├£ ╬▒Γòó├£╬▒Γòû├¿╬▒Γòû├⌐╬▒Γòû├£╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòù ╬▒ΓòóΓòù╬▒Γòû├à╬▒Γòó├│╬▒Γòó├£╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├å ╬▒ΓòóΓöñ╬▒Γòû├╢╬▒Γòû├ñ╬▒Γòû├╢╬▒Γòó┬╜╬▒Γòû├╢╬▒Γòû├ç╬▒Γòó├£╬▒Γòû├å╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒Γòû├ó╬▒ΓòóΓòò╬▒ΓòóΓûÆ╬▒Γòû├¿╬▒Γòû├ç╬▒Γòû├å╬▒Γòó┬í ╬▒Γòû├ç╬▒Γòû├å╬▒Γòû├ó╬▒Γòû├¿╬▒Γòó┬í╬▒Γòû├┤╬▒ΓòóΓòù╬▒Γòó┬╜ ╬▒ΓòóΓöñ╬▒Γòû├╢╬▒Γòû├ñ╬▒Γòû├╢╬▒Γòó┬╜╬▒Γòû├╢ ╬▒Γòû├ç╬▒Γòû├ë╬▒ΓòóΓîÉ╬▒Γòû├ó╬▒Γòó┬║╬▒Γòû├ñ╬▒ΓòóΓûÆ╬▒Γòó├£╬▒Γòó┬║ ╬▒ΓòóΓòû╬▒Γòû├à╬▒Γòó├│╬▒ΓòóΓûÆ╬▒ΓòóΓòæ ╬▒Γòû├ç╬▒ΓòóΓûÆ╬▒Γòû├╢ ╬▒Γòó├º╬▒Γòó┬í. ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒ΓòóΓöñ╬▒ΓòóΓòù╬▒Γòû├å╬▒ΓòóΓöñ╬▒Γòû├à╬▒ΓòóΓò£╬▒ΓòóΓûÆ╬▒ΓòóΓòæ ╬▒Γòû├ó╬▒Γòû├ñ ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓòæ╬▒Γòû├à╬▒ΓòóΓòò╬▒ΓòóΓûÆ ╬▒Γòó├£╬▒Γòû├¿╬▒Γòû├⌐╬▒Γòû├£╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòù╬▒ΓòóΓòæ╬▒Γòû├£ ╬▒Γòó├╢╬▒Γòû├ç╬▒Γòû├╢╬▒ΓòóΓûÆ╬▒Γòû├¿╬▒Γòó┬ú╬▒Γòû├£ ╬▒Γòû├ç╬▒Γòó┬ú╬▒Γòó├£╬▒Γòû├┤╬▒ΓòóΓòò╬▒Γòû├¿ ╬▒ΓòóΓòí╬▒ΓòóΓò£╬▒Γòó┬╗╬▒Γòû├à╬▒ΓòóΓòæ╬▒Γòû├┤ ╬▒ΓòóΓò£╬▒Γòû├û╬▒Γòû├ó ╬▒Γòó├½╬▒Γòó┬║╬▒Γòû├╢ ╬▒Γòó├£╬▒Γòû├å╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓòò ╬▒Γòû├ó╬▒ΓòóΓöé╬▒Γòû├ñ╬▒Γòû├à ╬▒Γòó├á╬▒Γòû├ç╬▒Γòû├╝╬▒Γòû├¿╬▒ΓòóΓòæ ╬▒Γòó┬╗╬▒Γòû├ë╬▒ΓòóΓûÆ╬▒Γòû├╢╬▒ΓòóΓòò ╬▒Γòû├ó╬▒Γòû├ñ ╬▒ΓòóΓöñ╬▒Γòû├¿╬▒ΓòóΓòù╬▒Γòû├à╬▒ΓòóΓòæ╬▒Γòû┬Ñ╬▒Γòó┬ú╬▒Γòû├å╬▒Γòó├£ ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓòù╬▒Γòû├à╬▒Γòû├ç╬▒ΓòóΓòù╬▒Γòó┬╜╬▒ΓòóΓòæ╬▒Γòû├û╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒Γòó├╢╬▒Γòû├ç╬▒Γòû├╢╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒Γòû├ó╬▒ΓòóΓûÆ╬▒Γòû├¿╬▒ΓòóΓûÆ╬▒Γòó┬╗╬▒Γòû├¿╬▒ΓòóΓûæ ╬▒Γòó├£╬▒Γòû├å╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓòò ╬▒Γòû├ó╬▒ΓòóΓöé╬▒Γòû├ñ╬▒Γòû├à ╬▒ΓòóΓòò╬▒Γòû├û╬▒ΓòóΓòò ╬▒Γòû├ç╬▒Γòû├ë╬▒ΓòóΓîÉ╬▒Γòû├ó╬▒Γòó┬║╬▒Γòû├ñ╬▒ΓòóΓûÆ ╬▒Γòû├ó╬▒Γòû├ë╬▒ΓòóΓò£╬▒Γòû├ó╬▒Γòû├╢╬▒ΓòóΓòò╬▒Γòû├¿ ╬▒Γòó├£╬▒ΓòóΓòù ╬▒Γòó├º╬▒Γòó┬í.\r\n\r\n╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒Γòó├á╬▒ΓòóΓòò╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòæ╬▒Γòû├à╬▒Γòó├⌐╬▒Γòû├╝╬▒ΓòóΓòæ╬▒Γòû├£ ╬▒ΓòóΓò£╬▒Γòû├£╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿ ╬▒Γòó├ª╬▒Γòû├ó╬▒Γòû├¿.╬▒Γòó├ª╬▒ΓòóΓòò╬▒Γòû├¿. ╬▒ΓòóΓöñ╬▒Γòû├å╬▒ΓòóΓòæ╬▒Γòó┬í╬▒Γòû├å╬▒Γòû├ó╬▒Γòû├¿╬▒Γòû├ó, ╬▒Γòû├ó╬▒Γòû├ñ ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒Γòó├£╬▒Γòû┬ú╬▒ΓòóΓòò╬▒Γòû├ó╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├å╬▒Γòû├ó╬▒Γòû├¿ ╬▒Γòó├│╬▒ΓòóΓûÆ╬▒ΓòóΓòù╬▒Γòû├à╬▒ΓòóΓò£╬▒Γòû├¿ ╬▒ΓòóΓûÆ╬▒Γòó┬╗╬▒Γòû├┤╬▒Γòó├£╬▒Γòû├à ╬▒Γòû├ç╬▒Γòó┬║╬▒ΓòóΓò£╬▒Γòû├å╬▒ΓòóΓòæ╬▒Γòó┬╗╬▒Γòû├¿╬▒Γòó┬╗ ╬▒ΓòóΓòò╬▒Γòû├ñ╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòò╬▒Γòû├å╬▒ΓòóΓòæ ╬▒Γòó┬╗, ╬▒Γòó├á╬▒ΓòóΓòò╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòæ╬▒Γòû├à╬▒Γòó├⌐╬▒Γòû├╝╬▒ΓòóΓòæ╬▒Γòû├£ ╬▒Γòó├│╬▒Γòû├¿╬▒ΓòóΓòæ╬▒Γòû├û╬▒Γòû├⌐╬▒Γòû├¿╬▒Γòó┬┐ ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓò£╬▒ΓòóΓûæ╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒Γòó├£╬▒Γòû├å╬▒Γòû├ñ╬▒Γòû├å╬▒ΓòóΓöñ ╬▒Γòó┬╗╬▒Γòû├û╬▒ΓòóΓûÆ╬▒Γòû├û╬▒Γòó├£╬▒Γòû├╢ ╬▒Γòó┬╗ ╬▒ΓòóΓòò╬▒Γòû├û╬▒ΓòóΓòò ╬▒Γòó├»╬▒Γòó┬í╬▒Γòû├¿╬▒Γòû├ó╬▒Γòû├ç╬▒ΓòóΓòæ╬▒Γòó┬║ ╬▒Γòó├ª╬▒Γòó├£╬▒Γòû├¿╬▒Γòû├ç ╬▒Γòû├ó╬▒Γòû├å╬▒Γòó┬║╬▒Γòû├å╬▒ΓòóΓòæ╬▒Γòû├ñ.\r\n\r\n╬▒ΓòóΓòò╬▒Γòû├û╬▒ΓòóΓòò ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓò£╬▒ΓòóΓûæ╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒ΓòóΓöñ╬▒Γòó┬í╬▒Γòû├¿ ╬▒Γòó├£╬▒Γòû├å╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓòò ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒ΓòóΓöñ╬▒ΓòóΓòù╬▒Γòû├å╬▒ΓòóΓöñ╬▒Γòû├à╬▒ΓòóΓò£╬▒ΓòóΓûÆ ╬▒ΓòóΓòù╬▒Γòû├à╬▒ΓòóΓòò╬▒Γòû├╢╬▒Γòû├ç ╬▒Γòó┬í╬▒Γòû├ç╬▒Γòó┬╗╬▒Γòû├╢╬▒ΓòóΓòù╬▒Γòó┬║╬▒Γòó┬í╬▒Γòû├¿ ╬▒Γòû├╝╬▒Γòó├£╬▒Γòû├¿╬▒Γòó┬í╬▒Γòû├å╬▒ΓòóΓòò╬▒Γòó┬í╬▒Γòû├¿ ╬▒Γòó├£╬▒Γòû├å╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓòò ╬▒Γòû├ó╬▒Γòû├ñ ╬▒ΓòóΓòù╬▒Γòó┬║ ╬▒ΓòóΓöñ╬▒Γòû├╢╬▒ΓòóΓòù╬▒Γòû├à ╬▒Γòû├ó╬▒Γòû├£╬▒Γòû├ç╬▒Γòû├à ╬▒Γòû├ó╬▒Γòû├ë╬▒ΓòóΓöñ╬▒ΓòóΓòæ╬▒Γòû├┤╬▒ΓòóΓòò ╬▒Γòó├½╬▒Γòû├ñ╬▒Γòû├á ╬▒ΓòóΓûÆ╬▒Γòû├ë╬▒Γòó├⌐╬▒Γòû├ç╬▒Γòû├┤╬▒ΓòóΓòò ╬▒Γòû├ó╬▒ΓòóΓöé╬▒Γòû├ñ╬▒Γòû├à ╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬╗╬▒Γòó┬ú╬▒Γòó┬í╬▒Γòû├¿ ╬▒ΓòóΓöñ╬▒Γòû├å╬▒ΓòóΓòæ╬▒Γòû├ç╬▒ΓòóΓòù╬▒Γòó├£╬▒Γòû├¿ ╬▒Γòû├ó╬▒ΓòóΓûÆ╬▒Γòû├å╬▒Γòó┬║╬▒Γòû├╢╬▒Γòû├ñ╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒Γòó├£╬▒ΓòóΓòù╬▒ΓòóΓòæ╬▒Γòû├å.','╬▒┬½┬┐╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬½Γòú╬▒┬╗├º╬▒┬½ΓîÉ╬▒┬╗├¼╬▒┬½┬¼╬▒┬½ΓöÉ╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½ΓöÉ, ╬▒┬½┬½╬▒┬╗├Ñ╬▒┬½Γòú╬▒┬╗├º╬▒┬½Γòí╬▒┬½Γûæ ╬▒┬½┬¼╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½├£ ╬▒┬½├▓╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½╞Æ╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½├½╬▒┬½Γöé╬▒┬╗├¼╬▒┬½Γöé ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├á╬▒┬½┬½╬▒┬╗├¬╬▒┬½├£╬▒┬╗├¼╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├▓╬▒┬╗├º╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½┬¼╬▒┬╗├»╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├▓╬▒┬╗├⌐╬▒┬½╞Æ╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½├▓╬▒┬½╞Æ╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½┬¼╬▒┬╗├Ñ╬▒┬½┬¼╬▒┬╗├¼╬▒┬½Γûæ╬▒┬½Γòí╬▒┬½Γûæ╬▒┬½ΓöÉ 16 ╬▒┬½├Ñ╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½├▒╬▒┬½ΓöÉ ╬▒┬½├▓╬▒┬½Γò¢╬▒┬½Γûô╬▒┬╗├¬ ╬▒┬½├º╬▒┬½╞Æ╬▒┬½┬½╬▒┬╗├¼╬▒┬½┬¼╬▒┬╗├Ñ╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½ΓûÆ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γöñ╬▒┬╗├¼╬▒┬½Γòí╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½┬¼╬▒┬╗├╝╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬½Γò¢╬▒┬½├▓ ╬▒┬½├£╬▒┬╗├º╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬╗├╝╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬╗├¿╬▒┬½Γöé╬▒┬╗├¼╬▒┬½Γöé╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ 38 ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├½╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬╗├»╬▒┬½├▓╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├╝╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γò¢╬▒┬½ΓîÉ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½┬½╬▒┬½ΓîÉ╬▒┬½├▓╬▒┬╗├¼ ╬▒┬½├▓╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├¼ ╬▒┬½Γòí╬▒┬½Γöñ╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓╬▒┬½ΓöÉ ╬▒┬½Γòí╬▒┬╗├¬╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½ΓîÉ.\r\n\r\n╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├á╬▒┬½┬½╬▒┬╗├¬╬▒┬½├£╬▒┬╗├¼╬▒┬½├£╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½╞Æ╬▒┬╗├¿╬▒┬½├▓╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├á╬▒┬½ΓîÉ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½┬ú╬▒┬½┬╗╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½┬¼╬▒┬╗├Ñ╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½ΓîÉ╬▒┬½Γò¢╬▒┬½├║╬▒┬╗├¼╬▒┬½╞Æ╬▒┬╗├» ╬▒┬½┬½╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½┬¼╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬½├▒╬▒┬½ΓöÉ ╬▒┬½├á╬▒┬½┬½╬▒┬╗├¬╬▒┬½├£╬▒┬╗├¼╬▒┬½├£╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬╗├╝ ╬▒┬½┬½╬▒┬½Γòú╬▒┬½ΓöÉ╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½┬ú╬▒┬½┬╗╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓ ╬▒┬½├Ñ╬▒┬½├▓╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬╗├»╬▒┬½Γûæ╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├▒╬▒┬½Γûô╬▒┬╗├¬╬▒┬½┬½╬▒┬╗├¬╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½├º╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γöñ╬▒┬╗├¼╬▒┬½Γòí╬▒┬╗├╝ ╬▒┬½├º╬▒┬½╞Æ╬▒┬½┬½╬▒┬╗├¼╬▒┬½┬¼╬▒┬╗├Ñ╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬½├▒╬▒┬╗├╝.\r\n\r\n╬▒┬½┬¼╬▒┬╗├╝╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬½Γò¢╬▒┬½├▓ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½┬½╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½Γöé╬▒┬╗├¼╬▒┬½Γöé ╬▒┬½├á╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├¼, ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├á╬▒┬½┬½╬▒┬╗├¬╬▒┬½├£╬▒┬╗├¼╬▒┬½├£╬▒┬½├▓╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├▓╬▒┬╗├ç╬▒┬½Γöñ╬▒┬╗├¼ ╬▒┬½├£╬▒┬╗├Ñ╬▒┬½┬╗╬▒┬½Γûô╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├º╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½┬╗ ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├Ñ╬▒┬½┬╗╬▒┬╗├¼╬▒┬½Γòí╬▒┬╗├╝╬▒┬½├▓╬▒┬╗├¼ ╬▒┬½├▓╬▒┬½Γöñ╬▒┬½├▓╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½┬½╬▒┬╗├⌐╬▒┬½ΓîÉ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬╗├╝ ╬▒┬½┬½╬▒┬½Γò¢╬▒┬½├▒ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½ΓûÆ╬▒┬╗├╝╬▒┬½Γòí╬▒┬½ΓîÉ╬▒┬½┬¼╬▒┬╗├¼ ╬▒┬½┬¼╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬╗├¬╬▒┬½┬╗╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├á╬▒┬½├▒╬▒┬½ΓîÉ╬▒┬╗├¼╬▒┬½┬¼╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├å╬▒┬½Γûæ╬▒┬╗├╝ ╬▒┬½┬½╬▒┬½Γò¢╬▒┬½├▒ ╬▒┬½├▓╬▒┬½Γöé╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½├║╬▒┬½ΓöÉ╬▒┬½┬¼╬▒┬╗├¼ ╬▒┬½┬¼╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬╗├¬╬▒┬½┬╗╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├½╬▒┬½Γöé╬▒┬╗├¼╬▒┬½Γöé╬▒┬½╞Æ╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬½ΓöÉ╬▒┬½┬╗ ╬▒┬½Γòí╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬½ΓöÉ╬▒┬½Γòí╬▒┬½Γò¢╬▒┬½ΓîÉ ╬▒┬½┬¼╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬╗├¼ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½├¬╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½Γòí╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├¼. ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½Γòí╬▒┬½Γò¢╬▒┬½├▓╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½┬½╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├å╬▒┬½Γöñ╬▒┬╗├╝╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½├▒╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½├á╬▒┬½Γòí╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½┬¼╬▒┬╗├¿╬▒┬½ΓûÆ╬▒┬╗├╝╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬╗├╝╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├¬ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½ΓûÆ╬▒┬½┬½╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ ╬▒┬½├£╬▒┬╗├Ñ╬▒┬½┬╗╬▒┬½Γûô╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½├▒╬▒┬╗├º╬▒┬½Γòí╬▒┬╗├¬╬▒┬½┬╗╬▒┬½Γò¢╬▒┬½ΓîÉ ╬▒┬½├á╬▒┬½ΓûÆ╬▒┬½ΓöÉ╬▒┬½Γòí╬▒┬╗├╝ ╬▒┬½┬½╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½┬┐╬▒┬½╞Æ╬▒┬╗├¬╬▒┬½┬½╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬ ╬▒┬½Γòí╬▒┬╗├Ñ╬▒┬½Γöé╬▒┬½ΓöÉ╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½Γò¢╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├╝╬▒┬½╞Æ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├á╬▒┬½Γòí╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├¬ ╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬╗├╝╬▒┬½Γòí╬▒┬½├▒╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γò¢╬▒┬½├▓ ╬▒┬½├º╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½Γòí╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½Γòí╬▒┬½┬½╬▒┬╗├¬╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½Γöé╬▒┬╗├¼╬▒┬½Γöé╬▒┬½├▒╬▒┬╗├╝.\r\n\r\n╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├á╬▒┬½┬½╬▒┬╗├¬╬▒┬½├£╬▒┬╗├¼╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├£╬▒┬╗├Ñ╬▒┬½┬╗╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬╗├╝. ╬▒┬½├ä╬▒┬½Γòò╬▒┬╗├¼.╬▒┬½├ä╬▒┬½┬½╬▒┬╗├¼. ╬▒┬½┬¼╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γòò╬▒┬╗├¼╬▒┬½Γòò, ╬▒┬½┬½╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├Ñ╬▒┬½├║╬▒┬╗├¬╬▒┬½┬╗╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½┬┐╬▒┬½Γò¢╬▒┬½┬╗╬▒┬½├▓╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬╗├╝╬▒┬½┬½╬▒┬½├▒╬▒┬½ΓöÉ ╬▒┬½┬┐╬▒┬½├▒╬▒┬╗├ç╬▒┬½├▓╬▒┬½Γò¢ ╬▒┬½Γòí╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½Γûô╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½├á╬▒┬½Γòí╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼, ╬▒┬½├á╬▒┬½┬½╬▒┬╗├¬╬▒┬½├£╬▒┬╗├¼╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬╗├º╬▒┬½Γòû╬▒┬╗├¼╬▒┬½╞Æ ╬▒┬½├á╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├¼ ╬▒┬½┬¼╬▒┬½Γûô╬▒┬½Γûæ╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├º╬▒┬½Γòí╬▒┬╗├¼╬▒┬½Γòí╬▒┬½ΓöÉ╬▒┬½Γöñ╬▒┬½Γò¢╬▒┬½Γòí╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½├▓╬▒┬½Γûô╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒╬▒┬╗├╝╬▒┬½├▓╬▒┬╗├¿╬▒┬½├║╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½ΓîÉ╬▒┬½Γûæ╬▒┬╗├¼.\r\n\r\n╬▒┬½├º╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½├á╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γöé╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½┬½╬▒┬½ΓîÉ╬▒┬½┬½╬▒┬╗├¼, ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½Γòí╬▒┬½Γò¢╬▒┬½├▓╬▒┬½├▓╬▒┬╗├¼ ╬▒┬½├▓╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½┬½╬▒┬╗├¬╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬╗├¬ ╬▒┬½┬½╬▒┬╗├º╬▒┬½Γûô╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½Γòí╬▒┬½Γûô╬▒┬╗├╝╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬╗├╝╬▒┬½Γòí╬▒┬½├▒╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½├▓╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼, ╬▒┬½┬┐╬▒┬½Γò¢╬▒┬½╞Æ╬▒┬╗├╝ ╬▒┬½┬½╬▒┬╗├╝╬▒┬½Γöñ╬▒┬╗├╝╬▒┬½Γòí╬▒┬½├▒╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├£╬▒┬╗├º╬▒┬½Γòí╬▒┬╗├¬ ╬▒┬½Γòí╬▒┬½Γöñ╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γûô╬▒┬╗├¬ ╬▒┬½┬½╬▒┬╗├º╬▒┬½┬½╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├╝╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬╗├╝╬▒┬½Γòí╬▒┬½├▒╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½├▓╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├å╬▒┬½Γûæ╬▒┬╗├╝ ╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬½ΓöÉ╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½ΓöÉ╬▒┬½╞Æ╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓ ╬▒┬½┬¼╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬╗├¬╬▒┬½├▓╬▒┬╗├¼ ╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬½ΓöÉ╬▒┬½ΓûÆ╬▒┬½├▒╬▒┬╗├╝.','uploads/news/2026/06/gallery-1-e866c.webp',NULL,'english','public',0,0,'Published',2,'2026-06-05 06:34:59','2026-06-05 09:47:38'),(2,'The committee approved by the Cabinet to amend the labour laws is consulting the National Labour Advisory Council (NLAC).','╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒ΓòóΓûÆ╬▒Γòû├┤╬▒Γòó┬í╬▒Γòû├å ╬▒Γòû├ó╬▒Γòó├⌐╬▒Γòû├╝╬▒Γòû┬Ñ╬▒ΓòóΓûæ╬▒ΓòóΓûÆ╬▒ΓòóΓòæ ╬▒Γòó├£╬▒Γòû├å╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓòò ╬▒Γòû├ó╬▒ΓòóΓöé╬▒Γòû├ñ╬▒Γòû├à ╬▒Γòó├£╬▒Γòû├ë╬▒ΓòóΓòó╬▒Γòû├å╬▒ΓòóΓûÆ╬▒Γòó┬║╬▒Γòû├¿ ╬▒ΓòóΓòò╬▒Γòó┬╜╬▒Γòû├¿╬▒ΓòóΓîÉ╬▒ΓòóΓò£╬▒ΓòóΓòæ ╬▒Γòû├ç╬▒Γòû├å╬▒Γòû├ó╬▒Γòû├å╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒Γòó├á╬▒ΓòóΓûÆ╬▒Γòû├╢╬▒ΓòóΓòò╬▒Γòó┬í ╬▒Γòó├£╬▒ΓòóΓòù╬▒ΓòóΓûÆ ╬▒ΓòóΓò£╬▒Γòó┬╗ ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├å╬▒Γòó┬║╬▒Γòû├╢╬▒Γòû├ç ╬▒Γòó├│╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒Γòó├»╬▒ΓòóΓöñ╬▒Γòó┬╗╬▒Γòû├£╬▒Γòû├╝╬▒Γòó├£ ╬▒Γòû├ó╬▒ΓòóΓòû','╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├£╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬╗├¬╬▒┬½├▒╬▒┬╗├¼ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬╗├╝╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬╗├╝╬▒┬½Γòí╬▒┬½├▒╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½├▓╬▒┬╗├╝ ╬▒┬½├á╬▒┬½┬½╬▒┬╗├¬╬▒┬½├£╬▒┬╗├¼╬▒┬½├£╬▒┬½Γûæ╬▒┬½Γòí╬▒┬╗├¬╬▒┬½┬╗╬▒┬½Γò¢╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½├á╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓╬▒┬╗├ç╬▒┬½├▓╬▒┬½Γûæ╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ ╬▒┬½├▓╬▒┬╗├╝╬▒┬½Γöñ╬▒┬╗├╝ ╬▒┬½├▒╬▒┬╗├º╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½┬╗ ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒','Media',NULL,'The ceremony organized to mark the commencement of the Ministry of Labor and its subordinate institutions for the year 2026 was held this morning (01) at the Narahenpita','2026 ╬▒Γòû├ç╬▒Γòû├ó╬▒ΓòóΓòù ╬▒Γòû├ó╬▒ΓòóΓöé╬▒Γòû├ñ╬▒Γòû├à ╬▒Γòó├£╬▒ΓòóΓòò╬▒Γòû├¿╬▒Γòó├£╬▒ΓòóΓòù╬▒Γòû├╢ ╬▒Γòó├á╬▒ΓòóΓòò╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├¿╬▒ΓòóΓòæ╬▒Γòû├à╬▒Γòó├⌐╬▒Γòû├╝╬▒ΓòóΓòæ ╬▒Γòû├ó╬▒Γòû├ñ ╬▒Γòó├¿╬▒Γòó┬║ ╬▒Γòó├á╬▒ΓòóΓûÆ╬▒Γòû├╢╬▒ΓòóΓòó╬▒Γòó┬╗╬▒Γòû├¿╬▒ΓòóΓûæ ╬▒Γòó├Ñ╬▒ΓòóΓòæ╬▒Γòó┬í╬▒ΓòóΓûÆ ╬▒Γòó├Ñ╬▒ΓòóΓòù╬▒ΓòóΓòò╬▒Γòû├¿╬▒ΓòóΓòû ╬▒Γòó├£╬▒Γòû├å╬▒ΓòóΓòù╬▒Γòû├┤╬▒ΓòóΓòò ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒ΓòóΓòò╬▒Γòû├å╬▒Γòó┬í╬▒Γòû├¿╬▒Γòó┬í╬▒Γòû├û╬▒ΓòóΓûÆ╬▒Γòû├¿ ╬▒Γòû├ó╬▒Γòó├⌐╬▒Γòû├ç╬▒Γòû├å╬▒ΓòóΓûæ╬▒Γòû├à╬▒ΓòóΓûÆ╬▒ΓòóΓòæ ╬▒Γòó├£╬▒Γòû├á ╬▒Γòó├»╬▒Γòó┬í╬▒Γòû├¿╬▒Γòû├ó╬▒Γòû├ç╬▒ΓòóΓòæ ╬▒Γòó├á╬▒Γòó┬╗ (01) ╬▒ΓòóΓöñ╬▒Γòû├û╬▒ΓòóΓòù╬▒Γòû├ç╬▒ΓòóΓòù╬▒Γòû├╢╬▒Γòû├ç╬▒Γòû├£ ╬▒ΓòóΓûÆ╬▒Γòû├à╬▒ΓòóΓòù╬▒Γòû├à╬▒Γòû├ñ╬▒Γòû├£╬▒ΓòóΓûÆ╬▒Γòû├¿╬▒ΓòóΓöñ╬▒Γòû├å╬▒Γòó┬║ ╬▒Γòó┬╗╬▒Γòû├┤ ╬▒ΓòóΓöñ╬▒Γòû├ë╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬í╬▒Γòû├¿╬▒Γòû├ç╬▒Γòû├å╬▒Γòó┬╜╬▒Γòû├å.','2026 ╬▒┬½├Ñ╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├Ñ╬▒┬½├║╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γò¢╬▒┬½ΓîÉ ╬▒┬½├▒╬▒┬╗├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬½Γò¢╬▒┬½Γöé╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├á╬▒┬½┬½╬▒┬╗├¬╬▒┬½├£╬▒┬╗├¼╬▒┬½├£╬▒┬╗├╝ ╬▒┬½┬½╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├á╬▒┬½├▒╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├▓╬▒┬╗├ç╬▒┬½Γöñ╬▒┬╗├¼ ╬▒┬½├º╬▒┬½┬╗╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½┬┐╬▒┬½ΓöÉ╬▒┬½ΓûÆ╬▒┬╗├╝╬▒┬½Γòí╬▒┬½ΓîÉ╬▒┬½├û╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├Ñ╬▒┬½Γûæ╬▒┬½┬½╬▒┬╗├¼╬▒┬½┬¼╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬╗├¬ ╬▒┬½┬½╬▒┬╗├╝╬▒┬½ΓîÉ╬▒┬╗├¼╬▒┬½ΓîÉ╬▒┬½ΓöÉ╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬╗├╝ ╬▒┬½├à╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½┬¼╬▒┬½Γò¢╬▒┬½╞Æ╬▒┬╗├╝ ╬▒┬½├£╬▒┬╗├Ñ╬▒┬½┬╗╬▒┬╗├¼╬▒┬½┬╗╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ ╬▒┬½Γòí╬▒┬╗├¬╬▒┬½┬¼╬▒┬½Γòí╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├º╬▒┬½ΓîÉ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬╗├╝ (01) ╬▒┬½├▓╬▒┬½Γò¢╬▒┬½Γûô╬▒┬╗├¬ ╬▒┬½┬┐╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬½Γòú╬▒┬╗├º╬▒┬½ΓîÉ╬▒┬╗├¼╬▒┬½┬¼╬▒┬½ΓöÉ╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½┬┐╬▒┬½╞Æ╬▒┬╗├¬╬▒┬½┬¼╬▒┬╗├Ñ╬▒┬½ΓûÆ╬▒┬╗├¼╬▒┬½ΓûÆ╬▒┬½├▒╬▒┬╗├╝.','uploads/news/2026/06/cabinet-a918e.jpg',NULL,'english','public',0,0,'Published',2,'2026-06-05 06:38:05','2026-06-05 09:47:30'),(3,'Press release on private sector salary increase.','╬▒ΓòóΓöñ╬▒ΓòûΓéº╬▒Γòó┬╗╬▒Γòû├¿╬▒Γòó┬ú╬▒ΓòóΓò£╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├á╬▒Γòó├⌐╬▒Γòû├╝╬▒ΓòóΓòæ╬▒Γòû├£ ╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬║╬▒Γòû├╢╬▒ΓòóΓöñ╬▒Γòû├¿ ╬▒Γòû├ç╬▒Γòû├ë╬▒ΓòóΓîÉ╬▒Γòû├å╬▒Γòû├ç╬▒Γòû├┤╬▒ΓòóΓòò ╬▒ΓòóΓöñ╬▒Γòû├å╬▒Γòû├á╬▒Γòû├å╬▒ΓòóΓòó╬▒ΓòóΓöé ╬▒ΓòóΓòò╬▒Γòû├à╬▒ΓòóΓûæ╬▒Γòû├¿╬▒ΓòóΓòæ ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒Γòû├ç╬▒Γòû├£╬▒Γòó┬╗╬▒ΓòóΓûÆ╬▒ΓòóΓòæ.','╬▒┬½├▒╬▒┬½ΓîÉ╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├£╬▒┬½┬½╬▒┬╗├¼╬▒┬½┬¼╬▒┬½Γöé ╬▒┬½├á╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γûæ╬▒┬½ΓöÉ╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬╗├╝ ╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½├£╬▒┬╗├Ñ╬▒┬½┬╗╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬½ΓöÉ╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬╗├╝.','Notices',NULL,'In accordance with the provisions of the National Minimum Wage of Employees Amendment Act No. 11 of 2025, the National Minimum Wage in the private sector','2025 ╬▒Γòó├á╬▒Γòó├⌐╬▒Γòó├£ 11 ╬▒Γòó┬╗╬▒ΓòóΓòù╬▒ΓòóΓûÆ ╬▒Γòû├ó╬▒Γòû├£╬▒Γòû├ç╬▒Γòó├£ ╬▒Γòó├│╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├á╬▒Γòû├ç╬▒ΓòóΓòò ╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬║╬▒Γòû├╢╬▒ΓòóΓöñ╬▒Γòû├¿ ╬▒Γòû├ó╬▒Γòó├⌐╬▒Γòû├╝╬▒Γòû┬Ñ╬▒ΓòóΓûæ╬▒ΓòóΓûÆ ╬▒ΓòóΓöñ╬▒ΓòóΓûÆ╬▒Γòó┬í╬▒Γòû├£ ╬▒Γòû├ç╬▒Γòû├å╬▒ΓòóΓûæ╬▒Γòû├å╬▒Γòû├ç╬▒Γòû├å╬▒ΓòóΓûæ╬▒Γòû├à╬▒ΓòóΓûÆ ╬▒Γòó├á╬▒ΓòóΓûÆ╬▒Γòû├╢╬▒Γòû├ç ╬▒ΓòóΓöñ╬▒Γòû├╢╬▒Γòó┬╗╬▒Γòû├¿╬▒Γòó┬ú╬▒ΓòóΓò£╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├á╬▒Γòó├⌐╬▒Γòû├╝╬▒ΓòóΓòæ╬▒Γòû├£ ╬▒Γòó├│╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├á╬▒Γòû├ç╬▒ΓòóΓòò ╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬║╬▒Γòû├╢╬▒ΓòóΓöñ','2025 ╬▒┬½├Ñ╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├Ñ╬▒┬½├║╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ 11 ╬▒┬½├Ñ╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├ä╬▒┬½├║╬▒┬╗├¼ ╬▒┬½├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├º╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½┬╗ ╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½├£ ╬▒┬½├¿╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½├▒╬▒┬╗├¼ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬╗├╝╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½├£╬▒┬╗├¼ ╬▒┬½├£╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½Γòí╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γöé╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬½ΓöÉ, ╬▒┬½├▒╬▒┬½ΓîÉ╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├º╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½┬╗ ╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½├£ ╬▒┬½├¿╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½┬½╬▒┬╗├¼','uploads/news/2026/06/minister-9d429.jpg',NULL,'english','public',1,0,'Published',2,'2026-06-05 06:44:31','2026-06-05 09:47:22'),(12,'Press release on private sector salary increase.','╬▒ΓòóΓöñ╬▒ΓòûΓéº╬▒Γòó┬╗╬▒Γòû├¿╬▒Γòó┬ú╬▒ΓòóΓò£╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├á╬▒Γòó├⌐╬▒Γòû├╝╬▒ΓòóΓòæ╬▒Γòû├£ ╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬║╬▒Γòû├╢╬▒ΓòóΓöñ╬▒Γòû├¿ ╬▒Γòû├ç╬▒Γòû├ë╬▒ΓòóΓîÉ╬▒Γòû├å╬▒Γòû├ç╬▒Γòû├┤╬▒ΓòóΓòò ╬▒ΓòóΓöñ╬▒Γòû├å╬▒Γòû├á╬▒Γòû├å╬▒ΓòóΓòó╬▒ΓòóΓöé ╬▒ΓòóΓòò╬▒Γòû├à╬▒ΓòóΓûæ╬▒Γòû├¿╬▒ΓòóΓòæ ╬▒ΓòóΓûÆ╬▒Γòû├å╬▒Γòû├ç╬▒Γòû├£╬▒Γòó┬╗╬▒ΓòóΓûÆ╬▒ΓòóΓòæ.','╬▒┬½├▒╬▒┬½ΓîÉ╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├£╬▒┬½┬½╬▒┬╗├¼╬▒┬½┬¼╬▒┬½Γöé ╬▒┬½├á╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γûæ╬▒┬½ΓöÉ╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬╗├╝ ╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒ ╬▒┬½├£╬▒┬╗├Ñ╬▒┬½┬╗╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬½ΓöÉ╬▒┬½┬¼╬▒┬╗├¼╬▒┬½┬¼╬▒┬╗├╝.','Media',NULL,'In accordance with the provisions of the National Minimum Wage of Employees Amendment Act No. 11 of 2025, the National Minimum Wage in the private sector,...Read More','2025 ╬▒Γòó├á╬▒Γòó├⌐╬▒Γòó├£ 11 ╬▒Γòó┬╗╬▒ΓòóΓòù╬▒ΓòóΓûÆ ╬▒Γòû├ó╬▒Γòû├£╬▒Γòû├ç╬▒Γòó├£ ╬▒Γòó├│╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├á╬▒Γòû├ç╬▒ΓòóΓòò ╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬║╬▒Γòû├╢╬▒ΓòóΓöñ╬▒Γòû├¿ ╬▒Γòû├ó╬▒Γòó├⌐╬▒Γòû├╝╬▒Γòû┬Ñ╬▒ΓòóΓûæ╬▒ΓòóΓûÆ ╬▒ΓòóΓöñ╬▒ΓòóΓûÆ╬▒Γòó┬í╬▒Γòû├£ ╬▒Γòû├ç╬▒Γòû├å╬▒ΓòóΓûæ╬▒Γòû├å╬▒Γòû├ç╬▒Γòû├å╬▒ΓòóΓûæ╬▒Γòû├à╬▒ΓòóΓûÆ ╬▒Γòó├á╬▒ΓòóΓûÆ╬▒Γòû├╢╬▒Γòû├ç ╬▒ΓòóΓöñ╬▒ΓòûΓéº╬▒Γòó┬╗╬▒Γòû├¿╬▒Γòó┬ú╬▒ΓòóΓò£╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├á╬▒Γòó├⌐╬▒Γòû├╝╬▒ΓòóΓòæ╬▒Γòû├£ ╬▒Γòó├│╬▒Γòû├à╬▒Γòó┬í╬▒Γòû├å╬▒Γòó├£ ╬▒Γòó├á╬▒Γòû├ç╬▒ΓòóΓòò ╬▒Γòû├ç╬▒Γòû├ë╬▒Γòó┬║╬▒Γòû├╢╬▒ΓòóΓöñ╬▒Γòû├¿,...Read More','2025 ╬▒┬½├Ñ╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├Ñ╬▒┬½├║╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ 11 ╬▒┬½├Ñ╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½├ä╬▒┬½├║╬▒┬╗├¼ ╬▒┬½├¿╬▒┬½Γöñ╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½Γûæ╬▒┬╗├¼╬▒┬½├▓╬▒┬½Γöé╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├º╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½┬╗ ╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½├£ ╬▒┬½├¿╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½├▒╬▒┬╗├¼ ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½Γûæ╬▒┬╗├╝╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½├£╬▒┬╗├¼ ╬▒┬½├£╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½╞Æ╬▒┬½├▒╬▒┬╗├¼╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼ ╬▒┬½Γòí╬▒┬½ΓöÉ╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬½Γöé╬▒┬½ΓöÉ╬▒┬½ΓîÉ╬▒┬╗├¼╬▒┬½┬¼╬▒┬½╞Æ╬▒┬½ΓöÉ, ╬▒┬½├▒╬▒┬½ΓîÉ╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½Γò¢╬▒┬½Γûæ╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½┬╗╬▒┬½ΓöÉ╬▒┬½Γûô╬▒┬╗├¼ ╬▒┬½├▒╬▒┬╗├º╬▒┬½├£╬▒┬½ΓöÉ╬▒┬½┬╗ ╬▒┬½├▓╬▒┬╗├╝╬▒┬½ΓûÆ╬▒┬╗├¬╬▒┬½┬┐╬▒┬╗├¼╬▒┬½├▒╬▒┬½┬¼╬▒┬½╞Æ╬▒┬╗├¼╬▒┬½├£ ╬▒┬½├¿╬▒┬½├▒╬▒┬½ΓöÉ╬▒┬½┬╗╬▒┬½┬½╬▒┬╗├¼,...╬▒┬½┬½╬▒┬╗├º╬▒┬½Γûô╬▒┬╗├╝╬▒┬½┬½╬▒┬╗├¼ ╬▒┬½┬¼╬▒┬½╞Æ╬▒┬½ΓöÉ╬▒┬½├▓╬▒┬╗├¼╬▒┬½├▓','uploads/news/2026/06/appointment-letters-64c23.jpg',NULL,'english','public',0,0,'Published',1,'2026-06-10 04:56:44','2026-06-10 04:56:44');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_images`
--

DROP TABLE IF EXISTS `news_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `article_id` (`news_id`),
  CONSTRAINT `news_images_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_images`
--

LOCK TABLES `news_images` WRITE;
/*!40000 ALTER TABLE `news_images` DISABLE KEYS */;
INSERT INTO `news_images` VALUES (1,1,'uploads/news/2026/06/gallery-2-e9d84.webp','2026-06-05 06:34:59'),(2,1,'uploads/news/2026/06/gallery-3-ead1d.webp','2026-06-05 06:34:59'),(3,1,'uploads/news/2026/06/gallery-4-ebc4e.webp','2026-06-05 06:34:59'),(4,2,'uploads/news/2026/06/minister-aabe3.jpg','2026-06-05 06:38:05'),(5,3,'uploads/news/2026/06/cabinet-9e1ac.jpg','2026-06-05 06:44:31'),(6,3,'uploads/news/2026/06/nlac-9eb01.jpg','2026-06-05 06:44:31');
/*!40000 ALTER TABLE `news_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `officials`
--

DROP TABLE IF EXISTS `officials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `officials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` enum('top','division') NOT NULL,
  `top_role` enum('minister','deputy_minister','secretary') DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `designation` varchar(200) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `division_id` (`division_id`),
  CONSTRAINT `officials_division_fk` FOREIGN KEY (`division_id`) REFERENCES `divisions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officials`
--

LOCK TABLES `officials` WRITE;
/*!40000 ALTER TABLE `officials` DISABLE KEYS */;
INSERT INTO `officials` VALUES (1,'top','minister',NULL,'Hon. Minister of Labour','Hon. Minister Anil Jayantha Fernando','','minister@labourmin.gov.lk','+94 (0)112 368175','+94 (0)112 588950','admin/uploads/officials/minister-anil-jayantha-fernando.webp',1,1,'2026-06-09 10:35:01','2026-06-09 11:18:37'),(2,'top','deputy_minister',NULL,'Hon. Deputy Minister of Labour','Mr. Mahinda Jayasinghe','','majayasinghe@gmail.com','+94 (0)112 368526','+94 (0)112 369340','admin/uploads/officials/deputy-minister-mahinda-jayasinghe.webp',2,1,'2026-06-09 10:35:01','2026-06-09 11:19:31'),(3,'top','secretary',NULL,'Secretary','Mr. S.M.Piyatissa',NULL,'slmol@slt.lk','+94 (0)112 368164','+94 (0)112 582938','admin/uploads/officials/secretary-sm-piyatissa.webp',3,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(4,'division',NULL,1,'Additional Secretary (Administration)','Ms. T P Muditha Pathmajay','Additional Secretary (Development)','mpathmajay@gmail.com','0718123025','+94 (0)112 368165','admin/uploads/officials/admin-muditha-pathmajay.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:54:45'),(5,'division',NULL,1,'Senior Assistant Secretary (Administration)','Mr. L.T.G.D Darshana','Senior Assistant Secretary (Administration)','sas.admin@labourmin.gov.lk','+94 (0)112 368304','+94 (0)112 368200','admin/uploads/officials/admin-darshana-ltgd.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:54:45'),(6,'division',NULL,1,'Assistant Secretary (Procurement)','Ms. S Luxiga','Assistant Secretary (Administration)','skluxi@gmail.com','0779265869','','admin/uploads/officials/admin-luxiga-s.webp',3,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(7,'division',NULL,1,'Assistant Secretary (Establishment)','Ms. Yashoda Thissera','Assistant Secretary (Establishment)','as.est@labourmin.gov.lk','+94 (0) 112 368264','','admin/uploads/officials/admin-yashoda-thissera.webp',4,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(8,'division',NULL,1,'Legal Officer','Ms. W P A G Wijesooriya','Legal Officer','gayaniew1@gmail.com','0763526589','','admin/uploads/officials/admin-wijesooriya-wpag.webp',5,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(9,'division',NULL,2,'Additional Secretary (Development)','Mr. Lal Samarasekara','Additional Secretary (Development)','adsec.dev@labourmin.gov.lk','+94 (0)112 586337','+94 (0)112 589267','admin/uploads/officials/dev-lal-samarasekara.webp',1,1,'2026-06-09 10:35:01','2026-06-09 16:39:31'),(10,'division',NULL,2,'Director (Development)','Mr. P D Chandana Pathirage','Director (Development)','pstchandana@gmail.com','0713373538','','admin/uploads/officials/dev-chandana-pathirage.webp',2,1,'2026-06-09 10:35:01','2026-06-09 16:39:31'),(11,'division',NULL,3,'Director General (Planning)','Ms. I V N Preethika Kumuduni','Director General (Planning)','','+94 (0)112 368594','','admin/uploads/officials/planning-preethika-kumuduni.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(12,'division',NULL,3,'Deputy Director (Planning)','Ms. M.P.D.C.W.Kumari','Deputy Director (Planning)','kuma_lg@yahoo.com','0716897218','','admin/uploads/officials/planning-kumari-mpdcw.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(13,'division',NULL,4,'Chief Finance Officer','Mrs. G.C.N. Fonseka','Chief Finance Officer','','+94 (0)112 505161','','admin/uploads/officials/finance-fonseka-gcn.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(14,'division',NULL,4,'Chief Accountant','Ms. S S Shiroma Nandani','Chief Accountant','shiromanandani@yahoo.com','0752261785','+94 (0)112 368204','admin/uploads/officials/finance-nandani-shiroma.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(15,'division',NULL,5,'Chief Internal Auditor','Mrs. A.M.M.K. Abeysinghe','Chief Internal Auditor','cia@labourmin.gov.lk','+94 (0)112 369422','','admin/uploads/officials/internal-audit-abeysinghe-ammk.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(16,'division',NULL,6,'Senior Assistant Secretary (Foreign Relations)','Mr. B Vasanthan','Senior Assistant Secretary (Foreign Relations)','bvasanthan@yahoo.com','0718249902','+94 (0)112 368609','admin/uploads/officials/foreign-relations-vasanthan-b.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(17,'division',NULL,6,'Assistant Secretary (FR)','Mrs. M.N.H.Peiris','Assistant Secretary (FR)','as.fr@labourmin.gov.lk','+94 (0)112 504478','','admin/uploads/officials/foreign-relations-peiris-mnh.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(19,'division',NULL,7,'Designated Officer','Mr. B.V.P.A.P.B. Basnayake','Additional Secretary (Administration)','addsec.admin@labourmin.gov.lk','+94 11 258 1991','+94 11 236 8165',NULL,1,1,'2026-07-10 10:30:07','2026-07-10 10:30:07'),(20,'division',NULL,7,'Information Officer','Ms. H.W.L.S. Amarasiri','Senior Assistant Secretary (Administration)','sas.admin@labourmin.gov.lk','+94 11 236 9367','+94 11 236 8165',NULL,2,1,'2026-07-10 10:30:07','2026-07-10 10:30:07'),(21,'division',NULL,7,'Central Officer','Mr. Vasantha Perera','Secretary','secretary@labourmin.gov.lk','+94 11 258 1991','+94 11 258 1991',NULL,3,1,'2026-07-10 10:30:07','2026-07-10 10:30:07');
/*!40000 ALTER TABLE `officials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procurements`
--

DROP TABLE IF EXISTS `procurements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `procurements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'Notice',
  `description` text DEFAULT NULL,
  `pdf_path` varchar(255) NOT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procurements`
--

LOCK TABLES `procurements` WRITE;
/*!40000 ALTER TABLE `procurements` DISABLE KEYS */;
INSERT INTO `procurements` VALUES (1,'Supply of Office Computers','Notice','Tender for the supply of 50 office computers.','uploads/procurements/procurement_1.pdf','Published','2026-06-30 04:10:00','2026-06-30 04:10:00'),(2,'Renovation of Training Center','Notice','Procurement for the renovation of the national training center.','uploads/procurements/procurement_1.pdf','Published','2026-06-30 04:15:00','2026-06-30 04:15:00');
/*!40000 ALTER TABLE `procurements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `pdf_path` varchar(255) NOT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publications`
--

LOCK TABLES `publications` WRITE;
/*!40000 ALTER TABLE `publications` DISABLE KEYS */;
/*!40000 ALTER TABLE `publications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `special_notices`
--

DROP TABLE IF EXISTS `special_notices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `special_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `pdf_path` varchar(255) DEFAULT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `special_notices`
--

LOCK TABLES `special_notices` WRITE;
/*!40000 ALTER TABLE `special_notices` DISABLE KEYS */;
/*!40000 ALTER TABLE `special_notices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistics`
--

DROP TABLE IF EXISTS `statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stat_key` varchar(50) NOT NULL,
  `stat_label` varchar(100) NOT NULL,
  `stat_value` varchar(50) NOT NULL,
  `stat_suffix` varchar(10) DEFAULT '',
  `display_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stat_key` (`stat_key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statistics`
--

LOCK TABLES `statistics` WRITE;
/*!40000 ALTER TABLE `statistics` DISABLE KEYS */;
INSERT INTO `statistics` VALUES (1,'ilo_conventions','ILO Ratified Conventions','44','',1),(2,'labour_acts','Labour Acts Enforced','32','+',2),(3,'affiliated_institutions','Affiliated Institutions','5','',3),(4,'total_visitors','Total Visitors','1250','',4);
/*!40000 ALTER TABLE `statistics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacancies`
--

DROP TABLE IF EXISTS `vacancies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vacancies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `pdf_path` varchar(255) NOT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacancies`
--

LOCK TABLES `vacancies` WRITE;
/*!40000 ALTER TABLE `vacancies` DISABLE KEYS */;
INSERT INTO `vacancies` VALUES (1,'ILO Conventions Consultant','Consultancy opportunity for ILO conventions.','uploads/vacancies/vacancy_1.pdf','Published','2026-06-30 04:00:00','2026-06-30 04:00:00'),(2,'Legal Draftsman Vacancy','Vacancy for a legal draftsman in the labor ministry.','uploads/vacancies/vacancy_1.pdf','Published','2026-06-30 04:05:00','2026-06-30 04:05:00');
/*!40000 ALTER TABLE `vacancies` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-10 16:01:16

--
-- Table structure for table ction_plans
--

DROP TABLE IF EXISTS ction_plans;
CREATE TABLE ction_plans (
  id int(11) NOT NULL AUTO_INCREMENT,
  	itle text NOT NULL,
  description text DEFAULT NULL,
  pdf_path varchar(255) DEFAULT NULL,
  status enum('Published','Draft') NOT NULL DEFAULT 'Published',
  created_at timestamp NULL DEFAULT current_timestamp(),
  updated_at timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table ti_reports
--

DROP TABLE IF EXISTS ti_reports;
CREATE TABLE ti_reports (
  id int(11) NOT NULL AUTO_INCREMENT,
  	itle text NOT NULL,
  description text DEFAULT NULL,
  pdf_path varchar(255) DEFAULT NULL,
  status enum('Published','Draft') NOT NULL DEFAULT 'Published',
  created_at timestamp NULL DEFAULT current_timestamp(),
  updated_at timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


