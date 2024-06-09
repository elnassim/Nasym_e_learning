-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2024 at 10:39 PM
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
-- Database: `nasmy`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminrequests`
--

CREATE TABLE `adminrequests` (
  `RequestID` int(11) NOT NULL,
  `ProfessorID` int(11) NOT NULL,
  `RequestType` enum('UserActivation','CourseCreation','Other') NOT NULL,
  `RequestDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `RequestStatus` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminrequests`
--

INSERT INTO `adminrequests` (`RequestID`, `ProfessorID`, `RequestType`, `RequestDate`, `RequestStatus`) VALUES
(1, 4, 'UserActivation', '2024-05-14 16:30:00', 'Pending'),
(2, 5, 'CourseCreation', '2024-05-14 17:45:00', 'Approved'),
(3, 6, 'Other', '2024-05-14 18:20:00', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastLogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID`, `FirstName`, `LastName`, `Username`, `Email`, `Password`, `CreatedAt`, `LastLogin`, `ProfilePicture`, `Active`) VALUES
(1, 'younes', 'elmakoudi', 'kouda', 'younes@gmail.com', '1234567', '2024-05-14 01:59:23', '0000-00-00 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `AnnouncementID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `ProfessorID` int(11) NOT NULL,
  `AnnouncementText` text NOT NULL,
  `DatePosted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`AnnouncementID`, `CourseID`, `ProfessorID`, `AnnouncementText`, `DatePosted`) VALUES
(1, 4, 4, 'Welcome to the course!', '2024-05-14 14:00:00'),
(2, 6, 5, 'Reminder: Assignment due next week.', '2024-05-14 15:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `AnswerID` int(11) NOT NULL,
  `QuestionID` int(11) NOT NULL,
  `ProfessorID` int(11) NOT NULL,
  `AnswerText` text NOT NULL,
  `DatePosted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`AnswerID`, `QuestionID`, `ProfessorID`, `AnswerText`, `DatePosted`) VALUES
