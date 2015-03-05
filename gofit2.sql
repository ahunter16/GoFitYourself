-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2015 at 01:53 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

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
  `cardio_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL,
  PRIMARY KEY (`cardio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `intensity`
--

CREATE TABLE IF NOT EXISTS `intensity` (
  `intensity_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `class` set('strength','size','endurance','general') NOT NULL,
  `sets` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  PRIMARY KEY (`intensity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

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
  `pair_id` int(11) NOT NULL AUTO_INCREMENT,
  `exercise_id` int(11) NOT NULL,
  `muscle_id` int(4) NOT NULL,
  `grouptype` enum('main','extra') NOT NULL,
  PRIMARY KEY (`pair_id`),
  KEY `exercise_id` (`exercise_id`),
  KEY `muscle_id` (`muscle_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `muscle_exercise_pairs`
--

INSERT INTO `muscle_exercise_pairs` (`pair_id`, `exercise_id`, `muscle_id`, `grouptype`) VALUES
(10, 1, 5, 'main'),
(11, 3, 9, 'main'),
(12, 2, 7, 'main'),
(13, 2, 11, 'main'),
(14, 2, 8, 'main'),
(15, 2, 12, 'extra'),
(16, 3, 5, 'extra'),
(17, 4, 3, 'main'),
(18, 4, 2, 'extra'),
(19, 4, 5, 'extra'),
(20, 4, 10, 'extra'),
(21, 5, 3, 'main'),
(22, 5, 2, 'main'),
(23, 5, 5, 'extra'),
(24, 6, 10, 'main'),
(25, 6, 5, 'extra'),
(26, 7, 10, 'main'),
(27, 8, 13, 'main'),
(28, 8, 7, 'extra'),
(29, 8, 8, 'extra'),
(30, 9, 3, 'main'),
(31, 9, 13, 'extra'),
(32, 9, 4, 'extra');

-- --------------------------------------------------------

--
-- Table structure for table `muscle_groups`
--

CREATE TABLE IF NOT EXISTS `muscle_groups` (
  `muscle_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`muscle_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `muscle_groups`
--

INSERT INTO `muscle_groups` (`muscle_id`, `name`) VALUES
(1, 'Traps'),
(2, 'Shoulders'),
(3, 'Chest'),
(4, 'Biceps'),
(5, 'Forearms'),
(6, 'Abs'),
(7, 'Quads'),
(8, 'Calves'),
(9, 'Lats'),
(10, 'Triceps'),
(11, 'Glutes'),
(12, 'Hamstrings'),
(13, 'Back');

-- --------------------------------------------------------

--
-- Table structure for table `strength_exercises`
--

CREATE TABLE IF NOT EXISTS `strength_exercises` (
  `exercise_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `reptime` int(11) NOT NULL DEFAULT '0',
  `rating` enum('1','2','3','4','5') NOT NULL DEFAULT '3',
  PRIMARY KEY (`exercise_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `strength_exercises`
--

INSERT INTO `strength_exercises` (`exercise_id`, `name`, `reptime`, `rating`) VALUES
(1, 'Bicep Curls', 1, '3'),
(2, 'Squats', 2, '5'),
(3, 'Lat Pulldowns', 1, '2'),
(4, 'bench press', 2, '5'),
(5, 'standing press', 1, '3'),
(6, 'skullcrushers', 2, '1'),
(7, 'tricep extensions', 1, '2'),
(8, 'deadlift', 2, '5'),
(9, 'bent-over rows', 1, '3');

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
