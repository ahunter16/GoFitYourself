-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2015 at 05:37 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gofit2`
--

-- --------------------------------------------------------

--
-- Table structure for table `cardio_exercises`
--

CREATE TABLE IF NOT EXISTS `cardio_exercises` (
`cardio_id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `intensity`
--

CREATE TABLE IF NOT EXISTS `intensity` (
`intensity_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `class` set('strength','size','endurance','general') NOT NULL,
  `sets` int(11) NOT NULL,
  `reps` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `intensity`
--

INSERT INTO `intensity` (`intensity_id`, `name`, `class`, `sets`, `reps`) VALUES
(1, 'special', '', 1, 5),
(3, '8x3', 'strength', 8, 3),
(4, '6x4', 'strength', 6, 4),
(5, '3x5', 'strength', 3, 5),
(6, '5x5', 'strength,size', 5, 5),
(8, '4x6', 'strength,size', 4, 6),
(10, '3x8', 'strength,size', 3, 8),
(12, '4x8', 'strength,size', 4, 8),
(15, '3x10', 'size,endurance', 3, 10),
(17, '4x10', 'size,endurance', 4, 10),
(19, '2x12', 'size,endurance', 2, 12),
(21, '3x12', 'size,endurance', 3, 12),
(22, '2x15', 'size,endurance', 2, 15),
(24, '2x20', 'endurance', 2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `muscle_exercise_pairs`
--

CREATE TABLE IF NOT EXISTS `muscle_exercise_pairs` (
`pair_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `muscle_id` int(4) NOT NULL,
  `grouptype` enum('main','extra') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `muscle_exercise_pairs`
--

INSERT INTO `muscle_exercise_pairs` (`pair_id`, `exercise_id`, `muscle_id`, `grouptype`) VALUES
(10, 1, 6, 'main'),
(11, 3, 1, 'main'),
(12, 2, 0, 'main'),
(16, 3, 6, 'extra'),
(17, 4, 2, 'main'),
(18, 4, 5, 'extra'),
(19, 4, 6, 'extra'),
(20, 4, 4, 'extra'),
(21, 5, 2, 'main'),
(22, 5, 5, 'main'),
(23, 5, 6, 'extra'),
(24, 6, 4, 'main'),
(25, 6, 6, 'extra'),
(26, 7, 4, 'main'),
(27, 8, 1, 'main'),
(28, 8, 0, 'extra'),
(30, 9, 2, 'main'),
(31, 9, 1, 'extra'),
(32, 9, 3, 'extra');

-- --------------------------------------------------------

--
-- Table structure for table `muscle_groups`
--

CREATE TABLE IF NOT EXISTS `muscle_groups` (
`muscle_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `muscle_groups`
--

INSERT INTO `muscle_groups` (`muscle_id`, `name`) VALUES
(0, 'legs'),
(1, 'back'),
(2, 'chest'),
(3, 'biceps'),
(4, 'triceps'),
(5, 'shoulders'),
(6, 'forearms'),
(7, 'abs');

-- --------------------------------------------------------

--
-- Table structure for table `strength_exercises`
--

CREATE TABLE IF NOT EXISTS `strength_exercises` (
`exercise_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `reptime` int(11) NOT NULL DEFAULT '0',
  `rating` enum('1','2','3','4','5') NOT NULL DEFAULT '3',
  `priority` enum('1','2','3') NOT NULL DEFAULT '2'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `strength_exercises`
--

INSERT INTO `strength_exercises` (`exercise_id`, `name`, `reptime`, `rating`, `priority`) VALUES
(1, 'Bicep Curls', 1, '3', '1'),
(2, 'Squats', 2, '5', '3'),
(3, 'Lat Pulldowns', 1, '2', '2'),
(4, 'bench press', 2, '5', '3'),
(5, 'standing press', 1, '3', '2'),
(6, 'skullcrushers', 2, '1', '1'),
(7, 'tricep extensions', 1, '2', '1'),
(8, 'deadlift', 2, '5', '3'),
(9, 'bent-over rows', 1, '3', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cardio_exercises`
--
ALTER TABLE `cardio_exercises`
 ADD PRIMARY KEY (`cardio_id`);

--
-- Indexes for table `intensity`
--
ALTER TABLE `intensity`
 ADD PRIMARY KEY (`intensity_id`);

--
-- Indexes for table `muscle_exercise_pairs`
--
ALTER TABLE `muscle_exercise_pairs`
 ADD PRIMARY KEY (`pair_id`), ADD KEY `exercise_id` (`exercise_id`), ADD KEY `muscle_id` (`muscle_id`);

--
-- Indexes for table `muscle_groups`
--
ALTER TABLE `muscle_groups`
 ADD PRIMARY KEY (`muscle_id`);

--
-- Indexes for table `strength_exercises`
--
ALTER TABLE `strength_exercises`
 ADD PRIMARY KEY (`exercise_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cardio_exercises`
--
ALTER TABLE `cardio_exercises`
MODIFY `cardio_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `intensity`
--
ALTER TABLE `intensity`
MODIFY `intensity_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `muscle_exercise_pairs`
--
ALTER TABLE `muscle_exercise_pairs`
MODIFY `pair_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `muscle_groups`
--
ALTER TABLE `muscle_groups`
MODIFY `muscle_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `strength_exercises`
--
ALTER TABLE `strength_exercises`
MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `muscle_exercise_pairs`
--
ALTER TABLE `muscle_exercise_pairs`
ADD CONSTRAINT `muscle_exercise_pairs_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `strength_exercises` (`exercise_id`),
ADD CONSTRAINT `muscle_exercise_pairs_ibfk_3` FOREIGN KEY (`muscle_id`) REFERENCES `muscle_groups` (`muscle_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
