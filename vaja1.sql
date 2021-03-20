-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 03, 2021 at 07:46 PM
-- Server version: 8.0.23-0ubuntu0.20.04.1
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vaja1`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id_address` int NOT NULL,
  `id_user` int NOT NULL,
  `id_postal_code` int NOT NULL,
  `name` text COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id_ad` int NOT NULL,
  `title` text COLLATE utf8_slovenian_ci NOT NULL,
  `description` text COLLATE utf8_slovenian_ci NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expiration_date` timestamp NULL DEFAULT NULL,
  `number_of_views` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id_ad`, `title`, `description`, `created_on`, `expiration_date`, `number_of_views`, `id_user`) VALUES
(1, 'Prvi oglas', 'Opis prvega oglasa', '2021-03-03 15:49:56', '2021-03-16 15:49:20', 4, 1),
(2, 'Drugi oglas', 'Opis drugega oglasa', '2021-03-03 15:50:00', '2021-03-16 15:49:20', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ads_categories`
--

CREATE TABLE `ads_categories` (
  `id_ads_categories` int NOT NULL,
  `id_category` int NOT NULL,
  `id_ad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ads_images`
--

CREATE TABLE `ads_images` (
  `id_ads_images` int NOT NULL,
  `id_image` int NOT NULL,
  `id_ad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_category` int NOT NULL,
  `category` text COLLATE utf8_slovenian_ci NOT NULL,
  `id_parent` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id_image` int NOT NULL,
  `image` longblob NOT NULL,
  `main` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postal_codes`
--

CREATE TABLE `postal_codes` (
  `id_postal_code` int NOT NULL,
  `postal_code` text COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` text COLLATE utf8_slovenian_ci NOT NULL,
  `password` text COLLATE utf8_slovenian_ci NOT NULL,
  `name` text COLLATE utf8_slovenian_ci NOT NULL,
  `surname` text COLLATE utf8_slovenian_ci NOT NULL,
  `id_address` int DEFAULT NULL,
  `mobile_number` bigint DEFAULT NULL,
  `gender` text COLLATE utf8_slovenian_ci,
  `age` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `name`, `surname`, `id_address`, `mobile_number`, `gender`, `age`) VALUES
(1, 'User1', 'user1', 'user1', 'surname1', NULL, 24242454, 'm', 24),
(2, 'User1', 'user1', 'user1', 'surname1', NULL, 24242454, 'm', 24);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id_address`),
  ADD KEY `postal_codes_addresses` (`id_postal_code`),
  ADD KEY `users_addresses` (`id_user`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id_ad`),
  ADD KEY `cons_user_ads` (`id_user`);

--
-- Indexes for table `ads_categories`
--
ALTER TABLE `ads_categories`
  ADD PRIMARY KEY (`id_ads_categories`),
  ADD KEY `ad_ads_categories` (`id_ad`),
  ADD KEY `category_ads_categories` (`id_category`);

--
-- Indexes for table `ads_images`
--
ALTER TABLE `ads_images`
  ADD PRIMARY KEY (`id_ads_images`),
  ADD KEY `images_ads_images` (`id_image`),
  ADD KEY `ad_ads_images` (`id_ad`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_image`);

--
-- Indexes for table `postal_codes`
--
ALTER TABLE `postal_codes`
  ADD PRIMARY KEY (`id_postal_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `adress_users` (`id_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id_address` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id_ad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ads_categories`
--
ALTER TABLE `ads_categories`
  MODIFY `id_ads_categories` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_images`
--
ALTER TABLE `ads_images`
  MODIFY `id_ads_images` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id_image` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postal_codes`
--
ALTER TABLE `postal_codes`
  MODIFY `id_postal_code` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `postal_codes_addresses` FOREIGN KEY (`id_postal_code`) REFERENCES `postal_codes` (`id_postal_code`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `users_addresses` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `cons_user_ads` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ads_categories`
--
ALTER TABLE `ads_categories`
  ADD CONSTRAINT `ad_ads_categories` FOREIGN KEY (`id_ad`) REFERENCES `ads` (`id_ad`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `category_ads_categories` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ads_images`
--
ALTER TABLE `ads_images`
  ADD CONSTRAINT `ad_ads_images` FOREIGN KEY (`id_ad`) REFERENCES `ads` (`id_ad`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `images_ads_images` FOREIGN KEY (`id_image`) REFERENCES `images` (`id_image`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `adress_users` FOREIGN KEY (`id_address`) REFERENCES `addresses` (`id_address`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
