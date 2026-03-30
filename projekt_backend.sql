-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2026 at 05:49 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

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
  `kcalPerGram` double NOT NULL,
  `unit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `isFruit`, `kcalPerGram`, `unit`) VALUES
(1, 'Alma', 1, 78, 'db'),
(2, 'Banán', 1, 105, 'db'),
(3, 'Csirkemell', 0, 1.2, 'g'),
(4, 'Rizs', 0, 3.5, 'g'),
(5, 'Paradicsom', 0, 22, 'db'),
(6, 'Tojás', 0, 78, 'db'),
(7, 'Liszt', 0, 3.4, 'g'),
(8, 'Cukor', 0, 3.87, 'g'),
(9, 'Narancs', 1, 62, 'db'),
(10, 'Eper', 1, 0.33, 'g'),
(11, 'Körte', 1, 102, 'db'),
(12, 'Brokkoli', 0, 135, 'db'),
(13, 'Sárgarépa', 0, 25, 'db'),
(14, 'Vöröshagyma', 0, 40, 'db'),
(15, 'Fokhagyma', 0, 5, 'db'),
(16, 'Tej', 0, 0.42, 'ml'),
(17, 'Tejföl', 0, 2.04, 'g'),
(18, 'Sajt', 0, 3.5, 'g'),
(19, 'Marhahús', 0, 2.5, 'g'),
(20, 'Lazac', 0, 2.08, 'g'),
(21, 'Tonhal', 0, 1.3, 'g'),
(22, 'Zabpehely', 0, 3.8, 'g'),
(23, 'Méz', 0, 3.04, 'g'),
(24, 'Olívaolaj', 0, 8.84, 'ml'),
(25, 'Paprika', 0, 31, 'db'),
(26, 'Uborka', 0, 40, 'db'),
(27, 'Gomba', 0, 0.22, 'g'),
(28, 'Krumpli', 0, 115, 'db'),
(29, 'Tejsavó fehérje', 0, 3.9, 'g'),
(30, 'Mandula', 0, 5.79, 'g'),
(31, 'Joghurt natúr', 0, 0.61, 'g'),
(32, 'Görög joghurt', 0, 0.95, 'g'),
(33, 'Vaj', 0, 7.17, 'g'),
(34, 'Margarin', 0, 5.2, 'g'),
(35, 'Teljes kiőrlésű kenyér', 0, 95, 'db'),
(36, 'Fehér kenyér', 0, 105, 'db'),
(37, 'Sonka', 0, 1.2, 'g'),
(38, 'Pulykamell', 0, 1.1, 'g'),
(39, 'Bacon', 0, 65, 'db'),
(40, 'Kolbász', 0, 3.8, 'g'),
(41, 'Túró', 0, 1.1, 'g'),
(42, 'Tejszín', 0, 2.9, 'ml'),
(43, 'Kakaópor', 0, 2.3, 'g'),
(44, 'Csokoládé ét', 0, 5.4, 'g'),
(45, 'Csokoládé tej', 0, 5.3, 'g'),
(46, 'Citrom', 1, 29, 'db'),
(47, 'Lime', 1, 20, 'db'),
(48, 'Avokádó', 1, 270, 'db'),
(49, 'Kókuszolaj', 0, 8.62, 'g'),
(50, 'Kókuszreszelék', 0, 6.6, 'g'),
(51, 'Mogyoróvaj', 0, 5.9, 'g'),
(52, 'Dió', 0, 6.54, 'g'),
(53, 'Kesudió', 0, 5.53, 'g'),
(54, 'Lencse', 0, 3.4, 'g'),
(55, 'Csicseriborsó', 0, 3.6, 'g'),
(56, 'Vörös bab', 0, 3.3, 'g'),
(57, 'Borsó', 0, 0.81, 'g'),
(58, 'Spenót', 0, 0.23, 'g'),
(59, 'Saláta', 0, 30, 'db'),
(60, 'Cukkini', 0, 50, 'db'),
(61, 'Padlizsán', 0, 85, 'db'),
(62, 'Kukorica', 0, 0.9, 'g'),
(63, 'Ketchup', 0, 1, 'g'),
(64, 'Majonéz', 0, 6.8, 'g'),
(65, 'Mustár', 0, 0.7, 'g'),
(66, 'Szójaszósz', 0, 0.6, 'ml'),
(67, 'Tészta (száraz)', 0, 3.6, 'g'),
(68, 'Bulgur', 0, 3.42, 'g'),
(69, 'Quinoa', 0, 3.65, 'g'),
(70, 'Tofu', 0, 0.76, 'g'),
(71, 'Áfonya', 1, 0.57, 'g'),
(72, 'Málna', 1, 0.52, 'g'),
(73, 'Szeder', 1, 0.43, 'g'),
(74, 'Ananász', 1, 450, 'db'),
(75, 'Mangó', 1, 190, 'db'),
(76, 'Szőlő', 1, 0.67, 'g'),
(77, 'Datolya', 1, 28, 'db'),
(78, 'Mazsola', 1, 3, 'g'),
(79, 'Füge', 1, 37, 'db'),
(80, 'Kivi', 1, 42, 'db'),
(81, 'Zöldbab', 0, 0.31, 'g'),
(82, 'Karfiol', 0, 125, 'db'),
(83, 'Kelbimbó', 0, 0.43, 'g'),
(84, 'Vöröskáposzta', 0, 0.31, 'g'),
(85, 'Fejes káposzta', 0, 200, 'db'),
(86, 'Cékla', 0, 65, 'db'),
(87, 'Édesburgonya', 0, 170, 'db'),
(88, 'Hajdina', 0, 3.4, 'g'),
(89, 'Kuszkusz', 0, 3.6, 'g'),
(90, 'Rizstej', 0, 0.47, 'ml'),
(91, 'Mandulatej', 0, 0.25, 'ml'),
(92, 'Zabtej', 0, 0.45, 'ml'),
(93, 'Kecskesajt', 0, 3.64, 'g'),
(94, 'Feta sajt', 0, 2.64, 'g'),
(95, 'Mozzarella', 0, 350, 'db'),
(96, 'Ricotta', 0, 1.74, 'g'),
(97, 'Pesto', 0, 4.5, 'g'),
(98, 'Szezámmag', 0, 5.7, 'g'),
(99, 'Chia mag', 0, 4.8, 'g'),
(100, 'Lenmag', 0, 5.3, 'g');

-- --------------------------------------------------------

--
-- Table structure for table `ingredient_recipe`
--

CREATE TABLE `ingredient_recipe` (
  `ingredientId` bigint(20) UNSIGNED NOT NULL,
  `recipeId` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `ingredient_recipe`
--

INSERT INTO `ingredient_recipe` (`ingredientId`, `recipeId`, `amount`) VALUES
(2, 2, 1),
(2, 4, 1),
(3, 1, 300),
(4, 1, 200),
(5, 1, 2),
(5, 3, 1),
(6, 2, 1),
(6, 3, 2),
(6, 4, 2),
(8, 4, 30),
(9, 8, 1),
(10, 8, 5),
(11, 8, 1),
(12, 6, 1),
(14, 7, 1),
(15, 7, 2),
(16, 5, 200),
(16, 8, 200),
(19, 7, 250),
(20, 6, 180),
(22, 5, 80),
(23, 5, 20),
(24, 6, 10),
(25, 6, 1),
(28, 7, 3),
(29, 5, 30);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_01_17_171002_create_users_table', 1),
(2, '2026_01_17_180530_create_ingredients_table', 1),
(3, '2026_01_20_153105_create_recipes_table', 1),
(4, '2026_01_20_153908_create_comments_table', 1),
(5, '2026_01_20_154313_create_user__ingredients_table', 1),
(6, '2026_01_20_155441_create_ingredient_recipe_table', 1),
(7, '2026_03_17_163126_create_password_reset_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `imageUrl` text DEFAULT NULL,
  `isMakeable` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `calories` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `name`, `userId`, `imageUrl`, `isMakeable`, `description`, `calories`) VALUES
(1, 'Csirkemell rizzsel', 1, 'http://127.0.0.1:8000/storage/recipeImages/csirkemell_rizzsel.jpg', 0, 'A rizst főzd meg enyhén sós vízben. A csirkemellet vágd szeletekre, fűszerezd ízlés szerint, majd serpenyőben süsd aranybarnára. A paradicsomot szeleteld fel, és tálald a csirkével és a rizzsel együtt.', 1104),
(2, 'Banános turmix', 1, 'http://127.0.0.1:8000/storage/recipeImages/banan_turmix.jpg', 0, 'A banánt tedd turmixgépbe, add hozzá a tojást, majd turmixold simára. Fogyaszthatod azonnal, hidegen a legfinomabb.', 183),
(3, 'Paradicsomos omlett', 1, 'http://127.0.0.1:8000/storage/recipeImages/omlett.jpg', 0, 'A tojásokat verd fel egy tálban. A paradicsomot vágd kisebb darabokra. Serpenyőben süsd meg az omlettet, majd a paradicsomot tedd rá a tetejére, és hajtsd félbe.', 178),
(4, 'Protein shake B-version', 2, 'http://127.0.0.1:8000/storage/recipeImages/choc-pb-carm-protein-shake.jpg', 0, 'A banánt, a cukrot és a tojást tedd turmixgépbe, majd turmixold krémes állagúra. Fogyaszd frissen, akár edzés után is.', 377),
(5, 'Zabkásás fehérje reggeli', 1, 'http://127.0.0.1:8000/storage/recipeImages/zabkasa.jpg', 0, 'A zabpelyhet főzd össze a tejjel pár perc alatt. Keverd hozzá a tejsavó fehérjét és a mézet, majd jól dolgozd el. Melegen tálald.', 566),
(6, 'Lazacos zöldséges tál', 2, 'http://127.0.0.1:8000/storage/recipeImages/lazacostal.jpg', 0, 'A lazacot fűszerezd, majd serpenyőben vagy sütőben süsd készre. A brokkolit párold meg, a paprikát szeleteld fel. Tálald a lazacot a zöldségekkel, és locsold meg egy kevés olívaolajjal.', 629),
(7, 'Marhahúsos ragu krumplival', 1, 'http://127.0.0.1:8000/storage/recipeImages/ragu.jpg', 0, 'A marhahúst kockázd fel, majd pirítsd meg. Add hozzá az apróra vágott vöröshagymát és fokhagymát, majd kevés vízzel párold puhára. A krumplit főzd vagy süsd meg külön, és a ragu mellé tálald.', 1020),
(8, 'Gyümölcsös joghurtos smoothie', 2, 'http://127.0.0.1:8000/storage/recipeImages/smoothie.jpg', 0, 'A narancsot és a körtét tisztítsd meg, majd darabold fel. Az eperrel és a tejjel együtt tedd turmixgépbe, majd turmixold simára. Hidegen tálald.', 250);

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
  `profilePictureUrl` text DEFAULT NULL,
  `caloriesEaten` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `passwrd`, `email`, `name`, `username`, `bodyweightKg`, `heightCm`, `birthDate`, `profilePictureUrl`, `caloriesEaten`) VALUES
(1, '12345678', 'pjozs@gmail.com', 'Példa József', 'pjzsf_1', 62, 168, '1993-05-12', 'http://127.0.0.1:8000/storage/profilePictures/E8CkcN0UxPIsZAF86YYGla0sVEQW7xhvaZgOGO5Q.png', 0),
(2, '87654321', 'panna@gmail.com', 'Példa Anna', 'annapel', 82, 182, '1988-12-01', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_ingredient`
--

CREATE TABLE `user_ingredient` (
  `userId` bigint(20) UNSIGNED NOT NULL,
  `ingredientId` bigint(20) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- Dumping data for table `user_ingredient`
--

INSERT INTO `user_ingredient` (`userId`, `ingredientId`, `amount`) VALUES
(1, 1, 500),
(1, 3, 800),
(1, 4, 1000),
(1, 5, 5),
(1, 6, 3),
(2, 2, 300),
(2, 5, 5),
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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `recipes_userid_foreign` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
