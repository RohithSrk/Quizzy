-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2018 at 11:30 AM
-- Server version: 5.7.12-log
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizzy`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `qid` varchar(10) NOT NULL,
  `ans_opt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `qid`, `ans_opt_id`) VALUES
(1, '1', 4),
(2, '2', 9),
(3, '3', 10),
(4, '3', 11),
(5, '4', 16),
(7, '11', 39),
(8, '12', 43),
(9, '13', 46),
(10, '14', 51),
(16, '18', 66),
(17, '19', 70),
(18, '20', 73),
(19, '21', 77),
(20, '21', 78),
(21, '22', 79),
(22, '23', 82),
(23, '24', 85),
(24, '25', 86),
(25, '26', 88),
(26, '26', 88),
(27, '27', 93),
(28, '28', 94),
(29, '29', 99),
(30, '30', 101),
(31, '31', 103),
(32, '32', 106),
(33, '33', 110),
(34, '34', 112),
(35, '35', 117),
(36, '36', 118),
(37, '37', 123),
(38, '38', 124),
(39, '39', 129),
(40, '40', 131),
(41, '41', 133),
(42, '42', 136),
(43, '43', 140),
(44, '44', 142),
(45, '45', 147),
(46, '46', 149),
(47, '47', 152),
(48, '48', 156),
(49, '49', 163),
(50, '50', 164),
(51, '51', 170),
(52, '52', 175),
(53, '53', 176),
(54, '55', 182),
(55, '56', 185),
(56, '57', 189),
(57, '58', 196),
(58, '59', 197),
(59, '60', 203),
(60, '61', 208),
(61, '62', 209),
(62, '64', 215),
(63, '66', 221),
(64, '67', 222),
(65, '68', 226),
(66, '70', 232),
(67, '71', 233),
(68, '72', 237),
(69, '73', 242),
(70, '74', 245),
(71, '75', 248),
(72, '76', 255),
(73, '77', 256),
(74, '78', 262),
(75, '79', 267),
(76, '80', 270);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(37, 'Chemistry'),
(38, 'Competitive Exams'),
(4, 'Databases'),
(6, 'Game Engines'),
(39, 'General Knowledge'),
(1, 'Mathematics'),
(36, 'Physics'),
(3, 'Programming'),
(5, 'Scripting'),
(35, 'Software Testing'),
(2, 'Web Development');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `qid` int(11) NOT NULL,
  `option_val` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `qid`, `option_val`) VALUES
