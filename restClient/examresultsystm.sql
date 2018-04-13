-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2018 at 07:23 PM
-- Server version: 5.7.21-0ubuntu0.17.10.1
-- PHP Version: 7.1.15-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examresultsystm`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students_marks`
--

CREATE TABLE `tbl_students_marks` (
  `id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `age` varchar(2) NOT NULL,
  `math` smallint(3) NOT NULL DEFAULT '0',
  `sci` smallint(3) NOT NULL DEFAULT '0',
  `eng` smallint(3) NOT NULL DEFAULT '0',
  `created_by` varchar(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_students_marks`
--

INSERT INTO `tbl_students_marks` (`id`, `student_name`, `age`, `math`, `sci`, `eng`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'test', '34', 50, 45, 50, NULL, '2018-04-11 16:10:29', NULL, NULL),
(2, 'test', '35', 50, 45, 50, NULL, '2018-04-11 16:11:27', NULL, '2018-04-12 10:43:53'),
(3, 'sdsfdsfs a', '34', 45, 45, 57, NULL, '2018-04-11 18:36:12', NULL, '2018-04-12 10:55:52'),
(4, 'testss', '34', 50, 70, 60, NULL, '2018-04-12 10:56:46', NULL, NULL),
(5, 'testssmm', '34', 50, 70, 60, NULL, '2018-04-12 10:57:43', NULL, '2018-04-12 11:09:29'),
(6, 'test', '23', 45, 45, 45, NULL, '2018-04-12 11:39:46', NULL, NULL),
(7, 'sdfsd', '23', 34, 354, 45, NULL, '2018-04-12 12:28:00', NULL, NULL),
(8, 'sdf', '34', 34, 45, 34, NULL, '2018-04-12 12:28:26', NULL, NULL),
(9, 'fsdfsd', '45', 34, 2342, 23423, NULL, '2018-04-12 12:29:39', NULL, NULL),
(10, 'fsdfsdd', '45', 34, 2342, 23423, NULL, '2018-04-12 12:30:09', NULL, '2018-04-12 13:06:44'),
(11, 'testtttxxx', '34', 60, 87, 68, NULL, '2018-04-12 13:10:27', NULL, '2018-04-12 13:13:28'),
(12, 'dfsd', '45', 59, 58, 45, NULL, '2018-04-12 13:14:03', NULL, NULL),
(13, 'sdfsdee', '50', 43, 33, 33, NULL, '2018-04-12 13:17:57', NULL, '2018-04-12 13:18:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `authKey` varchar(250) DEFAULT NULL,
  `accessToken` varchar(250) DEFAULT NULL,
  `user_code` enum('FCV4RS','WE32MN') DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `name`, `email`, `authKey`, `accessToken`, `user_code`, `created_date`) VALUES
(1, 'admin', '098f6bcd4621d373cade4e832627b4f6', 'admin', 'test@sfsd.in', '7qF0CobM4Jo4hnGnKlkKKmN8G8eefCN0', 'FkHQClHtWogaxbJCwnGfRaRXIkDYsEqZ', 'WE32MN', '2018-04-08 09:34:26'),
(2, 'teacher', '098f6bcd4621d373cade4e832627b4f6', 'teacher', 'teacher@test.com', NULL, 'sg8ZWmcd0bC_ZsT6XrqSNnBhwYT2IIGf', 'FCV4RS', '2018-04-08 18:20:01'),
(6, 'student', '098f6bcd4621d373cade4e832627b4f6', 'student', 'student@test.com', NULL, 'Xf2IJ7aXGW7xnGQQQgMJfIgqICAhrvp3', NULL, '2018-04-12 12:10:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_students_marks`
--
ALTER TABLE `tbl_students_marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_students_marks`
--
ALTER TABLE `tbl_students_marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
