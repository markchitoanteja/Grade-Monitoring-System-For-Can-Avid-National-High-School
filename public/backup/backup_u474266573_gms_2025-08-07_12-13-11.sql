-- Database Backup
-- Database: u474266573_gms
-- Date: 2025-08-07 12:13:11

-- Structure for table `grades`
CREATE TABLE `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `quarter_1` decimal(5,2) DEFAULT NULL,
  `quarter_2` decimal(5,2) DEFAULT NULL,
  `quarter_3` decimal(5,2) DEFAULT NULL,
  `quarter_4` decimal(5,2) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id` (`student_id`,`subject_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Structure for table `logs`
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `logs`
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('1', 'd106c18539375e532d305516d08ab0ff', '1', 'Successfully logged into the system.', '2025-08-07 10:43:04', '2025-08-07 10:43:04');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('2', '341a9ee2e755af513c3933b6b185b1b6', '1', 'Successfully logged into the system.', '2025-08-07 11:41:39', '2025-08-07 11:41:39');

-- Structure for table `strands`
CREATE TABLE `strands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Structure for table `students`
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `lrn` varchar(12) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `birthdate` date NOT NULL,
  `strand_id` int(11) NOT NULL,
  `grade_level` enum('11','12') NOT NULL,
  `section` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `lrn` (`lrn`),
  KEY `strand_id` (`strand_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`strand_id`) REFERENCES `strands` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Structure for table `subjects`
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `category` enum('core','applied','specialized') NOT NULL,
  `grade_level` enum('11','12') DEFAULT NULL,
  `strand_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `strand_id` (`strand_id`),
  CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`strand_id`) REFERENCES `strands` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Structure for table `users`
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(50) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `users`
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('1', '4d616d219c781222caba4dcf84c24f2b', 'Administrator', 'admin', '$2y$10$2CTY2kpz3iYrPqSLtjv0q.Gz0IVesZ0cZ5r8yu7y.LUPtxQnDa3ey', 'default-user-image.png', 'admin', '2025-08-07 10:43:04', '2025-08-07 10:43:04');

