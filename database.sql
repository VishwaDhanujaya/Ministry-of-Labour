CREATE DATABASE IF NOT EXISTS mol_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mol_db;

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('super_admin', 'admin', 'editor') NOT NULL DEFAULT 'admin',
  `access_level` varchar(50) NOT NULL DEFAULT 'view_only',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title_si` varchar(255) NULL DEFAULT NULL,
  `title_ta` varchar(255) NULL DEFAULT NULL,
  `category` varchar(50) NOT NULL,
  `publish_date` date NULL DEFAULT NULL,
  `summary` text NOT NULL,
  `content` longtext NOT NULL,
  `content_si` longtext NULL DEFAULT NULL,
  `content_ta` longtext NULL DEFAULT NULL,
  `cover_image` varchar(255) NULL DEFAULT NULL,
  `tags` varchar(255) NULL DEFAULT NULL,
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `visibility` enum('public', 'private', 'hidden') NOT NULL DEFAULT 'public',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_special_notice` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Draft', 'Published') NOT NULL DEFAULT 'Draft',
  `author_id` int(11) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `admins`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `article_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `cover_image` varchar(255) NOT NULL,
  `status` enum('Public', 'Private') NOT NULL DEFAULT 'Public',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`gallery_id`) REFERENCES `gallery`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bungalow_name` varchar(100) NOT NULL,
  `applicant_name` varchar(100) NOT NULL,
  `email` varchar(100) NULL DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `room_type` varchar(100) NOT NULL,
  `no_of_rooms` int(11) NOT NULL DEFAULT 1,
  `status` enum('Pending', 'Confirmed', 'Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default super admin if none exists (Password: Ministry@2026!)
INSERT INTO `admins` (`name`, `email`, `password_hash`, `role`, `access_level`) 
SELECT 'superadmin', 'admin@labourmin.gov.lk', '$2y$10$4ZL/LExe7wldrou49bkGf.3vNet7naY1gaG5aTD01Ec9Q1eaaUISW', 'super_admin', 'full_access'
WHERE NOT EXISTS (SELECT 1 FROM `admins` WHERE `email` = 'admin@labourmin.gov.lk');
