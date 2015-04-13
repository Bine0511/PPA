-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 13. Apr 2015 um 10:19
-- Server Version: 5.6.21
-- PHP-Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `ppa-db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `moderator`
--

CREATE TABLE IF NOT EXISTS `moderator` (
`moderator_ID` int(15) NOT NULL,
  `moderator_name` varchar(50) NOT NULL,
  `moderator_pw` varchar(150) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=668 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `moderator`
--

INSERT INTO `moderator` (`moderator_ID`, `moderator_name`, `moderator_pw`, `remember_token`) VALUES
(1, '1234moderator', '1234moderator', NULL),
(2, 'testmoderator', 'testmoderator', NULL),
(666, 'Markus', 'markus', NULL),
(667, 'Moderator', '$2y$10$BEdNWqDfHmZoEIZQESFiMuZdipsWQTofUv5utbbJybqJCkqUUZA6y', 'qPnfvosRRMLWM21lOO7CAhOIZfdEo3Jeykvh42pJELraLDsDcPXTklJqeFBK');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `session`
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
  `sum_calc_time` varchar(10) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=668 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `session`
--

INSERT INTO `session` (`session_ID`, `session_name`, `session_pw`, `session_moderator_ID`, `session_basestory_id`, `avg_sum`, `avg_sum_base`, `avg_time_div_avg`, `sum_calc_time`, `remember_token`) VALUES
(1, '1234', '1234', 1, 1, '12.50', '7.25', '30.63', '0.00', ''),
(2, 'test', 'test', 2, 2, '13.50', '2.63', '3.93', '0.00', ''),
(666, 'Lobby', '666', 666, NULL, '', '', '', '', NULL),
(667, 'PPA', '$2y$10$QD1xbI6jPq3HzSNMaDn0XeM3knXhW2WZHlQpTC0EaWr', 667, 6, '', '', '', '', '4Il2waaKd0CQvVR4X4FDxPqQvQkLS5pUNR7xwfBlH3jUOFgtxvlsFOAwWnBh');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `timevote`
--

CREATE TABLE IF NOT EXISTS `timevote` (
  `timevote_user_id` int(15) NOT NULL,
  `timevote_userstory_id` int(15) NOT NULL,
  `timevote_session_id` int(15) NOT NULL,
  `timevote_value` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `timevote`
--

INSERT INTO `timevote` (`timevote_user_id`, `timevote_userstory_id`, `timevote_session_id`, `timevote_value`) VALUES
(1, 1, 1, '20'),
(1, 2, 1, '30'),
(2, 1, 1, '10'),
(3, 1, 2, '13'),
(3, 2, 2, '22'),
(4, 1, 2, '44'),
(4, 2, 2, '23'),
(23, 5, 667, '3'),
(23, 8, 667, '10'),
(23, 9, 667, '1'),
(24, 5, 667, '70'),
(24, 8, 667, '50'),
(24, 9, 667, '10');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_ID` int(15) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_session_ID` int(15) NOT NULL,
  `user_session_pw` varchar(100) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_ID`, `user_name`, `user_session_ID`, `user_session_pw`, `remember_token`) VALUES
