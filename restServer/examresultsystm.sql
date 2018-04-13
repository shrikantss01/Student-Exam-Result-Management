-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2018 at 04:15 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
  `math` decimal(5,2) DEFAULT '0.00',
  `sci` decimal(5,2) DEFAULT '0.00',
  `eng` decimal(5,2) NOT NULL DEFAULT '0.00',
  `created_by` varchar(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_students_marks`
--

INSERT INTO `tbl_students_marks` (`id`, `student_name`, `age`, `math`, `sci`, `eng`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'test', '34', '50.00', '45.00', '50.00', NULL, '2018-04-11 16:10:29', NULL, NULL),
(2, 'test test', '45', '50.00', '60.00', '55.00', NULL, '2018-04-11 16:11:27', NULL, NULL),
(3, 'sdsfdsfs a', '34', '45.00', '45.00', '57.00', NULL, '2018-04-11 18:36:12', NULL, NULL);

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
(1, 'admin', '098f6bcd4621d373cade4e832627b4f6', 'admin', 'test@sfsd.in', '7qF0CobM4Jo4hnGnKlkKKmN8G8eefCN0', 'ICy8jdZUIQDFCNnhFEpSpMNFJwWu6rvA', NULL, '2018-04-08 09:34:26'),
(2, 'demo', '098f6bcd4621d373cade4e832627b4f6', 'demo', 'demo@test.com', NULL, NULL, 'FCV4RS', '2018-04-08 18:20:01'),
(3, 'shri', 'test', 'shri', 'shri@test.com', NULL, NULL, '', '2018-04-11 09:09:31'),
(4, 'shri1', 'test', 'shrione', 'shri1@gmail.com', NULL, NULL, '', '2018-04-11 09:46:26');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
