-- phpMyAdmin SQL Dump
-- version 4.3.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2016 at 01:57 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `be_lrs`
--
CREATE DATABASE IF NOT EXISTS `be_lrs` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `be_lrs`;

-- --------------------------------------------------------

--
-- Table structure for table `lrs`
--

CREATE TABLE IF NOT EXISTS `lrs` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lrs`
--

INSERT INTO `lrs` (`id`, `title`, `description`, `owner_id`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 6, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `lrs_user`
--

CREATE TABLE IF NOT EXISTS `lrs_user` (
  `id` int(11) NOT NULL,
  `lrs_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lrs_user`
--

INSERT INTO `lrs_user` (`id`, `lrs_id`, `user_id`, `role_id`) VALUES
(0, 1, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_07_15_143809_create_lrs_table', 1),
('2016_07_15_145812_create_sites_table', 2),
('2016_07_15_145828_create_users_table', 3),
('2016_07_15_161256_create_user_tokens_table', 4),
('2016_07_15_164745_create_lrs_users_table', 5),
('2016_07_15_150431_create_roles_table', 6),
('2016_07_15_150446_create_permissions_table', 6),
('2016_07_15_170746_create_role_permission_table', 7),
('2016_07_15_145111_create_statements_table', 8),
('2016_07_15_170746_create_permission_role_table', 9),
('2016_07_18_174349_create_role_user_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `readable` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `readable`, `description`) VALUES
(1, 'VIEW_DASHBOARD', 'Can View the LRS Super Dashboard.', 'super admin, show site dashboard'),
(2, 'CREATE_LRS', 'Can create LRS.', ''),
(3, 'EDIT_LRS', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` int(10) unsigned NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 2),
(2, 1, 3),
(3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'SUPER'),
(2, 'OBSERVER'),
(3, 'ADMIN'),
(4, 'OWNER');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(10) unsigned NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`) VALUES
(1, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `registration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restrict` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_lrs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `name`, `description`, `email`, `lang`, `registration`, `restrict`, `domain`, `create_lrs`, `created_at`, `updated_at`) VALUES
(1, 'Bible Exchange', 'our own app', 'be@bible.exchange', 'en-US', 'yes', 'no', 'http://bible.exchange', 'yes', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `statements`
--

CREATE TABLE IF NOT EXISTS `statements` (
  `id` int(10) unsigned NOT NULL,
  `statement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `voided` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `refs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lrs_id` int(11) NOT NULL,
  `stored` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `verified` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `verified`, `role`, `password`, `created_at`, `updated_at`) VALUES
(3, 'Stephen Reynolds Jr', 'sgrjr@deliverance.me', 'yes', 'super', '$2y$10$/NLI8/V2JpWlSoD8HOymw.Ww3zsKB5ELSUZ9LDZ8KVCtHT0r4Is9S', '2016-07-15 20:10:02', '2016-07-18 23:52:49'),
(4, 'Stephen Reynolds Jr', 'sgrjr@deliverance.me1', 'no', 'observer', '$2y$10$XQ7XRiLAb3vGgyjKCFQIruJSFm2HN0r5/wEqQjUxU1JVqIUJTusue', '2016-07-15 20:11:16', '2016-07-15 20:11:16'),
(5, 'Stephen Reynolds Jr', 'sgrjr@deliverance.me12', 'no', 'observer', '$2y$10$QfWNFNMrAw6bbJB8SRUAHuykTgaxZNrErnDKdFb27AdiGpGtnmqaq', '2016-07-15 20:11:36', '2016-07-15 20:11:36'),
(6, 'Stephen Reynolds Jr', 'sgrjr@deliverance.me123', 'no', 'observer', '$2y$10$oHsvIuMmsGQYhEMAHqwTuepyxLBUBbyGjQh5Naw7THx0FckykAzSm', '2016-07-15 20:15:32', '2016-07-15 20:15:32'),
(7, 'Stephen Reynolds Jr', 'sgrjr@deliverance.me8', 'no', 'observer', '$2y$10$E087GZR/XBi0.aHvhsRVvu5Ort..YvxMLbc.SiffTn4YS82cYdfOW', '2016-07-18 06:11:45', '2016-07-18 06:11:45'),
(8, 'Stephen Reynolds Jr', 'sgrjr@deliverance.me1238', 'no', 'observer', '$2y$10$6eyW/JjY5OfloTWhAZ4USuQB3FA3ZHLRbNSRW3B4VvCl8khHCqJBG', '2016-07-18 21:13:12', '2016-07-18 21:13:12'),
(9, 'Stephen Reynolds Jr', 'sgrjr8@deliverance.me', 'no', 'observer', '$2y$10$SC8z3JgU8YnSsxnauJJNf.iOKqlC9w8vYxZHrhgE8F1YwlV8jku5G', '2016-07-18 21:14:04', '2016-07-19 15:49:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(10) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_tokens`
--

INSERT INTO `user_tokens` (`id`, `email`, `token`, `created_at`, `updated_at`) VALUES
(1, 'sgrjr@deliverance.me123', '46e9178c69f59bca066faf9b0b05fd9aa1d82366', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'sgrjr@deliverance.me8', 'eb276b598b2dbbbc4759c99866479938c67484f0', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'sgrjr@deliverance.me1238', '46ad78347e2a06dd9145c62bd91c960442b34638', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'sgrjr@deliverance.me12380', '3753cbdb70c14d53bab3f7fb4d7cbfa4b40b95a2', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'sgrjr8@deliverance.me', 'e30c55e112999a442da20cd92287e44c99bb289b', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lrs`
--
ALTER TABLE `lrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lrs_user`
--
ALTER TABLE `lrs_user`
  ADD PRIMARY KEY (`id`), ADD KEY `lrs_id` (`lrs_id`), ADD KEY `user_id` (`user_id`), ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`), ADD KEY `permission_role_role_id_index` (`role_id`), ADD KEY `permission_role_permission_id_index` (`permission_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`), ADD KEY `role_user_role_id_index` (`role_id`), ADD KEY `role_user_user_id_index` (`user_id`);

--
-- Indexes for table `sites`
--
ALTER TABLE `sites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statements`
--
ALTER TABLE `statements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lrs`
--
ALTER TABLE `lrs`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sites`
--
ALTER TABLE `sites`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `statements`
--
ALTER TABLE `statements`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
