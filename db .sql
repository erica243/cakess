-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2024 at 08:48 AM
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
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(30) NOT NULL,
  `client_ip` varchar(20) NOT NULL,
  `user_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `client_ip`, `user_id`, `product_id`, `qty`) VALUES
(236, '::1', 45, 38, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`) VALUES
(8, 'Baptismal Cake '),
(10, 'Fathers/Mothers Day Cake'),
(19, 'Wedding Cake'),
(23, 'Birthday Cake');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_reply` text DEFAULT NULL,
  `reply_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `order_number`, `email`, `comment`, `photo_path`, `created_at`, `admin_reply`, `reply_date`) VALUES
(1, '2088', 'manilyndemesa87@gmail.com', 'HI admin', NULL, '2024-11-22 14:38:03', 'hello', '2024-11-22 14:53:36'),
(2, '2088', 'manilyndemesa87@gmail.com', 'HI admin', NULL, '2024-11-22 14:54:06', 'd', '2024-11-22 15:03:13'),
(3, '2088', 'manilyndemesa87@gmail.com', 'HI admin', NULL, '2024-11-22 14:55:16', 'sd', '2024-11-22 15:01:06'),
(4, '2088', 'manilyndemesa87@gmail.com', 'HI admin', NULL, '2024-11-22 14:56:14', 'oo', '2024-11-22 15:01:00'),
(5, '2088', 'manilyndemesa87@gmail.com', 'gwapo ako', 'uploads/1732287435_birth6.jpg', '2024-11-22 14:57:15', 'oo patugot', '2024-11-22 14:58:07'),
(6, '2088', 'manilyndemesa87@gmail.com', 'sorry\r\n', NULL, '2024-11-22 15:04:16', 'd mako', '2024-11-22 15:04:28'),
(7, '2088', 'manilyndemesa87@gmail.com', 'utro', NULL, '2024-11-22 15:04:51', 'd', '2024-11-22 15:15:07'),
(8, '2088', 'manilyndemesa87@gmail.com', 'dcd', NULL, '2024-11-22 15:29:37', 'sfffweed', '2024-11-22 15:30:05');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_details`
--

CREATE TABLE `delivery_details` (
  `id` int(11) NOT NULL,
  `delivery_name` varchar(255) NOT NULL,
  `delivery_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_details`
--

INSERT INTO `delivery_details` (`id`, `delivery_name`, `delivery_number`) VALUES
(1, 'as', '24'),
(2, 'as', '24'),
(3, 'as', 'we');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `order_number` int(50) NOT NULL,
  `message` text NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_reply` text DEFAULT NULL,
  `user_reply` text DEFAULT NULL,
  `reply_date` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`user_id`, `email`, `order_number`, `message`, `photo_path`, `created_at`, `admin_reply`, `user_reply`, `reply_date`, `status`, `is_read`) VALUES
(130, 'manilyndemesa87@gmail.com', 2088, 'sss', 'uploads/1732290606_birth9.jpg', '2024-11-22 15:50:06', 'erfefe', NULL, '2024-11-22 15:59:18', 1, 0),
(131, 'manilyndemesa87@gmail.com', 0, 'ccs', '', '2024-11-22 16:04:37', 'vvff', NULL, '2024-11-22 16:05:25', 1, 0),
(132, 'manilyndemesa87@gmail.com', 0, 'ccs', '', '2024-11-22 16:05:31', 'sd', NULL, '2024-11-22 16:36:22', 1, 0),
(133, 'manilyndemesa87@gmail.com', 2088, 'a', NULL, '2024-11-22 16:38:51', 'ewe', NULL, '2024-11-22 16:39:03', 1, 0),
(134, 'manilyndemesa87@gmail.com', 2088, 'sa', NULL, '2024-11-22 16:57:21', 'sd', NULL, '2024-11-22 16:57:35', 1, 0),
(135, 'manilyndemesa87@gmail.com', 2088, 'sa', NULL, '2024-11-22 16:57:40', NULL, NULL, NULL, 0, 0);