(1, 1, '&#x3C;javascript&#x3E;'),
(2, 1, '&#x3C;scripting&#x3E;'),
(3, 1, '&#x3C;js&#x3E;'),
(4, 1, '&#x3C;script&#x3E;'),
(5, 1, '&#x3C;execute&#x3E;'),
(6, 2, 'document.getElementByName(&#x22;p&#x22;).innerHTML = &#x22;Hello World!&#x22;;'),
(7, 2, '#demo.innerHTML = &#x22;Hello World!&#x22;;'),
(8, 2, 'document.getElement(&#x22;p&#x22;).innerHTML = &#x22;Hello World!&#x22;;'),
(9, 2, 'document.getElementById(&#x22;demo&#x22;).innerHTML = &#x22;Hello World!&#x22;;'),
(10, 3, 'The &#x3C;head&#x3E; section'),
(11, 3, 'The &#x3C;body&#x3E; section'),
(12, 3, 'In between &#x3C;html&#x3E; and &#x3C;/html'),
(13, 3, 'In between &#x3C;thead&#x3E; and &#x3C;/thead&#x3E;'),
(14, 4, '&#x3C;script href=&#x22;xxx.js&#x22;&#x3E;'),
(15, 4, '&#x3C;script name=&#x22;xxx.js&#x22;&#x3E;'),
(16, 4, '&#x3C;script src=&#x22;xxx.js&#x22;&#x3E;'),
(17, 4, '&#x3C;script source=&#x22;xxx.js&#x22;&#x3E;'),
(57, 16, 'Personal Hypertext Processor'),
(58, 16, 'PHP: Hypertext Preprocessor'),
(59, 16, 'Private Home Page'),
(60, 17, '<&>...</&>'),
(61, 17, '<?php...?>'),
(62, 17, '<?php>...</?>'),
(63, 17, '<script>...</script>'),
(64, 17, '<?=...?>'),
(65, 18, '\"Hello World\";'),
(66, 18, 'echo \"Hello World\";'),
(67, 18, 'Document.Write(\"Hello World\");'),
(68, 19, '&'),
(69, 19, '!'),
(70, 19, '$'),
(71, 20, '</php>'),
(72, 20, '.'),
(73, 20, ' ;'),
(74, 20, 'New line'),
(75, 21, 'JavaScript'),
(76, 21, 'VBScript'),
(77, 21, 'Perl'),
(78, 21, 'C'),
(79, 22, '$_GET[];'),
(80, 22, 'Request.Form;'),
(81, 22, 'Request.QueryString;'),
(82, 23, 'False'),
(83, 23, 'True'),
(84, 24, 'False'),
(85, 24, 'True'),
(86, 25, 'False'),
(87, 25, 'True'),
(88, 26, '19.6m '),
(89, 26, '1960m'),
(90, 26, '64m'),
(91, 27, 'velocity'),
(92, 27, 'acceleration '),
(93, 27, 'instantaneous velocity'),
(94, 28, '19.6m/s'),
(95, 28, '39.2m/s'),
(96, 28, '19.8m/s'),
(97, 29, '98m'),
(98, 29, '980m'),
(99, 29, '490m'),
(100, 30, '39.2m/s'),
(101, 30, '19.6m/s'),
(102, 30, '9.8m/s'),
(103, 31, 'uniform velocity '),
(104, 31, 'uniform acceleration '),
(105, 31, 'stopped'),
(106, 32, 'perpendicular to each other '),
(107, 32, 'parallel each other'),
(108, 32, 'inclined 45 degrees'),
(109, 33, '1/8'),
(110, 33, '1/4'),
(111, 33, '1/2'),
(112, 34, 'parabolic path '),
(113, 34, 'circular path'),
(114, 34, 'elliptical path'),
(115, 35, '0 s'),
(116, 35, '2 s'),
(117, 35, '6 s'),
(118, 36, '19.6m '),
(119, 36, '1960m'),
(120, 36, '64m'),
(121, 37, 'velocity'),
(122, 37, 'acceleration '),
(123, 37, 'instantaneous velocity'),
(124, 38, '19.6m/s'),
(125, 38, '39.2m/s'),
(126, 38, '19.8m/s'),
(127, 39, '98m'),
(128, 39, '980m'),
(129, 39, '490m'),
(130, 40, '39.2m/s'),
(131, 40, '19.6m/s'),
(132, 40, '9.8m/s'),
(133, 41, 'uniform velocity '),
(134, 41, 'uniform acceleration '),
(135, 41, 'stopped'),
(136, 42, 'perpendicular to each other '),
(137, 42, 'parallel each other'),
(138, 42, 'inclined 45 degrees'),
(139, 43, '1/8'),
(140, 43, '1/4'),
(141, 43, '1/2'),
(142, 44, 'parabolic path '),
(143, 44, 'circular path'),
(144, 44, 'elliptical path'),
(145, 45, '0 s'),
(146, 45, '2 s'),
(147, 45, '6 s'),
(148, 46, '4s'),
(149, 46, '4p'),
(150, 46, '4d'),
(151, 46, '4f'),
(152, 47, '0'),
(153, 47, '1'),
(154, 47, '2'),
(155, 47, '3'),
(156, 48, '2'),
(157, 48, '4'),
(158, 48, '6'),
(159, 48, '8'),
(160, 49, '26'),
(161, 49, '29'),
(162, 49, '21'),
(163, 49, '25'),
(164, 50, 'Neutron'),
(165, 50, 'Proton'),
(166, 50, 'Electron'),
(167, 50, 'Nucleons'),
(168, 51, 'L value'),
(169, 51, 'm value'),
(170, 51, 'n value'),
(171, 51, 'atom'),
(172, 52, '  l'),
(173, 52, 'm'),
(174, 52, 'n'),
(175, 52, 's'),
(176, 53, 'Cu'),
(177, 53, 'Ar'),
(178, 53, 'Ne'),
(179, 53, 'Cr'),
(180, 54, 'Aufbau principle'),
(181, 55, '4s'),
(182, 55, '4p'),
(183, 55, '4d'),
(184, 55, '4f'),
(185, 56, '0'),
(186, 56, '1'),
(187, 56, '2'),
(188, 56, '3'),
(189, 57, '2'),
(190, 57, '4'),
(191, 57, '6'),
(192, 57, '8'),
(193, 58, '26'),
(194, 58, '29'),
(195, 58, '21'),
(196, 58, '25'),
(197, 59, 'Neutron'),
(198, 59, 'Proton'),
(199, 59, 'Electron'),
(200, 59, 'Nucleons'),
(201, 60, 'L value'),
(202, 60, 'm value'),
(203, 60, 'n value'),
(204, 60, 'atom'),
(205, 61, '  l'),
(206, 61, 'm'),
(207, 61, 'n'),
(208, 61, 's'),
(209, 62, 'Cu'),
(210, 62, 'Ar'),
(211, 62, 'Ne'),
(212, 62, 'Cr'),
(213, 63, 'Aufbau principle'),
(214, 64, 'secondary solid'),
(215, 64, 'secondary liquid'),
(216, 64, 'secondary gas'),
(217, 65, 'Transportation'),
(218, 65, 'Distrillation'),
(219, 66, 'carbon'),
(220, 66, 'nickeloxide'),
(221, 66, 'copperoxide'),
(222, 67, 'alkanes'),
(223, 67, 'alkenes'),
(224, 67, 'alkynes'),
(225, 68, 'secondary solid'),
(226, 68, 'secondary liquid'),
(227, 68, 'secondary gas'),
(228, 69, 'Transportation'),
(229, 69, 'Distrillation'),
(230, 70, 'carbon'),
(231, 70, 'nickeloxide'),
(232, 70, 'copperoxide'),
(233, 71, 'alkanes'),
(234, 71, 'alkenes'),
(235, 71, 'alkynes'),
(236, 72, 'A class must contain all pure virtual functions'),
(237, 72, ' A class must contain at least one pure virtual function'),
(238, 72, ' A class may not contain pure virtual function.'),
(239, 72, 'A class must contain pure virtual function defined outside the class.'),
(240, 73, ' private'),
(241, 73, ' protected'),
(242, 73, 'public'),
(243, 73, 'Access specifiers not applicable for structures.'),
(244, 74, 'Both can be overloaded'),
(245, 74, 'Both cannot be overloaded'),
(246, 74, 'Only sizeof can be overloaded'),
(247, 74, 'Only ?: can be overloaded'),
(248, 75, 'By only providing all the functions as virtual functions in the class.'),
(249, 75, 'Defining the class following with the keyword virtual'),
(250, 75, ' Defining the class following with the keyword interface'),
(251, 75, 'Defining the class following with the keyword abstract'),
(252, 76, 'Assigned one object to another object at its creation'),
(253, 76, 'When objects are sent to function using call by value mechanism'),
(254, 76, 'When the function return an object'),
(255, 76, 'All the above.'),
(256, 77, 'Standard template library.'),
(257, 77, 'System template library.'),
(258, 77, 'Standard topics library.'),
(259, 77, ' None of the above.'),
(260, 78, '0 1'),
(261, 78, '0 2'),
(262, 78, '0 8'),
(263, 78, 'Compile error'),
(264, 79, '2'),
(265, 79, '4'),
(266, 79, '8'),
(267, 79, 'compiler dependent'),
(268, 80, ' #include &lt;file&gt;'),
(269, 80, '#include &quot;file&quot;'),
(270, 80, '#include &lt; file'),
(271, 80, 'All of the above are invalid');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL,
  `user_type` varchar(15) NOT NULL,
  `add_content` varchar(6) NOT NULL,
  `modify_content` varchar(6) NOT NULL,
  `manage_users` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `user_type`, `add_content`, `modify_content`, `manage_users`) VALUES
