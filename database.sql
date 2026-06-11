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
-- Table structure for table `article_images`
--

DROP TABLE IF EXISTS `article_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `article_images_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_images`
--

LOCK TABLES `article_images` WRITE;
/*!40000 ALTER TABLE `article_images` DISABLE KEYS */;
INSERT INTO `article_images` VALUES (1,1,'uploads/news/2026/06/gallery-2-e9d84.webp','2026-06-05 06:34:59'),(2,1,'uploads/news/2026/06/gallery-3-ead1d.webp','2026-06-05 06:34:59'),(3,1,'uploads/news/2026/06/gallery-4-ebc4e.webp','2026-06-05 06:34:59'),(4,2,'uploads/news/2026/06/minister-aabe3.jpg','2026-06-05 06:38:05'),(5,3,'uploads/news/2026/06/cabinet-9e1ac.jpg','2026-06-05 06:44:31'),(6,3,'uploads/news/2026/06/nlac-9eb01.jpg','2026-06-05 06:44:31');
/*!40000 ALTER TABLE `article_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
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
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,'38 New Labour Officers Receive Appointment Letters','නව කම්කරු නිලධාරීන් 38 දෙනෙකුට පත්වීම් ලිපි ලැබේ','38 புதிய தொழிலாளர் அலுவலர்கள் நியமனக் கடிதங்களைப் பெறுகின்றனர்','Media',NULL,'Appointment letters were presented to 38 newly recruited Labour Officers at a ceremony held on the morning of 16 February at the Labour Ministry Auditorium, Mehewara Piyasa Building, Narahenpita.\r\n\r\nThe event was held under the patronage of the Minister of Labour, Dr. Anil Jayantha Fernando, and the Deputy Minister of Labour, Mr. Mahinda Jayasinghe.\r\n\r\nThe newly appointed officers will undergo a comprehensive training programme comprising three months of institutional training followed by one month of field duty training at the National Institute of Labour Studies, functioning under the Ministry of Labour. The programme is designed to equip them with the necessary knowledge and practical exposure to effectively carry out their responsibilities in the field of labour administration and regulation.\r\n\r\nThe Secretary to the Ministry of Labour, Mr. S.M. Piyatissa, and the Commissioner General of Labour, Mrs. Nadeeka Wataliyadda, were also present at the ceremony, along with several senior officials of the Ministry.\r\n\r\nThe appointment of these officers marks a significant step towards further strengthening the labour administration framework and enhancing service delivery across the country.','පෙබරවාරි 16 වැනි දින පෙරවරුවේ නාරාහේන්පිට මෙහෙවර පියස ගොඩනැගිල්ලේ කම්කරු අමාත්යාංශ ශ්රවණාගාරයේදී පැවැති උත්සවයකදී අලුතින් බඳවාගත් කම්කරු නිලධාරීන් 38 දෙනකු සඳහා පත්වීම් ලිපි ප්රදානය කෙරිණි.\r\n\r\nකම්කරු අමාත්ය ආචාර්ය අනිල් ජයන්ත ප්රනාන්දු මහතාගේ සහ කම්කරු නියෝජ්ය අමාත්ය මහින්ද ජයසිංහ මහතාගේ ප්රධානත්වයෙන් මෙම උත්සවය පැවැත්විණි.\r\n\r\nඅලුතින් පත් කරන ලද නිලධාරීන් කම්කරු අමාත්යාංශය යටතේ ක්රියාත්මක වන  ජාතික කම්කරු අධ්යයන ආයතනයේ මාස තුනක ආයතනික පුහුණුවකින් පසුව මාසයක ක්ෂේත්ර රාජකාරි පුහුණුවකින් සමන්විත විස්තීරණ පුහුණු වැඩසටහනකට භාජනය වනු ඇත. කම්කරු පරිපාලනය සහ නියාමන ක්ෂේත්රයේ ඔවුන්ගේ වගකීම් ඵලදායී ලෙස ඉටු කිරීම සඳහා අවශ්ය දැනුම සහ ප්රායෝගික නිරාවරණයෙන් ඔවුන් සන්නද්ධ කිරීම සඳහා මෙම වැඩසටහන සැලසුම් කර ඇත.\r\n\r\nකම්කරු අමාත්යාංශයේ ලේකම් එස්.එම්. පියතිස්ස, සහ කම්කරු කොමසාරිස් ජනරාල් නදීකා වටලියද්ද මහත්මිය ද, අමාත්යාංශයේ ජ්යෙෂ්ඨ නිලධාරීන් කිහිප දෙනෙකු ද මෙම උත්සවයට එක්ව සිටියහ.\r\n\r\nමෙම නිලධාරීන් පත් කිරීම කම්කරු පරිපාලන රාමුව තවදුරටත් ශක්තිමත් කිරීම සහ රට පුරා සේවා සැපයීම ඉහළ නැංවීම සඳහා වැදගත් පියවරක් සනිටුහන් කරයි.','நாரஹேன்பிட்டி, மெஹேவர பியச கட்டிடத்தில் உள்ள தொழிலாளர் அமைச்சின் கேட்போர் கூடத்தில் கடந்த பெப்ரவரி 16 ஆம் திகதி காலை இடம்பெற்ற நிகழ்வில் புதிதாக சேர்த்துக்கொள்ளப்பட்ட 38 தொழிலாளர் உத்தியோகத்தர்களுக்கான நியமனக் கடிதங்கள் வழங்கி வைக்கப்பட்டன.\r\n\r\nதொழிலாளர் அமைச்சர் டொக்டர் அனில் ஜயந்த பெர்னாண்டோ மற்றும் தொழிலாளர் பிரதி அமைச்சர் திரு மஹிந்த ஜயசிங்க ஆகியோரின் தலைமையில் இந்த நிகழ்வு இடம்பெற்றது.\r\n\r\nபுதிதாக நியமிக்கப்பட்டுள்ள அதிகாரிகள், தொழிலாளர் அமைச்சகத்தின் கீழ் செயல்படும் தேசிய தொழிலாளர் ஆய்வுக் கழகத்தில் மூன்று மாத நிறுவனப் பயிற்சியையும் அதன்பின் ஒரு மாத களப்பணிப் பயிற்சியையும் உள்ளடக்கிய விரிவான பயிற்சித் திட்டத்தில் ஈடுபடுவார்கள். தொழிலாளர் நிர்வாகம் மற்றும் ஒழுங்குமுறைத் துறையில் அவர்களின் பொறுப்புகளை திறம்பட செயல்படுத்த தேவையான அறிவு மற்றும் நடைமுறை வெளிப்பாடுகளுடன் அவர்களை சித்தப்படுத்துவதற்காக இந்த திட்டம் வடிவமைக்கப்பட்டுள்ளது.\r\n\r\nதொழிலாளர் அமைச்சின் செயலாளர் திரு. எஸ்.எம். பியதிஸ்ஸ, மற்றும் தொழிலாளர் ஆணையாளர் நாயகம் திருமதி நதீகா வத்தலியத்த அவர்களும், அமைச்சின் சிரேஷ்ட அதிகாரிகள் பலரும் இவ்விழாவில் கலந்துகொண்டனர்.\r\n\r\nஇந்த அதிகாரிகளின் நியமனம், தொழிலாளர் நிர்வாகக் கட்டமைப்பை மேலும் வலுப்படுத்துவதற்கும், நாடு முழுவதும் சேவை வழங்கலை மேம்படுத்துவதற்கும் ஒரு குறிப்பிடத்தக்க படியைக் குறிக்கிறது.','uploads/news/2026/06/gallery-1-e866c.webp',NULL,'english','public',0,0,'Published',2,'2026-06-05 06:34:59','2026-06-05 09:47:38'),(2,'The committee approved by the Cabinet to amend the labour laws is consulting the National Labour Advisory Council (NLAC).','කම්කරු නීති සංශෝධනය කිරීම සඳහා කැබිනට් මණ්ඩලය විසින් අනුමත කරන ලද කමිටුව ජාතික කම්කරු උපදේශක සභාවේ (NLAC) උපදෙස් ලබා ගනී.','தொழிலாளர் சட்டங்களைத் திருத்துவதற்கு அமைச்சரவையால் அங்கீகரிக்கப்பட்ட குழு தேசிய தொழிலாளர் ஆலோசனைக் குழுவின் (NLAC) ஆலோசனையை மேற்கொண்டு வருகிறது.','Media',NULL,'The ceremony organized to mark the commencement of the Ministry of Labor and its subordinate institutions for the year 2026 was held this morning (01) at the Narahenpita','2026 වසර සඳහා කම්කරු අමාත්යාංශය සහ ඊට අනුබද්ධ ආයතන ආරම්භ කිරීම නිමිත්තෙන් සංවිධානය කළ උත්සවය අද (01) පෙරවරුවේ නාරාහේන්පිට දී පැවැත්විණි.','2026 ஆம் ஆண்டிற்கான தொழிலாளர் அமைச்சு மற்றும் அதன் கீழ் இயங்கும் நிறுவனங்களின் ஆரம்பத்தை முன்னிட்டு ஏற்பாடு செய்யப்பட்ட வைபவம் இன்று (01) காலை நாரஹேன்பிட்டியில் நடைபெற்றது.','uploads/news/2026/06/cabinet-a918e.jpg',NULL,'english','public',0,0,'Published',2,'2026-06-05 06:38:05','2026-06-05 09:47:30'),(3,'Press release on private sector salary increase.','පෞද්ගලික අංශයේ වැටුප් වැඩිවීම පිළිබඳ මාධ්ය නිවේදනය.','தனியார் துறையின் சம்பள அதிகரிப்பு குறித்த செய்திக்குறிப்பு.','Notices',NULL,'In accordance with the provisions of the National Minimum Wage of Employees Amendment Act No. 11 of 2025, the National Minimum Wage in the private sector','2025 අංක 11 දරන සේවක ජාතික අවම වැටුප් සංශෝධන පනතේ විධිවිධාන අනුව පුද්ගලික අංශයේ ජාතික අවම වැටුප','2025 ஆம் ஆண்டின் 11 ஆம் எண் ஊழியர்களின் தேசிய குறைந்தபட்ச ஊதியத் திருத்தச் சட்டத்தின் விதிகளின்படி, தனியார் துறையில் தேசிய குறைந்தபட்ச ஊதியம்','uploads/news/2026/06/minister-9d429.jpg',NULL,'english','public',1,0,'Published',2,'2026-06-05 06:44:31','2026-06-05 09:47:22'),(12,'Press release on private sector salary increase.','පෞද්ගලික අංශයේ වැටුප් වැඩිවීම පිළිබඳ මාධ්ය නිවේදනය.','தனியார் துறையின் சம்பள அதிகரிப்பு குறித்த செய்திக்குறிப்பு.','Media',NULL,'In accordance with the provisions of the National Minimum Wage of Employees Amendment Act No. 11 of 2025, the National Minimum Wage in the private sector,...Read More','2025 අංක 11 දරන සේවක ජාතික අවම වැටුප් සංශෝධන පනතේ විධිවිධාන අනුව පෞද්ගලික අංශයේ ජාතික අවම වැටුප්,...Read More','2025 ஆம் ஆண்டின் 11 ஆம் எண் ஊழியர்களின் தேசிய குறைந்தபட்ச ஊதியத் திருத்தச் சட்டத்தின் விதிகளின்படி, தனியார் துறையில் தேசிய குறைந்தபட்ச ஊதியம்,...மேலும் படிக்க','uploads/news/2026/06/appointment-letters-64c23.jpg',NULL,'english','public',0,0,'Published',1,'2026-06-10 04:56:44','2026-06-10 04:56:44');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
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
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `status` enum('Public','Private') NOT NULL DEFAULT 'Public',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` VALUES (1,'New Labour Officers Receive Appointment Letters','uploads/gallery/2026/06/gallery-1-a15a6.webp','Public','2026-06-05 06:36:16','2026-06-05 06:36:16'),(2,'National Labour Advisory Council (NLAC)','uploads/gallery/2026/06/appointment-letters-7e3d4.jpg','Public','2026-06-05 06:36:56','2026-06-05 06:36:56'),(7,'Cabinet to amend the labour laws','uploads/gallery/2026/06/cabinet-5795c.jpg','Public','2026-06-10 04:57:29','2026-06-10 04:57:29'),(8,'The Ministry of Labour also begins work in the new year','uploads/gallery/2026/06/minister-af9c8.jpg','Public','2026-06-10 04:57:52','2026-06-10 04:57:52');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`),
  CONSTRAINT `gallery_images_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_images`
