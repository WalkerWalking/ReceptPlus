-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2026 at 07:01 PM
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
-- Database: `projekt_backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `recipeId` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `recipeId`, `userId`) VALUES
(1, 'Nagyon finom lett, köszi!', 1, 2),
(2, 'Ez a turmix brutál jó lett!', 2, 2),
(3, 'Remek reggeli ötlet, köszönöm!', 3, 2),
(4, 'Ez a protein shake nagyon jól sikerült!', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `isFruit` tinyint(1) NOT NULL,
  `kcalPerGram` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `isFruit`, `kcalPerGram`) VALUES
(1, 'Alma', 1, 0.52),
(2, 'Banán', 1, 0.89),
(3, 'Csirkemell', 0, 1.65),
(4, 'Rizs', 0, 3.6),
(5, 'Paradicsom', 0, 0.18),
(6, 'Tojás', 0, 1.55),
(7, 'Liszt', 0, 3.64),
(8, 'Cukor', 0, 3.87),
(9, 'Narancs', 1, 0.47),
(10, 'Eper', 1, 0.32),
(11, 'Körte', 1, 0.57),
(12, 'Brokkoli', 0, 0.34),
(13, 'Sárgarépa', 0, 0.41),
(14, 'Vöröshagyma', 0, 0.4),
(15, 'Fokhagyma', 0, 1.49),
(16, 'Tej', 0, 0.42),
(17, 'Tejföl', 0, 1.93),
(18, 'Sajt', 0, 4.02),
(19, 'Marhahús', 0, 2.5),
(20, 'Lazac', 0, 2.08),
(21, 'Tonhal', 0, 1.32),
(22, 'Zabpehely', 0, 3.89),
(23, 'Méz', 0, 3.04),
(24, 'Olívaolaj', 0, 8.84),
(25, 'Paprika', 0, 0.31),
(26, 'Uborka', 0, 0.16),
(27, 'Gomba', 0, 0.22),
(28, 'Krumpli', 0, 0.77),
(29, 'Tejsavó fehérje', 0, 4.12),
(30, 'Mandula', 0, 5.76),
(31, 'Joghurt natúr', 0, 0.59),
(32, 'Görög joghurt', 0, 0.97),
(33, 'Vaj', 0, 7.17),
(34, 'Margarin', 0, 7.2),
(35, 'Teljes kiőrlésű kenyér', 0, 2.47),
(36, 'Fehér kenyér', 0, 2.65),
(37, 'Sonka', 0, 1.45),
(38, 'Pulykamell', 0, 1.35),
(39, 'Bacon', 0, 5.41),
(40, 'Kolbász', 0, 4.55),
(41, 'Túró', 0, 0.98),
(42, 'Tejszín', 0, 3.4),
(43, 'Kakaópor', 0, 2.28),
(44, 'Csokoládé ét', 0, 5.46),
(45, 'Csokoládé tej', 0, 5.35),
(46, 'Citrom', 1, 0.29),
(47, 'Lime', 1, 0.3),
(48, 'Avokádó', 1, 1.6),
(49, 'Kókuszolaj', 0, 8.62),
(50, 'Kókuszreszelék', 0, 6.6),
(51, 'Mogyoróvaj', 0, 5.88),
(52, 'Dió', 0, 6.54),
(53, 'Kesudió', 0, 5.53),
(54, 'Lencse', 0, 3.53),
(55, 'Csicseriborsó', 0, 3.64),
(56, 'Bab vörös', 0, 3.37),
(57, 'Borsó', 0, 0.81),
(58, 'Spenót', 0, 0.23),
(59, 'Saláta', 0, 0.15),
(60, 'Cukkini', 0, 0.17),
(61, 'Padlizsán', 0, 0.25),
(62, 'Kukorica', 0, 0.86),
(63, 'Ketchup', 0, 1.12),
(64, 'Majonéz', 0, 6.8),
(65, 'Mustár', 0, 0.66),
(66, 'Szójaszósz', 0, 0.53),
(67, 'Tészta (száraz)', 0, 3.71),
(68, 'Bulgur', 0, 3.42),
(69, 'Quinoa', 0, 3.68),
(70, 'Tofu', 0, 0.76),
(71, 'Áfonya', 1, 0.57),
(72, 'Málna', 1, 0.52),
(73, 'Szeder', 1, 0.43),
(74, 'Ananász', 1, 0.5),
(75, 'Mangó', 1, 0.6),
(76, 'Szőlő', 1, 0.69),
(77, 'Datolya', 1, 2.82),
(78, 'Mazsola', 1, 2.99),
(79, 'Füge', 1, 0.74),
(80, 'Kivi', 1, 0.61),
(81, 'Zöldbab', 0, 0.31),
(82, 'Karfiol', 0, 0.25),
(83, 'Kelbimbó', 0, 0.43),
(84, 'Vöröskáposzta', 0, 0.31),
(85, 'Fejes káposzta', 0, 0.25),
(86, 'Cékla', 0, 0.43),
(87, 'Édesburgonya', 0, 0.86),
(88, 'Hajdina', 0, 3.43),
(89, 'Kuszkusz', 0, 3.76),
(90, 'Rizstej', 0, 0.47),
(91, 'Mandulatej', 0, 0.13),
(92, 'Zabtej', 0, 0.46),
(93, 'Kecskesajt', 0, 3.64),
(94, 'Feta sajt', 0, 2.64),
(95, 'Mozzarella', 0, 2.8),
(96, 'Ricotta', 0, 1.74),
(97, 'Pesto', 0, 4.54),
(98, 'Szezámmag', 0, 5.73),
(99, 'Chia mag', 0, 4.86),
(100, 'Lenmag', 0, 5.34);

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_recipe`
--

