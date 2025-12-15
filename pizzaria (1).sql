-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 04:53 AM
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
-- Database: `pizzaria`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_ID` int(11) NOT NULL,
  `cus_ID` int(11) NOT NULL,
  `seller_ID` int(11) NOT NULL,
  `cus_message` varchar(100) NOT NULL,
  `seller_message` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cus_ID` int(11) NOT NULL,
  `cus_name` varchar(100) NOT NULL,
  `cus_username` varchar(100) NOT NULL,
  `login_cus_id` int(11) NOT NULL,
  `contact_num` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `order_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_login`
--

CREATE TABLE `customer_login` (
  `log_cus_id` int(11) NOT NULL,
  `cus_ID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `delivery_ID` int(11) NOT NULL,
  `order_ID` int(11) NOT NULL,
  `courier` varchar(100) NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_time` time(6) NOT NULL,
  `delivery_driver` varchar(100) NOT NULL,
  `delivery_driver_contact` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `cus_ID` int(11) NOT NULL,
  `seller_ID` int(11) NOT NULL,
  `payment_ID` int(11) NOT NULL,
  `quantity` int(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_time` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `delivery_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_ID` int(11) NOT NULL,
  `order_ID` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_ID` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `seller_ID` int(11) NOT NULL,
  `shop_ID` int(11) NOT NULL,
  `reviews_product_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews_product`
--

CREATE TABLE `reviews_product` (
  `reviews_product_ID` int(11) NOT NULL,
  `shop_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `order_ID` int(11) NOT NULL,
  `review` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews_shop`
--

CREATE TABLE `reviews_shop` (
  `reviews_shop_ID` int(11) NOT NULL,
  `shop_ID` int(11) NOT NULL,
  `reviews` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `seller_ID` int(11) NOT NULL,
  `login_seller_ID` int(11) NOT NULL,
  `seller_name` varchar(100) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `contact_num` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `order_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_login`
--

CREATE TABLE `seller_login` (
  `login_seller_ID` int(11) NOT NULL,
  `seller_ID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `shop_ID` int(11) NOT NULL,
  `shop_name` varchar(100) NOT NULL,
  `seller_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `reviews_shop_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_ID`),
  ADD UNIQUE KEY `cus_ID` (`cus_ID`),
  ADD UNIQUE KEY `seller_ID` (`seller_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cus_ID`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD UNIQUE KEY `login_cus_id` (`login_cus_id`),
  ADD UNIQUE KEY `chat_id` (`chat_id`);

--
-- Indexes for table `customer_login`
--
ALTER TABLE `customer_login`
  ADD PRIMARY KEY (`log_cus_id`),
  ADD UNIQUE KEY `cus_ID` (`cus_ID`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`delivery_ID`),
  ADD UNIQUE KEY `order_ID` (`order_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_ID`),
  ADD UNIQUE KEY `product_ID` (`product_ID`),
  ADD UNIQUE KEY `cus_ID` (`cus_ID`),
  ADD UNIQUE KEY `seller_ID` (`seller_ID`),
  ADD UNIQUE KEY `payment_ID` (`payment_ID`),
  ADD UNIQUE KEY `delivery_ID` (`delivery_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_ID`),
  ADD UNIQUE KEY `order_ID` (`order_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_ID`),
  ADD UNIQUE KEY `seller_ID` (`seller_ID`),
  ADD UNIQUE KEY `reviews_product_ID` (`reviews_product_ID`),
  ADD UNIQUE KEY `shop_ID` (`shop_ID`);

--
-- Indexes for table `reviews_product`
--
ALTER TABLE `reviews_product`
  ADD PRIMARY KEY (`reviews_product_ID`),
  ADD UNIQUE KEY `shop_ID` (`shop_ID`),
  ADD UNIQUE KEY `product_ID` (`product_ID`),
  ADD UNIQUE KEY `order_ID` (`order_ID`);

--
-- Indexes for table `reviews_shop`
--
ALTER TABLE `reviews_shop`
  ADD PRIMARY KEY (`reviews_shop_ID`),
  ADD UNIQUE KEY `shop_ID` (`shop_ID`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`seller_ID`),
  ADD UNIQUE KEY `login_seller_ID` (`login_seller_ID`),
  ADD UNIQUE KEY `shop_id` (`shop_id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD UNIQUE KEY `chat_id` (`chat_id`);

--
-- Indexes for table `seller_login`
--
ALTER TABLE `seller_login`
  ADD PRIMARY KEY (`login_seller_ID`),
  ADD UNIQUE KEY `seller_ID` (`seller_ID`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`shop_ID`),
  ADD UNIQUE KEY `seller_ID` (`seller_ID`),
  ADD UNIQUE KEY `product_ID` (`product_ID`),
  ADD UNIQUE KEY `reviews_ID` (`reviews_shop_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cus_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_login`
--
ALTER TABLE `customer_login`
  MODIFY `log_cus_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `delivery_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews_product`
--
ALTER TABLE `reviews_product`
  MODIFY `reviews_product_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews_shop`
--
ALTER TABLE `reviews_shop`
  MODIFY `reviews_shop_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `seller_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_login`
--
ALTER TABLE `seller_login`
  MODIFY `login_seller_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `shop_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`seller_ID`) REFERENCES `seller` (`seller_ID`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`cus_ID`) REFERENCES `customer` (`cus_ID`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`login_cus_id`) REFERENCES `customer_login` (`log_cus_id`),
  ADD CONSTRAINT `customer_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_ID`),
  ADD CONSTRAINT `customer_ibfk_3` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`chat_ID`);

--
-- Constraints for table `customer_login`
--
ALTER TABLE `customer_login`
  ADD CONSTRAINT `customer_login_ibfk_1` FOREIGN KEY (`cus_ID`) REFERENCES `customer` (`cus_ID`);

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`order_ID`) REFERENCES `orders` (`order_ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cus_ID`) REFERENCES `customer` (`cus_ID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`seller_ID`) REFERENCES `seller` (`seller_ID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`product_ID`) REFERENCES `products` (`product_ID`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`delivery_ID`) REFERENCES `delivery` (`delivery_ID`),
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`payment_ID`) REFERENCES `payment` (`payment_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_ID`) REFERENCES `orders` (`order_ID`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`seller_ID`) REFERENCES `seller` (`seller_ID`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`reviews_product_ID`) REFERENCES `reviews_product` (`reviews_product_ID`);

--
-- Constraints for table `reviews_product`
--
ALTER TABLE `reviews_product`
  ADD CONSTRAINT `reviews_product_ibfk_1` FOREIGN KEY (`shop_ID`) REFERENCES `shop` (`shop_ID`),
  ADD CONSTRAINT `reviews_product_ibfk_2` FOREIGN KEY (`order_ID`) REFERENCES `orders` (`order_ID`);

--
-- Constraints for table `seller`
--
ALTER TABLE `seller`
  ADD CONSTRAINT `seller_ibfk_1` FOREIGN KEY (`login_seller_ID`) REFERENCES `seller_login` (`login_seller_ID`),
  ADD CONSTRAINT `seller_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`shop_ID`),
  ADD CONSTRAINT `seller_ibfk_3` FOREIGN KEY (`chat_id`) REFERENCES `chat` (`chat_ID`);

--
-- Constraints for table `seller_login`
--
ALTER TABLE `seller_login`
  ADD CONSTRAINT `seller_login_ibfk_1` FOREIGN KEY (`seller_ID`) REFERENCES `seller` (`seller_ID`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `shop_ibfk_1` FOREIGN KEY (`seller_ID`) REFERENCES `seller` (`seller_ID`),
  ADD CONSTRAINT `shop_ibfk_2` FOREIGN KEY (`product_ID`) REFERENCES `products` (`product_ID`),
  ADD CONSTRAINT `shop_ibfk_3` FOREIGN KEY (`reviews_shop_ID`) REFERENCES `reviews_shop` (`reviews_shop_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
