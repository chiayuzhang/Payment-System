-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2023 at 06:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `payment_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `accountant`
--

CREATE TABLE `accountant` (
  `accountantID` int(10) NOT NULL,
  `AC_Username` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `employeeID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accountant`
--

INSERT INTO `accountant` (`accountantID`, `AC_Username`, `password`, `employeeID`) VALUES
(1, 'Kam', 'abc123', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cfo`
--

CREATE TABLE `cfo` (
  `cfoID` int(10) NOT NULL,
  `C_Username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `employeeID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cfo`
--

INSERT INTO `cfo` (`cfoID`, `C_Username`, `password`, `employeeID`) VALUES
(1, 'Chia', 'abc123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `companyID` int(10) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `companyAddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`companyID`, `companyName`, `companyAddress`) VALUES
(1, 'Sunway University Subang', 'Sunway Lagoon Persiaran Sepang, 123000, Selangor'),
(2, 'Multimedia University Cyberjaya', 'Multimedia University Cyberjaya, 63300, Selangor');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employeeID` int(10) NOT NULL,
  `employeeName` varchar(100) NOT NULL,
  `role` enum('accountant','cfo') NOT NULL,
  `department` varchar(20) NOT NULL,
  `companyID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeID`, `employeeName`, `role`, `department`, `companyID`) VALUES
(1, 'Chia Yu Zhang', 'cfo', 'FCM', 1),
(2, 'Kam Kar Hou', 'accountant', 'FCI', 2);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoiceID` int(10) NOT NULL,
  `dueDate` date NOT NULL,
  `issueDate` date DEFAULT NULL,
  `totalPrice` double(10,2) DEFAULT NULL,
  `invoiceStatus` enum('Approved','Pending','Expired') DEFAULT NULL,
  `vendorID` int(10) NOT NULL,
  `vmanagerID` int(10) DEFAULT NULL,
  `paymentID` int(10) DEFAULT NULL,
  `payStatus` enum('Paid','Pending') NOT NULL,
  `companyID` int(10) NOT NULL,
  `companyName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoiceID`, `dueDate`, `issueDate`, `totalPrice`, `invoiceStatus`, `vendorID`, `vmanagerID`, `paymentID`, `payStatus`, `companyID`, `companyName`) VALUES
(1, '2023-01-27', '2023-01-25', 4472.50, 'Approved', 1, 1, 2, 'Paid', 1, 'Sunway University Subang'),
(2, '2023-01-27', '2023-01-26', 700.00, 'Approved', 1, 1, 3, 'Paid', 2, 'Multimedia University Cyberjaya'),
(3, '2023-01-27', '2023-01-26', 170.00, 'Approved', 1, 1, NULL, 'Pending', 2, 'Multimedia University Cyberjaya');

--
-- Triggers `invoice`
--
DELIMITER $$
CREATE TRIGGER `get_CompanyName` BEFORE INSERT ON `invoice` FOR EACH ROW SET NEW.companyName = (SELECT companyName FROM company WHERE company.companyID = NEW.companyID)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `get_ProductTotalPrice` BEFORE INSERT ON `invoice` FOR EACH ROW BEGIN
    	SET @total = (SELECT SUM(totalPrice) FROM product where product.invoiceID IS NULL);
        SET new.totalPrice = @total;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `get_issueDate` BEFORE INSERT ON `invoice` FOR EACH ROW SET new.issueDate = NOW()
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set_initialStatus` BEFORE INSERT ON `invoice` FOR EACH ROW SET NEW.invoiceStatus = "Pending"
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_Product` AFTER INSERT ON `invoice` FOR EACH ROW UPDATE product
SET invoiceID = new.invoiceID
WHERE invoiceID IS NULL
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(10) NOT NULL,
  `paymentStatus` enum('Pending','Paid') DEFAULT NULL,
  `paymentDate` date NOT NULL,
  `paymentType` enum('Cash','Card','Online') NOT NULL,
  `cfoID` int(10) NOT NULL,
  `companyID` int(10) NOT NULL,
  `invoiceID` int(10) DEFAULT NULL,
  `vmanagerID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `paymentStatus`, `paymentDate`, `paymentType`, `cfoID`, `companyID`, `invoiceID`, `vmanagerID`) VALUES
(2, 'Paid', '2023-01-25', 'Cash', 1, 1, 1, 1),
(3, 'Paid', '2023-01-26', 'Cash', 1, 2, 2, 1);

--
-- Triggers `payment`
--
DELIMITER $$
CREATE TRIGGER `update_invoiceID` AFTER INSERT ON `payment` FOR EACH ROW UPDATE invoice
	SET paymentID = new.paymentID WHERE new.invoiceID = invoiceID
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_invoice_paystatus` AFTER INSERT ON `payment` FOR EACH ROW BEGIN
  UPDATE invoice SET payStatus = 'pending' WHERE invoiceID = NEW.invoiceID;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_invoice_paystatus_approved` AFTER UPDATE ON `payment` FOR EACH ROW UPDATE invoice
SET payStatus = "Paid" WHERE invoiceID = new.invoiceID AND new.paymentStatus = "Paid" AND paymentID = new.paymentID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int(10) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` double(10,2) NOT NULL,
  `totalPrice` double(10,2) DEFAULT NULL,
  `invoiceID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `quantity`, `price`, `totalPrice`, `invoiceID`) VALUES
(1, 'Dyson Vacuum 4000', 2, 1200.00, 2400.00, 1),
(2, 'Dell Laptop', 4, 500.00, 2000.00, 1),
(3, 'Desk Lamp', 5, 14.50, 72.50, 1),
(4, 'Mouse', 5, 15.00, 75.00, 2),
(5, 'Keyboard', 5, 25.00, 125.00, 2),
(6, 'Monitor', 5, 100.00, 500.00, 2),
(7, 'Trash Bin', 5, 5.00, 25.00, 3),
(8, 'Lamp', 5, 29.00, 145.00, 3);

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `Trig_TotalPrice` BEFORE INSERT ON `product` FOR EACH ROW SET NEW.totalPrice = NEW.quantity * NEW.price
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `receiptID` int(10) NOT NULL,
  `issueDate` date DEFAULT NULL,
  `invoiceID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`receiptID`, `issueDate`, `invoiceID`) VALUES
