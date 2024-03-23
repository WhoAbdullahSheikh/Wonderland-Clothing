-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 01:21 AM
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
-- Database: `tutorfinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`firstname`, `lastname`, `username`, `password`) VALUES
('Abdullah', 'Sheikh', 'admin', 'admin000');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`FirstName`, `LastName`, `UserName`, `Email`, `Password`) VALUES
('Abdullah', 'Sheikh', 'abdullah123', 'abdullah@gmail.com', '1111'),
('Abdullah', 'Sheikh', 'abdullah123', 'abdullah@gmail.com', '12343'),
('Abdullah', 'Sheikh', 'abdullah123', 'abdullah@gmail.com', '1234'),
('Abdullah', 'Sheikh', 'abdullah123', 'abdullah@gmail.com', '1111'),
('Abdullah', 'Sheikh', 'abdullah123', 'abdullah@gmail.com', '4444'),
('Abdullah', 'Sheikh', 'abdullah123', 'abdullah@gmail.com', '11111'),
('Abdullah', 'asdasd', 'abdullah123', 'abdullahmuhhamad339@gmail.com', '4444');

-- --------------------------------------------------------

--
-- Table structure for table `tutors`
--

CREATE TABLE `tutors` (
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tutors`
--

INSERT INTO `tutors` (`firstname`, `lastname`, `username`, `email`, `password`) VALUES
('abc', 'abc', 'abc123', 'abc@gmail.com', '12345'),
('abc', 'abc', 'abc123', 'abc@gmail.com', '11111'),
('Abdullah', 'Sheikh', 'abdullah123', 'abdullah@gmail.com', '44444'),
('Abdullah', 'asdasd', 'abdullah123', 'abdullahmuhhamad339@gmail.com', '123456'),
('Abdullah', 'Sheikh', 'abdullah123', 'abdullah@gmail.com', 'asdasd'),
('asdsad', 'asdad', 'qeqwe', 'abdullahmuhhamad339@gmail.com', '1323121312');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
