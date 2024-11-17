-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2023 at 05:15 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlicksystems_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `incident_location` varchar(255) NOT NULL DEFAULT '',
  `incident_description` varchar(255) NOT NULL DEFAULT '',
  `incident_photo` varchar(255) NOT NULL DEFAULT '',
  `staff_involved` varchar(255) NOT NULL DEFAULT '',
  `staff_name_and_role` varchar(255) NOT NULL DEFAULT '',
  `equipment_involved` varchar(255) NOT NULL DEFAULT '',
  `witnesses_whoes` varchar(255) NOT NULL DEFAULT '',
  `witnesses_names` varchar(255) NOT NULL DEFAULT '',
  `incident_injuries` varchar(255) NOT NULL DEFAULT '',
  `medical_attention` varchar(255) NOT NULL DEFAULT '',
  `supervisor_attention` varchar(255) NOT NULL DEFAULT '',
  `factors_identified` varchar(255) NOT NULL DEFAULT '',
  `potential_consequences` varchar(255) NOT NULL DEFAULT '',
  `preventive_measures` varchar(255) NOT NULL DEFAULT '',
  `incident_history` varchar(255) NOT NULL DEFAULT '',
  `incident_notes` varchar(255) NOT NULL DEFAULT '',
  `parents_contacted` varchar(255) NOT NULL DEFAULT '',
  `disciplinary_actions` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL DEFAULT '',
  `followup_actions` varchar(255) NOT NULL DEFAULT '',
  `asset` varchar(200) NOT NULL,
  `priority` int(1) NOT NULL,
  `category` int(2) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `due_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`id`, `student_id`, `incident_location`, `incident_description`, `incident_photo`, `staff_involved`, `staff_name_and_role`, `equipment_involved`, `witnesses_whoes`, `witnesses_names`, `incident_injuries`, `medical_attention`, `supervisor_attention`, `factors_identified`, `potential_consequences`, `preventive_measures`, `incident_history`, `incident_notes`, `parents_contacted`, `disciplinary_actions`, `description`, `followup_actions`, `asset`, `priority`, `category`, `status`, `created_at`, `due_date`) VALUES
(1, 362, '1', 'Voluptates optio ut', '', 'Modi soluta esse ali', 'Gay Sykes', 'Ab rerum sunt volup', 'fail', '', 'pass', 'fail', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, '2023-07-07 23:42:33', NULL),
(2, 362, '1', 'Voluptates optio ut', '', '', 'sdfgsdfg', '', 'fail', '', 'fail', 'fail', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, '2023-01-13 23:50:59', NULL),
(3, 376, '1', 'zxcvczxv', '', '', '', '', 'fail', '', 'na', 'fail', '', '', '', '', '', '', '', '', '', '', '', 3, 3, 1, '2023-07-07 23:52:18', '2023-07-15'),
(4, 361, '9', 'sdf', '', '', 'aadas', '', 'pass', '', 'pass', 'fail', '', '', '', '', '', '', '', '', ' fgufsdyiuxfyixfyhikdxgu', '12515451', 'gfhdfghfghzz', 1, 3, 1, '2023-07-07 23:56:39', '2023-07-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
