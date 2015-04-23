-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2015 at 05:48 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `muscle_exercise_pairs`
--

INSERT INTO `muscle_exercise_pairs` (`pair_id`, `exercise_id`, `muscle_id`, `grouptype`) VALUES
(11, 3, 1, 'main'),
(16, 3, 6, 'extra'),
(17, 4, 2, 'main'),
(18, 4, 5, 'extra'),
(20, 4, 4, 'extra'),
(21, 5, 2, 'main'),
(22, 5, 5, 'main'),
(23, 5, 6, 'extra'),
(27, 8, 1, 'main'),
(28, 8, 0, 'extra'),
(33, 10, 1, 'main'),
(34, 11, 7, 'main'),
(35, 12, 7, 'main'),
(36, 13, 7, 'main'),
(37, 13, 1, 'extra'),
(38, 14, 2, 'main'),
(39, 15, 2, 'main'),
(40, 16, 2, 'main'),
(41, 17, 2, 'main'),
(42, 18, 2, 'main'),
(43, 19, 2, 'main'),
(44, 20, 2, 'main'),
(45, 21, 2, 'main'),
(46, 22, 2, 'main'),
(47, 23, 2, 'main'),
(48, 24, 1, 'main'),
(49, 25, 1, 'main'),
(50, 26, 1, 'main'),
(51, 27, 1, 'main'),
(52, 28, 0, 'main'),
(53, 28, 1, 'extra'),
(54, 29, 1, 'main'),
(55, 29, 0, 'extra'),
(56, 30, 1, 'main'),
(57, 30, 0, 'extra'),
(58, 31, 1, 'main'),
(59, 32, 1, 'main'),
(60, 32, 0, 'extra'),
(61, 33, 1, 'main'),
(62, 33, 0, 'extra'),
(63, 34, 5, 'main'),
(64, 34, 6, 'extra'),
(65, 34, 0, 'extra'),
(66, 35, 5, 'main'),
(67, 36, 5, 'main'),
(100, 37, 5, 'main'),
(101, 38, 5, 'main'),
(102, 39, 5, 'main'),
(103, 40, 5, 'main'),
(104, 41, 5, 'main'),
(105, 42, 5, 'main'),
(106, 43, 5, 'main'),
(107, 44, 5, 'main'),
(108, 45, 4, 'main'),
(109, 46, 4, 'main'),
(110, 47, 4, 'main'),
(111, 47, 2, 'extra'),
(112, 48, 4, 'main'),
(113, 49, 4, 'main'),
(114, 50, 4, 'main'),
(115, 51, 4, 'main'),
(116, 52, 4, 'main'),
(117, 53, 3, 'main'),
(118, 54, 3, 'main'),
(119, 55, 3, 'main'),
(120, 56, 3, 'main'),
(121, 57, 3, 'main'),
(122, 58, 3, 'main'),
(123, 59, 3, 'main'),
(124, 59, 6, 'extra'),
(125, 60, 6, 'main'),
(126, 61, 3, 'main'),
(127, 62, 0, 'main'),
(128, 63, 0, 'main'),
(129, 64, 0, 'main'),
(130, 65, 0, 'main'),
(131, 66, 0, 'main'),
(132, 67, 0, 'main'),
(133, 68, 0, 'main'),
(134, 69, 0, 'main'),
(135, 70, 0, 'main'),
(136, 71, 0, 'main'),
(137, 71, 1, 'extra'),
(138, 72, 1, 'main'),
(139, 72, 0, 'extra'),
(140, 73, 1, 'main'),
(141, 73, 0, 'extra'),
(142, 74, 0, 'main'),
(143, 75, 0, 'main'),
(144, 76, 0, 'main'),
(145, 77, 0, 'main'),
(146, 78, 0, 'main'),
(147, 79, 0, 'main'),
(148, 80, 0, 'main'),
(149, 80, 1, 'extra'),
(150, 81, 0, 'main'),
(151, 81, 1, 'extra');

-- --------------------------------------------------------

--
-- Table structure for table `muscle_groups`
--

