-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2025 at 11:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_csip5501`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `product_quantity`, `created_at`) VALUES
(8, 4, 3, 1, '2025-03-24 11:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `popular` tinyint(4) NOT NULL DEFAULT 0,
  `image` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` mediumtext NOT NULL,
  `meta_keywords` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `popular`, `image`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`) VALUES
(1, 'Backpacks', 'backpacks', 'This collection includes Nike, addidas, chanel and louis vuitton backpacks.', 1, 0, '1739983590.png', 'Backpacks', 'This collection includes Nike, addidas, chanel and louis vuitton backpacks.', 'Nike, addidas, chanel, louis vuitton, backpacks.', '2025-02-19 16:47:30'),
(2, 'iPhones', 'iPhones', 'This collection includes iPhones 11,12,13,14,15,16.', 1, 0, '1740065571.png', 'iPhones', 'This collection includes iPhones 11,12,13,14,15,16.', 'iPhones, Apple.', '2025-02-19 16:49:22'),
(3, 'Watches', 'watches', 'This collection includes Louis vuitton, chanel, gucci mens and womens watches.', 1, 1, '1739985579.png', 'Watches', 'This collection includes Louis vuitton, chanel, gucci mens and womens watches.', 'Louis vuitton, chanel, gucci, watches.', '2025-02-19 17:19:38'),
(6, 'Womens Shoes', 'womens-running-shoes', 'This collection includes Nike and addidas womens running shoes.', 1, 0, '1740134626.png', 'Womens Shoes', 'This collection includes Nike and addidas womens running shoes.', 'Nike, addidas, Womens Shoes.', '2025-02-21 10:43:46'),
(7, 'Mens Shoes', 'mens-running-shoes', 'This collection includes Nike and addidas mens road running shoes - White and black.', 1, 0, '1740134853.png', 'Mens Shoes', 'This collection includes Nike and addidas mens road running shoes - White and black.', 'Nike, addidas, Mens Shoes.', '2025-02-21 10:47:33'),
(8, 'Womens Handbags', 'hand-bags', 'This collection includes Louis Vuitton, Chanel, and Gucci womens handbags.', 1, 1, '1741263454.png', 'Womens Handbags', 'This collection includes Louis Vuitton, Chanel, and Gucci womens handbags.', 'women handbags, louis vuitton, chanel, gucci.', '2025-03-06 12:17:34'),
(9, 'Mens Suits', 'mens-suits', 'This collection will feature a diverse assortment of mens suits.', 1, 0, '1741264284.png', 'Mens Suits', 'This collection will feature a diverse assortment of mens suits.', 'Mens suits, outfits.', '2025-03-06 12:26:32'),
(10, 'Women Suits', 'women-suits', 'This collection will feature a diverse assortment of womens suits.', 1, 0, '1741264546.png', 'Women Suits', 'This collection will feature a diverse assortment of womens suits.', 'Women suits, outfits.', '2025-03-06 12:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `tracking_no` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` mediumtext NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `total_price` int(11) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `comments` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `tracking_no`, `user_id`, `name`, `email`, `phone_number`, `address`, `postal_code`, `total_price`, `payment_mode`, `payment_id`, `status`, `comments`, `created_at`) VALUES
(1, '224-UNLIMITED-TRADE876647554748820', 4, 'Ibrahima Diallo', 'thiernoibrahima48@gmail.com', '+447554748820', '229 Aikman Ave', 'LE3 9PX', 547, 'COD', '', 1, NULL, '2025-03-19 13:23:47'),
(2, '224-UNLIMITED-TRADE779747554748820', 4, 'Ibrahima Diallo', 'thiernoibrahima48@gmail.com', '+447554748820', '229 Aikman Ave', 'LE3 9PX', 149, 'COD', '', 0, NULL, '2025-03-20 12:26:16'),
(3, 'TRADE-BA2768F5-1742564874', 4, 'Ibrahima Diallo', 'thiernoibrahima48@gmail.com', '+447554748820', '229 Aikman Ave', 'LE3 9PX', 99, 'COD', '', 0, NULL, '2025-03-21 13:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_quantity`, `price`, `created_at`) VALUES
(1, 1, 1, 2, 199, '2025-03-19 13:23:47'),
(2, 1, 3, 1, 149, '2025-03-19 13:23:47'),
(3, 2, 3, 1, 149, '2025-03-20 12:26:16'),
(4, 3, 4, 1, 99, '2025-03-21 13:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `small_description` mediumtext NOT NULL,
  `description` mediumtext NOT NULL,
  `original_price` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `trending` tinyint(4) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` mediumtext NOT NULL,
  `meta_description` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `small_description`, `description`, `original_price`, `selling_price`, `image`, `quantity`, `status`, `trending`, `meta_title`, `meta_keywords`, `meta_description`, `created_at`) VALUES
(1, 2, 'iPhones 11', 'iPhones-11-pro-max', 'iPhones 11 Pro 256GB - Midnight Green - Unlocked.', 'The iPhone 11 Pro (256GB) in Midnight Green (Unlocked) is a premium Apple smartphone released in 2019. It features a 5.8-inch Super Retina XDR OLED display, providing vibrant colors and deep blacks. Powered by the A13 Bionic chip, it delivers fast performance and efficiency. The device has a triple 12MP camera system (Ultra-Wide, Wide, and Telephoto) with Night Mode, 4K video recording, and advanced computational photography. The 256GB storage allows ample space for apps, photos, and videos. Being unlocked, it is compatible with most carriers worldwide. The Midnight Green finish gives it a sleek and unique look. It also supports Face ID, wireless charging, and has IP68 water and dust resistance.', 499, 199, '1740159159_2948c454f2.png', 20, 1, 1, 'iPhones 11', 'iPhones, apple, iPhones 11.', 'iPhones 11 Pro 256GB - Midnight Green - Unlocked.', '2025-02-21 17:32:40'),
(2, 2, 'iPhone 12', 'iPhone-12-pro', 'iPhone 12 Pro 128GB - Pacific Blue - Unlocked.', 'The iPhone 12 Pro (128GB) in Pacific Blue (Unlocked) is a high-end Apple smartphone released in 2020. It features a 6.1-inch Super Retina XDR OLED display with Ceramic Shield for improved durability. Powered by the A14 Bionic chip, it delivers top-tier performance and efficiency. The triple 12MP camera system (Ultra-Wide, Wide, and Telephoto) supports Night Mode, Deep Fusion, LiDAR for enhanced AR and low-light photography, and 4K Dolby Vision HDR recording. The 128GB storage offers ample space for apps, photos, and videos. Being unlocked, it works with most carriers worldwide. The Pacific Blue color gives it a stylish, premium look. It supports 5G, MagSafe charging, Face ID, and has IP68 water and dust resistance.', 599, 299, '1740241189_690b79a6b1.png', 20, 1, 1, 'iPhone 12', 'iPhone 12, apple, iPhone.', 'iPhone 12 Pro 128GB - Pacific Blue - Unlocked.', '2025-02-22 16:19:49'),
(3, 1, 'Nike Backpack', 'nike-academy-backpack', 'Nike Academy Team Backpack.', 'The Nike Academy Team Backpack is a stylish and functional bag designed for athletes, students, and everyday users. It features a spacious main compartment for storing gear, books, or clothing, along with a separate ventilated pocket to keep shoes or wet items apart from clean belongings. The backpack includes padded shoulder straps and a back panel for comfortable carrying, while its side mesh pockets provide easy access to water bottles or small essentials. With a water-resistant bottom, it offers added protection against moisture and dirt, making it a reliable choice for sports, school, or travel.', 199, 149, '1740313915_66b3ab2a46.png', 9, 1, 1, 'Nike Backpack', 'Nike, backpack.', 'Nike Academy Team Backpack.', '2025-02-23 12:31:55'),
(4, 3, 'Gucci Watch', 'gucci-watch', 'Gucci G-Timeless Watch, 38mm.', 'The Gucci G-Timeless Watch (38mm) is a sophisticated and stylish timepiece that blends luxury with modern elegance. It features a 38mm stainless steel case, a Swiss quartz movement for precise timekeeping, and a sleek dial adorned with Gucci’s signature motifs, such as the bee, stars, or the iconic GG pattern. The watch is available in various designs, including models with leather, stainless steel, or mesh straps. With its scratch-resistant sapphire crystal and water resistance, it offers durability alongside its high-end aesthetic, making it a perfect statement piece for both casual and formal wear.', 149, 99, '1740314168_dd0e98f743.png', 14, 1, 1, 'Gucci Watch', 'Gucci, watch.', 'Gucci G-Timeless Watch, 38mm.', '2025-02-23 12:36:08'),
(5, 3, 'Chanel J12 Watch', 'chanel-watch', 'Chanel J12 White Ceramic.', 'The Chanel J12 White Ceramic is a luxurious and contemporary timepiece known for its sleek design and high-performance craftsmanship. Made from high-tech white ceramic, it offers exceptional durability, scratch resistance, and a glossy, elegant finish. The watch typically features a self-winding Swiss automatic movement or a quartz movement, depending on the model. It comes with a unidirectional rotating bezel, luminescent hands, and water resistance up to 200 meters, making it both stylish and functional. The sapphire crystal enhances its durability, while the minimalist yet sophisticated design makes it a timeless fashion statement.', 149, 99, '1740314390_8c106ac61d.png', 5, 1, 1, 'Chanel J12 Watch', 'Chanel, watch.', 'Chanel J12 White Ceramic.', '2025-02-23 12:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_as` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `phone`, `password`, `role_as`, `created_at`) VALUES
(1, 'Ibrahima Diallo', 'thiernoibrahima48@gmail.com', '07554748820', '$2y$10$DglE8aTJ7cXS0OQbJPPtUONpZvyxEITt.B82fvF1TVhBVvD6txCYe', 1, '2025-02-18 12:58:40'),
(4, 'Kadiatou Barry', 'kadiatou123@gmail.com', '07455758730', '$2y$10$psJK1o/vJ2qFCj0UmBq1zeY4JeBVdPEWpLJmb.niRUictGfiP9HvK', 0, '2025-02-18 21:52:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
