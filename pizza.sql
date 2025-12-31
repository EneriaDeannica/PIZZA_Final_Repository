/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.32-MariaDB : Database - pizza
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pizza` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `pizza`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`status`) values 
(1,'Pizza',1),
(2,'Burger',1),
(3,'Beverages',1),
(4,'Pasta',1),
(5,'Dessert',1);

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`menu_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `menu` */

insert  into `menu`(`menu_id`,`name`,`description`,`price`,`image`,`category_id`,`status`,`created_at`,`stock`) values 
(1,'Pepperoni Pizza','Classic pepperoni with mozzarella cheese',299.00,'pizza.png',1,1,'2025-12-19 09:09:39',11),
(2,'Cheese Pizza','Rich tomato sauce and melted cheese',249.00,'cheese pizza.jpg',1,1,'2025-12-19 09:09:39',0),
(3,'Hawaiian Pizza','Ham, pineapple, and cheese',279.00,'hawaiian pizza.jpg',1,1,'2025-12-19 09:09:39',0),
(4,'Veggie Pizza','Loaded with fresh vegetables',259.00,'veggie pizza.jpg',1,1,'2025-12-19 09:09:39',0),
(5,'Chicken Burger','Crispy chicken with special sauce',149.00,'chickenburger.jpeg',2,1,'2025-12-19 09:09:39',0),
(6,'Beef Burger','Juicy beef patty with cheese',169.00,'beef burger.jpg',2,1,'2025-12-19 09:09:39',0),
(7,'Coke','Chilled soft drink',49.00,'Coke.jpg',3,1,'2025-12-19 09:09:39',0),
(8,'Iced Tea','Refreshing lemon iced tea',59.00,'Iced Tea.jpg',3,1,'2025-12-19 09:09:39',0),
(9,'Carbonara Pasta','Creamy white sauce pasta',199.00,'carbonara.jpeg',4,1,'2025-12-19 09:09:39',0),
(10,'Spaghetti','Classic Italian spaghetti',189.00,'classic pasta.jpg',4,1,'2025-12-19 09:09:39',0),
(11,'Chocolate Cake','Rich chocolate dessert',129.00,'chocolate cake.jpg',5,1,'2025-12-19 09:09:39',0),
(28,'Bacon Burger','Beef burger with crispy bacon and cheese.',150.00,'bacon burger.jpg',2,1,'2025-12-19 20:42:36',0),
(30,'Classic American Burger','Classic beef burger with cheese and veggies.',170.00,'classic american burger.jpg',2,1,'2025-12-19 20:42:36',0),
(31,'Alaking Burger','Creamy chicken burger with rich sauce.',165.00,'alaking.jpg',2,1,'2025-12-19 20:42:36',0),
(33,'Shrimp Burger','Crispy shrimp burger with fresh lettuce.',170.00,'shrimp burger.jpg',2,1,'2025-12-19 20:42:36',0),
(34,'Spaghetti Bolognese','Spaghetti with rich meat sauce.',185.00,'spaghetti-bolognese-36.jpg',4,1,'2025-12-19 20:42:36',0),
(35,'Creamy Cajun Pasta','Creamy pasta with Cajun-spiced chicken.',190.00,'creamy cajun pasta.jpg',4,1,'2025-12-19 20:42:36',0),
(36,'Chicken Alfredo','Creamy Alfredo pasta with chicken.',195.00,'Chicken Alfredo.jpg',4,1,'2025-12-19 20:42:36',0),
(37,'Creamy Pesto Chicken Skillet','Creamy pesto pasta with chicken.',189.00,'Creamy Pesto Chicken Skillet.jpg',4,1,'2025-12-19 20:42:36',0),
(38,'Classic Lemonade','Fresh sweet and sour lemonade.',65.00,'classic lemonade.jpg',3,1,'2025-12-19 20:42:36',0),
(39,'Bubble Gum','Sweet bubble gum flavored drink.',45.00,'bubble gum.jpg',3,1,'2025-12-19 20:42:36',0),
(40,'Peach Iced Tea','Iced tea with peach flavor.',65.00,'peach iced tea.jpg',3,1,'2025-12-19 20:42:36',0),
(41,'Matcha Latte','Creamy matcha green tea latte.',75.00,'Matcha Latte.jpg',3,1,'2025-12-19 20:42:36',0),
(42,'Tandoori Pizza','Pizza with spicy tandoori chicken.',280.00,'tandoori pizza.jpg',1,1,'2025-12-19 20:42:36',0),
(43,'Margherita Pizza','Classic pizza with tomato and cheese.',295.00,'margherita pizza.jpg',1,1,'2025-12-19 20:42:36',1),
(44,'Chocolate Lava Cake','Warm chocolate cake with molten center.',180.00,'lava cake.jpg',5,1,'2025-12-19 20:55:49',1),
(45,'Classic Cheesecake','Creamy cheesecake with graham crust.',175.00,'cheese cake.jpg',5,1,'2025-12-19 20:55:49',2),
(46,'Chocolate Brownie','Rich chocolate brownie served warm.',160.00,'brownie.jpg',5,1,'2025-12-19 20:55:49',1),
(47,'Vanilla Ice Cream','Smooth vanilla ice cream scoop.',120.00,'ice cream.jpg',5,1,'2025-12-19 20:55:49',3),
(48,'Caramel Flan','Silky caramel custard dessert.',165.00,'flan.jpg',5,1,'2025-12-19 20:55:49',1),
(49,'Burger','Beef burger',0.00,'uploads/1767112893_beef burger.jpg',2,1,'2025-12-31 00:41:33',0),
(53,'Pizza','Mushroom Pizza',0.00,'uploads/1767189321_mushroom pizza.jfif',1,1,'2025-12-31 21:55:22',2);

