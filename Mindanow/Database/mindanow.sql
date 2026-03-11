-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2026 at 10:53 AM
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
-- Database: `mindanow`
--

-- --------------------------------------------------------

--
-- Table structure for table `advisories`
--

CREATE TABLE `advisories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`) VALUES
(1, 'Storm warning!', 'Typhoon Bopha made landfall over Mindanao on December 4, destroying homes, cutting power and forcing the cancellation of flights and ferry services. There was only one confirmed death at that moment, but local media said people were injured by flying debris and falling trees.', '2026-03-11 08:29:02');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `header_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `created_at`, `header_image`) VALUES
(4, 'Siargao: Mindanao’s Island Paradise 🌴🌊', 'When you think of paradise in the Philippines, Siargao Island often tops the list. Known worldwide as a surfing haven, this tropical gem offers more than just waves—it’s a mosaic of pristine beaches, turquoise lagoons, lush forests, and vibrant island culture.\r\n\r\nThe Surfing Capital of the Philippines\r\n\r\nSiargao has earned the title of “Surfing Capital of the Philippines” thanks to the famous Cloud 9 break. Every year, surfers from around the globe flock here to ride some of the best waves in Southeast Asia. But even if you don’t surf, watching the surfers from the boardwalk as the sun rises or sets is an unforgettable experience.\r\n\r\nNatural Wonders Beyond the Waves\r\n\r\nSiargao’s beauty isn’t limited to the ocean. The island is dotted with stunning natural attractions that make it perfect for adventure seekers and nature lovers alike:\r\n\r\nSugba Lagoon – A serene lagoon with crystal-clear waters, perfect for swimming, paddleboarding, or simply soaking in the tropical scenery.\r\n\r\nMagpupungko Rock Pools – Natural tidal pools where you can swim in calm, turquoise water surrounded by rock formations during low tide.\r\n\r\nNaked, Daku, and Guyam Islands – Tiny islands off Siargao’s coast with powdery white sand, swaying coconut trees, and untouched beauty.\r\n\r\nLush Landscapes and Hidden Corners\r\n\r\nVenture inland, and you’ll find palm-fringed roads, mangrove forests, and coconut groves that make the island feel like a secret paradise. The scenery here isn’t just picturesque—it’s immersive, letting you breathe the fresh island air and feel truly disconnected from city life.\r\n\r\nIsland Vibes and Local Culture\r\n\r\nBeyond its natural beauty, Siargao’s charm comes from its warm and welcoming locals. Small cafés, boutique resorts, and artisan shops add to the laid-back vibe. Whether you’re enjoying fresh coconut juice on the beach or exploring the island’s trails, you’ll feel the rhythm of island life in every moment.', '2026-03-03 10:01:38', '1773155230_9e00757faa6fd4123facefcdd345d902.jpg'),
(5, 'Discovering the Enchanted River: Mindanao\'s Mystical Gem', 'Discovering the Enchanted River: Mindanao\'s Mystical Gem\r\n\r\nThe Enchanted River, often mistakenly linked to Davao, is actually in Barangay Talisay, Hinatuan, Surigao del Sur, about a 4-5 hour drive from Davao City. This saltwater river captivates with its crystal-clear sapphire and jade hues, flowing into the Pacific Ocean without visible silt, thanks to an underground cave system.\r\n\r\nLocal Legends and Magic\r\nLocals attribute the river\'s enchanting colors to fairies mixing sapphire and jade, while stories speak of engkantos (supernatural beings) and uncatchable fish guarding its depths up to 80 feet. Fish feeding happens daily at noon and 3 PM—swimmers must exit as a bell rings and the \"Hymn of Hinatuan\" plays, drawing colorful schools from the deep.\r\n\r\nWhat to Expect\r\nSwim in the cool, vibrant waters surrounded by lush greenery and orchids, but note the no-swim zone beyond 5 PM for clearer views. Entrance fees apply (around 50-100 PHP, check locally), with cottages, life vests, and snorkeling available; nearby island hopping costs about 500 PHP for 2 hours.\r\n\r\nHow to Visit from Davao\r\nTake a van or bus from Davao City to Hinatuan (drop-off at the signboard), then a tricycle to the site—tours bundling Enchanted River with other Surigao spots simplify logistics. Best visited early to avoid crowds; combine with Britania Islands for a full day trip.', '2026-03-11 06:21:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_images`
--

CREATE TABLE `article_images` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article_images`
--

INSERT INTO `article_images` (`id`, `article_id`, `filename`) VALUES
(4, 4, '1773156199_9e00757faa6fd4123facefcdd345d902.jpg'),
(5, 4, '1773156214_rtsdtptwcao51.jpg'),
(6, 4, '1773156214_440602870_25583914137889766_2240980588673340731_n.jpg'),
(8, 5, '1773210096_488003739_991526193104940_5020289552231998823_n.jpg'),
(9, 5, '1773210096_487538661_991526176438275_3348618228542817232_n.jpg'),
(10, 5, '1773210096_fb_img_1502606496326.jpg'),
(11, 5, '1773210902_fb_img_1502606496326.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cuisines`
--