(1, 'Franz', 1, '', NULL),
(2, 'Herbert', 1, '', NULL),
(3, 'Hiii', 2, '', NULL),
(4, 'Hoo', 2, '', NULL),
(5, 'Martin', 667, 'ppa', NULL),
(6, 'Martin', 667, 'ppa', NULL),
(7, 'Martin', 667, 'ppa', '7vac4MDNeUUp4ByZW7B6YhxNlV0rhvWXvjoBL793BVsrwSexbpppT3UFFJ0E'),
(8, 'Martin', 667, 'ppa', '8ui3XcO1btAqV8HdYUywbWjcEq9K3yhgiTeq7OqJVKQO9R7UKQx89pProxQN'),
(9, 'Martin', 667, 'ppa', NULL),
(10, 'Martin', 667, 'ppa', NULL),
(11, 'Martin', 667, 'ppa', NULL),
(12, 'Martin', 667, 'ppa', NULL),
(13, 'Dieter', 667, 'ppa', NULL),
(14, 'Martin', 667, 'ppa', NULL),
(15, 'Dieter', 667, 'ppa', NULL),
(16, 'Dieter', 667, 'ppa', NULL),
(17, 'Martin', 667, 'ppa', NULL),
(18, 'Dieter', 667, 'ppa', NULL),
(19, 'Dieter', 667, 'ppa', NULL),
(20, 'Martin', 667, 'ppa', NULL),
(21, 'Dieter', 667, 'ppa', NULL),
(22, 'Klaus', 667, 'ppa', '2rDtR8aC6ObiO6caJMNtXXSr844YEJ0F1ZVW4v67DmwABOzcEGe7JpALP8Nq'),
(23, 'Dieter', 667, 'ppa', NULL),
(24, 'Lari', 667, 'ppa', 'aDmoelethTXiA8DAw8LXyhUd6PLSt6ITDboUKz6zCzcanngnxkisVW8mouQb');

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
  `userstory_time_average` varchar(20) DEFAULT NULL,
  `userstory_timeavg_div_avg` varchar(6) NOT NULL,
  `calc_time` varchar(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `userstory`
--

INSERT INTO `userstory` (`userstory_ID`, `userstory_session_ID`, `userstory_name`, `userstory_description`, `userstory_average`, `userstory_time_average`, `userstory_timeavg_div_avg`, `calc_time`) VALUES
(1, 1, 'Planung', 'Planungsdokumente erstellen', '12.00', '15.00', '1.25', '0.00'),
(1, 2, 'Test1', NULL, '8.50', '28.50', '1.25', '0.00'),
(1, 666, 'Das ist die Nummer 1', 'Nummer 1 ist einfach die beste weil Sie so super toll ist', NULL, NULL, '1.25', '0.00'),
(2, 1, 'Programmierung', 'Programmieren bis zum umfallen', '0.50', '30.00', '60.00', '0.00'),
(2, 2, 'Test2', 'dd', '5.00', '22.50', '60.00', '0.00'),
(2, 666, 'Das ist die Nummer 2', 'Nummer 2 ist einfach die beste weil Sie so super toll ist', NULL, NULL, '60.00', '0.00'),
(3, 666, 'Das ist die Nummer 3', 'Nummer 3 ist einfach die beste weil Sie so super toll ist', NULL, NULL, '', '0.00'),
(4, 666, 'Das ist die Nummer 4', 'Nummer 4 ist einfach die beste weil Sie so super toll ist', NULL, NULL, '', '0.00'),
(5, 667, 'Planen', 'Planen ist ganz toll den es ist so toll toll toll', '22.50', NULL, '', '0.00'),
(6, 667, 'Programmieren', 'Programmieren ist ganz toll den es ist so toll toll toll toll toll toll toll toll', NULL, NULL, '', '0.00'),
(7, 667, 'Marketing', 'Marketing ist ganz toll den es ist so toll toll toll toll toll toll toll toll', NULL, NULL, '', '0.00'),
(8, 667, 'Ausflug', 'AUch Freizeit  muss sein', NULL, NULL, '', '0.00'),
(9, 667, 'Datenbank', 'Datenbanken braucht man immer', NULL, NULL, '', '0.00');

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
(1, 2, 1, 'coffee'),
(2, 1, 1, '?'),
(2, 2, 1, '0.5'),
(3, 1, 2, '12'),
(3, 2, 2, '2'),
(4, 1, 2, '5'),
(4, 2, 2, '8'),
(23, 5, 667, '5'),
(23, 7, 667, '5'),
(23, 8, 667, '13'),
(23, 9, 667, '40'),
(24, 5, 667, '40'),
(24, 7, 667, '20'),
(24, 8, 667, 'coffee'),
(24, 9, 667, '20');

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
 ADD PRIMARY KEY (`timevote_user_id`,`timevote_userstory_id`,`timevote_session_id`), ADD KEY `timevote_userstory_id` (`timevote_userstory_id`), ADD KEY `timevote_session_id` (`timevote_session_id`);

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
MODIFY `moderator_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=668;
--
-- AUTO_INCREMENT für Tabelle `session`
--
ALTER TABLE `session`
MODIFY `session_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=668;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
MODIFY `user_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT für Tabelle `userstory`
--
ALTER TABLE `userstory`
MODIFY `userstory_ID` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