/*Table structure for table `order_items` */

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `order_items` */

insert  into `order_items`(`id`,`order_id`,`product_name`,`price`,`quantity`,`subtotal`) values 
(1,1,'Coke',49.00,1,49.00),
(2,1,'Iced Tea',59.00,1,59.00),
(3,1,'Coke',49.00,1,49.00),
(4,1,'Coke',49.00,1,49.00),
(5,2,'Iced Tea',59.00,1,59.00),
(6,3,'Iced Tea',59.00,1,59.00),
(7,4,'Iced Tea',59.00,1,59.00),
(8,4,'Beef Burger',169.00,1,169.00),
(9,6,'Cheese Pizza',249.00,1,249.00),
(10,6,'Hawaiian Pizza',279.00,1,279.00),
(11,6,'Veggie Pizza',259.00,1,259.00),
(12,7,'Pepperoni Pizza',299.00,2,598.00),
(13,8,'Pepperoni Pizza',299.00,1,299.00),
(14,9,'Pepperoni Pizza',299.00,2,598.00),
(15,10,'Matcha Latte',75.00,1,75.00),
(16,10,'Chicken Burger',149.00,1,149.00),
(17,10,'Classic Lemonade',65.00,1,65.00),
(18,11,'Chicken Burger',149.00,1,149.00),
(19,11,'Classic Lemonade',65.00,1,65.00),
(20,12,'Beef Burger',169.00,1,169.00),
(21,12,'Chicken Burger',149.00,1,149.00),
(22,13,'Coke',49.00,1,49.00),
(23,13,'Iced Tea',59.00,1,59.00),
(24,13,'Classic Lemonade',65.00,1,65.00),
(25,13,'Bubble Gum',45.00,1,45.00),
(26,14,'Bubble Gum',45.00,1,45.00),
(27,14,'Beef Burger',169.00,1,169.00),
(28,14,'Bacon Burger',150.00,1,150.00),
(29,14,'Classic American Burger',170.00,1,170.00),
(30,14,'Alaking Burger',165.00,1,165.00),
(31,14,'Shrimp Burger',170.00,1,170.00),
(32,14,'Chocolate Lava Cake',180.00,2,360.00),
(33,14,'Classic Cheesecake',175.00,1,175.00),
(34,14,'Chocolate Brownie',160.00,1,160.00),
(35,14,'Spaghetti',189.00,1,189.00),
(36,14,'Carbonara Pasta',199.00,1,199.00),
(37,14,'Caramel Flan',165.00,1,165.00),
(38,14,'Vanilla Ice Cream',120.00,1,120.00),
(39,14,'Creamy Cajun Pasta',190.00,1,190.00),
(40,14,'Chicken Alfredo',195.00,1,195.00),
(41,14,'Creamy Pesto Chicken Skillet',189.00,1,189.00),
(42,15,'Cheese Pizza',249.00,1,249.00),
(43,15,'Hawaiian Pizza',279.00,1,279.00),
(44,15,'Spaghetti',189.00,2,378.00),
(45,15,'Spaghetti Bolognese',185.00,2,370.00),
(46,16,'Classic Lemonade',65.00,1,65.00),
(47,16,'Coke',49.00,1,49.00),
(48,16,'Classic American Burger',170.00,1,170.00),
(49,17,'Hawaiian Pizza',279.00,1,279.00),
(50,17,'Cheese Pizza',249.00,1,249.00),
(51,17,'Coke',49.00,2,98.00),
(52,17,'Peach Iced Tea',65.00,2,130.00),
(53,17,'Carbonara Pasta',199.00,1,199.00),
(54,17,'Spaghetti',189.00,1,189.00),
(55,17,'Classic Cheesecake',175.00,1,175.00),
(56,17,'Vanilla Ice Cream',120.00,2,240.00),
(57,18,'Coke',49.00,2,98.00),
(58,18,'Iced Tea',59.00,2,118.00),
(59,18,'Peach Iced Tea',65.00,2,130.00),
(60,18,'Hawaiian Pizza',279.00,1,279.00),
(61,18,'Beef Burger',169.00,1,169.00),
(62,18,'Alaking Burger',165.00,1,165.00),
(63,18,'Chocolate Brownie',160.00,1,160.00),
(64,18,'Classic Cheesecake',175.00,1,175.00),
(65,18,'Vanilla Ice Cream',120.00,2,240.00),
(66,18,'Caramel Flan',165.00,1,165.00),
(67,18,'Matcha Latte',75.00,2,150.00),
(68,19,'Coke',49.00,2,98.00),
(69,19,'Iced Tea',59.00,1,59.00),
(70,19,'Chicken Burger',149.00,2,298.00),
(71,20,'Coke',49.00,1,49.00),
(72,20,'Beef Burger',169.00,1,169.00),
(73,20,'Classic Cheesecake',175.00,1,175.00),
(74,21,'Coke',49.00,1,49.00),
(75,21,'Classic Cheesecake',175.00,1,175.00),
(76,21,'Beef Burger',169.00,1,169.00),
(77,22,'Coke',49.00,3,147.00),
(78,22,'Iced Tea',59.00,3,177.00),
(79,22,'Bacon Burger',150.00,2,300.00),
(80,22,'Classic Cheesecake',175.00,3,525.00),
(81,22,'Spaghetti',189.00,1,189.00),
(82,22,'Carbonara Pasta',199.00,1,199.00),
(83,22,'Pepperoni Pizza',299.00,1,299.00);

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `orders` */

