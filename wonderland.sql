-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 11:05 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `filename` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`filename`, `email`, `p_name`, `description`, `price`) VALUES
('2.PNG', '', '', '', 0),
('2.PNG', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', '', '', '', 0),
('1c14ef3578336745957fd68079315cf3.jpg', 'abdulrehman@gmail.com', '', '2222', 100),
('1c14ef3578336745957fd68079315cf3.jpg', 'abdulrehman@gmail.com', '', '2222', 100),
('1c14ef3578336745957fd68079315cf3.jpg', 'abdulrehman@gmail.com', '', '2222', 100),
('2d5106a590622d204b9409880d9be0fe.jpg', 'abdulrehman@gmail.com', 'asdasda', 'asdasdaweqweqeq', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200),
('7bc300ca0bc86659f6663e2ea2fe61b8.jpg', 'abdulrehman@gmail.com', 'asdasda', 'ghsadkhasjhd', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`fullname`, `email`, `password`) VALUES
('AbdulRehman', 'abdulrehman@gmail.com', '1234');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
