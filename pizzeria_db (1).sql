-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2025 at 03:30 PM
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
-- Database: `pizzeria_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`) VALUES
(1, 'Pizza', 1),
(2, 'Burger', 1),
(3, 'Beverages', 1),
(4, 'Pasta', 1),
(5, 'Dessert', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `description`, `price`, `image`, `category_id`, `status`, `created_at`, `stock`) VALUES
(1, 'Pepperoni Pizza', 'Classic pepperoni with mozzarella cheese', 299.00, 'pizza.png', 1, 1, '2025-12-19 01:09:39', 12),
(2, 'Cheese Pizza', 'Rich tomato sauce and melted cheese', 249.00, 'cheese pizza.jpg', 1, 1, '2025-12-19 01:09:39', 0),
(3, 'Hawaiian Pizza', 'Ham, pineapple, and cheese', 279.00, 'hawaiian pizza.jpg', 1, 1, '2025-12-19 01:09:39', 0),
(4, 'Veggie Pizza', 'Loaded with fresh vegetables', 259.00, 'veggie pizza.jpg', 1, 1, '2025-12-19 01:09:39', 0),
(5, 'Chicken Burger', 'Crispy chicken with special sauce', 149.00, 'chickenburger.jpeg', 2, 1, '2025-12-19 01:09:39', 0),
(6, 'Beef Burger', 'Juicy beef patty with cheese', 169.00, 'beef burger.jpg', 2, 1, '2025-12-19 01:09:39', 0),
(7, 'Coke', 'Chilled soft drink', 49.00, 'Coke.jpg', 3, 1, '2025-12-19 01:09:39', 0),
(8, 'Iced Tea', 'Refreshing lemon iced tea', 59.00, 'Iced Tea.jpg', 3, 1, '2025-12-19 01:09:39', 0),
(9, 'Carbonara Pasta', 'Creamy white sauce pasta', 199.00, 'carbonara.jpeg', 4, 1, '2025-12-19 01:09:39', 0),
(10, 'Spaghetti', 'Classic Italian spaghetti', 189.00, 'classic pasta.jpg', 4, 1, '2025-12-19 01:09:39', 0),
(11, 'Chocolate Cake', 'Rich chocolate dessert', 129.00, 'chocolate cake.jpg', 5, 1, '2025-12-19 01:09:39', 0),
(28, 'Bacon Burger', 'Beef burger with crispy bacon and cheese.', 150.00, 'bacon burger.jpg', 2, 1, '2025-12-19 12:42:36', 0),
(30, 'Classic American Burger', 'Classic beef burger with cheese and veggies.', 170.00, 'classic american burger.jpg', 2, 1, '2025-12-19 12:42:36', 0),
(31, 'Alaking Burger', 'Creamy chicken burger with rich sauce.', 165.00, 'alaking.jpg', 2, 1, '2025-12-19 12:42:36', 0),
(33, 'Shrimp Burger', 'Crispy shrimp burger with fresh lettuce.', 170.00, 'shrimp burger.jpg', 2, 1, '2025-12-19 12:42:36', 0),
(34, 'Spaghetti Bolognese', 'Spaghetti with rich meat sauce.', 185.00, 'spaghetti-bolognese-36.jpg', 4, 1, '2025-12-19 12:42:36', 0),
(35, 'Creamy Cajun Pasta', 'Creamy pasta with Cajun-spiced chicken.', 190.00, 'creamy cajun pasta.jpg', 4, 1, '2025-12-19 12:42:36', 0),
(36, 'Chicken Alfredo', 'Creamy Alfredo pasta with chicken.', 195.00, 'Chicken Alfredo.jpg', 4, 1, '2025-12-19 12:42:36', 0),
(37, 'Creamy Pesto Chicken Skillet', 'Creamy pesto pasta with chicken.', 189.00, 'Creamy Pesto Chicken Skillet.jpg', 4, 1, '2025-12-19 12:42:36', 0),
(38, 'Classic Lemonade', 'Fresh sweet and sour lemonade.', 65.00, 'classic lemonade.jpg', 3, 1, '2025-12-19 12:42:36', 0),
(39, 'Bubble Gum', 'Sweet bubble gum flavored drink.', 45.00, 'bubble gum.jpg', 3, 1, '2025-12-19 12:42:36', 0),
(40, 'Peach Iced Tea', 'Iced tea with peach flavor.', 65.00, 'peach iced tea.jpg', 3, 1, '2025-12-19 12:42:36', 0),
(41, 'Matcha Latte', 'Creamy matcha green tea latte.', 75.00, 'Matcha Latte.jpg', 3, 1, '2025-12-19 12:42:36', 0),
(42, 'Tandoori Pizza', 'Pizza with spicy tandoori chicken.', 280.00, 'tandoori pizza.jpg', 1, 1, '2025-12-19 12:42:36', 0),
(43, 'Margherita Pizza', 'Classic pizza with tomato and cheese.', 295.00, 'margherita pizza.jpg', 1, 1, '2025-12-19 12:42:36', 0),
(44, 'Chocolate Lava Cake', 'Warm chocolate cake with molten center.', 180.00, 'lava cake.jpg', 5, 1, '2025-12-19 12:55:49', 0),
(45, 'Classic Cheesecake', 'Creamy cheesecake with graham crust.', 175.00, 'cheese cake.jpg', 5, 1, '2025-12-19 12:55:49', 0),
(46, 'Chocolate Brownie', 'Rich chocolate brownie served warm.', 160.00, 'brownie.jpg', 5, 1, '2025-12-19 12:55:49', 0),
(47, 'Vanilla Ice Cream', 'Smooth vanilla ice cream scoop.', 120.00, 'ice cream.jpg', 5, 1, '2025-12-19 12:55:49', 0),
(48, 'Caramel Flan', 'Silky caramel custard dessert.', 165.00, 'flan.jpg', 5, 1, '2025-12-19 12:55:49', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `customer_name`, `email`, `phone`, `address`, `total`, `created_at`, `status`) VALUES
(1, 0, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'Daraga', 206.00, '2025-12-19 03:19:12', 'pending'),
(2, 0, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'daraga', 59.00, '2025-12-19 03:22:13', 'pending'),
(3, 1, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'daraga', 59.00, '2025-12-19 03:52:32', 'pending'),
(4, 10, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'daraga', 228.00, '2025-12-19 05:54:53', 'pending'),
(6, 10, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'daraga', 787.00, '2025-12-20 00:40:01', 'delivered'),
(7, 16, 'ibang pangalan', 'cielomen@gmail.com', '09918167000', 'daraga', 598.00, '2025-12-20 06:09:34', 'cancel'),
(8, 16, 'ibang pangalan', 'cielomenpez@gmail.com', '09918167010', 'daraga', 299.00, '2025-12-20 06:16:12', 'cancel'),
(9, 10, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167000', 'daraga', 598.00, '2025-12-20 06:17:52', 'on way'),
(10, 22, 'Shai', 'shai@l.com', '09918167010', 'daraga', 289.00, '2025-12-20 09:23:20', 'delivered'),
(11, 22, 'shai', 'shai@l.com', '09918167075', 'daraga', 214.00, '2025-12-20 09:31:18', 'delivered'),
(12, 10, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'daraga', 318.00, '2025-12-20 14:25:15', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `price`, `quantity`, `subtotal`) VALUES
(1, 1, 'Coke', 49.00, 1, 49.00),
(2, 1, 'Iced Tea', 59.00, 1, 59.00),
(3, 1, 'Coke', 49.00, 1, 49.00),
(4, 1, 'Coke', 49.00, 1, 49.00),
(5, 2, 'Iced Tea', 59.00, 1, 59.00),
(6, 3, 'Iced Tea', 59.00, 1, 59.00),
(7, 4, 'Iced Tea', 59.00, 1, 59.00),
(8, 4, 'Beef Burger', 169.00, 1, 169.00),
(9, 6, 'Cheese Pizza', 249.00, 1, 249.00),
(10, 6, 'Hawaiian Pizza', 279.00, 1, 279.00),
(11, 6, 'Veggie Pizza', 259.00, 1, 259.00),
(12, 7, 'Pepperoni Pizza', 299.00, 2, 598.00),
(13, 8, 'Pepperoni Pizza', 299.00, 1, 299.00),
(14, 9, 'Pepperoni Pizza', 299.00, 2, 598.00),
(15, 10, 'Matcha Latte', 75.00, 1, 75.00),
(16, 10, 'Chicken Burger', 149.00, 1, 149.00),
(17, 10, 'Classic Lemonade', 65.00, 1, 65.00),
(18, 11, 'Chicken Burger', 149.00, 1, 149.00),
(19, 11, 'Classic Lemonade', 65.00, 1, 65.00),
(20, 12, 'Beef Burger', 169.00, 1, 169.00),
(21, 12, 'Chicken Burger', 149.00, 1, 149.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('customer','admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `phone`, `address`, `password`, `created_at`, `role`) VALUES
(10, 'cielo', 'cielomendioro.lopez@gmail.com', '09918167010', 'Daraga', '$2y$10$BCUqOY7eLsN2FoWOpvkeg.bRE8Wf2kkyZtElU6VJ.uh1xP4nPIhKe', '2025-12-19 05:27:44', 'customer'),
(11, 'myrthel', 'addun@gmail.com', '09918167000', 'iriga', '$2y$10$j/zHrsDkuTh7neTK5G0ZY./veEJB0ECXEiOkQvEMklwQ8WgvoBoWm', '2025-12-19 05:29:24', 'customer'),
(15, 'John', 'john@gmail.com', '09123456789', 'Manila', 'hash', '2025-12-19 19:38:09', 'customer'),
(16, 'Admin', 'admin@pizzeria.com', '09123456789', 'Admin Address', '$2y$10$hC6H1ADbna/y8GxCmlAyKeTNe15EzcFBt8zQX3dhXFFnVVBaI9noK', '2025-12-19 19:45:51', 'admin'),
(17, 'Frances', 'frances@gmail.com', '09034782345', 'sorsogon', '$2y$10$bhrUtSpOIHqUUDavAflGTe5Qdfb2yb9Q0U1ASrl/uyaojRJpsl3Cu', '2025-12-19 21:57:02', 'customer'),
(18, 'Keso', 'KesoDBongon@gmail.com', '09034782345', 'sorsogon', '$2y$10$yF55lFbiV2JyQcI/5e6qe.2JLK2blNQfvkqieqz9ukAy1rfviOy3e', '2025-12-19 22:05:45', 'customer'),
(19, 'lalaine', 'laine@gmail.com', '09452785432', 'albay', '$2y$10$jk2s.FdH11kXjNkkHJED0.QOCmp45IEJNijvviFkGdz0Qb1v7poxa', '2025-12-20 08:58:34', 'customer'),
(21, 'lyster', 'cielomeez@gmail.com', '09918167075', 'iriga', '$2y$10$jMjgomY/dWRsCimqglULI.pxR3EhS2uzRk7Gsnv284ac5KbWPVQbG', '2025-12-20 09:19:48', 'customer'),
(22, 'shai', 'shai@l.com', '09124754382', 'Daraga', '$2y$10$AZBKUbUL9RrC6sFsziS0SOiImukoipeH3RqXe/up3lsW6yTw0vHHy', '2025-12-20 09:21:26', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