--
-- Triggers `messages`
--
DELIMITER $$
CREATE TRIGGER `after_message_reply` AFTER UPDATE ON `messages` FOR EACH ROW BEGIN
    IF NEW.admin_reply IS NOT NULL AND OLD.admin_reply IS NULL THEN
        INSERT INTO notifications (user_id, type, reference_id, message)
        VALUES (
            NEW.user_id,
            'message_reply',
            NEW.order_number,
            CONCAT('You have received a reply to your message regarding order #', NEW.order_number)
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `reference_id`, `message`, `created_at`, `is_read`, `order_id`) VALUES
(1, 130, 'message_reply', 2088, 'You have received a reply to your message regarding order #2088', '2024-11-22 15:59:18', 0, 0),
(2, 131, 'message_reply', 0, 'You have received a reply to your message regarding order #0', '2024-11-22 16:05:25', 0, 0),
(3, 132, 'message_reply', 0, 'You have received a reply to your message regarding order #0', '2024-11-22 16:36:22', 0, 0),
(4, 133, 'message_reply', 2088, 'You have received a reply to your message regarding order #2088', '2024-11-22 16:39:03', 0, 0),
(5, 134, 'message_reply', 2088, 'You have received a reply to your message regarding order #2088', '2024-11-22 16:57:35', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(30) NOT NULL,
  `order_number` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `name` text NOT NULL,
  `address` text NOT NULL,
  `mobile` text NOT NULL,
  `email` text NOT NULL,
  `delivery_method` varchar(100) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `shipping` int(11) NOT NULL,
  `pickup_date` date DEFAULT NULL,
  `pickup_time` time DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `delivery_status` varchar(100) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `status_updated_at` datetime DEFAULT current_timestamp(),
  `estimated_delivery` datetime DEFAULT NULL,
  `tracking_notes` text DEFAULT NULL,
  `tracking_status` varchar(50) DEFAULT 'Order Placed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `order_date`, `name`, `address`, `mobile`, `email`, `delivery_method`, `transaction_id`, `payment_method`, `created_at`, `shipping`, `pickup_date`, `pickup_time`, `payment_proof`, `delivery_status`, `status`, `ref_no`, `status_updated_at`, `estimated_delivery`, `tracking_notes`, `tracking_status`) VALUES
(78, 1273, '2024-11-17 15:12:37', 'Erica Adlit', 'malbago', '6391582596', 'erica204chavez@gmail.com', 'pickup', 0, 'cash', '2024-11-17 22:13:31', 0, '2024-11-18', '22:18:00', '', 'delivered', '1', '', '2024-11-17 22:12:37', NULL, NULL, 'Order Placed'),
(79, 7942, '2024-11-17 15:13:31', 'Erica Adlit', 'malbago', '6391582596', 'erica204chavez@gmail.com', 'pickup', 0, 'cash', '2024-11-17 22:13:31', 0, '2024-11-18', '15:18:00', '', 'delivered', '', '', '2024-11-17 22:13:31', NULL, NULL, 'Order Placed'),
(80, 7179, '2024-11-19 11:17:26', 'Erica Adlit', 'malbago', '6391582596', 'erica204chavez@gmail.com', 'pickup', 0, 'cash', '2024-11-19 18:17:26', 0, '0000-00-00', '00:00:00', '', '', '', '', '2024-11-19 18:17:26', NULL, NULL, 'Order Placed'),
(81, 1972, '2024-11-19 11:18:08', 'Erica Adlit', 'malbago', '6391582596', 'erica204chavez@gmail.com', 'pickup', 0, 'cash', '2024-11-19 18:18:08', 0, '2024-11-27', '22:22:00', '', '', '', '', '2024-11-19 18:18:08', NULL, NULL, 'Order Placed'),
(82, 4491, '2024-11-22 14:32:07', 'Erica Adlit', 'malbago', '6391582596', 'manilyndemesa87@gmail.com', 'delivery', 0, 'cash', '2024-11-22 21:32:07', 0, '0000-00-00', '00:00:00', '', 'delivered', '', '', '2024-11-22 21:32:07', NULL, NULL, 'Order Placed'),
(83, 4243, '2024-11-22 14:53:10', 'Erica Adlit', 'malbago', '6391582596', 'manilyndemesa87@gmail.com', 'delivery', 0, 'cash', '2024-11-22 21:53:10', 0, '0000-00-00', '00:00:00', '', 'preparing', '', '', '2024-11-22 21:53:10', NULL, NULL, 'Order Placed'),
(84, 2088, '2024-11-22 15:27:16', 'Erica Adlit', 'malbago', '6391582596', 'manilyndemesa87@gmail.com', 'delivery', 0, 'cash', '2024-11-22 22:27:16', 0, '0000-00-00', '00:00:00', '', NULL, '', '', '2024-11-22 22:27:16', NULL, NULL, 'Order Placed');

--
-- Triggers `orders`
--
DELIMITER $$
CREATE TRIGGER `after_order_status_update` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    IF NEW.status != OLD.status THEN
        INSERT INTO notifications (user_id, type, reference_id, message)
        SELECT 
            u.id,
            'order_status',
            NEW.order_number,
            CONCAT('Your order #', NEW.order_number, ' status has been updated to: ', NEW.status)
        FROM users u
        WHERE u.email = NEW.email;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `order_id`, `product_id`, `qty`) VALUES
