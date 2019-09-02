-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2019 at 05:40 AM
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
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills_calculation`
--

CREATE TABLE `bills_calculation` (
  `id` int(11) NOT NULL,
  `month_before_kwh` float NOT NULL,
  `month_current_kwh` float NOT NULL,
  `total_payment_kwh` int(11) NOT NULL,
  `water_bill` int(11) NOT NULL,
  `monthly_payment` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bills_calculation`
--

INSERT INTO `bills_calculation` (`id`, `month_before_kwh`, `month_current_kwh`, `total_payment_kwh`, `water_bill`, `monthly_payment`, `tenant_id`) VALUES
(37, 6, 6, 0, 100, 1600, 25),
(38, 6, 6, 0, 100, 800, 25),
(39, 6, 6, 0, 100, 1600, 26),
(40, 6, 6, 0, 100, 800, 26),
(41, 3, 3, 0, 100, 1600, 27),
(42, 3, 3, 0, 100, 800, 27),
(43, 12, 12, 0, 100, 1600, 28),
(44, 12, 12, 0, 100, 800, 28),
(45, 3, 3, 0, 100, 5000, 29),
(46, 3, 3, 0, 100, 2500, 29),
(47, 98, 98, 0, 100, 1800, 30),
(48, 98, 98, 0, 100, 900, 30),
(49, 0, 0, 0, 100, 1600, 31),
(50, 0, 0, 0, 100, 800, 31),
(51, 3, 3, 0, 100, 1600, 32),
(52, 3, 3, 0, 100, 800, 32),
(53, 12, 12, 0, 100, 1800, 33),
(54, 12, 12, 0, 100, 900, 33),
(55, 0, 0, 0, 100, 1600, 34),
(56, 0, 0, 0, 100, 800, 34);

-- --------------------------------------------------------

--
-- Table structure for table `monitor_payment_status`
--

CREATE TABLE `monitor_payment_status` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `bills_calculation_id` int(11) NOT NULL,
  `date_paid` date NOT NULL,
  `actual_due_date` date NOT NULL,
  `actual_due_day_monthly` int(11) NOT NULL,
  `total_amount_paid` int(11) NOT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `month` varchar(50) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `monitor_payment_status`
--

INSERT INTO `monitor_payment_status` (`id`, `tenant_id`, `bills_calculation_id`, `date_paid`, `actual_due_date`, `actual_due_day_monthly`, `total_amount_paid`, `payment_status`, `month`, `year`) VALUES
(19, 25, 37, '2019-06-11', '2019-06-11', 11, 1700, 1, 'June', 2019),
(20, 25, 38, '0000-00-00', '2019-06-23', 11, 900, 0, 'July', 2019),
(21, 26, 39, '2019-06-11', '2019-06-11', 11, 1700, 1, 'June', 2019),
(22, 26, 40, '0000-00-00', '2019-07-11', 11, 900, 0, 'July', 2019),
(23, 27, 41, '2019-06-11', '2019-06-11', 11, 1700, 1, 'June', 2019),
(24, 27, 42, '0000-00-00', '2019-07-11', 11, 900, 0, 'July', 2019),
(25, 28, 43, '2019-06-13', '2019-06-13', 13, 1700, 1, 'June', 2019),
(26, 28, 44, '0000-00-00', '2019-07-13', 13, 900, 0, 'July', 2019),
(27, 29, 45, '2019-06-13', '2019-06-13', 13, 5100, 1, 'June', 2019),
(28, 29, 46, '0000-00-00', '2019-07-13', 13, 2600, 0, 'July', 2019),
(29, 30, 47, '2019-06-13', '2019-06-13', 13, 1900, 1, 'June', 2019),
(30, 30, 48, '0000-00-00', '2019-07-13', 13, 1000, 0, 'July', 2019),
(31, 31, 49, '2019-11-07', '2019-11-07', 7, 1700, 1, 'November', 2019),
(32, 31, 50, '0000-00-00', '2019-12-07', 7, 900, 0, 'December', 2019),
(33, 32, 51, '2019-06-13', '2019-06-13', 13, 1700, 1, 'June', 2019),
(34, 32, 52, '0000-00-00', '2019-07-13', 13, 900, 0, 'July', 2019),
(35, 33, 53, '2019-06-13', '2019-06-13', 13, 1900, 1, 'June', 2019),
(36, 33, 54, '0000-00-00', '2019-07-13', 13, 1000, 0, 'July', 2019),
(37, 34, 55, '2019-06-13', '2019-06-13', 13, 1700, 1, 'June', 2019),
(38, 34, 56, '0000-00-00', '2019-07-13', 13, 900, 0, 'July', 2019);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_no` varchar(100) NOT NULL,
  `room_occupied` int(11) NOT NULL,
  `room_capacity` int(11) NOT NULL,
  `room_value` int(11) NOT NULL,
  `floor` int(1) NOT NULL,
  `current_electricity_kwh` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_no`, `room_occupied`, `room_capacity`, `room_value`, `floor`, `current_electricity_kwh`) VALUES
(1, 'RM-101', 2, 2, 1600, 1, 3),
(2, 'RM-102', 1, 2, 1600, 1, 6),
(3, 'RM-103', 1, 2, 1600, 1, 0),
(4, 'RM-104', 1, 2, 1600, 1, 12),
(5, 'RM-105', 1, 2, 1600, 1, 3),
(6, 'RM-106', 1, 2, 1600, 1, 0),
(7, 'RM-107', 0, 2, 1600, 1, 0),
(8, 'RM-108', 0, 2, 1600, 1, 0),
(9, 'RM-109', 0, 2, 1600, 1, 0),
(10, 'RM-110', 0, 2, 1600, 1, 0),
(11, 'RM-111', 0, 2, 1600, 1, 0),
(12, 'RM-112', 0, 2, 1600, 1, 0),
(13, 'RM-201', 1, 2, 1800, 2, 12),
(14, 'RM-202', 1, 2, 1800, 2, 98),
(15, 'RM-203', 0, 2, 1800, 2, 0),
(16, 'RM-204', 0, 2, 1800, 2, 0),
(17, 'RM-205', 0, 2, 1800, 2, 0),
(18, 'RM-206', 0, 2, 1800, 2, 0),
(19, 'RM-207', 0, 2, 1800, 2, 0),
(20, 'RM-208', 0, 2, 1800, 2, 0),
(21, 'RM-209', 0, 2, 1800, 2, 0),
(22, 'RM-210', 0, 2, 1800, 2, 0),
(23, 'RM-211', 0, 2, 1800, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `room_id` varchar(11) NOT NULL,
  `phone_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `first_name`, `last_name`, `room_id`, `phone_number`) VALUES
(25, 'Bill', 'Pisot', '2', '09203234783'),
(26, 'Jong', 'Kim', '1', '09230540561'),
(27, 'webster', 'the great', '1', '09203234783'),
(28, 'Jong', 'efgwef', '4', '24213523'),
(29, 'Bill', 'Kim', '25', '09203234783'),
(30, 'Jong', 'efgwef', '14', '24213523'),
(31, '', '', '3', ''),
(32, 'Bill', 'Pisot', '5', '09203234783'),
(33, 'Jong', 'efgwef', '13', '24213523'),
(34, '', '', '6', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `fname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `fname`) VALUES
(1, '123@sample.com', '123', 'jong'),
(2, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills_calculation`
--
ALTER TABLE `bills_calculation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monitor_payment_status`
--
ALTER TABLE `monitor_payment_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills_calculation`
--
ALTER TABLE `bills_calculation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `monitor_payment_status`
--
ALTER TABLE `monitor_payment_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
