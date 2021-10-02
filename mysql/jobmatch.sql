-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2021 at 12:14 PM
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
(1, 'admin', 'admin', 'admin', 'admin', '2021-09-14', 123123, 'admin@gmail.com', 'admin', NULL),
(2, 'ddd', 'ddd', 'ddd', 'ddd', '2021-09-10', 123123, 'ddd@gmail.com', 'ad', NULL),
(3, 'ccc', 'ccc', 'ccc', 'ccc', '2021-09-23', 123123, 'ccc@gmail.com', 'ccc', NULL);

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
  `phone` int(11) NOT NULL,
  `email` text NOT NULL,
  `position` text NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `position`, `rating`, `image`) VALUES
(11, 'www', 'www', 'www', 'www', '2021-09-09', 111, 'www@gmail.com', 'www', 0, NULL);

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
(3, 'employer1', 'ggg', 0, 25, NULL, NULL),
(4, 'www', 'ggg', 1, 25, NULL, NULL),
(5, 'www', 'ggg', 1, 25, NULL, NULL),
(6, 'employer1', 'ggg', 0, 25, NULL, NULL),
(7, 'www', 'ggg', 1, 25, NULL, NULL),
(8, 'employer1', 'ggg', 0, 25, NULL, NULL),
(9, 'www', 'ggg', 1, 25, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobpost`
--

CREATE TABLE `jobpost` (
  `id` int(11) NOT NULL,
  `position` text NOT NULL,
  `salary` int(11) NOT NULL,
  `type` text NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `location` text NOT NULL,
  `employer` text NOT NULL,
  `contact` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobpost`
--

INSERT INTO `jobpost` (`id`, `position`, `salary`, `type`, `description`, `requirements`, `location`, `employer`, `contact`, `date`) VALUES
(0, 'Dev', 1000, 'fulltime', 'Melbourne Based job', '2 years exp', 'Melbourne', 'employer1', 12345, '2021-09-09 00:00:00'),
(1, 'test', 25, 'fulltime', 'ggg', 'dsfds', 'nsw', 'www', 123123, '2021-10-20 03:02:04');

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
  `phone` int(11) NOT NULL,
  `email` text NOT NULL,
  `field` text NOT NULL,
  `experience` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobseeker`
--

INSERT INTO `jobseeker` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `field`, `experience`, `Image`) VALUES
(12, 'see', 'see', 'see', 'see', '2021-09-17', 123123, 'see@gmail.com', 'Education & Training', NULL, NULL),
(17, 'ggg', 'ggg', 'ggg', 'ggg', '2021-09-15', 123123, 'ggg@gmail.com', 'Consulting', NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobmatch`
--
ALTER TABLE `jobmatch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobpost`
--
ALTER TABLE `jobpost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobseeker`
--
ALTER TABLE `jobseeker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
