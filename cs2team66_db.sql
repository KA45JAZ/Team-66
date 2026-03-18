-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2026 at 10:23 AM
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
(2, 1, '2026-03-14 20:49:50', 12.00, 'pending', 'Jaspinder Shergill', '3 Lavender Close', '', 'Walsall', 'WS5 4ST', '07368209033'),
(3, 1, '2026-03-17 14:45:58', 17.00, 'pending', 'Jaspinder Shergill', '3 Lavender Close', '', 'Walsall', 'WS5 4ST', '07368209033');

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
(2, 2, 26, 1, 12.00),
(3, 3, 27, 1, 17.00);

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
(1, 1, 'Men’s Performance Hoodie', 'Breathable, warm hoodie ideal for training. Providing that unmistakable outdoors inspired technical design with modern cuts founded for the streets. The full zip fastening front and adjustable branded cuffs provide ample coverage from the elements as does the toggle adjustable hood. Side hand pockets combine with secure zip fastening chest pocket to keep your small essentials safe while you’re active.', 29.99, 3, 'https://www.footasylum.com/images/products/large/4105935.jpg', '2025-12-05 11:43:06', '2026-03-06 17:24:29'),
(2, 1, 'Men’s Training Joggers', 'Open Hem Joggers in Black. Discover comfort and style with this ultimate blend of relaxed fit and modern versatility. Crafted for the guy who values comfort without sacrificing style, these joggers deliver a standard fit that\'s generously relaxed through the seat and thighs.', 24.99, 15, 'https://www.footasylum.com/images/products/large/4122229.jpg', '2025-12-05 11:43:06', '2026-03-06 17:13:23'),
(3, 1, 'Men’s Compression Shirt', 'Designed for ultra-tight, physique‑enhancing performance with a compression fit that feels like a second skin, using stretchy ribbed fabric', 19.99, 25, 'https://cdn.shopify.com/s/files/1/0156/6146/files/images-GSxCarlosLSTeeGSLightGreyGSOnyxGreyA4B7I_GCH2_0486_V3_1920x.jpg?v=1770642276', '2025-12-05 11:43:06', '2026-03-06 17:21:47'),
(4, 1, 'Men’s Running Shorts', 'Running Shorts in Escape Green. Experience ultimate comfort and performance with the Running Shorts. Lightweight, breathable, and designed for active living. Meticulously engineered for optimal performance and unparalleled comfort.', 14.99, 30, 'https://www.footasylum.com/images/products/large/4127173.jpg', '2025-12-05 11:43:06', '2026-03-06 17:23:48'),
(5, 1, 'Men’s Sleeveless Gym Top', 'Tank Top in Black. A running tank top designed for comfort and performance during your runs. Made from ultra-lightweight Dri-FIT fabric that wicks away sweat to keep you dry and cool. ', 12.99, 40, 'https://www.gymshark.com/_next/image?url=https%3A%2F%2Fimages.ctfassets.net%2Fwl6q2in9o7k3%2Fw9mrUGjnaBf8TBZL3aVrC%2Fb8f654d2ae9cd134e21d262111354a54%2FSoftSculpt-Ecom-PLP_Link_Card_-_24437663.jpeg&w=1920&q=75', '2025-12-05 11:43:06', '2026-03-06 17:29:17'),
(6, 2, 'Women’s Yoga Leggings', 'Yoga Pants in Black. Elevate your activewear with the Women\'s Yoga Pant, premium, high-performance leggings designed for yoga, gym sessions, running, or everyday comfort. ', 22.99, 30, 'https://www.footasylum.com/images/products/large/4127526_1.jpg', '2025-12-05 11:43:22', '2026-03-06 17:38:32'),
(7, 2, 'Women’s Sports Bra', 'Womens Sports Bra in Midnight and Spring Veil. This supportive medium-impact bra features a sleek halter-style design with ruched detailing at the front for added shape and comfort. Crafted from premium, breathable, stretch fabric that moves with you, it offers adjustable straps, secure underband, and subtle branding for a confident fit during yoga, running, or HIIT', 18.99, 25, 'https://www.footasylum.com/images/products/large/4126933.jpg', '2025-12-05 11:43:22', '2026-03-06 17:43:00'),
(8, 2, 'Women’s Running Jacket', 'Womens Align Running Jacket in Midship Midnight and Spring Veil. This lightweight, packable running jacket features a full zip, stand collar, mesh vents for breathability, and reflective accents for visibility. The water-resistant, windproof shell with stretch panels provides freedom of movement, perfect for outdoor runs, training, or casual layering.', 34.99, 10, 'https://www.footasylum.com/images/products/large/4126924_3.jpg', '2025-12-05 11:43:22', '2026-03-07 21:35:28'),
(9, 2, 'Women’s Training Tee', 'Soft, fitted training t‑shirt with comfy, easy wear styles, this collection is as versatile as your workouts. ', 14.99, 35, 'https://cdn.shopify.com/s/files/1/0156/6146/files/TrainingBabyTeeGSBlackB3B9F-BB2J6462_94961c82-4728-4fc3-9447-87c0d267cf01_1920x.jpg?v=1740429547', '2025-12-05 11:43:22', '2026-03-07 21:36:46'),
(10, 2, 'Women’s Gym Shorts', 'Whether you’re just ticking off your daily miles or training for a marathon, our running collection keeps you going with breathable, sweat-wicking fabrics, soft brushed linings and reflective details to keep you safe.', 16.99, 20, 'https://cdn.shopify.com/s/files/1/0156/6146/files/images-RunningBetter2_in_1ShortGSIronBlueB3C4D_UCTM_0310_V1_640x.jpg?v=1770715718', '2025-12-05 11:43:22', '2026-03-07 21:38:28'),
(11, 3, 'Kids Training Hoodie', 'Woven Running Jacket in Black. It is built to do it all. Providing that unmistakable outdoors inspired technical design with modern cuts founded on the streets. The full zip fastening front and adjustable branded cuffs provide ample coverage from the elements as does the fixed hood', 17.99, 20, 'https://www.footasylum.com/images/products/productlistings/4105914.jpg', '2025-12-05 11:43:46', '2026-03-07 21:40:54'),
(12, 3, 'Kids Sports Shorts', 'Shorts in Midnight Echo and Steam Green. Finding space in your activewear collection has never been easier as these minimally designed but maximum comfort shorts. With an elasticated adjustable drawstring waistband, open side pockets for your hands and/or small essentials such as phone and keys, contrast panels', 9.99, 30, 'https://www.footasylum.com/images/products/large/4126956_1.jpg', '2025-12-05 11:43:46', '2026-03-07 21:42:10'),
(13, 3, 'Kids Running Shoes', 'Lightweight trainers for kids. Its trail-specific sole and high abrasion rubber are designed to walk on rugged terrain while the Rearfoot GEL cushioning ensures unbeatable comfort. ', 24.99, 15, 'https://www.footasylum.com/images/products/large/4097136_1.jpg', '2025-12-05 11:43:46', '2026-03-07 22:05:39'),
(14, 3, 'Kids Cotton Tee', 'T-Shirt in Space Blue and Navy Blue. Designed to keep pace with your adrenaline-fuelled active lifestyle, this sporty short-sleeved tee from Trailberg is crafted from lightweight woven 4-way stretch fabric and is equipped with laser-cut perforations to the back to allow for increased airflow. ', 7.99, 40, 'https://www.footasylum.com/images/products/large/4123371.jpg', '2025-12-05 11:43:46', '2026-03-07 21:48:29'),
(15, 3, 'Kids Joggers', 'Comfortable joggers in Black for school or play. Comfort is supplied via an elasticated waistband and ribbed cuffs, ensuring a snug personalised feel is easily attained. ', 12.99, 25, 'https://www.footasylum.com/images/products/large/4092106.jpg', '2025-12-05 11:43:46', '2026-03-07 21:49:54'),
(16, 4, 'Sports Water Bottle', 'With a 0.89L (30 oz) capacity, you can now stay hydrated in style thanks to this outstanding bottle. Featuring a wide opening for ice and easy cleaning, leak proof straw lid, convenient car cup compatible for those long demanding journeys, easy carry stainless steel handle and double wall stainless steel vacuum insulated.', 8.99, 50, 'https://www.footasylum.com/images/products/large/4121624.jpg', '2025-12-05 11:43:58', '2026-03-07 21:50:59'),
(17, 4, 'Gym Gloves', 'Grip‑enhancing gloves for weightlifting.', 12.99, 20, 'https://cdn.shopify.com/s/files/1/0156/6146/files/images-LegacyLiftingGlovesV2GSBlackI1B7Q_BB2J_0007_V1_640x.jpg?v=1772051427', '2025-12-05 11:43:58', '2026-03-07 21:52:48'),
(18, 4, 'Training Backpack', 'Backpack in Jet Black. Spacious and stylish portable storage for the \r\ngym-goer, worker, hiker, commuter or traveller. Large main double zip top fastening compartment with separate additional secure zip fastening compartments to side and front', 29.99, 10, 'https://cdn.shopify.com/s/files/1/0156/6146/files/CoatedPursuitBackpackGSBlackI3A6Y-BB2J0066_1920x.jpg?v=1724429998', '2025-12-05 11:43:58', '2026-03-07 21:54:58'),
(19, 4, 'Sweatband Set', 'Headband and wristbands for workouts that absorbs sweat and allows breathability whilst also providing a tight fit.', 6.99, 40, 'https://cdn.shopify.com/s/files/1/0156/6146/files/images-AdaptSeamlessHeadbandENGAA0005GSBlackGSAsphaltGreyI2C4R_BDRY_0263_V2_640x.jpg?v=1772051563', '2025-12-05 11:43:58', '2026-03-07 21:57:34'),
(20, 4, 'Shaker Bottle', 'Shaker Bottle 20 Oz in Black 2.0. Shaken not stirred! Infuse your water or add in protein powder then simply shake and drink. The 20 oz Active Shaker bottle keeps your drink cold for hours thanks to its innovative double-wall vacuum insulation, whilst the rounded interior makes mixing and cleaning a doddle.', 7.99, 35, 'https://cdn.shopify.com/s/files/1/0156/6146/files/images-BetterShakerBottleGSBlackI1B6N_BB2J_0080_V2_640x.jpg?v=1763562941', '2025-12-05 11:43:58', '2026-03-07 21:58:58'),
(21, 5, 'Running Trainers', 'Running Trainers in Black and Blue. With a regular width and secure lace fastening closure, this slick footwear from Puma is inspired by performance and designed to slot in perfectly with your busy lifestyle. With a rounded toe, NITRO™ heel booster for optimal comfort, this exquisite shoe effortlessly fuses dynamism with functionality.', 49.99, 15, 'https://www.footasylum.com/images/products/large/4125761_1.jpg', '2025-12-05 11:44:12', '2026-03-07 22:06:14'),
(22, 5, 'Gym Training Shoes', 'Stable shoes designed for lifting and HIIT. A flexible, versatile training shoe built for feel-good workouts.  ', 44.99, 12, 'https://www.footasylum.com/images/products/productlistings/4124942.jpg', '2025-12-05 11:44:12', '2026-03-07 22:03:28'),
(23, 5, 'Trail Running Shoes', 'Explore the outdoors with this shoe designed for both trail and road running. This shoe features an ultra-responsive foam midsole for superior cushioning. The upper combines mesh with tighter woven fabric in high-wear areas like the toes, offering breathability and durability.', 59.99, 10, 'https://www.footasylum.com/images/products/large/4124980_1.jpg', '2025-12-05 11:44:12', '2026-03-07 22:07:32'),
(24, 5, 'Everyday Comfort Trainers', 'Soft‑sole trainers for daily wear. Key features include a midsole for impact absorption, dual-density cushioning.', 39.99, 20, 'https://www.footasylum.com/images/products/large/4133970_1.jpg', '2025-12-05 11:44:12', '2026-03-07 22:09:44'),
(25, 5, 'Kids Sport Trainers', 'Durable trainers for active kids designed for a faster, lighter feel without sacrificing protection. The sport-inspired nylon ripstop and TPU upper offers a durable yet breathable shell that stands up to the demands of the trail. For complete confidence underfoot, this shoe integrates a full-length rock plate for protection,', 29.99, 18, 'https://www.footasylum.com/images/products/large/4124776_1.jpg', '2025-12-05 11:44:12', '2026-03-07 22:11:14'),
(26, 1, 'Adidas Men\'s Tiro24 Short Sleeve Performance T-Shirt', 'The adidas Tiro24 Short Sleeve Performance T-Shirt is built for football training with a streamlined cut. Designed to support active sessions, it offers a clean, athletic fit.', 12.00, 0, 'products/mens/adidas_blue_t_front.png', '2026-03-14 18:46:08', '2026-03-14 20:49:50'),
(27, 1, 'Nike Icon Futura T-Shirt Mens', 'Keep it simple. The Nike Icon Futura T-Shirt keeps things classic with a solid colour-way that makes the contrasting Nike wordmark and Swoosh pop. Cut to a regular fit, it’s the easy tee you’ll reach for again and again.', 17.00, 0, 'products/mens/nike_black_t_front.png', '2026-03-14 18:46:08', '2026-03-17 14:45:58'),
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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