insert  into `orders`(`order_id`,`user_id`,`customer_name`,`email`,`phone`,`address`,`total`,`created_at`,`status`) values 
(1,0,'Cielo Lopez','cielomendioro.lopez@gmail.com','09918167010','Daraga',206.00,'2025-12-19 11:19:12','pending'),
(2,0,'Cielo Lopez','cielomendioro.lopez@gmail.com','09918167010','daraga',59.00,'2025-12-19 11:22:13','pending'),
(3,1,'Cielo Lopez','cielomendioro.lopez@gmail.com','09918167010','daraga',59.00,'2025-12-19 11:52:32','pending'),
(4,10,'Cielo Lopez','cielomendioro.lopez@gmail.com','09918167010','daraga',228.00,'2025-12-19 13:54:53','on way'),
(6,10,'Cielo Lopez','cielomendioro.lopez@gmail.com','09918167010','daraga',787.00,'2025-12-20 08:40:01','delivered'),
(7,16,'ibang pangalan','cielomen@gmail.com','09918167000','daraga',598.00,'2025-12-20 14:09:34','cancel'),
(8,16,'ibang pangalan','cielomenpez@gmail.com','09918167010','daraga',299.00,'2025-12-20 14:16:12','cancel'),
(9,10,'Cielo Lopez','cielomendioro.lopez@gmail.com','09918167000','daraga',598.00,'2025-12-20 14:17:52','on way'),
(10,22,'Shai','shai@l.com','09918167010','daraga',289.00,'2025-12-20 17:23:20','delivered'),
(11,22,'shai','shai@l.com','09918167075','daraga',214.00,'2025-12-20 17:31:18','delivered'),
(12,10,'Cielo Lopez','cielomendioro.lopez@gmail.com','09918167010','daraga',318.00,'2025-12-20 22:25:15','on way'),
(13,23,'Wonder Weiss','wwss2288@gmail.com','09273467912','Kansa, Texas',218.00,'2025-12-26 17:45:07','delivered'),
(14,23,'Wonder Weiss','wwss2288@gmail.com','09273467912','Kansas, Texas',2811.00,'2025-12-26 17:47:00','delivered'),
(15,24,'Crisyan Nimo','loppun@gmail.com','09273359675','Philippines, Metro Manila',1276.00,'2025-12-26 17:53:43','cancelled'),
(16,24,'Crisyan Nimo','loppun@gmail.com','09273359675','Las Vegas',284.00,'2025-12-26 17:57:00','cancelled'),
(17,16,'Admin','admin@pizzeria.com','09123456789','Admin Address',1559.00,'2025-12-26 21:51:24','on way'),
(18,16,'Admin','admin@pizzeria.com','09123456789','Admin Address',1849.00,'2025-12-26 22:04:40','on way'),
(19,16,'Admin','admin@pizzeria.com','09123456789','Admin Priveliges',455.00,'2025-12-28 16:37:26','cancel'),
(20,23,'Wonder Weiss','wwss2288@gmail.com','09273467912','Japan, Tokyo',393.00,'2025-12-28 18:14:09','cancel'),
(21,26,'Solopipb','solopipb114@gmail.com','09928819493','Las Vegas',393.00,'2025-12-30 23:43:27','delivered'),
(22,28,'New User','newuser123@gmail.com','0999484123','New York, Avenue',1836.00,'2025-12-31 20:14:39','on way');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('customer','admin') DEFAULT 'customer',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`email`,`phone`,`address`,`password`,`created_at`,`role`) values 
(10,'cielo','cielomendioro.lopez@gmail.com','09918167010','Daraga','$2y$10$BCUqOY7eLsN2FoWOpvkeg.bRE8Wf2kkyZtElU6VJ.uh1xP4nPIhKe','2025-12-19 13:27:44','customer'),
(11,'myrthel','addun@gmail.com','09918167000','iriga','$2y$10$j/zHrsDkuTh7neTK5G0ZY./veEJB0ECXEiOkQvEMklwQ8WgvoBoWm','2025-12-19 13:29:24','customer'),
(15,'John','john@gmail.com','09123456789','Manila','hash','2025-12-20 03:38:09','customer'),
(16,'Admin','admin@pizzeria.com','09123456789','Admin Address','$2y$10$hC6H1ADbna/y8GxCmlAyKeTNe15EzcFBt8zQX3dhXFFnVVBaI9noK','2025-12-20 03:45:51','admin'),
(17,'Frances','frances@gmail.com','09034782345','sorsogon','$2y$10$bhrUtSpOIHqUUDavAflGTe5Qdfb2yb9Q0U1ASrl/uyaojRJpsl3Cu','2025-12-20 05:57:02','customer'),
(18,'Keso','KesoDBongon@gmail.com','09034782345','sorsogon','$2y$10$yF55lFbiV2JyQcI/5e6qe.2JLK2blNQfvkqieqz9ukAy1rfviOy3e','2025-12-20 06:05:45','customer'),
(19,'lalaine','laine@gmail.com','09452785432','albay','$2y$10$jk2s.FdH11kXjNkkHJED0.QOCmp45IEJNijvviFkGdz0Qb1v7poxa','2025-12-20 16:58:34','customer'),
(21,'lyster','cielomeez@gmail.com','09918167075','iriga','$2y$10$jMjgomY/dWRsCimqglULI.pxR3EhS2uzRk7Gsnv284ac5KbWPVQbG','2025-12-20 17:19:48','customer'),
(22,'shai','shai@l.com','09124754382','Daraga','$2y$10$AZBKUbUL9RrC6sFsziS0SOiImukoipeH3RqXe/up3lsW6yTw0vHHy','2025-12-20 17:21:26','customer'),
(23,'Wonder_Weiss','wwss2288@gmail.com','09273467912','Japan, Tokyo','$2y$10$VHlxd8rhE9V2B00bkisugO4zBCt2tIRNy2BVG/MJ7aRGvgAOM./Li','2025-12-26 17:35:26','customer'),
(24,'Crisyan Nimo','loppun@gmail.com','09273359675','Philippines, Metro Manila','$2y$10$uEOZooopPH95m/Iq4W9sNO9YVrWKQwCI55/LwwHHFMMuLZ/SNKz2a','2025-12-26 17:50:28','customer'),
(25,'slytherin3643','slytherin@gmail.com','09994259889','Las Vegas','$2y$10$U38Yjzg7ieaaUWmMD9qQou1FibcorIs0VNqBeab0XcVHrG9/.ErMm','2025-12-26 18:24:19','customer'),
(26,'SoloPipB114750','solopipb114@gmail.com','09928819493','Las Vegas','$2y$10$DTaOAbfhw/NwbqYcmxKRJO.x9mQxgKVW0rZ0C4D7wJzOIC.LAYEHO','2025-12-30 23:40:10','customer'),
(28,'New User','newuser123@gmail.com','0999484123','New York, Avenue','$2y$10$txOfqqTiT2RKCh8ObkRll.ESCjJZnpfsow/HfGvoiNYmmRNBvzuhC','2025-12-31 20:12:45','customer');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