(146, 78, 38, 1),
(147, 79, 38, 1),
(148, 81, 38, 1),
(149, 81, 38, 1),
(150, 82, 38, 1),
(151, 83, 38, 1),
(152, 84, 38, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_status_logs`
--

CREATE TABLE `order_status_logs` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_tracking`
--

CREATE TABLE `order_tracking` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL DEFAULT 0,
  `img_path` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `size_unit` varchar(10) NOT NULL DEFAULT 'inches',
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `category_id`, `name`, `description`, `price`, `img_path`, `status`, `size`, `size_unit`, `stock`) VALUES
(38, 8, 'Chocolate cakek', 'jkh', 480, '_6292e5b9-9a68-4547-b465-9562e06e3faf.jpg', 'Available', '1', 'inches', 6);

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_date` datetime DEFAULT current_timestamp(),
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `reply` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_info`
--

CREATE TABLE `shipping_info` (
  `id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `map_location` text DEFAULT NULL,
  `municipality` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `shipping_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_info`
--

INSERT INTO `shipping_info` (`id`, `address`, `street_address`, `map_location`, `municipality`, `email`, `shipping_amount`, `created_at`) VALUES
(165, 'Atop-atop', NULL, NULL, 'Bantayan', '', 110.00, '2024-11-10 11:07:10'),
(166, 'Baigad', NULL, NULL, 'Santa Fe', '', 1100.00, '2024-11-22 13:23:21'),
(186, 'Tarong', NULL, NULL, 'Madridejos', '', 70.00, '2024-11-19 10:19:41'),
(190, 'Malbago', NULL, NULL, 'Madridejos', '', 120.00, '2024-11-19 10:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'M&M Cake Ordering System', 'erica204chavez@gmail.com', '+639158259643', '1729917480_bg.jpg', '&lt;h1 style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;span style=&quot;color:rgb(68,68,68);text-align: center; background: transparent; position: relative;&quot;&gt;&lt;h1&gt;&lt;span style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68);&quot;&gt;&lt;sup style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68);&quot;&gt;&lt;b style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68);&quot;&gt;ABOUT US&lt;/b&gt;&lt;/sup&gt;&lt;/span&gt;&lt;/h1&gt;&lt;h1&gt;&lt;span style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68);&quot;&gt;&lt;sup style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68);&quot;&gt;&amp;nbsp;&lt;/sup&gt;&lt;/span&gt;&lt;/h1&gt;&lt;/span&gt;&lt;span style=&quot;font-size:20px;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68);&quot;&gt;&lt;span style=&quot;color: rgb(68, 68, 68); text-align: center; background: transparent; position: relative; font-size: 20px;&quot;&gt;&lt;h1 style=&quot;font-size: 20px;&quot;&gt;&lt;span style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68); font-size: 20px;&quot;&gt;&lt;sup style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68); font-size: 20px;&quot;&gt;&lt;/sup&gt;&lt;/span&gt;&lt;/h1&gt;&lt;/span&gt;&lt;span style=&quot;font-size: 24px; text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68);&quot;&gt;&lt;span style=&quot;color: rgb(68, 68, 68); text-align: center; background: transparent; position: relative; font-size: 24px;&quot;&gt;&lt;h1 style=&quot;font-size: 24px;&quot;&gt;&lt;span style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&lt;sup style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&lt;b style=&quot;text-align: center; background: transparent; position: relative; color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;Welcome to the M&amp;amp;M Cake Ordering System, home of beautifully tasty cakes, an unforgettable cake for every one! We at M&amp;amp;M believe that every occasion is of the highest importance: Celebrate with a cake as exceptional and unique as you. Our selection of beautifully crafted cakes is perfect for your special occasions, whether it&rsquo;s celebrating a birthday, wedding, anniversary - you name it.&lt;/b&gt;&lt;/sup&gt;&lt;/span&gt;&lt;/h1&gt;&lt;h3 style=&quot;font-size: 24px;&quot;&gt;&lt;b style=&quot;font-size: 24px;&quot;&gt;&lt;sup style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;br style=&quot;font-size: 24px;&quot;&gt;&lt;/sup&gt;&lt;sup style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&amp;nbsp; &amp;nbsp;&lt;sup style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&lt;/sup&gt;&lt;/sup&gt;&lt;/b&gt;&lt;/h3&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&lt;span style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&lt;span style=&quot;font-size: 24px; color: rgb(68, 68, 68);&quot;&gt;&lt;span style=&quot;color: rgb(68, 68, 68); text-align: center; background: transparent; position: relative; font-size: 24px;&quot;&gt;&lt;h3 style=&quot;font-size: 24px;&quot;&gt;&lt;b style=&quot;font-size: 24px;&quot;&gt;&lt;sup style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&lt;sup style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt; The story of M&amp;amp;M started in the 1980s with a love of baking and a dedication to perfection. The name &quot;M&amp;amp;M&quot; stands for &quot;Money and Millions,&quot; symbolizing our commitment to delivering value and abundance in every creation we make.&lt;br style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&lt;/sup&gt;&lt;/sup&gt;&lt;sup style=&quot;font-size: 24px;&quot;&gt;&lt;span style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&amp;nbsp; &amp;nbsp;&amp;nbsp;&lt;br style=&quot;font-size: 24px;&quot;&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&amp;nbsp; &amp;nbsp; We pride ourselves on selecting only the best ingredients, meaning that every cake we make not only looks amazing but tastes delicious too. Our talented bakers and decorators bring some of your favorite classic flavors to new heights, as well as one-of-a-kind creations inspired by your sweetest visions.&lt;/span&gt;&lt;/sup&gt;&lt;/b&gt;&lt;/h3&gt;&lt;/span&gt;&lt;p style=&quot;text-align: center; font-size: 24px;&quot;&gt;&lt;/p&gt;&lt;/span&gt;&lt;p style=&quot;text-align: center; font-size: 24px;&quot;&gt;&lt;/p&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(68, 68, 68); font-size: 24px;&quot;&gt;&lt;p style=&quot;text-align: center; font-size: 24px;&quot;&gt;&lt;/p&gt;&lt;/span&gt;&lt;span style=&quot;color: rgb(68, 68, 68); font-size: 16px;&quot;&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;&lt;/span&gt;&lt;/h1&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=admin , 2 = staff',
  `profile_picture` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_code` varchar(6) DEFAULT NULL,
  `reset_code_expiry` datetime DEFAULT NULL,
  `temp_reset_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`, `profile_picture`, `email`, `reset_token`, `reset_code`, `reset_code_expiry`, `temp_reset_token`) VALUES
