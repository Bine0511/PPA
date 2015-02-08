-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2015 at 11:35 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ppa-testdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `moderator`
--

CREATE TABLE IF NOT EXISTS `moderator` (
`moderator_ID` int(15) NOT NULL,
  `moderator_name` varchar(50) NOT NULL,
  `moderator_pw` varchar(150) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `moderator`
--

INSERT INTO `moderator` (`moderator_ID`, `moderator_name`, `moderator_pw`) VALUES
(1, '1234moderator', '1234moderator'),
(2, 'testmoderator', 'testmoderator');

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
`session_ID` int(15) NOT NULL,
  `session_name` varchar(50) NOT NULL,
  `session_pw` varchar(50) NOT NULL,
  `session_moderator_ID` int(15) NOT NULL,
  `session_basestory_id` int(15) DEFAULT NULL,
  `avg_sum` varchar(20) NOT NULL,
  `avg_sum_base` varchar(20) NOT NULL,
  `avg_time_div_avg` varchar(20) NOT NULL,
  `sum_calc_time` varchar(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`session_ID`, `session_name`, `session_pw`, `session_moderator_ID`, `session_basestory_id`, `avg_sum`, `avg_sum_base`, `avg_time_div_avg`, `sum_calc_time`) VALUES
(1, '1234', '1234', 1, 1, '17.25', '15.5', '5.48385', '94.5957'),
(2, 'test', 'test', 2, 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `timevote`
--

CREATE TABLE IF NOT EXISTS `timevote` (
  `timevote_user_id` int(15) NOT NULL,
  `timevote_userstory_id` int(15) NOT NULL,
  `timevote_session_id` int(15) NOT NULL,
  `timevote_value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `timevote`
--

INSERT INTO `timevote` (`timevote_user_id`, `timevote_userstory_id`, `timevote_session_id`, `timevote_value`) VALUES
(1, 1, 1, '20'),
(1, 2, 1, '30'),
(2, 1, 1, '10'),
(2, 2, 1, '5');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_ID` int(15) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_session_ID` int(15) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `user_name`, `user_session_ID`) VALUES
(1, 'Franz', 1),
(2, 'Herbert', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userstory`
--

CREATE TABLE IF NOT EXISTS `userstory` (
`userstory_ID` int(15) NOT NULL,
  `userstory_session_ID` int(15) NOT NULL,
  `userstory_name` varchar(50) NOT NULL,
  `userstory_description` varchar(300) DEFAULT NULL,
  `userstory_average` varchar(20) DEFAULT NULL,
  `userstory_time_average` varchar(20) DEFAULT NULL,
  `userstory_timeavg_div_avg` varchar(6) NOT NULL,
  `calc_time` varchar(6) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `userstory`
--

INSERT INTO `userstory` (`userstory_ID`, `userstory_session_ID`, `userstory_name`, `userstory_description`, `userstory_average`, `userstory_time_average`, `userstory_timeavg_div_avg`, `calc_time`) VALUES
(1, 1, 'Planung', 'Planungsdokumente erstellen', '15.5', '15', '0.9677', '84.999'),
(2, 1, 'Programmierung', 'Programmieren bis zum umfallen', '1.75', '17.5', '10', '9.5967');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `vote_user_ID` int(15) NOT NULL,
  `vote_userstory_ID` int(15) NOT NULL,
  `vote_session_id` int(15) NOT NULL,
  `value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`vote_user_ID`, `vote_userstory_ID`, `vote_session_id`, `value`) VALUES
(1, 1, 1, '12'),
(1, 2, 1, '3'),
(2, 1, 1, '19'),
(2, 2, 1, '0.5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `moderator`
--
ALTER TABLE `moderator`
 ADD PRIMARY KEY (`moderator_ID`), ADD UNIQUE KEY `moderator_ID_2` (`moderator_ID`), ADD KEY `moderator_ID` (`moderator_ID`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
 ADD PRIMARY KEY (`session_ID`,`session_name`), ADD UNIQUE KEY `session_moderator_ID` (`session_moderator_ID`);

--
-- Indexes for table `timevote`
--
ALTER TABLE `timevote`
 ADD PRIMARY KEY (`timevote_user_id`,`timevote_userstory_id`,`timevote_session_id`), ADD KEY `timevote_userstory_id` (`timevote_userstory_id`), ADD KEY `timevote_session_id` (`timevote_session_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_ID`), ADD KEY `user_session_ID` (`user_session_ID`);

--
-- Indexes for table `userstory`
--
ALTER TABLE `userstory`
 ADD PRIMARY KEY (`userstory_ID`,`userstory_session_ID`), ADD KEY `userstory_session_ID` (`userstory_session_ID`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
 ADD PRIMARY KEY (`vote_user_ID`,`vote_userstory_ID`,`vote_session_id`), ADD KEY `vote_userstory_ID` (`vote_userstory_ID`), ADD KEY `vote_session_id` (`vote_session_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `moderator`
--
ALTER TABLE `moderator`
MODIFY `moderator_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
MODIFY `session_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `user_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `userstory`
--
ALTER TABLE `userstory`
MODIFY `userstory_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
