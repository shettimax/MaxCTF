-- phpMyAdmin SQL Dump
-- shettimax@yahoo.com or
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 25, 2025 at 01:24 PM
-- Server version: 5.7.44
-- PHP Version: 5.6.40-81+ubuntu20.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
  `ctfpassword` varchar(1000) NOT NULL COMMENT 'password its d mail o',
  `farko` varchar(11) DEFAULT NULL COMMENT 'basic if uuser bypass d html reg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `ctfid`, `ctfname`, `ctfscore`, `joined`, `ctfskillset`, `gender`, `ctfemail`, `ctfpassword`, `farko`) VALUES
(1, 'CTFBB812170105', 'max', 60, '2020-12-17', 'noob', 'male', 'max@yahoo.com', 'max@yahoo.com', '1'),
(2, 'CTFJU312160519', '1337M4X', 21, '2020-12-16', 'noob', 'male', 'blckx@yahoo.com', 'blckx@yahoo.com', '1'),
(3, 'MXS4F96TOK0', 'Shettimax', 200, '2020-12-16', '1337', 'male', 'shettimax@yahooo.com', 'shettimax@yahooo.com', '1'),
(4, 'CTFXN410251144', 'KingCobra', 20, '2025-10-25', 'noob', 'male', 'xw@x.x', '95fef0b03489c26d510bc36ecceef32d8a60bc69', NULL),
(5, 'CTFYX710251150', '0xvince', 35, '2025-10-25', 'noob', 'male', '', '9b50d1f90e62bf2b07ce4a2c12ae735ccb4c3d05', '1');

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
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `vibe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `title`, `vibe`) VALUES
(1, 'n00b', 'Just getting started'),
(2, 'WebInitiate', 'Learning the ropes'),
(3, 'ByteSpinner', 'Crafting basic payloads'),
(4, 'Weaver', 'Showing promise'),
(5, 'Lurker', 'Gaining traction'),
(6, 'Explorer', 'Starting to stand out'),
(7, 'Phantom', 'Skilled and stealthy'),
(8, 'Architect', 'Designing clever payloads'),
(9, 'SignalBender', 'Master of manipulation'),
(10, '1337', 'Recognized expert'),
(11, 'WebStrategist', 'Tactical and precise'),
(12, 'CyberArtisan', 'Payloads with flair'),
(13, 'ShadowCoder', 'Operating in the dark'),
(14, 'Exploit Engineer', 'Building advanced tools'),
(15, '1337Phantom', 'Nearly undetectable'),
(16, '1337Prodigy', 'Legendary status'),
(17, 'WebDominator', 'Controls the digital battlefield'),
(18, 'SignalOverlord', 'Commands the flow'),
(19, 'Exploit Sovereign', 'Supreme payload mastery'),
(20, 'C.O.H.S', 'Chief of Hacking Staff');

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
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `id` int(11) NOT NULL,
  `quote` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`id`, `quote`) VALUES
(1, 'Hackers are artists, and computers are their canvas.'),
(2, 'There is no patch for human stupidity. — Kevin Mitnick'),
(3, 'Security is not a product, but a process. — Bruce Schneier'),
(4, 'The quieter you become, the more you are able to hear. — Ram Dass'),
(5, 'The best way to predict the future is to invent it. — Alan Kay'),
(6, 'Amateurs hack systems; professionals hack people. — Bruce Schneier'),
(7, 'Technology trust is a good thing, but control is a better one. — Stephane Nappo'),
(8, 'If you think technology can solve your security problems, then you don\'t understand the problems and you don\'t understand the technology. — Bruce Schneier'),
(9, 'Hacking is not about breaking things. It\'s about understanding them.'),
(10, 'A hacker does for love what others do for money.'),
(11, 'The only secure system is one that is powered off, cast in a block of concrete, and sealed in a lead-lined room with armed guards.'),
(12, 'Cybersecurity is much more than a matter of IT. — Stephane Nappo'),
(13, 'To know your enemy, you must become your enemy. — Sun Tzu'),
(14, 'The Internet is the first thing that humanity has built that humanity doesn\'t understand.'),
(15, 'Every lock can be picked with a big enough hammer.'),
(16, 'In cybersecurity, the weakest link is always human.'),
(17, 'You can’t defend. You can only respond.'),
(18, 'The best hackers are the ones who never get caught.'),
(19, 'Encryption works. Properly implemented strong crypto systems are one of the few things that you can rely on. — Edward Snowden'),
(20, 'The most secure computer is one that’s turned off.'),
(21, 'Hackers don’t break systems. They break assumptions.'),
(22, 'The goal of hacking is not destruction, but exploration.'),
(23, 'CTFs teach you how to think like a hacker.'),
(24, 'The first rule of hacking: never trust user input.'),
(25, 'The second rule of hacking: never trust the system.'),
(26, 'The third rule of hacking: always read the source.'),
(27, 'The fourth rule of hacking: logs are your best friend.'),
(28, 'The fifth rule of hacking: if it’s not documented, it’s vulnerable.'),
(29, 'The sixth rule of hacking: everything is a puzzle.'),
(30, 'The seventh rule of hacking: never underestimate curiosity.'),
(31, 'The eighth rule of hacking: always look twice.'),
(32, 'The ninth rule of hacking: the flag is always there.'),
(33, 'The tenth rule of hacking: if it looks secure, it probably isn’t.'),
(34, 'CTFs are the dojo of cybersecurity.'),
(35, 'Hackers are problem solvers, not criminals.'),
(36, 'The best exploits are elegant.'),
(37, 'Reverse engineering is like archaeology with hex.'),
(38, 'A good hacker knows the system. A great hacker knows the mindset.'),
(39, 'CTFs reward persistence, not perfection.'),
(40, 'The shell is your playground.'),
(41, 'The network is your battlefield.'),
(42, 'The logs are your map.'),
(43, 'The payload is your weapon.'),
(44, 'The challenge is your teacher.'),
(45, 'The flag is your trophy.'),
(46, 'The exploit is your art.'),
(47, 'The vulnerability is your opportunity.'),
(48, 'The patch is your proof.'),
(49, 'The root is your crown.'),
(50, 'The game is your world.');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='bugsubmissions';

--
-- Dumping data for table `reportx`
--

INSERT INTO `reportx` (`id`, `walletid`, `amount`, `proofimage`, `date`, `status`, `bug`, `severity`) VALUES
(1, 'MXS4F96TOK0', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM'),
(2, 'CTFBB812170105', '20', 'admin/proofimages/Screenshot from 2025-10-20 16-36-30.png', '2025-10-23 12:10:27', 'approved', 'XSS', 'LOW'),
(3, 'CTFBB137987489', '100', 'proof.jpg', '2025-10-23 13:14', 'approved', 'XSS', 'high'),
(4, 'CTFBB812170105', '20', 'admin/admin/proofimages/vatar1337.png', '2025-10-23 14:30:06', 'approved', 'XSS', 'FIRM');

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
  `about` varchar(5000) NOT NULL,
  `disclaimer` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site`
--

INSERT INTO `site` (`id`, `sitename`, `header`, `header2`, `about`, `disclaimer`) VALUES
(1, 'MAX CTF', 'A place for H4X0RS. Inspired by the classic green on black terminal style.', 'Tk8gUFVSQ0hBU0UgTkVDRVNTQVJZ<br>VE8gRU5URVIgT1IgV0lO', 'MAXCTF is built for curious minds stepping into the world of Capture The Flag (CTF) hacking. Whether you\'re a total beginner or just exploring cybersecurity, this platform introduces the basics and gives you the confidence to participate. CTFs are competitive hacking events often hosted at infosec conferences like BSides, DEF CON, and local meetups. They feature challenges across web exploitation, reverse engineering, cryptography, forensics, and more — each designed to test your problem-solving skills and creativity.', 'We do not promote, encourage, support or excite any illegal activity or hacking without written permission in general. We want you to think outside the box by solving daily ctf challenges. If you plan to use the information for illegal purposes, please leave this website now. We cannot be held responsible for any misuse of your boosted knowlegde.');

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
-- Indexes for table `badges`
--
ALTER TABLE `badges`
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
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `reportx`
--
ALTER TABLE `reportx`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
