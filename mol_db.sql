-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2026 at 05:54 AM
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
-- Database: `mol_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('super_admin','admin','editor') NOT NULL DEFAULT 'admin',
  `access_level` varchar(50) NOT NULL DEFAULT 'view_only',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password_hash`, `role`, `access_level`, `created_at`, `updated_at`) VALUES
(2, 'superadmin', 'admin@gmail.com', '$2y$10$ywnQbcv9xGJ7kNLRMXWcNuAw76F4rmNzH982ccivZ1ZTt5mgxKjxG', 'super_admin', 'full_access', '2026-06-04 09:32:39', '2026-06-04 09:34:28'),
(3, 'Vishwa', 'vishwa@gmail.com', '$2y$10$yLl15KFsqiN0hg2UqnnYUerGw9qzzfM5e/86ESPwEt0Q01VpIBkpC', 'admin', 'full_access', '2026-06-04 10:03:22', '2026-06-04 10:03:22');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `content` longtext NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `visibility` enum('public','private','hidden') NOT NULL DEFAULT 'public',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Draft','Published') NOT NULL DEFAULT 'Draft',
  `author_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `title_si` varchar(255) DEFAULT NULL,
  `title_ta` varchar(255) DEFAULT NULL,
  `content_si` longtext DEFAULT NULL,
  `content_ta` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `category`, `content`, `cover_image`, `visibility`, `is_featured`, `status`, `author_id`, `created_at`, `updated_at`, `title_si`, `title_ta`, `content_si`, `content_ta`) VALUES
(1, '38 New Labour Officers Receive Appointment Letters', 'Media', 'Appointment letters were presented to 38 newly recruited Labour Officers at a ceremony held on the morning of 16 February at the Labour Ministry Auditorium, Mehewara Piyasa Building, Narahenpita.\r\n\r\nThe event was held under the patronage of the Minister of Labour, Dr. Anil Jayantha Fernando, and the Deputy Minister of Labour, Mr. Mahinda Jayasinghe.\r\n\r\nThe newly appointed officers will undergo a comprehensive training programme comprising three months of institutional training followed by one month of field duty training at the National Institute of Labour Studies, functioning under the Ministry of Labour. The programme is designed to equip them with the necessary knowledge and practical exposure to effectively carry out their responsibilities in the field of labour administration and regulation.\r\n\r\nThe Secretary to the Ministry of Labour, Mr. S.M. Piyatissa, and the Commissioner General of Labour, Mrs. Nadeeka Wataliyadda, were also present at the ceremony, along with several senior officials of the Ministry.\r\n\r\nThe appointment of these officers marks a significant step towards further strengthening the labour administration framework and enhancing service delivery across the country.', 'uploads/news/2026/06/gallery-1-e866c.webp', 'public', 0, 'Published', 2, '2026-06-05 06:34:59', '2026-06-05 09:47:38', 'නව කම්කරු නිලධාරීන් 38 දෙනෙකුට පත්වීම් ලිපි ලැබේ', '38 புதிய தொழிலாளர் அலுவலர்கள் நியமனக் கடிதங்களைப் பெறுகின்றனர்', 'පෙබරවාරි 16 වැනි දින පෙරවරුවේ නාරාහේන්පිට මෙහෙවර පියස ගොඩනැගිල්ලේ කම්කරු අමාත්‍යාංශ ශ්‍රවණාගාරයේදී පැවැති උත්සවයකදී අලුතින් බඳවාගත් කම්කරු නිලධාරීන් 38 දෙනකු සඳහා පත්වීම් ලිපි ප්‍රදානය කෙරිණි.\r\n\r\nකම්කරු අමාත්‍ය ආචාර්ය අනිල් ජයන්ත ප්‍රනාන්දු මහතාගේ සහ කම්කරු නියෝජ්‍ය අමාත්‍ය මහින්ද ජයසිංහ මහතාගේ ප්‍රධානත්වයෙන් මෙම උත්සවය පැවැත්විණි.\r\n\r\nඅලුතින් පත් කරන ලද නිලධාරීන් කම්කරු අමාත්‍යාංශය යටතේ ක්‍රියාත්මක වන  ජාතික කම්කරු අධ්‍යයන ආයතනයේ මාස තුනක ආයතනික පුහුණුවකින් පසුව මාසයක ක්ෂේත්‍ර රාජකාරි පුහුණුවකින් සමන්විත විස්තීරණ පුහුණු වැඩසටහනකට භාජනය වනු ඇත. කම්කරු පරිපාලනය සහ නියාමන ක්‍ෂේත්‍රයේ ඔවුන්ගේ වගකීම් ඵලදායී ලෙස ඉටු කිරීම සඳහා අවශ්‍ය දැනුම සහ ප්‍රායෝගික නිරාවරණයෙන් ඔවුන් සන්නද්ධ කිරීම සඳහා මෙම වැඩසටහන සැලසුම් කර ඇත.\r\n\r\nකම්කරු අමාත්‍යාංශයේ ලේකම් එස්.එම්. පියතිස්ස, සහ කම්කරු කොමසාරිස් ජනරාල් නදීකා වටලියද්ද මහත්මිය ද, අමාත්‍යාංශයේ ජ්‍යෙෂ්ඨ නිලධාරීන් කිහිප දෙනෙකු ද මෙම උත්සවයට එක්ව සිටියහ.\r\n\r\nමෙම නිලධාරීන් පත් කිරීම කම්කරු පරිපාලන රාමුව තවදුරටත් ශක්තිමත් කිරීම සහ රට පුරා සේවා සැපයීම ඉහළ නැංවීම සඳහා වැදගත් පියවරක් සනිටුහන් කරයි.', 'நாரஹேன்பிட்டி, மெஹேவர பியச கட்டிடத்தில் உள்ள தொழிலாளர் அமைச்சின் கேட்போர் கூடத்தில் கடந்த பெப்ரவரி 16 ஆம் திகதி காலை இடம்பெற்ற நிகழ்வில் புதிதாக சேர்த்துக்கொள்ளப்பட்ட 38 தொழிலாளர் உத்தியோகத்தர்களுக்கான நியமனக் கடிதங்கள் வழங்கி வைக்கப்பட்டன.\r\n\r\nதொழிலாளர் அமைச்சர் டொக்டர் அனில் ஜயந்த பெர்னாண்டோ மற்றும் தொழிலாளர் பிரதி அமைச்சர் திரு மஹிந்த ஜயசிங்க ஆகியோரின் தலைமையில் இந்த நிகழ்வு இடம்பெற்றது.\r\n\r\nபுதிதாக நியமிக்கப்பட்டுள்ள அதிகாரிகள், தொழிலாளர் அமைச்சகத்தின் கீழ் செயல்படும் தேசிய தொழிலாளர் ஆய்வுக் கழகத்தில் மூன்று மாத நிறுவனப் பயிற்சியையும் அதன்பின் ஒரு மாத களப்பணிப் பயிற்சியையும் உள்ளடக்கிய விரிவான பயிற்சித் திட்டத்தில் ஈடுபடுவார்கள். தொழிலாளர் நிர்வாகம் மற்றும் ஒழுங்குமுறைத் துறையில் அவர்களின் பொறுப்புகளை திறம்பட செயல்படுத்த தேவையான அறிவு மற்றும் நடைமுறை வெளிப்பாடுகளுடன் அவர்களை சித்தப்படுத்துவதற்காக இந்த திட்டம் வடிவமைக்கப்பட்டுள்ளது.\r\n\r\nதொழிலாளர் அமைச்சின் செயலாளர் திரு. எஸ்.எம். பியதிஸ்ஸ, மற்றும் தொழிலாளர் ஆணையாளர் நாயகம் திருமதி நதீகா வத்தலியத்த அவர்களும், அமைச்சின் சிரேஷ்ட அதிகாரிகள் பலரும் இவ்விழாவில் கலந்துகொண்டனர்.\r\n\r\nஇந்த அதிகாரிகளின் நியமனம், தொழிலாளர் நிர்வாகக் கட்டமைப்பை மேலும் வலுப்படுத்துவதற்கும், நாடு முழுவதும் சேவை வழங்கலை மேம்படுத்துவதற்கும் ஒரு குறிப்பிடத்தக்க படியைக் குறிக்கிறது.'),
(2, 'The committee approved by the Cabinet to amend the labour laws is consulting the National Labour Advisory Council (NLAC).', 'Media', 'The ceremony organized to mark the commencement of the Ministry of Labor and its subordinate institutions for the year 2026 was held this morning (01) at the Narahenpita', 'uploads/news/2026/06/cabinet-a918e.jpg', 'public', 0, 'Published', 2, '2026-06-05 06:38:05', '2026-06-05 09:47:30', 'කම්කරු නීති සංශෝධනය කිරීම සඳහා කැබිනට් මණ්ඩලය විසින් අනුමත කරන ලද කමිටුව ජාතික කම්කරු උපදේශක සභාවේ (NLAC) උපදෙස් ලබා ගනී.', 'தொழிலாளர் சட்டங்களைத் திருத்துவதற்கு அமைச்சரவையால் அங்கீகரிக்கப்பட்ட குழு தேசிய தொழிலாளர் ஆலோசனைக் குழுவின் (NLAC) ஆலோசனையை மேற்கொண்டு வருகிறது.', '2026 වසර සඳහා කම්කරු අමාත්‍යාංශය සහ ඊට අනුබද්ධ ආයතන ආරම්භ කිරීම නිමිත්තෙන් සංවිධානය කළ උත්සවය අද (01) පෙරවරුවේ නාරාහේන්පිට දී පැවැත්විණි.', '2026 ஆம் ஆண்டிற்கான தொழிலாளர் அமைச்சு மற்றும் அதன் கீழ் இயங்கும் நிறுவனங்களின் ஆரம்பத்தை முன்னிட்டு ஏற்பாடு செய்யப்பட்ட வைபவம் இன்று (01) காலை நாரஹேன்பிட்டியில் நடைபெற்றது.'),
(3, 'Press release on private sector salary increase.', 'Notices', 'In accordance with the provisions of the National Minimum Wage of Employees Amendment Act No. 11 of 2025, the National Minimum Wage in the private sector', 'uploads/news/2026/06/minister-9d429.jpg', 'public', 1, 'Published', 2, '2026-06-05 06:44:31', '2026-06-05 09:47:22', 'පෞද්ගලික අංශයේ වැටුප් වැඩිවීම පිළිබඳ මාධ්‍ය නිවේදනය.', 'தனியார் துறையின் சம்பள அதிகரிப்பு குறித்த செய்திக்குறிப்பு.', '2025 අංක 11 දරන සේවක ජාතික අවම වැටුප් සංශෝධන පනතේ විධිවිධාන අනුව පුද්ගලික අංශයේ ජාතික අවම වැටුප', '2025 ஆம் ஆண்டின் 11 ஆம் எண் ஊழியர்களின் தேசிய குறைந்தபட்ச ஊதியத் திருத்தச் சட்டத்தின் விதிகளின்படி, தனியார் துறையில் தேசிய குறைந்தபட்ச ஊதியம்'),
(4, 'sinhala', 'Media', '', NULL, 'public', 0, 'Draft', 2, '2026-06-05 09:32:47', '2026-06-05 09:32:47', 'ඉංග්රීසි', 'ஆங்கிலம்', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `article_images`
--

CREATE TABLE `article_images` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_images`
--