--

LOCK TABLES `gallery_images` WRITE;
/*!40000 ALTER TABLE `gallery_images` DISABLE KEYS */;
INSERT INTO `gallery_images` VALUES (1,1,'uploads/gallery/2026/06/gallery-2-a2a6f.webp','2026-06-05 06:36:16'),(2,1,'uploads/gallery/2026/06/gallery-3-a394f.webp','2026-06-05 06:36:16'),(3,1,'uploads/gallery/2026/06/gallery-4-a47ff.webp','2026-06-05 06:36:16'),(4,2,'uploads/gallery/2026/06/cabinet-7f114.jpg','2026-06-05 06:36:56'),(5,2,'uploads/gallery/2026/06/minister-80755.jpg','2026-06-05 06:36:56'),(6,2,'uploads/gallery/2026/06/nlac-81c14.jpg','2026-06-05 06:36:56');
/*!40000 ALTER TABLE `gallery_images` ENABLE KEYS */;
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
INSERT INTO `officials` VALUES (1,'top','minister',NULL,'Hon. Minister of Labour','Hon. Minister Anil Jayantha Fernando','','minister@labourmin.gov.lk','+94 (0)112 368175','+94 (0)112 588950','admin/uploads/officials/minister-anil-jayantha-fernando.webp',1,1,'2026-06-09 10:35:01','2026-06-09 11:18:37'),(2,'top','deputy_minister',NULL,'Hon. Deputy Minister of Labour','Mr. Mahinda Jayasinghe','','majayasinghe@gmail.com','+94 (0)112 368526','+94 (0)112 369340','admin/uploads/officials/deputy-minister-mahinda-jayasinghe.webp',2,1,'2026-06-09 10:35:01','2026-06-09 11:19:31'),(3,'top','secretary',NULL,'Secretary','Mr. S.M.Piyatissa',NULL,'slmol@slt.lk','+94 (0)112 368164','+94 (0)112 582938','admin/uploads/officials/secretary-sm-piyatissa.webp',3,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(4,'division',NULL,1,'Additional Secretary (Administration)','Ms. T P Muditha Pathmajay','Additional Secretary (Administration)','adsec.admin@labourmin.gov.lk','+94 (0)112 368938','+94 (0)112 368165','admin/uploads/officials/admin-muditha-pathmajay.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:54:45'),(5,'division',NULL,1,'Senior Assistant Secretary (Administration)','Mr. L.T.G.D Darshana','Senior Assistant Secretary (Administration)','sas.admin@labourmin.gov.lk','+94 (0)112 368304','+94 (0)112 368200','admin/uploads/officials/admin-darshana-ltgd.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:54:45'),(6,'division',NULL,1,'Assistant Secretary (Procurement)','Ms. S Luxiga','Assistant Secretary (Procurement)','','+94 (0)112 368136','','admin/uploads/officials/admin-luxiga-s.webp',3,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(7,'division',NULL,1,'Assistant Secretary (Establishment)','Ms. Yashoda Thissera','Assistant Secretary (Establishment)','as.est@labourmin.gov.lk','+94 (0) 112 368264','','admin/uploads/officials/admin-yashoda-thissera.webp',4,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(8,'division',NULL,1,'Legal Officer','Ms. W P A G Wijesooriya','Legal Officer','labourminlegal@gmail.com','+94 (0)112 582046','','admin/uploads/officials/admin-wijesooriya-wpag.webp',5,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(9,'division',NULL,2,'Additional Secretary (Development)','Mr. Lal Samarasekara','Additional Secretary (Development)','adsec.dev@labourmin.gov.lk','+94 (0)112 586337','+94 (0)112 589267','admin/uploads/officials/dev-lal-samarasekara.webp',1,1,'2026-06-09 10:35:01','2026-06-09 16:39:31'),(10,'division',NULL,2,'Director (Development)','Mr. P D Chandana Pathirage','Director (Development)','dir.dev@labourmin.gov.lk','+94 (0)11 2502807','','admin/uploads/officials/dev-chandana-pathirage.webp',2,1,'2026-06-09 10:35:01','2026-06-09 16:39:31'),(11,'division',NULL,3,'Director General (Planning)','Ms. I V N Preethika Kumuduni','Director General (Planning)','','+94 (0)112 368594','','admin/uploads/officials/planning-preethika-kumuduni.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(12,'division',NULL,3,'Deputy Director (Planning)','Ms. M.P.D.C.W.Kumari','Deputy Director (Planning)','','+94 (0) 1125 82171','','admin/uploads/officials/planning-kumari-mpdcw.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(13,'division',NULL,4,'Chief Finance Officer','Mrs. G.C.N. Fonseka','Chief Finance Officer','','+94 (0)112 505161','','admin/uploads/officials/finance-fonseka-gcn.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(14,'division',NULL,4,'Chief Accountant','Ms. S S Shiroma Nandani','Chief Accountant','ca@labourmin.gov.lk','+94 (0)112 368204','+94 (0)112 368204','admin/uploads/officials/finance-nandani-shiroma.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(15,'division',NULL,5,'Chief Internal Auditor','Mrs. A.M.M.K. Abeysinghe','Chief Internal Auditor','cia@labourmin.gov.lk','+94 (0)112 369422','','admin/uploads/officials/internal-audit-abeysinghe-ammk.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(16,'division',NULL,6,'Senior Assistant Secretary (Foreign Relations)','Mr. B Vasanthan','Senior Assistant Secretary (Foreign Relations)','sas.fr@labourmin.gov.lk','+94 (0)112 368609','+94 (0)112 368609','admin/uploads/officials/foreign-relations-vasanthan-b.webp',1,1,'2026-06-09 10:35:01','2026-06-09 10:35:01'),(17,'division',NULL,6,'Assistant Secretary (FR)','Mrs. M.N.H.Peiris','Assistant Secretary (FR)','as.fr@labourmin.gov.lk','+94 (0)112 504478','','admin/uploads/officials/foreign-relations-peiris-mnh.webp',2,1,'2026-06-09 10:35:01','2026-06-09 10:35:01');
/*!40000 ALTER TABLE `officials` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-10 10:33:13

--
-- Table structure for table `publications`
--

DROP TABLE IF EXISTS `publications`;
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

--
-- Table structure for table `procurements`
--

DROP TABLE IF EXISTS `procurements`;
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

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE IF NOT EXISTS `bookings` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