(1, 'Erica Adlit', 'manilyndemesa87@gmail.com', '$2y$10$.QbcPGWlsgqMPJz1uJOc1eS1Z54DXEt6E6Lc.So/05X/YYAG/S4J2', 1, NULL, 'manilyndemesa87@gmail.com', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` varchar(300) NOT NULL,
  `municipality` varchar(100) NOT NULL,
  `active` tinyint(1) DEFAULT 0,
  `code` int(11) NOT NULL,
  `reset_time` time NOT NULL,
  `otp` int(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `token` varchar(100) NOT NULL,
  `token_expiry` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `address`, `municipality`, `active`, `code`, `reset_time`, `otp`, `otp_expiry`, `token`, `token_expiry`) VALUES
(45, 'Erica', 'Adlit', 'manilyndemesa87@gmail.com', '$2y$10$VC0PQHyiBir4.NSDYR1Cie.Psw2mbz3ra4/ZNf0U1crNGWM6y42jy', '6391582596', 'malbago', 'malbago', 1, 20473, '00:00:00', NULL, NULL, '', '2024-11-22 22:26:01'),
(47, 'keneth', 'ducay', 'kenethducay12@gmail.com', '$2y$10$TVlye7D2yxI9th63R2wqnOAryk7lIZMHWw704MjYBWN.u2lRlw/Im', '6391582963', 'Atop-atop', 'Atop-atop', 1, 895985, '00:00:00', NULL, NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE `user_messages` (
  `message_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `message_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_reply` text DEFAULT NULL,
  `reply_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_details`
--
ALTER TABLE `delivery_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_reference` (`type`,`reference_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status_logs`
--
ALTER TABLE `order_status_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `order_tracking`
--
ALTER TABLE `order_tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indexes for table `shipping_info`
--
ALTER TABLE `shipping_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `address` (`address`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `delivery_details`
--
ALTER TABLE `delivery_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `order_status_logs`
--
ALTER TABLE `order_status_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_tracking`
--
ALTER TABLE `order_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_info`
--
ALTER TABLE `shipping_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_messages`
--
ALTER TABLE `user_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_status_logs`
--
ALTER TABLE `order_status_logs`
  ADD CONSTRAINT `order_status_logs_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `order_tracking`
--
ALTER TABLE `order_tracking`
  ADD CONSTRAINT `order_tracking_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD CONSTRAINT `product_ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`),
  ADD CONSTRAINT `product_ratings_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
