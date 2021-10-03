-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2021 at 05:31 AM
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
-- Database: `jobmatch`
--
DROP DATABASE IF EXISTS jobmatch;
CREATE DATABASE jobmatch;
-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `dateOfBirth` date NOT NULL,
  `phone` int(11) NOT NULL,
  `email` text NOT NULL,
  `position` text NOT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `position`, `image`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', '2021-09-14', 123123, 'admin@gmail.com', 'admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE `employer` (
  `id` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `dateOfBirth` date NOT NULL,
  `phone` text NOT NULL,
  `email` text NOT NULL,
  `position` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `position`, `rating`, `image`) VALUES
(11, 'wwww', 'wwww', 'wwww', 'www', '2021-09-09', '111', 'www@gmail.com', 'www', 0, NULL),
(12, 'ggg', 'ggg', 'gggG1', 'ggg', '2021-10-07', '123123', 'ggg@gmail.com', 'ggg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobmatch`
--

CREATE TABLE `jobmatch` (
  `id` int(11) NOT NULL,
  `employer` text NOT NULL,
  `jobSeeker` text NOT NULL,
  `jobPostID` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `status` text DEFAULT NULL,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobmatch`
--

INSERT INTO `jobmatch` (`id`, `employer`, `jobSeeker`, `jobPostID`, `percentage`, `status`, `feedback`) VALUES
(6, 'www', 'ggg', 3, 25, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobpost`
--

CREATE TABLE `jobpost` (
  `id` int(11) NOT NULL,
  `position` text NOT NULL,
  `salary` text NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `location` text NOT NULL,
  `employer` text NOT NULL,
  `contact` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobpost`
--

INSERT INTO `jobpost` (`id`, `position`, `salary`, `type`, `description`, `requirements`, `location`, `employer`, `contact`, `date`) VALUES
(6, 'Asd', '25-30', 'casual', 'asd', 'asd', 'act', 'wwww', '1231231', '2021-10-03 03:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `jobseeker`
--

CREATE TABLE `jobseeker` (
  `id` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `dateOfBirth` date NOT NULL,
  `phone` text NOT NULL,
  `email` text NOT NULL,
  `field` text NOT NULL,
  `experience` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobseeker`
--

INSERT INTO `jobseeker` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `field`, `experience`, `Image`) VALUES
(25, 'Qweww', 'Qweww', 'qweG1', 'qweG1', '2021-10-21', '123123', 'qwe@gmail.com', 'Government & Defence', NULL, NULL),
(28, 'dfgfgfg', 'thfthth', 'hhh1111G', 'hhh1111G', '2021-10-28', '1231236', 'asd@gmail.com', 'Hospitality & Tourism', NULL, NULL),
(29, 'Ggg111G', 'Ggg111G', 'ggg111G', 'ggg111G', '2021-10-21', '433245898', 'ggg111G@gmail.com', 'Information Technology', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer`
--
ALTER TABLE `employer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobmatch`
--
ALTER TABLE `jobmatch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobpost`
--
ALTER TABLE `jobpost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobseeker`
--
ALTER TABLE `jobseeker`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobmatch`
--
ALTER TABLE `jobmatch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobpost`
--
ALTER TABLE `jobpost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jobseeker`
--
ALTER TABLE `jobseeker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
