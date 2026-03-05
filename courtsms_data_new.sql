-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 23, 2025 at 06:02 AM
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
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1766469448;', 1766469448),
('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1766469448),
('laravel-cache-court_sms_token', 's:1439:\"eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJxNHVPQ1VLTkw2NzRyU1A0eDBraWRmdmFnNG1aSTZpb0NsbEFBRXoxLUpRIn0.eyJleHAiOjE3NjU3MTU5MDQsImlhdCI6MTc2NTcxNTYwNCwianRpIjoiNWQ2NWI1OTItOWQ0ZC00OGU1LWIwYjktMjRlNDlkN2RmMmY3IiwiaXNzIjoiaHR0cHM6Ly9pZHAub3NzLm5ldC5iZC9hdXRoL3JlYWxtcy9kZXYiLCJhdWQiOlsiYWNjb3VudCIsImJyb2tlci1hcGkiXSwic3ViIjoiNmIzZThiZDQtY2ZiNC00YTRiLWI1MDItMTZlZjNlM2UzYjJjIiwidHlwIjoiQmVhcmVyIiwiYXpwIjoiQ291cnQgU01TIiwiYWNyIjoiMSIsImFsbG93ZWQtb3JpZ2lucyI6WyJodHRwOi8vbG9jYWxob3N0OjgwODAvIl0sInJlYWxtX2FjY2VzcyI6eyJyb2xlcyI6WyJib3JrZXItdWktYWRtaW4iLCJkZWZhdWx0LXJvbGVzLWRldiIsIm9mZmxpbmVfYWNjZXNzIiwidW1hX2F1dGhvcml6YXRpb24iLCJVU0VSIl19LCJyZXNvdXJjZV9hY2Nlc3MiOnsiYWNjb3VudCI6eyJyb2xlcyI6WyJtYW5hZ2UtYWNjb3VudCIsInZpZXctcHJvZmlsZSJdfSwiYnJva2VyLWFwaSI6eyJyb2xlcyI6WyJVU0VSIl19fSwic2NvcGUiOiJwcm9maWxlIGVtYWlsIiwiY2xpZW50SG9zdCI6IjI0MDA6YzYwMDozMzU2OjQwODQ6YTRlNTo3ZGFlOjk4MzU6ZGJkMyIsImNsaWVudElkIjoiQ291cnQgU01TIiwiZW1haWxfdmVyaWZpZWQiOmZhbHNlLCJwcmVmZXJyZWRfdXNlcm5hbWUiOiJzZXJ2aWNlLWFjY291bnQtY291cnQgc21zIiwiY2xpZW50QWRkcmVzcyI6IjI0MDA6YzYwMDozMzU2OjQwODQ6YTRlNTo3ZGFlOjk4MzU6ZGJkMyJ9.FC1heJFwmRNYDIUXXiQ7qWj2aR8yCe96m_gKP9WAQz9EeagOOv1rZIkbxar5lAIFEyv1R_1B4yZZChwc5QJaTyRjx1LBLrCO-oCgOEsGSE1Bd_06c4y0p0bl4dAohpRtIqfZV_dcEstd2nxyiH_-lfofMwxV1KzX-9QCPj3Cn9yv5qPv_ycNp--u6MylYLnSEMtpCoJ3NeFTKMmcG10cTdDmMbbrL1H-2_3M3kAY4wPnx1DpjxxePePPyG-_nPqxJX0OnhUnS90zBCK4aoFsYEDQNwwIcZf3dtrqH-qWQPtXT6jaAjnmCIJT0vikQ56c-GCLJdHLXhJNuQ26TzO5gA\";', 1765718605),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:8:\"group_id\";s:1:\"c\";s:4:\"name\";s:1:\"d\";s:10:\"guard_name\";}s:11:\"permissions\";a:40:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";i:1;s:1:\"c\";s:15:\"View Permission\";s:1:\"d\";s:3:\"web\";}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";i:1;s:1:\"c\";s:17:\"Create Permission\";s:1:\"d\";s:3:\"web\";}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";i:1;s:1:\"c\";s:15:\"Edit Permission\";s:1:\"d\";s:3:\"web\";}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";i:1;s:1:\"c\";s:17:\"Delete Permission\";s:1:\"d\";s:3:\"web\";}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";i:2;s:1:\"c\";s:10:\"View Roles\";s:1:\"d\";s:3:\"web\";}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";i:2;s:1:\"c\";s:11:\"Create Role\";s:1:\"d\";s:3:\"web\";}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";i:2;s:1:\"c\";s:9:\"Edit Role\";s:1:\"d\";s:3:\"web\";}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";i:2;s:1:\"c\";s:11:\"Delete Role\";s:1:\"d\";s:3:\"web\";}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";i:2;s:1:\"c\";s:18:\"Assign Permissions\";s:1:\"d\";s:3:\"web\";}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";i:3;s:1:\"c\";s:21:\"View Permission Group\";s:1:\"d\";s:3:\"web\";}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";i:3;s:1:\"c\";s:23:\"Create Permission Group\";s:1:\"d\";s:3:\"web\";}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";i:3;s:1:\"c\";s:21:\"Edit Permission Group\";s:1:\"d\";s:3:\"web\";}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";i:3;s:1:\"c\";s:23:\"Delete Permission Group\";s:1:\"d\";s:3:\"web\";}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";i:4;s:1:\"c\";s:10:\"View Users\";s:1:\"d\";s:3:\"web\";}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";i:4;s:1:\"c\";s:12:\"Create Users\";s:1:\"d\";s:3:\"web\";}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";i:4;s:1:\"c\";s:10:\"Edit Users\";s:1:\"d\";s:3:\"web\";}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";i:4;s:1:\"c\";s:12:\"Delete Users\";s:1:\"d\";s:3:\"web\";}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";i:4;s:1:\"c\";s:21:\"View User Permissions\";s:1:\"d\";s:3:\"web\";}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";i:5;s:1:\"c\";s:13:\"View Division\";s:1:\"d\";s:3:\"web\";}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";i:5;s:1:\"c\";s:15:\"Create Division\";s:1:\"d\";s:3:\"web\";}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";i:5;s:1:\"c\";s:13:\"Edit Division\";s:1:\"d\";s:3:\"web\";}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";i:5;s:1:\"c\";s:18:\"Delete Divisioners\";s:1:\"d\";s:3:\"web\";}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";i:6;s:1:\"c\";s:13:\"View District\";s:1:\"d\";s:3:\"web\";}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";i:6;s:1:\"c\";s:15:\"Create District\";s:1:\"d\";s:3:\"web\";}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";i:6;s:1:\"c\";s:13:\"Edit District\";s:1:\"d\";s:3:\"web\";}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";i:6;s:1:\"c\";s:15:\"Delete District\";s:1:\"d\";s:3:\"web\";}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";i:7;s:1:\"c\";s:10:\"View Court\";s:1:\"d\";s:3:\"web\";}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";i:7;s:1:\"c\";s:12:\"Create Court\";s:1:\"d\";s:3:\"web\";}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";i:7;s:1:\"c\";s:10:\"Edit Court\";s:1:\"d\";s:3:\"web\";}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";i:7;s:1:\"c\";s:12:\"Delete Court\";s:1:\"d\";s:3:\"web\";}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";i:8;s:1:\"c\";s:8:\"SMS Form\";s:1:\"d\";s:3:\"web\";}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";i:8;s:1:\"c\";s:8:\"Send SMS\";s:1:\"d\";s:3:\"web\";}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";i:9;s:1:\"c\";s:30:\"View Message Template Category\";s:1:\"d\";s:3:\"web\";}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";i:9;s:1:\"c\";s:32:\"Create Message Template Category\";s:1:\"d\";s:3:\"web\";}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";i:9;s:1:\"c\";s:30:\"Edit Message Template Category\";s:1:\"d\";s:3:\"web\";}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";i:9;s:1:\"c\";s:32:\"Delete Message Template Category\";s:1:\"d\";s:3:\"web\";}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";i:9;s:1:\"c\";s:21:\"View Message Template\";s:1:\"d\";s:3:\"web\";}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";i:9;s:1:\"c\";s:23:\"Create Message Template\";s:1:\"d\";s:3:\"web\";}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";i:9;s:1:\"c\";s:21:\"Edit Message Template\";s:1:\"d\";s:3:\"web\";}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";i:9;s:1:\"c\";s:23:\"Delete Message Template\";s:1:\"d\";s:3:\"web\";}}s:5:\"roles\";a:0:{}}', 1766555793);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `case_no`, `court_id`, `hearing_date`, `hearing_time`, `reschedule_date`, `reschedule_time`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'জিআর ১২৫/২৫s', 1, '2025-12-29', NULL, NULL, NULL, NULL, 1, '2025-12-14 05:27:44', '2025-12-14 05:27:44'),
(2, 'fdsgdsg', 1, '2026-01-02', NULL, NULL, NULL, NULL, 1, '2025-12-14 06:31:34', '2025-12-14 06:31:34');

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
(1, 1, '2026-01-02', NULL, 1, 1, '2025-12-14 05:27:44', '2025-12-14 06:30:15'),
(2, 2, '2025-12-06', NULL, 1, 1, '2025-12-14 06:31:34', '2025-12-18 01:24:30');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courts`
--

INSERT INTO `courts` (`id`, `district_id`, `name_en`, `name_bn`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 47, 'Dhaka', 'ঢাকা', 1, '2025-12-14 02:30:08', '2025-12-14 02:30:08');

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(11, '2025_09_30_042145_create_witnesses_table', 1),
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
(2, 'App\\Models\\User', 5),
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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `schedule_id`, `witness_id`, `channel`, `status`, `sent_at`, `response`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'sms', 'pending', NULL, NULL, '2025-12-14 05:27:45', '2025-12-14 05:27:45'),
(2, 1, 2, 'sms', 'pending', NULL, NULL, '2025-12-14 05:27:45', '2025-12-14 05:27:45'),
(3, 2, 1, 'sms', 'pending', NULL, NULL, '2025-12-14 05:27:45', '2025-12-14 05:27:45'),
(4, 2, 2, 'sms', 'pending', NULL, NULL, '2025-12-14 05:27:45', '2025-12-14 05:27:45'),
(5, 3, 1, 'sms', 'pending', NULL, NULL, '2025-12-14 05:37:00', '2025-12-14 05:37:00'),
(6, 3, 2, 'sms', 'pending', NULL, NULL, '2025-12-14 05:37:00', '2025-12-14 05:37:00'),
(7, 4, 1, 'sms', 'pending', NULL, NULL, '2025-12-14 05:37:00', '2025-12-14 05:37:00'),
(8, 4, 2, 'sms', 'pending', NULL, NULL, '2025-12-14 05:37:00', '2025-12-14 05:37:00'),
(9, 5, 1, 'sms', 'pending', NULL, NULL, '2025-12-14 06:30:15', '2025-12-14 06:30:15'),
(10, 5, 2, 'sms', 'pending', NULL, NULL, '2025-12-14 06:30:15', '2025-12-14 06:30:15'),
(11, 6, 3, 'sms', 'pending', NULL, NULL, '2025-12-14 06:31:34', '2025-12-14 06:31:34'),
(12, 7, 3, 'sms', 'failed', '2025-12-14 12:33:26', '{\"messages\": [{\"to\": \"8801712105580\", \"message\": \"মোঃ আরিফুর রহমান, 2026-01-03 তারিখে ঢাকা এ fdsgdsg মামলায় আপনাকে সাক্ষী হিসেবে উপস্থিত থাকার জন্য অনুরোধ করা হলো।\"}], \"response\": [{\"to\": \"8801712105580\", \"message\": \"মোঃ আরিফুর রহমান, 2026-01-03 তারিখে ঢাকা এ fdsgdsg মামলায় আপনাকে সাক্ষী হিসেবে উপস্থিত থাকার জন্য অনুরোধ করা হলো।\", \"response\": {\"data\": {\"id\": \"741301cd-a0e4-441a-be09-f66c4c30a6c8\", \"type\": \"SMS\", \"isSent\": 7, \"masking\": \"Court SMS\", \"message\": \"মোঃ আরিফুর রহমান, 2026-01-03 তারিখে ঢাকা এ fdsgdsg মামলায় আপনাকে সাক্ষী হিসেবে উপস্থিত থাকার জন্য অনুরোধ করা হলো।\", \"priority\": 0, \"provider\": \"mnet\", \"smsCount\": 2, \"queuingAt\": 1765715604786, \"updatedOn\": 1765715604786, \"accessToken\": \"Court SMS\", \"destination\": \"8801712105580\", \"messageType\": \"1\", \"numberOfTry\": 0, \"transactionType\": \"T\"}, \"status\": 200, \"message\": null, \"options\": null, \"success\": true, \"timestamp\": 1765715604790, \"fieldErrors\": null, \"responseCode\": 0, \"generalErrors\": null}, \"response_code\": 200}], \"response_code\": 200}', '2025-12-14 06:33:25', '2025-12-14 06:33:26'),
(13, 8, 3, 'sms', 'pending', NULL, NULL, '2025-12-14 06:39:14', '2025-12-14 06:39:14'),
(14, 9, 3, 'sms', 'pending', NULL, NULL, '2025-12-18 01:24:30', '2025-12-18 01:24:30');

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_schedules`
--

INSERT INTO `notification_schedules` (`id`, `hearing_id`, `template_id`, `channel`, `status`, `schedule_date`, `schedule_time`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'sms', 'active', '2025-12-19 00:00:00', NULL, 1, '2025-12-14 05:27:45', '2025-12-14 05:27:45'),
(2, 1, 1, 'sms', 'active', '2025-12-26 00:00:00', NULL, 1, '2025-12-14 05:27:45', '2025-12-14 05:27:45'),
(3, 1, 1, 'sms', 'active', '2025-12-21 00:00:00', NULL, 1, '2025-12-14 05:37:00', '2025-12-14 05:37:00'),
(4, 1, 1, 'sms', 'active', '2025-12-28 00:00:00', NULL, 1, '2025-12-14 05:37:00', '2025-12-14 05:37:00'),
(5, 1, 1, 'sms', 'active', '2025-12-30 00:00:00', NULL, 1, '2025-12-14 06:30:15', '2025-12-14 06:30:15'),
(6, 2, 1, 'sms', 'active', '2025-12-23 00:00:00', NULL, 1, '2025-12-14 06:31:34', '2025-12-14 06:31:34'),
(7, 2, 1, 'sms', 'active', '2025-12-14 12:33:25', NULL, 1, '2025-12-14 06:33:25', '2025-12-14 06:33:25'),
(8, 2, 1, 'sms', 'active', '2025-12-25 00:00:00', NULL, 1, '2025-12-14 06:39:14', '2025-12-14 06:39:14'),
(9, 2, 1, 'sms', 'active', '2025-11-26 00:00:00', NULL, 1, '2025-12-18 01:24:30', '2025-12-18 01:24:30');

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', NULL, NULL);

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
('tXczZjVVBC5XCXnOxuyje0HHpcuwzjA43JZxE7L6', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUGpreUhRODFiaGN0SEJhZlhabUZHVzFVSjFKN1JHOGNUaTBGN1djZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9oZWFyaW5ncy9tYW5hZ2UiO3M6NToicm91dGUiO3M6MjE6ImFkbWluLmhlYXJpbmdzLm1hbmFnZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo2OiJsb2NhbGUiO3M6MjoiYm4iO30=', 1765715956),
('0HsK2Ywb8WsKK7oAyaJgvO86GPea9RL1AvwZUo8m', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSHRCTVZCZkFzaTVsUHp4bWsxUXY4Mm5UVDdUbk1Jcm96bmlhNDZJcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1766469358),
('BSDjN1yKdY2aLGs8wpj3cmHTwq5I7qAD6NYrpUDB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXZuSzhscFN5NE5Pa1RrMDZKVEd4cnhUekpJVkEwVmt0NlB4T0laaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9fQ==', 1766049091),
('y1ThNrIvUufZCFpS3iBlZixMu0aqRqGdNlbHzSEs', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidkhKbFFyMFI4OHM2MzNjUHVnQTBUb1dGVXAwdXhyMVFiNm05WWtUcCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kaXN0cmljdHMiO3M6NToicm91dGUiO3M6MjE6ImFkbWluLmRpc3RyaWN0cy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1766469509);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `division_id`, `district_id`, `court_id`, `name`, `email`, `phone_number`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'Super Admin', 'superadmin@example.com', NULL, NULL, '$2y$12$/CbptggB2PqvhwsAyfL9qeZ1XFvVzFmlsl4/5HQpnZnYR4/PhCGwy', 1, NULL, '2025-09-29 23:34:56', '2025-09-29 23:34:56');

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
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `witnesses_hearing_id_foreign` (`hearing_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `witnesses`
--

INSERT INTO `witnesses` (`id`, `hearing_id`, `name`, `phone`, `appeared_status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 'মোঃ আরিফুর রহমান', '01712105580', 'appeared', NULL, '2025-12-14 05:27:45', '2025-12-14 06:31:01'),
(2, 1, 'আখলাকুর রহমান', '01311078690', 'appeared', NULL, '2025-12-14 05:27:45', '2025-12-14 06:31:02'),
(3, 2, 'মোঃ আরিফুর রহমান', '01712105580', 'appeared', NULL, '2025-12-14 06:31:34', '2025-12-14 06:37:48');

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
