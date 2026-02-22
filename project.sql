-- phpMyAdmin SQL Dump
-- version 5.2.3deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 22, 2026 at 01:13 PM
-- Server version: 11.8.5-MariaDB-4 from Debian
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `code`, `name`) VALUES
(1, 'Bsc.ISF', 'Bachelor of Science Information Security and Forensics'),
(2, 'Bsc.IT', 'Bachelor of Science in Information Technology'),
(3, 'Bsc.CS', 'Bachelor of Science in Computer Science'),
(4, 'Bsc.SE', 'Bachelor of Science in Software Engineering'),
(5, 'Bsc.DS', 'Bachelor of Science in Data Science'),
(6, 'Bsc.AI', 'Bachelor of Science in Artificial Intelligence'),
(7, 'Bsc.BIT', 'Bachelor of Business Information Technology'),
(8, 'Bsc.NS', 'Bachelor of Science in Network Security'),
(9, 'Bsc.CE', 'Bachelor of Science in Computer Engineering'),
(10, 'Bsc.GAM', 'Bachelor of Science in Game Development');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `document_type_id` int(11) DEFAULT 1,
  `path` varchar(255) NOT NULL,
  `submission_date` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `milestone_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `project_id`, `document_type_id`, `path`, `submission_date`, `status`, `milestone_id`, `user_id`, `version`, `created_at`, `updated_at`) VALUES
(13, 1, 1, '21_06643/Proposal_21_06643_Joseph Munyira_v1.pdf', '2026-02-03 07:04:01', 'pending', 1, 4, 1, '2026-02-03 10:04:01', '2026-02-03 10:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `document_types`
--

CREATE TABLE `document_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `max_marks` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `document_types`
--

INSERT INTO `document_types` (`id`, `name`, `max_marks`, `order`, `created_at`) VALUES
(1, 'Concept Note', 10, 1, '2026-02-02 14:26:24'),
(2, 'Proposal', 20, 2, '2026-02-02 14:26:24'),
(3, 'Literature Review', 15, 3, '2026-02-02 14:26:24'),
(4, 'Methodology', 15, 4, '2026-02-02 14:26:24'),
(5, 'System Architecture', 20, 5, '2026-02-02 14:26:24'),
(6, 'Source Code Link', 50, 6, '2026-02-02 14:26:24'),
(7, 'User Manual', 10, 7, '2026-02-02 14:26:24'),
(8, 'Test Cases', 10, 8, '2026-02-02 14:26:24'),
(9, 'Final Report', 100, 9, '2026-02-02 14:26:24'),
(10, 'Poster/Slides', 10, 10, '2026-02-02 14:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `submilestone_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `grade` decimal(5,2) NOT NULL,
  `visibility` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `project_id`, `submilestone_id`, `document_id`, `supervisor_id`, `grade`, `visibility`, `created_at`) VALUES
(11, 1, 11, 13, 2, 7.00, 0, '2026-02-03 07:34:38'),
(12, 1, 12, 13, 2, 9.00, 0, '2026-02-03 07:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

CREATE TABLE `milestones` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short` varchar(10) NOT NULL,
  `description` text DEFAULT NULL,
  `no` int(3) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `milestones`
--

INSERT INTO `milestones` (`id`, `title`, `short`, `description`, `no`, `deadline`, `created_at`) VALUES
(1, 'Project Proposal', 'Proposal', '', 1, '2026-07-05 00:00:00', '2026-02-02 14:26:24'),
(2, 'Software Requirements Specification', 'SRS', NULL, 2, NULL, '2026-02-02 14:45:52'),
(3, 'Software Design Specification', 'SDS', NULL, 3, '2026-03-20 00:00:00', '2026-02-02 14:26:24'),
(4, 'Implementation plan', 'Implem', '', 4, '2026-04-10 00:00:00', '2026-02-02 14:26:24'),
(5, 'Test Plan', 'Test', '', 5, '2026-04-30 00:00:00', '2026-02-02 14:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `is_checked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `document_id`, `user_id`, `note`, `is_checked`, `created_at`, `updated_at`) VALUES
(11, 13, 2, 'hi', 0, '2026-02-03 07:18:29', '2026-02-03 07:18:29'),
(12, 13, 2, 'improve on the ajfhkjldashfjkldasf', 0, '2026-02-03 07:18:43', '2026-02-03 07:18:43');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `student_id` int(11) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','In Progress','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `student_id`, `supervisor_id`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'KCAU SOT Projects Tracking', 4, 2, 'to track student projects', 'Approved', '2025-03-05 17:38:18', '2026-02-02 14:19:45'),
(2, 'Blockchain Voting System', 15, 3, NULL, 'In Progress', '2026-02-02 14:26:24', '2026-02-02 14:26:24'),
(3, 'AI Medical Diagnosis', 16, 4, NULL, 'Pending', '2026-02-02 14:26:24', '2026-02-02 14:26:24'),
(4, 'IoT Smart Farm', 17, 5, NULL, 'Approved', '2026-02-02 14:26:24', '2026-02-02 14:26:24'),
(5, 'E-Learning Gamification', 18, 6, NULL, 'In Progress', '2026-02-02 14:26:24', '2026-02-02 14:26:24'),
(6, 'Cybersecurity Audit Tool', 19, 7, NULL, 'Approved', '2026-02-02 14:26:24', '2026-02-02 14:26:24'),
(7, 'Mobile Banking Security', 20, 8, NULL, 'Rejected', '2026-02-02 14:26:24', '2026-02-02 14:26:24'),
(8, 'Facial Recognition Entry', 21, 9, NULL, 'In Progress', '2026-02-02 14:26:24', '2026-02-02 14:26:24'),
(9, 'Mental Health Chatbot', 22, 10, NULL, 'Approved', '2026-02-02 14:26:24', '2026-02-02 14:26:24'),
(10, 'Cloud Cost Optimizer', 23, 11, NULL, 'Approved', '2026-02-02 14:26:24', '2026-02-02 14:51:41'),
(11, 'Smart Traffic Control', 24, 12, NULL, 'In Progress', '2026-02-02 14:26:24', '2026-02-02 14:26:24'),
(12, 'Supply Chain Tracker', 25, 13, NULL, 'Approved', '2026-02-02 14:26:24', '2026-02-02 14:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `user_id` int(11) NOT NULL,
  `reg_number` varchar(10) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `reg_number`, `course_id`, `created_at`) VALUES
