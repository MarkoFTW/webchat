-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Gostitelj: localhost
-- Čas nastanka: 05 apr 2015 ob 03.07
-- Različica strežnika: 5.5.41
-- Različica PHP: 5.5.23-1+deb.sury.org~precise+2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Zbirka podatkov: `testchat`
--

-- --------------------------------------------------------

--
-- Struktura tabele `censor`
--

CREATE TABLE IF NOT EXISTS `censor` (
  `CensorID` int(11) NOT NULL AUTO_INCREMENT,
  `Word` varchar(254) COLLATE utf8_slovenian_ci NOT NULL,
  `Replacement` varchar(254) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`CensorID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktura tabele `chats`
--

CREATE TABLE IF NOT EXISTS `chats` (
  `ChatID` int(11) NOT NULL AUTO_INCREMENT,
  `MsgUserID` int(11) NOT NULL,
  `Message` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `Time` varchar(30) NOT NULL,
  PRIMARY KEY (`ChatID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Struktura tabele `emoticons`
--

CREATE TABLE IF NOT EXISTS `emoticons` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Emote` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  `Picture` varchar(255) COLLATE utf8_slovenian_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Struktura tabele `online`
--

CREATE TABLE IF NOT EXISTS `online` (
  `OnlineID` int(11) NOT NULL,
  `Seen` varchar(30) NOT NULL,
  `LoginTime` varchar(30) NOT NULL,
  UNIQUE KEY `OnlineID` (`OnlineID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabele `private_msg`
--

CREATE TABLE IF NOT EXISTS `private_msg` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `group_hash` int(11) DEFAULT NULL,
  `from_id` int(11) DEFAULT NULL,
  `message` varchar(255) COLLATE utf8_slovenian_ci DEFAULT NULL,
  `msg_time` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struktura tabele `private_msg_groups`
--

CREATE TABLE IF NOT EXISTS `private_msg_groups` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL,
  `hash` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Email` varchar(50) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `Password` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci,
  `Access` int(11) DEFAULT NULL,
  `IP_ADDR` varchar(255) DEFAULT NULL,
  `Country` varchar(255) DEFAULT NULL,
  `Type` int(11) DEFAULT NULL,
  `Created` datetime NOT NULL,
  `Birthday` date NOT NULL,
  `Last_seen` datetime NOT NULL,
  `Gender` int(1) NOT NULL,
  `Censor` int(1) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Odloži podatke za tabelo `emoticons`
--

INSERT INTO `emoticons` (`ID`, `Emote`, `Picture`) VALUES
(1, ':)', 'smiling.png'),
(2, ':P', 'tongue_out.png'),
(3, ':*', 'kissing.png'),
(4, ':O', 'gasping.png'),
(5, ':@', 'angry.png'),
(6, ':S', 'confused.png'),
(7, 'B)', 'cool.png'),
(8, ':3', 'cute.png'),
(9, ';3', 'cute_winking.png'),
(10, '(6)', 'devil.png'),
(11, ':(', 'frowning.png'),
(12, ':D', 'happy.png'),
(13, '<3', 'heart.png'),
(14, 'XD', 'laughing.png'),
(15, ':X', 'lips_sealed.png'),
(16, '>:D', 'malicious.png'),
(17, ':C', 'pouting.png'),
(18, '^^', 'shy.png'),
(19, ':|', 'speechless.png'),
(20, 'o.0', 'surprised.png'),
(21, '-.-', 'tired.png'),
(22, ':\\', 'unsure.png'),
(23, ':/', 'unsure_2.png'),
(24, ';)', 'winking.png'),
(25, ':p', 'tongue_out.png'),
(26, ':o', 'gasping.png'),
(27, ':s', 'confused.png'),
(28, ':d', 'happy.png'),
(29, 'xd', 'laughing.png'),
(30, 'Xd', 'laughing.png'),
(31, 'xD', 'laughing.png'),
(32, ':x', 'lips_sealed.png'),
(33, '>:d', 'malicious.png'),
(34, ':c', 'pouting.png'),
(35, '0.o', 'surprised.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
