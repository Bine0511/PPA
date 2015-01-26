-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Jan 2015 um 14:22
-- Server Version: 5.6.21
-- PHP-Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `ppa-testdb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `moderator`
--

CREATE TABLE IF NOT EXISTS `moderator` (
`moderator_ID` int(15) NOT NULL,
  `moderator_name` varchar(50) NOT NULL,
  `moderator_pw` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `moderator`
--

INSERT INTO `moderator` (`moderator_ID`, `moderator_name`, `moderator_pw`) VALUES
(1, '1234moderator', '1234moderator'),
(2, 'testmoderator', 'testmoderator');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `session`
--

CREATE TABLE IF NOT EXISTS `session` (
`session_ID` int(15) NOT NULL,
  `session_name` varchar(50) NOT NULL,
  `session_pw` varchar(50) NOT NULL,
  `session_moderator_ID` int(15) NOT NULL,
  `session_basestory_id` int(15) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `session`
--

INSERT INTO `session` (`session_ID`, `session_name`, `session_pw`, `session_moderator_ID`, `session_basestory_id`) VALUES
(1, '1234', '1234', 1, 0),
(2, 'test', 'test', 2, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `timevote`
--

CREATE TABLE IF NOT EXISTS `timevote` (
`timevote_vote_id` int(15) NOT NULL,
  `timevote_userstory_id` int(15) NOT NULL,
  `timevote_session_id` int(15) NOT NULL,
  `timevote_value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_ID` int(15) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_session_ID` int(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_ID`, `user_name`, `user_session_ID`) VALUES
(1, 'Franz', 1),
(2, 'Herbert', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `userstory`
--

CREATE TABLE IF NOT EXISTS `userstory` (
`userstory_ID` int(15) NOT NULL,
  `userstory_session_ID` int(15) NOT NULL,
  `userstory_name` varchar(50) NOT NULL,
  `userstory_description` varchar(300) DEFAULT NULL,
  `userstory_average` varchar(20) DEFAULT NULL,
  `userstory_time_average` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `userstory`
--

INSERT INTO `userstory` (`userstory_ID`, `userstory_session_ID`, `userstory_name`, `userstory_description`, `userstory_average`, `userstory_time_average`) VALUES
(1, 1, 'Planung', 'Planungsdokumente erstellen', 0, ''),
(2, 2, 'Programmierung', 'Programmieren bis zum umfallen', 0, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `vote_user_ID` int(15) NOT NULL,
  `vote_userstory_ID` int(15) NOT NULL,
  `vote_session_id` int(15) NOT NULL,
  `value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `vote`
--

INSERT INTO `vote` (`vote_user_ID`, `vote_userstory_ID`, `vote_session_id`, `value`) VALUES
(1, 1, 1, '12'),
(2, 2, 2, '19');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `moderator`
--
ALTER TABLE `moderator`
 ADD PRIMARY KEY (`moderator_ID`), ADD UNIQUE KEY `moderator_ID_2` (`moderator_ID`), ADD KEY `moderator_ID` (`moderator_ID`);

--
-- Indizes für die Tabelle `session`
--
ALTER TABLE `session`
 ADD PRIMARY KEY (`session_ID`,`session_name`), ADD UNIQUE KEY `session_moderator_ID` (`session_moderator_ID`);

--
-- Indizes für die Tabelle `timevote`
--
ALTER TABLE `timevote`
 ADD PRIMARY KEY (`timevote_vote_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_ID`), ADD KEY `user_session_ID` (`user_session_ID`);

--
-- Indizes für die Tabelle `userstory`
--
ALTER TABLE `userstory`
 ADD PRIMARY KEY (`userstory_ID`,`userstory_session_ID`), ADD KEY `userstory_session_ID` (`userstory_session_ID`);

--
-- Indizes für die Tabelle `vote`
--
ALTER TABLE `vote`
 ADD PRIMARY KEY (`vote_user_ID`,`vote_userstory_ID`,`vote_session_id`), ADD KEY `vote_userstory_ID` (`vote_userstory_ID`), ADD KEY `vote_session_id` (`vote_session_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `moderator`
--
ALTER TABLE `moderator`
MODIFY `moderator_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `session`
--
ALTER TABLE `session`
MODIFY `session_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `timevote`
--
ALTER TABLE `timevote`
MODIFY `timevote_vote_id` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
MODIFY `user_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `userstory`
--
ALTER TABLE `userstory`
MODIFY `userstory_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `session`
--
ALTER TABLE `session`
ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`session_moderator_ID`) REFERENCES `moderator` (`moderator_ID`);

--
-- Constraints der Tabelle `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_session_ID`) REFERENCES `session` (`session_ID`);

--
-- Constraints der Tabelle `userstory`
--
ALTER TABLE `userstory`
ADD CONSTRAINT `userstory_ibfk_1` FOREIGN KEY (`userstory_session_ID`) REFERENCES `session` (`session_ID`);

--
-- Constraints der Tabelle `vote`
--
ALTER TABLE `vote`
ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`vote_userstory_ID`) REFERENCES `userstory` (`userstory_ID`),
ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`vote_user_ID`) REFERENCES `user` (`user_ID`),
ADD CONSTRAINT `vote_ibfk_3` FOREIGN KEY (`vote_session_id`) REFERENCES `session` (`session_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
