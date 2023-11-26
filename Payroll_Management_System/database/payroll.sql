-- phpMyAdmin SQL Dump
-- Host: localhost


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `payroll`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `emp_id` int(10) NOT NULL AUTO_INCREMENT,
  `lname` varchar(20) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `emp_type` varchar(20) NOT NULL,
  `division` varchar(30) NOT NULL,
  `salary` int(10) NOT NULL DEFAULT 0,
  `deduction` int(10) NOT NULL ,
  `overtime` int(10) NOT NULL,
  `bonus` int(10) NOT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `fname`, `lname`, `gender`, `emp_type`, `division`, `salary` , `deduction`, `overtime`, `bonus`) VALUES
(1, 'Maya', 'Poojari', 'Female', 'PartTime', 'Accountant',20000, 0, 2, 2),
(2, 'Meenakshi', 'K', 'Female', 'FullTIme', 'Human Resource',30000, 1, 1, 1),
(3, 'Mahesh', 'Poojari', 'Male', 'PartTime', 'Admin',40000, 2, 24, 10);

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE IF NOT EXISTS `deductions` (
  `deduction_id` int(5) NOT NULL AUTO_INCREMENT,
  `medical` int(20) NOT NULL,
  `tax` int(20) NOT NULL,
  `refreshments` int(20) NOT NULL,
  `house` int(20) NOT NULL,
  `loans` int(20) NOT NULL,
  `total` int(20) DEFAULT NULL,
  PRIMARY KEY (`deduction_id`) 
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`deduction_id`, `medical`, `tax`, `refreshments`, `house`, `loans`, `total`) VALUES
  (1, 1, 2, 3, 4, 5, 15);

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE IF NOT EXISTS `overtime` (
  `ot_id` int(10) NOT NULL AUTO_INCREMENT,
  `rate` int(10) NOT NULL,
  `none` int(2) NOT NULL,
  PRIMARY KEY (`ot_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `overtime`
--

INSERT INTO `overtime` (`ot_id`, `rate`, `none`) VALUES
(1, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin@123');


ALTER TABLE employee MODIFY COLUMN deduction INT DEFAULT 0;
ALTER TABLE employee MODIFY COLUMN overtime INT DEFAULT 0;
ALTER TABLE employee MODIFY COLUMN bonus INT DEFAULT 0;



DELIMITER //
CREATE PROCEDURE GetEmployeeCount()
BEGIN
    SELECT COUNT(*) FROM employee;
END //



DELIMITER //
CREATE TRIGGER `total_deductions` 
AFTER UPDATE ON `deductions`
FOR EACH ROW
BEGIN 
UPDATE deductions
SET total = NEW.medical + NEW.tax + New.refreshments + NEW.house + NEW.loans
WHERE deduction_id = 1;
END //