INSERT INTO `article_images` (`id`, `article_id`, `image_path`, `created_at`) VALUES
(1, 1, 'uploads/news/2026/06/gallery-2-e9d84.webp', '2026-06-05 06:34:59'),
(2, 1, 'uploads/news/2026/06/gallery-3-ead1d.webp', '2026-06-05 06:34:59'),
(3, 1, 'uploads/news/2026/06/gallery-4-ebc4e.webp', '2026-06-05 06:34:59'),
(4, 2, 'uploads/news/2026/06/minister-aabe3.jpg', '2026-06-05 06:38:05'),
(5, 3, 'uploads/news/2026/06/cabinet-9e1ac.jpg', '2026-06-05 06:44:31'),
(6, 3, 'uploads/news/2026/06/nlac-9eb01.jpg', '2026-06-05 06:44:31');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `bungalow_name` varchar(100) NOT NULL,
  `applicant_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `no_of_rooms` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `bungalow_name`, `applicant_name`, `email`, `phone`, `start_date`, `end_date`, `room_type`, `status`, `created_at`, `updated_at`, `no_of_rooms`) VALUES
(1, 'Ampara', 'Test', 'example@gmail.com', '07000000', '2026-06-05', '2026-06-09', 'Entire Bungalow', 'Confirmed', '2026-06-05 06:38:49', '2026-06-05 06:39:47', 1),
(2, 'Ampara', 'Test', 'gallagevishwa@gmail.com', '07000000', '2026-06-10', '2026-06-19', 'VIP Room', 'Pending', '2026-06-05 06:39:03', '2026-06-05 06:39:03', 1),
(3, 'Ampara', 'Test', 'gallagevishwa@gmail.com', '07000000', '2026-06-10', '2026-06-19', 'A/C Triple Room', 'Pending', '2026-06-05 06:39:03', '2026-06-05 06:39:03', 1),
(4, 'Ampara', 'Test', 'gallagevishwa@gmail.com', '07000000', '2026-06-25', '2026-06-28', 'A/C Triple Room', 'Confirmed', '2026-06-05 09:07:33', '2026-06-05 09:08:21', 2);

-- --------------------------------------------------------

--
-- Table structure for table `circuit_bungalows`
--

CREATE TABLE `circuit_bungalows` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `circuit_bungalows`
--

INSERT INTO `circuit_bungalows` (`id`, `name`, `location`) VALUES
(1, 'Ampara Circuit Bungalow', 'Ampara');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `status` enum('Public','Private') NOT NULL DEFAULT 'Public',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `cover_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'New Labour Officers Receive Appointment Letters', 'uploads/gallery/2026/06/gallery-1-a15a6.webp', 'Public', '2026-06-05 06:36:16', '2026-06-05 06:36:16'),
(2, 'National Labour Advisory Council (NLAC)', 'uploads/gallery/2026/06/appointment-letters-7e3d4.jpg', 'Public', '2026-06-05 06:36:56', '2026-06-05 06:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `gallery_id`, `image_path`, `created_at`) VALUES
(1, 1, 'uploads/gallery/2026/06/gallery-2-a2a6f.webp', '2026-06-05 06:36:16'),
(2, 1, 'uploads/gallery/2026/06/gallery-3-a394f.webp', '2026-06-05 06:36:16'),
(3, 1, 'uploads/gallery/2026/06/gallery-4-a47ff.webp', '2026-06-05 06:36:16'),
(4, 2, 'uploads/gallery/2026/06/cabinet-7f114.jpg', '2026-06-05 06:36:56'),
(5, 2, 'uploads/gallery/2026/06/minister-80755.jpg', '2026-06-05 06:36:56'),
(6, 2, 'uploads/gallery/2026/06/nlac-81c14.jpg', '2026-06-05 06:36:56');

-- --------------------------------------------------------

--
-- Table structure for table `news_events`
--

CREATE TABLE `news_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` enum('news','event','media') NOT NULL DEFAULT 'news',
  `image_path` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_by` int(11) DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','super_admin') NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `is_active`, `created_at`, `last_login`) VALUES
(1, 'System Super Admin', 'superadmin@labour.gov.lk', '$2y$10$yXJITl7FbtWpnDKtQTuO0.Q.g7i5MzASa4tPDz4L.rJz2kcc.Ux2a', 'super_admin', 1, '2026-06-04 06:03:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `article_images`
--
ALTER TABLE `article_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `circuit_bungalows`
--
ALTER TABLE `circuit_bungalows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_id` (`gallery_id`);

--
-- Indexes for table `news_events`
--
ALTER TABLE `news_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `article_images`
--
ALTER TABLE `article_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `circuit_bungalows`
--
ALTER TABLE `circuit_bungalows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `news_events`
--
ALTER TABLE `news_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `article_images`
--
ALTER TABLE `article_images`
  ADD CONSTRAINT `article_images_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news_events`
--
ALTER TABLE `news_events`
  ADD CONSTRAINT `news_events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
