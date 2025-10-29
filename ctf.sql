-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 29, 2025 at 03:16 AM
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
-- Database: `ctf2`
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
(1, 'CTFM4X1337', 'Al0new0lf', 106, '2019-12-17', 'noob', 'male', 'shettimax@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(2, 'BL4KXPL6', 'BXP6', 500, '2020-02-16', 'noob', 'male', 'black@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(3, 'M4Z4NG33Z0', 'MZGZ', 1000, '2021-12-16', '1337', 'male', 'mzgz@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(4, 'C0BR47A73', 'KingCobra', 1500, '2022-10-25', 'noob', 'male', 'cobra@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(5, 'CTFXG33W4', '0xvince', 2000, '2023-11-05', 'N00B', 'male', '0xvince@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(6, 'CTF3XL0V44', 'XL0V3R', 2500, '2024-09-16', '1337', 'MALE', 'XL0V3R@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(10, 'CTFHO910260316', 'kiralina', 3033, '2025-10-26', 'N00B', 'FEMALE', 'kira@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(11, 'CTFHO60316', 'DMP', 3569, '2025-10-27', 'N00B', 'FEMALE', 'dudu@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1');

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
  `vibe` varchar(255) NOT NULL,
  `required_score` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `title`, `vibe`, `required_score`) VALUES
(1, 'n00b', 'Just getting started', 1),
(2, 'WebInitiate', 'Learning the ropes', 500),
(3, 'ByteSpinner', 'Crafting basic payloads', 1000),
(4, 'Weaver', 'Showing promise', 1500),
(5, 'Lurker', 'Gaining traction', 2000),
(6, 'Explorer', 'Starting to stand out', 2500),
(7, 'Phantom', 'Skilled and stealthy', 3000),
(8, 'Architect', 'Designing clever payloads', 3500),
(9, 'SignalBender', 'Master of manipulation', 4000),
(10, '1337', 'Recognized expert', 4500),
(11, 'WebStrategist', 'Tactical and precise', 5000),
(12, 'CyberArtisan', 'Payloads with flair', 5500),
(13, 'ShadowCoder', 'Operating in the dark', 6000),
(14, 'Exploit Engineer', 'Building advanced tools', 6500),
(15, '1337Phantom', 'Nearly undetectable', 7000),
(16, '1337Prodigy', 'Legendary status', 7500),
(17, 'WebDominator', 'Controls the digital battlefield', 8000),
(18, 'SignalOverlord', 'Commands the flow', 8500),
(19, 'Exploit Sovereign', 'Supreme payload mastery', 9000),
(20, 'C.O.H.S', 'Chief of Hacking Staff', 10000);

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
(5, 'OSCMD'),
(6, 'UPLOADer'),
(7, 'CLICKJACK'),
(8, 'SESSIONs'),
(9, 'DIRBRUTE'),
(10, 'XMLPARSER'),
(11, 'NOT HERE');

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
('MALE'),
('FEMALE');

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
(4, 'CTFBB812170105', '20', 'admin/admin/proofimages/vatar1337.png', '2025-10-23 14:30:06', 'approved', 'XSS', 'FIRM'),
(5, 'CTFXN410251144', '20', 'admin/admin/proofimages/vatar1337.png', '2025-10-23 14:30:06', 'approved', 'XSS', 'FIRM'),
(6, 'CTFXN410251144', '30', 'admin/admin/proofimages/vatar1337.png', '2025-10-24 14:30:06', 'approved', 'XSS', 'FIRM'),
(7, 'CTFHO910260316', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM'),
(8, 'CTFHO910260316', '20', 'admin/admin/proofimages/vatar1337.png', '2025-10-23 14:30:06', 'approved', 'XSS', 'FIRM'),
(9, 'CTFHO910260316', '0', 'admin/proofimages/Screenshot from 2025-10-20 16-36-30.png', '2025-10-23 12:10:27', 'pending', 'XSS', 'LOW'),
(10, 'CTFM4X1333337', '15', 'admin/proofimages/Screenshot from 2025-10-20 16-36-30.png', '2025-10-23 12:10:27', 'pending', 'LFI', 'LOW'),
(11, 'M4Z4NG33Z0', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM');

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
  `header2` varchar(1500) NOT NULL,
  `about` varchar(5000) NOT NULL,
  `disclaimer` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site`
--

INSERT INTO `site` (`id`, `sitename`, `header`, `header2`, `about`, `disclaimer`) VALUES
(1, 'M4XCTF™', 'A place for H4X0RS. Inspired by the classic green on black terminal style.', 'MAXCTF and its creators cannot be held liable for any misuse, misinterpretation, or unauthorized application of the content provided. Stay ethical. Stay curious. Hack responsibly.', 'MAXCTF is built for curious minds stepping into the world of Capture The Flag (CTF) hacking. Whether you\'re a total beginner or just exploring cybersecurity, this platform introduces the basics and gives you the confidence to participate. CTFs are competitive hacking events often hosted at infosec conferences like BSides, DEF CON, and local meetups. They feature challenges across web exploitation, reverse engineering, cryptography, forensics, and more — each designed to test your problem-solving skills and creativity.', 'Our mission is to inspire critical thinking and technical growth by presenting real-world scenarios in a safe, controlled environment. If you intend to misuse the knowledge gained here for unlawful purposes, we respectfully ask that you leave this site immediately.\r\n\r\nMAXCTF and its creators cannot be held liable for any misuse, misinterpretation, or unauthorized application of the content provided. Stay ethical. Stay curious. Hack responsibly.');

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
(1, 'N00B'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
