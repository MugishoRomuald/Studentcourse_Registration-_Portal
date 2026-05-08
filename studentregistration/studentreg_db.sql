-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 08, 2026 at 07:18 PM
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
-- Database: `studentreg_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `course_code` (`course_code`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_code`, `description`, `created_at`, `updated_at`) VALUES
(4, 'Bachelor of Science in InformationTechnology', '300', 'BSC IT is a 3-year program at our institution', '2026-05-06 12:15:58', '2026-05-07 18:50:36'),
(5, 'Bachelor of Science in Computer Science', '200', 'This is a 3-year program where students learn and gain skills in various take areas.', '2026-05-06 14:08:59', '2026-05-07 13:49:32'),
(6, 'Introduction to Programming', 'CS101', 'Learn fundamentals of programming using Python', '2026-05-06 15:22:56', '2026-05-06 15:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
CREATE TABLE IF NOT EXISTS `registrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `course_id` int NOT NULL,
  `status` enum('enrolled','dropped') DEFAULT 'enrolled',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`course_id`),
  KEY `course_id` (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `user_id`, `course_id`, `status`, `created_at`) VALUES
(1, '2', 5, 'enrolled', '2026-05-06 15:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student') DEFAULT 'student',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(2, 'Mugisho Muganga', 'mugishomunganga1@gmail.com', '$2y$10$gAeFmaW6h62MPFlRIPpJ9eJt4VCtUTlE9atd45ySd9hNtVl01mL0.', 'student', '2026-05-06 11:07:14', '2026-05-06 11:07:14'),
(4, 'Mugisho Munganga', 'mugishomunganga@gmail.com', '$2y$10$NOIeWZprvPLbt5em5.96hOhA0VxQh5F.8m5EBNTeZJsbauk/wU46O', 'admin', '2026-05-06 12:11:27', '2026-05-06 12:11:27'),
(7, 'Ninsiima Hellena', 'ninsiimahellena@gmail.com', '$2y$10$tOrvS9UFoWxhCh8AH43nNeFlo92jqY0SIki8UfczuKLBg6uvcFlje', 'student', '2026-05-07 13:40:53', '2026-05-07 13:40:53'),
(8, 'Ssemwogerere Ashiraf', 'ssemwogerere.ashiraf@stud.umu.ac.ug', '$2y$10$TFj7KRmiyturqjksEX5tt.wqzn8k.lx/EPGlzmM3cRQmNLsr3tAci', 'admin', '2026-05-07 18:45:07', '2026-05-07 18:45:07'),
(9, 'Kategere Alvin', 'alvink@gmail.com', '$2y$10$Yr3NnmykAcRUVEh11mZTzOdMguJozQ/qgppWguZePzMYBvMDdgkra', 'admin', '2026-05-07 18:47:55', '2026-05-07 18:47:55'),
(12, 'Ssemogerere Ashtraf', 'ssemogerere@gmail.com', '$2y$10$c/zYe.miIfO5khVAMppNiOx6L/gVEgH1e5tipcWbA3TsWjENtB0KC', 'student', '2026-05-08 18:59:01', '2026-05-08 18:59:01'),
(11, 'Birungi Christine', 'birungichristine@gmail.com', '$2y$10$dIXnu9kAgPm8BhNXI0XVSOwc/qGtGyPb2fVCNC3Ks/0nQmJ8e20xa', 'admin', '2026-05-08 12:45:38', '2026-05-08 12:45:38');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
