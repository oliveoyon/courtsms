-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 31, 2025 at 05:49 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courtsms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1767201682;', 1767201682),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1767201682),
('laravel-cache-court_sms_token', 's:1375:\"eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJxNHVPQ1VLTkw2NzRyU1A0eDBraWRmdmFnNG1aSTZpb0NsbEFBRXoxLUpRIn0.eyJleHAiOjE3NjY5Mzg1MjAsImlhdCI6MTc2NjkzODIyMCwianRpIjoiZWVhZWIwMTUtYTNmNS00ZjM0LWJhNWMtNTA4Njk1ZDE0OGExIiwiaXNzIjoiaHR0cHM6Ly9pZHAub3NzLm5ldC5iZC9hdXRoL3JlYWxtcy9kZXYiLCJhdWQiOlsiYWNjb3VudCIsImJyb2tlci1hcGkiXSwic3ViIjoiNmIzZThiZDQtY2ZiNC00YTRiLWI1MDItMTZlZjNlM2UzYjJjIiwidHlwIjoiQmVhcmVyIiwiYXpwIjoiQ291cnQgU01TIiwiYWNyIjoiMSIsImFsbG93ZWQtb3JpZ2lucyI6WyJodHRwOi8vbG9jYWxob3N0OjgwODAvIl0sInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJib3JrZXItdWktYWRtaW4iLCJkZWZhdWx0LXJvbGVzLWRldiIsIm9mZmxpbmVfYWNjZXNzIiwidW1hX2F1dGhvcml6YXRpb24iLCJVU0VSIl19LCJyZXNvdXJjZV9hY2Nlc3MiOnsiYWNjb3VudCI6eyJyb2xlcyI6WyJtYW5hZ2UtYWNjb3VudCIsInZpZXctcHJvZmlsZSJdfSwiYnJva2VyLWFwaSI6eyJyb2xlcyI6WyJVU0VSIl19fSwic2NvcGUiOiJwcm9maWxlIGVtYWlsIiwiY2xpZW50SG9zdCI6IjEwMy4xOTguMTMzLjExNyIsImNsaWVudElkIjoiQ291cnQgU01TIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJzZXJ2aWNlLWFjY291bnQtY291cnQgc21zIiwiY2xpZW50QWRkcmVzcyI6IjEwMy4xOTguMTMzLjExNyJ9.hgAoAuo8X5WPq3xSafw4c8SLKTVPKLWag7gy5WRfjQBj2HI__LZKylAWdSGq38xyoR-9RxM6LlEiGFadmAZ1eHjja4E3FhUOE70K3FOgH9GCP-2iVvRB7W9M_OsWL_HBKnSC1M1hrrcJ7D0cIbGTWca_iOxaAQH9zrH25MrP1M6tq6q478Jtoc9AdiUe8gBfZ8XKJHy1K6i3yLSBkHI-2p_yyjaA0wLbCm_JuXwb-AcrNQSwN1YL2C7scEWSlszhK1DPeyhBCKa_Vui916beO2isuwhPCjlsnrAmPg7DJUTNHsB2sgxRz67Pr8lxHIQ5IoXqp_9JTNVIG6MLYjW3zA\";', 1766941219),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:8:\"group_id\";s:1:\"c\";s:4:\"name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:40:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";i:1;s:1:\"c\";s:15:\"View Permission\";s:1:\"d\";s:3:\"web\";}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";i:1;s:1:\"c\";s:17:\"Create Permission\";s:1:\"d\";s:3:\"web\";}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";i:1;s:1:\"c\";s:15:\"Edit Permission\";s:1:\"d\";s:3:\"web\";}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";i:1;s:1:\"c\";s:17:\"Delete Permission\";s:1:\"d\";s:3:\"web\";}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";i:2;s:1:\"c\";s:10:\"View Roles\";s:1:\"d\";s:3:\"web\";}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";i:2;s:1:\"c\";s:11:\"Create Role\";s:1:\"d\";s:3:\"web\";}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";i:2;s:1:\"c\";s:9:\"Edit Role\";s:1:\"d\";s:3:\"web\";}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";i:2;s:1:\"c\";s:11:\"Delete Role\";s:1:\"d\";s:3:\"web\";}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";i:2;s:1:\"c\";s:18:\"Assign Permissions\";s:1:\"d\";s:3:\"web\";}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";i:3;s:1:\"c\";s:21:\"View Permission Group\";s:1:\"d\";s:3:\"web\";}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";i:3;s:1:\"c\";s:23:\"Create Permission Group\";s:1:\"d\";s:3:\"web\";}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";i:3;s:1:\"c\";s:21:\"Edit Permission Group\";s:1:\"d\";s:3:\"web\";}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";i:3;s:1:\"c\";s:23:\"Delete Permission Group\";s:1:\"d\";s:3:\"web\";}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";i:4;s:1:\"c\";s:10:\"View Users\";s:1:\"d\";s:3:\"web\";}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";i:4;s:1:\"c\";s:12:\"Create Users\";s:1:\"d\";s:3:\"web\";}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";i:4;s:1:\"c\";s:10:\"Edit Users\";s:1:\"d\";s:3:\"web\";}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";i:4;s:1:\"c\";s:12:\"Delete Users\";s:1:\"d\";s:3:\"web\";}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";i:4;s:1:\"c\";s:21:\"View User Permissions\";s:1:\"d\";s:3:\"web\";}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";i:5;s:1:\"c\";s:13:\"View Division\";s:1:\"d\";s:3:\"web\";}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";i:5;s:1:\"c\";s:15:\"Create Division\";s:1:\"d\";s:3:\"web\";}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";i:5;s:1:\"c\";s:13:\"Edit Division\";s:1:\"d\";s:3:\"web\";}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";i:5;s:1:\"c\";s:18:\"Delete Divisioners\";s:1:\"d\";s:3:\"web\";}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";i:6;s:1:\"c\";s:13:\"View District\";s:1:\"d\";s:3:\"web\";}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";i:6;s:1:\"c\";s:15:\"Create District\";s:1:\"d\";s:3:\"web\";}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";i:6;s:1:\"c\";s:13:\"Edit District\";s:1:\"d\";s:3:\"web\";}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";i:6;s:1:\"c\";s:15:\"Delete District\";s:1:\"d\";s:3:\"web\";}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";i:7;s:1:\"c\";s:10:\"View Court\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";i:7;s:1:\"c\";s:12:\"Create Court\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";i:7;s:1:\"c\";s:10:\"Edit Court\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:3;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";i:7;s:1:\"c\";s:12:\"Delete Court\";s:1:\"d\";s:3:\"web\";}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";i:8;s:1:\"c\";s:8:\"SMS Form\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:3;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";i:8;s:1:\"c\";s:8:\"Send SMS\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:3;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";i:9;s:1:\"c\";s:30:\"View Message Template Category\";s:1:\"d\";s:3:\"web\";}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";i:9;s:1:\"c\";s:32:\"Create Message Template Category\";s:1:\"d\";s:3:\"web\";}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";i:9;s:1:\"c\";s:30:\"Edit Message Template Category\";s:1:\"d\";s:3:\"web\";}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";i:9;s:1:\"c\";s:32:\"Delete Message Template Category\";s:1:\"d\";s:3:\"web\";}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";i:9;s:1:\"c\";s:21:\"View Message Template\";s:1:\"d\";s:3:\"web\";}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";i:9;s:1:\"c\";s:23:\"Create Message Template\";s:1:\"d\";s:3:\"web\";}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";i:9;s:1:\"c\";s:21:\"Edit Message Template\";s:1:\"d\";s:3:\"web\";}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";i:9;s:1:\"c\";s:23:\"Delete Message Template\";s:1:\"d\";s:3:\"web\";}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:3;s:1:\"c\";s:14:\"District Focal\";s:1:\"d\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"c\";s:11:\"Court Staff\";s:1:\"d\";s:3:\"web\";}}}', 1767289597);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

