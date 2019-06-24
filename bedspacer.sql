-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2019 at 10:56 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bedspacer`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_calculation`
--

CREATE TABLE `bill_calculation` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `electricity_kwh_before` float NOT NULL,
  `electricity_kwh_current` float NOT NULL,
  `water_bill` tinyint(1) NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `parking_fee` tinyint(1) NOT NULL,
  `month` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill_calculation`
--

INSERT INTO `bill_calculation` (`id`, `tenant_id`, `electricity_kwh_before`, `electricity_kwh_current`, `water_bill`, `discount`, `parking_fee`, `month`) VALUES
(2, 18, 0, 0, 100, 0, 1, 'June'),
(3, 19, 2, 2, 100, 0, 1, 'June'),
(4, 20, 0, 0, 100, 0, 1, 'June');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int(11) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `occupied` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `room_value` float NOT NULL,
  `electricity_kwh` float NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `room_number`, `occupied`, `capacity`, `room_value`, `electricity_kwh`, `is_active`) VALUES
(1, 'RM-101', 2, 2, 1600, 0, 1),
(2, 'RM-102', 1, 2, 1600, 2, 1),
(3, 'RM-103', 0, 2, 1600, 0, 1),
(4, 'RM-104', 0, 2, 1600, 0, 1),
(5, 'RM-105', 0, 2, 1600, 0, 1),
(6, 'RM-106', 0, 2, 1600, 0, 1),
(7, 'RM-107', 0, 2, 1600, 0, 1),
(8, 'RM-108', 0, 2, 1600, 0, 1),
(9, 'RM-109', 0, 2, 1600, 0, 1),
(10, 'RM-110', 0, 2, 1600, 0, 1),
(11, 'RM-111', 0, 2, 1600, 0, 1),
(12, 'RM-112', 0, 2, 1600, 0, 1),
(13, 'RM-201', 0, 2, 1800, 0, 1),
(14, 'RM-202', 0, 2, 1800, 0, 1),
(15, 'RM-203', 0, 2, 1800, 0, 1),
(16, 'RM-204', 0, 2, 1800, 0, 1),
(17, 'RM-205', 0, 2, 1800, 0, 1),
(18, 'RM-206', 0, 2, 1800, 0, 1),
(19, 'RM-207', 0, 2, 1800, 0, 1),
(20, 'RM-208', 0, 2, 1800, 0, 1),
(21, 'RM-209', 0, 2, 1800, 0, 1),
(22, 'RM-210', 0, 2, 1800, 0, 1),
(23, 'RM-211', 0, 2, 1800, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `board_date` date NOT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`id`, `room_id`, `first_name`, `last_name`, `phone_number`, `board_date`, `payment_status`, `is_active`) VALUES
(18, 1, 'Bill', 'Kim', '09203234783', '2019-06-24', 1, 1),
(19, 2, 'wqefwe', 'fwefwe', '09203234783', '2019-06-24', 1, 1),
(20, 1, 'jull', 'Kim', '09203234783', '2019-06-24', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `bill_calculation_id` int(11) NOT NULL,
  `date_paid` date NOT NULL,
  `due_date` date NOT NULL,
  `total_amount` float NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`id`, `tenant_id`, `bill_calculation_id`, `date_paid`, `due_date`, `total_amount`, `type`) VALUES
(1, 20, 4, '2019-06-24', '2019-06-24', 24, 'Initial Payment');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`) VALUES
(1, 'jong', 'jong', 'jong yun kim');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill_calculation`
--
ALTER TABLE `bill_calculation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill_calculation`
--
ALTER TABLE `bill_calculation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