CREATE TABLE IF NOT EXISTS `muscle_groups` (
`muscle_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

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
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
`picture_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `picture_order` int(11) NOT NULL,
  `picture` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
`rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `strength_exercises`
--

CREATE TABLE IF NOT EXISTS `strength_exercises` (
`exercise_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `reptime` int(11) NOT NULL DEFAULT '0',
  `equipment` enum('0','1','2','3') NOT NULL DEFAULT '1',
  `rating` enum('1','2','3','4','5') NOT NULL DEFAULT '3',
  `priority` enum('1','2','3') NOT NULL DEFAULT '2'
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `strength_exercises`
--

INSERT INTO `strength_exercises` (`exercise_id`, `name`, `reptime`, `equipment`, `rating`, `priority`) VALUES
(3, 'Lat Pulldowns', 1, '3', '2', '2'),
(4, 'Bench Press', 2, '2', '5', '3'),
(5, 'Standing Press', 1, '1', '3', '2'),
(8, 'Deadlift', 2, '1', '5', '3'),
(10, 'Hyperextensions', 1, '2', '2', '2'),
(11, 'Balance Ball Crunch', 1, '2', '3', '1'),
(12, 'Rope Pull-Down', 2, '3', '2', '2'),
(13, 'Double-Cable Lean-Over', 2, '3', '4', '2'),
(14, 'Cable Fly', 1, '3', '5', '1'),
(15, 'Reverse-Grip Incline Bench Press', 2, '2', '4', '3'),
(16, 'Hammer-Grip Press', 1, '2', '2', '3'),
(17, 'Plate Pushup', 1, '1', '4', '2'),
(18, 'Bent-Arm Dumbbell Pull-Over', 2, '1', '3', '2'),
(19, 'Dumbbell Fly', 1, '2', '4', '2'),
(20, 'Smith Machine Flat Bench Press', 2, '3', '2', '3'),
(21, 'Cable Machine Decline Raise', 1, '3', '2', '2'),
(22, 'Cable Crossover Fly', 2, '3', '2', '2'),
(23, 'Cable Decline Fly', 2, '3', '3', '2'),
(24, 'Incline Bench Row', 1, '2', '4', '2'),
(25, 'Dumbbell Shrug', 1, '1', '2', '1'),
(26, 'Plate Row', 1, '1', '4', '2'),
(27, 'Dumbbell Row', 2, '1', '4', '3'),
(28, 'Cable Squat', 1, '3', '2', '3'),
(29, 'Dumbbell Deadlift', 1, '1', '2', '3'),
(30, 'Romanian Deadlift', 2, '1', '5', '3'),
(31, 'Flat bench Hyperextensions', 1, '2', '4', '2'),
(32, 'Back Extensions', 1, '2', '3', '2'),
(33, 'Good Mornings', 2, '1', '4', '2'),
(34, 'Barbell Row', 0, '1', '5', '3'),
(35, 'Pyramid Cable Press', 1, '1', '4', '1'),
(36, 'Front Plate Raise', 2, '1', '4', '1'),
(37, 'Seated Arnold Press', 1, '1', '5', '1'),
(38, 'Dumbbell Shoulder Press', 1, '1', '4', '1'),
(39, 'Standing Barbell Row', 2, '1', '4', '2'),
(40, 'Dumbbell Side Push-Out', 1, '1', '3', '1'),
(41, 'Lateral shoulder Raise', 1, '1', '4', '1'),
(42, 'Bent-Over Cable Raise', 2, '1', '3', '2'),
(43, 'One-Arm Dumbbell Raise', 1, '1', '3', '1'),
(44, 'Reverse Fly', 2, '1', '2', '1'),
(45, 'Triceps Bench Dip', 2, '1', '3', '1'),
(46, 'Skull Crushers', 1, '1', '4', '1'),
(47, 'Smith Machine Close-Grip Press', 1, '1', '2', '2'),
(48, 'One-Arm Cable Extension', 1, '1', '1', '1'),
(49, 'Rope Overhead Extension', 2, '1', '4', '1'),
(50, 'Rope Push-Down', 1, '1', '5', '1'),
(51, 'Tricep Extension', 1, '1', '4', '1'),
(52, 'Dumbbell Kickback', 1, '1', '2', '1'),
(53, 'Rope Hammer Curl', 1, '1', '5', '1'),
(54, 'Reclining Cable Curl', 1, '1', '3', '1'),
(55, 'Barbell Curl', 1, '1', '4', '1'),
(56, 'Alternating Hammer Curl', 2, '1', '1', '1'),
(57, 'Dumbbell Curl', 1, '1', '2', '1'),
(58, 'Plate Curl', 2, '1', '4', '1'),
(59, 'Hammer Curl', 1, '1', '3', '1'),
(60, 'Wrist Curl', 1, '1', '4', '1'),
(61, 'Single-Arm Concentration Curl', 1, '1', '3', '1'),
(62, 'Smith Machine Squat', 2, '1', '4', '3'),
(63, 'Smith Machine Single-Leg Press', 2, '1', '3', '3'),
(64, 'Leg Press Plie', 2, '1', '2', '3'),
(65, 'Flat Bench Dumbbell Squat', 2, '1', '3', '3'),
(66, 'Dumbbell Walking Lunge', 2, '1', '5', '2'),
(67, 'Flat Bench Step-Up', 3, '1', '2', '2'),
(68, 'Barbell Squat', 2, '1', '5', '3'),
(69, 'Lateral Lunge', 2, '1', '3', '2'),
(70, 'Lunge', 2, '1', '2', '2'),
(71, 'Front Squat', 2, '1', '3', '3'),
(72, 'Single Leg Deadlift', 3, '1', '3', '2'),
(73, 'Stiff-Legged Barbell Deadlift', 2, '1', '4', '3'),
(74, 'Plie Squat', 2, '1', '3', '3'),
(75, 'Dumbbell Shin Raise', 2, '1', '2', '1'),
(76, 'Step-Up', 1, '1', '3', '2'),
(77, 'Step-Down', 1, '1', '2', '2'),
(78, 'Dumbbell Calf Raise', 1, '1', '3', '1'),
(79, 'Calf Raise', 1, '1', '4', '1'),
(80, 'Cable Abduction', 2, '1', '5', '2'),
(81, 'Clamshells', 1, '1', '4', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workouts`
--

CREATE TABLE IF NOT EXISTS `workouts` (
`workout_id` int(11) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `intensity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('strength','size','endurance') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `workout_pairs`
--

CREATE TABLE IF NOT EXISTS `workout_pairs` (
`pair_id` int(11) NOT NULL,
  `workout_id` int(11) NOT NULL,
  `exercise_id` int(11) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
 ADD PRIMARY KEY (`picture_id`), ADD KEY `exercise_id` (`exercise_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
 ADD PRIMARY KEY (`rating_id`), ADD KEY `exercise_id` (`exercise_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `strength_exercises`
--
ALTER TABLE `strength_exercises`
 ADD PRIMARY KEY (`exercise_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `workouts`
--
ALTER TABLE `workouts`
 ADD PRIMARY KEY (`workout_id`), ADD KEY `intensity` (`intensity`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `workout_pairs`
--
ALTER TABLE `workout_pairs`
 ADD PRIMARY KEY (`pair_id`), ADD KEY `workout_id` (`workout_id`), ADD KEY `exercise_id` (`exercise_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `intensity`
--
ALTER TABLE `intensity`
MODIFY `intensity_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `muscle_exercise_pairs`
--
ALTER TABLE `muscle_exercise_pairs`
MODIFY `pair_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=152;
--
-- AUTO_INCREMENT for table `muscle_groups`
--
ALTER TABLE `muscle_groups`
MODIFY `muscle_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `strength_exercises`
--
ALTER TABLE `strength_exercises`
MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workouts`
--
ALTER TABLE `workouts`
MODIFY `workout_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workout_pairs`
--
ALTER TABLE `workout_pairs`
MODIFY `pair_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `muscle_exercise_pairs`
--
ALTER TABLE `muscle_exercise_pairs`
ADD CONSTRAINT `muscle_exercise_pairs_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `strength_exercises` (`exercise_id`),
ADD CONSTRAINT `muscle_exercise_pairs_ibfk_3` FOREIGN KEY (`muscle_id`) REFERENCES `muscle_groups` (`muscle_id`);

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
ADD CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`exercise_id`) REFERENCES `strength_exercises` (`exercise_id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`exercise_id`) REFERENCES `strength_exercises` (`exercise_id`),
ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `workouts`
--
ALTER TABLE `workouts`
ADD CONSTRAINT `workouts_ibfk_1` FOREIGN KEY (`intensity`) REFERENCES `intensity` (`intensity_id`),
ADD CONSTRAINT `workouts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `workout_pairs`
--
ALTER TABLE `workout_pairs`
ADD CONSTRAINT `workout_pairs_ibfk_1` FOREIGN KEY (`workout_id`) REFERENCES `workouts` (`workout_id`),
ADD CONSTRAINT `workout_pairs_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `strength_exercises` (`exercise_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
