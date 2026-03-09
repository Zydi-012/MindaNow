-- MindaNow v2 Database Upgrade Script
-- Run this to add new features

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Add full_name column to users
ALTER TABLE `users` ADD COLUMN `full_name` varchar(100) DEFAULT NULL AFTER `username`;

-- Create categories table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL UNIQUE,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create article_categories junction table
CREATE TABLE IF NOT EXISTS `article_categories` (
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`, `category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add new columns to articles table
ALTER TABLE `articles`
    ADD COLUMN slug VARCHAR(255) UNIQUE AFTER title,
    ADD COLUMN featured_image VARCHAR(500) DEFAULT NULL AFTER content,
    ADD COLUMN author_id INT(11) DEFAULT (SELECT id FROM users WHERE role='admin' LIMIT 1),
    ADD COLUMN status ENUM('published','draft') DEFAULT 'draft' AFTER created_at;

-- Update existing articles to be published by default and generate slugs from titles
UPDATE articles SET status = 'published', 
    slug = LOWER(
        REPLACE(
            REPLACE(
                REPLACE(title, ' ', '-'),
                '.', ''),
            ',', '')
        )
WHERE slug IS NULL OR slug = '';

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
