-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: dd25120
-- Generation Time: Mar 29, 2020 at 12:46 AM
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
  `sichtpruefung` tinyint(1) NOT NULL,
  `schutzleiter` decimal(5,2) NOT NULL,
  `isowiderstand` decimal(5,2) NOT NULL,
  `schutzleiterstrom` decimal(5,2) NOT NULL,
  `beruehrstrom` decimal(5,2) NOT NULL,
  `funktion` tinyint(1) NOT NULL,
  `bestanden` tinyint(1) NOT NULL,
  `bemerkung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pruefung`
--
ALTER TABLE `pruefung`
  ADD PRIMARY KEY (`pruefungid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
