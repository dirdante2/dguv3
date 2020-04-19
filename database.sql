-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: dd25120
-- Generation Time: Apr 19, 2020 at 03:21 PM
-- Server version: 5.7.28-nmm1-log
-- PHP Version: 7.1.33-nmm1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `d03136eb`
--
CREATE DATABASE IF NOT EXISTS `d03136eb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `d03136eb`;

-- --------------------------------------------------------

--
-- Table structure for table `firmen`
--

CREATE TABLE `firmen` (
  `firmen_firmaid` int(11) NOT NULL,
  `firma_name` varchar(40) NOT NULL,
  `firma_strasse` varchar(30) DEFAULT NULL,
  `firma_ort` varchar(30) DEFAULT NULL,
  `firma_plz` varchar(30) DEFAULT NULL,
  `firma_beschreibung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `geraete`
--

CREATE TABLE `geraete` (
  `gid` int(11) NOT NULL,
  `oid` int(11) NOT NULL COMMENT 'OrtsID',
  `geraete_firmaid` int(11) NOT NULL DEFAULT '1',
  `name` varchar(30) NOT NULL,
  `hersteller` varchar(20) NOT NULL,
  `typ` varchar(20) NOT NULL,
  `seriennummer` varchar(30) NOT NULL,
  `nennspannung` int(11) NOT NULL,
  `nennstrom` decimal(5,2) NOT NULL,
  `leistung` int(11) NOT NULL,
  `hinzugefuegt` date NOT NULL,
  `beschreibung` text NOT NULL,
  `aktiv` tinyint(1) NOT NULL,
  `schutzklasse` int(11) NOT NULL,
  `wiederholung` int(5) NOT NULL,
  `verlaengerungskabel` tinyint(1) NOT NULL,
  `kabellaenge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messgeraete`
--

CREATE TABLE `messgeraete` (
  `mid` int(11) NOT NULL,
  `messgeraete_firmaid` int(11) NOT NULL DEFAULT '1',
  `name` varchar(20) NOT NULL,
  `beschreibung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orte`
--

CREATE TABLE `orte` (
  `oid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `beschreibung` text NOT NULL,
  `orte_firmaid` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pruefer`
--

CREATE TABLE `pruefer` (
  `pid` int(11) NOT NULL,
  `pruefer_firmaid` int(11) NOT NULL DEFAULT '1',
  `name` varchar(20) NOT NULL,
  `beschreibung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pruefung`
--

CREATE TABLE `pruefung` (
  `pruefungid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `datum` date NOT NULL,
  `mid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `oid` int(11) NOT NULL,
  `pruefung_firmaid` int(11) NOT NULL,
  `sichtpruefung` tinyint(1) DEFAULT NULL,
  `schutzleiter` decimal(5,2) DEFAULT NULL,
  `RPEmax` decimal(5,2) DEFAULT NULL,
  `isowiderstand` decimal(5,2) DEFAULT NULL,
  `schutzleiterstrom` decimal(5,2) DEFAULT NULL,
  `beruehrstrom` decimal(5,2) DEFAULT NULL,
  `funktion` tinyint(1) NOT NULL,
  `bestanden` tinyint(1) NOT NULL,
  `bemerkung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_pid` int(11) DEFAULT NULL,
  `user_mid` int(11) DEFAULT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_password` varchar(40) NOT NULL,
  `user_level` varchar(3) NOT NULL,
  `users_firmaid` int(11) NOT NULL,
  `user_oid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `firmen`
--
ALTER TABLE `firmen`
  ADD PRIMARY KEY (`firmen_firmaid`);

--
-- Indexes for table `geraete`
--
ALTER TABLE `geraete`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `messgeraete`
--
ALTER TABLE `messgeraete`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `orte`
--
ALTER TABLE `orte`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `pruefer`
--
ALTER TABLE `pruefer`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `pruefung`
--
ALTER TABLE `pruefung`
  ADD PRIMARY KEY (`pruefungid`),
  ADD KEY `datum` (`datum`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `firmen`
--
ALTER TABLE `firmen`
  MODIFY `firmen_firmaid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geraete`
--
ALTER TABLE `geraete`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messgeraete`
--
ALTER TABLE `messgeraete`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orte`
--
ALTER TABLE `orte`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pruefer`
--
ALTER TABLE `pruefer`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pruefung`
--
ALTER TABLE `pruefung`
  MODIFY `pruefungid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
