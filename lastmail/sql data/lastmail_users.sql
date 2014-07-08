-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2014 at 03:44 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `lastmail_users`
--

CREATE TABLE IF NOT EXISTS `lastmail_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID, Int, auto-increment primary',
  `email` tinytext COMMENT 'E-mail address',
  `password` text COMMENT 'hashed password of user',
  `last_activity` int(11) DEFAULT NULL COMMENT 'timestamp of last moment the user was online/logged in, or read a mail containing an image. ',
  `check_frequency` smallint(6) NOT NULL DEFAULT '7' COMMENT 'Time, in days, between checks. Default: once weekly. (i.e. 7)',
  `send_after` smallint(6) NOT NULL DEFAULT '30' COMMENT 'Time, in days, that needs to be passed after last_activity to send the mails connected to this user.',
  `haspassed` tinyint(1) NOT NULL DEFAULT '0' COMMENT ' Boolean, true if the user has passed away',
  `ukey` text NOT NULL COMMENT 'User-specific key to update activity',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `lastmail_users`
--

INSERT INTO `lastmail_users` (`userid`, `email`, `password`, `last_activity`, `check_frequency`, `send_after`, `haspassed`, `ukey`) VALUES
(1, 'test@something.com', '', 0, 7, 30, 0, ''),
(6, 'someone@something.com', 'd02e6f74a2209fa0778b0e5ee4186ff5f95c9c6c3e3c963ab36e7a28c31c9203bc63728cad7e74531470af8ed76503f837583fbf443f50e28780da325198bdf7', 0, 7, 30, 0, ''),
(7, 'test@asdf.com', '2a42b56254172ba20df34f58bd04a3b4a903007dda79b66df533577970900dc2e8d658cfcd45de372394b6382d4b51cefb42404b5efeb331a509357a3431b3a5', 0, 7, 30, 0, ''),
(8, 'asdf@asdf.com', '47b3da8f82c17c09c671a952b36aa197ad1facc249cf8be0b1fea7e3ff7c813f792a02c2826cb1a54ac9d01201d51e0113ac2c204fdf25a2e10bc64933d9c7be', 1401803023, 7, 30, 0, '123948987d9f1983274vjc'),
(9, 'some@asdf.com', '89dd1e05536fda2e3a5e9022621867473562131e34943fc5142d8a9e924336551da6ddfe42d79e662b3f535aaadfc7ddf87196d6e1ff597001b20329803c173b', 0, 7, 30, 0, ''),
(10, 'd@d.com', 'a46a37b2b370f989b3112be43f782c397f7304ca036f0e61d719a778e29191cce3a477a2215400788a2e7b293fd628acee778427eedf6abdd3daeaa29e4834c4', 0, 7, 30, 0, ''),
(11, '8@d.com', '4504289a2cc43b06edd760aa8db9362f008e45e15952067dad4c022d1644e4777f56e2be398eaa049f6e1a7b69335274129ad4b49c99694f1c428bf58e810c94', 0, 7, 30, 0, ''),
(12, '9@d.com', '667424cdbabaa436569eb2c999ece03a336fb01d1b6ff337f9ede9eaadceab2d7d8f935d82d002fd19affc0b05930388e8cadb12a01db87df7cde35b6931b34d', 0, 7, 30, 0, ''),
(13, '1@d.com', 'b8e9dcb60b14e0a56053eb3e2ca33017e5864217c772e2eedfe762a7aec94d4b72ab50f80c4afbdd5f88ed640e2575d8ef2fd301252d26dfc74d95dcaa643a40', 0, 7, 30, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
