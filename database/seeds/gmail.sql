-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 25, 2017 at 08:27 PM
-- Server version: 5.7.16
-- PHP Version: 7.1.0RC5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gmail`
--

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` int(10) NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`id`, `subject`, `body`, `created_at`, `updated_at`) VALUES
(1, 'Hi', 'How are you doing ?', '2017-01-25 19:10:02', '2017-01-25 19:10:02'),
(2, 'Hi', 'I\'m doing fine.\\nI loved your Gmail App.\\nLet me hire you.', '2017-01-25 19:12:07', '2017-01-25 19:12:07'),
(3, 'Hi', 'How are you doing ?', '2017-01-25 19:13:11', '2017-01-25 19:13:11'),
(4, 'Check Draft', 'Storing this email to draft', '2017-01-25 19:20:09', '2017-01-25 19:20:09'),
(5, '', '', '2017-01-25 19:21:06', '2017-01-25 19:21:06');

-- --------------------------------------------------------

--
-- Table structure for table `email_user`
--

CREATE TABLE `email_user` (
  `id` int(11) NOT NULL,
  `from_user_id` int(10) NOT NULL,
  `to_user_id` int(10) NOT NULL,
  `email_id` int(10) NOT NULL,
  `parent_email_id` int(11) DEFAULT NULL,
  `has_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_draft` tinyint(1) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_user`
--

INSERT INTO `email_user` (`id`, `from_user_id`, `to_user_id`, `email_id`, `parent_email_id`, `has_read`, `is_draft`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 1, 1, 0, 0, '2017-01-25 19:10:02', '2017-01-25 19:10:02'),
(2, 2, 1, 2, 1, 1, 0, 1, '2017-01-25 19:12:07', '2017-01-25 19:12:07'),
(3, 1, 2, 3, 3, 0, 1, 0, '2017-01-25 19:13:11', '2017-01-25 19:13:11'),
(4, 1, 2, 4, 4, 0, 1, 0, '2017-01-25 19:20:09', '2017-01-25 19:20:09'),
(5, 1, 2, 5, 5, 0, 1, 0, '2017-01-25 19:21:06', '2017-01-25 19:21:06');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(8, '2014_10_12_000000_create_users_table', 1),
(9, '2014_10_12_100000_create_password_resets_table', 1),
(10, '2017_01_21_103937_create_participants_table', 1),
(11, '2017_01_21_104145_create_threads_table', 1),
(12, '2017_01_21_104202_create_messages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abhijeet Ashok Muneshwar', 'openingknots@gmail.com', '$2y$10$xCa1MHAi26MA4Xq/BL0mfeMNk8Mtq8hhYmnpwnUpUWiQt2f2dGHLq', 'edIoK8ESQnAZuG698ryuomeGMNUv0kG3IOYDZDe7Uv7lpebFBCGBaiggDDhX', '2017-01-25 19:06:04', '2017-01-25 19:07:36'),
(2, 'Vlad kachur', 'vlad@gmail.com', '$2y$10$agOhroP65YjhRUDJ0S/eG.Xdr9X3Ai9M.fe2xbjExo29..55wWaFu', 'RPTorUUeZ8cJTW7gnIIBYxYUh0qE56XVRsQD9iWoWGQ50oadSpGOhl8WeAhZ', '2017-01-25 19:07:56', '2017-01-25 19:08:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_user`
--
ALTER TABLE `email_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `email_user`
--
ALTER TABLE `email_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
