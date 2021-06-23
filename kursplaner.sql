-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 23. Jun 2021 um 16:45
-- Server-Version: 10.1.21-MariaDB
-- PHP-Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `kursplaner`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin`
--

CREATE TABLE `admin` (
  `UID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `admin`
--

INSERT INTO `admin` (`UID`) VALUES
(1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `appointment`
--

CREATE TABLE `appointment` (
  `AID` int(11) NOT NULL,
  `day` int(5) NOT NULL,
  `timeslot` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `appointment`
--

INSERT INTO `appointment` (`AID`, `day`, `timeslot`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 2, 1),
(7, 2, 2),
(8, 2, 3),
(9, 2, 4),
(10, 2, 5),
(11, 3, 1),
(12, 3, 2),
(13, 3, 3),
(14, 3, 4),
(15, 3, 5),
(16, 4, 1),
(17, 4, 2),
(18, 4, 3),
(19, 4, 4),
(20, 4, 5),
(21, 5, 1),
(22, 5, 2),
(23, 5, 3),
(24, 5, 4),
(25, 5, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `class`
--

CREATE TABLE `class` (
  `KID` int(11) NOT NULL,
  `token` varchar(11) NOT NULL,
  `homework` varchar(200) NOT NULL,
  `lk` tinyint(1) NOT NULL,
  `SID` int(11) NOT NULL,
  `TID` int(11) NOT NULL,
  `subject` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `class`
--

INSERT INTO `class` (`KID`, `token`, `homework`, `lk`, `SID`, `TID`, `subject`) VALUES
(1, 'LKG01', 'Seite 17 im Buch\r\n-user3', 1, 3, 4, 'Geschichte'),
(2, 'GKE01', '', 0, 5, 4, 'English'),
(3, 'LKM01', '', 1, 5, 5, 'Mathe');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `exam`
--

CREATE TABLE `exam` (
  `KID` int(11) NOT NULL,
  `date` date NOT NULL,
  `topic` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `exam`
--

INSERT INTO `exam` (`KID`, `date`, `topic`) VALUES
(1, '2021-06-15', 'Herbert der Große'),
(1, '2021-08-24', 'Ich! Ich! Ich!\r\n(Egoismus)');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `student`
--

CREATE TABLE `student` (
  `UID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `student`
--

INSERT INTO `student` (`UID`) VALUES
(2),
(3),
(5),
(6),
(7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `take`
--

CREATE TABLE `take` (
  `KID` int(11) NOT NULL,
  `UID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `take`
--

INSERT INTO `take` (`KID`, `UID`) VALUES
(1, 2),
(1, 3),
(2, 5),
(3, 5),
(2, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `takesplace`
--

CREATE TABLE `takesplace` (
  `KID` int(11) NOT NULL,
  `AID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `takesplace`
--

INSERT INTO `takesplace` (`KID`, `AID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teacher`
--

CREATE TABLE `teacher` (
  `UID` int(11) NOT NULL,
  `token` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `teacher`
--

INSERT INTO `teacher` (`UID`, `token`) VALUES
(4, 'Us'),
(5, 'Ur');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `UID` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`UID`, `email`, `nickname`, `username`, `password`) VALUES
(1, '', 'rich', 'user0', '-928147211'),
(2, '', '', 'user1', '-928147210'),
(3, '', '', 'user2', '-928147209'),
(4, '', '', 'user3', '-928147208'),
(5, '', '', 'user4', '-928147207'),
(6, '', '', 'user5', '-928147206'),
(7, '', '', 'user6', '-928147205');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`UID`);

--
-- Indizes für die Tabelle `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`AID`);

--
-- Indizes für die Tabelle `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`KID`),
  ADD KEY `student_class` (`SID`),
  ADD KEY `teacher_class` (`TID`);

--
-- Indizes für die Tabelle `exam`
--
ALTER TABLE `exam`
  ADD KEY `class_exam` (`KID`);

--
-- Indizes für die Tabelle `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`UID`);

--
-- Indizes für die Tabelle `take`
--
ALTER TABLE `take`
  ADD KEY `class_take` (`KID`),
  ADD KEY `student_take` (`UID`);

--
-- Indizes für die Tabelle `takesplace`
--
ALTER TABLE `takesplace`
  ADD KEY `class_takesPlace` (`KID`),
  ADD KEY `appointment_takesPlace` (`AID`);

--
-- Indizes für die Tabelle `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`UID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `appointment`
--
ALTER TABLE `appointment`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT für Tabelle `class`
--
ALTER TABLE `class`
  MODIFY `KID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `user_admin` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`);

--
-- Constraints der Tabelle `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `student_class` FOREIGN KEY (`SID`) REFERENCES `student` (`UID`),
  ADD CONSTRAINT `teacher_class` FOREIGN KEY (`TID`) REFERENCES `teacher` (`UID`);

--
-- Constraints der Tabelle `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `class_exam` FOREIGN KEY (`KID`) REFERENCES `class` (`KID`);

--
-- Constraints der Tabelle `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `user_student` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`);

--
-- Constraints der Tabelle `take`
--
ALTER TABLE `take`
  ADD CONSTRAINT `class_take` FOREIGN KEY (`KID`) REFERENCES `class` (`KID`),
  ADD CONSTRAINT `student_take` FOREIGN KEY (`UID`) REFERENCES `student` (`UID`);

--
-- Constraints der Tabelle `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `user_teacher` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