CREATE TABLE `cuisines` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuisines`
--

INSERT INTO `cuisines` (`id`, `title`, `description`, `image`, `created_at`) VALUES
(1, 'Discover the Flavors of Davao: Mindanao’s Rising Food Destination 🍽️🌴', 'When people talk about travel in Mindanao, beaches, mountains, and adventure activities often take the spotlight. But in recent years, Davao City has quietly become one of the most exciting food destinations in Mindanao. Known for its diverse culture and access to fresh ingredients, the city offers a culinary experience that blends indigenous traditions, Filipino comfort food, and modern innovation.\r\n\r\nWhether you\'re a traveler searching for authentic flavors or a local foodie looking for the next great meal, Davao\'s food scene has something unforgettable waiting.\r\n\r\n\r\nA Culinary Culture Built on Diversity\r\n\r\nOne reason Davao City stands out is its cultural mix. The city is home to Lumad communities, Moro traditions, and migrants from different parts of the Philippines, each contributing unique flavors and cooking styles.\r\n\r\nThis diversity means you can find:\r\n\r\nTraditional Mindanao dishes\r\n\r\nFresh seafood specialties\r\n\r\nGrilled street food\r\n\r\nContemporary Filipino cuisine\r\n\r\nAll within a few streets of each other.\r\n\r\nMust-Try Local Delicacies\r\n\r\nNo food trip in Davao City is complete without trying some of its iconic dishes.\r\n\r\n1. Durian Delights\r\nDavao is famously known as the Durian Capital of the Philippines. While the fruit’s smell can be intimidating, locals turn it into delicious treats such as:\r\n\r\nDurian candy\r\n\r\nDurian coffee\r\n\r\nDurian ice cream\r\n\r\n2. Grilled Tuna Belly\r\nThanks to nearby fishing grounds, Davao serves incredibly fresh tuna. Restaurants often grill tuna belly over charcoal, creating a smoky flavor that pairs perfectly with rice and soy-calamansi dipping sauce.\r\n\r\n3. Kinilaw na Tuna\r\nMindanao’s version of ceviche features fresh tuna marinated in vinegar, calamansi, ginger, and chili. It’s refreshing, tangy, and a favorite appetizer among locals.\r\n\r\n4. Sinuglaw\r\nA unique Mindanao specialty combining grilled pork (sinugba) and fish ceviche (kinilaw). The mix of smoky and tangy flavors makes this dish a must-try.\r\n\r\nFood Spots Locals Love\r\n\r\nMany food lovers visiting Davao City start their culinary journey at iconic spots like:\r\n\r\nRoxas Night Market – famous for street food, grilled seafood, and affordable local eats.\r\n\r\nDavao Dencia\'s Restaurant – well known for classic Filipino dishes.\r\n\r\nBondi & Bourke – a popular upscale restaurant mixing global flavors with local ingredients.\r\n\r\nThese places showcase the variety of dining experiences available—from bustling street stalls to modern dining spots.\r\n\r\nBeyond the Plate: A Food Experience\r\n\r\nEating in Davao City is more than just tasting food—it’s about experiencing the culture of Mindanao. Friendly locals, vibrant markets, and freshly harvested ingredients create a culinary scene that feels both authentic and welcoming.\r\n\r\nFrom smoky barbecue at night markets to exotic fruit desserts, Davao proves that Mindanao is one of the Philippines’ most exciting food frontiers.\r\n\r\n✨ Final Bite\r\n\r\nIf you’re planning your next food adventure, skip the usual destinations and explore Davao City. With its bold flavors, cultural richness, and unforgettable dishes, it’s quickly becoming one of Mindanao’s hottest food destinations.', NULL, '2026-03-11 09:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `cuisine_images`
--

CREATE TABLE `cuisine_images` (
  `id` int(11) NOT NULL,
  `cuisine_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cuisine_images`
--

INSERT INTO `cuisine_images` (`id`, `cuisine_id`, `filename`, `created_at`) VALUES
(1, 1, '1773191894_roxas-night-market-street-food-festival-davao-JYPXP8.jpg', '2026-03-11 01:18:14'),
(2, 1, '1773191894_homepage_650022454ea9a_1721729218_large.jpg', '2026-03-11 01:18:14'),
(3, 1, '1773191894_main-dining-2.jpg', '2026-03-11 01:18:14'),
(4, 1, '1773191894_641381451_1371768154995579_2571934925822234698_n.jpg', '2026-03-11 01:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','editor') DEFAULT 'editor',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(3, 'admin', 'admin@mindanow.com', '$2y$10$4rjswsW2mLTtlPEE51LOHuYF6GXuf/AhEvY3fiKf82E1v4b1eYzr.', 'admin', '2026-03-03 09:48:54'),
(4, 'carl', 'cimagalacj@gmail.com', '$2y$10$wfKPxyrQAMCHPRdGwZVtfusD.cxE8cjFfjGhQikaAEZ509LoouHf2', 'editor', '2026-03-10 15:35:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advisories`
--
ALTER TABLE `advisories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_images`
--
ALTER TABLE `article_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `cuisines`
--
ALTER TABLE `cuisines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cuisine_images`
--
ALTER TABLE `cuisine_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advisories`
--
ALTER TABLE `advisories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `article_images`
--
ALTER TABLE `article_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cuisines`
--
ALTER TABLE `cuisines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cuisine_images`
--
ALTER TABLE `cuisine_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article_images`
--
ALTER TABLE `article_images`
  ADD CONSTRAINT `article_images_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