(4, '21/06643', 1, '2025-03-05 13:35:25'),
(15, '22/01001', 2, '2026-02-02 14:26:24'),
(16, '22/01002', 3, '2026-02-02 14:26:24'),
(17, '22/01003', 4, '2026-02-02 14:26:24'),
(18, '22/01004', 5, '2026-02-02 14:26:24'),
(19, '22/01005', 6, '2026-02-02 14:26:24'),
(20, '22/01006', 7, '2026-02-02 14:26:24'),
(21, '22/01007', 8, '2026-02-02 14:26:24'),
(22, '22/01008', 9, '2026-02-02 14:26:24'),
(23, '22/01009', 10, '2026-02-02 14:26:24'),
(24, '22/01010', 1, '2026-02-02 14:26:24'),
(25, '22/01011', 2, '2026-02-02 14:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `submilestones`
--

CREATE TABLE `submilestones` (
  `id` int(11) NOT NULL,
  `milestone_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `max_marks` int(11) NOT NULL,
  `percentage` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `submilestones`
--

INSERT INTO `submilestones` (`id`, `milestone_id`, `name`, `max_marks`, `percentage`) VALUES
(5, 3, 'SDS Document', 20, NULL),
(11, 1, 'Proposal Document', 10, NULL),
(12, 1, 'Proposal Presentation', 10, NULL),
(13, 2, 'SRS Document', 20, NULL),
(14, 4, 'Implementation Plan Document', 20, NULL),
(15, 5, 'Test Plan Document', 20, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supervision`
--

CREATE TABLE `supervision` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `supervision`
--

INSERT INTO `supervision` (`id`, `project_id`, `supervisor_id`) VALUES
(1, 1, 2),
(2, 2, 3),
(3, 3, 4),
(4, 4, 5),
(5, 5, 6),
(6, 6, 7),
(7, 7, 8),
(8, 8, 9),
(9, 9, 10),
(10, 10, 11);

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_comments`
--

CREATE TABLE `supervisor_comments` (
  `id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `supervisor_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','supervisor','student') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(15) NOT NULL,
  `gender` varchar(6) NOT NULL DEFAULT 'Male'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `phone`, `gender`) VALUES
(1, 'admin', 'admin@mail.com', '$2y$12$7swbO3S.2es2zP0CWJugPeOJoUscpz6Bv26luPD4QxVzL3MHEQBmO', 'admin', '2025-03-03 02:13:12', '0711318428', 'Male'),
(2, 'Supervisor', 'supervisor@mail.com', '$2y$12$bDUFb2rLh9EG8YL0RvWqt.ijru9gzKj9ReYSa5w4pxXrvym/PLCzi', 'supervisor', '2025-03-03 08:33:13', '0712345678', 'Male'),
(3, 'Prof. Wangari', 'wangari@kcau.ac.ke', 'hash3', 'supervisor', '2026-02-02 14:27:50', '0722333444', 'Female'),
(4, 'Joseph Munyira', '2106643@students.kcau.ac.ke', '$2y$12$bDUFb2rLh9EG8YL0RvWqt.ijru9gzKj9ReYSa5w4pxXrvym/PLCzi', 'student', '2025-03-05 13:35:25', '0711111111', 'Male'),
(5, 'Ms. Atieno', 'atieno@kcau.ac.ke', 'hash5', 'supervisor', '2026-02-02 14:27:50', '0722777888', 'Female'),
(6, 'Dr. Omondi', 'omondi@kcau.ac.ke', 'hash6', 'supervisor', '2026-02-02 14:27:50', '0722999000', 'Male'),
(7, 'Prof. Mutua', 'mutua@kcau.ac.ke', 'hash7', 'supervisor', '2026-02-02 14:27:50', '0733111222', 'Male'),
(8, 'Dr. Nekesa', 'nekesa@kcau.ac.ke', 'hash8', 'supervisor', '2026-02-02 14:27:50', '0733333444', 'Female'),
(9, 'Mr. Kiprop', 'kiprop@kcau.ac.ke', 'hash9', 'supervisor', '2026-02-02 14:27:50', '0733555666', 'Male'),
(10, 'Ms. Moraa', 'moraa@kcau.ac.ke', 'hash10', 'supervisor', '2026-02-02 14:27:50', '0733777888', 'Female'),
(11, 'Dr. Hassan', 'hassan@kcau.ac.ke', 'hash11', 'supervisor', '2026-02-02 14:27:50', '0733999000', 'Male'),
(12, 'Prof. Zahra', 'zahra@kcau.ac.ke', 'hash12', 'supervisor', '2026-02-02 14:27:50', '0744111222', 'Female'),
(13, 'Dr. Gakuru', 'gakuru@kcau.ac.ke', 'hash13', 'supervisor', '2026-02-02 14:27:50', '0744333444', 'Male'),
(15, 'Alice Wambui', '2201001@students.kcau.ac.ke', 'hash15', 'student', '2026-02-02 14:27:50', '0721001001', 'Female'),
(16, 'Brian Otieno', '2201002@students.kcau.ac.ke', 'hash16', 'student', '2026-02-02 14:27:50', '0721001002', 'Male'),
(17, 'Catherine Njeri', '2201003@students.kcau.ac.ke', 'hash17', 'student', '2026-02-02 14:27:50', '0721001003', 'Female'),
(18, 'David Kiprono', '2201004@students.kcau.ac.ke', 'hash18', 'student', '2026-02-02 14:27:50', '0721001004', 'Male'),
(19, 'Esther Musyoka', '2201005@students.kcau.ac.ke', 'hash19', 'student', '2026-02-02 14:27:50', '0721001005', 'Female'),
(20, 'Felix Gathuru', '2201006@students.kcau.ac.ke', 'hash20', 'student', '2026-02-02 14:27:50', '0721001006', 'Male'),
(21, 'Grace Kwamboka', '2201007@students.kcau.ac.ke', 'hash21', 'student', '2026-02-02 14:27:50', '0721001007', 'Female'),
(22, 'Humphrey Juma', '2201008@students.kcau.ac.ke', 'hash22', 'student', '2026-02-02 14:27:50', '0721001008', 'Male'),
(23, 'Irene Nafula', '2201009@students.kcau.ac.ke', 'hash23', 'student', '2026-02-02 14:27:50', '0721001009', 'Female'),
(24, 'John Tei', '2201010@students.kcau.ac.ke', 'hash24', 'student', '2026-02-02 14:27:50', '0721001010', 'Male'),
(25, 'Kevin Maloba', '2201011@students.kcau.ac.ke', 'hash25', 'student', '2026-02-02 14:27:50', '0721001011', 'Male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`code`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `document_type_id` (`document_type_id`),
  ADD KEY `documents_ibfk_3` (`user_id`);

--
-- Indexes for table `document_types`
--
ALTER TABLE `document_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `supervisor_id` (`supervisor_id`),
  ADD KEY `projects_ibfk_3` (`project_id`);

--
-- Indexes for table `milestones`
--
ALTER TABLE `milestones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`reg_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `submilestones`
--
ALTER TABLE `submilestones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `milestone_id` (`milestone_id`);

--
-- Indexes for table `supervision`
--
ALTER TABLE `supervision`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indexes for table `supervisor_comments`
--
ALTER TABLE `supervisor_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `document_id` (`document_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `document_types`
--
ALTER TABLE `document_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `milestones`
--
ALTER TABLE `milestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `submilestones`
--
ALTER TABLE `submilestones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `supervision`
--
ALTER TABLE `supervision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supervisor_comments`
--
ALTER TABLE `supervisor_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_ibfk_2` FOREIGN KEY (`document_type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `documents_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_ibfk_3` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `submilestones`
--
ALTER TABLE `submilestones`
  ADD CONSTRAINT `submilestones_ibfk_1` FOREIGN KEY (`milestone_id`) REFERENCES `milestones` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supervision`
--
ALTER TABLE `supervision`
  ADD CONSTRAINT `supervision_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supervision_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supervisor_comments`
--
ALTER TABLE `supervisor_comments`
  ADD CONSTRAINT `supervisor_comments_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `supervisor_comments_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
