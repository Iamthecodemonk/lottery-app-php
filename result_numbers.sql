-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2026 at 10:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blueloto`
--

-- --------------------------------------------------------

--
-- Table structure for table `result_numbers`
--

CREATE TABLE `result_numbers` (
  `id` char(36) NOT NULL,
  `result_id` char(36) NOT NULL,
  `game_type_id` char(36) NOT NULL,
  `number` int(11) NOT NULL,
  `type` enum('winning','machine') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result_numbers`
--

INSERT INTO `result_numbers` (`id`, `result_id`, `game_type_id`, `number`, `type`) VALUES
('RN1', 'R1', '141b5ecd-2bb3-11f1-87d2-0068eb6923ff', 12, 'winning'),
('RN10', 'R1', '141b91b4-2bb3-11f1-87d2-0068eb6923ff', 66, 'machine'),
('RN2', 'R1', '141b8dc7-2bb3-11f1-87d2-0068eb6923ff', 45, 'winning'),
('RN3', 'R1', '141b8faf-2bb3-11f1-87d2-0068eb6923ff', 78, 'winning'),
('RN4', 'R1', '141b9100-2bb3-11f1-87d2-0068eb6923ff', 90, 'winning'),
('RN5', 'R1', '141b91b4-2bb3-11f1-87d2-0068eb6923ff', 11, 'winning'),
('RN6', 'R1', '141b5ecd-2bb3-11f1-87d2-0068eb6923ff', 22, 'machine'),
('RN7', 'R1', '141b8dc7-2bb3-11f1-87d2-0068eb6923ff', 33, 'machine'),
('RN8', 'R1', '141b8faf-2bb3-11f1-87d2-0068eb6923ff', 44, 'machine'),
('RN9', 'R1', '141b9100-2bb3-11f1-87d2-0068eb6923ff', 55, 'machine');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `result_numbers`
--
ALTER TABLE `result_numbers`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
