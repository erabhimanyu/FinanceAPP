-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2016 at 06:36 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

USE finance;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finance`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrower`
--

CREATE TABLE IF NOT EXISTS `borrower` (
  `borrower_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `mobile` bigint(11) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `drivinglic` varchar(25) NOT NULL,
  `adharno` varchar(25) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `note` text NOT NULL,
  `docs` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrower`
--

INSERT INTO `borrower` (`borrower_id`, `firstname`, `lastname`, `dob`, `address`, `city`, `mobile`, `phone`, `gender`, `email`, `drivinglic`, `adharno`, `created_at`, `updated_at`, `deleted_at`, `note`, `docs`) VALUES
(1, 'CHETAN', 'SHARMA', '1986-10-28', 'A-201, Airoli', 'THANE', 8080274441, 0, 'male', 'chetanya_tech@yahoo.co.in', '1234567890', '1234567890', '2015-12-13 06:41:33', '0000-00-00 00:00:00', '2016-02-20 08:21:35', 'borrowing money for education', ''),
(2, 'AJAY', 'BHAGAT', '2016-02-22', 'Borivali', 'BORIVALI', 8080274441, 1234567890, 'male', 'ajay.bhagat@gmail.com', '', '', '2016-02-22 06:15:22', '0000-00-00 00:00:00', NULL, '', ''),
(4, 'SANDEEP', 'SATPUTE', '1988-03-08', 'Borivali', 'BORIVALI', 8080274441, 1234567890, 'male', 'Sandeep.satpute@gmail.com', '1234567890', '1234567890', '2016-03-05 16:21:23', '0000-00-00 00:00:00', NULL, 'Non-Group', ''),
(11, 'Manoj', 'Sharma', '1982-03-05', 'A-201, NARAMADA COOPERATIVE HOUSING SOCITY  SECTOR-19, AIROLI, NAVI MUMBAI', 'NAVI MUMBAI', 8080274441, 221234567890, 'male', 'manoj.sharma@gmail.com', 'D123123', 'A123456', '2016-03-07 10:14:43', '0000-00-00 00:00:00', NULL, 'Non-Group member', '<ul><li><a href=''docs/07-03-2016-10-12-49-Alison_iphone.JPG'' target=''_blank''>Alison_iphone.JPG</a></li><li><a href=''docs/07-03-2016-10-12-49-Capture.PNG'' target=''_blank''>Capture.PNG</a></li><li><a href=''docs/07-03-2016-10-12-49-Capture11.PNG'' target=''_blank''>Capture11.PNG</a></li></ul>'),
(12, 'Mukesh', 'Satpute', '1989-11-02', '3rd floor, Reliable Tech Park, Thane-Belapur Road, Airoli MIDC, Navi Mumbai, India 400708', 'NAVI MUMBAI', 8080274441, 221234567890, 'male', 'Mukesh.Satpute@gmail.com', 'D1234567890', 'A1234567890', '2016-03-07 10:44:53', '0000-00-00 00:00:00', NULL, 'SRP Group Member', '<ul><li><a href=''docs/07-03-2016-10-43-53-file-page1.jpg'' target=''_blank''>file-page1.jpg</a></li><li><a href=''docs/07-03-2016-10-43-53-file-page5.jpg'' target=''_blank''>file-page5.jpg</a></li><li><a href=''docs/07-03-2016-10-43-53-file-page6.jpg'' target=''_blank''>file-page6.jpg</a></li></ul>');

-- --------------------------------------------------------

--
-- Table structure for table `installment`
--

CREATE TABLE IF NOT EXISTS `installment` (
  `insta_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `pay_amount` double NOT NULL,
  `paid_amount` double NOT NULL,
  `paid_date` date NOT NULL,
  `payoff` int(11) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `installment`
--

INSERT INTO `installment` (`insta_id`, `loan_id`, `borrower_id`, `pay_amount`, `paid_amount`, `paid_date`, `payoff`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1943, 1943, '2015-12-13', 0, '', '2015-12-13 05:52:00', '0000-00-00 00:00:00', NULL),
(2, 1, 1, 2234, 2234, '2016-02-20', 0, '', '2016-02-20 07:19:21', '0000-00-00 00:00:00', NULL),
(3, 1, 1, 1231, 1231, '2016-01-20', 0, '', '2016-02-20 07:20:08', '0000-00-00 00:00:00', NULL);

--
-- Triggers `installment`
--
DELIMITER $$
CREATE TRIGGER `AI_loan_txn` AFTER INSERT ON `installment`
 FOR EACH ROW BEGIN
	DECLARE pay_amount DOUBLE(8,2) DEFAULT 0;
	DECLARE paid_amount DOUBLE(8,2) DEFAULT 0;
	DECLARE loan_amount DOUBLE(8,2) DEFAULT 0;
	DECLARE final_amount DOUBLE(8,2) DEFAULT 0;
	DECLARE user_amount DOUBLE(8,2) DEFAULT 0;
	DECLARE payoff VARCHAR(25);
	
	select amount from loan where `loan_id`=NEW.loan_id
	into loan_amount;	
	
	SET pay_amount=NEW.pay_amount;
	SET paid_amount=NEW.paid_amount;

	IF(pay_amount > paid_amount) THEN
		SET payoff="Installment";
		SET final_amount=loan_amount+(pay_amount-paid_amount);
		
		INSERT INTO `loan_transaction`(`loan_id`, `borrower_id`, `insta_id`, `amount`, `final_amount`, `reason`) VALUES (NEW.loan_id,NEW.borrower_id,NEW.insta_id,NEW.paid_amount,final_amount,payoff);
	
	ELSEIF(pay_amount <= paid_amount) THEN
		SET user_amount=pay_amount;

		IF(user_amount = paid_amount  && NEW.payoff = "1") THEN
			SET payoff="Payoff";
			SET final_amount=0;
		ELSE
			SET payoff="Installment";
			SET final_amount=loan_amount-(paid_amount-pay_amount);
	    END IF;
		IF(payoff = "Payoff") THEN
		INSERT INTO `loan_transaction`(`loan_id`, `borrower_id`, `insta_id`, `amount`, `final_amount`, `reason`) VALUES (NEW.loan_id,NEW.borrower_id,NEW.insta_id,NEW.paid_amount,final_amount,payoff);
		update loan set `status`=0 where loan_id = NEW.loan_id; 		
		ELSE
		INSERT INTO `loan_transaction`(`loan_id`, `borrower_id`, `insta_id`, `amount`, `final_amount`, `reason`) VALUES (NEW.loan_id,NEW.borrower_id,NEW.insta_id,NEW.paid_amount,final_amount,payoff);
		END IF;
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
  `loan_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `rate` float NOT NULL,
  `start_date` date NOT NULL,
  `payoff_date` date NOT NULL,
  `installment_duration` int(11) NOT NULL,
  `duration_in_month` int(11) NOT NULL,
  `note` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `loanname` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan`
--

INSERT INTO `loan` (`loan_id`, `borrower_id`, `amount`, `rate`, `start_date`, `payoff_date`, `installment_duration`, `duration_in_month`, `note`, `status`, `loanname`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 10000, 9.85, '2015-12-13', '2016-02-13', 60, 2, 'eduation loan from Shrer Ram Prathisthan', '1', '10000 for 9.85% on Dec - 2015', '2015-12-13 01:21:29', '0000-00-00 00:00:00', NULL),
(2, 1, 5000, 5, '2016-02-20', '2016-08-20', 30, 6, '', '1', '5000 for 5% on Feb - 2016', '2016-02-20 02:52:41', '0000-00-00 00:00:00', NULL),
(3, 2, 5000, 1, '2016-02-22', '2016-02-22', 0, 0, '', '1', '5000 for 1% on Feb - 2016', '2016-02-22 00:46:39', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_transaction`
--

CREATE TABLE IF NOT EXISTS `loan_transaction` (
  `lt_id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `insta_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `final_amount` double NOT NULL,
  `loan_amount` double NOT NULL,
  `reason` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_transaction`
--

INSERT INTO `loan_transaction` (`lt_id`, `loan_id`, `borrower_id`, `insta_id`, `amount`, `final_amount`, `loan_amount`, `reason`) VALUES
(1, 1, 1, 1, 1943, 10000, 0, 'Installment'),
(2, 1, 1, 2, 2234, 10000, 0, 'Installment'),
(3, 1, 1, 3, 1231, 10000, 0, 'Installment');

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE IF NOT EXISTS `login_history` (
  `uid` int(11) NOT NULL,
  `login_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`uid`, `login_date`) VALUES
(1, '2015-12-13 11:33:11'),
(1, '2015-12-13 11:34:38'),
(1, '2015-12-13 11:41:26'),
(1, '2015-12-13 11:49:30'),
(1, '2016-01-04 15:33:52'),
(1, '2016-02-06 12:41:16'),
(1, '2016-02-06 12:41:40'),
(1, '2016-02-06 12:41:44'),
(1, '2016-02-20 12:47:39'),
(1, '2016-02-20 17:02:06'),
(1, '2016-02-22 10:18:23'),
(1, '2016-02-22 10:35:26'),
(1, '2016-02-22 20:15:08'),
(1, '2016-03-05 11:59:43'),
(1, '2016-03-05 18:37:54'),
(1, '2016-03-06 13:01:59'),
(1, '2016-03-06 13:54:29'),
(1, '2016-03-06 14:15:36'),
(1, '2016-03-06 14:25:49'),
(1, '2016-03-06 14:46:39'),
(1, '2016-03-07 12:44:34'),
(1, '2016-03-07 21:33:45'),
(1, '2016-03-07 22:31:25'),
(1, '2016-03-07 22:31:28'),
(1, '2016-03-08 10:08:28'),
(1, '2016-03-08 11:56:09'),
(1, '2016-03-08 22:49:37'),
(1, '2016-03-14 20:56:53'),
(1, '2016-03-17 10:37:07'),
(1, '2016-03-17 13:48:39'),
(1, '2016-03-22 10:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `name`, `username`, `password`) VALUES
(1, 'Shree Ram Prathisthan', 'chetanya_tech@yahoo.co.in', 'chetan1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrower`
--
ALTER TABLE `borrower`
  ADD PRIMARY KEY (`borrower_id`);

--
-- Indexes for table `installment`
--
ALTER TABLE `installment`
  ADD PRIMARY KEY (`insta_id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `loan_transaction`
--
ALTER TABLE `loan_transaction`
  ADD PRIMARY KEY (`lt_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrower`
--
ALTER TABLE `borrower`
  MODIFY `borrower_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `installment`
--
ALTER TABLE `installment`
  MODIFY `insta_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `loan_transaction`
--
ALTER TABLE `loan_transaction`
  MODIFY `lt_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
