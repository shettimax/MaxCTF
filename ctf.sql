-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 19, 2020 at 11:17 AM
-- Server version: 5.7.29-0ubuntu0.16.04.1
-- PHP Version: 5.6.40-29+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ctf`
--

-- --------------------------------------------------------

--
-- Table structure for table `1f86700588aed0390dd27c383b7fc963`
--

CREATE TABLE `1f86700588aed0390dd27c383b7fc963` (
  `id` int(11) NOT NULL,
  `radix` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `1f86700588aed0390dd27c383b7fc963`
--

INSERT INTO `1f86700588aed0390dd27c383b7fc963` (`id`, `radix`) VALUES
(1, 'PGSVQ&PGSRZNVY JVYY OR LBHE YBTVA VASB ROT13'),
(2, 'YWRtaW4= base'),
(3, '0x6d617a616e67697a6f 0xhex'),
(4, '1f86700588aed0390dd27c383b7fc963 md'),
(5, 'Y3J5cHRzYWxnb3JpdGht base'),
(6, 'cmVwb3J0ZXI= base reporter.php'),
(7, 'x64617368626f617264 hex dashboard.php');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `ctfid` varchar(30) NOT NULL COMMENT 'autoogenctfid',
  `ctfname` varchar(20) NOT NULL COMMENT 'cybername of user',
  `ctfscore` int(5) NOT NULL COMMENT 'score of user',
  `joined` varchar(20) NOT NULL COMMENT 'date user joined',
  `ctfskillset` varchar(4) NOT NULL COMMENT 'noob or 1337',
  `gender` varchar(10) NOT NULL COMMENT 'male ni or female',
  `ctfemail` varchar(30) NOT NULL COMMENT 'email',
  `ctfpassword` varchar(30) NOT NULL COMMENT 'password its d mail o',
  `farko` varchar(11) DEFAULT NULL COMMENT 'basic if uuser bypass d html reg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `ctfid`, `ctfname`, `ctfscore`, `joined`, `ctfskillset`, `gender`, `ctfemail`, `ctfpassword`, `farko`) VALUES
(1, 'CTFBB812170105', 'max', 20, '2020-12-17', 'noob', 'male', 'max@yahoo.com', 'max@yahoo.com', '1'),
(2, 'CTFJU312160519', '1337M4X', 21, '2020-12-16', 'noob', 'male', 'blckx@yahoo.com', 'blckx@yahoo.com', '1'),
(3, 'MXS4F96TOK0', 'Shettimax', 102, '2020-12-16', '1337', 'male', 'shettimax@yahooo.com', 'shettimax@yahooo.com', '1');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'ctfadmin', 'admin@maxctf.xyz', '$2y$10$JKsviA8XtBmgRpsmtBXXyemW.2oCS2JHco.ns6UTIjZSmu.zajZ3e');

-- --------------------------------------------------------

--
-- Table structure for table `bugs`
--

CREATE TABLE `bugs` (
  `id` int(11) NOT NULL,
  `bug` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bugs`
--

INSERT INTO `bugs` (`id`, `bug`) VALUES
(1, 'SQLi'),
(2, 'XSS'),
(3, 'LFI'),
(4, 'RFI'),
(5, 'FILEUPLOAD'),
(6, 'NOT HERE');

-- --------------------------------------------------------

--
-- Table structure for table `ctfs`
--

