-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2024 at 09:32 PM
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
('Abdullah Sheikh', 'abdullahmuhhamad95@yahoo.com', '$2y$10$CuovZG8KE1Q/isn.NEzzsu4Ye0NbIMXUaJiMfUKOBAhkZ.1Qw72b2'),
('Abdullah Sheikh', 'abdullahmuhhamad95@yahoo.com', '$2y$10$/iUF/ZiCgloyoT13777jLeP38nMWVOVjB89catdVwvVrJzz1KyPGC'),
('Abdullah Sheikh', 'Coursehero256@gmail.com', ''),
('Abdullah Sheikh', 'Coursehero256@gmail.com', '1234'),
('Abdullah Sheikh', 'Coursehero256@gmail.com', '1234'),
('Abdullah Sheikh', 'Coursehero256@gmail.com', '1234'),
('Abdullah Sheikh', 'Coursehero256@gmail.com', '1234'),
('Abdullah Sheikh', 'Coursehero256@gmail.com', '1234');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
