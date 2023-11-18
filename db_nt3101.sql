-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 07:12 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_nt3101`
--

-- --------------------------------------------------------

--
-- Table structure for table `admindb`
--

CREATE TABLE `admindb` (
  `adminID` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admindb`
--

INSERT INTO `admindb` (`adminID`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `ID` int(11) NOT NULL,
  `SR_Code` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`ID`, `SR_Code`, `subject`, `message`) VALUES
(1, '21-30169', 'About Pin', 'Hi, Im paul and ang masasabi ko lang sa product niyo ay napakaganda at hindi maikukumpara sa iba pang product. Sana ituloy niyo lang ang magandang serbisyon niyo'),
(2, '21-30169', 'About Pin', 'sjahkjhkjsahkjhsdfkjhasdkfjhasdkjfhaksjdhfaksjdhfakjsdhfakjsdhfaskdjhfaskjdhfaksdjfhaskdjfhaskdjfhasdkjfhasdkjfhasdkjfhasdkjfhasdkfjhaskdfjhaskdjfhaskdfjhaskdjfhaskjdfhaksjdhfaksjdhfkasjdfhaksdjfhaksdjhfaksjdhfaksjdhfaksjhfaskjdhfaksjdhfaskjdhfaskjdfhaskjdfhaskjdhfaskjdfhaskdjfhaskjfhasdkfjhaskdjfhasdkjfhaskdjfhasdkjfhasdkjfhaskjdhfaskjdhfaskjdhfaksjdhfkjashdfkjasdhfakjsdhfaskdjhfaksjdhfasdfasdfasdfasdfasdfasdfasdfasdfasdf');

-- --------------------------------------------------------

--
-- Table structure for table `orderdb`
--

CREATE TABLE `orderdb` (
  `OrderID` int(100) NOT NULL,
  `SR_Code` varchar(100) NOT NULL,
  `Orderdate` date NOT NULL,
  `Status` varchar(255) NOT NULL,
  `OrderCost` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderdb`
--

INSERT INTO `orderdb` (`OrderID`, `SR_Code`, `Orderdate`, `Status`, `OrderCost`) VALUES
(97, '21-30169', '2023-11-07', 'Approved', 27),
(114, '21-30169', '2023-11-10', 'Approved', 9);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `OrderItemID` int(11) NOT NULL,
  `OrderID` int(100) NOT NULL,
  `ProductID` int(100) NOT NULL,
  `Quantity` int(100) NOT NULL,
  `TotalPrice` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`OrderItemID`, `OrderID`, `ProductID`, `Quantity`, `TotalPrice`) VALUES
(117, 97, 1, 3, 27),
(142, 114, 1, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `productdb`
--

CREATE TABLE `productdb` (
  `ProductID` int(100) NOT NULL,
  `ProductName` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `AvailStocks` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productdb`
--

INSERT INTO `productdb` (`ProductID`, `ProductName`, `Price`, `image`, `AvailStocks`) VALUES
(1, 'Shot Glass', '9', '320140-removebg-preview.png', 7),
(3, 'Pin', '4', 'IMS.png', 9),
(4, 'Shirt', '200', 'EscuzarPaulAlvin_BSIT2203.png', 9),
(5, 'Id Lace', '50', 'andre-benz-cXU6tNxhub0-unsplash.jpg', 9);

-- --------------------------------------------------------

--
-- Table structure for table `shopcart`
--

CREATE TABLE `shopcart` (
  `CartID` int(11) NOT NULL,
  `SR_Code` varchar(100) NOT NULL,
  `ProductID` int(100) NOT NULL,
  `Quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_record`
--

CREATE TABLE `student_record` (
  `SR_Code` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dept` varchar(255) NOT NULL,
  `prog_sec` varchar(255) NOT NULL,
  `cnum` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_record`
--

INSERT INTO `student_record` (`SR_Code`, `pass`, `firstname`, `lastname`, `email`, `dept`, `prog_sec`, `cnum`) VALUES
('21-30169', 'Pol', 'Paul Alvin', 'Tolentino', '21-30169@g.batstate-u.edu.ph', 'CICS', 'BSIT-NT-3101', '09090774577'),
('21-33112', 'Lord', 'Wingell Lord', 'Vinas', 'ichigokurosaki@gmail.com', 'CICS', 'BSIT-NT-3101', '09445278541');

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admindb`
--
ALTER TABLE `admindb`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orderdb`
--
ALTER TABLE `orderdb`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `SR-Code` (`SR_Code`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`OrderItemID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `productdb`
--
ALTER TABLE `productdb`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `shopcart`
--
ALTER TABLE `shopcart`
  ADD PRIMARY KEY (`CartID`);

--
-- Indexes for table `student_record`
--
ALTER TABLE `student_record`
  ADD PRIMARY KEY (`SR_Code`);

--
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orderdb`
--
ALTER TABLE `orderdb`
  MODIFY `OrderID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `OrderItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `productdb`
--
ALTER TABLE `productdb`
  MODIFY `ProductID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shopcart`
--
ALTER TABLE `shopcart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdb`
--
ALTER TABLE `orderdb`
  ADD CONSTRAINT `SR-Code` FOREIGN KEY (`SR_Code`) REFERENCES `student_record` (`SR_Code`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `OrderID` FOREIGN KEY (`OrderID`) REFERENCES `orderdb` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ProductID` FOREIGN KEY (`ProductID`) REFERENCES `productdb` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
