-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2020 at 05:50 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skhaftini`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ADMIN_ID` varchar(8) NOT NULL,
  `PASSWORD` varchar(12) NOT NULL,
  `NAME` varchar(30) NOT NULL,
  `SURNAME` varchar(30) NOT NULL,
  `NATIONAL_ID` int(10) NOT NULL,
  `PHONE_NUMBER` int(15) NOT NULL,
  `EMAIL` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ADMIN_ID`, `PASSWORD`, `NAME`, `SURNAME`, `NATIONAL_ID`, `PHONE_NUMBER`, `EMAIL`) VALUES
('JACK123', 'POIUYTREWQ', 'JACK', 'LAMAR', 87878787, 22222222, 'JAC@YAHOO.COM.');

-- --------------------------------------------------------

--
-- Table structure for table `concern`
--

CREATE TABLE `concern` (
  `CONCERN_ID` int(11) NOT NULL,
  `CONCERN` varchar(255) NOT NULL,
  `EMAIL` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FEEDBACK_ID` int(11) NOT NULL,
  `CPHONE_NUMBER` int(13) NOT NULL,
  `RPHONE_NUMBER` int(13) NOT NULL,
  `FEEDBACK` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

CREATE TABLE `meal` (
  `MEAL_CODE` int(8) NOT NULL,
  `PHONE_NUMBER` int(8) NOT NULL,
  `NAME_OF_MEAL` varchar(80) NOT NULL,
  `DESCRIPTION` varchar(255) NOT NULL,
  `PRICE` float NOT NULL,
  `IMAGE_NAME` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meal`
--

INSERT INTO `meal` (`MEAL_CODE`, `PHONE_NUMBER`, `NAME_OF_MEAL`, `DESCRIPTION`, `PRICE`, `IMAGE_NAME`) VALUES
(6, 50033666, 'TAMIA BONANZA', 'SALTY, CRISPY TAMIAS', 150, 'gallery-img-01.jpg'),
(7, 50033666, 'DOLIA MAGI', 'FRESH PICKED DOLIAS', 80, 'gallery-img-02.jpg'),
(8, 50246810, 'POLIO TAS', 'KELIO POLIO WITH FISH', 50, 'gallery-img-04.jpg'),
(9, 50246810, 'RAMENLO', 'DIASFSIDE RAMEN', 99, 'gallery-img-05.jpg'),
(10, 50000000, 'tartiana', 'tingy salty tartiana', 80, 'gallery-img-04.jpg'),
(11, 50000000, 'davido', 'davi filled pasta', 70, 'gallery-img-02.jpg'),
(12, 63333333, 'keystone', 'delieri poli', 84, 'gallery-img-05.jpg'),
(13, 52222222, 'gravy boat', 'gravy filled tonga', 100, 'gallery-img-04.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order_t`
--

CREATE TABLE `order_t` (
  `ORDER_ID` int(8) NOT NULL,
  `PHONE_NUMBER` int(8) NOT NULL,
  `MEAL_CODE` int(8) NOT NULL,
  `DATE_AND_TIME_ORDER_MADE` datetime NOT NULL DEFAULT current_timestamp(),
  `TYPE_OF_DELIVERY` varchar(14) NOT NULL,
  `DATE_FOR_DELIVERY_OR_PICKUP` date NOT NULL,
  `PRICE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_t`
--

INSERT INTO `order_t` (`ORDER_ID`, `PHONE_NUMBER`, `MEAL_CODE`, `DATE_AND_TIME_ORDER_MADE`, `TYPE_OF_DELIVERY`, `DATE_FOR_DELIVERY_OR_PICKUP`, `PRICE`) VALUES
(14, 67777777, 11, '2020-06-17 16:22:00', 'PICKUP', '2020-06-18', 70),
(15, 50777777, 13, '2020-06-17 17:04:25', 'PICKUP', '2020-06-18', 100),
(16, 50777777, 11, '2020-06-17 17:21:14', 'HOME DELIVERY', '2020-06-19', 269);

-- --------------------------------------------------------

--
-- Table structure for table `requirement`
--

CREATE TABLE `requirement` (
  `COM_ID` int(11) NOT NULL,
  `CPHONE_NUMBER` int(11) NOT NULL,
  `RPHONE_NUMBER` int(11) NOT NULL,
  `ORDER_ID` int(11) NOT NULL,
  `STATUS_OF_ORDER` varchar(12) NOT NULL,
  `REQUIREMENTS` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requirement`
--

INSERT INTO `requirement` (`COM_ID`, `CPHONE_NUMBER`, `RPHONE_NUMBER`, `ORDER_ID`, `STATUS_OF_ORDER`, `REQUIREMENTS`) VALUES
(1, 67777777, 50000000, 14, 'CONFIRM', 'WANTS MORE TOMATO SAUCE'),
(2, 50777777, 52222222, 15, 'CONFIRM', 'wants more sugr');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `HOUSE_NUMBER` int(70) NOT NULL,
  `STREET` varchar(30) NOT NULL,
  `CITY` varchar(30) NOT NULL,
  `DISTRICT` varchar(30) NOT NULL,
  `POSTAL_CODE` int(3) NOT NULL,
  `VILLAGE` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`HOUSE_NUMBER`, `STREET`, `CITY`, `DISTRICT`, `POSTAL_CODE`, `VILLAGE`) VALUES
(23, 'europa', 'maseru', 'MASERU', 100, 'QOALING'),
(45, 'qoaling', 'qoaling', 'maseru', 100, 'foso'),
(54, 'papashane', 'maseru', 'maseru', 100, 'thetsane'),
(89, 'white road', 'maseru', 'MASERU', 100, 'HA THETSANE'),
(98, 'White road', 'maseru', 'maseru', 100, 'qoaling'),
(898, 'THETSANE', 'THETSANE', 'MASERU', 100, 'THETSANE'),
(56416, 'LSJDKFJ', 'LKSJDKF', 'IOSDJOFIS', 21, 'NDSIOFN');

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE `user_registration` (
  `PHONE_NUMBER` int(8) NOT NULL,
  `EMAIL` varchar(320) NOT NULL,
  `NAME` varchar(80) NOT NULL,
  `HOUSE_NUMBER` int(70) NOT NULL,
  `PASSWORD` varchar(94) NOT NULL,
  `TYPE_OF_USER` varchar(15) NOT NULL,
  `IMAGE` varchar(255) NOT NULL,
  `STATUS` varchar(10) NOT NULL,
  `CREDIT_CARD` int(16) NOT NULL,
  `CHARGE` int(11) NOT NULL,
  `DATE_ACCOUNT_CREATED` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`PHONE_NUMBER`, `EMAIL`, `NAME`, `HOUSE_NUMBER`, `PASSWORD`, `TYPE_OF_USER`, `IMAGE`, `STATUS`, `CREDIT_CARD`, `CHARGE`, `DATE_ACCOUNT_CREATED`) VALUES
(50000000, 'cotera@gmail.com', 'cotera', 54, '/.,mnbvcxz', 'RESTAURANT', 'stuff-img-02.jpg', 'ACTIVE', 2147483647, 0, '2020-06-17'),
(50033666, 'greenbill@mail.com', 'greenbill', 89, '/.,MNBVCXZ', 'RESTAURANT', 'stuff-img-02.jpg', 'ACTIVE', 2147483647, 0, '2020-06-17'),
(50246810, 'opendoor@gmail.com', 'open door', 23, '/.,MNBVCXZ', 'RESTAURANT', 'stuff-img-01.jpg', 'ACTIVE', 2147483647, 0, '2020-06-17'),
(50777777, 'setho@yahoo.com', 'setho', 45, '/.,mnbvcxz', 'CLIENT', 'avt-img.jpg', 'ACTIVE', 2147483647, 100, '2020-06-17'),
(52222222, 'haley@gmail.com', 'haleyway', 898, '/.,mnbvcxz', 'RESTAURANT', 'stuff-img-04.jpg', 'ACTIVE', 2147483647, 0, '2020-06-17'),
(63333333, 'suthisa@gmail.com', 'suthisa', 98, '/.,MNBVCXZ', 'RESTAURANT', 'stuff-img-06.jpg', 'ACTIVE', 2147483647, 0, '2020-06-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ADMIN_ID`);

--
-- Indexes for table `concern`
--
ALTER TABLE `concern`
  ADD PRIMARY KEY (`CONCERN_ID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FEEDBACK_ID`,`CPHONE_NUMBER`,`RPHONE_NUMBER`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`MEAL_CODE`);

--
-- Indexes for table `order_t`
--
ALTER TABLE `order_t`
  ADD PRIMARY KEY (`ORDER_ID`);

--
-- Indexes for table `requirement`
--
ALTER TABLE `requirement`
  ADD PRIMARY KEY (`COM_ID`,`CPHONE_NUMBER`,`ORDER_ID`,`RPHONE_NUMBER`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`HOUSE_NUMBER`);

--
-- Indexes for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`PHONE_NUMBER`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `concern`
--
ALTER TABLE `concern`
  MODIFY `CONCERN_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `meal`
--
ALTER TABLE `meal`
  MODIFY `MEAL_CODE` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_t`
--
ALTER TABLE `order_t`
  MODIFY `ORDER_ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `requirement`
--
ALTER TABLE `requirement`
  MODIFY `COM_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