DROP TABLE IF EXISTS `cases`;
CREATE TABLE IF NOT EXISTS `cases` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `case_no` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `court_id` bigint UNSIGNED NOT NULL,
  `hearing_date` date NOT NULL,
  `hearing_time` time DEFAULT NULL,
  `reschedule_date` date DEFAULT NULL,
  `reschedule_time` time DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cases_court_id_foreign` (`court_id`),
  KEY `cases_created_by_foreign` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_hearings`
--

DROP TABLE IF EXISTS `case_hearings`;
CREATE TABLE IF NOT EXISTS `case_hearings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `case_id` bigint UNSIGNED NOT NULL,
  `hearing_date` date NOT NULL,
  `hearing_time` time DEFAULT NULL,
  `is_reschedule` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `case_hearings_case_id_foreign` (`case_id`),
  KEY `case_hearings_created_by_foreign` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_hearings`
--

INSERT INTO `case_hearings` (`id`, `case_id`, `hearing_date`, `hearing_time`, `is_reschedule`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-09', NULL, 0, 1, '2025-12-31 00:36:00', '2025-12-31 00:36:00'),
(2, 1, '2026-01-23', NULL, 1, 1, '2025-12-31 00:40:48', '2025-12-31 00:40:48');

-- --------------------------------------------------------

--
-- Table structure for table `courts`
--

DROP TABLE IF EXISTS `courts`;
CREATE TABLE IF NOT EXISTS `courts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `district_id` bigint UNSIGNED NOT NULL,
  `name_en` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courts_district_id_foreign` (`district_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courts`
--

INSERT INTO `courts` (`id`, `district_id`, `name_en`, `name_bn`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 33, 'Chief Judicial Magistrate Court', 'সিজেএম আদালত', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(2, 33, 'Additional Chief Judicial Magistrate Court', 'এসি‌জেএম আদালত', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(3, 33, 'Senior Judicial Magistrate, 1st Court', 'এসজেএম-১', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(4, 33, 'Senior Judicial Magistrate, 2nd Court', 'এসজেএম-২', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(5, 33, 'Senior Judicial Magistrate, 3rd Court', 'এসজেএম-৩', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(6, 33, 'Senior Judicial Magistrate, 4th Court', 'এসজেএম-৪', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(7, 33, 'Judicial Magistrate, 1st Court', 'জুডিঃ ম্যাজিঃ-১', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(8, 33, 'Judicial Magistrate, 2nd Court', 'জুডিঃ ম্যাজিঃ-২', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(9, 33, 'Judicial Magistrate, 3rd Court', 'জুডিঃ ম্যাজিঃ-৩', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(10, 33, 'Judicial Magistrate, 4th Court', 'জুডিঃ ম্যাজিঃ-৪', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(11, 33, 'Judicial Magistrate, 5th Court', 'জুডিঃ ম্যাজিঃ-৫', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(12, 33, 'Chief Metropolitan Magistrate Court', 'সিএমএম আদালত', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(13, 33, 'Additional Chief Metropolitan Magistrate Court', 'এসি‌এমএম আদালত', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(14, 33, 'Metropolitan Magistrate, 1st Court', 'মেট্রো ম্যাজিঃ-১', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(15, 33, 'Metropolitan Magistrate, 2nd Court', 'মেট্রো ম্যাজিঃ-২', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(16, 33, 'Metropolitan Magistrate, 3rd Court', 'মেট্রো ম্যাজিঃ-৩', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38'),
(17, 33, 'District and Sessions Judge Court', 'জেলা জজ আদালত', 1, '2025-12-31 17:16:38', '2025-12-31 17:16:38');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
CREATE TABLE IF NOT EXISTS `districts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `division_id` bigint UNSIGNED NOT NULL,
  `name_en` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `districts_division_id_foreign` (`division_id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `division_id`, `name_en`, `name_bn`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Cumilla', 'কুমিল্লা', 1, '2025-09-29 23:35:45', '2025-10-03 07:20:39'),
(2, 1, 'Feni', 'ফেনী', 0, '2025-09-29 23:35:45', '2025-10-03 07:18:42'),
(3, 1, 'Brahmanbaria', 'ব্রাহ্মণবাড়িয়া', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(4, 1, 'Rangamati', 'রাঙ্গামাটি', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(5, 1, 'Noakhali', 'নোয়াখালী', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(6, 1, 'Chandpur', 'চাঁদপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(7, 1, 'Lakshmipur', 'লক্ষ্মীপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(8, 1, 'Chattogram', 'চট্টগ্রাম', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(9, 1, 'Cox\'s Bazar', 'কক্সবাজার', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(10, 1, 'Khagrachari', 'খাগড়াছড়ি', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(11, 1, 'Bandarban', 'বান্দরবান', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(12, 2, 'Sirajganj', 'সিরাজগঞ্জ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(13, 2, 'Pabna', 'পাবনা', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(14, 2, 'Bogra', 'বগুড়া', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(15, 2, 'Rajshahi', 'রাজশাহী', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(16, 2, 'Natore', 'নাটোর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(17, 2, 'Joypurhat', 'জয়পুরহাট', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(18, 2, 'Chapainawabganj', 'চাঁপাইনবাবগঞ্জ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(19, 2, 'Naogaon', 'নওগাঁ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(20, 3, 'Jessore', 'যশোর', 0, '2025-09-29 23:35:45', '2025-10-03 07:22:31'),
(21, 3, 'Satkhira', 'সাতক্ষীরা', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(22, 3, 'Meherpur', 'মেহেরপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(23, 3, 'Narail', 'নড়াইল', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(24, 3, 'Chuadanga', 'চুয়াডাঙ্গা', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(25, 3, 'Kushtia', 'কুষ্টিয়া', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(26, 3, 'Magura', 'মাগুরা', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(27, 3, 'Khulna', 'খুলনা', 1, '2025-09-29 23:35:45', '2025-10-03 07:22:49'),
(28, 3, 'Bagerhat', 'বাগেরহাট', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(29, 3, 'Jhenaidah', 'ঝিনাইদহ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(30, 4, 'Jhalokathi', 'ঝালকাঠি', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(31, 4, 'Patuakhali', 'পটুয়াখালী', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(32, 4, 'Pirojpur', 'পিরোজপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(33, 4, 'Barishal', 'বরিশাল', 1, '2025-09-29 23:35:45', '2025-10-03 07:21:10'),
(34, 4, 'Bhola', 'ভোলা', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(35, 4, 'Barguna', 'বরগুনা', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(36, 5, 'Sylhet', 'সিলেট', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(37, 5, 'Maulvibazar', 'মৌলভীবাজার', 1, '2025-09-29 23:35:45', '2025-10-03 07:21:20'),
(38, 5, 'Habiganj', 'হবিগঞ্জ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(39, 5, 'Sunamganj', 'সুনামগঞ্জ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(40, 6, 'Narsingdi', 'নরসিংদী', 1, '2025-09-29 23:35:45', '2025-10-03 07:22:09'),
(41, 6, 'Gazipur', 'গাজীপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(42, 6, 'Shariatpur', 'শরীয়তপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(43, 6, 'Narayanganj', 'নারায়ণগঞ্জ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(44, 6, 'Tangail', 'টাঙ্গাইল', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(45, 6, 'Kishoreganj', 'কিশোরগঞ্জ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(46, 6, 'Manikganj', 'মানিকগঞ্জ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(47, 6, 'Dhaka', 'ঢাকা', 1, '2025-09-29 23:35:45', '2025-10-03 07:21:33'),
(48, 6, 'Munshiganj', 'মুন্সীগঞ্জ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(49, 6, 'Rajbari', 'রাজবাড়ী', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(50, 6, 'Madaripur', 'মাদারীপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(51, 6, 'Gopalganj', 'গোপালগঞ্জ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(52, 6, 'Faridpur', 'ফরিদপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(53, 7, 'Panchagarh', 'পঞ্চগড়', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(54, 7, 'Dinajpur', 'দিনাজপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(55, 7, 'Lalmonirhat', 'লালমনিরহাট', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(56, 7, 'Nilphamari', 'নীলফামারী', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(57, 7, 'Gaibandha', 'গাইবান্ধা', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(58, 7, 'Thakurgaon', 'ঠাকুরগাঁও', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(59, 7, 'Rangpur', 'রংপুর', 1, '2025-09-29 23:35:45', '2025-10-03 07:21:47'),
(60, 7, 'Kurigram', 'কুড়িগ্রাম', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(61, 8, 'Sherpur', 'শেরপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(62, 8, 'Mymensingh', 'ময়মনসিংহ', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(63, 8, 'Jamalpur', 'জামালপুর', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(64, 8, 'Netrokona', 'নেত্রকোণা', 0, '2025-09-29 23:35:45', '2025-09-29 23:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

DROP TABLE IF EXISTS `divisions`;
CREATE TABLE IF NOT EXISTS `divisions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_en` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `divisions_name_en_unique` (`name_en`),
  UNIQUE KEY `divisions_name_bn_unique` (`name_bn`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisions`
--

INSERT INTO `divisions` (`id`, `name_en`, `name_bn`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Chattogram', 'চট্টগ্রাম', 1, '2025-09-29 23:35:45', '2025-10-03 07:10:07'),
(2, 'Rajshahi', 'রাজশাহী', 1, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(3, 'Khulna', 'খুলনা', 1, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(4, 'Barishal', 'বরিশাল', 1, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(5, 'Sylhet', 'সিলেট', 1, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(6, 'Dhaka', 'ঢাকা', 1, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(7, 'Rangpur', 'রংপুর', 1, '2025-09-29 23:35:45', '2025-09-29 23:35:45'),
(8, 'Mymensingh', 'ময়মনসিংহ', 1, '2025-09-29 23:35:45', '2025-09-29 23:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'sms', '{\"uuid\":\"9e42ad25-b15e-4960-8c0b-ff9fba783069\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":3:{s:2:\\\"to\\\";s:13:\\\"8801725132141\\\";s:7:\\\"message\\\";s:243:\\\"Limu, ২০২৬-০১-০৯ তারিখে ঢাকা এ Teszf মামলায় আপনাকে সাক্ষী হিসেবে উপস্থিত থাকার জন্য অনুরোধ করা হলো।\\\";s:5:\\\"queue\\\";s:3:\\\"sms\\\";}\"},\"createdAt\":1766936672,\"delay\":null}', 0, NULL, 1766936672, 1766936672),
(2, 'sms', '{\"uuid\":\"e62b9daa-2b9a-4684-8df4-a74234798648\",\"displayName\":\"App\\\\Jobs\\\\SendSmsJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SendSmsJob\",\"command\":\"O:19:\\\"App\\\\Jobs\\\\SendSmsJob\\\":3:{s:2:\\\"to\\\";s:13:\\\"8801725132141\\\";s:7:\\\"message\\\";s:243:\\\"hjh, ২০২৬-০১-০৮ তারিখে ঢাকা এ jdgkjb মামলায় আপনাকে সাক্ষী হিসেবে উপস্থিত থাকার জন্য অনুরোধ করা হলো।\\\";s:5:\\\"queue\\\";s:3:\\\"sms\\\";}\"},\"createdAt\":1766937118,\"delay\":null}', 0, NULL, 1766937118, 1766937118);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_templates`
--

DROP TABLE IF EXISTS `message_templates`;
CREATE TABLE IF NOT EXISTS `message_templates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_en_sms` text COLLATE utf8mb4_unicode_ci,
  `body_en_whatsapp` text COLLATE utf8mb4_unicode_ci,
  `body_bn_sms` text COLLATE utf8mb4_unicode_ci,
  `body_bn_whatsapp` text COLLATE utf8mb4_unicode_ci,
  `body_email` text COLLATE utf8mb4_unicode_ci,
  `channel` enum('sms','whatsapp','both','email') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sms',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `message_templates_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_templates`
--

INSERT INTO `message_templates` (`id`, `title`, `body_en_sms`, `body_en_whatsapp`, `body_bn_sms`, `body_bn_whatsapp`, `body_email`, `channel`, `is_active`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Initial Hearing Reminder', 'Dear {witness_name}, your case {case_no} is scheduled on {hearing_date} at {hearing_time}. Please attend on time.', 'Reminder: Dear {witness_name}, your case {case_no} will be heard on {hearing_date} at {hearing_time}. Kindly be present at the court.', '{witness_name}, {hearing_date} তারিখে {court_name} এ {case_no} মামলায় আপনাকে সাক্ষী হিসেবে উপস্থিত থাকার জন্য অনুরোধ করা হলো।', 'সতর্কবার্তা: {witness_name}, আপনার মামলা {case_no} {hearing_date} তারিখে {hearing_time} সময়ে শুনানি হবে। আদালতে উপস্থিত থাকুন।', 'Subject: Court Hearing Notification – {case_no}\n\nDear {witness_name},\n\nYour case {case_no} is scheduled for hearing on {hearing_date} at {hearing_time}. Please be present at the court.\n\nThank you,\nCourt Administration', 'sms', 1, 1, '2025-10-03 05:57:36', '2025-11-11 22:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `message_template_categories`
--

DROP TABLE IF EXISTS `message_template_categories`;
CREATE TABLE IF NOT EXISTS `message_template_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_en` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_bn` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_template_categories`
--

INSERT INTO `message_template_categories` (`id`, `name_en`, `name_bn`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'CourtSMS', 'কোর্টএসএমএস', 1, '2025-10-03 05:57:36', '2025-10-03 05:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_09_18_170452_create_permission_tables', 1),
(4, '2025_09_19_044952_create_permission_groups_table', 1),
(5, '2025_09_19_050039_add_group_id_to_permissions_table', 1),
(6, '2025_09_28_085642_create_divisions_table', 1),
(7, '2025_09_28_092921_create_districts_table', 1),
(8, '2025_09_28_100027_create_courts_table', 1),
(9, '2025_09_28_100027_create_users_table', 1),
(10, '2025_09_30_042045_create_cases_table', 1),
(22, '2025_09_30_042145_create_witnesses_table', 5),
(12, '2025_09_30_042332_create_message_template_categories_table', 1),
(13, '2025_09_30_042341_create_message_templates_table', 1),
(14, '2025_09_30_042343_create_notification_schedules_table', 1),
(15, '2025_09_30_042521_create_notifications_table', 1),
(18, '2025_10_05_125248_create_witness_attendances_table', 3),
(17, '2025_12_14_082531_create_case_hearings_table', 2),
(19, '2025_12_14_122218_create_witness_attendances_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(0, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 13),
(2, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 15),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 17),
(2, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `schedule_id` bigint UNSIGNED DEFAULT NULL,
  `witness_id` bigint UNSIGNED NOT NULL,
  `channel` enum('sms','whatsapp','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sms',
  `status` enum('pending','sent','delivered','failed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `sent_at` datetime DEFAULT NULL,
  `response` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_schedule_id_foreign` (`schedule_id`),
  KEY `notifications_witness_id_foreign` (`witness_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_schedules`
--

DROP TABLE IF EXISTS `notification_schedules`;
CREATE TABLE IF NOT EXISTS `notification_schedules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hearing_id` bigint UNSIGNED NOT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `channel` enum('sms','whatsapp','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sms',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `schedule_date` datetime DEFAULT NULL,
  `schedule_time` time DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_schedules_template_id_foreign` (`template_id`),
  KEY `notification_schedules_created_by_foreign` (`created_by`),
  KEY `notification_schedules_hearing_id_foreign` (`hearing_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  KEY `permissions_group_id_foreign` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `group_id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'View Permission', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(2, 1, 'Create Permission', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(3, 1, 'Edit Permission', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(4, 1, 'Delete Permission', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(5, 2, 'View Roles', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(6, 2, 'Create Role', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(7, 2, 'Edit Role', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(8, 2, 'Delete Role', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(9, 2, 'Assign Permissions', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(10, 3, 'View Permission Group', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(11, 3, 'Create Permission Group', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(12, 3, 'Edit Permission Group', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(13, 3, 'Delete Permission Group', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(14, 4, 'View Users', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(15, 4, 'Create Users', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(16, 4, 'Edit Users', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(17, 4, 'Delete Users', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(18, 4, 'View User Permissions', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(19, 5, 'View Division', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(20, 5, 'Create Division', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(21, 5, 'Edit Division', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(22, 5, 'Delete Divisioners', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(23, 6, 'View District', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(24, 6, 'Create District', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(25, 6, 'Edit District', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(26, 6, 'Delete District', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(27, 7, 'View Court', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(28, 7, 'Create Court', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(29, 7, 'Edit Court', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(30, 7, 'Delete Court', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(31, 8, 'SMS Form', 'web', '2025-09-30 01:04:04', '2025-09-30 01:04:04'),
(32, 8, 'Send SMS', 'web', '2025-09-30 01:04:13', '2025-09-30 01:04:13'),
(33, 9, 'View Message Template Category', 'web', '2025-10-03 06:29:17', '2025-10-03 06:29:17'),
(34, 9, 'Create Message Template Category', 'web', '2025-10-03 06:29:31', '2025-10-03 06:29:31'),
(35, 9, 'Edit Message Template Category', 'web', '2025-10-03 06:29:44', '2025-10-03 06:29:44'),
(36, 9, 'Delete Message Template Category', 'web', '2025-10-03 06:30:03', '2025-10-03 06:30:03'),
(37, 9, 'View Message Template', 'web', '2025-10-03 06:30:22', '2025-10-03 06:30:22'),
(38, 9, 'Create Message Template', 'web', '2025-10-03 06:30:35', '2025-10-03 06:30:35'),
(39, 9, 'Edit Message Template', 'web', '2025-10-03 06:30:48', '2025-10-03 06:30:48'),
(40, 9, 'Delete Message Template', 'web', '2025-10-03 06:30:59', '2025-10-03 06:30:59');

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

DROP TABLE IF EXISTS `permission_groups`;
CREATE TABLE IF NOT EXISTS `permission_groups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Permission Management', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(2, 'Role Managements', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(3, 'Permission Group Management', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(4, 'User Management', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(5, 'Division Management', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(6, 'District Management', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(7, 'Court Management', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(8, 'Sending SMS', '2025-09-30 01:02:46', '2025-09-30 01:02:46'),
(9, 'Message Template', '2025-10-03 06:28:47', '2025-10-03 06:28:47');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2025-12-31 16:56:48', '2025-12-31 16:57:03'),
(2, 'Court Staff', 'web', '2025-12-31 10:58:22', '2025-12-31 10:58:22'),
(3, 'District Focal', 'web', '2025-12-31 10:58:42', '2025-12-31 10:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(27, 3),
(28, 3),
(29, 3),
(31, 2),
(31, 3),
(32, 2),
(32, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('O3WK8n6FaNpe1GA0RqG5FtHbBN6muDJWL5Kx3aut', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZzdsNmxlZXBjSjhENXVVaEJLYWFRTENQNW1uSGZ2bUhQN25GcUlkMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ob21lIjtzOjU6InJvdXRlIjtzOjE1OiJhZG1pbi5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1767201784),
('jtKMEy2U2ZVxY6TykZXubS5Gd0R32XzteADEj26O', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMXBCalJ4R2xBU0tPc3BlNXNMaTR5U3JIQnhnSWNIbFcwUUpYVTJxeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4udXNlcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1767203198);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `division_id` bigint UNSIGNED DEFAULT NULL,
  `district_id` bigint UNSIGNED DEFAULT NULL,
  `court_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_division_id_foreign` (`division_id`),
  KEY `users_district_id_foreign` (`district_id`),
  KEY `users_court_id_foreign` (`court_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `division_id`, `district_id`, `court_id`, `name`, `email`, `phone_number`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'Super Admin', 'superadmin@example.com', NULL, NULL, '$2y$12$/CbptggB2PqvhwsAyfL9qeZ1XFvVzFmlsl4/5HQpnZnYR4/PhCGwy', 1, NULL, '2025-09-29 23:34:56', '2025-09-29 23:34:56'),
(2, 4, 33, 1, 'Md. Shafiqur Rahman', 'rahamanmdshafiq@gmail.com', '01915362903', NULL, '$2y$12$cE9gR5HIHmSE0Y/BRLm1UuQ2orurLxLbunHolHXjdC41q38xf7bii', 1, NULL, '2025-12-31 11:19:48', '2025-12-31 11:22:47'),
(3, 4, 33, 2, 'Md. Abul Kalam Azad', 'abulkalamazadcjmc1979@gmail.com', '01739441192', NULL, '$2y$12$8zWuf8aAXBM9AI1Rr9.MhuegZSeirefjaTrCwYSg8.0S4WHvsRsNK', 1, NULL, '2025-12-31 11:24:49', '2025-12-31 11:24:49'),
(4, 4, 33, 3, 'Md. Hafizur Rahman', 'hafizur1983cjmc@gmail.com', '01726831873', NULL, '$2y$12$2EpkDAOsneGRuTMsd4pdsOAhSUtFsKKylKAIpB8hRs5PBZurId2yS', 1, NULL, '2025-12-31 11:26:01', '2025-12-31 11:26:01'),
(5, 4, 33, 4, 'Md. Enamul Haque', 'enamulcjmcourtbarisal85@gmail.com', '01795510071', NULL, '$2y$12$ohSQ0.3mGiW9kcOzN1frC.oAJ5w6A1zaJzvNrio4TbUvR0.kdsBcK', 1, NULL, '2025-12-31 11:27:27', '2025-12-31 11:27:27'),
(6, 4, 33, 5, 'Halima', 'halimasteno@gmail.com', '01732808216', NULL, '$2y$12$pwjWuJFcRkbM46uMTNPw.uSdkDCs.3m02/dmZwZK7IqQi9tAF8eXm', 1, NULL, '2025-12-31 11:28:30', '2025-12-31 11:28:30'),
(7, 4, 33, 6, 'Arjun Bishwas', 'arjoun1982@gmail.com', '01718693654', NULL, '$2y$12$UAqnd2Zmj1WbR48dDLuRTu3EOtzcAMRPGHOTWrRM/23Ca7KSEA/JS', 1, NULL, '2025-12-31 11:29:46', '2025-12-31 11:29:46'),
(8, 4, 33, 7, 'Md. Yeasin', 'easinkary@gmail.com', '01729108421', NULL, '$2y$12$I5vgdDrJraZxhxXtnEANeeCDGvUalwm2q0B2FMFM0OPtss01qqHp2', 1, NULL, '2025-12-31 11:30:52', '2025-12-31 11:30:52'),
(9, 4, 33, 8, 'Lavli Akter', '1282015@gmail.com', '01716378389', NULL, '$2y$12$X2BE9rCRQ/x2k2/Ya/yUTu7BY8NLqcav9CVtmHKMjlDepNTkdF/wG', 1, NULL, '2025-12-31 11:32:36', '2025-12-31 11:32:36'),
(10, 4, 33, 9, 'Md. Firoz Alam', 'firojalombk@gmail.com', '01710022000', NULL, '$2y$12$Z9ZY5ZjGBrePL7O167yJoe95SXlSUCpfoY89c2DPRqq7ZOARe5qsO', 1, NULL, '2025-12-31 11:33:35', '2025-12-31 11:33:35'),
(11, 4, 33, 10, 'Md. Nurul Islam', 'kakonislam010@gmail.com', '01712128770', NULL, '$2y$12$WbDxITd/kd4afJGDlZewh.NAX3rNp2nS6qjs/jEiGYH0VzBDQaBFm', 1, NULL, '2025-12-31 11:34:34', '2025-12-31 11:34:34'),
(12, 4, 33, 11, 'Md. Atiqur Rahman', 'atiksteno@gmail.com', '01716184122', NULL, '$2y$12$bIZ/qSTxvim54wmeBn0s7.uMkVDq8pWLChGI1Mf6DBeIwyOj8IkO6', 1, NULL, '2025-12-31 11:37:28', '2025-12-31 11:37:28'),
(13, 4, 33, 12, 'Md. Nur Sayeed Hawladar', 'cmmcourt.gov.bd@gmail.com', '01832944475', NULL, '$2y$12$szC5alwU2QY0Fsd9vitQQuqQ5M8JMjq37aVlLb.ronXFzRjxGjVsm', 1, NULL, '2025-12-31 11:39:30', '2025-12-31 11:39:30'),
(14, 4, 33, 13, 'Md. Helal Hossen', 'helalhossain191@gmail.com', '01725815191', NULL, '$2y$12$4ILmq8oNbvK99LyqvKyR0uZ7YAPG/rooTtaHGtV3p8qh.45f.26dW', 1, NULL, '2025-12-31 11:40:40', '2025-12-31 11:40:40'),
(15, 4, 33, 14, 'Md. Jolil Hossen', 'selim2024rajbari@gmail.com', '01964670072', NULL, '$2y$12$SfPUwY.CX.AmtjHroAaFve9KZ7rDTus6EQvNxMHyNaO3J.tMcWq6S', 1, NULL, '2025-12-31 11:41:37', '2025-12-31 11:41:37'),
(16, 4, 33, 15, 'Md. Abdullah-Al-Sohan', 'sohanabdullah58@gmail.com', '01926950622', NULL, '$2y$12$8roPhs9FBCWrf46rD4OwleyC0QVzogTxv.a9tI.x6y3vfZ5cJqNzi', 1, NULL, '2025-12-31 11:44:05', '2025-12-31 11:44:05'),
(17, 4, 33, 16, 'Md. Mahabub Hossen', 'stenomahabub@gmail.com', '01734413670', NULL, '$2y$12$KO8Tvjj2aaeqNU7lNQ6mIuLoyvuZYPnJWqfHJh1.HCubcH3jSO/0u', 1, NULL, '2025-12-31 11:45:32', '2025-12-31 11:45:32'),
(18, 4, 33, 17, 'Taijul Islam Labu', 'taijullabu@gmail.com', '01720592912', NULL, '$2y$12$NY5yBhOW2haXnFvafJgz4e455eR417vtsXe73dtcKN11YTnt2B4gG', 1, NULL, '2025-12-31 11:46:35', '2025-12-31 11:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `witnesses`
--

DROP TABLE IF EXISTS `witnesses`;
CREATE TABLE IF NOT EXISTS `witnesses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hearing_id` bigint UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appeared_status` enum('pending','appeared','absent','excused') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `gender` enum('Female','Male','Third Gender') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `others_info` enum('Under 18','Person with Disability') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_seen` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `witness_heard` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `witnesses_hearing_id_foreign` (`hearing_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `witness_attendances`
--

DROP TABLE IF EXISTS `witness_attendances`;
CREATE TABLE IF NOT EXISTS `witness_attendances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `hearing_id` bigint UNSIGNED NOT NULL,
  `witness_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','appeared','absent','excused') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `witness_attendances_hearing_id_foreign` (`hearing_id`),
  KEY `witness_attendances_witness_id_foreign` (`witness_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
