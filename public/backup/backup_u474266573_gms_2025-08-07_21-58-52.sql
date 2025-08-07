-- Database Backup
-- Database: `u474266573_gms`
-- Date: 2025-08-07 21:58:52

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Structure for table `grades`
-- ----------------------------
DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
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
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `student_id` (`student_id`,`subject_id`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Structure for table `logs`
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Data for table `logs`
-- ----------------------------
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('1', 'f1f2beae71526038246694caf4a8db1a', '1', 'Successfully logged into the system.', '2025-08-07 18:34:44', '2025-08-07 18:34:44');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('2', '4a2abfc792e7426c79cd501ae6d82eb8', '1', 'A new strand has been added successfully.', '2025-08-07 18:34:53', '2025-08-07 18:34:53');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('3', '77c41fd6a3cc1d2353b4bd05e7de40f5', '1', 'A new strand has been added successfully.', '2025-08-07 18:34:59', '2025-08-07 18:34:59');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('4', '6f660696de2c3fcd9dd895a3d44ca533', '1', 'A new strand has been added successfully.', '2025-08-07 18:35:06', '2025-08-07 18:35:06');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('5', '670d99a083239505aedabb33ec801baa', '1', 'A student has been added successfully.', '2025-08-07 18:35:32', '2025-08-07 18:35:32');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('6', '0fd1cb32b84c2baf3ec54ef540cc6265', '1', 'A student has been added successfully.', '2025-08-07 19:30:12', '2025-08-07 19:30:12');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('7', '88fd7e02b49652bf13d030d132018934', '1', 'A student has been updated successfully.', '2025-08-07 21:03:38', '2025-08-07 21:03:38');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('8', '2fdf4b527eaf98b0fe9918d5172fdb0c', '1', 'A student has been updated successfully.', '2025-08-07 21:03:45', '2025-08-07 21:03:45');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('9', '7a0971e2f2c8f0037381aa2be606190b', '1', 'A student has been updated successfully.', '2025-08-07 21:03:54', '2025-08-07 21:03:54');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('10', 'fcf383cfdd840f4096db811046f50d60', '1', 'A student has been updated successfully.', '2025-08-07 21:04:15', '2025-08-07 21:04:15');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('11', '75157b6fdb5e0a3024f61fa5df6857a5', '1', 'A student has been deleted successfully.', '2025-08-07 21:08:51', '2025-08-07 21:08:51');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('12', 'a8947baf0c60c7e14b49f8d15c8e4870', '1', 'A new subject has been added successfully.', '2025-08-07 21:45:31', '2025-08-07 21:45:31');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('13', '00555f6188d81de0ac35eb9ae315ba98', '1', 'Added subject \'Oral Communication\' to all strands.', '2025-08-07 21:48:04', '2025-08-07 21:48:04');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('14', 'e6c140a91c30efeca8c98e3d3f1d2091', '1', 'A new subject has been added successfully.', '2025-08-07 21:49:06', '2025-08-07 21:49:06');

-- ----------------------------
-- Structure for table `strands`
-- ----------------------------
DROP TABLE IF EXISTS `strands`;
CREATE TABLE `strands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Data for table `strands`
-- ----------------------------
INSERT INTO `strands` (`id`, `uuid`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES ('1', '8593b58d0f61fe2dc04ae0cfba09af6b', 'STEM', 'Science, Technology, Engineering and Mathematics', '', '2025-08-07 18:34:53', '2025-08-07 18:34:53');
INSERT INTO `strands` (`id`, `uuid`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES ('2', '6470738680d5ef3ae27c44d3a19baefe', 'HUMSS', 'Humanities and Social Sciences', '', '2025-08-07 18:34:59', '2025-08-07 18:34:59');
INSERT INTO `strands` (`id`, `uuid`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES ('3', 'e47624fbe0ac70c95c7d7d12ec60ba90', 'ABM', 'Accountancy, Business and Management', '', '2025-08-07 18:35:06', '2025-08-07 18:35:06');

-- ----------------------------
-- Structure for table `students`
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `account_id` int(11) NOT NULL,
  `lrn` varchar(12) NOT NULL,
  `strand_id` int(11) NOT NULL,
  `grade_level` enum('11','12') NOT NULL,
  `section` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `birthday` date NOT NULL,
  `sex` enum('Male','Female') NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `account_id` (`account_id`),
  UNIQUE KEY `lrn` (`lrn`),
  UNIQUE KEY `email` (`email`),
  KEY `strand_id` (`strand_id`),
  CONSTRAINT `students_ibfk_1` FOREIGN KEY (`strand_id`) REFERENCES `strands` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `students_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Data for table `students`
-- ----------------------------
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('1', '1c4b209d8c51d9a44652471190f7112c', '2', '17-00136', '3', '11', 'Valentine', 'Mark Chito', 'Rizano', 'Anteja', '1994-07-23', 'Male', '00anteja23@gmail.com', 'Project 8', '2025-08-07 18:35:32', '2025-08-07 18:35:32');

-- ----------------------------
-- Structure for table `subjects`
-- ----------------------------
DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` enum('core','applied and specialized') NOT NULL,
  `grade_level` enum('11','12') DEFAULT NULL,
  `strand_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  KEY `strand_id` (`strand_id`),
  CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`strand_id`) REFERENCES `strands` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Data for table `subjects`
-- ----------------------------
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('9', '4e1162ad60690cddc286bffa2e495489', 'Oral Communication', 'core', '11', '1', '2025-08-07 21:48:04', '2025-08-07 21:48:04');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('10', '3817f86d9ebc0937632c7c2301bf68aa', 'Oral Communication', 'core', '11', '2', '2025-08-07 21:48:04', '2025-08-07 21:48:04');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('11', 'bcb3d32335a9e3a7a4e3bb2e77502ed1', 'Oral Communication', 'core', '11', '3', '2025-08-07 21:48:04', '2025-08-07 21:48:04');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('12', '3aa86ca5a47f04066ce035c684e885e0', 'Pre-Calculus', 'applied and specialized', '11', '1', '2025-08-07 21:49:06', '2025-08-07 21:49:06');

-- ----------------------------
-- Structure for table `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Data for table `users`
-- ----------------------------
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('1', '091c9a7f8e7c028efa5c7af50a751427', 'Administrator', 'admin', '$2y$10$YrBOV2LsBnSlahcCBvSATu9NEvpsMZmlZx91RnY7cvfAZVzD9ZXK6', 'default-user-image.png', 'admin', '2025-08-07 18:34:41', '2025-08-07 18:34:41');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('2', '1718a8d458820e38194d0bc686b6b1d6', 'Mark Chito R. Anteja', '17-00136', '$2y$10$MkG1SNYQ0R/hc08X/vS3fueflxHdmbik1uHmbLV3vXm/8iz9WL3Oa', 'img_68948174199640.75510605.jpg', 'student', '2025-08-07 18:35:32', '2025-08-07 18:35:32');

SET FOREIGN_KEY_CHECKS = 1;
