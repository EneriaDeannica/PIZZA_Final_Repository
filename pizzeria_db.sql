-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2025 at 07:08 AM
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
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `price`, `image`, `category_id`, `status`, `created_at`) VALUES
(1, 'Pepperoni Pizza', 'Classic pepperoni with mozzarella cheese', 299.00, 'pizza.png', 1, 1, '2025-12-19 01:09:39'),
(2, 'Cheese Pizza', 'Rich tomato sauce and melted cheese', 249.00, 'pizza.png', 1, 1, '2025-12-19 01:09:39'),
(3, 'Hawaiian Pizza', 'Ham, pineapple, and cheese', 279.00, 'pizza.png', 1, 1, '2025-12-19 01:09:39'),
(4, 'Veggie Pizza', 'Loaded with fresh vegetables', 259.00, 'pizza.png', 1, 1, '2025-12-19 01:09:39'),
(5, 'Chicken Burger', 'Crispy chicken with special sauce', 149.00, 'chickenburger.jpeg', 2, 1, '2025-12-19 01:09:39'),
(6, 'Beef Burger', 'Juicy beef patty with cheese', 169.00, 'burger2.png', 2, 1, '2025-12-19 01:09:39'),
(7, 'Coke', 'Chilled soft drink', 49.00, 'coke.jpeg', 3, 1, '2025-12-19 01:09:39'),
(8, 'Iced Tea', 'Refreshing lemon iced tea', 59.00, 'icedtea.png', 3, 1, '2025-12-19 01:09:39'),
(9, 'Carbonara Pasta', 'Creamy white sauce pasta', 199.00, 'pasta1.png', 4, 1, '2025-12-19 01:09:39'),
(10, 'Spaghetti', 'Classic Italian spaghetti', 189.00, 'pasta2.png', 4, 1, '2025-12-19 01:09:39'),
(11, 'Chocolate Cake', 'Rich chocolate dessert', 129.00, 'dessert1.png', 5, 1, '2025-12-19 01:09:39');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `email`, `phone`, `address`, `total`, `created_at`) VALUES
(1, 0, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'Daraga', 206.00, '2025-12-19 03:19:12'),
(2, 0, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'daraga', 59.00, '2025-12-19 03:22:13'),
(3, 1, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'daraga', 59.00, '2025-12-19 03:52:32'),
(4, 10, 'Cielo Lopez', 'cielomendioro.lopez@gmail.com', '09918167010', 'daraga', 228.00, '2025-12-19 05:54:53');

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
(8, 4, 'Beef Burger', 169.00, 1, 169.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `address`, `password`, `created_at`, `role`) VALUES
(10, 'cielo', 'cielomendioro.lopez@gmail.com', '09918167010', 'Daraga', '$2y$10$BCUqOY7eLsN2FoWOpvkeg.bRE8Wf2kkyZtElU6VJ.uh1xP4nPIhKe', '2025-12-19 05:27:44', 'customer'),
(11, 'myrthel', 'addun@gmail.com', '09918167000', 'iriga', '$2y$10$j/zHrsDkuTh7neTK5G0ZY./veEJB0ECXEiOkQvEMklwQ8WgvoBoWm', '2025-12-19 05:29:24', 'customer'),
(13, 'admin', 'admin@example.com', '0991817080', 'daraga\r\n', '$2y$10$J9yJWrvfy12DXhUp0gEeU.4OFg1Z6kDFYqgG7pA6gGZZm/6B1X0nC', '2025-12-19 05:42:25', 'admin');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
