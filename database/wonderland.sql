-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 06, 2024 at 09:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wonderland`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`) VALUES
('admin@wonderland.com', 'root');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `cashondelivery` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) DEFAULT NULL,
  `owner_email` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `tr_receipt` varchar(255) DEFAULT NULL,
  `delivery_status` varchar(255) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `fullname`, `email`, `address`, `city`, `state`, `zip`, `cashondelivery`, `created_at`, `total_price`, `owner_email`, `status`, `tr_receipt`, `delivery_status`) VALUES
(34, 'Shahid', 'abdulrehman@gmail.com', 'asldkjakls', 'rwp', 'pnj', '46000', 1, '2024-06-21 06:43:51', 2300.00, 'abdulrehman@gmail.com', 'Approved', NULL, 'shipped'),
(35, 'Shahid', 'abdulrehman@gmail.com', 'asldkjakls', 'rwp', 'pnj', '46000', 1, '2024-06-23 14:29:05', 1200.00, 'abdulrehman@gmail.com', 'Pending', NULL, 'pending'),
(36, 'Abdulrehman', 'abc@gmail.com', 'Islamabad, Federal', 'Rawalpindi', 'Punjab', '12312', 1, '2024-06-26 19:43:49', 3600.00, 'abdulrehman@gmail.com', 'Rejected', 'WhatsApp Image 2024-06-23 at 14.15.29.jpeg', 'pending'),
(37, 'Abdulrehman', 'abc@gmail.com', 'Islamabad, Federal', 'Rawalpindi', 'Punjab', '12344', 1, '2024-06-26 20:00:02', 1200.00, 'abdulrehman@gmail.com', 'Approved', 'WhatsApp Image 2024-06-23 at 14.15.29.jpeg', 'shipped'),
(38, 'Abdulrehman', 'abc@gmail.com', 'Islamabad, Federal', 'Rawalpindi', 'Punjab', '46000', 1, '2024-07-06 17:06:42', 1200.00, 'abdulrehman@gmail.com', 'Approved', '3c9d3584157b3976ee3ac37eb19f2fe6.jpg', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_price`, `product_quantity`) VALUES
(21, 34, 26, 'Black Long Frock', 2300.00, 1),
(22, 35, 7, 'White Casual T-Shirt', 1200.00, 1),
(23, 36, 7, 'White Casual T-Shirt', 1200.00, 1),
(24, 36, 7, 'smajdklajsd', 1200.00, 1),
(25, 36, 7, 'White Casual T-Shirt', 1200.00, 1),
(26, 37, 7, 'White Casual T-Shirt', 1200.00, 1),
(27, 38, 41, 'Shirt', 1200.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `p_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `p_condition` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filename2` varchar(255) NOT NULL,
  `filename3` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `feedback` text NOT NULL DEFAULT 'N/A'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `email`, `category`, `type`, `p_name`, `description`, `p_condition`, `price`, `filename`, `filename2`, `filename3`, `status`, `feedback`) VALUES
(7, 'abdulrehman@gmail.com', 'Men', 'Shirts', 'White Casual T-Shirt', '100% Cotton White Casual Shirt for Daily \r\n', 'Good', 1200, '3c9d3584157b3976ee3ac37eb19f2fe6.jpg', '', '', 'Approved', 'N/A'),
(27, 'abdullahmuhhamad339@gmail.com', 'Men', 'Shirts', 'Black Shirt', 'Black T-shirt for casual use', 'Good', 1200, '3c9d3584157b3976ee3ac37eb19f2fe6.jpg', '', '', 'Approved', 'N/A'),
(26, 'abdulrehman@gmail.com', 'Women', 'Frocks', 'Black Long Frock', 'Black long frock for women', 'Good', 2300, 'MF-31.jpg', '', '', 'Approved', 'N/A'),
(41, 'abdulrehman@gmail.com', 'Men', 'Shirts', 'Shirt', 'Black Shirt', 'Excellent', 1200, '3c9d3584157b3976ee3ac37eb19f2fe6.jpg', 'DS-14.jpg', '6cd89aa0a4f5332635198f49b1d8a453.jpg', 'Approved', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `rating` decimal(10,1) DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `contact`, `dob`, `rating`) VALUES
(1, 'Abdulrehman', 'abdulrehman@gmail.com', '1234', '+92-311-5369301', '2024-04-03', 4.0),
(2, 'Abdullah Sheikh', 'abdullahmuhhamad339@gmail.com', '1234', NULL, NULL, 0.0),
(3, 'abdullah', 'abc@gmail.com', '12345', NULL, NULL, 0.0);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
