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
  `phone` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `no_of_rooms` int(11) NOT NULL DEFAULT 1,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `divisions`
--

LOCK TABLES `divisions` WRITE;
/*!40000 ALTER TABLE `divisions` DISABLE KEYS */;
INSERT INTO `divisions` VALUES (1,'administration','Administration',1),(2,'development','Development',2),(3,'planning','Planning',3),(4,'finance','Finance',4),(5,'internal-audit','Internal Audit',5),(6,'foreign-relations','Foreign Relations',6);
/*!40000 ALTER TABLE `divisions` ENABLE KEYS */;
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
INSERT INTO `news` VALUES (1,'38 New Labour Officers Receive Appointment Letters','α╢▒α╖Ç α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢▒α╖Æα╢╜α╢░α╖Åα╢╗α╖ôα╢▒α╖è 38 α╢»α╖Öα╢▒α╖Öα╢Üα╖öα╢º α╢┤α╢¡α╖èα╖Çα╖ôα╢╕α╖è α╢╜α╖Æα╢┤α╖Æ α╢╜α╖Éα╢╢α╖Ü','38 α«¬α»üα«ñα«┐α«» α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«àα«▓α»üα«╡α«▓α«░α»ìα«òα«│α»ì α«¿α«┐α«»α««α«⌐α«òα»ì α«òα«ƒα«┐α«ñα«Öα»ìα«òα«│α»êα«¬α»ì α«¬α»åα«▒α»üα«òα«┐α«⌐α»ìα«▒α«⌐α«░α»ì','Media',NULL,'Appointment letters were presented to 38 newly recruited Labour Officers at a ceremony held on the morning of 16 February at the Labour Ministry Auditorium, Mehewara Piyasa Building, Narahenpita.\r\n\r\nThe event was held under the patronage of the Minister of Labour, Dr. Anil Jayantha Fernando, and the Deputy Minister of Labour, Mr. Mahinda Jayasinghe.\r\n\r\nThe newly appointed officers will undergo a comprehensive training programme comprising three months of institutional training followed by one month of field duty training at the National Institute of Labour Studies, functioning under the Ministry of Labour. The programme is designed to equip them with the necessary knowledge and practical exposure to effectively carry out their responsibilities in the field of labour administration and regulation.\r\n\r\nThe Secretary to the Ministry of Labour, Mr. S.M. Piyatissa, and the Commissioner General of Labour, Mrs. Nadeeka Wataliyadda, were also present at the ceremony, along with several senior officials of the Ministry.\r\n\r\nThe appointment of these officers marks a significant step towards further strengthening the labour administration framework and enhancing service delivery across the country.','α╢┤α╖Öα╢╢α╢╗α╖Çα╖Åα╢╗α╖Æ 16 α╖Çα╖Éα╢▒α╖Æ α╢»α╖Æα╢▒ α╢┤α╖Öα╢╗α╖Çα╢╗α╖öα╖Çα╖Ü α╢▒α╖Åα╢╗α╖Åα╖äα╖Üα╢▒α╖èα╢┤α╖Æα╢º α╢╕α╖Öα╖äα╖Öα╖Çα╢╗ α╢┤α╖Æα╢║α╖â α╢£α╖£α╢⌐α╢▒α╖Éα╢£α╖Æα╢╜α╖èα╢╜α╖Ü α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢àα╢╕α╖Åα╢¡α╖èα╢║α╖Åα╢éα╖ü α╖üα╖èα╢╗α╖Çα╢½α╖Åα╢£α╖Åα╢╗α╢║α╖Üα╢»α╖ô α╢┤α╖Éα╖Çα╖Éα╢¡α╖Æ α╢ïα╢¡α╖èα╖âα╖Çα╢║α╢Üα╢»α╖ô α╢àα╢╜α╖öα╢¡α╖Æα╢▒α╖è α╢╢α╢│α╖Çα╖Åα╢£α╢¡α╖è α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢▒α╖Æα╢╜α╢░α╖Åα╢╗α╖ôα╢▒α╖è 38 α╢»α╖Öα╢▒α╢Üα╖ö α╖âα╢│α╖äα╖Å α╢┤α╢¡α╖èα╖Çα╖ôα╢╕α╖è α╢╜α╖Æα╢┤α╖Æ α╢┤α╖èα╢╗α╢»α╖Åα╢▒α╢║ α╢Üα╖Öα╢╗α╖Æα╢½α╖Æ.\r\n\r\nα╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢àα╢╕α╖Åα╢¡α╖èα╢║ α╢åα╢áα╖Åα╢╗α╖èα╢║ α╢àα╢▒α╖Æα╢╜α╖è α╢óα╢║α╢▒α╖èα╢¡ α╢┤α╖èα╢╗α╢▒α╖Åα╢▒α╖èα╢»α╖ö α╢╕α╖äα╢¡α╖Åα╢£α╖Ü α╖âα╖ä α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢▒α╖Æα╢║α╖¥α╢óα╖èα╢║ α╢àα╢╕α╖Åα╢¡α╖èα╢║ α╢╕α╖äα╖Æα╢▒α╖èα╢» α╢óα╢║α╖âα╖Æα╢éα╖ä α╢╕α╖äα╢¡α╖Åα╢£α╖Ü α╢┤α╖èα╢╗α╢░α╖Åα╢▒α╢¡α╖èα╖Çα╢║α╖Öα╢▒α╖è α╢╕α╖Öα╢╕ α╢ïα╢¡α╖èα╖âα╖Çα╢║ α╢┤α╖Éα╖Çα╖Éα╢¡α╖èα╖Çα╖Æα╢½α╖Æ.\r\n\r\nα╢àα╢╜α╖öα╢¡α╖Æα╢▒α╖è α╢┤α╢¡α╖è α╢Üα╢╗α╢▒ α╢╜α╢» α╢▒α╖Æα╢╜α╢░α╖Åα╢╗α╖ôα╢▒α╖è α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢àα╢╕α╖Åα╢¡α╖èα╢║α╖Åα╢éα╖üα╢║ α╢║α╢ºα╢¡α╖Ü α╢Üα╖èα╢╗α╖Æα╢║α╖Åα╢¡α╖èα╢╕α╢Ü α╖Çα╢▒  α╢óα╖Åα╢¡α╖Æα╢Ü α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢àα╢░α╖èα╢║α╢║α╢▒ α╢åα╢║α╢¡α╢▒α╢║α╖Ü α╢╕α╖Åα╖â α╢¡α╖öα╢▒α╢Ü α╢åα╢║α╢¡α╢▒α╖Æα╢Ü α╢┤α╖öα╖äα╖öα╢½α╖öα╖Çα╢Üα╖Æα╢▒α╖è α╢┤α╖âα╖öα╖Ç α╢╕α╖Åα╖âα╢║α╢Ü α╢Üα╖èα╖éα╖Üα╢¡α╖èα╢╗ α╢╗α╖Åα╢óα╢Üα╖Åα╢╗α╖Æ α╢┤α╖öα╖äα╖öα╢½α╖öα╖Çα╢Üα╖Æα╢▒α╖è α╖âα╢╕α╢▒α╖èα╖Çα╖Æα╢¡ α╖Çα╖Æα╖âα╖èα╢¡α╖ôα╢╗α╢½ α╢┤α╖öα╖äα╖öα╢½α╖ö α╖Çα╖Éα╢⌐α╖âα╢ºα╖äα╢▒α╢Üα╢º α╢╖α╖Åα╢óα╢▒α╢║ α╖Çα╢▒α╖ö α╢çα╢¡. α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢┤α╢╗α╖Æα╢┤α╖Åα╢╜α╢▒α╢║ α╖âα╖ä α╢▒α╖Æα╢║α╖Åα╢╕α╢▒ α╢Üα╖èα╖éα╖Üα╢¡α╖èα╢╗α╢║α╖Ü α╢öα╖Çα╖öα╢▒α╖èα╢£α╖Ü α╖Çα╢£α╢Üα╖ôα╢╕α╖è α╢╡α╢╜α╢»α╖Åα╢║α╖ô α╢╜α╖Öα╖â α╢ëα╢ºα╖ö α╢Üα╖Æα╢╗α╖ôα╢╕ α╖âα╢│α╖äα╖Å α╢àα╖Çα╖üα╖èα╢║ α╢»α╖Éα╢▒α╖öα╢╕ α╖âα╖ä α╢┤α╖èα╢╗α╖Åα╢║α╖¥α╢£α╖Æα╢Ü α╢▒α╖Æα╢╗α╖Åα╖Çα╢╗α╢½α╢║α╖Öα╢▒α╖è α╢öα╖Çα╖öα╢▒α╖è α╖âα╢▒α╖èα╢▒α╢»α╖èα╢░ α╢Üα╖Æα╢╗α╖ôα╢╕ α╖âα╢│α╖äα╖Å α╢╕α╖Öα╢╕ α╖Çα╖Éα╢⌐α╖âα╢ºα╖äα╢▒ α╖âα╖Éα╢╜α╖âα╖öα╢╕α╖è α╢Üα╢╗ α╢çα╢¡.\r\n\r\nα╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢àα╢╕α╖Åα╢¡α╖èα╢║α╖Åα╢éα╖üα╢║α╖Ü α╢╜α╖Üα╢Üα╢╕α╖è α╢æα╖âα╖è.α╢æα╢╕α╖è. α╢┤α╖Æα╢║α╢¡α╖Æα╖âα╖èα╖â, α╖âα╖ä α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢Üα╖£α╢╕α╖âα╖Åα╢╗α╖Æα╖âα╖è α╢óα╢▒α╢╗α╖Åα╢╜α╖è α╢▒α╢»α╖ôα╢Üα╖Å α╖Çα╢ºα╢╜α╖Æα╢║α╢»α╖èα╢» α╢╕α╖äα╢¡α╖èα╢╕α╖Æα╢║ α╢», α╢àα╢╕α╖Åα╢¡α╖èα╢║α╖Åα╢éα╖üα╢║α╖Ü α╢óα╖èα╢║α╖Öα╖éα╖èα╢¿ α╢▒α╖Æα╢╜α╢░α╖Åα╢╗α╖ôα╢▒α╖è α╢Üα╖Æα╖äα╖Æα╢┤ α╢»α╖Öα╢▒α╖Öα╢Üα╖ö α╢» α╢╕α╖Öα╢╕ α╢ïα╢¡α╖èα╖âα╖Çα╢║α╢º α╢æα╢Üα╖èα╖Ç α╖âα╖Æα╢ºα╖Æα╢║α╖ä.\r\n\r\nα╢╕α╖Öα╢╕ α╢▒α╖Æα╢╜α╢░α╖Åα╢╗α╖ôα╢▒α╖è α╢┤α╢¡α╖è α╢Üα╖Æα╢╗α╖ôα╢╕ α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢┤α╢╗α╖Æα╢┤α╖Åα╢╜α╢▒ α╢╗α╖Åα╢╕α╖öα╖Ç α╢¡α╖Çα╢»α╖öα╢╗α╢ºα╢¡α╖è α╖üα╢Üα╖èα╢¡α╖Æα╢╕α╢¡α╖è α╢Üα╖Æα╢╗α╖ôα╢╕ α╖âα╖ä α╢╗α╢º α╢┤α╖öα╢╗α╖Å α╖âα╖Üα╖Çα╖Å α╖âα╖Éα╢┤α╢║α╖ôα╢╕ α╢ëα╖äα╖à α╢▒α╖Éα╢éα╖Çα╖ôα╢╕ α╖âα╢│α╖äα╖Å α╖Çα╖Éα╢»α╢£α╢¡α╖è α╢┤α╖Æα╢║α╖Çα╢╗α╢Üα╖è α╖âα╢▒α╖Æα╢ºα╖öα╖äα╢▒α╖è α╢Üα╢╗α╢║α╖Æ.','α«¿α«╛α«░α«╣α»çα«⌐α»ìα«¬α«┐α«ƒα»ìα«ƒα«┐, α««α»åα«╣α»çα«╡α«░ α«¬α«┐α«»α«Ü α«òα«ƒα»ìα«ƒα«┐α«ƒα«ñα»ìα«ñα«┐α«▓α»ì α«ëα«│α»ìα«│ α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«àα««α»êα«Üα»ìα«Üα«┐α«⌐α»ì α«òα»çα«ƒα»ìα«¬α»ïα«░α»ì α«òα»éα«ƒα«ñα»ìα«ñα«┐α«▓α»ì α«òα«ƒα«¿α»ìα«ñ α«¬α»åα«¬α»ìα«░α«╡α«░α«┐ 16 α«åα««α»ì α«ñα«┐α«òα«ñα«┐ α«òα«╛α«▓α»ê α«çα«ƒα««α»ìα«¬α»åα«▒α»ìα«▒ α«¿α«┐α«òα«┤α»ìα«╡α«┐α«▓α»ì α«¬α»üα«ñα«┐α«ñα«╛α«ò α«Üα»çα«░α»ìα«ñα»ìα«ñα»üα«òα»ìα«òα»èα«│α»ìα«│α«¬α»ìα«¬α«ƒα»ìα«ƒ 38 α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«ëα«ñα»ìα«ñα«┐α«»α»ïα«òα«ñα»ìα«ñα«░α»ìα«òα«│α»üα«òα»ìα«òα«╛α«⌐ α«¿α«┐α«»α««α«⌐α«òα»ì α«òα«ƒα«┐α«ñα«Öα»ìα«òα«│α»ì α«╡α«┤α«Öα»ìα«òα«┐ α«╡α»êα«òα»ìα«òα«¬α»ìα«¬α«ƒα»ìα«ƒα«⌐.\r\n\r\nα«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«àα««α»êα«Üα»ìα«Üα«░α»ì α«ƒα»èα«òα»ìα«ƒα«░α»ì α«àα«⌐α«┐α«▓α»ì α«£α«»α«¿α»ìα«ñ α«¬α»åα«░α»ìα«⌐α«╛α«úα»ìα«ƒα»ï α««α«▒α»ìα«▒α»üα««α»ì α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«¬α«┐α«░α«ñα«┐ α«àα««α»êα«Üα»ìα«Üα«░α»ì α«ñα«┐α«░α»ü α««α«╣α«┐α«¿α»ìα«ñ α«£α«»α«Üα«┐α«Öα»ìα«ò α«åα«òα«┐α«»α»ïα«░α«┐α«⌐α»ì α«ñα«▓α»êα««α»êα«»α«┐α«▓α»ì α«çα«¿α»ìα«ñ α«¿α«┐α«òα«┤α»ìα«╡α»ü α«çα«ƒα««α»ìα«¬α»åα«▒α»ìα«▒α«ñα»ü.\r\n\r\nα«¬α»üα«ñα«┐α«ñα«╛α«ò α«¿α«┐α«»α««α«┐α«òα»ìα«òα«¬α»ìα«¬α«ƒα»ìα«ƒα»üα«│α»ìα«│ α«àα«ñα«┐α«òα«╛α«░α«┐α«òα«│α»ì, α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«àα««α»êα«Üα»ìα«Üα«òα«ñα»ìα«ñα«┐α«⌐α»ì α«òα»Çα«┤α»ì α«Üα»åα«»α«▓α»ìα«¬α«ƒα»üα««α»ì α«ñα»çα«Üα«┐α«» α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«åα«»α»ìα«╡α»üα«òα»ì α«òα«┤α«òα«ñα»ìα«ñα«┐α«▓α»ì α««α»éα«⌐α»ìα«▒α»ü α««α«╛α«ñ α«¿α«┐α«▒α»üα«╡α«⌐α«¬α»ì α«¬α«»α«┐α«▒α»ìα«Üα«┐α«»α»êα«»α»üα««α»ì α«àα«ñα«⌐α»ìα«¬α«┐α«⌐α»ì α«Æα«░α»ü α««α«╛α«ñ α«òα«│α«¬α»ìα«¬α«úα«┐α«¬α»ì α«¬α«»α«┐α«▒α»ìα«Üα«┐α«»α»êα«»α»üα««α»ì α«ëα«│α»ìα«│α«ƒα«òα»ìα«òα«┐α«» α«╡α«┐α«░α«┐α«╡α«╛α«⌐ α«¬α«»α«┐α«▒α»ìα«Üα«┐α«ñα»ì α«ñα«┐α«ƒα»ìα«ƒα«ñα»ìα«ñα«┐α«▓α»ì α«êα«ƒα»üα«¬α«ƒα»üα«╡α«╛α«░α»ìα«òα«│α»ì. α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«¿α«┐α«░α»ìα«╡α«╛α«òα««α»ì α««α«▒α»ìα«▒α»üα««α»ì α«Æα«┤α»üα«Öα»ìα«òα»üα««α»üα«▒α»êα«ñα»ì α«ñα»üα«▒α»êα«»α«┐α«▓α»ì α«àα«╡α«░α»ìα«òα«│α«┐α«⌐α»ì α«¬α»èα«▒α»üα«¬α»ìα«¬α»üα«òα«│α»ê α«ñα«┐α«▒α««α»ìα«¬α«ƒ α«Üα»åα«»α«▓α»ìα«¬α«ƒα»üα«ñα»ìα«ñ α«ñα»çα«╡α»êα«»α«╛α«⌐ α«àα«▒α«┐α«╡α»ü α««α«▒α»ìα«▒α»üα««α»ì α«¿α«ƒα»êα««α»üα«▒α»ê α«╡α»åα«│α«┐α«¬α»ìα«¬α«╛α«ƒα»üα«òα«│α»üα«ƒα«⌐α»ì α«àα«╡α«░α»ìα«òα«│α»ê α«Üα«┐α«ñα»ìα«ñα«¬α»ìα«¬α«ƒα»üα«ñα»ìα«ñα»üα«╡α«ñα«▒α»ìα«òα«╛α«ò α«çα«¿α»ìα«ñ α«ñα«┐α«ƒα»ìα«ƒα««α»ì α«╡α«ƒα«┐α«╡α««α»êα«òα»ìα«òα«¬α»ìα«¬α«ƒα»ìα«ƒα»üα«│α»ìα«│α«ñα»ü.\r\n\r\nα«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«àα««α»êα«Üα»ìα«Üα«┐α«⌐α»ì α«Üα»åα«»α«▓α«╛α«│α«░α»ì α«ñα«┐α«░α»ü. α«Äα«╕α»ì.α«Äα««α»ì. α«¬α«┐α«»α«ñα«┐α«╕α»ìα«╕, α««α«▒α»ìα«▒α»üα««α»ì α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«åα«úα»êα«»α«╛α«│α«░α»ì α«¿α«╛α«»α«òα««α»ì α«ñα«┐α«░α»üα««α«ñα«┐ α«¿α«ñα»Çα«òα«╛ α«╡α«ñα»ìα«ñα«▓α«┐α«»α«ñα»ìα«ñ α«àα«╡α«░α»ìα«òα«│α»üα««α»ì, α«àα««α»êα«Üα»ìα«Üα«┐α«⌐α»ì α«Üα«┐α«░α»çα«╖α»ìα«ƒ α«àα«ñα«┐α«òα«╛α«░α«┐α«òα«│α»ì α«¬α«▓α«░α»üα««α»ì α«çα«╡α»ìα«╡α«┐α«┤α«╛α«╡α«┐α«▓α»ì α«òα«▓α«¿α»ìα«ñα»üα«òα»èα«úα»ìα«ƒα«⌐α«░α»ì.\r\n\r\nα«çα«¿α»ìα«ñ α«àα«ñα«┐α«òα«╛α«░α«┐α«òα«│α«┐α«⌐α»ì α«¿α«┐α«»α««α«⌐α««α»ì, α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«¿α«┐α«░α»ìα«╡α«╛α«òα«òα»ì α«òα«ƒα»ìα«ƒα««α»êα«¬α»ìα«¬α»ê α««α»çα«▓α»üα««α»ì α«╡α«▓α»üα«¬α»ìα«¬α«ƒα»üα«ñα»ìα«ñα»üα«╡α«ñα«▒α»ìα«òα»üα««α»ì, α«¿α«╛α«ƒα»ü α««α»üα«┤α»üα«╡α«ñα»üα««α»ì α«Üα»çα«╡α»ê α«╡α«┤α«Öα»ìα«òα«▓α»ê α««α»çα««α»ìα«¬α«ƒα»üα«ñα»ìα«ñα»üα«╡α«ñα«▒α»ìα«òα»üα««α»ì α«Æα«░α»ü α«òα»üα«▒α«┐α«¬α»ìα«¬α«┐α«ƒα«ñα»ìα«ñα«òα»ìα«ò α«¬α«ƒα«┐α«»α»êα«òα»ì α«òα»üα«▒α«┐α«òα»ìα«òα«┐α«▒α«ñα»ü.','uploads/news/2026/06/gallery-1-e866c.webp',NULL,'english','public',0,0,'Published',2,'2026-06-05 06:34:59','2026-06-05 09:47:38'),(2,'The committee approved by the Cabinet to amend the labour laws is consulting the National Labour Advisory Council (NLAC).','α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢▒α╖ôα╢¡α╖Æ α╖âα╢éα╖üα╖¥α╢░α╢▒α╢║ α╢Üα╖Æα╢╗α╖ôα╢╕ α╖âα╢│α╖äα╖Å α╢Üα╖Éα╢╢α╖Æα╢▒α╢ºα╖è α╢╕α╢½α╖èα╢⌐α╢╜α╢║ α╖Çα╖Æα╖âα╖Æα╢▒α╖è α╢àα╢▒α╖öα╢╕α╢¡ α╢Üα╢╗α╢▒ α╢╜α╢» α╢Üα╢╕α╖Æα╢ºα╖öα╖Ç α╢óα╖Åα╢¡α╖Æα╢Ü α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢ïα╢┤α╢»α╖Üα╖üα╢Ü α╖âα╢╖α╖Åα╖Çα╖Ü (NLAC) α╢ïα╢┤α╢»α╖Öα╖âα╖è α╢╜α╢╢α╖Å α╢£α╢▒α╖ô.','α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«Üα«ƒα»ìα«ƒα«Öα»ìα«òα«│α»êα«ñα»ì α«ñα«┐α«░α»üα«ñα»ìα«ñα»üα«╡α«ñα«▒α»ìα«òα»ü α«àα««α»êα«Üα»ìα«Üα«░α«╡α»êα«»α«╛α«▓α»ì α«àα«Öα»ìα«òα»Çα«òα«░α«┐α«òα»ìα«òα«¬α»ìα«¬α«ƒα»ìα«ƒ α«òα»üα«┤α»ü α«ñα»çα«Üα«┐α«» α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«åα«▓α»ïα«Üα«⌐α»êα«òα»ì α«òα»üα«┤α»üα«╡α«┐α«⌐α»ì (NLAC) α«åα«▓α»ïα«Üα«⌐α»êα«»α»ê α««α»çα«▒α»ìα«òα»èα«úα»ìα«ƒα»ü α«╡α«░α»üα«òα«┐α«▒α«ñα»ü.','Media',NULL,'The ceremony organized to mark the commencement of the Ministry of Labor and its subordinate institutions for the year 2026 was held this morning (01) at the Narahenpita','2026 α╖Çα╖âα╢╗ α╖âα╢│α╖äα╖Å α╢Üα╢╕α╖èα╢Üα╢╗α╖ö α╢àα╢╕α╖Åα╢¡α╖èα╢║α╖Åα╢éα╖üα╢║ α╖âα╖ä α╢èα╢º α╢àα╢▒α╖öα╢╢α╢»α╖èα╢░ α╢åα╢║α╢¡α╢▒ α╢åα╢╗α╢╕α╖èα╢╖ α╢Üα╖Æα╢╗α╖ôα╢╕ α╢▒α╖Æα╢╕α╖Æα╢¡α╖èα╢¡α╖Öα╢▒α╖è α╖âα╢éα╖Çα╖Æα╢░α╖Åα╢▒α╢║ α╢Üα╖à α╢ïα╢¡α╖èα╖âα╖Çα╢║ α╢àα╢» (01) α╢┤α╖Öα╢╗α╖Çα╢╗α╖öα╖Çα╖Ü α╢▒α╖Åα╢╗α╖Åα╖äα╖Üα╢▒α╖èα╢┤α╖Æα╢º α╢»α╖ô α╢┤α╖Éα╖Çα╖Éα╢¡α╖èα╖Çα╖Æα╢½α╖Æ.','2026 α«åα««α»ì α«åα«úα»ìα«ƒα«┐α«▒α»ìα«òα«╛α«⌐ α«ñα»èα«┤α«┐α«▓α«╛α«│α«░α»ì α«àα««α»êα«Üα»ìα«Üα»ü α««α«▒α»ìα«▒α»üα««α»ì α«àα«ñα«⌐α»ì α«òα»Çα«┤α»ì α«çα«»α«Öα»ìα«òα»üα««α»ì α«¿α«┐α«▒α»üα«╡α«⌐α«Öα»ìα«òα«│α«┐α«⌐α»ì α«åα«░α««α»ìα«¬α«ñα»ìα«ñα»ê α««α»üα«⌐α»ìα«⌐α«┐α«ƒα»ìα«ƒα»ü α«Åα«▒α»ìα«¬α«╛α«ƒα»ü α«Üα»åα«»α»ìα«»α«¬α»ìα«¬α«ƒα»ìα«ƒ α«╡α»êα«¬α«╡α««α»ì α«çα«⌐α»ìα«▒α»ü (01) α«òα«╛α«▓α»ê α«¿α«╛α«░α«╣α»çα«⌐α»ìα«¬α«┐α«ƒα»ìα«ƒα«┐α«»α«┐α«▓α»ì α«¿α«ƒα»êα«¬α»åα«▒α»ìα«▒α«ñα»ü.','uploads/news/2026/06/cabinet-a918e.jpg',NULL,'english','public',0,0,'Published',2,'2026-06-05 06:38:05','2026-06-05 09:47:30'),(3,'Press release on private sector salary increase.','α╢┤α╖₧α╢»α╖èα╢£α╢╜α╖Æα╢Ü α╢àα╢éα╖üα╢║α╖Ü α╖Çα╖Éα╢ºα╖öα╢┤α╖è α╖Çα╖Éα╢⌐α╖Æα╖Çα╖ôα╢╕ α╢┤α╖Æα╖àα╖Æα╢╢α╢│ α╢╕α╖Åα╢░α╖èα╢║ α╢▒α╖Æα╖Çα╖Üα╢»α╢▒α╢║.','α«ñα«⌐α«┐α«»α«╛α«░α»ì α«ñα»üα«▒α»êα«»α«┐α«⌐α»ì α«Üα««α»ìα«¬α«│ α«àα«ñα«┐α«òα«░α«┐α«¬α»ìα«¬α»ü α«òα»üα«▒α«┐α«ñα»ìα«ñ α«Üα»åα«»α»ìα«ñα«┐α«òα»ìα«òα»üα«▒α«┐α«¬α»ìα«¬α»ü.','Notices',NULL,'In accordance with the provisions of the National Minimum Wage of Employees Amendment Act No. 11 of 2025, the National Minimum Wage in the private sector','2025 α╢àα╢éα╢Ü 11 α╢»α╢╗α╢▒ α╖âα╖Üα╖Çα╢Ü α╢óα╖Åα╢¡α╖Æα╢Ü α╢àα╖Çα╢╕ α╖Çα╖Éα╢ºα╖öα╢┤α╖è α╖âα╢éα╖üα╖¥α╢░α╢▒ α╢┤α╢▒α╢¡α╖Ü α╖Çα╖Æα╢░α╖Æα╖Çα╖Æα╢░α╖Åα╢▒ α╢àα╢▒α╖öα╖Ç α╢┤α╖öα╢»α╖èα╢£α╢╜α╖Æα╢Ü α╢àα╢éα╖üα╢║α╖Ü α╢óα╖Åα╢¡α╖Æα╢Ü α╢àα╖Çα╢╕ α╖Çα╖Éα╢ºα╖öα╢┤','2025 α«åα««α»ì α«åα«úα»ìα«ƒα«┐α«⌐α»ì 11 α«åα««α»ì α«Äα«úα»ì α«èα«┤α«┐α«»α«░α»ìα«òα«│α«┐α«⌐α»ì α«ñα»çα«Üα«┐α«» α«òα»üα«▒α»êα«¿α»ìα«ñα«¬α«ƒα»ìα«Ü α«èα«ñα«┐α«»α«ñα»ì α«ñα«┐α«░α»üα«ñα»ìα«ñα«Üα»ì α«Üα«ƒα»ìα«ƒα«ñα»ìα«ñα«┐α«⌐α»ì α«╡α«┐α«ñα«┐α«òα«│α«┐α«⌐α»ìα«¬α«ƒα«┐, α«ñα«⌐α«┐α«»α«╛α«░α»ì α«ñα»üα«▒α»êα«»α«┐α«▓α»ì α«ñα»çα«Üα«┐α«» α«òα»üα«▒α»êα«¿α»ìα«ñα«¬α«ƒα»ìα«Ü α«èα«ñα«┐α«»α««α»ì','uploads/news/2026/06/minister-9d429.jpg',NULL,'english','public',1,0,'Published',2,'2026-06-05 06:44:31','2026-06-05 09:47:22'),(12,'Press release on private sector salary increase.','α╢┤α╖₧α╢»α╖èα╢£α╢╜α╖Æα╢Ü α╢àα╢éα╖üα╢║α╖Ü α╖Çα╖Éα╢ºα╖öα╢┤α╖è α╖Çα╖Éα╢⌐α╖Æα╖Çα╖ôα╢╕ α╢┤α╖Æα╖àα╖Æα╢╢α╢│ α╢╕α╖Åα╢░α╖èα╢║ α╢▒α╖Æα╖Çα╖Üα╢»α╢▒α╢║.','α«ñα«⌐α«┐α«»α«╛α«░α»ì α«ñα»üα«▒α»êα«»α«┐α«⌐α»ì α«Üα««α»ìα«¬α«│ α«àα«ñα«┐α«òα«░α«┐α«¬α»ìα«¬α»ü α«òα»üα«▒α«┐α«ñα»ìα«ñ α«Üα»åα«»α»ìα«ñα«┐α«òα»ìα«òα»üα«▒α«┐α«¬α»ìα«¬α»ü.','Media',NULL,'In accordance with the provisions of the National Minimum Wage of Employees Amendment Act No. 11 of 2025, the National Minimum Wage in the private sector,...Read More','2025 α╢àα╢éα╢Ü 11 α╢»α╢╗α╢▒ α╖âα╖Üα╖Çα╢Ü α╢óα╖Åα╢¡α╖Æα╢Ü α╢àα╖Çα╢╕ α╖Çα╖Éα╢ºα╖öα╢┤α╖è α╖âα╢éα╖üα╖¥α╢░α╢▒ α╢┤α╢▒α╢¡α╖Ü α╖Çα╖Æα╢░α╖Æα╖Çα╖Æα╢░α╖Åα╢▒ α╢àα╢▒α╖öα╖Ç α╢┤α╖₧α╢»α╖èα╢£α╢╜α╖Æα╢Ü α╢àα╢éα╖üα╢║α╖Ü α╢óα╖Åα╢¡α╖Æα╢Ü α╢àα╖Çα╢╕ α╖Çα╖Éα╢ºα╖öα╢┤α╖è,...Read More','2025 α«åα««α»ì α«åα«úα»ìα«ƒα«┐α«⌐α»ì 11 α«åα««α»ì α«Äα«úα»ì α«èα«┤α«┐α«»α«░α»ìα«òα«│α«┐α«⌐α»ì α«ñα»çα«Üα«┐α«» α«òα»üα«▒α»êα«¿α»ìα«ñα«¬α«ƒα»ìα«Ü α«èα«ñα«┐α«»α«ñα»ì α«ñα«┐α«░α»üα«ñα»ìα«ñα«Üα»ì α«Üα«ƒα»ìα«ƒα«ñα»ìα«ñα«┐α«⌐α»ì α«╡α«┐α«ñα«┐α«òα«│α«┐α«⌐α»ìα«¬α«ƒα«┐, α«ñα«⌐α«┐α«»α«╛α«░α»ì α«ñα»üα«▒α»êα«»α«┐α«▓α»ì α«ñα»çα«Üα«┐α«» α«òα»üα«▒α»êα«¿α»ìα«ñα«¬α«ƒα»ìα«Ü α«èα«ñα«┐α«»α««α»ì,...α««α»çα«▓α»üα««α»ì α«¬α«ƒα«┐α«òα»ìα«ò','uploads/news/2026/06/appointment-letters-64c23.jpg',NULL,'english','public',0,0,'Published',1,'2026-06-10 04:56:44','2026-06-10 04:56:44');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officials`
--

LOCK TABLES `officials` WRITE;
/*!40000 ALTER TABLE `officials` DISABLE KEYS */;
INSERT INTO `officials` VALUES (1,'top','minister',NULL,'Hon. Minister of Labour','Hon. Minister Anil Jayantha Fernando','','minister@labourmin.gov.lk','+94 (0)112 368175','+94 (0)112 588950','admin/uploads/officials/minister-anil-jayantha-fernando.webp',1,1,'2026-06-09 10:35:01','2026-06-09 11:18:37'),(2,'top','deputy_minister',NULL,'Hon. Deputy Minister of Labour','Mr. Mahinda Jayasinghe','','majayasinghe@gmail.com','+94 (0)112 368526','+94 (0)112 369340','admin/uploads/officials/deputy-minister-mahinda-jayasinghe.webp',2,1,'2026-06-09 10:35:01','2026-06-09 11:19:31'),(3,'top','secretary',NULL,'Secretary','Mr. S.M.Piyatissa',NULL,'slmol@slt.lk','+94 (0)112 368164','+94 (0)112 582938','admin/uploads/officials/secretary-sm-piyatissa.webp',3,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(4,'division',NULL,1,'Additional Secretary (Administration)','Ms. T P Muditha Pathmajay','Additional Secretary (Development)','mpathmajay@gmail.com','0718123025','+94 (0)112 368165','admin/uploads/officials/admin-muditha-pathmajay.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:54:45'),(5,'division',NULL,1,'Senior Assistant Secretary (Administration)','Mr. L.T.G.D Darshana','Senior Assistant Secretary (Administration)','sas.admin@labourmin.gov.lk','+94 (0)112 368304','+94 (0)112 368200','admin/uploads/officials/admin-darshana-ltgd.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:54:45'),(6,'division',NULL,1,'Assistant Secretary (Procurement)','Ms. S Luxiga','Assistant Secretary (Administration)','skluxi@gmail.com','0779265869','','admin/uploads/officials/admin-luxiga-s.webp',3,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(7,'division',NULL,1,'Assistant Secretary (Establishment)','Ms. Yashoda Thissera','Assistant Secretary (Establishment)','as.est@labourmin.gov.lk','+94 (0) 112 368264','','admin/uploads/officials/admin-yashoda-thissera.webp',4,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(8,'division',NULL,1,'Legal Officer','Ms. W P A G Wijesooriya','Legal Officer','gayaniew1@gmail.com','0763526589','','admin/uploads/officials/admin-wijesooriya-wpag.webp',5,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(9,'division',NULL,2,'Additional Secretary (Development)','Mr. Lal Samarasekara','Additional Secretary (Development)','adsec.dev@labourmin.gov.lk','+94 (0)112 586337','+94 (0)112 589267','admin/uploads/officials/dev-lal-samarasekara.webp',1,1,'2026-06-09 10:35:01','2026-06-09 16:39:31'),(10,'division',NULL,2,'Director (Development)','Mr. P D Chandana Pathirage','Director (Development)','pstchandana@gmail.com','0713373538','','admin/uploads/officials/dev-chandana-pathirage.webp',2,1,'2026-06-09 10:35:01','2026-06-09 16:39:31'),(11,'division',NULL,3,'Director General (Planning)','Ms. I V N Preethika Kumuduni','Director General (Planning)','','+94 (0)112 368594','','admin/uploads/officials/planning-preethika-kumuduni.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(12,'division',NULL,3,'Deputy Director (Planning)','Ms. M.P.D.C.W.Kumari','Deputy Director (Planning)','kuma_lg@yahoo.com','0716897218','','admin/uploads/officials/planning-kumari-mpdcw.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(13,'division',NULL,4,'Chief Finance Officer','Mrs. G.C.N. Fonseka','Chief Finance Officer','','+94 (0)112 505161','','admin/uploads/officials/finance-fonseka-gcn.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(14,'division',NULL,4,'Chief Accountant','Ms. S S Shiroma Nandani','Chief Accountant','shiromanandani@yahoo.com','0752261785','+94 (0)112 368204','admin/uploads/officials/finance-nandani-shiroma.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(15,'division',NULL,5,'Chief Internal Auditor','Mrs. A.M.M.K. Abeysinghe','Chief Internal Auditor','cia@labourmin.gov.lk','+94 (0)112 369422','','admin/uploads/officials/internal-audit-abeysinghe-ammk.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(16,'division',NULL,6,'Senior Assistant Secretary (Foreign Relations)','Mr. B Vasanthan','Senior Assistant Secretary (Foreign Relations)','bvasanthan@yahoo.com','0718249902','+94 (0)112 368609','admin/uploads/officials/foreign-relations-vasanthan-b.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(17,'division',NULL,6,'Assistant Secretary (FR)','Mrs. M.N.H.Peiris','Assistant Secretary (FR)','as.fr@labourmin.gov.lk','+94 (0)112 504478','','admin/uploads/officials/foreign-relations-peiris-mnh.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:35:01');
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
  `description` text DEFAULT NULL,
  `pdf_path` varchar(255) NOT NULL,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procurements`
