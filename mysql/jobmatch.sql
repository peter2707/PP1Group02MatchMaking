-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2021 at 07:49 AM
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
  `position` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `position`) VALUES
(1, 'Zak', 'Brown', 'admin', 'admin', '2021-09-14', 1231231, 'admin@gmail.com', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `position` text NOT NULL,
  `company` text NOT NULL,
  `experience` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `institution` text NOT NULL,
  `degree` text NOT NULL,
  `graduation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `location` text NOT NULL,
  `rating` double(2,1) DEFAULT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `position`, `location`, `rating`, `image`) VALUES
(7, 'Mark', 'Zuckerberg', 'Mark123', 'Mark123', '2021-10-06', '123123123', 'mark123@gmail.com', 'CEO Facebook', 'South Australia', NULL, NULL),
(8, 'Elon', 'Musk', 'Elonmusk123', 'Elonmusk123', '2021-09-29', '123123123', 'elonmusk123@gmail.com', 'CEO Tesla', 'New South Wales', NULL, NULL),
(9, 'Bill', 'Gates', 'Billgate123', 'Billgate123', '2021-10-14', '1231231', 'billgate123@gmail.com', 'CEO Microsoft', 'Australian Capital Territory', NULL, NULL);
INSERT INTO `employer` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `position`, `location`, `rating`, `image`) VALUES
(11, 'Jane', 'Doe', 'JaneDoe123', 'JaneDoe123', '2021-11-01', '1231231', 'janedoe123@gmail.com', 'CEO', 'New South Wales', NULL, NULL);

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
  `rating` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobpost`
--

CREATE TABLE `jobpost` (
  `id` int(11) NOT NULL,
  `position` text NOT NULL,
  `field` text NOT NULL,
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

INSERT INTO `jobpost` (`id`, `position`, `field`, `salary`, `type`, `description`, `requirements`, `location`, `employer`, `contact`, `date`) VALUES
(16, 'Accountant', 'Banking & Financial Services', '$30-$35/hr', 'Full Time', '', '', 'Australian Capital Territory', 'JaneDoe123', 'janedoe@gmail.com', '2021-11-05 06:35:29'),
(17, 'Manager', 'Accounting', '$55-$60/hr', 'Contract', '', '', 'South Australia', 'JaneDoe123', 'janedoe@gmail.com', '2021-11-05 06:38:41'),
(18, 'Mechatronics Electrical Engineer', 'Arts & Media', '$45-$50/hr', 'Casual', '', '', 'Australian Capital Territory', 'JaneDoe123', 'janedoe@gmail.com', '2021-11-05 06:39:15'),
(19, 'Data Analyst', 'Administration', '$35-$40/hr', 'Part Time', '', '', 'South Australia', 'JaneDoe123', 'janedoe@gmail.com', '2021-11-05 06:39:35');

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
  `location` text NOT NULL,
  `image` mediumblob DEFAULT NULL,
  `resume` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobseeker`
--

INSERT INTO `jobseeker` (`id`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `phone`, `email`, `field`, `location`, `image`, `resume`) VALUES
(14, 'Lewis', 'Hamilton', 'Lewis444', 'Lewis444', '2021-11-11', '123123123', 'lewishamilton@gmail.com', 'Hospitality & Tourism', 'Australian Capital Territory', NULL, NULL),
(15, 'Max', 'Verstappen', 'Max3333', 'Max3333', '2021-11-23', '123123123', 'maxverstappen@gmail.com', 'Human Resource', 'New South Wales', NULL, NULL),
(16, 'Monkolsophearith', 'Prum', 'Peter2707', 'Peter2707', '2021-11-25', '123123123', 'prummonkolsophearith@gmail.com', 'Hospitality & Tourism', 'Tasmania', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `token` text NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id`, `email`, `token`, `expDate`) VALUES
(6, 'prummonkolsophearith@gmail.com', 'e1982477c68fffd4fb3af3d2ab890cda', '2021-11-06 07:00:07'),
(7, 'janedoe123@gmail.com', 'c8a8fdabe3e355a21d3cb8987df1c403', '2021-11-06 07:00:21');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `type` text NOT NULL,
  `matchID` int(11) NOT NULL,
  `reason` text NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `skill` text NOT NULL,
  `experience` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `social`
--

CREATE TABLE `social` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `linkedin` text NOT NULL,
  `github` text NOT NULL,
  `twitter` text NOT NULL,
  `instagram` text NOT NULL,
  `facebook` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `social`
--

INSERT INTO `social` (`id`, `username`, `linkedin`, `github`, `twitter`, `instagram`, `facebook`) VALUES
(5, 'JaneDoe123', 'Not added', 'Not added', 'Not added', 'Not added', 'Not added');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
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
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social`
--
ALTER TABLE `social`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `employer`
--
ALTER TABLE `employer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobmatch`
--
ALTER TABLE `jobmatch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `jobpost`
--
ALTER TABLE `jobpost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `jobseeker`
--
ALTER TABLE `jobseeker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `social`
--
ALTER TABLE `social`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
