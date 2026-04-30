-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2026 at 06:00 PM
-- Server version: 8.0.26
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ihapp_ACE`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_questions`
--

CREATE TABLE `activity_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `question_type` varchar(50) DEFAULT NULL,
  `question` text NOT NULL,
  `answer` text,
  `options` json DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1=enabled, 0=disabled',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `activity_questions`
--

INSERT INTO `activity_questions` (`id`, `question_type`, `question`, `answer`, `options`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'mcq', 'these is test question?', 'Test', '[\"Test\", \"qwe\", \"qwer\", \"axerf\"]', 1, '2026-04-29 06:52:06', '2026-04-30 03:15:36', NULL),
(2, 'mcq', 'these is test question?', 'Test123', '[\"1\", \"12\", \"123\", \"Test123\"]', 1, '2026-04-30 02:46:34', '2026-04-30 03:13:52', NULL),
(3, 'mcq', 'these is test question?123', 'Test', '[\"12\", \"1\", \"123\", \"Test\"]', 1, '2026-04-30 03:39:45', '2026-04-30 03:39:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `name`, `password`, `created_at`, `updated_at`) VALUES
(1, 'ACE@gmail.com', 'ACE', '123456', '2026-04-23 05:06:15', '2026-04-23 05:06:15');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '123456', '2026-04-23 05:51:04', '2026-04-23 06:48:56', NULL),
(2, '1234', '2026-04-23 06:29:53', '2026-04-23 06:49:01', '2026-04-23 06:49:01'),
(3, '12z', '2026-04-23 06:31:08', '2026-04-23 06:49:04', '2026-04-23 06:49:04');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `live_questions`
--

CREATE TABLE `live_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `web_cast_activity_id` bigint UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0' COMMENT '0=unread, 1=read'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `live_questions`
--

