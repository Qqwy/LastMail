-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2014 at 08:02 PM
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
-- Table structure for table `lastmail_mails`
--

CREATE TABLE IF NOT EXISTS `lastmail_mails` (
  `mailid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `to` text,
  `subject` text,
  `message` mediumtext,
  `name` tinytext,
  `extradelay` int(11) NOT NULL COMMENT 'Days to wait after inactivity before sending this mail.',
  `wassent` tinyint(1) NOT NULL COMMENT '1 if the mail has been sent.',
  PRIMARY KEY (`mailid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `lastmail_mails`
--

INSERT INTO `lastmail_mails` (`mailid`, `userid`, `to`, `subject`, `message`, `name`, `extradelay`, `wassent`) VALUES
(1, 7, 'john@smith.com, test@someone.com, me@there.com, qqwy@gmx.com, W-M@gmx.us, wiebemarten@gmx.com, test@here.com, www@example.com, asdfthatfails.com, epic@ness.com', 'this is a test mail with a subject that is faaaar tooo looong!', 'ALSKJFLSKD:FJ:LSDKFJ<br>', NULL, 0, 0),
(2, 7, 'me@there.com', 'asdffda', 'jhfhjgfghfhjfhjfjh fhf <br><br><br><br><br>kjhjhghjgjkhgj<br>', NULL, 0, 0),
(3, 56, 'myself@somewhere.com', 'This is my subject', 'Hello there. It''s a lovely day.<br><p><br></p>', NULL, 0, 0),
(4, 15, 'W-M@gmx.us, wiebemarten@gmx.com, qqwy@gmx.com, qqwy@live.nl', 'This is my epic testmail.', 'We did''t start the flamewar!<br><br>This is epic fun =).<br><br>~W-M<br><p><br></p>', 'qqwy', 0, 0),
(5, 15, 'A second message', 'awe', 'asdf', 'Qqwy', 0, 0),
(6, 15, 'A second message', 'awe', 'asdf', 'Qqwy', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
