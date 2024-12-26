-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2024 at 01:56 PM
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
-- Database: `localproducts`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_otp`
--

CREATE TABLE `admin_otp` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `cart_view_at` datetime DEFAULT NULL,
  `size` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `total_price`, `cart_view_at`, `size`) VALUES
(11, 23, 26, 4, NULL, NULL, 'L'),
(12, 23, 25, 1, NULL, NULL, 'L'),
(13, 23, 26, 4, NULL, NULL, 'XL'),
(14, 23, 26, 4, NULL, NULL, 'M');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `checkout_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `total_cost` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `checkout_view_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `favorite_view_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`image_id`, `product_id`, `img`) VALUES
(111, 25, 'public/images/Product_image/aoVK2.jpg'),
(112, 25, 'public/images/Product_image/aoVK3.jpg'),
(113, 25, 'public/images/Product_image/aoVk4.jpg'),
(114, 25, 'public/images/Product_image/aoVk7.jpg'),
(115, 26, 'public/images/Product_image/vay1.jpg'),
(116, 26, 'public/images/Product_image/vay2.jpg'),
(117, 26, 'public/images/Product_image/vayVK4.jpg'),
(118, 27, 'public/images/Product_image/comlam.jpg'),
(119, 27, 'public/images/Product_image/comlam2.jpg'),
(120, 28, 'public/images/Product_image/Beng.jpg'),
(121, 28, 'public/images/Product_image/Beng2.jpg'),
(122, 29, 'public/images/Product_image/khan1.jpg'),
(123, 29, 'public/images/Product_image/khan2.jpg'),
(124, 29, 'public/images/Product_image/khan3.jpg'),
(125, 30, 'public/images/Product_image/tavin1.jpg'),
(126, 30, 'public/images/Product_image/tavin2.jpg'),
(127, 31, 'public/images/Product_image/tui1.jpg'),
(128, 31, 'public/images/Product_image/tui2.jpg'),
(129, 31, 'public/images/Product_image/tui3.jpg'),
(130, 32, 'public/images/Product_image/Tiêu1.jpg'),
(131, 32, 'public/images/Product_image/Tiêu2.jpg'),
(134, 33, 'public/images/Product_image/676578eaaae7c_pano2.jpg'),
(136, 34, 'public/images/Product_image/67657a6dc6182_dan2.jpg'),
(137, 35, 'public/images/Product_image/A Băng1.jpg'),
(138, 35, 'public/images/Product_image/A Băng2.jpg'),
(139, 35, 'public/images/Product_image/A Băng3.jpg'),
(140, 36, 'public/images/Product_image/boVK2.jpg'),
(141, 37, 'public/images/Product_image/ÁoVK.webp'),
(142, 37, 'public/images/Product_image/aoVK2.jpg'),
(143, 37, 'public/images/Product_image/aoVK3.jpg'),
(144, 38, 'public/images/Product_image/Anua1.jpg'),
(145, 39, 'public/images/Product_image/Xé1.jpg'),
(146, 39, 'public/images/Product_image/Xé2.jpg'),
(147, 39, 'public/images/Product_image/Xé3.jpg'),
(150, 10, 'public/images/Product_image/6765b69d75218_pano1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orderss`
--

CREATE TABLE `orderss` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `specific_address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderss`
--

INSERT INTO `orderss` (`order_id`, `user_id`, `full_name`, `phone`, `location`, `specific_address`, `created_at`) VALUES
(21, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-25 10:12:28'),
(22, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-25 10:13:48'),
(23, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-25 10:15:02'),
(24, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-25 10:15:28'),
(25, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-25 10:16:53'),
(28, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-25 10:20:39'),
(36, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-26 01:39:11'),
(37, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-26 10:07:45'),
(38, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-26 10:24:09'),
(39, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-26 10:24:58'),
(40, 23, 'vai', '0323232323', 'fdfdfdshowProductshowProductshowProductshowProductshowProduct', 'dfdfdfshowProductshowProductshowProductshowProductshowProductshowProduct', '2024-12-26 10:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `product_name`, `size`, `price`, `quantity`) VALUES
(39, 24, 26, 'Xấn', 'XL', 100.00, 6),
(40, 24, 26, 'Xấn', 'S', 100.00, 3),
(41, 25, 25, 'A Gio', 'L', 100.00, 3),
(42, 25, 26, 'Xấn', 'XL', 100.00, 6),
(52, 28, 26, 'Xấn', 'S', 300.00, 3),
(67, 36, 25, 'A Gio', 'L', 700.00, 7),
(68, 36, 26, 'Xấn', 'XL', 600.00, 6),
(69, 37, 26, 'Xấn', 'L', 400.00, 4),
(70, 37, 25, 'A Gio', 'L', 500.00, 5),
(71, 38, 26, 'Xấn', 'L', 400.00, 4),
(72, 38, 25, 'A Gio', 'L', 300.00, 3),
(73, 39, 26, 'Xấn', 'L', 100.00, 1),
(74, 39, 25, 'A Gio', 'L', 100.00, 1),
(75, 40, 26, 'Xấn', 'L', 400.00, 4),
(76, 40, 25, 'A Gio', 'L', 100.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `preview`
--

CREATE TABLE `preview` (
  `preview_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `preview_view_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `product_view_at` datetime DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `category`, `quantity`, `type`, `price`, `product_view_at`, `description`) VALUES
(10, 'Pa No O', 'Musical Instruments', 10, 'Vân Kiều', 100.00, '2024-12-17 14:32:50', 'Pa No O is a traditional musical instrument of the Vân Kiều people, often used in their cultural ceremonies and festivities. This instrument is made from bamboo and features a unique design that produces a distinct, melodic sound when played. Pa No is typically played by blowing air through small holes, and it plays a significant role in the Vân Kiều’s folk music, helping to convey emotions and stories through its gentle yet captivating tones. It is a symbol of the community\'s deep connection to music, nature, and their cultural heritage.'),
(25, 'A Gio', 'Shirt', 190, 'Vân Kiều', 100.00, '2024-12-20 14:40:41', 'The Vân Kiều traditional shirt is a beautiful blend of cultural heritage and craftsmanship. Featuring vibrant colors and intricate designs, it reflects the Vân Kiều people\'s deep connection to nature and history. Made from high-quality materials, it offers both comfort and elegance. Perfect for cultural events or as a unique addition to your wardrobe. Embrace tradition and order yours today!\r\n\r\n\r\n\r\n'),
(26, 'Xấn', 'Dress', 287, 'Vân Kiều', 100.00, '2024-12-20 14:43:37', 'The Vân Kiều traditional dress features vibrant colors and intricate patterns, reflecting the rich culture of the Vân Kiều people. Made from comfortable, breathable fabric, it offers elegance and style. Perfect for cultural events or as a unique wardrobe piece. Order yours today and celebrate tradition with pride!'),
(27, 'Cơm Lam', 'Food', 100, 'Vân Kiều', 20.00, '2024-12-20 14:45:07', 'Cơm Lam is a traditional dish of the Vân Kiều people, made from glutinous rice cooked in bamboo tubes. The rice is infused with a smoky flavor from being roasted over an open fire, giving it a unique taste and aroma. Served with grilled meats or vegetables, Cơm Lam is a beloved dish that represents the Vân Kiều people\'s deep connection to nature and their culinary traditions. A must-try for anyone looking to experience authentic ethnic cuisine!'),
(28, 'Beng', 'Food', 50, 'Vân Kiều', 15.00, '2024-12-20 14:46:20', 'Beng is a traditional dish of the Vân Kiều people, made from sticky rice, coconut milk, and sugar, wrapped in banana leaves. It is steamed to perfection, resulting in a sweet, fragrant, and soft treat that highlights the Vân Kiều\'s rich culinary heritage. Beng is often enjoyed during festivals or special occasions, offering a taste of the community\'s deep connection to nature and tradition. A delightful dessert that’s both delicious and culturally significant!'),
(29, 'Khăn', 'Accessories', 100, 'Pa Cô', 40.00, '2024-12-20 14:47:53', 'The Pa Cô people’s traditional scarf, known as \"khăn,\" is a beautifully crafted accessory that holds cultural significance. Made from cotton or silk, the scarf is often handwoven with intricate patterns and vibrant colors, reflecting the Pa Cô\'s rich heritage and craftsmanship. Worn by both men and women, the khăn is not just a functional piece, but also a symbol of identity and tradition. Its elegant design and fine craftsmanship make it a unique and cherished item in the Pa Cô community.'),
(30, 'Pa Điên Đôi', 'Household Items', 30, 'Vân Kiều', 30.00, '2024-12-20 14:50:08', 'Pa Điên Đôi is a traditional item used by the Vân Kiều people to drain sticky rice, allowing it to become perfectly dry. Made from bamboo, this tool is designed with a wide, shallow bowl-like shape to hold freshly steamed sticky rice. The bamboo slats allow steam to escape, ensuring the rice stays fluffy and dry. Pa Điên Đôi is not only a practical kitchen tool but also a reflection of the Vân Kiều people\'s ingenuity and deep connection to their natural environment.'),
(31, 'Túi O', 'Accessories', 50, 'Vân Kiều', 10.00, '2024-12-20 14:51:40', 'Túi O is a traditional bag of the Vân Kiều people, made from natural materials such as rattan or woven fibers. It is often used by both men and women to carry personal belongings or daily essentials. The bag features a simple yet functional design, with intricate weaving patterns that showcase the craftsmanship of the Vân Kiều community. Lightweight and durable, Túi O is a symbol of practicality and cultural heritage, often worn during festivals or while engaging in daily activities.'),
(32, 'Tiêu a hâyrrr', 'Food', 10, 'Pa Cô', 10.00, '2024-12-20 14:57:36', 'Tiêu a hâyrrr is a type of extremely spicy chili pepper grown by the Vân Kiều people. Known for its intense heat and unique flavor, this chili is often used in traditional Vân Kiều dishes to add a fiery kick. The peppers are small but pack a punch, making them a vital ingredient in many local recipes. Tiêu a hâyrrr is not only a key part of the Vân Kiều cuisine but also a symbol of the bold and vibrant flavors that define the community\'s culinary culture.'),
(33, 'Pa No', 'Musical Instruments', 100, 'Vân Kiều', 40.00, '2024-12-20 15:01:46', 'Pa No is a traditional musical instrument of the Vân Kiều people, often used in their cultural ceremonies and festivities. This instrument is made from bamboo and features a unique design that produces a distinct, melodic sound when played. Pa No is typically played by blowing air through small holes, and it plays a significant role in the Vân Kiều’s folk music, helping to convey emotions and stories through its gentle yet captivating tones. It is a symbol of the community\'s deep connection to music, nature, and their cultural heritage.'),
(34, 'Đàn Ta Lư', 'Musical Instruments', 12, 'Vân Kiều', 45.00, '2024-12-20 15:08:32', 'Đàn Ta Lư is a traditional stringed musical instrument of the Vân Kiều people, often used in their cultural ceremonies and celebrations. The instrument typically has several strings, and it is played by plucking or strumming, producing a rich and melodic sound. Đàn Ta Lư is highly valued in Vân Kiều culture for its ability to express emotions, stories, and traditions through music. The craftsmanship involved in making the instrument reflects the community\'s deep connection to their heritage and artistic expression. It is a significant symbol of the Vân Kiều people\'s cultural identity.'),
(35, ' A Băng', 'Food', 16, 'Vân Kiều', 9.00, '2024-12-20 15:13:57', 'A Băng is a type of bamboo shoot commonly used by the Vân Kiều people in their traditional cuisine. The bamboo shoots are harvested from young bamboo plants and are prized for their tender texture and subtle, earthy flavor. A Băng is often used in soups, stews, or stir-fries, adding a unique taste to the dish. It reflects the Vân Kiều people\'s close relationship with nature, as they skillfully use local resources to create delicious and nutritious meals. A Băng is a true example of the community\'s sustainable food practices.\r\n'),
(36, 'A Gio Cặp', 'Dress', 12, 'Vân Kiều', 60.00, '2024-12-20 15:34:37', 'The Vân Kiều traditional shirt is a beautiful blend of cultural heritage and craftsmanship. Featuring vibrant colors and intricate designs, it reflects the Vân Kiều people\'s deep connection to nature and history. Made from high-quality materials, it offers both comfort and elegance. Perfect for cultural events or as a unique addition to your wardrobe. Embrace tradition and order yours today!\r\n'),
(37, 'Áo A Gio', 'Shirt', 50, 'Vân Kiều', 50.00, '2024-12-20 15:36:28', 'The Vân Kiều traditional shirt is a beautiful blend of cultural heritage and craftsmanship. Featuring vibrant colors and intricate designs, it reflects the Vân Kiều people\'s deep connection to nature and history. Made from high-quality materials, it offers both comfort and elegance. Perfect for cultural events or as a unique addition to your wardrobe. Embrace tradition and order yours today!\r\n\r\n'),
(38, 'A Núa', 'Household Items', 50, 'Vân Kiều', 30.00, '2024-12-20 15:39:50', 'A Núa is a traditional tool used by the Vân Kiều people for fishing. This tool is typically made from wood or bamboo and is designed to scoop or catch fish in rivers or streams. A Núa is an essential part of the Vân Kiều\'s fishing techniques, enabling them to efficiently gather fish for their meals. The craftsmanship and design of A Núa reflect the community\'s deep understanding of their natural environment and their resourceful ways of utilizing local materials for everyday needs.'),
(39, 'Xé ', 'Food', 100, 'Vân Kiều', 30.00, '2024-12-20 15:43:08', 'Xé is a type of fish that the Vân Kiều people often grill to create a delicious and flavorful dish. The fish is typically marinated with local herbs and spices before being roasted over an open flame. The result is a smoky, tender, and juicy fish that is enjoyed with rice or vegetables. Xé is a popular dish in Vân Kiều cuisine, showcasing their expertise in cooking with fresh, natural ingredients from their environment. It’s a true taste of their rich cultural heritage and deep connection to nature.');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `size_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`size_id`, `product_id`, `size`) VALUES
(70, 10, 'S'),
(71, 10, 'M'),
(72, 10, 'L'),
(73, 25, 'S'),
(74, 25, 'M'),
(75, 25, 'L'),
(76, 25, 'XL'),
(77, 26, 'S'),
(78, 26, 'M'),
(79, 26, 'L'),
(80, 26, 'XL'),
(81, 39, 'S'),
(82, 39, 'M'),
(83, 10, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `saveotp`
--

CREATE TABLE `saveotp` (
  `user_id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `user_view_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `OTP_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saveotp`
--

INSERT INTO `saveotp` (`user_id`, `Name`, `email`, `phone`, `avatar`, `user_view_at`, `password`, `OTP_code`) VALUES
(25, 'An', 'hothion010100@gmail.com', '0346243031', NULL, NULL, '96e79218965eb72c92a549dd5a330112', '595401'),
(28, 'vai', 'xomdangvaisf@gmail.com', '0323232323', NULL, NULL, '96e79218965eb72c92a549dd5a330112', '996189');

-- --------------------------------------------------------

--
-- Table structure for table `track_order`
--

CREATE TABLE `track_order` (
  `track_order_id` int(11) NOT NULL,
  `checkout_id` int(11) DEFAULT NULL,
  `track_order` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `avata` text DEFAULT NULL,
  `user_view_at` datetime DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `Name`, `email`, `phone`, `avata`, `user_view_at`, `password`, `reset_token`, `reset_token_expiry`) VALUES
(20, 'An', 'hothion010100@gmail.com', '0346243031', NULL, NULL, '96e79218965eb72c92a549dd5a330112', '823790', '0000-00-00 00:00:00'),
(23, 'vai', 'xomdangvaisf@gmail.com', '0323232323', NULL, NULL, '96e79218965eb72c92a549dd5a330112', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_otp`
--
ALTER TABLE `admin_otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`checkout_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orderss`
--
ALTER TABLE `orderss`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `preview`
--
ALTER TABLE `preview`
  ADD PRIMARY KEY (`preview_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`size_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `saveotp`
--
ALTER TABLE `saveotp`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `track_order`
--
ALTER TABLE `track_order`
  ADD PRIMARY KEY (`track_order_id`),
  ADD KEY `checkout_id` (`checkout_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_otp`
--
ALTER TABLE `admin_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `checkout_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `orderss`
--
ALTER TABLE `orderss`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `preview`
--
ALTER TABLE `preview`
  MODIFY `preview_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `saveotp`
--
ALTER TABLE `saveotp`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `track_order`
--
ALTER TABLE `track_order`
  MODIFY `track_order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `checkout_ibfk_3` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`);

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orderss` (`order_id`);

--
-- Constraints for table `preview`
--
ALTER TABLE `preview`
  ADD CONSTRAINT `preview_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `preview_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `track_order`
--
ALTER TABLE `track_order`
  ADD CONSTRAINT `track_order_ibfk_1` FOREIGN KEY (`checkout_id`) REFERENCES `checkout` (`checkout_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