INSERT INTO `live_questions` (`id`, `user_id`, `web_cast_activity_id`, `question`, `created_at`, `updated_at`, `deleted_at`, `is_read`) VALUES
(1, 2, 11, 'how Are You?', '2026-04-29 23:37:42', '2026-04-29 23:37:42', NULL, 0),
(2, 2, 11, 'how Are You?', '2026-04-29 23:52:18', '2026-04-29 23:52:18', NULL, 0),
(3, 2, 11, 'how Are You?', '2026-04-29 23:52:23', '2026-04-29 23:52:23', NULL, 0),
(4, 2, 11, 'how Are You?', '2026-04-29 23:52:27', '2026-04-29 23:52:27', NULL, 0),
(5, 2, 11, 'how Are You?', '2026-04-29 23:52:32', '2026-04-30 00:13:38', NULL, 1),
(6, 2, 11, 'how Are You?', '2026-04-29 23:52:35', '2026-04-30 00:13:51', NULL, 1),
(7, 2, 11, 'how Are You?', '2026-04-29 23:53:43', '2026-04-30 00:13:34', NULL, 1),
(8, 2, 11, 'how Are You?', '2026-04-29 23:53:47', '2026-04-30 00:13:15', NULL, 1),
(9, 2, 11, 'how Are You?', '2026-04-29 23:53:51', '2026-04-30 00:09:19', NULL, 1),
(10, 2, 11, 'how Are You?', '2026-04-29 23:53:55', '2026-04-30 00:13:45', NULL, 0),
(11, 2, 11, 'how Are You?', '2026-04-30 00:44:23', '2026-04-30 00:44:23', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_23_104213_create_categories_table', 2),
(6, '2026_04_23_104320_create_web_cast_activities_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('rzbWud49ctkkOt9MBUARrFvjTdqbWtQREUxcFawQ', 5, '172.69.179.175', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVFl6Rnd2ZEhiZWU4SnlzUkFFblZGVlZ0c2s5aTlRS1draTVyelJPVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQzOiJodHRwczovL2loYXBwLmluL0FDRS9saXZlLXNlc3Npb24vd2ViaW5hcnMvZXlKcGRpSTZJbEJ1ZUc5VVVuRm5Ramh6WjAxek5rSkVjVWxuYjBFOVBTSXNJblpoYkhWbElqb2lTMDlNWlRBdk1GcHpiVmhLU21Sb2JYRmpWSEkyVVQwOUlpd2liV0ZqSWpvaU1tSmxOemN5WkRGaU56VTNNemhrTXpCallUQmhNakk1TWpNeE5XWTRaV1JrTkdWbE5qZGxOVGRoTm1FNE1XTXlZbUk1TldKbE1HUTVaREptTjJaak1DSXNJblJoWnlJNklpSjkiO3M6NToicm91dGUiO3M6MjA6IndlYmluYXJzLnZpZGVvU3RyZWFtIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cHM6Ly9paGFwcC5pbi9BQ0UvbGl2ZS1zZXNzaW9uIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTtzOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1777545670),
('wulguyQILWNuhoYNqq6BHnbmjy0dbETARN1EYctT', 1, '162.158.227.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiREVjeEpoaUVtajZmb09yRTRvZGZWNkNUeThiaG5jRG5qbERYVEx2RyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMzQ6Imh0dHBzOi8vaWhhcHAuaW4vQUNFL2xpdmUtc2Vzc2lvbi9leUpwZGlJNklrcEJSMnh5TTJwTlRsVkVUVk5vWTBvMFExb3JTa0U5UFNJc0luWmhiSFZsSWpvaWVEbE9kMGxKU2xaWlp6QlZNVzFRY3pCYVUyRmFVVDA5SWl3aWJXRmpJam9pTW1ReU56QXhZekV5WkRWaE9HWTJZMlJsTkRrd01tWmpNMlJsTmprd1l6TmlOR1JsWkRVM05EQm1OVEppWmpJNFkyVmtaakJpWVRVM1pXUXlPRGRoWXlJc0luUmhaeUk2SWlKOSI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQzOiJodHRwczovL2loYXBwLmluL0FDRS9hZG1pbi93ZWJjYXN0LXJlc291cmNlIjtzOjU6InJvdXRlIjtzOjIzOiJhZG1pbi53Y19yZXNvdXJjZS5pbmRleCI7fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1777551987);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hospital` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_track` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `title`, `degree`, `hospital`, `state`, `city`, `pincode`, `mobile`, `remember_token`, `created_at`, `updated_at`, `user_track`) VALUES
(1, 'Jonathan Smith', 'Jonathan', 'Smith', 'test@example.com', NULL, '$2y$12$3zl.fVkR2DFhFapEozIIfe85zs6uJduBCeaKAFfLTgq8e7ahLrxVK', 'Mr', 'MBBS', 'HP City Hospital', 'Gujarat', 'Surat', '395006', '9876543210', NULL, '2026-04-27 01:01:51', '2026-04-27 01:01:51', NULL),
(2, 'Jonathan Smith', 'Jonathan', 'Smith', 'test@example1.com', NULL, '$2y$12$hpkQuqfTzV5xqPUJf8pc9e1zBlDeb.G6NweEI1eM/d49ZAJsinQ8a', 'Mr', 'MBBS', 'HP City Hospital', 'Gujarat', 'Surat', '395006', '9876543211', NULL, '2026-04-28 03:19:39', '2026-04-28 03:19:39', NULL),
(3, 'Jonathan Smith', 'Jonathan', 'Smith', 'demo@gmail.com', NULL, '$2y$12$7d9kdXVL7YH1f/bQHAWk1eGogb0IEddI9yUdM3v29mh5PaISiIrQC', 'Mr', 'MBBS', 'HP City Hospital', 'Gujarat', 'Surat', '395006', '9724078754', NULL, '2026-04-28 03:29:25', '2026-04-28 03:29:25', NULL),
(4, 'Jonathan Smith', 'Jonathan', 'Smith', 'rt@gmail.com', NULL, '$2y$12$dGW118sPmD2Th5s8ilaEOOtcTqYEjXagarpdJoUu.SZ.0CgThBgqO', 'Mr', 'MBBS', 'HP City Hospital', 'Gujarat', 'Surat', '395006', '9876743210', NULL, '2026-04-28 06:05:30', '2026-04-28 06:05:30', NULL),
(5, 'Rt Anghan', 'Rt', 'Anghan', 'rtanghan0@gmail.com', NULL, '$2y$12$h34iOfdpFBoyFVs0p/6yEuRp.Q/1bFupWPouEMspswu5FKL7/Y8TO', 'Dr', 'MBBS', 'Apollo Hosiptal,', 'Gujarat', 'ccd', '395006', '9771506644', NULL, '2026-04-30 04:09:28', '2026-04-30 04:09:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_assessment_questions_ans`
--

CREATE TABLE `user_assessment_questions_ans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `answer` text NOT NULL,
  `is_correct_ans` tinyint(1) DEFAULT '0' COMMENT '1=true, 0=false',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_assessment_questions_ans`
--

INSERT INTO `user_assessment_questions_ans` (`id`, `user_id`, `question_id`, `answer`, `is_correct_ans`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 2, 1, 'Test', 1, '2026-04-30 03:40:44', '2026-04-30 03:40:44', NULL),
(6, 2, 2, 'Test123', 1, '2026-04-30 03:40:44', '2026-04-30 03:40:44', NULL),
(7, 2, 3, '1', 0, '2026-04-30 03:40:44', '2026-04-30 09:43:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_tracks`
--

CREATE TABLE `user_tracks` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `web_cast_activity_id` bigint UNSIGNED DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `complete_status` tinyint(1) DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_tracks`
--

INSERT INTO `user_tracks` (`id`, `user_id`, `web_cast_activity_id`, `type`, `complete_status`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 7, 'teaser', 1, '2026-04-29 05:00:00', '2026-04-29 05:00:00', '2026-04-29 05:00:00'),
(2, 2, 7, 'pre-read', 1, '2026-04-29 05:08:15', '2026-04-29 05:08:15', '2026-04-29 05:08:15'),
(3, 2, 7, 'view-agenda', 1, '2026-04-29 05:08:32', '2026-04-29 05:08:32', '2026-04-29 05:08:32'),
(5, 2, 7, 'assement', 1, '2026-04-28 18:30:00', '2026-04-29 10:39:40', '2026-04-29 10:40:03'),
(7, 2, 7, 'summary', 1, '2026-04-29 05:11:34', '2026-04-29 05:11:18', '2026-04-29 05:11:34'),
(8, 2, 7, 'certificate', 1, '2026-04-29 05:11:34', '2026-04-29 05:11:18', '2026-04-29 05:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `web_cast_activities`
--

CREATE TABLE `web_cast_activities` (
  `id` bigint UNSIGNED NOT NULL,
  `content_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dr_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `webcast_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webcast_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webcast_hour` tinyint DEFAULT NULL,
  `webcast_minute` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webcast_ampm` enum('AM','PM') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('upcoming','live','completed') COLLATE utf8mb4_unicode_ci DEFAULT 'upcoming',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `web_cast_activities`
--

INSERT INTO `web_cast_activities` (`id`, `content_title`, `activity_name`, `dr_name`, `thumbnail`, `slider_images`, `webcast_date`, `webcast_time`, `webcast_hour`, `webcast_minute`, `webcast_ampm`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Molestias voluptatib', 'Frances Lamb', 'Maxine Pena', 'webcasts/thumbnails/TwqxHekuupeQ1NUzIXLVJOMYCUFvxohC48uAfND1.jpg', '[\"webcasts\\/sliders\\/hYIY3Mgs7zULtMZVXg7Ul2Twp4KSc60YIqzjRWZo.jpg\",\"webcasts\\/sliders\\/ZAMbsEK9wgbbmZUxSjcvsetRLZ31jrquWojtOEsO.png\"]', '2026-04-28', '12:25 AM', 12, '25', 'AM', 'live', '2026-04-24 00:46:50', '2026-04-28 04:28:44', '2026-04-28 04:28:44'),
(2, 'Quia consequat Dolo', 'Mari Knowles', 'Abigail Stein', 'webcasts/thumbnails/XyiB6qUYjpfL6eydRKjtE3oxP9uCO4AGT6Pfu4ey.jpg', '[\"webcasts\\/sliders\\/EzRWh95s0u0tHUngrMr4HjMX9P5137xhInwBJNGm.png\"]', '2026-04-28', '8:40 PM', 8, '40', 'PM', 'upcoming', '2026-04-24 04:40:01', '2026-04-28 04:28:30', '2026-04-28 04:28:30'),
(3, 'Vel tempore aliquam', 'Jaden Bolton', 'Octavia Sanders', 'webcasts/thumbnails/El9vV3OiL9JOEg4ulpZ7Nc37ApqzJLldUcb9wbX7.jpg', '[\"webcasts\\/sliders\\/4AkzipYncWplurQg1QHPDIayAX3xMdNoXto3xdEb.png\"]', '2026-04-28', '10:30 PM', 10, '30', 'PM', 'upcoming', '2026-04-24 05:26:57', '2026-04-28 04:28:34', '2026-04-28 04:28:34'),
(4, 'Dolore sequi blandit', 'Nero Hall', 'Samuel Rich', 'webcasts/thumbnails/lp1GsGlZR0wnPuCJqTurb6NBRI0Jy0sEeV6grnn4.jpg', '[\"webcasts\\/sliders\\/Z2mfRGnhg7jRVcB9MefO5zv7pv4j3RMLAibYmf5L.png\"]', '2026-04-28', '5:15 PM', 5, '15', 'PM', 'upcoming', '2026-04-24 06:58:55', '2026-04-28 04:28:37', '2026-04-28 04:28:37'),
(5, 'TEST', 'TESTjbsahbdfiasfd', 'RANJEET KUMAR BARNWAL', '9fd1ced6-5de4-47f7-a15b-e77c1606e7681777368676.png', '[\"webcasts\\/sliders\\/AMvTwC9jglcrf9uZclGHsCY9UInQRFjDFJGNqHKi.png\",\"webcasts\\/sliders\\/gR450vdaqQmvpQwnoNXoIeTiICKpF6lESycQfJcW.png\"]', '2026-04-28', '2:5 AM', 2, '5', 'AM', 'upcoming', '2026-04-28 04:01:17', '2026-04-28 04:28:40', '2026-04-28 04:28:40'),
(6, 'Module 1 - Part A', 'Basics of Allergy', 'Dr. P. Mahesh', 'd0fecacb-625e-45de-afe1-ebe5b3875a3a1777380014.png', '[\"5fbabcf0-5643-43e5-b379-36fec4ae58301777380014.png\"]', '2026-04-28', '3:10 PM', 7, '10', 'PM', 'live', '2026-04-28 04:30:52', '2026-04-29 04:33:41', NULL),
(7, 'Module 1 - Part B', 'Aerobiology: - Clinical aspects', 'Dr. Sonam', 'dad81a3d-7675-4e0b-ba77-7cfb2af59a931777379971.png', '[\"14c7504d-3e46-4302-be25-f31e43b334f11777378871.png\"]', '2026-04-28', '3:15 PM', 3, '15', 'PM', 'live', '2026-04-28 04:31:31', '2026-04-28 07:09:31', NULL),
(8, 'Module 2- Part A', 'Allergy history taking', 'Dr. Raj Kumar', '5d2e483d-efbd-48da-9492-8e8303d133e71777370452.png', '[\"3ef9a885-6ae6-4d31-bda6-2b31159790a11777370452.png\"]', '2026-04-28', '3:10 PM', 3, '10', 'PM', 'upcoming', '2026-04-28 04:30:52', '2026-04-28 06:49:43', NULL),
(9, 'Module 2- Part B', 'Allergy diagnosis: - (In vivo, In vitro, component)', 'Dr. P. Mahesh', '5d2e483d-efbd-48da-9492-8e8303d133e71777370452.png', '[\"3ef9a885-6ae6-4d31-bda6-2b31159790a11777370452.png\"]', '2026-04-28', '3:10 PM', 3, '10', 'PM', 'upcoming', '2026-04-28 04:30:52', '2026-04-28 06:50:15', NULL),
(10, 'Module 3 - Part A', 'Spirometry', 'Dr. Sonam', '5147f891-b2ce-4c43-9bff-39c937df71311777379942.png', '[\"3ef9a885-6ae6-4d31-bda6-2b31159790a11777370452.png\"]', '2026-04-28', '3:10 PM', 3, '10', 'PM', 'upcoming', '2026-04-28 04:30:52', '2026-04-28 07:09:02', NULL),
(11, 'TEST2', 'Frances Lamb', 'test', '5074b795-86a1-428c-b062-8f4df3f692bf1777456055.png', '[\"d5d4968f-915d-4c0b-81cc-b9b07d0b48dd1777456055.png\"]', '2026-04-29', '2:5 AM', 2, '5', 'AM', 'live', '2026-04-29 04:17:35', '2026-04-29 04:17:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `web_cast_activity_resources`
--

CREATE TABLE `web_cast_activity_resources` (
  `id` bigint UNSIGNED NOT NULL,
  `webcast_activity_id` bigint UNSIGNED DEFAULT NULL,
  `activity_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `upload_type` text COLLATE utf8mb4_unicode_ci,
  `pdf_url` text COLLATE utf8mb4_unicode_ci,
  `url` text COLLATE utf8mb4_unicode_ci,
  `video_url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `web_cast_activity_resources`
--

INSERT INTO `web_cast_activity_resources` (`id`, `webcast_activity_id`, `activity_type`, `upload_type`, `pdf_url`, `url`, `video_url`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 7, 'pre_read', 'pdf', 'https://imagicahealth.live/pdfgoogledrive/pdf-flipbook/sTwZkuOzxk165', NULL, NULL, '2026-04-28 04:39:55', '2026-04-28 04:39:55', NULL),
(2, 7, 'teaser', 'url', '', 'https://player.vimeo.com/video/954655325?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479', NULL, '2026-04-28 04:39:55', '2026-04-28 04:39:55', NULL),
(3, 7, 'view_agenda', 'pdf', 'https://imagicahealth.live/pdfgoogledrive/pdf-flipbook/sTwZkuOzxk165', NULL, NULL, '2026-04-28 04:39:55', '2026-04-28 04:39:55', NULL),
(4, 7, 'summary', 'pdf', 'https://imagicahealth.live/pdfgoogledrive/pdf-flipbook/sTwZkuOzxk165', NULL, NULL, '2026-04-28 04:39:55', '2026-04-28 04:39:55', NULL),
(5, 7, 'vimeo_url', 'url', '', 'https://player.vimeo.com/video/954655325?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479', NULL, '2026-04-28 04:39:55', '2026-04-28 04:39:55', NULL),
(6, 11, 'pre_read', 'pdf', 'https://imagicahealth.live/pdfgoogledrive/pdf-flipbook/sTwZkuOzxk165', NULL, NULL, '2026-04-29 04:19:07', '2026-04-29 04:19:07', NULL),
(7, 11, 'teaser', 'url', NULL, 'https://player.vimeo.com/video/954655325?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479', NULL, '2026-04-29 04:19:07', '2026-04-29 04:19:07', NULL),
(8, 11, 'view_agenda', 'pdf', 'https://imagicahealth.live/pdfgoogledrive/pdf-flipbook/sTwZkuOzxk165', NULL, NULL, '2026-04-29 04:19:07', '2026-04-29 04:19:07', NULL),
(9, 11, 'summary', 'pdf', 'https://imagicahealth.live/pdfgoogledrive/pdf-flipbook/sTwZkuOzxk165', NULL, NULL, '2026-04-29 04:19:07', '2026-04-29 04:19:07', NULL),
(10, 11, 'vimeo_url', 'url', NULL, 'https://player.vimeo.com/video/954655325?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479', NULL, '2026-04-29 04:19:07', '2026-04-29 04:19:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_questions`
--
ALTER TABLE `activity_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_aq_type` (`question_type`),
  ADD KEY `idx_aq_status` (`status`),
  ADD KEY `idx_aq_deleted` (`deleted_at`),
  ADD KEY `idx_aq_status_deleted` (`status`,`deleted_at`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `live_questions`
--
ALTER TABLE `live_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lq_user` (`user_id`),
  ADD KEY `idx_lq_activity` (`web_cast_activity_id`),
  ADD KEY `idx_lq_deleted` (`deleted_at`),
  ADD KEY `idx_lq_user_activity` (`user_id`,`web_cast_activity_id`),
  ADD KEY `idx_lq_activity_time` (`web_cast_activity_id`,`created_at`),
  ADD KEY `idx_lq_is_read` (`is_read`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`);

--
-- Indexes for table `user_assessment_questions_ans`
--
ALTER TABLE `user_assessment_questions_ans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_question` (`user_id`,`question_id`),
  ADD KEY `idx_uaqa_user` (`user_id`),
  ADD KEY `idx_uaqa_question` (`question_id`),
  ADD KEY `idx_uaqa_deleted` (`deleted_at`),
  ADD KEY `idx_uaqa_user_question` (`user_id`,`question_id`),
  ADD KEY `idx_uaqa_correct` (`is_correct_ans`),
  ADD KEY `idx_uaqa_user_correct` (`user_id`,`is_correct_ans`);

--
-- Indexes for table `user_tracks`
--
ALTER TABLE `user_tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_tracks_user_type` (`user_id`,`type`),
  ADD KEY `fk_user_tracks_activity` (`web_cast_activity_id`),
  ADD KEY `idx_user_activity` (`user_id`,`web_cast_activity_id`,`type`);

--
-- Indexes for table `web_cast_activities`
--
ALTER TABLE `web_cast_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_cast_activity_resources`
--
ALTER TABLE `web_cast_activity_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `web_cast_activity_resources_webcast_activity_id_foreign` (`webcast_activity_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_questions`
--
ALTER TABLE `activity_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `live_questions`
--
ALTER TABLE `live_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_assessment_questions_ans`
--
ALTER TABLE `user_assessment_questions_ans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_tracks`
--
ALTER TABLE `user_tracks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `web_cast_activities`
--
ALTER TABLE `web_cast_activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `web_cast_activity_resources`
--
ALTER TABLE `web_cast_activity_resources`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `live_questions`
--
ALTER TABLE `live_questions`
  ADD CONSTRAINT `fk_live_questions_activity` FOREIGN KEY (`web_cast_activity_id`) REFERENCES `web_cast_activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_live_questions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_assessment_questions_ans`
--
ALTER TABLE `user_assessment_questions_ans`
  ADD CONSTRAINT `fk_uaqa_question` FOREIGN KEY (`question_id`) REFERENCES `activity_questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_uaqa_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tracks`
--
ALTER TABLE `user_tracks`
  ADD CONSTRAINT `fk_user_tracks_activity` FOREIGN KEY (`web_cast_activity_id`) REFERENCES `web_cast_activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_tracks_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `web_cast_activity_resources`
--
ALTER TABLE `web_cast_activity_resources`
  ADD CONSTRAINT `web_cast_activity_resources_webcast_activity_id_foreign` FOREIGN KEY (`webcast_activity_id`) REFERENCES `web_cast_activities` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
