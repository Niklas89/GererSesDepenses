-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 18, 2012 at 02:38 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gerersesdepenses`
--

-- --------------------------------------------------------

--
-- Table structure for table `depenses`
--

CREATE TABLE IF NOT EXISTS `depenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_users` int(11) NOT NULL,
  `description` text NOT NULL,
  `coldate` datetime NOT NULL,
  `montant` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `depenses`
--

INSERT INTO `depenses` (`id`, `id_users`, `description`, `coldate`, `montant`) VALUES
(1, 71, 'dsfdsfsdfdsf ', '0000-00-00 00:00:00', 35),
(2, 71, 'gasfdsad', '0000-00-00 00:00:00', 23),
(3, 2, 'asdsadsa', '0000-00-00 00:00:00', 56),
(4, 71, 'hehe', '0000-00-00 00:00:00', 55),
(5, 71, 'pas cher', '0000-00-00 00:00:00', 25),
(6, 71, 'asd', '0000-00-00 00:00:00', 34),
(7, 71, 'werw', '0000-00-00 00:00:00', 56),
(8, 71, '', '0000-00-00 00:00:00', 23),
(9, 71, '', '0000-00-00 00:00:00', 67),
(10, 71, '', '0000-00-00 00:00:00', 23),
(13, 71, 'deuxieme semaine', '0000-00-00 00:00:00', 34),
(14, 71, '2eme semaien', '0000-00-00 00:00:00', 56),
(15, 71, '2eme semaine', '0000-00-00 00:00:00', 56),
(16, 71, '2eme semaine', '0000-00-00 00:00:00', 25),
(17, 71, '2eme semaine', '0000-00-00 00:00:00', 12),
(18, 71, '2eme semaine', '2012-03-16 11:22:51', 6),
(19, 2, 'adasdsad as', '0000-00-00 00:00:00', 34),
(20, 71, 'asdad', '2012-04-03 16:24:40', 23),
(21, 71, 'gdg df', '2012-04-17 16:24:51', 67),
(22, 71, 'hehe', '2012-04-17 16:48:20', 56),
(23, 71, 'hrhr', '2012-04-17 16:48:59', 45),
(24, 71, 'hrhr', '2012-04-24 16:51:32', 45),
(25, 71, 'asda sd', '2012-04-18 12:54:55', 89),
(26, 73, 'wefwe', '2012-04-18 13:49:32', 23);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pass` varchar(255) COLLATE utf8_bin NOT NULL,
  `fname` varchar(100) COLLATE utf8_bin NOT NULL,
  `lname` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(200) COLLATE utf8_bin NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(30) COLLATE utf8_bin NOT NULL,
  `login` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=74 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pass`, `fname`, `lname`, `email`, `date`, `ip`, `login`) VALUES
(71, '123123213123213', 'niklas', 'edelstam', 'email@hotmail.com', '2012-04-16 07:21:52', '127.0.0.1', 'niklas'),
(70, '1231312312312', 'niklas', 'edelstam', 'niklas@email.com', '2012-04-16 07:21:20', '127.0.0.1', 'niklastest'),
(72, '123123213123213', 'jules', 'verbe', 'jules@email.com', '2012-04-18 13:17:39', '127.0.0.1', 'jules'),
(73, '123123213123213', 'broden', 'daniel', 'daniel@broden.com', '2012-04-18 13:44:17', '127.0.0.1', 'daniel');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
