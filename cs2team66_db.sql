-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2026 at 02:36 PM
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
-- Database: `cs2team66_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'Men', 'Men’s clothing and sportswear'),
(2, 'Women', 'Women’s clothing and sportswear'),
(3, 'Kids', 'Kids’ clothing and sportswear'),
(4, 'Accessories', 'Sports accessories and gear'),
(5, 'Trainers', 'Running shoes and trainers');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','shipped','delivered','cancelled') DEFAULT 'pending',
  `full_name` varchar(150) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `status`, `full_name`, `address1`, `address2`, `city`, `postcode`, `phone`) VALUES
(1, 1, '2026-03-14 20:30:56', 22.00, 'pending', 'Jaspinder Shergill', '3 Lavender Close', '', 'Walsall', 'WS5 4ST', '07368209033'),
(2, 1, '2026-03-14 20:49:50', 12.00, 'pending', 'Jaspinder Shergill', '3 Lavender Close', '', 'Walsall', 'WS5 4ST', '07368209033');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_purchase` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price_at_purchase`) VALUES
(1, 1, 29, 1, 22.00),
(2, 2, 26, 1, 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `created_at`, `updated_at`) VALUES
(26, 1, 'Adidas Men\'s Tiro24 Short Sleeve Performance T-Shirt', 'The adidas Tiro24 Short Sleeve Performance T-Shirt is built for football training with a streamlined cut. Designed to support active sessions, it offers a clean, athletic fit.', 12.00, 0, 'products/mens/adidas_blue_t_front.png', '2026-03-14 18:46:08', '2026-03-14 20:49:50'),
(27, 1, 'Nike Icon Futura T-Shirt Mens', 'Keep it simple. The Nike Icon Futura T-Shirt keeps things classic with a solid colour-way that makes the contrasting Nike wordmark and Swoosh pop. Cut to a regular fit, it’s the easy tee you’ll reach for again and again.', 17.00, 1, 'products/mens/nike_black_t_front.png', '2026-03-14 18:46:08', '2026-03-14 20:02:01'),
(28, 1, 'Under Armour Logo T-Shirt Mens', 'Everyone makes graphic Ts...but Under Armour makes them better. The fabric we use is light, soft, and quick-drying.', 19.99, 1, 'products/mens/underarmour_blue_t_front.png', '2026-03-14 18:46:08', '2026-03-14 20:02:01'),
(29, 1, 'The North Face 24/7 Short Sleeve T-Shirt Mens', 'Wherever you like to train and however you like to work out, the 100% recycled 24/7 T-Shirt will help keep you dry. Engineered with FlashDry™ technology acting like a second skin, the fabric works to draw moisture to the surface where it rapidly evaporates.', 22.00, 0, 'products/mens/northface_blue_t_front.png', '2026-03-14 18:46:08', '2026-03-14 20:30:56'),
(30, 1, 'Puma Men\'s Short-Sleeve Performance T-Shirt', 'Puma\'s Short-Sleeve Performance T-Shirt merges athletic design with performance features. Designed for movement, this activewear piece offers breathability with a comfortable fit.', 15.00, 0, 'products/mens/puma_orange_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(31, 2, 'Nike Futura T-Shirt Ladies', 'This Nike Futura T Shirt is crafted with short sleeves and a crew neck for a classic look. It features flat lock seams to prevent chafing and is a lightweight construction.', 12.00, 0, 'products/womens/nike_white_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(32, 2, 'Puma Train Oversized Tee T-Shirt Womens', 'Puma\'s very nice green t-shirt that looks very green and nice.', 14.00, 0, 'products/womens/puma_green_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(33, 2, 'Under Armour Challenger Training T-Shirt Womens', 'The UA Challenger collection has all your go-to soccer gear that\'s built to keep you staying light and feeling fast on the field.', 17.00, 0, 'products/womens/underarmour_pink_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(34, 2, 'Under Armour Women\'s Rival Core Short-Sleeve Oversized T-Shirt', 'Under Armour\'s Women\'s Rival Core Short-Sleeve Oversized T-Shirt fuses athletic function with relaxed proportions.', 14.00, 0, 'products/womens/underarmour_blue_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(35, 2, 'Nike Tm Ss Polo Ld99', 'Nike Polo sport T-shirt', 12.00, 0, 'products/womens/nike_black_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(36, 3, 'The North Face Simple Dome Regular Fit T-Shirt Juniors', 'A wardrobe essential that delivers classic outdoor style, this regular-fit T-shirt from The North Face is perfect for everyday adventures.', 12.00, 0, 'products/kids/northface_black_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(37, 3, 'Nike Futura T Shirt Junior Boys', 'This Nike Futura T Shirt is crafted with short sleeves and a crew neck for a classic look.', 11.50, 0, 'products/kids/nike_black_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(38, 3, 'Under Armour Tech™ 2.0 Short Sleeve T-Shirt Juniors', 'UA Tech™ is our original go-to training gear: loose, light, and it keeps you cool.', 17.00, 0, 'products/kids/underarmour_orange_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(39, 3, 'Adidas Sereno Training Top Juniors', 'Get set to ignite the athletic spirit in your little champion with the adidas Sereno Training Top.', 12.99, 0, 'products/kids/adidas_purple_t_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(40, 3, 'Nike NSW Futura T Shirt Infant Boys', 'This Nike Futura T Shirt is crafted with short sleeves and a crew neck for a classic look.', 11.99, 0, 'products/kids/nike_black_t_front.png', '2026-03-14 18:46:08', '2026-03-15 12:47:19'),
(41, 4, 'Nike Elemental Kids Backpack (20l) Unisex Kids', 'Get ready for school with the Nike Elemental Backpack. Its durable design features 2 zippered compartments.', 21.00, 0, 'products/accessories/nike_backpack_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(42, 4, 'Nike Brasilia S Training Duffel Bag (Small 41L)', 'The Nike Brasilia Small Grip Bag is the perfect little gym bag for all your essentials.', 30.00, 0, 'products/accessories/nike_duffle_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(43, 4, 'Artic Men\'s Polar Grip Fleece Glove', 'Arctic Army Polar Grip Fleece Glove delivers essential winter warmth with functional style.', 13.00, 0, 'products/accessories/artic_gloves_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(44, 4, 'Nike Pacer Womens Therma-FIT Lightweight Running Gloves', 'Lightweight gloves help take the chill out of your run, so you stay warm, dry and focused.', 16.00, 0, 'products/accessories/nike_womens_gloves_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(45, 4, 'Nike Gym Essential Gloves', 'Low-density foam in targeted areas and lightweight material for enhanced flexibility.', 17.99, 0, 'products/accessories/nike_gym_gloves_front.png', '2026-03-14 18:46:08', '2026-03-14 18:46:08'),
(46, 5, 'Nike Air Max IVO Trainers', 'Inspired by early 90s running shoes from the Beaverton brand.', 75.00, 0, 'products/trainers/nike_airmax_front.png', '2026-03-14 18:46:08', '2026-03-14 18:51:16'),
(47, 5, 'Adidas DURAMO 10 Sn99', 'Very good shoe that adidas made.', 25.00, 0, 'products/trainers/adidas_duramo_front.png', '2026-03-14 18:46:08', '2026-03-14 18:51:16'),
(48, 5, 'Adidas Terrex Anylander Hiking Shoes Mens', 'From short forest walks to extended day hikes, these adidas Terrex hiking shoes offer support and comfort.', 47.00, 0, 'products/trainers/adidas_terrex_front.png', '2026-03-14 18:46:08', '2026-03-14 18:51:16'),
(49, 5, 'Nike Court Vision Low Next Nature Trainers', 'Get ready to level up your style game with the Nike Court Vision Low Next Nature Trainers.', 60.00, 0, 'products/trainers/nike_court_front.png', '2026-03-14 18:46:08', '2026-03-14 18:51:16'),
(50, 5, 'Adidas Grand Court Base Womens Trainers', 'Sneakers with staying power. The adidas Grand Court shoes have been around since the 70s.', 32.00, 0, 'products/trainers/adidas_womens_front.png', '2026-03-14 18:46:08', '2026-03-14 18:51:16');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text DEFAULT NULL,
  `review_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password_hash`, `phone`, `role`) VALUES
(1, 'Jaspinder', 'Shergill', 'jaspinder-shergill@hotmail.com', '$2y$10$JGSo15YiNPsGeWYM7BXxDOaD.ex.qRmk0oVnSglgwFkuXcA9bQhvq', '07368209033', 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `added_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

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
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