(1, 'superadmin', 'Y', 'Y', 'Y'),
(2, 'admin', 'Y', 'Y', 'N'),
(3, 'user', 'Y', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `qid` int(11) NOT NULL,
  `question` text NOT NULL,
  `is_multi_ans_que` varchar(6) NOT NULL,
  `quiz_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`qid`, `question`, `is_multi_ans_que`, `quiz_id`) VALUES
(1, 'Inside which HTML element do we put the JavaScript?', 'N', 1),
(2, 'What is the correct JavaScript syntax to change the content of the HTML element below?', 'N', 1),
(3, 'Where is the correct place to insert a JavaScript?', 'Y', 1),
(4, 'What is the correct syntax for referring to an external script called \"xxx.js\"?', 'N', 1),
(16, 'What does PHP stand for?', 'N', 10),
(17, 'PHP server scripts are surrounded by delimiters, which?', 'Y', 10),
(18, 'How do you write \"Hello World\" in PHP', 'N', 10),
(19, 'All variables in PHP start with which symbol?', 'N', 10),
(20, 'What is the correct way to end a PHP statement?', 'N', 10),
(21, 'The PHP syntax is most similar to:', 'Y', 11),
(22, 'How do you get information from a form that is submitted using the \"get\" method?', 'N', 11),
(23, 'When using the POST method, variables are displayed in the URL:', 'N', 11),
(24, 'In PHP you can use both single quotes (  ) and double quotes ( \" \" ) for strings:', 'N', 11),
(25, 'Include files must have the file extension \".inc\"', 'N', 11),
(26, 'A stone dropped from the top of a building reaches the ground in  2 sec.The height of the building is ', 'N', 12),
(27, 'The slope of a time-displacement graph gives', 'N', 12),
(28, 'A body is thrown vertically upwards with a velocity of 39.2m/s. The velocity of a body after 2s is ', 'N', 12),
(29, 'A body is projected upwards with a velocity of 98m/s.The max height reached by the body is', 'N', 12),
(30, 'A body is dropped from height of 39.2m.After it crosses half the distance,the acceleration due to gravity cases to act.The velocity with which the body hits the ground is', 'N', 12),
(31, 'If a person in a running train throws a ball comes in to his hand,it shows that the train has ', 'N', 12),
(32, 'At  the highest point of the path of a projectile, the direction of its velocity  &amp; acceleration are', 'N', 12),
(33, 'A projectile thrown so as to cover of the max range.If the max height reached is H &amp; the max  horizontal range is R,then the ratio H/R is equal to  ', 'N', 12),
(34, 'A stone is dropped from a running train.It will hit the ground following a ', 'N', 12),
(35, 'A body is allow to fall from a height of 98m.After 2s of its fall ,the gravity disappears .What is the time taken by the body to reach the ground?', 'N', 12),
(36, 'A stone dropped from the top of a building reaches the ground in  2 sec.The height of the building is ', 'N', 13),
(37, 'The slope of a time-displacement graph gives', 'N', 13),
(38, 'A body is thrown vertically upwards with a velocity of 39.2m/s. The velocity of a body after 2s is ', 'N', 13),
(39, 'A body is projected upwards with a velocity of 98m/s.The max height reached by the body is', 'N', 13),
(40, 'A body is dropped from height of 39.2m.After it crosses half the distance,the acceleration due to gravity cases to act.The velocity with which the body hits the ground is', 'N', 13),
(41, 'If a person in a running train throws a ball comes in to his hand,it shows that the train has ', 'N', 13),
(42, 'At  the highest point of the path of a projectile, the direction of its velocity  &amp; acceleration are', 'N', 13),
(43, 'A projectile thrown so as to cover of the max range.If the max height reached is H &amp; the max  horizontal range is R,then the ratio H/R is equal to  ', 'N', 13),
(44, 'A stone is dropped from a running train.It will hit the ground following a ', 'N', 13),
(45, 'A body is allow to fall from a height of 98m.After 2s of its fall ,the gravity disappears .What is the time taken by the body to reach the ground?', 'N', 13),
(46, 'After filling of 3d orbital differentiating electrons enters into ', 'N', 14),
(47, 'The magnetic quantum no.for the outer most electron of Na atom is', 'N', 14),
(48, 'Oxygen uses ____electrons for bonding', 'N', 14),
(49, 'The atomic no. of the elements  having max. no.of unpaired 3d  electrons is', 'N', 14),
(50, 'Which of the following particle is not present  in the hydrogen?', 'N', 14),
(51, 'Energy of a orbit depends on', 'N', 14),
(52, 'The values of Azimuthal quantum no. depends on?', 'N', 14),
(53, 'The atom containing 18 electrons in the penultimate orbit is', 'N', 14),
(54, 'Nitrogen has 3 unpaired electrons, this is according to? ', 'N', 14),
(55, 'After filling of 3d orbital differentiating electrons enters into ', 'N', 15),
(56, 'The magnetic quantum no.for the outer most electron of Na atom is', 'N', 15),
(57, 'Oxygen uses ____electrons for bonding', 'N', 15),
(58, 'The atomic no. of the elements  having max. no.of unpaired 3d  electrons is', 'N', 15),
(59, 'Which of the following particle is not present  in the hydrogen?', 'N', 15),
(60, 'Energy of a orbit depends on', 'N', 15),
(61, 'The values of Azimuthal quantum no. depends on?', 'N', 15),
(62, 'The atom containing 18 electrons in the penultimate orbit is', 'N', 15),
(63, 'Nitrogen has 3 unpaired electrons, this is according to? ', 'N', 15),
(64, 'Gasoline is an example of ', 'N', 16),
(65, 'The water present in the crude oil is separated by ', 'N', 16),
(66, 'The sulphur compounds present in the crude oil are removed by using', 'N', 16),
(67, 'Natural gas is a mixture of ', 'N', 16),
(68, 'Gasoline is an example of ', 'N', 17),
(69, 'The water present in the crude oil is separated by ', 'N', 17),
(70, 'The sulphur compounds present in the crude oil are removed by using', 'N', 17),
(71, 'Natural gas is a mixture of ', 'N', 17),
(72, 'Abstract class is __', 'N', 18),
(73, 'By default the members of the structure are', 'N', 18),
(74, ' Operators sizeof and ?:', 'N', 18),
(75, 'How can we make an class act as an interface in C++?', 'N', 18),
(76, 'The copy constructor is executed on', 'N', 18),
(77, ' What is the full form of STL?', 'N', 18),
(78, ' What is the outpout of the following program?\n\n#include&lt;isotream&gt;\n\nusing namespace std;\nmain()\n{\n   enum { \n      india, is = 7, GREAT \n      };\n\n      cout&lt;&lt;india&lt;&lt;&rdquo; &ldquo;&lt;&lt;GREAT;\n}\n', 'N', 18),
(79, ' What is the size of &lsquo;int&rsquo;?', 'N', 18),
(80, 'Following is the invalid inclusion of a file to the current program. Identify it', 'N', 18),
(81, 'What is the output of the following program?\n#include&lt;isotream&gt;\n\nusing namespace std;\nmain()\n{	\n   int a[', '1', 18);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `quiz_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `topic_id` int(11) NOT NULL,
  `total_questions` int(25) NOT NULL,
  `duration` time DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `quiz_name`, `description`, `topic_id`, `total_questions`, `duration`, `created_by`) VALUES
