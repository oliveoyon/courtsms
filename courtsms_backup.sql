-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2025 at 08:21 AM
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
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:8:\"group_id\";s:1:\"c\";s:4:\"name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:40:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";i:1;s:1:\"c\";s:15:\"View Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";i:1;s:1:\"c\";s:17:\"Create Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";i:1;s:1:\"c\";s:15:\"Edit Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";i:1;s:1:\"c\";s:17:\"Delete Permission\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";i:2;s:1:\"c\";s:10:\"View Roles\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";i:2;s:1:\"c\";s:11:\"Create Role\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";i:2;s:1:\"c\";s:9:\"Edit Role\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";i:2;s:1:\"c\";s:11:\"Delete Role\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";i:2;s:1:\"c\";s:18:\"Assign Permissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";i:3;s:1:\"c\";s:21:\"View Permission Group\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";i:3;s:1:\"c\";s:23:\"Create Permission Group\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";i:3;s:1:\"c\";s:21:\"Edit Permission Group\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";i:3;s:1:\"c\";s:23:\"Delete Permission Group\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";i:4;s:1:\"c\";s:10:\"View Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";i:4;s:1:\"c\";s:12:\"Create Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";i:4;s:1:\"c\";s:10:\"Edit Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";i:4;s:1:\"c\";s:12:\"Delete Users\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";i:4;s:1:\"c\";s:21:\"View User Permissions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";i:5;s:1:\"c\";s:13:\"View Division\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";i:5;s:1:\"c\";s:15:\"Create Division\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";i:5;s:1:\"c\";s:13:\"Edit Division\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";i:5;s:1:\"c\";s:18:\"Delete Divisioners\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";i:6;s:1:\"c\";s:13:\"View District\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";i:6;s:1:\"c\";s:15:\"Create District\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";i:6;s:1:\"c\";s:13:\"Edit District\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";i:6;s:1:\"c\";s:15:\"Delete District\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";i:7;s:1:\"c\";s:10:\"View Court\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";i:7;s:1:\"c\";s:12:\"Create Court\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";i:7;s:1:\"c\";s:10:\"Edit Court\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";i:7;s:1:\"c\";s:12:\"Delete Court\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";i:8;s:1:\"c\";s:8:\"SMS Form\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:2;i:1;i:3;i:2;i:4;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";i:8;s:1:\"c\";s:8:\"Send SMS\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:2;i:1;i:3;i:2;i:4;}}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";i:9;s:1:\"c\";s:30:\"View Message Template Category\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";i:9;s:1:\"c\";s:32:\"Create Message Template Category\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";i:9;s:1:\"c\";s:30:\"Edit Message Template Category\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";i:9;s:1:\"c\";s:32:\"Delete Message Template Category\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";i:9;s:1:\"c\";s:21:\"View Message Template\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:2;i:1;i:4;}}i:37;a:5:{s:1:\"a\";i:38;s:1:\"b\";i:9;s:1:\"c\";s:23:\"Create Message Template\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:38;a:5:{s:1:\"a\";i:39;s:1:\"b\";i:9;s:1:\"c\";s:21:\"Edit Message Template\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:39;a:5:{s:1:\"a\";i:40;s:1:\"b\";i:9;s:1:\"c\";s:23:\"Delete Message Template\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}}s:5:\"roles\";a:3:{i:0;a:3:{s:1:\"a\";i:2;s:1:\"c\";s:14:\"Ministry Focal\";s:1:\"d\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:4;s:1:\"c\";s:14:\"District Focal\";s:1:\"d\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"c\";s:11:\"Court Staff\";s:1:\"d\";s:3:\"web\";}}}', 1762943463),
('laravel-cache-supseradmin@example.com|127.0.0.1:timer', 'i:1762855552;', 1762855552),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1762920672;', 1762920672),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1762920672),
('laravel-cache-superadmin@email.com|127.0.0.1:timer', 'i:1762769727;', 1762769727),
('laravel-cache-superadmin@email.com|127.0.0.1', 'i:1;', 1762769727),
('laravel-cache-supseradmin@example.com|127.0.0.1', 'i:1;', 1762855552),
('laravel-cache-court_sms_token', 's:1373:\"eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJxNHVPQ1VLTkw2NzRyU1A0eDBraWRmdmFnNG1aSTZpb0NsbEFBRXoxLUpRIn0.eyJleHAiOjE3NjI5MjgyNjUsImlhdCI6MTc2MjkyNzk2NSwianRpIjoiOGY5OGEyOTgtZDhhNC00NDQ4LThmNDAtYTE1ZDc2ZGJiMDQ0IiwiaXNzIjoiaHR0cHM6Ly9pZHAub3NzLm5ldC5iZC9hdXRoL3JlYWxtcy9kZXYiLCJhdWQiOlsiYWNjb3VudCIsImJyb2tlci1hcGkiXSwic3ViIjoiNmIzZThiZDQtY2ZiNC00YTRiLWI1MDItMTZlZjNlM2UzYjJjIiwidHlwIjoiQmVhcmVyIiwiYXpwIjoiQ291cnQgU01TIiwiYWNyIjoiMSIsImFsbG93ZWQtb3JpZ2lucyI6WyJodHRwOi8vbG9jYWxob3N0OjgwODAvIl0sInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJib3JrZXItdWktYWRtaW4iLCJkZWZhdWx0LXJvbGVzLWRldiIsIm9mZmxpbmVfYWNjZXNzIiwidW1hX2F1dGhvcml6YXRpb24iLCJVU0VSIl19LCJyZXNvdXJjZV9hY2Nlc3MiOnsiYWNjb3VudCI6eyJyb2xlcyI6WyJtYW5hZ2UtYWNjb3VudCIsInZpZXctcHJvZmlsZSJdfSwiYnJva2VyLWFwaSI6eyJyb2xlcyI6WyJVU0VSIl19fSwic2NvcGUiOiJwcm9maWxlIGVtYWlsIiwiY2xpZW50SG9zdCI6IjExNS4xMjcuODQuMTAwIiwiY2xpZW50SWQiOiJDb3VydCBTTVMiLCJlbWFpbF92ZXJpZmllZCI6ZmFsc2UsInByZWZlcnJlZF91c2VybmFtZSI6InNlcnZpY2UtYWNjb3VudC1jb3VydCBzbXMiLCJjbGllbnRBZGRyZXNzIjoiMTE1LjEyNy44NC4xMDAifQ.J4lLqEs1Fu18co0wmrwt2ALqY06-5QvKsIxGcq9ZTlgntUA5lA2eSuHhVDD3rcA0Q_H4kzV7b-eqjFrbdbjX1teURKSdAl3gDefZw6vw3wsqfUZCo_cqaz7YDCCkvgRw27v5q51y9JSqqXS1f4wz-DehkjQs3HseysQ_3gg4rLmWJX4XJomT0j9qiDimDM_90OEdhVG-DIc3eazYDx_Qpc57EHUjOdYDV7znio-ITAec6ifw9nDp8vHGlDxbeeLPIbXNDiu39MFvXfDLEdgvTxoM_isn0RNbEbOaibjhTPiD2E0zf1siT91QenUTbQy1w22oXthuQvTkqyMLP2qt_Q\";', 1762930966);

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
-- Table structure for table `case_reschedules`
--

