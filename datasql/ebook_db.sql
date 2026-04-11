-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ebook_db
CREATE DATABASE IF NOT EXISTS `ebook_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ebook_db`;

-- Dumping structure for table ebook_db.ebooks
CREATE TABLE IF NOT EXISTS `ebooks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ebooks_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebook_db.ebooks: ~8 rows (approximately)
INSERT INTO `ebooks` (`id`, `title`, `slug`, `description`, `author`, `price`, `cover_image`, `file_path`, `category`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Laravel: Up & Running', 'laravel-up-running', 'A complete guide to the Laravel PHP framework. Learn to build modern web applications with Laravel from the ground up. Covers routing, Eloquent ORM, Blade templating, queues, and more.', 'Matt Stauffer', 29.99, NULL, NULL, 'Programming', 'published', '2026-04-08 20:23:08', '2026-04-08 20:23:08'),
	(2, 'Clean Code', 'clean-code', 'A Handbook of Agile Software Craftsmanship. Even bad code can function. But if code isn\'t clean, it can bring a development organization to its knees. This book is a must-read for any developer.', 'Robert C. Martin', 24.99, NULL, NULL, 'Programming', 'published', '2026-04-08 20:23:08', '2026-04-08 20:23:08'),
	(3, 'The Pragmatic Programmer', 'the-pragmatic-programmer', 'Your Journey to Mastery. This book will help you become a better programmer. Topics range from personal responsibility to career development, and include architectural techniques to keep code flexible.', 'David Thomas & Andrew Hunt', 34.99, NULL, NULL, 'Programming', 'published', '2026-04-08 20:23:08', '2026-04-08 20:23:08'),
	(4, 'JavaScript: The Good Parts', 'javascript-the-good-parts', 'Most programming languages contain good and bad parts, but JavaScript has more than its share of the bad. This book identifies the goodness in JavaScript that makes it work well.', 'Douglas Crockford', 19.99, NULL, NULL, 'Web Development', 'published', '2026-04-08 20:23:08', '2026-04-08 20:23:08'),
	(5, 'Python Crash Course', 'python-crash-course', 'A Hands-On, Project-Based Introduction to Programming. Python Crash Course is the world\'s best-selling guide to the Python programming language.', 'Eric Matthes', 22.99, NULL, NULL, 'Programming', 'published', '2026-04-08 20:23:08', '2026-04-08 20:23:08'),
	(6, 'Design Patterns', 'design-patterns', 'Elements of Reusable Object-Oriented Software. Capturing a wealth of experience about the design of object-oriented software, four top-notch designers present a catalog of simple and succinct solutions.', 'Gang of Four', 39.99, NULL, NULL, 'Software Architecture', 'published', '2026-04-08 20:23:08', '2026-04-08 20:23:08'),
	(7, 'CSS: The Definitive Guide', 'css-the-definitive-guide', 'If you\'re a web designer or app developer interested in sophisticated page styling, improved accessibility, and saving time and effort, this comprehensive guide is essential reading.', 'Eric A. Meyer', 18.99, NULL, NULL, 'Web Development', 'published', '2026-04-08 20:23:08', '2026-04-08 20:23:08'),
	(8, 'Domain-Driven Design', 'domain-driven-design', 'Tackling Complexity in the Heart of Software. This is not a book about specific technologies. It\'s about how you think about the problems you\'re solving.', 'Eric Evans', 44.99, NULL, NULL, 'Software Architecture', 'draft', '2026-04-08 20:23:08', '2026-04-08 20:23:08');

-- Dumping structure for table ebook_db.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebook_db.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table ebook_db.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebook_db.migrations: ~6 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2024_01_01_000001_create_ebooks_table', 1),
	(6, '2024_01_01_000002_create_purchases_table', 1);

-- Dumping structure for table ebook_db.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebook_db.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table ebook_db.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebook_db.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table ebook_db.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `ebook_id` bigint unsigned NOT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchases_user_id_foreign` (`user_id`),
  KEY `purchases_ebook_id_foreign` (`ebook_id`),
  CONSTRAINT `purchases_ebook_id_foreign` FOREIGN KEY (`ebook_id`) REFERENCES `ebooks` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebook_db.purchases: ~0 rows (approximately)

-- Dumping structure for table ebook_db.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ebook_db.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `google_id`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'admin@ebook.com', NULL, '$2y$12$x0KZBt28arvus/BOXA0g0eXTfEUJMAocS0XOxT6EYUX60wccNTnti', NULL, 'admin', NULL, '2026-04-08 20:23:07', '2026-04-08 20:23:07'),
	(2, 'John Doe', 'user@ebook.com', NULL, '$2y$12$rRS5/DntCTBd7oHEb4cNK.1NXwOxBwf/EG6LVsKh5529G.U5w.zr2', NULL, 'user', NULL, '2026-04-08 20:23:08', '2026-04-08 20:23:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
