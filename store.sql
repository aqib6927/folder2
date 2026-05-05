-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2026 at 02:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `prod_id`, `quantity`, `added_date`) VALUES
(4, 8, 15, 1, '2026-04-30 07:44:52'),
(5, 8, 5, 1, '2026-04-30 07:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_description`, `created_at`) VALUES
(1, 'Cosmetics', 'Beauty products', '2026-04-28 05:31:45'),
(2, 'Jewelry', 'Imitation jewelry', '2026-04-28 05:31:45'),
(3, 'Skincare', 'Skin care products', '2026-04-28 05:31:45');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`) VALUES
(1, 8, '2026-04-30 07:42:15', 850.00, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `prod_id`, `quantity`, `price`) VALUES
(1, 1, 6, 1, 850.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `cat_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_name`, `prod_description`, `price`, `quantity`, `cat_id`, `image`, `created_at`) VALUES
(4, 'Lipstick', 'Long lasting matte finish', 299.00, 50, 1, 'lipstick.jpg', '2026-04-29 07:15:09'),
(5, 'Red Lipstick V2', 'Creamy texture red shade', 350.00, 30, 1, 'lipstick2.jpg', '2026-04-29 07:15:09'),
(6, 'Professional Foundation', 'Full coverage base', 850.00, 19, 1, 'foundation.jpg', '2026-04-29 07:15:09'),
(7, 'Light Foundation', 'Daily wear light base', 700.00, 25, 1, 'foundation2.webp', '2026-04-29 07:15:09'),
(8, 'Eyeshadow Palette', 'Multi-color glitter palette', 1200.00, 15, 1, 'eyeshadow.webp', '2026-04-29 07:15:09'),
(9, 'Pearl Necklace', 'Elegant white pearl set', 499.00, 40, 2, 'pearl.jpg', '2026-04-29 07:15:09'),
(10, 'Gold Pearl Set', 'Gold plated pearl necklace', 550.00, 35, 2, 'pearl2.jpg', '2026-04-29 07:15:09'),
(11, 'Classic Necklace', 'Simple daily wear necklace', 400.00, 45, 2, 'necklace.jpg', '2026-04-29 07:15:09'),
(12, 'Diamond Style Necklace', 'Shiny crystal necklace', 999.00, 10, 2, 'necklace2.jpg', '2026-04-29 07:15:09'),
(13, 'Organic Pearl Cream', 'Natural skin glowing cream', 800.00, 20, 2, 'pearl3.webp', '2026-04-29 07:15:09'),
(14, 'Sunscreen Lotion', 'Total UV protection', 650.00, 25, 2, 'pearl4.jpg', '2026-04-29 07:15:09'),
(15, 'Face Wash', 'Deep cleaning charcoal face wash', 199.00, 72, 3, 'facewash.jpg', '2026-04-29 07:15:09'),
(17, 'Zirconia Bridal Set', 'A timeless 3-piece silver-toned set with sparkling American Diamonds and classic teardrop stones', 20000.00, 50, 2, 'Zirconia Bridal 1.webp', '2026-05-04 07:50:20'),
(18, 'Choker Necklace', 'A bold and beautiful statement choker, designed to add elegance and grace to any festive outfit', 25000.00, 50, 2, 'Choker Necklace2.webp    ', '2026-05-04 07:59:20'),
(19, 'Emerald Bridal Choker', 'Luxurious emerald green stones set in intricate kundan work, creating a majestic bridal masterpiece', 30000.00, 50, 2, 'Emerald Bridal Choker3.webp', '2026-05-04 08:00:49'),
(20, 'Antique Temple Set ', 'Traditional Goddess Lakshmi motifs in a stunning antique gold finish, perfect for a regal bridal look.', 50000.00, 50, 2, 'Antique Temple Set4.webp', '2026-05-04 08:02:13'),
(21, 'Emerald Zircon Bridal Set', 'Dazzling silver-finish set featuring premium emerald stones and high-quality zirconia for a diamond-like glow', 30000.00, 60, 2, 'Emerald Zircon Bridal Set5.webp', '2026-05-04 08:03:15'),
(22, 'Green Bead Choker', 'Charming matte gold choker adorned with vibrant green beads and delicate pearl hangings', 35000.00, 30, 2, 'Green Bead Choker6.webp', '2026-05-04 08:04:13'),
(23, 'Emerald Pendant Set', 'Sophisticated teardrop emerald pendant paired with sparkling zircons for a refined and modern touch', 30000.00, 30, 2, 'Emerald Pendant Set7.webp', '2026-05-04 08:05:24'),
(24, 'Mint Green Gajra Set', 'Fresh and delicate mint green crystal beads in a beautiful gajra-style choker for a soft, elegant look', 10000.00, 50, 2, 'Mint Green Gajra Set7.webp', '2026-05-04 08:07:05'),
(25, 'Royal Bridal Choker', 'A heavy, royal-themed kundan choker featuring a unique blend of emerald and honey-brown stones', 20000.00, 20, 2, 'Royal Bridal Choker8.webp', '2026-05-04 08:08:14'),
(26, 'Kundan Bridal Choker   ', 'Exquisite white kundan stones with deep green bead drops, blending tradition with timeless style', 50000.00, 70, 2, 'Kundan Bridal Choker9.webp', '2026-05-04 08:09:31'),
(27, 'Silver Heavy Bridal Set', 'Magnificent antique silver-plated Maharani set, perfect for brides who want a shahi and vintage feel', 50000.00, 50, 2, 'Silver Heavy Bridal Set10.webp', '2026-05-04 08:10:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `work_phone` varchar(20) DEFAULT NULL,
  `cell_no` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `address`, `email`, `work_phone`, `cell_no`, `dob`, `category`, `remarks`, `password`, `is_admin`, `created_at`) VALUES
(8, 'aqib ', ' i am admin', 'aqib@gmail.com', '0349393939', '0293939393', '2026-04-14', 'Regular Customer', 'hy', '827ccb0eea8a706c4c34a16891f84e7b', 1, '2026-04-29 20:05:05'),
(9, 'ahmed', 'gg', 'test@gmail.com', '0303030399', '88888888888', '2026-04-13', 'Regular Customer', 'ff', '827ccb0eea8a706c4c34a16891f84e7b', 0, '2026-04-30 02:17:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
