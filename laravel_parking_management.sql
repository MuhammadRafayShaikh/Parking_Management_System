-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 09:53 PM
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
-- Database: `laravel_parking_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `parking_charge` int(11) NOT NULL,
  `category_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `parking_charge`, `category_status`) VALUES
(1, 'Car', 100, 1),
(2, 'Trucks', 250, 1),
(3, 'Bike', 60, 1),
(4, 'Rickshaw', 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_01_183824_create_categories_table', 1),
(6, '2024_11_01_184102_create_vehicles_table', 1),
(7, '2024_11_01_202027_create_admins_table', 2),
(9, '2024_11_02_172955_create_users_table', 3),
(10, '2024_11_04_173530_create_vehicles_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(25, 'App\\Models\\User', 1, 'API TOKEN', '7b5bb3d4cf9caf2de6fbd06cd21292d8fe123f7b26fab8658181331bcbe48bcd', '[\"*\"]', '2024-11-06 15:44:59', NULL, '2024-11-06 15:18:34', '2024-11-06 15:44:59'),
(26, 'App\\Models\\User', 1, 'API TOKEN', '22d6c0dc906acefdee748baebab578b55b9ee5e25e5133646ce20b1f0316d7b8', '[\"*\"]', NULL, NULL, '2024-11-06 15:52:09', '2024-11-06 15:52:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `password`) VALUES
(1, 'admin', 99999999, 'admin@gmail.com', '$2y$12$j9Lq9XfmZDQp5Iv6PVqLaOCtVLZu/qUi3BNPFA7AjdI54DwJTVPZm');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parking_number` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_company` varchar(255) NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_contact` int(11) NOT NULL,
  `owner_email` varchar(255) NOT NULL,
  `intime` timestamp NULL DEFAULT NULL,
  `outtime` timestamp NULL DEFAULT NULL,
  `charges` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `parking_number`, `category_id`, `vehicle_company`, `registration_number`, `owner_name`, `owner_contact`, `owner_email`, `intime`, `outtime`, `charges`, `status`) VALUES
(1, 6152, 3, 'abc', 'abc', 'rafay', 31533077, 'rafay@gmail.com', '2024-11-04 15:51:17', NULL, 0, 0),
(2, 3471, 4, 'Mazda', 'abc-123', 'abc', 99999, 'abc@gmail.com', '2024-11-04 17:53:28', '2024-11-05 13:50:02', 800, 1),
(3, 8165, 1, 'Honda', 'xyz-123', 'Person 3', 999999, 'person3@gmail.com', '2024-11-06 17:01:43', '2024-11-06 20:27:15', 400, 1),
(4, 4940, 2, 'Bolan', 'abc-123', 'Person 4', 9999999, 'aptechrafay2@gmail.com', '2024-11-06 18:18:48', '2024-11-06 20:43:20', 750, 1),
(6, 2580, 2, 'Bolan', '9999999', 'Person 5', 9999999, 'person4@gmail.com', '2024-11-06 18:21:02', '2024-11-06 20:35:44', 750, 1),
(8, 7084, 3, 'Honda', 'abc-123', 'Person 7', 99999999, 'rafayshaikh405@gmail.com', '2024-11-06 20:39:11', '2024-11-06 20:39:45', 60, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_category_name_unique` (`category_name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_owner_email_unique` (`owner_email`),
  ADD KEY `vehicles_category_id_foreign` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