(1, 'Beginner-1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 6, 4, '00:05:00', 1),
(12, 'Kinematics', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 85, 10, '00:05:00', 2),
(14, 'Fundamentals of chemistry', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 88, 10, '00:05:00', 2),
(16, 'Fundamentals of fuels', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 91, 4, '00:02:00', 2),
(18, 'C++ Intro', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ', 20, 10, '00:05:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_report`
--

CREATE TABLE `quiz_report` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `user_start_time` timestamp NULL DEFAULT NULL,
  `user_end_time` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_finished` varchar(6) NOT NULL DEFAULT 'N',
  `percentage` float DEFAULT NULL,
  `points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz_report`
--

INSERT INTO `quiz_report` (`id`, `quiz_id`, `start_time`, `user_start_time`, `user_end_time`, `user_id`, `is_finished`, `percentage`, `points`) VALUES
(1, 1, '2016-02-27 05:01:23', '2016-02-27 05:01:25', '2016-02-27 05:01:30', NULL, 'Y', 25, 307),
(2, 1, '2016-02-27 05:01:48', NULL, NULL, NULL, 'N', 0, 0),
(3, 1, '2016-02-27 05:01:53', NULL, NULL, NULL, 'N', 0, 0),
(4, 1, '2016-02-27 05:02:11', '2016-02-27 05:02:16', '2016-02-27 05:02:42', NULL, 'Y', 100, 474),
(5, 1, '2016-02-27 05:03:17', '2016-02-27 05:03:21', '2016-02-27 05:03:38', NULL, 'Y', 50, 358),
(6, 1, '2016-02-27 05:03:56', '2016-02-27 05:03:57', '2016-02-27 05:04:01', NULL, 'Y', 0, 246),
(7, 1, '2016-02-27 05:04:30', '2016-02-27 05:04:36', '2016-02-27 05:04:52', NULL, 'Y', 0, 231),
(8, 1, '2016-02-27 05:22:20', NULL, NULL, NULL, 'N', 0, 0),
(9, 1, '2016-02-27 05:38:52', NULL, NULL, NULL, 'N', 0, 0),
(10, 1, '2016-02-27 07:02:14', '2016-02-27 07:02:22', '2016-02-27 07:03:16', NULL, 'Y', 50, 322),
(11, 1, '2016-02-27 07:04:21', '2016-02-27 07:04:28', '2016-02-27 07:04:30', NULL, 'Y', 25, 305),
(12, 1, '2016-02-27 07:58:04', '2016-02-27 07:58:06', '2016-02-27 07:58:12', NULL, 'Y', 0, 243),
(13, 3, '2016-02-27 00:58:28', '2016-02-27 04:06:19', '2016-02-27 04:49:32', NULL, 'Y', 0, 0),
(14, 3, '2016-02-27 04:30:00', '2016-02-26 19:00:00', '2016-02-26 18:30:44', NULL, 'N', NULL, NULL),
(15, 1, '2016-02-27 13:37:54', NULL, NULL, NULL, 'N', NULL, NULL),
(16, 1555555555, '2016-02-27 13:38:17', NULL, NULL, NULL, 'N', NULL, NULL),
(17, 1555555555, '2016-02-27 13:38:25', NULL, NULL, NULL, 'N', NULL, NULL),
(18, 1555555555, '2016-02-27 13:38:34', NULL, NULL, NULL, 'N', NULL, NULL),
(19, 1, '2016-02-27 14:11:48', NULL, NULL, NULL, 'N', NULL, NULL),
(20, 1, '2016-02-27 14:20:54', NULL, NULL, NULL, 'N', NULL, NULL),
(21, 1, '2016-02-27 15:26:10', '2016-02-27 15:26:13', '2016-02-27 15:27:21', NULL, 'Y', 100, 441),
(22, 1, '2016-02-27 15:29:21', '2016-02-27 15:29:22', '2016-02-27 15:29:41', NULL, 'Y', 100, 483),
(23, 1, '2016-02-27 15:31:10', NULL, NULL, NULL, 'N', NULL, NULL),
(24, 1, '2016-02-27 15:31:49', '2016-02-27 15:31:51', '2016-02-27 15:32:03', NULL, 'Y', 100, 488),
(25, 1, '2016-02-27 15:32:29', '2016-02-27 15:32:31', '2016-02-27 15:32:45', NULL, 'Y', 100, 487),
(26, 1, '2016-02-27 15:44:32', '2016-02-27 15:44:36', '2016-02-27 15:44:43', NULL, 'Y', 0, 241),
(27, 1, '2016-02-27 15:48:25', '2016-02-27 15:48:27', '2016-02-27 15:48:34', NULL, 'Y', 25, 305),
(28, 1, '2016-02-27 15:48:47', '2016-02-27 15:48:49', '2016-02-27 15:49:25', NULL, 'Y', 100, 468),
(29, 1, '2016-02-28 00:30:31', '2016-02-28 00:30:36', '2016-02-28 00:30:58', NULL, 'Y', 100, 478),
(30, 1, '2016-02-28 00:39:32', NULL, NULL, NULL, 'N', NULL, NULL),
(31, 3, '2016-02-28 00:39:35', NULL, NULL, NULL, 'N', NULL, NULL),
(32, 1, '2016-02-28 00:39:49', NULL, NULL, NULL, 'N', NULL, NULL),
(33, 1, '2016-02-28 02:38:37', NULL, NULL, NULL, 'N', NULL, NULL),
(34, 1, '2016-02-28 02:41:15', NULL, NULL, NULL, 'N', NULL, NULL),
(35, 1, '2016-02-28 02:41:21', NULL, NULL, NULL, 'N', NULL, NULL),
(36, 1, '2016-02-28 02:41:28', NULL, NULL, NULL, 'N', NULL, NULL),
(37, 1, '2016-02-28 02:42:47', NULL, NULL, NULL, 'N', NULL, NULL),
(38, 1, '2016-02-28 02:51:22', NULL, NULL, NULL, 'N', NULL, NULL),
(39, 1, '2016-02-28 02:51:35', NULL, NULL, NULL, 'N', NULL, NULL),
(40, 1, '2016-02-28 02:53:32', '2016-02-28 02:53:35', '2016-02-28 02:53:50', NULL, 'Y', 100, 485),
(41, 1, '2016-02-28 05:04:50', '2016-02-28 05:04:52', '2016-02-28 05:05:02', NULL, 'Y', 50, 365),
(42, 1, '2016-02-28 05:15:49', NULL, NULL, NULL, 'N', NULL, NULL),
(43, 1, '2016-02-28 05:16:20', NULL, NULL, NULL, 'N', NULL, NULL),
(44, 1, '2016-02-28 06:18:55', NULL, NULL, NULL, 'N', NULL, NULL),
(45, 1, '2016-02-28 17:36:53', NULL, NULL, NULL, 'N', NULL, NULL),
(46, 1, '2016-02-28 17:39:00', '2016-02-28 17:39:06', '2016-02-28 17:39:36', NULL, 'Y', 75, 407),
(47, 1, '2016-02-28 17:40:05', NULL, NULL, NULL, 'N', NULL, NULL),
(48, 3, '2016-02-28 22:19:54', NULL, NULL, NULL, 'N', NULL, NULL),
(49, 1, '2016-02-29 10:28:29', '2016-02-29 10:28:34', '2016-02-29 10:28:56', NULL, 'Y', 100, 478),
(50, 1, '2016-02-29 11:03:10', '2016-02-29 11:03:16', '2016-02-29 11:04:29', NULL, 'Y', 25, 245),
(51, 1, '2016-02-29 13:43:48', '2016-02-29 13:43:50', '2016-02-29 13:43:59', NULL, 'Y', 100, 491),
(52, 1, '2016-03-01 07:59:12', '2016-03-01 07:59:13', '2016-03-01 07:59:32', NULL, 'Y', 50, 358),
(53, 1, '2016-03-01 07:59:47', '2016-03-01 07:59:48', '2016-03-01 08:00:00', NULL, 'Y', 100, 489),
(54, 1, '2016-03-01 08:02:03', '2016-03-01 08:02:06', '2016-03-01 08:02:18', NULL, 'Y', 100, 488),
(55, 1, '2016-03-01 08:02:23', NULL, NULL, NULL, 'N', NULL, NULL),
(56, 1, '2016-03-01 08:02:55', NULL, NULL, NULL, 'N', NULL, NULL),
(57, 1, '2016-03-01 08:04:11', '2016-03-01 08:04:13', '2016-03-01 08:04:37', 1, 'Y', 75, 416),
(58, 1, '2016-03-01 13:05:26', '2016-03-01 13:05:31', '2016-03-01 13:05:50', 1, 'Y', 100, 480),
(59, 9, '2016-03-01 14:38:22', '2016-03-01 14:38:24', '2016-03-01 14:39:07', 1, 'Y', 100, 406),
(60, 2, '2016-03-01 14:40:12', NULL, NULL, 1, 'N', NULL, NULL),
(61, 13, '2016-03-01 15:04:56', NULL, NULL, 1, 'N', NULL, NULL),
(62, 12, '2016-03-01 15:09:27', NULL, NULL, 1, 'N', NULL, NULL),
(63, 12, '2016-03-01 15:09:30', NULL, NULL, 1, 'N', NULL, NULL),
(64, 12, '2016-03-01 15:10:43', NULL, NULL, 1, 'N', NULL, NULL),
(65, 12, '2016-03-01 15:10:46', NULL, NULL, 1, 'N', NULL, NULL),
(66, 13, '2016-03-01 15:12:21', NULL, NULL, 1, 'N', NULL, NULL),
(67, 12, '2016-03-01 15:23:12', NULL, NULL, 1, 'N', NULL, NULL),
(68, 12, '2016-03-01 15:23:29', NULL, NULL, 1, 'N', NULL, NULL),
(69, 1, '2016-03-01 15:28:31', '2016-03-01 15:28:33', '2016-03-01 15:28:47', 1, 'Y', 100, 487),
(70, 1, '2016-03-01 17:46:21', '2016-03-01 17:46:36', '2016-03-01 17:46:54', NULL, 'Y', 100, 471),
(71, 1, '2016-03-01 19:00:38', NULL, NULL, 1, 'N', NULL, NULL),
(72, 1, '2016-03-01 19:12:53', NULL, NULL, 1, 'N', NULL, NULL),
(73, 1, '2016-03-01 20:03:34', '2016-03-01 20:03:39', '2016-03-01 20:03:59', 1, 'Y', 100, 479),
(74, 1, '2016-03-01 20:04:22', NULL, NULL, 1, 'N', NULL, NULL),
(75, 1, '2016-03-01 20:04:32', NULL, NULL, 1, 'N', NULL, NULL),
(76, 1, '2016-03-01 20:04:57', NULL, NULL, 1, 'N', NULL, NULL),
(77, 1, '2016-03-01 20:06:03', NULL, NULL, 1, 'N', NULL, NULL),
(78, 1, '2016-03-01 20:06:28', NULL, NULL, 1, 'N', NULL, NULL),
(79, 1, '2016-03-01 22:39:50', NULL, NULL, 1, 'N', NULL, NULL),
(80, 1, '2016-03-01 22:40:27', '2016-03-01 22:40:32', '2016-03-01 22:40:50', 1, 'Y', 100, 481),
(81, 1, '2016-03-01 22:41:34', '2016-03-01 22:41:36', '2016-03-01 22:41:46', 1, 'Y', 100, 490),
(82, 1, '2016-03-01 22:41:57', '2016-03-01 22:42:03', '2016-03-01 22:42:12', 1, 'Y', 50, 362),
(83, 1, '2016-03-01 22:42:28', '2016-03-01 22:42:31', '2016-03-01 22:42:35', 1, 'Y', 0, 244),
(84, 1, '2016-03-01 22:42:43', NULL, NULL, 1, 'N', NULL, NULL),
(85, 1, '2016-03-01 22:44:54', '2016-03-01 22:44:56', '2016-03-01 22:45:06', 1, 'Y', 50, 365),
(86, 1, '2016-03-01 22:45:36', '2016-03-01 22:45:38', '2016-03-01 22:45:46', 1, 'Y', 25, 304),
(87, 1, '2016-03-01 22:47:22', '2016-03-01 22:47:24', '2016-03-01 22:47:28', 1, 'Y', 25, 308),
(88, 1, '2016-03-01 22:49:18', '2016-03-01 22:49:21', '2016-03-01 22:49:29', 1, 'Y', 50, 366),
(89, 1, '2016-03-01 22:50:15', '2016-03-01 22:50:17', '2016-03-01 22:50:27', 1, 'Y', 75, 428),
(90, 1, '2016-03-01 22:51:28', '2016-03-01 22:51:30', '2016-03-01 22:51:33', 1, 'Y', 0, 246),
(91, 1, '2016-03-01 22:52:35', '2016-03-01 22:52:37', '2016-03-01 22:52:40', 1, 'Y', 0, 246),
(92, 1, '2016-03-01 22:53:39', '2016-03-01 22:53:42', '2016-03-01 22:53:46', 1, 'Y', 0, 244),
(93, 1, '2016-03-01 22:54:18', '2016-03-01 22:54:20', '2016-03-01 22:54:26', 1, 'Y', 0, 243),
(94, 1, '2016-03-01 22:55:02', '2016-03-01 22:55:05', '2016-03-01 22:55:12', 1, 'Y', 50, 367),
(95, 1, '2016-03-01 22:58:06', '2016-03-01 22:58:08', '2016-03-01 22:58:16', 1, 'Y', 50, 367),
(96, 1, '2016-03-01 22:58:50', '2016-03-01 22:58:52', '2016-03-01 22:59:03', 1, 'Y', 75, 427),
(97, 1, '2016-03-01 23:07:34', '2016-03-01 23:07:36', '2016-03-01 23:07:48', 1, 'Y', 100, 488),
(98, 1, '2016-03-01 23:08:19', '2016-03-01 23:08:22', '2016-03-01 23:08:37', 1, 'Y', 100, 485),
(99, 1, '2016-03-01 23:13:55', '2016-03-01 23:13:58', '2016-03-01 23:14:09', 1, 'Y', 100, 488),
(100, 1, '2016-03-01 23:21:01', '2016-03-01 23:21:03', '2016-03-01 23:21:18', 1, 'Y', 75, 423),
(101, 1, '2016-03-01 23:22:24', NULL, NULL, 1, 'N', NULL, NULL),
(102, 1, '2016-03-01 23:23:16', '2016-03-01 23:23:18', '2016-03-01 23:23:26', 1, 'Y', 50, 367),
(103, 1, '2016-03-01 23:24:48', NULL, NULL, 1, 'N', NULL, NULL),
(104, 1, '2016-03-01 23:25:14', '2016-03-01 23:25:17', '2016-03-01 23:25:50', 1, 'Y', 25, 283),
(105, 9, '2016-03-02 03:07:53', NULL, NULL, 1, 'N', NULL, NULL),
(106, 1, '2016-03-02 03:09:45', NULL, NULL, 1, 'N', NULL, NULL),
(107, 1, '2016-03-04 04:15:11', NULL, NULL, NULL, 'N', NULL, NULL),
(108, 1, '2016-03-04 04:17:14', '2016-03-04 04:17:17', '2016-03-04 04:17:43', NULL, 'Y', 50, 351),
(109, 10, '2016-03-04 04:23:03', '2016-03-04 04:23:06', '2016-03-04 04:23:22', NULL, 'Y', 0, 210),
(110, 11, '2016-03-04 04:28:01', '2016-03-04 04:28:04', '2016-03-04 04:28:36', NULL, 'Y', 20, 227),
(111, 12, '2016-03-04 05:51:51', '2016-03-04 05:51:53', '2016-03-04 05:52:27', 2, 'Y', 40, 320),
(112, 13, '2016-03-04 05:53:46', '2016-03-04 05:53:49', '2016-03-04 05:54:29', 2, 'Y', 80, 414),
(113, 1, '2016-03-04 06:27:42', NULL, NULL, NULL, 'N', NULL, NULL),
(114, 1, '2016-03-08 01:36:20', '2016-03-08 01:36:23', '2016-03-08 01:36:58', 2, 'Y', 25, 281),
(115, 1, '2016-03-08 01:50:19', NULL, NULL, 2, 'N', NULL, NULL),
(116, 10, '2016-03-08 01:57:23', NULL, NULL, NULL, 'N', NULL, NULL),
(117, 10, '2016-03-08 01:57:30', NULL, NULL, NULL, 'N', NULL, NULL),
(118, 14, '2016-03-08 02:24:13', '2016-03-08 02:24:15', '2016-03-08 02:25:22', 2, 'Y', 20, 243),
(119, 14, '2016-03-08 02:27:48', NULL, NULL, NULL, 'N', NULL, NULL),
(120, 14, '2016-03-08 02:30:31', NULL, NULL, NULL, 'N', NULL, NULL),
(121, 14, '2016-03-08 02:30:31', '2016-03-08 02:30:37', '2016-03-08 02:31:38', NULL, 'Y', 20, 243),
(122, 14, '2016-03-08 02:31:17', '2016-03-08 02:31:19', '2016-03-08 02:31:43', 2, 'Y', 10, 253),
(123, 14, '2016-03-08 02:32:54', NULL, NULL, 2, 'N', NULL, NULL),
(124, 14, '2016-03-08 02:33:00', NULL, NULL, 2, 'N', NULL, NULL),
(125, 14, '2016-03-08 02:33:04', NULL, NULL, 2, 'N', NULL, NULL),
(126, 1, '2016-03-08 02:34:50', NULL, NULL, NULL, 'N', NULL, NULL),
(127, 1, '2016-03-08 02:35:24', NULL, NULL, NULL, 'N', NULL, NULL),
(128, 1, '2016-03-08 02:37:27', NULL, NULL, NULL, 'N', NULL, NULL),
(129, 16, '2016-03-08 02:44:51', '2016-03-08 02:44:53', '2016-03-08 02:46:24', 2, 'Y', 50, 181),
(130, 14, '2016-03-08 02:55:15', NULL, NULL, 2, 'N', NULL, NULL),
(131, 17, '2016-03-08 02:55:20', '2016-03-08 02:55:23', '2016-03-08 02:56:10', 2, 'Y', 0, 146),
(132, 17, '2016-03-08 02:56:33', NULL, NULL, 2, 'N', NULL, NULL),
(133, 16, '2016-03-08 02:56:42', NULL, NULL, 2, 'N', NULL, NULL),
(134, 14, '2016-03-08 02:57:02', NULL, NULL, 2, 'N', NULL, NULL),
(135, 18, '2016-03-08 03:17:11', '2016-03-08 03:17:15', '2016-03-08 03:20:25', 2, 'Y', 30, 163),
(136, 1, '2016-03-08 04:35:05', '2016-03-08 04:35:11', '2016-03-08 04:35:25', 2, 'Y', 25, 295),
(137, 15, '2016-03-08 04:36:31', '2016-03-08 04:36:34', '2016-03-08 04:37:32', 2, 'Y', 40, 299),
(138, 15, '2016-03-08 04:38:10', '2016-03-08 04:38:12', '2016-03-08 04:43:12', 2, 'Y', 30, 77),
(139, 12, '2016-03-08 05:16:14', '2016-03-08 05:16:27', '2016-03-08 05:16:55', NULL, 'Y', 50, 339),
(140, 12, '2016-03-08 05:20:05', '2016-03-08 05:20:07', '2016-03-08 05:20:30', 2, 'Y', 60, 379),
(141, 1, '2016-03-12 04:01:35', '2016-03-12 04:01:37', '2016-03-12 04:01:46', NULL, 'Y', 0, 241),
(142, 1, '2016-03-12 04:02:15', '2016-03-12 04:02:16', '2016-03-12 04:02:30', NULL, 'Y', 50, 363),
(143, 18, '2016-03-14 05:02:36', '2016-03-14 05:02:38', '2016-03-14 05:03:01', NULL, 'Y', 30, 304),
(144, 18, '2016-03-15 04:07:14', NULL, NULL, NULL, 'N', NULL, NULL),
(145, 18, '2016-03-15 04:19:15', '2016-03-15 04:19:18', '2016-03-15 04:19:54', NULL, 'Y', 30, 293),
(146, 1, '2016-03-15 04:21:41', '2016-03-15 04:21:46', '2016-03-15 04:22:34', NULL, 'Y', 25, 268),
(147, 12, '2016-03-15 04:31:33', '2016-03-15 04:31:38', '2016-03-15 04:33:42', 2, 'Y', 20, 193),
(148, 1, '2016-03-17 02:19:27', '2016-03-17 02:19:29', '2016-03-17 02:19:46', NULL, 'Y', 100, 484),
(149, 1, '2018-04-02 13:37:58', '2018-04-02 13:38:02', '2018-04-02 13:39:12', NULL, 'Y', 75, 376),
(150, 1, '2018-04-02 13:40:04', NULL, NULL, NULL, 'N', NULL, NULL),
(151, 1, '2018-04-02 14:04:02', '2018-04-02 14:04:07', '2018-04-02 14:08:40', 2, 'Y', 100, 268),
(152, 1, '2018-04-02 14:16:26', '2018-04-02 14:16:28', '2018-04-02 14:16:49', 2, 'Y', 75, 418);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `topic` varchar(25) NOT NULL,
  `topic_description` text NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `topic`, `topic_description`, `category_id`) VALUES
(1, 'Algebra', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 1),
(2, 'Trignometry', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 1),
(3, 'Calculus', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 1),
(4, 'Geometry', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 1),
(5, 'Probability', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 1),
(6, 'Javascript', 'JavaScript is a lightweight, interpreted programming language. It is designed for creating network-centric applications. It is complimentary to and integrated with Java. JavaScript is very easy to implement because it is integrated with HTML. It is open and cross-platform.', 2),
(7, 'ASP.NET', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(8, 'HTML', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(9, 'jQuery', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(10, 'CSS', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(11, 'Ruby on Rails', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(12, 'Python', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(13, 'MVC Framework', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(14, 'VBScript', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(15, 'XHTML', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(16, 'XML', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(17, 'Ajax', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(18, 'Bootstrap', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(19, 'Foundataion', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 2),
(20, 'C & C++', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 3),
(21, 'Java Language', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 3),
(22, 'Assembly', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 3),
(23, 'C#', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 3),
(24, 'VB.NET', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 3),
(25, 'D Language', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 3),
(26, 'COBOL', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 3),
(27, 'FORTRAN', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 3),
(28, 'Lua', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 5),
(29, 'Python', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 5),
(30, 'Perl', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 5),
(31, 'PostgreSQL', 'PostgreSQL is a powerful, open source object-relational database system. It has more than 15 years of active development and a proven architecture that has earned it a strong reputation for reliability, data integrity, and correctness.', 4),
(32, 'MySQL', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 4),
(33, 'SQL', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 4),
(34, 'SQLite', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 4),
(35, 'PL/SQL', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 4),
(36, 'Oracle', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut maiores optio tempore natus laudantium beatae, ipsum. Alias vitae incidunt, facere magni iusto sapiente tempora. Consequuntur, quo magnam nisi earum facilis!', 4),
(37, 'Statistics', '', 1),
(52, 'Cocos2D', '', 6),
(53, 'Unity', '', 6),
(54, 'Unreal Engine', '', 6),
(55, 'Lumberyard', '', 6),
(56, 'Construct 2', '', 6),
(81, 'QUnit', '', 35),
(82, 'Codeception', '', 35),
(83, 'PHP Unit', '', 35),
(84, 'TESTIFY', '', 35),
(85, 'Kinematics', '', 36),
(86, 'Dynamics', '', 36),
(87, 'Friction', '', 36),
(88, 'Atomic Structure', '', 37),
(89, 'PHP', '', 2),
(90, 'Swift', '', 3),
(91, 'Fuels', '', 37),
(92, 'Polymers', '', 37),
(93, 'ECET', '', 38),
(94, 'EMCET', '', 38),
(95, 'GMAT', '', 38),
(96, 'SAT', '', 38),
(97, 'GATE', '', 38),
(98, 'Indian History', '', 39),
(99, 'GRE', '', 38);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `user_type` int(11) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `user_type`, `first_name`, `last_name`, `password`) VALUES
(1, 'admin', 2, 'Chris', 'Hemsworth', 'ef793e482586739ce1a7e09d6399989f');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`qid`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_report`
--
ALTER TABLE `quiz_report`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=272;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `qid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `quiz_report`
--
ALTER TABLE `quiz_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