DROP TABLE IF EXISTS `case_reschedules`;
CREATE TABLE IF NOT EXISTS `case_reschedules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `case_id` bigint UNSIGNED NOT NULL,
  `reschedule_date` date NOT NULL,
  `reschedule_time` time DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `case_reschedules_case_id_foreign` (`case_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courts`
--

INSERT INTO `courts` (`id`, `district_id`, `name_en`, `name_bn`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 47, 'Dhaka Judge Court', 'ঢাকা জেলা আদালত', 1, '2025-09-30 00:17:10', '2025-09-30 00:17:10'),
(2, 47, 'Dhaka CMM Court', 'ঢাকা সিএমএম আদালত', 1, '2025-10-13 00:14:19', '2025-10-13 00:14:19'),
(3, 40, 'Narsingdi Judge Court', 'নরসিংদী জেলা আদালত', 1, '2025-10-13 00:15:22', '2025-10-13 00:16:47'),
(4, 40, 'Narsingdi CMM Court', 'নরসিংদী সিএমএম আদালত', 1, '2025-10-13 00:16:09', '2025-10-13 00:16:09');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_templates`
--

INSERT INTO `message_templates` (`id`, `title`, `body_en_sms`, `body_en_whatsapp`, `body_bn_sms`, `body_bn_whatsapp`, `body_email`, `channel`, `is_active`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Initial Hearing Reminder', 'Dear {witness_name}, your case {case_no} is scheduled on {hearing_date} at {hearing_time}. Please attend on time.', 'Reminder: Dear {witness_name}, your case {case_no} will be heard on {hearing_date} at {hearing_time}. Kindly be present at the court.', '{witness_name}, {hearing_date} তারিখে {court_name} এ {case_no} মামলায় আপনাকে সাক্ষী হিসেবে উপস্থিত থাকার জন্য অনুরোধ করা হলো।', 'সতর্কবার্তা: {witness_name}, আপনার মামলা {case_no} {hearing_date} তারিখে {hearing_time} সময়ে শুনানি হবে। আদালতে উপস্থিত থাকুন।', 'Subject: Court Hearing Notification – {case_no}\n\nDear {witness_name},\n\nYour case {case_no} is scheduled for hearing on {hearing_date} at {hearing_time}. Please be present at the court.\n\nThank you,\nCourt Administration', 'sms', 1, 3, '2025-10-03 05:57:36', '2025-11-11 22:38:49'),
(2, 'Hearing Adjourned', 'Hello {witness_name}, your case {case_no} hearing has been adjourned. Please check with the court for the new date.', 'Notice: {witness_name}, your case {case_no} hearing is adjourned. Contact the court for updated schedule.', 'হ্যালো {witness_name}, মামলা {case_no} এর শুনানি স্থগিত করা হয়েছে। নতুন তারিখ জানতে আদালতের সাথে যোগাযোগ করুন।', 'নোটিশ: {witness_name}, মামলা {case_no} এর শুনানি স্থগিত করা হয়েছে। আদালতের সাথে যোগাযোগ করুন।', 'Subject: Hearing Adjourned – {case_no}\n\nDear {witness_name},\n\nYour case {case_no} hearing has been adjourned. Please contact the court for the new date.\n\nThank you,\nCourt Administration', 'both', 0, 3, '2025-10-03 05:57:36', '2025-11-11 22:38:49'),
(3, 'Important Notice', 'Hello {witness_name}, please note an important update regarding your case {case_no}. Check email or court notice.', 'Important: {witness_name}, update for case {case_no}. Check email or court notice.', 'হ্যালো {witness_name}, মামলা {case_no} সম্পর্কিত গুরুত্বপূর্ণ তথ্য। ইমেল বা আদালতের বিজ্ঞপ্তি দেখুন।', 'গুরুত্বপূর্ণ: {witness_name}, মামলা {case_no} এর জন্য আপডেট। ইমেল বা আদালতের বিজ্ঞপ্তি দেখুন।', 'Subject: Important Update – {case_no}\n\nDear {witness_name},\n\nThere is an important update regarding your case {case_no}. Please check your email or court notice for details.\n\nThanks,\nCourt Administration', 'both', 1, 4, '2025-10-03 05:57:36', '2025-10-03 05:57:36'),
(4, 'Follow-up Reminder', 'Hello {witness_name}, this is a reminder for your case {case_no} scheduled on {hearing_date} at {hearing_time}.', 'Reminder: {witness_name}, your case {case_no} is coming up on {hearing_date} at {hearing_time}.', 'হ্যালো {witness_name}, মামলা {case_no} এর জন্য {hearing_date} তারিখে {hearing_time} সময়ে উপস্থিত থাকুন।', 'নোটিশ: {witness_name}, মামলা {case_no} {hearing_date} তারিখে {hearing_time} সময়ে অনুষ্ঠিত হবে। উপস্থিত থাকুন।', 'Subject: Court Hearing Reminder – {case_no}\n\nDear {witness_name},\n\nReminder: Your case {case_no} is scheduled on {hearing_date} at {hearing_time}. Please be present at the court.\n\nThanks,\nCourt Administration', 'both', 1, 5, '2025-10-03 05:57:36', '2025-10-03 05:57:36');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_template_categories`
--

INSERT INTO `message_template_categories` (`id`, `name_en`, `name_bn`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'First Message', 'বরিশাল', 1, '2025-10-03 05:48:06', '2025-10-03 05:48:06'),
(2, 'Second Message', 'কুমিল্লা', 1, '2025-10-03 05:48:26', '2025-10-03 05:48:26'),
(3, 'CourtSMS', 'কোর্টএসএমএস', 1, '2025-10-03 05:57:36', '2025-10-03 05:57:36'),
(4, 'Urgent Notices', 'জরুরি বিজ্ঞপ্তি', 1, '2025-10-03 05:57:36', '2025-10-03 05:57:36'),
(5, 'Reminders', 'মনে করিয়ে দিচ্ছে', 1, '2025-10-03 05:57:36', '2025-10-03 05:57:36'),
(6, 'Follow-ups', 'ফলোআপ', 1, '2025-10-03 05:57:36', '2025-10-03 05:57:36');

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_18_170452_create_permission_tables', 1),
(5, '2025_09_19_044952_create_permission_groups_table', 1),
(6, '2025_09_19_050039_add_group_id_to_permissions_table', 1),
(7, '2025_09_28_085642_create_divisions_table', 1),
(8, '2025_09_28_092921_create_districts_table', 1),
(9, '2025_09_28_100027_create_courts_table', 1),
(10, '2025_09_30_042045_create_cases_table', 1),
(11, '2025_09_30_042145_create_witnesses_table', 1),
(20, '2025_10_04_042241_create_message_templates_table', 5),
(21, '2025_09_30_042342_create_notification_defaults_table', 6),
(14, '2025_09_30_042521_create_notifications_table', 1),
(15, '2025_09_30_052839_create_notification_schedules_table', 1),
(19, '2025_10_03_114018_create_message_template_categories_table', 4),
(22, '2025_10_05_125153_create_case_reschedules_table', 7),
(23, '2025_10_05_125248_create_witness_attendances_table', 7);

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
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 2),
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
-- Table structure for table `notification_defaults`
--

DROP TABLE IF EXISTS `notification_defaults`;
CREATE TABLE IF NOT EXISTS `notification_defaults` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `days_before` int NOT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_defaults_template_id_foreign` (`template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_schedules`
--

DROP TABLE IF EXISTS `notification_schedules`;
CREATE TABLE IF NOT EXISTS `notification_schedules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `case_id` bigint UNSIGNED NOT NULL,
  `template_id` bigint UNSIGNED NOT NULL,
  `channel` enum('sms','whatsapp','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sms',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `schedule_date` datetime DEFAULT NULL,
  `schedule_time` time DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_schedules_case_id_foreign` (`case_id`),
  KEY `notification_schedules_template_id_foreign` (`template_id`),
  KEY `notification_schedules_created_by_foreign` (`created_by`)
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
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2025-09-29 23:34:55', '2025-09-29 23:34:55'),
(2, 'Ministry Focal', 'web', '2025-09-29 23:34:55', '2025-10-12 10:07:27'),
(3, 'Court Staff', 'web', '2025-09-30 00:17:56', '2025-09-30 00:17:56'),
(4, 'District Focal', 'web', '2025-10-01 09:10:44', '2025-10-01 09:10:44');

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
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(14, 4),
(15, 2),
(15, 4),
(16, 2),
(16, 4),
(17, 2),
(17, 4),
(18, 2),
(18, 4),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(27, 4),
(28, 2),
(28, 4),
(29, 2),
(29, 4),
(30, 2),
(30, 4),
(31, 2),
(31, 3),
(31, 4),
(32, 2),
(32, 3),
(32, 4),
(33, 2),
(33, 4),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(37, 4),
(38, 2),
(39, 2),
(40, 2);

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
('gbg6mU2u6CjgwGvqmyfgajBD97Fq4kdyVjgm19TA', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoib2YyczhDYWI5aXZMbG9LTGFFMWdxbkN4S0wyVkpWZWl3QnNRZ1dmcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi91c2VycyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo2OiJsb2NhbGUiO3M6MjoiYm4iO30=', 1762935554);

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `division_id`, `district_id`, `court_id`, `name`, `email`, `phone_number`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'Super Admin', 'superadmin@example.com', NULL, NULL, '$2y$12$/CbptggB2PqvhwsAyfL9qeZ1XFvVzFmlsl4/5HQpnZnYR4/PhCGwy', 1, NULL, '2025-09-29 23:34:56', '2025-09-29 23:34:56'),
(2, 6, 47, 1, 'Court Staff DSJ - Dhaka', 'dhakadsj@email.com', '01823456789', NULL, '$2y$12$obWswM.AjMOD8zC71bItKOucBn2bfiEJh0QEGw9.qOZb1v2NcpHWK', 1, NULL, '2025-09-30 00:18:21', '2025-10-13 00:18:40'),
(3, 6, 47, NULL, 'District Focal - Dhaka', 'dhakafocal@email.com', '01712105154', NULL, '$2y$12$6QcAAOVfVTc./5GWGeF4u.PodgHXC2a8/OzmVUfMGOIRxvkfTfeGK', 1, NULL, '2025-10-01 09:12:31', '2025-10-13 00:18:03'),
(4, 6, 47, 2, 'Court Staff CMM - Dhaka', 'dhakacmm@email.com', '01823456789', NULL, '$2y$12$y9O/HPnBv62ibUfFRdhA5.wlrGQInDQpmMaVluBtOsABTZOazD5ay', 1, NULL, '2025-10-13 00:19:39', '2025-10-13 00:19:39'),
(5, 6, 40, 4, 'Court Staff CMM - Narsingdi', 'narcmm@email.com', '01823456789', NULL, '$2y$12$6vlr4FDVTU.xHktUfXnXUuCXNY9IuP.9x.MMAG0G8UnTHOHiEM6n2', 1, NULL, '2025-10-13 00:20:44', '2025-10-13 00:20:44'),
(6, 6, 40, 3, 'Court Staff DSJ - Narsingdi', 'nardsj@email.com', '01823456789', NULL, '$2y$12$Z6OkEi4oETYQxc5GPdQ0Y.fmen/SuCM3/oGj.oOERgC7xgSR4HlUi', 1, NULL, '2025-10-13 00:22:18', '2025-10-13 00:22:18'),
(7, 6, 40, NULL, 'District Focal - Narsingdi', 'narfocal@email.com', '01712105580', NULL, '$2y$12$9GsTNIVjjZr/BTe4ymtEqOqdDyCBdyMslLHLB22qtvpTmIpY.5zmq', 1, NULL, '2025-10-13 00:23:41', '2025-10-13 00:23:41'),
(8, NULL, NULL, NULL, 'Ministry Focal', 'ministry@email.com', '01741354741', NULL, '$2y$12$nJlGepY3Bkj4aB1glsV8kuBVCQHmbENsJgbeKsYHJZAndeh1Y23FS', 1, NULL, '2025-10-13 00:25:10', '2025-10-13 00:25:10');

-- --------------------------------------------------------

--
-- Table structure for table `witnesses`
--

DROP TABLE IF EXISTS `witnesses`;
CREATE TABLE IF NOT EXISTS `witnesses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `case_id` bigint UNSIGNED NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appeared_status` enum('pending','appeared','absent','excused') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `witnesses_case_id_foreign` (`case_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `witness_attendances`
--

DROP TABLE IF EXISTS `witness_attendances`;
CREATE TABLE IF NOT EXISTS `witness_attendances` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `case_id` bigint UNSIGNED NOT NULL,
  `witness_id` bigint UNSIGNED NOT NULL,
  `hearing_date` date NOT NULL,
  `hearing_time` time DEFAULT NULL,
  `status` enum('pending','appeared','absent','excused') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `witness_attendances_case_id_foreign` (`case_id`),
  KEY `witness_attendances_witness_id_foreign` (`witness_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
