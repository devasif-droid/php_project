-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 18, 2025 at 10:11 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_form`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message` varchar(600) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `address`, `message`) VALUES
(1, 'Asif', 'asif000540@gmail.com', 'Himachal', 'Testing'),
(2, 'User', 'abc123@gmail.com', 'pb', 'hi'),
(3, 'Mohammed Asif', 'wmasif@gmail.com', 'Hamirpur Himachal', 'Please approve my request to delete my account'),
(4, 'Mohammed Asif', 'wmasif@gmail.com', 'Hamirpur Himachal', 'Please approve my request to delete my account'),
(5, 'check1', 'check@gmail.com', 'California USA', 'Testing '),
(6, 'd', 'asifdev0011@gmail.com', 'd', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`(250))
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
(2, 'check@gmail.com', '9e9d1977bcd6a3d158860b899534dc13b4c6e441fc42c1f8837111aa60aa1f0f', '2025-06-15 11:28:56', '2025-06-14 11:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8mb4_general_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `term_accepted` tinyint(1) NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `password`, `gender`, `country`, `term_accepted`, `profile_picture`) VALUES
(1, 'Asif', 'asif000540@gmail.com', '$2y$10$YQOCAHTz5orSWdUeV.Wx8OX3DhY1z5Tne4j/OKNRNYoiy0cEaKhuW', 'Male', 'INDIA', 1, NULL),
(2, 'User', 'user01@gmail.com', '$2y$10$inRIXsKKiu3PnPx8Z4gJVefG3Snk/PUsaVcLaOAdsbSRwW156fI52', 'Female', 'USA', 1, NULL),
(3, 'user', 'user@gmail.com', '$2y$10$xWgtO2guXMeQTmjPuvbPi.DdneRKK2xhthSmtneBeAmc4.ajGn40G', 'Female', 'USA', 1, NULL),
(4, 'Aaron Swartz', 'swartz1@gmail.com', '$2y$10$CAQVZdL8FZAnwIWizUFzIuELKvwE9mLiLhapqBD1GyhXD6LUeSEKu', 'Male', 'USA', 1, NULL),
(5, 'check1', 'check@gmail.com', '$2y$10$QP.liSJLJiysx8l4E0GFKOHp.dtm/4zr1i2JBI.BgGAK6b183zlre', 'Male', 'USA', 1, 'uploads/profile_pictures/profile_5_1749034442.png'),
(6, 'Mohammed Asif', 'wmasif@gmail.com', '$2y$10$6RPfa7tZBAxj27sumA2Abuk7TYzBq53BbdiF8r.SWZB1ABgWSYg0.', 'Male', 'INDIA', 1, 'uploads/profile_pictures/profile_6_1749467229.jpg'),
(8, 'ASIF', 'asifdev0011@gmail.com', '$2y$10$FATq2HIXDK6/DhXJ03yyd.skeBACwDLmeyPronXlmIQZl3vWnm8kq', 'Male', 'INDIA', 1, 'uploads/profile_pictures/profile_8_1749899859.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
