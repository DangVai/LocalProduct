-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2024 at 06:29 PM
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
(3, 23, 10, 1, NULL, NULL, 'Def'),
(4, 23, 10, 1, NULL, NULL, 'Def');

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
(147, 39, 'public/images/Product_image/Xé3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `size` varchar(10) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `specific_address` varchar(255) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `size`, `quantity`, `product_name`, `product_id`, `product_price`, `full_name`, `phone`, `location`, `specific_address`, `payment_method`, `user_id`, `name`, `total_price`) VALUES
(3, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0323232323', 'sds', 'dangvai', '0', NULL, NULL, 105.00),
(4, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(5, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(6, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(7, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(8, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(9, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(10, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(11, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(12, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(13, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(14, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(15, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(16, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(17, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(18, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(19, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(20, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(21, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(22, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00),
(23, NULL, 1, 'Khau đôi', 14, 100.00, 'Xôm Đăng Vai', '0632323232', 'vai.xom26@student.passerellesnumeriques.org', 'dangvaidvai.xom26@student.passerellesnumeriques.org', '0', NULL, NULL, 105.00);

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
(10, 'Trống đồng Đông Dương', 'Đồ gia dụng', 10, 'Vân Kiều', 100000.00, '2024-12-17 14:32:50', 'Đẹp noa'),
(11, 'Khăn ưefefe', 'Đồ gia dụng', 1343, 'Pa Cô', 10230033.00, '2024-12-17 14:35:55', 'Không đẹpdfdgdfdfdf ơn dewewew'),
(14, 'Khau đôi', 'Đồ gia dụng', 20, 'Vân Kiều', 100.00, '2024-12-18 08:03:58', 'Khau đôi dùng để đựng xôi'),
(15, 'A chói', 'Đồ gia dụng', 12, 'Pa Cô', 100000.00, '2024-12-18 10:42:14', 'A chói dùng để gùi củi'),
(16, 'A Đư', 'Đồ gia dụng', 10, 'Vân Kiều', 100000.00, '2024-12-18 10:44:02', 'A Đư để đựng cá khi mình đi xúc cá vào mùa lũ'),
(17, 'Đôi hun', 'Đồ gia dụng', 12, 'Vân Kiều', 10000.00, '2024-12-19 08:07:26', 'Đôi hun là một món ăn truyền thống của người Vân Kiều'),
(18, 'Cây rửa', 'Đồ gia dụng', 10, 'Vân Kiều', 20000.00, '2024-12-19 08:15:56', 'Cây rửa người dân thường dùng để chặt củi và làm rẫy'),
(25, 'A Gio', 'Shirt', 10, 'Vân Kiều', 100.00, '2024-12-20 14:40:41', 'The Vân Kiều traditional shirt is a beautiful blend of cultural heritage and craftsmanship. Featuring vibrant colors and intricate designs, it reflects the Vân Kiều people\'s deep connection to nature and history. Made from high-quality materials, it offers both comfort and elegance. Perfect for cultural events or as a unique addition to your wardrobe. Embrace tradition and order yours today!\r\n\r\n\r\n\r\n'),
(26, 'Xấn', 'Dress', 20, 'Vân Kiều', 100.00, '2024-12-20 14:43:37', 'The Vân Kiều traditional dress features vibrant colors and intricate patterns, reflecting the rich culture of the Vân Kiều people. Made from comfortable, breathable fabric, it offers elegance and style. Perfect for cultural events or as a unique wardrobe piece. Order yours today and celebrate tradition with pride!'),
(27, 'Cơm Lam', 'Food', 100, 'Vân Kiều', 20.00, '2024-12-20 14:45:07', 'Cơm Lam is a traditional dish of the Vân Kiều people, made from glutinous rice cooked in bamboo tubes. The rice is infused with a smoky flavor from being roasted over an open fire, giving it a unique taste and aroma. Served with grilled meats or vegetables, Cơm Lam is a beloved dish that represents the Vân Kiều people\'s deep connection to nature and their culinary traditions. A must-try for anyone looking to experience authentic ethnic cuisine!'),
(28, 'Beng', 'Food', 50, 'Vân Kiều', 15.00, '2024-12-20 14:46:20', 'Beng is a traditional dish of the Vân Kiều people, made from sticky rice, coconut milk, and sugar, wrapped in banana leaves. It is steamed to perfection, resulting in a sweet, fragrant, and soft treat that highlights the Vân Kiều\'s rich culinary heritage. Beng is often enjoyed during festivals or special occasions, offering a taste of the community\'s deep connection to nature and tradition. A delightful dessert that’s both delicious and culturally significant!'),
(29, 'Khăn', 'Accessories', 100, 'Pa Cô', 40.00, '2024-12-20 14:47:53', 'The Pa Cô people’s traditional scarf, known as \"khăn,\" is a beautifully crafted accessory that holds cultural significance. Made from cotton or silk, the scarf is often handwoven with intricate patterns and vibrant colors, reflecting the Pa Cô\'s rich heritage and craftsmanship. Worn by both men and women, the khăn is not just a functional piece, but also a symbol of identity and tradition. Its elegant design and fine craftsmanship make it a unique and cherished item in the Pa Cô community.'),
(30, 'Pa Điên Đôi', 'Household Items', 30, 'Vân Kiều', 30.00, '2024-12-20 14:50:08', 'Pa Điên Đôi is a traditional item used by the Vân Kiều people to drain sticky rice, allowing it to become perfectly dry. Made from bamboo, this tool is designed with a wide, shallow bowl-like shape to hold freshly steamed sticky rice. The bamboo slats allow steam to escape, ensuring the rice stays fluffy and dry. Pa Điên Đôi is not only a practical kitchen tool but also a reflection of the Vân Kiều people\'s ingenuity and deep connection to their natural environment.'),
(31, 'Túi O', 'Accessories', 50, 'Vân Kiều', 10.00, '2024-12-20 14:51:40', 'Túi O is a traditional bag of the Vân Kiều people, made from natural materials such as rattan or woven fibers. It is often used by both men and women to carry personal belongings or daily essentials. The bag features a simple yet functional design, with intricate weaving patterns that showcase the craftsmanship of the Vân Kiều community. Lightweight and durable, Túi O is a symbol of practicality and cultural heritage, often worn during festivals or while engaging in daily activities.'),
(32, 'Tiêu a hâyrrr', 'Food', 10, 'Pa Cô', 10.00, '2024-12-20 14:57:36', 'Tiêu a hâyrrr is a type of extremely spicy chili pepper grown by the Vân Kiều people. Known for its intense heat and unique flavor, this chili is often used in traditional Vân Kiều dishes to add a fiery kick. The peppers are small but pack a punch, making them a vital ingredient in many local recipes. Tiêu a hâyrrr is not only a key part of the Vân Kiều cuisine but also a symbol of the bold and vibrant flavors that define the community\'s culinary culture.'),
(33, 'Pa No', 'Musical Instruments', 5, 'Vân Kiều', 40.00, '2024-12-20 15:01:46', 'Pa No is a traditional musical instrument of the Vân Kiều people, often used in their cultural ceremonies and festivities. This instrument is made from bamboo and features a unique design that produces a distinct, melodic sound when played. Pa No is typically played by blowing air through small holes, and it plays a significant role in the Vân Kiều’s folk music, helping to convey emotions and stories through its gentle yet captivating tones. It is a symbol of the community\'s deep connection to music, nature, and their cultural heritage.'),
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
(33, 16, 'S'),
(34, 16, 'M'),
(37, 14, 'M'),
(39, 14, 'XL'),
(42, 11, 'XL'),
(56, 11, 'S'),
(57, 11, 'M'),
(58, 15, 'M'),
(59, 15, 'L'),
(60, 15, 'XL'),
(61, 10, 'M'),
(62, 10, 'L'),
(63, 17, 'S'),
(64, 17, 'M'),
(65, 17, 'L'),
(66, 17, 'XL'),
(67, 18, 'S'),
(68, 18, 'M'),
(69, 18, 'XL');

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_product_id` (`product_id`);

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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

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
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