CREATE TABLE `ingredient_recipe` (
  `ingredientId` bigint(20) UNSIGNED NOT NULL,
  `recipeId` bigint(20) UNSIGNED NOT NULL,
  `gramAmount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ingredient_recipe`
--

INSERT INTO `ingredient_recipe` (`ingredientId`, `recipeId`, `gramAmount`) VALUES
(2, 2, 150),
(2, 4, 120),
(3, 1, 300),
(4, 1, 200),
(5, 1, 100),
(5, 3, 80),
(6, 2, 50),
(6, 3, 120),
(6, 4, 70),
(8, 4, 30),
(9, 8, 120),
(10, 8, 100),
(11, 8, 80),
(12, 6, 120),
(14, 7, 60),
(15, 7, 10),
(16, 5, 200),
(16, 8, 200),
(19, 7, 250),
(20, 6, 180),
(22, 5, 80),
(23, 5, 20),
(24, 6, 10),
(25, 6, 80),
(28, 7, 300),
(29, 5, 30);

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
(1, '2026_01_17_171002_create_users_table', 1),
(2, '2026_01_17_180530_create_ingredients_table', 1),
(3, '2026_01_20_153105_create_recipes_table', 1),
(4, '2026_01_20_153908_create_comments_table', 1),
(5, '2026_01_20_154313_create_user__ingredients_table', 1),
(6, '2026_01_20_155441_create_ingredient_recipe_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `imageUrl` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `name`, `userId`, `imageUrl`) VALUES
(1, 'Csirkemell rizzsel', 1, ''),
(2, 'Banános turmix', 1, ''),
(3, 'Paradicsomos omlett', 1, ''),
(4, 'Protein shake B-version', 2, ''),
(5, 'Zabkásás fehérje reggeli', 1, ''),
(6, 'Lazacos zöldséges tál', 2, ''),
(7, 'Marhahúsos ragu krumplival', 1, ''),
(8, 'Gyümölcsös joghurtos smoothie', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `passwrd` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `bodyweightKg` int(11) DEFAULT NULL,
  `heightCm` int(11) DEFAULT NULL,
  `birthDate` date DEFAULT current_timestamp(),
  `profilePictureUrl` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `passwrd`, `email`, `name`, `username`, `bodyweightKg`, `heightCm`, `birthDate`, `profilePictureUrl`) VALUES
(1, '12345678', 'pjozs@pelda.com', 'Példa József', 'pjzsf_1', 62, 168, '1993-05-12', ''),
(2, '87654321', 'panna@pelda.com', 'Példa Anna', 'annapel', 82, 182, '1988-12-01', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_ingredient`
--

CREATE TABLE `user_ingredient` (
  `userId` bigint(20) UNSIGNED NOT NULL,
  `ingredientId` bigint(20) UNSIGNED NOT NULL,
  `gramAmount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_ingredient`
--

INSERT INTO `user_ingredient` (`userId`, `ingredientId`, `gramAmount`) VALUES
(1, 1, 500),
(1, 3, 800),
(1, 4, 1000),
(1, 6, 200),
(2, 2, 300),
(2, 5, 400),
(2, 7, 1000),
(2, 8, 500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_recipeid_foreign` (`recipeId`),
  ADD KEY `comments_userid_foreign` (`userId`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ingredients_name_unique` (`name`);

--
-- Indexes for table `ingredient_recipe`
--
ALTER TABLE `ingredient_recipe`
  ADD PRIMARY KEY (`ingredientId`,`recipeId`),
  ADD KEY `ingredient_recipe_recipeid_foreign` (`recipeId`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipes_userid_foreign` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indexes for table `user_ingredient`
--
ALTER TABLE `user_ingredient`
  ADD PRIMARY KEY (`userId`,`ingredientId`),
  ADD KEY `user_ingredient_ingredientid_foreign` (`ingredientId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_recipeid_foreign` FOREIGN KEY (`recipeId`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ingredient_recipe`
--
ALTER TABLE `ingredient_recipe`
  ADD CONSTRAINT `ingredient_recipe_ingredientid_foreign` FOREIGN KEY (`ingredientId`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ingredient_recipe_recipeid_foreign` FOREIGN KEY (`recipeId`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_ingredient`
--
ALTER TABLE `user_ingredient`
  ADD CONSTRAINT `user_ingredient_ingredientid_foreign` FOREIGN KEY (`ingredientId`) REFERENCES `ingredients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_ingredient_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