CREATE TABLE `ctfs` (
  `id` int(11) NOT NULL,
  `farkoo` varchar(300) NOT NULL,
  `biyu` varchar(300) NOT NULL,
  `uku` varchar(300) NOT NULL,
  `hudu` varchar(300) NOT NULL,
  `biyar` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ctfs`
--

INSERT INTO `ctfs` (`id`, `farkoo`, `biyu`, `uku`, `hudu`, `biyar`) VALUES
(1, 'targets/Dummyvotingsys', 'targets/Dummyloginsys', 'targets/DummyAdmissionchecksys', 'targets/DummyLFi', 'targets/Dummy');

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`gender`) VALUES
('male'),
('female');

-- --------------------------------------------------------

--
-- Table structure for table `modz`
--

CREATE TABLE `modz` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modz`
--

INSERT INTO `modz` (`id`, `username`, `email`, `password`) VALUES
(1, 'mod1337', 'admin2@maxctf.co', '1f86700588aed0390dd27c383b7fc963');

-- --------------------------------------------------------

--
-- Table structure for table `reportx`
--

CREATE TABLE `reportx` (
  `id` int(11) NOT NULL,
  `walletid` varchar(60) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `proofimage` text NOT NULL,
  `date` varchar(60) NOT NULL,
  `status` text NOT NULL,
  `bug` varchar(15) NOT NULL,
  `severity` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='theis store request of top up by user';

--
-- Dumping data for table `reportx`
--

INSERT INTO `reportx` (`id`, `walletid`, `amount`, `proofimage`, `date`, `status`, `bug`, `severity`) VALUES
(1, 'MXS4F96TOK0', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM');

-- --------------------------------------------------------

--
-- Table structure for table `severities`
--

CREATE TABLE `severities` (
  `id` int(11) NOT NULL,
  `severity` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `severities`
--

INSERT INTO `severities` (`id`, `severity`) VALUES
(1, 'LOW'),
(2, 'MEDIUM'),
(3, 'TENTATIVE'),
(4, 'FIRM'),
(5, 'CRITICAL'),
(6, 'NOT HERE');

-- --------------------------------------------------------

--
-- Table structure for table `site`
--

CREATE TABLE `site` (
  `id` int(11) NOT NULL,
  `sitename` varchar(100) NOT NULL,
  `header` varchar(300) NOT NULL,
  `header2` varchar(100) NOT NULL,
  `about` varchar(500) NOT NULL,
  `disclaimer` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site`
--

INSERT INTO `site` (`id`, `sitename`, `header`, `header2`, `about`, `disclaimer`) VALUES
(1, 'MAX CTF', 'A place for H4X0RS. Inspired by the classic green on black terminal style.', 'Tk8gUFVSQ0hBU0UgTkVDRVNTQVJZ<br>VE8gRU5URVIgT1IgV0lO', 'This platform is designed for a person that is brand-new to Capture The Flag (CTF) hacking and explains the basics to give you the courage to enter a CTF and see for yourself what it is like to participate. CTFs are events that are usually hosted at information security conferences, including the various BSides events. These events consist of a series of challenges that vary in their degree of difficulty, and that require participants to exercise different skillsets to solve.', 'We do not promote, encourage, support or excite any illegal activity or hacking without written permission in general. We want you to think outside the box by solving daily ctf challenges. If you plan to use the information for illegal purposes, please leave this website now. We cannot be held responsible for any misuse of your boosted knowlegde.');

-- --------------------------------------------------------

--
-- Table structure for table `skillsets`
--

CREATE TABLE `skillsets` (
  `id` int(11) NOT NULL,
  `skillset` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skillsets`
--

INSERT INTO `skillsets` (`id`, `skillset`) VALUES
(1, 'noob'),
(2, '1337');

-- --------------------------------------------------------

--
-- Table structure for table `Y3J5cHRzYWxnb3JpdGht`
--

CREATE TABLE `Y3J5cHRzYWxnb3JpdGht` (
  `id` int(11) NOT NULL,
  `b068931cc450442b63f5b3d276ea4297` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Y3J5cHRzYWxnb3JpdGht`
--

INSERT INTO `Y3J5cHRzYWxnb3JpdGht` (`id`, `b068931cc450442b63f5b3d276ea4297`) VALUES
(1, 'md5'),
(2, '0xhex'),
(3, 'base64'),
(4, 'rot13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `1f86700588aed0390dd27c383b7fc963`
--
ALTER TABLE `1f86700588aed0390dd27c383b7fc963`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ctfid` (`ctfid`),
  ADD UNIQUE KEY `ctfname` (`ctfname`),
  ADD UNIQUE KEY `ctfpassword` (`ctfpassword`),
  ADD UNIQUE KEY `ctfemail` (`ctfemail`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ctfs`
--
ALTER TABLE `ctfs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modz`
--
ALTER TABLE `modz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reportx`
--
ALTER TABLE `reportx`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `severities`
--
ALTER TABLE `severities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site`
--
ALTER TABLE `site`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skillsets`
--
ALTER TABLE `skillsets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Y3J5cHRzYWxnb3JpdGht`
--
ALTER TABLE `Y3J5cHRzYWxnb3JpdGht`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `1f86700588aed0390dd27c383b7fc963`
--
ALTER TABLE `1f86700588aed0390dd27c383b7fc963`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ctfs`
--
ALTER TABLE `ctfs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `modz`
--
ALTER TABLE `modz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `reportx`
--
ALTER TABLE `reportx`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `severities`
--
ALTER TABLE `severities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `site`
--
ALTER TABLE `site`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `skillsets`
--
ALTER TABLE `skillsets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Y3J5cHRzYWxnb3JpdGht`
--
ALTER TABLE `Y3J5cHRzYWxnb3JpdGht`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