--

LOCK TABLES `procurements` WRITE;
/*!40000 ALTER TABLE `procurements` DISABLE KEYS */;
INSERT INTO `procurements` VALUES 
(1,'Supply of Office Computers','Tender for the supply of 50 office computers.','uploads/procurements/procurement_1.pdf','Published','2026-06-30 04:10:00','2026-06-30 04:10:00'),
(2,'Renovation of Training Center','Procurement for the renovation of the national training center.','uploads/procurements/procurement_1.pdf','Published','2026-06-30 04:15:00','2026-06-30 04:15:00');
/*!40000 ALTER TABLE `procurements` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacancies`
--

LOCK TABLES `vacancies` WRITE;
/*!40000 ALTER TABLE `vacancies` DISABLE KEYS */;
INSERT INTO `vacancies` VALUES 
(1,'ILO Conventions Consultant','Consultancy opportunity for ILO conventions.','uploads/vacancies/vacancy_1.pdf','Published','2026-06-30 04:00:00','2026-06-30 04:00:00'),
(2,'Legal Draftsman Vacancy','Vacancy for a legal draftsman in the labor ministry.','uploads/vacancies/vacancy_1.pdf','Published','2026-06-30 04:05:00','2026-06-30 04:05:00');
/*!40000 ALTER TABLE `vacancies` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `learning_platforms_local`
--

LOCK TABLES `learning_platforms_local` WRITE;
/*!40000 ALTER TABLE `learning_platforms_local` DISABLE KEYS */;
INSERT INTO `learning_platforms_local` VALUES 
(1,'National Vocational Training Guide','Official vocational training guidelines and syllabus.','uploads/learning_platforms/local_1.pdf','Published','2026-06-30 04:20:00','2026-06-30 04:20:00'),
(2,'Labour Laws and Regulations Handbook','Comprehensive guide to local labour laws and employee rights.','uploads/learning_platforms/local_2.pdf','Published','2026-06-30 04:22:00','2026-06-30 04:22:00');
/*!40000 ALTER TABLE `learning_platforms_local` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `learning_platforms_foreign`
--

LOCK TABLES `learning_platforms_foreign` WRITE;
/*!40000 ALTER TABLE `learning_platforms_foreign` DISABLE KEYS */;
INSERT INTO `learning_platforms_foreign` VALUES 
(1,'ILO International Labour Standards Guide','Global standards guidelines from the International Labour Organization.','uploads/learning_platforms/foreign_1.pdf','Published','2026-06-30 04:25:00','2026-06-30 04:25:00'),
(2,'Global Employment Trends Report 2026','International employment and economic trends report.','uploads/learning_platforms/foreign_2.pdf','Published','2026-06-30 04:27:00','2026-06-30 04:27:00');
/*!40000 ALTER TABLE `learning_platforms_foreign` ENABLE KEYS */;
UNLOCK TABLES;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-27 11:44:03
