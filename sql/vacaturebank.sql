-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2022 at 08:02 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vacaturebank`
--

-- --------------------------------------------------------

--
-- Table structure for table `sollicitatiehistory`
--

CREATE TABLE `sollicitatiehistory` (
  `id` int(11) NOT NULL,
  `vacature` varchar(50) NOT NULL,
  `sollicitant` varchar(50) NOT NULL,
  `functie` varchar(50) NOT NULL,
  `datum` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `bedrijf` varchar(50) NOT NULL,
  `commissie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sollicitatiehistory`
--

INSERT INTO `sollicitatiehistory` (`id`, `vacature`, `sollicitant`, `functie`, `datum`, `email`, `bedrijf`, `commissie`) VALUES
(1, '2', 'sollicitant01', 'backend developer', '15-02-2022', 'sollicitant01@email.com', 'bedrijf01', '10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `naam` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `wachtwoord` varchar(50) NOT NULL,
  `soort` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `naam`, `email`, `wachtwoord`, `soort`) VALUES
(1, 'sollicitant01', 'sollicitant01@email.com', '12345678', 'sollicitant'),
(2, 'bedrijf01', 'bedrijf01@email.com', '12345678', 'bedrijf');

-- --------------------------------------------------------

--
-- Table structure for table `vacatures`
--

CREATE TABLE `vacatures` (
  `id` int(11) NOT NULL,
  `bedrijf` varchar(50) NOT NULL,
  `vacature` varchar(50) NOT NULL,
  `functie` varchar(50) NOT NULL,
  `commissie` varchar(50) NOT NULL,
  `datum` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vacatures`
--

INSERT INTO `vacatures` (`id`, `bedrijf`, `vacature`, `functie`, `commissie`, `datum`, `email`) VALUES
(2, 'bedrijf01', '2', 'backend developer', '10', '15-02-2022', 'bedrijf01@email.com'),
(3, 'bedrijf01', '3', 'frontend developer', '20', '15-02-2022', 'bedrijf01@email.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sollicitatiehistory`
--
ALTER TABLE `sollicitatiehistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vacatures`
--
ALTER TABLE `vacatures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sollicitatiehistory`
--
ALTER TABLE `sollicitatiehistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vacatures`
--
ALTER TABLE `vacatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