(1, '2023-01-25', 1),
(2, '2023-01-26', 2);

--
-- Triggers `receipt`
--
DELIMITER $$
CREATE TRIGGER `get_issueDateReceipt` BEFORE INSERT ON `receipt` FOR EACH ROW SET new.issueDate = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendorID` int(10) NOT NULL,
  `V_Username` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendorID`, `V_Username`, `name`, `password`) VALUES
(1, 'Yap', 'Yap Zhi Toung', 'abc123');

-- --------------------------------------------------------

--
-- Table structure for table `vmanager`
--

CREATE TABLE `vmanager` (
  `vmanagerID` int(10) NOT NULL,
  `VM_Username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vmanager`
--

INSERT INTO `vmanager` (`vmanagerID`, `VM_Username`, `name`, `password`) VALUES
(1, 'Iven', 'Iven Low Zi Yin', 'abc123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountant`
--
ALTER TABLE `accountant`
  ADD PRIMARY KEY (`accountantID`),
  ADD KEY `accountant_employee` (`employeeID`);

--
-- Indexes for table `cfo`
--
ALTER TABLE `cfo`
  ADD PRIMARY KEY (`cfoID`),
  ADD KEY `cfo_employee` (`employeeID`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`companyID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employeeID`),
  ADD KEY `employee_company` (`companyID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoiceID`),
  ADD KEY `invoice_payment` (`paymentID`),
  ADD KEY `invoice_vendor` (`vendorID`),
  ADD KEY `invoice_employee` (`companyID`),
  ADD KEY `invoice_vmanager` (`vmanagerID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `payment_cfo` (`cfoID`),
  ADD KEY `payment_company` (`companyID`),
  ADD KEY `payment_vmanager` (`vmanagerID`),
  ADD KEY `payment_invoice` (`invoiceID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `product_invoice` (`invoiceID`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`receiptID`),
  ADD KEY `receipt_invoice` (`invoiceID`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendorID`);

--
-- Indexes for table `vmanager`
--
ALTER TABLE `vmanager`
  ADD PRIMARY KEY (`vmanagerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountant`
--
ALTER TABLE `accountant`
  MODIFY `accountantID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cfo`
--
ALTER TABLE `cfo`
  MODIFY `cfoID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `companyID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employeeID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoiceID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `receiptID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendorID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vmanager`
--
ALTER TABLE `vmanager`
  MODIFY `vmanagerID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accountant`
--
ALTER TABLE `accountant`
  ADD CONSTRAINT `accountant_employee` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cfo`
--
ALTER TABLE `cfo`
  ADD CONSTRAINT `cfo_employee` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_company` FOREIGN KEY (`companyID`) REFERENCES `company` (`companyID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_vendor` FOREIGN KEY (`vendorID`) REFERENCES `vendor` (`vendorID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_vmanager` FOREIGN KEY (`vmanagerID`) REFERENCES `vmanager` (`vmanagerID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_cfo` FOREIGN KEY (`cfoID`) REFERENCES `cfo` (`cfoID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_company` FOREIGN KEY (`companyID`) REFERENCES `company` (`companyID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_invoice` FOREIGN KEY (`invoiceID`) REFERENCES `invoice` (`invoiceID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_vmanager` FOREIGN KEY (`vmanagerID`) REFERENCES `vmanager` (`vmanagerID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_invoice` FOREIGN KEY (`invoiceID`) REFERENCES `invoice` (`invoiceID`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `receipt`
--
ALTER TABLE `receipt`
  ADD CONSTRAINT `receipt_invoice` FOREIGN KEY (`invoiceID`) REFERENCES `invoice` (`invoiceID`) ON DELETE NO ACTION ON UPDATE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_expired_invoices` ON SCHEDULE EVERY 5 MINUTE STARTS '2023-01-15 21:36:42' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE invoice
  SET invoiceStatus = 'Expired'
  WHERE dueDate < NOW() AND invoiceStatus != 'Approved'$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
