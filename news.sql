-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 04. Jun 2023 um 22:23
-- Server-Version: 10.4.25-MariaDB
-- PHP-Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `news`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategories`
--

CREATE TABLE `kategories` (
  `kid` int(10) UNSIGNED NOT NULL,
  `kategorie` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `kategories`
--

INSERT INTO `kategories` (`kid`, `kategorie`) VALUES
(1, 'Aktuelles'),
(2, 'Politik'),
(3, 'Wirtschaft'),
(4, 'Sport'),
(5, 'Wissenschaft'),
(6, 'Technik');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE `news` (
  `newsID` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `inhalt` text DEFAULT NULL,
  `gueltigVon` date DEFAULT NULL,
  `gueltigBis` date DEFAULT NULL,
  `erstelltam` date DEFAULT NULL,
  `kid` int(10) UNSIGNED NOT NULL,
  `link` varchar(50) DEFAULT NULL,
  `bild` varchar(255) DEFAULT NULL,
  `autor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `news`
--



-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `Benutzername` varchar(20) NOT NULL,
  `Passwort` varchar(255) NOT NULL,
  `Anrede` char(4) DEFAULT NULL,
  `Vorname` varchar(50) NOT NULL,
  `Nachname` varchar(50) NOT NULL,
  `Strasse` varchar(50) DEFAULT NULL,
  `PLZ` varchar(15) DEFAULT NULL,
  `Ort` varchar(50) DEFAULT NULL,
  `Land` varchar(50) DEFAULT NULL,
  `EMail_Adresse` varchar(30) DEFAULT NULL,
  `Telefon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--



--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
