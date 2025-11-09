-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 08, 2025 at 08:59 AM
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
  `ctfpassword` varchar(1000) NOT NULL COMMENT 'password',
  `farko` varchar(11) DEFAULT NULL COMMENT 'basic if uuser bypass d html reg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `ctfid`, `ctfname`, `ctfscore`, `joined`, `ctfskillset`, `gender`, `ctfemail`, `ctfpassword`, `farko`) VALUES
(1, 'CTFM4X1337', 'Al0new0lf', 115, '2019-12-17', 'noob', 'male', 'shettimax@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(2, 'BL4KXPL6', 'BXP6', 500, '2020-02-16', '1337', 'male', 'black@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(3, 'M4Z4NG33Z0', 'MZGZ', 1140, '2021-12-16', '1337', 'male', 'mzgz@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(4, 'C0BR47A73', 'KingCobra', 1500, '2022-10-25', 'noob', 'male', 'cobra@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(5, 'CTFXG33W4', '0xvince', 2003, '2023-11-05', 'N00B', 'male', '0xvince@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(6, 'CTF3XL0V44', 'XL0V3R', 2500, '2024-09-16', '1337', 'MALE', 'XL0V3R@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(10, 'CTFHO910260316', 'kiralina', 3095, '2025-10-26', 'N00B', 'FEMALE', 'kira@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(11, 'CTFHO60316', 'DMP', 3717, '2025-10-27', 'N00B', 'FEMALE', 'dudu@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(12, 'CTFVH310290308', 'emsonj4y', 29, '2025-10-29', 'N00B', 'MALE', 'emsonj4y@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1'),
(13, 'CTFQJ110291223', 'maxinjector', 23, '2025-10-29', '1337', 'MALE', 'maxinjector@1337.co', '0eb9ea0bef58bbe654059ac7e27f67c2e8eb9240', '1');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(20) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'ctfadmin', 'admin@maxctf.xyz', '$2y$10$JKsviA8XtBmgRpsmtBXXyemW.2oCS2JHco.ns6UTIjZSmu.zajZ3e', 'admin'),
(2, 'ctfmod', 'mod@maxctf.xyz', '$2y$10$JKsviA8XtBmgRpsmtBXXyemW.2oCS2JHco.ns6UTIjZSmu.zajZ3e', 'mod'),
(3, 'mazang1z0', 'mzgz@maxctf.xyz', '$2y$10$JKsviA8XtBmgRpsmtBXXyemW.2oCS2JHco.ns6UTIjZSmu.zajZ3e', 'admin'),
(4, 'ctfadmin2', 'ctfadmin2@1337.xyz', '$2y$10$hkB0LXKUCkBBTjJtY9Dym.Uak40utL8eB7u0REdybG5G/uTXoHHfO', 'admin'),
(5, 'kira', 'kira@1337.co', '$2y$10$ae0GuWiXOw3.3A6EX/gX3OQW2Y.POEmAUjWqSFGuKbHY2vAxxzYcu', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `auditlog`
--

CREATE TABLE `auditlog` (
  `id` int(11) NOT NULL,
  `admin` varchar(50) DEFAULT NULL,
  `action` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auditlog`
--

INSERT INTO `auditlog` (`id`, `admin`, `action`, `timestamp`) VALUES
(1, 'ctfadmin', 'Approved flag ID 9 for CTFHO910260316 with note: ', '2025-11-02 17:36:02'),
(2, 'ctfadmin', 'Approved flag ID 11 for M4Z4NG33Z0 with note: xx', '2025-11-02 17:36:30'),
(3, 'ctfadmin', 'Approved flag ID 9 for CTFHO910260316 with note: xx', '2025-11-02 17:41:55'),
(4, 'ctfadmin', 'Approved flag ID 11 for M4Z4NG33Z0 with note: ccc', '2025-11-02 17:50:06'),
(5, 'ctfadmin', 'Rejected flag ID 10 for CTFM4X1333337 with reason: ccc', '2025-11-02 17:50:13'),
(6, 'ctfadmin', 'Approved flag ID 12 for M4Z4NG33Z0 with note: zz', '2025-11-02 18:09:52'),
(7, 'ctfadmin', 'Approved flag ID 13 for M4Z4NG33Z0 with note: ee', '2025-11-02 18:15:21'),
(8, 'ctfadmin', 'Approved flag ID 14 for M4Z4NG33Z0 with note: dfg', '2025-11-02 18:24:06'),
(9, 'ctfadmin', 'Updated user BL4KXPL6', '2025-11-02 19:18:14'),
(10, 'ctfadmin', 'Updated user BL4KXPL6', '2025-11-02 19:23:11'),
(11, 'ctfadmin', 'Created new admin ctfadmin2', '2025-11-02 19:34:48'),
(12, 'ctfadmin', 'Edited admin ctfadmin', '2025-11-02 19:41:03'),
(13, 'ctfadmin2', 'Logged in', '2025-11-03 09:14:53'),
(14, 'ctfadmin2', 'Logged in', '2025-11-03 09:19:35'),
(15, 'ctfadmin2', 'Logged in', '2025-11-03 09:27:10'),
(16, 'ctfadmin2', 'Logged in', '2025-11-03 09:28:05'),
(17, 'ctfadmin2', 'Edited admin ctfadmin', '2025-11-03 10:16:18'),
(18, 'ctfadmin2', 'Edited admin ctfadmin', '2025-11-03 10:16:29'),
(19, '', 'Updated user BL4KXPL6', '2025-11-03 14:38:22'),
(20, 'ctfadmin2', 'Logged in', '2025-11-03 14:38:45'),
(21, 'ctfadmin2', 'Approved flag ID 15 for M4Z4NG33Z0 with note: ', '2025-11-03 14:43:32'),
(22, 'ctfadmin2', 'Approved flag ID 15 for M4Z4NG33Z0 with note: ', '2025-11-03 14:45:32'),
(23, 'ctfadmin2', 'Logged in', '2025-11-03 15:38:58'),
(24, 'ctfadmin2', 'Logged in', '2025-11-03 15:41:25'),
(25, 'ctfadmin2', 'Logged in', '2025-11-03 23:06:19'),
(26, 'ctfadmin2', 'Approved flag ID 16 for CTFHO60316 with note: confirmed', '2025-11-03 23:06:57'),
(27, 'ctfadmin2', 'Approved flag ID 16 for CTFHO60316 with note: good', '2025-11-03 23:20:01'),
(28, 'ctfadmin2', 'Approved flag ID 16 for CTFHO60316 with note: good boy', '2025-11-03 23:23:12'),
(29, 'ctfadmin2', 'Rejected flag ID 16 for CTFHO60316 with reason: uwaka', '2025-11-03 23:24:08'),
(30, 'ctfadmin2', 'Logged in', '2025-11-04 10:07:54'),
(31, 'ctfadmin2', 'Approved flag ID 16 for CTFHO60316 with note: good good', '2025-11-04 10:16:33'),
(32, 'ctfadmin2', 'Rejected flag ID 17 for CTFHO910260316 with reason: kai karyace', '2025-11-04 10:16:48'),
(33, 'ctfadmin2', 'Edited admin ctfadmin', '2025-11-04 10:49:58'),
(34, 'ctfadmin2', 'Edited admin ctfadmin', '2025-11-04 10:50:13'),
(35, 'ctfadmin2', 'Edited admin ctfadmin', '2025-11-04 10:50:33'),
(36, 'ctfadmin2', 'Edited admin ctfadmin', '2025-11-04 10:50:45'),
(37, 'ctfadmin2', 'Edited admin ctfadmin', '2025-11-04 11:09:52'),
(38, 'ctfadmin2', 'Updated user BL4KXPL6', '2025-11-04 12:02:52'),
(39, 'ctfadmin2', 'Updated user BL4KXPL6', '2025-11-04 12:03:08'),
(40, 'ctfadmin2', 'Logged in', '2025-11-04 16:25:22'),
(41, 'ctfadmin2', 'Edited admin ctfadmin', '2025-11-04 16:27:38'),
(42, 'ctfadmin2', 'Logged in', '2025-11-04 17:20:59'),
(43, 'ctfadmin2', 'Logged in', '2025-11-04 17:44:58'),
(44, 'ctfadmin2', 'Logged in', '2025-11-04 17:51:30'),
(45, 'ctfadmin2', 'Updated user BL4KXPL6', '2025-11-04 17:57:10'),
(46, 'ctfadmin2', 'Created new admin kira', '2025-11-04 18:11:16'),
(47, 'ctfadmin2', 'Updated user BL4KXPL6', '2025-11-04 18:38:02'),
(48, 'ctfadmin2', 'Approved flag ID 17 for CTFHO910260316 with note: cool', '2025-11-04 18:39:47'),
(49, 'ctfadmin2', 'Updated badge ShadowCoder', '2025-11-04 19:07:42'),
(50, 'ctfadmin2', 'Logged in', '2025-11-05 09:56:08'),
(51, 'ctfadmin2', 'Updated user BL4KXPL6', '2025-11-05 09:56:19'),
(52, 'ctfadmin2', 'Updated user BL4KXPL6', '2025-11-05 09:56:23'),
(53, 'ctfadmin2', 'Updated badge n00b', '2025-11-05 09:56:59'),
(54, 'ctfadmin2', 'Updated badge n00b', '2025-11-05 09:57:04'),
(55, 'ctfadmin2', 'Updated challenge: SQLi101', '2025-11-05 10:02:08'),
(56, 'ctfadmin2', 'Updated challenge: SQLi101', '2025-11-05 10:02:24'),
(57, 'ctfadmin2', 'Updated challenge: XSS101', '2025-11-05 10:03:03'),
(58, 'ctfadmin2', 'Logged in', '2025-11-06 11:07:50'),
(59, 'ctfadmin2', 'Rejected flag ID 17 for CTFHO910260316 with reason: na lie', '2025-11-06 11:08:37'),
(60, 'ctfadmin2', 'Updated user BL4KXPL6', '2025-11-06 11:09:16'),
(61, 'ctfadmin2', 'Updated user BL4KXPL6', '2025-11-06 11:09:21'),
(62, 'ctfadmin2', 'Logged in', '2025-11-07 11:24:54'),
(63, 'ctfadmin2', 'Approved flag ID 17 for CTFHO910260316 with note: good catch', '2025-11-07 11:25:32'),
(64, 'ctfadmin2', 'Updated target: MCTFVWA', '2025-11-07 11:34:14'),
(65, 'ctfadmin2', 'Updated target: MCTFVWA', '2025-11-07 11:34:18');

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
(3, 'CSRF'),
(4, 'MANIPULATION'),
(5, 'AUTH'),
(6, 'UPLOADer'),
(7, 'IDOR'),
(8, 'SESSIONs'),
(9, 'DIRBRUTE'),
(10, 'XMLPARSER'),
(11, 'NOT HERE');

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `points` int(11) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'active',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`id`, `title`, `description`, `points`, `category`, `status`, `start_time`, `end_time`, `target_id`) VALUES
(1, 'SQLi', 'SQLi101', 15, 'WebAppSecurity', 'active', '2025-11-03 14:22:00', '2027-08-27 14:22:00', 1),
(2, 'XSS', 'XSS101', 15, 'WebAppSecurity', 'inactive', '2025-11-03 16:42:00', '2025-11-04 13:47:00', 1),
(3, 'IDOR', 'find as many IDOR you can and submit on the go.', 15, 'WebAppSecurity', 'active', '2025-11-04 01:02:00', '2027-02-04 01:02:00', 1),
(4, 'UPLOAD', 'run as many UPLOAD bypass you can and submit POC on the go.', 15, 'WebAppSecurity', 'active', '2025-11-04 01:06:00', '2026-02-28 04:06:00', 1),
(5, 'CSRF101', 'find as many CSRF you can and submit POC on the go.', 15, 'WebAppSecurity', 'active', '2025-11-04 01:08:00', '2027-05-22 01:08:00', 1),
(6, 'AUTHBYPASS', 'bypass as many AUTH you can and submit POC on the go.', 15, 'WebAppSecurity', 'active', '2025-11-04 01:12:00', '2027-10-09 01:12:00', 1),
(7, 'B-LOGIC', 'manipulate your way around this BUSINESS LOGIC and submit POC on the go', 15, 'WebAppSecurity', 'active', '2025-11-04 01:23:00', '2027-10-28 01:23:00', 1);

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
-- Table structure for table `dp`
--

CREATE TABLE `dp` (
  `id` int(11) NOT NULL,
  `gender` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dp`
--

INSERT INTO `dp` (`id`, `gender`) VALUES
(1, 1),
(2, 2);

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
-- Table structure for table `modlog`
--

CREATE TABLE `modlog` (
  `id` int(11) NOT NULL,
  `modname` varchar(50) DEFAULT NULL,
  `action` text,
  `targetid` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `severity` varchar(15) NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='bugsubmissions';

--
-- Dumping data for table `reportx`
--

INSERT INTO `reportx` (`id`, `walletid`, `amount`, `proofimage`, `date`, `status`, `bug`, `severity`, `notes`) VALUES
(1, 'MXS4F96TOK0', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM', ''),
(2, 'CTFBB812170105', '20', 'admin/proofimages/Screenshot from 2025-10-20 16-36-30.png', '2025-10-23 12:10:27', 'approved', 'XSS', 'LOW', ''),
(3, 'CTFBB137987489', '100', 'proof.jpg', '2025-10-23 13:14', 'approved', 'XSS', 'high', ''),
(4, 'CTFBB812170105', '20', 'admin/admin/proofimages/vatar1337.png', '2025-10-23 14:30:06', 'approved', 'XSS', 'FIRM', ''),
(5, 'CTFXN410251144', '20', 'admin/admin/proofimages/vatar1337.png', '2025-10-23 14:30:06', 'approved', 'XSS', 'FIRM', ''),
(6, 'CTFXN410251144', '30', 'admin/admin/proofimages/vatar1337.png', '2025-10-24 14:30:06', 'approved', 'XSS', 'FIRM', ''),
(7, 'CTFHO910260316', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM', ''),
(8, 'CTFHO910260316', '20', 'admin/admin/proofimages/vatar1337.png', '2025-10-23 14:30:06', 'approved', 'XSS', 'FIRM', ''),
(9, 'CTFHO910260316', '0', 'admin/proofimages/Screenshot from 2025-10-20 16-36-30.png', '2025-10-23 12:10:27', 'approved', 'XSS', 'LOW', 'xx'),
(10, 'CTFM4X1333337', '15', 'admin/proofimages/Screenshot from 2025-10-20 16-36-30.png', '2025-10-23 12:10:27', 'rejected', 'LFI', 'LOW', 'ccc'),
(11, 'M4Z4NG33Z0', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM', 'ccc'),
(12, 'M4Z4NG33Z0', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM', 'zz'),
(13, 'M4Z4NG33Z0', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM', 'ee'),
(14, 'M4Z4NG33Z0', '20', 'admin/proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM', 'trying to drop a long submission text to text some functionalities in admin dashboard trying to drop a long submission text to text some functionalities in admin dashboard trying to drop a long submission text to text some functionalities in admin dashboard trying to drop a long submission text to text some functionalities in admin dashboard'),
(15, 'M4Z4NG33Z0', '20', 'proofimages/mclcnew1.png', '2020-12-19 03:12:33', 'approved', 'XSS', 'MEDIUM', ''),
(16, 'CTFHO60316', '13', 'admin/proofimages/CTFHO60316_1762211043.png', '2025-11-04 00:04:03', 'approved', 'IDOR', 'MEDIUM', 'good good'),
(17, 'CTFHO910260316', '13', 'admin/proofimages/CTFHO910260316_1762249624.jpeg', '2025-11-04 10:47:04', 'approved', 'CSRF', 'MEDIUM', 'good catch');

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
-- Table structure for table `solves`
--

CREATE TABLE `solves` (
  `id` int(11) NOT NULL,
  `ctfid` varchar(50) DEFAULT NULL,
  `challenge_id` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `targets`
--

CREATE TABLE `targets` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'active',
  `difficulty` varchar(20) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `targets`
--

INSERT INTO `targets` (`id`, `name`, `path`, `status`, `difficulty`, `category`) VALUES
(1, 'MCTFVWA', 'mctfvwa', 'active', 'easy', 'WebAppSecurity');

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
-- Indexes for table `auditlog`
--
ALTER TABLE `auditlog`
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
-- Indexes for table `challenges`
--
ALTER TABLE `challenges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ctfs`
--
ALTER TABLE `ctfs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp`
--
ALTER TABLE `dp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modlog`
--
ALTER TABLE `modlog`
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
-- Indexes for table `solves`
--
ALTER TABLE `solves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `targets`
--
ALTER TABLE `targets`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `auditlog`
--
ALTER TABLE `auditlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `challenges`
--
ALTER TABLE `challenges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ctfs`
--
ALTER TABLE `ctfs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dp`
--
ALTER TABLE `dp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modlog`
--
ALTER TABLE `modlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- AUTO_INCREMENT for table `solves`
--
ALTER TABLE `solves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `targets`
--
ALTER TABLE `targets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Y3J5cHRzYWxnb3JpdGht`
--
ALTER TABLE `Y3J5cHRzYWxnb3JpdGht`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
