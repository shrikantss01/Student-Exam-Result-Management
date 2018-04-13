-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 13, 2018 at 06:53 PM
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
(1, 'student one', '25', 50, 45, 40, NULL, '2018-04-13 13:09:04', NULL, NULL),
(2, 'student two', '30', 50, 56, 34, NULL, '2018-04-13 13:09:25', NULL, NULL),
(3, 'student three', '45', 56, 54, 45, NULL, '2018-04-13 13:10:04', NULL, NULL),
(4, 'sdfsd', '15', 45, 10, 45, NULL, '2018-04-13 13:10:37', NULL, '2018-04-13 13:11:23');

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
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin@test.com', NULL, '', 'WE32MN', '2018-04-13 13:04:44'),
(2, 'teacher', '8d788385431273d11e8b43bb78f3aa41', 'teacher', 'teacher@test.com', NULL, '', 'FCV4RS', '2018-04-13 13:07:56'),
(3, 'student', 'cd73502828457d15655bbd7a63fb0bc8', 'student', 'student@test.com', NULL, '', NULL, '2018-04-13 13:12:36');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