(1, 1, 4, 'Here is the answer to your question.', '2024-05-14 14:45:00'),
(2, 2, 5, 'You can find the solution in chapter 3.', '2024-05-14 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `coursemodules`
--

CREATE TABLE `coursemodules` (
  `ModuleID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `ModuleName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `ModuleType` enum('Lecture','Quiz','Assignment') NOT NULL,
  `ModuleOrder` int(11) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courseparts`
--

CREATE TABLE `courseparts` (
  `PartID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `PartName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Visible` tinyint(1) NOT NULL DEFAULT 1,
  `FilePath` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courseresources`
--

CREATE TABLE `courseresources` (
  `ResourceID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `ResourceName` varchar(100) NOT NULL,
  `FilePath` varchar(255) NOT NULL,
  `Visibility` enum('Public','Private') NOT NULL DEFAULT 'Public',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `FileSize` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courseresources`
--

INSERT INTO `courseresources` (`ResourceID`, `CourseID`, `ResourceName`, `FilePath`, `Visibility`, `CreatedAt`, `FileSize`) VALUES
(7, 6, 'index.php', '../uploads/index.php', 'Public', '2024-05-14 20:34:38', '10690');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CourseID` int(11) NOT NULL,
  `ProfessorID` int(11) NOT NULL,
  `SubjectID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Keywords` varchar(255) DEFAULT NULL,
  `TargetAudience` varchar(100) DEFAULT NULL,
  `CourseImage` varchar(255) DEFAULT NULL,
  `Prerequisites` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseID`, `ProfessorID`, `SubjectID`, `Title`, `Description`, `Keywords`, `TargetAudience`, `CourseImage`, `Prerequisites`, `CreatedAt`, `UpdatedAt`) VALUES
(4, 4, 4, 'Course 2', 'Course 2 description', 'keyword1, keyword2', 'Target audience 2', 'course_image_2.jpg', 'Prerequisite 2', '2024-05-14 11:19:39', '2024-05-14 11:19:39'),
(6, 6, 6, 'Course 4', 'Course 4 description', 'keyword1, keyword2', 'Target audience 4', 'course_image_4.jpg', 'Prerequisite 4', '2024-05-14 11:19:39', '2024-05-14 11:19:39'),
(7, 7, 7, 'Course 5', 'test', 'keyword1, keyword2', 'Target audience 5', 'course_image_5.jpg', 'Prerequisite 5', '2024-05-14 11:19:39', '2024-05-14 15:12:57'),
(8, 8, 8, 'Course 6', 'Course 6 description', 'keyword1, keyword2', 'Target audience 6', 'course_image_6.jpg', 'Prerequisite 6', '2024-05-14 11:19:39', '2024-05-14 11:19:39'),
(9, 9, 9, 'Course 7', 'Course 7 description', 'keyword1, keyword2', 'Target audience 7', 'course_image_7.jpg', 'Prerequisite 7', '2024-05-14 11:19:39', '2024-05-14 11:19:39'),
(10, 10, 10, 'Course 8', '', 'keyword1, keyword2', 'Target audience 8', 'course_image_8.jpg', 'Prerequisite 8', '2024-05-14 11:19:39', '2024-05-14 15:12:38'),
(11, 4, 1, '', '', '', NULL, NULL, NULL, '2024-05-14 15:13:07', '2024-05-14 15:13:07'),
(12, 5, 7, 'test title', 'test', 'lang', NULL, NULL, NULL, '2024-05-14 15:13:38', '2024-05-14 15:13:38');

-- --------------------------------------------------------

--
-- Table structure for table `discussionposts`
--

CREATE TABLE `discussionposts` (
  `PostID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PostText` text NOT NULL,
  `PostType` enum('Question','Answer','Comment') NOT NULL,
  `ParentPostID` int(11) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `EnrollmentID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `EnrolledAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`EnrollmentID`, `StudentID`, `CourseID`, `EnrolledAt`) VALUES
(6, 1, 4, '2024-05-14 13:44:19'),
(7, 2, 4, '2024-05-14 13:44:19'),
(8, 3, 4, '2024-05-14 13:44:19'),
(11, 6, 6, '2024-05-14 13:44:19'),
(12, 7, 9, '2024-05-14 13:44:19'),
(13, 8, 10, '2024-05-14 13:44:19'),
(14, 9, 9, '2024-05-14 13:44:19'),
(15, 10, 8, '2024-05-14 13:44:19');

-- --------------------------------------------------------

--
-- Table structure for table `moduleresources`
--

CREATE TABLE `moduleresources` (
  `ResourceID` int(11) NOT NULL,
  `ModuleID` int(11) NOT NULL,
  `ResourceName` varchar(100) NOT NULL,
  `FilePath` varchar(255) NOT NULL,
  `Visibility` enum('Public','Private') NOT NULL DEFAULT 'Public',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `ProfessorID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastLogin` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professors`
--

INSERT INTO `professors` (`ProfessorID`, `FirstName`, `LastName`, `Username`, `Email`, `Password`, `CreatedAt`, `LastLogin`, `ProfilePicture`, `Active`) VALUES
(4, 'Professor1', 'Lastname1', 'professor1', 'professor1@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1),
(5, 'Professor2', 'Lastname2', 'professor2', 'professor2@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1),
(6, 'Professor3', 'Lastname3', 'professor3', 'professor3@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1),
(7, 'Professor4', 'Lastname4', 'professor4', 'professor4@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1),
(8, 'Professor5', 'Lastname5', 'professor5', 'professor5@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1),
(9, 'Professor6', 'Lastname6', 'professor6', 'professor6@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1),
(10, 'Professor7', 'Lastname7', 'professor7', 'professor7@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1),
(11, 'Professor8', 'Lastname8', 'professor8', 'professor8@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1),
(12, 'dfa', 'rew', 'younes@gmail.com', 'you@gmail.com', '$2y$10$YJmv10P4PDVW7y4fv6vBXeR8XqpUNZR6npO/rjRcf36RHCX4Ughwy', '2024-05-14 11:37:57', '0000-00-00 00:00:00', NULL, 1),
(13, 'ali', 'sekkal', 'ali1', 'ali@gmail.com', '$2y$10$SspiCox0WvS.YDyuUoDjTuAJ5hGAfUGvmrfi0t2bjAxckgNqf8N1S', '2024-05-14 15:44:17', '0000-00-00 00:00:00', NULL, 1),
(17, 'ali', 'sekkal', 'ali01', 'prof@gmail.com', '$2y$10$VStRCLc6MKvbH0NBfqxEAOjAlLzbA42EV2jN2dK.ga1nDWqi20fQm', '2024-05-14 15:52:39', '0000-00-00 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profrequests`
--

CREATE TABLE `profrequests` (
  `RequestID` int(11) NOT NULL,
  `ProfessorID` int(11) NOT NULL,
  `RequestType` enum('UserActivation','CourseCreation','Other') NOT NULL,
  `RequestDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `RequestStatus` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `QuestionID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `QuestionText` text NOT NULL,
  `DatePosted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuestionID`, `CourseID`, `StudentID`, `QuestionText`, `DatePosted`) VALUES
(1, 4, 1, 'How do I solve this equation?', '2024-05-14 12:30:00'),
(2, 6, 2, 'Can you explain this concept further?', '2024-05-14 13:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `StudentID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastLogin` timestamp NOT NULL DEFAULT current_timestamp(),
  `ProfilePicture` varchar(255) DEFAULT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT 1,
  `CourseID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`StudentID`, `FirstName`, `LastName`, `Username`, `Email`, `Password`, `CreatedAt`, `LastLogin`, `ProfilePicture`, `Active`, `CourseID`) VALUES
(1, 'nassim', 'el kaddaoui', 'nassim', 'nassim@gmail.com', '$2y$10$35RqFYpfssww2MEWeHG8mObQ2jwNl1xoJaT22RvyWACUKOK3vbdRi', '2024-05-14 01:55:04', '0000-00-00 00:00:00', NULL, 1, NULL),
(2, 'Amina', 'Hassan', 'aminahassan', 'aminahassan@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(3, 'Youssef', 'Ali', 'youssefali', 'youssefali@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(4, 'Student1', 'Lastname1', 'student1', 'student1@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(5, 'Student2', 'Lastname2', 'student2', 'student2@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(6, 'Student3', 'Lastname3', 'student3', 'student3@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(7, 'Student4', 'Lastname4', 'student4', 'student4@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(8, 'Student5', 'Lastname5', 'student5', 'student5@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(9, 'Student6', 'Lastname6', 'student6', 'student6@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(10, 'Student7', 'Lastname7', 'student7', 'student7@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(11, 'Student8', 'Lastname8', 'student8', 'student8@gmail.com', 'password', '2024-05-14 11:13:24', '0000-00-00 00:00:00', NULL, 1, NULL),
(12, '', '', '', '', '', '2024-05-14 13:50:53', '2024-05-14 13:50:53', NULL, 1, 6),
(18, 'Alice', 'Smith', 'alice123', 'alice@example.com', '', '2024-05-14 14:16:34', '2024-05-14 14:16:34', NULL, 1, 4),
(19, 'Bob', 'Johnson', 'bob456', 'bob@example.com', '', '2024-05-14 14:16:34', '2024-05-14 14:16:34', NULL, 1, 4),
(20, 'Charlie', 'Brown', 'charlie789', 'charlie@example.com', '', '2024-05-14 14:16:34', '2024-05-14 14:16:34', NULL, 1, 8),
(21, 'John', 'Doe', 'johndoe', 'john.doe@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 4),
(23, 'Michael', 'Johnson', 'michaelj', 'michael.johnson@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 4),
(24, 'FirstName1', 'LastName1', 'username1', 'email1@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 6),
(25, 'FirstName2', 'LastName2', 'username2', 'email2@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 7),
(26, 'FirstName3', 'LastName3', 'username3', 'email3@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 4),
(28, 'FirstName5', 'LastName5', 'username5', 'email5@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 6),
(29, 'FirstName6', 'LastName6', 'username6', 'email6@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 7),
(30, 'FirstName7', 'LastName7', 'username7', 'email7@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 8),
(31, 'FirstName8', 'LastName8', 'username8', 'email8@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 9),
(32, 'FirstName9', 'LastName9', 'username9', 'email9@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 10),
(33, 'FirstName10', 'LastName10', 'username10', 'email10@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 8),
(34, 'FirstName11', 'LastName11', 'username11', 'email11@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 9),
(35, 'FirstName12', 'LastName12', 'username12', 'email12@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 10),
(36, 'FirstName13', 'LastName13', 'username13', 'email13@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 9),
(37, 'FirstName14', 'LastName14', 'username14', 'email14@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 10),
(38, 'FirstName15', 'LastName15', 'username15', 'email15@example.com', '', '2024-05-14 14:21:53', '2024-05-14 14:21:53', NULL, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `SubjectID` int(11) NOT NULL,
  `SubjectName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`SubjectID`, `SubjectName`, `Description`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'Mathematics', 'Introduction to Mathematics', '2024-05-14 11:13:24', '2024-05-14 11:13:24'),
(2, 'Physics', 'Introduction to Physics', '2024-05-14 11:13:24', '2024-05-14 11:13:24'),
(3, 'Subject1', 'Subject1 description', '2024-05-14 11:13:24', '2024-05-14 11:13:24'),
(4, 'Subject2', 'Subject2 description', '2024-05-14 11:13:24', '2024-05-14 11:13:24'),
(5, 'Subject3', 'Subject3 description', '2024-05-14 11:13:24', '2024-05-14 11:13:24'),
(6, 'Subject4', 'Subject4 description', '2024-05-14 11:13:24', '2024-05-14 11:13:24'),
(7, 'Subject5', 'Subject5 description', '2024-05-14 11:13:24', '2024-05-14 11:13:24'),
(8, 'Subject6', 'Subject6 description', '2024-05-14 11:13:24', '2024-05-14 11:13:24'),
(9, 'Subject7', 'Subject7 description', '2024-05-14 11:13:24', '2024-05-14 11:13:24'),
(10, 'Subject8', 'Subject8 description', '2024-05-14 11:13:24', '2024-05-14 11:13:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminrequests`
--
ALTER TABLE `adminrequests`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `ProfessorID` (`ProfessorID`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`AnnouncementID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `announcements_ibfk_2` (`ProfessorID`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`AnswerID`),
  ADD KEY `QuestionID` (`QuestionID`),
  ADD KEY `answers_ibfk_2` (`ProfessorID`);

--
-- Indexes for table `coursemodules`
--
ALTER TABLE `coursemodules`
  ADD PRIMARY KEY (`ModuleID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `courseparts`
--
ALTER TABLE `courseparts`
  ADD PRIMARY KEY (`PartID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `courseresources`
--
ALTER TABLE `courseresources`
  ADD PRIMARY KEY (`ResourceID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `ProfessorID` (`ProfessorID`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indexes for table `discussionposts`
--
ALTER TABLE `discussionposts`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `FK_UserID` (`UserID`),
  ADD KEY `FK_ParentPostID` (`ParentPostID`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`EnrollmentID`),
  ADD KEY `StudentID` (`StudentID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `moduleresources`
--
ALTER TABLE `moduleresources`
  ADD PRIMARY KEY (`ResourceID`),
  ADD KEY `ModuleID` (`ModuleID`);

--
-- Indexes for table `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`ProfessorID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `profrequests`
--
ALTER TABLE `profrequests`
  ADD PRIMARY KEY (`RequestID`),
  ADD KEY `ProfessorID` (`ProfessorID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QuestionID`),
  ADD KEY `CourseID` (`CourseID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`SubjectID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminrequests`
--
ALTER TABLE `adminrequests`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `AnnouncementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `AnswerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coursemodules`
--
ALTER TABLE `coursemodules`
  MODIFY `ModuleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courseparts`
--
ALTER TABLE `courseparts`
  MODIFY `PartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `courseresources`
--
ALTER TABLE `courseresources`
  MODIFY `ResourceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `discussionposts`
--
ALTER TABLE `discussionposts`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `EnrollmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `moduleresources`
--
ALTER TABLE `moduleresources`
  MODIFY `ResourceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `professors`
--
ALTER TABLE `professors`
  MODIFY `ProfessorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `profrequests`
--
ALTER TABLE `profrequests`
  MODIFY `RequestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `QuestionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `SubjectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adminrequests`
--
ALTER TABLE `adminrequests`
  ADD CONSTRAINT `adminrequests_ibfk_1` FOREIGN KEY (`ProfessorID`) REFERENCES `professors` (`ProfessorID`);

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`),
  ADD CONSTRAINT `announcements_ibfk_2` FOREIGN KEY (`ProfessorID`) REFERENCES `professors` (`ProfessorID`) ON DELETE CASCADE;

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `questions` (`QuestionID`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`ProfessorID`) REFERENCES `professors` (`ProfessorID`) ON DELETE CASCADE;

--
-- Constraints for table `coursemodules`
--
ALTER TABLE `coursemodules`
  ADD CONSTRAINT `coursemodules_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `courseparts`
--
ALTER TABLE `courseparts`
  ADD CONSTRAINT `courseparts_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `courseresources`
--
ALTER TABLE `courseresources`
  ADD CONSTRAINT `courseresources_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`ProfessorID`) REFERENCES `professors` (`ProfessorID`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `subjects` (`SubjectID`);

--
-- Constraints for table `discussionposts`
--
ALTER TABLE `discussionposts`
  ADD CONSTRAINT `FK_ParentPostID` FOREIGN KEY (`ParentPostID`) REFERENCES `discussionposts` (`PostID`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_UserID` FOREIGN KEY (`UserID`) REFERENCES `professors` (`ProfessorID`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussionposts_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `students` (`StudentID`),
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);

--
-- Constraints for table `moduleresources`
--
ALTER TABLE `moduleresources`
  ADD CONSTRAINT `moduleresources_ibfk_1` FOREIGN KEY (`ModuleID`) REFERENCES `coursemodules` (`ModuleID`);

--
-- Constraints for table `profrequests`
--
ALTER TABLE `profrequests`
  ADD CONSTRAINT `profrequests_ibfk_1` FOREIGN KEY (`ProfessorID`) REFERENCES `professors` (`ProfessorID`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`),
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`StudentID`) REFERENCES `students` (`StudentID`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `courses` (`CourseID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
