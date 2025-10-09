-- Database Backup
-- Database: `u474266573_gms`
-- Date: 2025-10-10 00:23:28

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Data for table `grades`
-- ----------------------------
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('2', 'c9f0cac5bced8c4ba4280ca7c755e62a', '3', '2', '80.00', '90.00', '0.00', '0.00', '85.00', 'PASSED', '2025-08-27 14:18:36', '2025-08-27 14:18:36');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('4', 'ea3b95ebce8d9977cf3e47bff4dec58b', '5', '4', '90.00', '80.00', '0.00', '0.00', '85.00', 'PASSED', '2025-08-27 14:34:11', '2025-08-27 14:34:11');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('5', '8f86f853a8f3bdeb74fd458ec74c41d9', '6', '5', '90.00', '90.00', '0.00', '0.00', '90.00', 'PASSED', '2025-08-27 14:43:55', '2025-08-27 14:43:55');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('6', '3ce791e3ddcc71ffd4f3dfcbd1071d3a', '7', '6', '99.00', '88.00', '0.00', '0.00', '93.50', 'PASSED', '2025-08-27 14:55:33', '2025-08-27 14:55:33');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('7', 'e162f75296bb65954e09e70fcedfe298', '8', '3', '99.00', '90.00', '0.00', '0.00', '94.50', 'PASSED', '2025-08-27 15:01:28', '2025-08-27 15:01:28');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('8', 'dc1c220995a907eaf84e1d5262386beb', '9', '3', '90.00', '99.00', '0.00', '0.00', '94.50', 'PASSED', '2025-08-27 15:08:28', '2025-08-27 15:08:28');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('9', 'cbe4d91d5870d1ef13e2a9977572aff2', '10', '8', '90.00', '80.00', '0.00', '0.00', '85.00', 'PASSED', '2025-08-27 15:24:35', '2025-08-27 15:24:35');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('10', '7f968746501629ebc5cc3948962c1762', '11', '9', '90.00', '88.00', '0.00', '0.00', '89.00', 'PASSED', '2025-08-27 15:32:05', '2025-08-27 15:32:05');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('11', 'dd0e292174c9617a20bac9b879ade078', '12', '2', '90.00', '89.00', '0.00', '0.00', '89.50', 'PASSED', '2025-08-27 15:36:53', '2025-08-27 15:36:53');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('12', '855c6bbda5797bd05eded60b37e27821', '13', '9', '99.00', '89.00', '0.00', '0.00', '94.00', 'PASSED', '2025-08-27 15:42:14', '2025-08-27 15:42:14');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('13', 'ffa64173ee693db8dcffdff68103b82f', '14', '2', '99.00', '89.00', '0.00', '0.00', '94.00', 'PASSED', '2025-08-28 10:31:10', '2025-08-28 10:31:10');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('15', 'b6eb8628497c32a48ab5939a4a300251', '17', '2', '99.00', '89.00', '0.00', '0.00', '94.00', 'PASSED', '2025-08-28 10:48:38', '2025-08-28 10:48:38');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('16', '7c727fca88c37d91755bdbb90d4a5e2b', '18', '3', '99.00', '98.00', '0.00', '0.00', '98.50', 'PASSED', '2025-08-29 09:18:48', '2025-08-29 09:18:48');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('17', '524ae251ac8b3966af052ce8c9db0033', '19', '2', '85.00', '85.00', '0.00', '0.00', '85.00', 'PASSED', '2025-08-29 09:36:40', '2025-08-29 09:36:40');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('18', '510326876b5080d6dd7d5442ad5d23a8', '20', '3', '90.00', '85.00', '0.00', '0.00', '87.50', 'PASSED', '2025-08-29 10:15:20', '2025-08-29 10:15:20');
INSERT INTO `grades` (`id`, `uuid`, `student_id`, `subject_id`, `quarter_1`, `quarter_2`, `quarter_3`, `quarter_4`, `final_grade`, `remarks`, `created_at`, `updated_at`) VALUES ('20', '4d78c7c24fc1038f2e853fea8ef7237d', '21', '8', '98.00', '89.00', '0.00', '0.00', '93.50', 'PASSED', '2025-10-08 14:35:22', '2025-10-08 14:35:22');

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
  UNIQUE KEY `uuid` (`uuid`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Data for table `logs`
-- ----------------------------
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('1', '8ae239cb6897da4d3af004a97b199a98', '1', 'Successfully logged into the system.', '2025-08-11 08:53:33', '2025-08-11 08:53:33');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('2', '6b77267e8fdf23a1a57180f88336c922', '1', 'Successfully logged into the system.', '2025-08-17 20:04:05', '2025-08-17 20:04:05');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('3', '05bfb790a09f55fd9e74f9a05e50ec95', '1', 'A new strand has been added successfully.', '2025-08-17 20:04:46', '2025-08-17 20:04:46');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('4', 'f981342cf1188319f1345eaedb93c152', '1', 'A student has been added successfully.', '2025-08-17 20:05:18', '2025-08-17 20:05:18');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('5', '289e783fd2c8cb3a2364257b086ba0df', '2', 'Successfully logged into the system.', '2025-08-17 20:05:53', '2025-08-17 20:05:53');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('6', '39e7a9afd67fc3c4b578bfea7049d907', '2', 'Logged out successfully.', '2025-08-17 20:06:29', '2025-08-17 20:06:29');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('7', 'b38a8cbbda417616a1063ee5a1c57ad2', '2', 'Successfully logged into the system.', '2025-08-19 18:15:05', '2025-08-19 18:15:05');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('8', 'cc2fbe28b597092e61b5101307f7f8df', '1', 'Successfully logged into the system.', '2025-08-19 18:17:38', '2025-08-19 18:17:38');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('9', '293e348bb0197dd03ab153a1b6ea5c89', '1', 'A student has been added successfully.', '2025-08-19 18:20:40', '2025-08-19 18:20:40');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('10', '4e3ddc9f4c0313e7d8c3137a2d019ee1', '1', 'A new strand has been added successfully.', '2025-08-19 18:21:02', '2025-08-19 18:21:02');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('11', '1cd44749499d998073429e93348513da', '1', 'A student has been updated successfully.', '2025-08-19 18:21:14', '2025-08-19 18:21:14');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('13', '1ce8b6909f89431aee444b525c51cd4f', '1', 'A new subject has been added successfully.', '2025-08-19 18:25:28', '2025-08-19 18:25:28');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('14', '19cc39f31b6a9836900c4731bca697a8', '1', 'A new grade has been added successfully.', '2025-08-19 18:25:46', '2025-08-19 18:25:46');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('15', '7739cb81d6a1b271ee375668f625cf03', '1', 'Logged out successfully.', '2025-08-19 18:28:09', '2025-08-19 18:28:09');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('16', 'a947cb71ce233d94227889564b9607c4', '2', 'Successfully logged into the system.', '2025-08-19 18:28:28', '2025-08-19 18:28:28');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('17', 'f204c4679cce3f2ddbe42575d8ae8620', '2', 'Logged out successfully.', '2025-08-19 18:32:14', '2025-08-19 18:32:14');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('18', '9f427f90c506499c62078adc678e2669', '1', 'Successfully logged into the system.', '2025-08-19 18:32:24', '2025-08-19 18:32:24');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('19', 'd1d50262790ce8595ee518ae4eb5347e', '1', 'Successfully logged into the system.', '2025-08-27 14:01:25', '2025-08-27 14:01:25');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('20', 'c73a880d179833753cc0ed4ec19db3f2', '1', 'Logged out successfully.', '2025-08-27 14:01:49', '2025-08-27 14:01:49');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('21', 'b9cb21a81831f6c87c724b2a7cb635b4', '2', 'Successfully logged into the system.', '2025-08-27 14:03:38', '2025-08-27 14:03:38');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('22', 'de15c4a45d633d45c39bed0e9b0fec91', '2', 'Logged out successfully.', '2025-08-27 14:03:57', '2025-08-27 14:03:57');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('23', '79731c8c47d865df160f0464c9e9c96a', '2', 'Successfully logged into the system.', '2025-08-27 14:04:00', '2025-08-27 14:04:00');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('24', '937e2bafdf8c17c34f25acd7095b214c', '2', 'Logged out successfully.', '2025-08-27 14:04:23', '2025-08-27 14:04:23');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('25', '8b9f0b213b858ec643239945598e83b0', '1', 'Successfully logged into the system.', '2025-08-27 14:05:13', '2025-08-27 14:05:13');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('26', 'd3aad9ab603c859b48584d566c4a9f74', '1', 'A student has been deleted successfully.', '2025-08-27 14:09:19', '2025-08-27 14:09:19');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('27', 'f03dc01bb4218d0580e962a5978c6e93', '1', 'A new strand has been added successfully.', '2025-08-27 14:10:54', '2025-08-27 14:10:54');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('28', '3001c8a0aefb753324dbc3b67e1bc56d', '1', 'A new strand has been added successfully.', '2025-08-27 14:11:06', '2025-08-27 14:11:06');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('29', '0377d3c348803384f6891280cfd2e18c', '1', 'A new strand has been added successfully.', '2025-08-27 14:11:21', '2025-08-27 14:11:21');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('30', '4e267c66d0f3bc30b02c4d8a2a22df26', '1', 'A subject has been deleted successfully.', '2025-08-27 14:11:47', '2025-08-27 14:11:47');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('31', 'e235177ad91d724536ca3d0814fa8438', '1', 'A new subject has been added successfully.', '2025-08-27 14:12:29', '2025-08-27 14:12:29');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('32', 'fc03a56fcb9a56167092245c3055bf96', '1', 'A student has been added successfully.', '2025-08-27 14:15:17', '2025-08-27 14:15:17');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('33', '3b47c0f78577193d686c2896c8b77e45', '1', 'A student has been updated successfully.', '2025-08-27 14:17:22', '2025-08-27 14:17:22');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('34', '33f9ed16c0ccfd23948124a9539b4774', '1', 'A new subject has been added successfully.', '2025-08-27 14:17:45', '2025-08-27 14:17:45');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('35', '74cd1b23d986174706066c092ccd36f7', '1', 'A student has been updated successfully.', '2025-08-27 14:18:11', '2025-08-27 14:18:11');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('36', 'ae41f085add45cdfbd165cace8f134cc', '1', 'A new grade has been added successfully.', '2025-08-27 14:18:36', '2025-08-27 14:18:36');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('37', 'e7bb2ae6d9e181a21a5e98cc0b101774', '1', 'A student has been added successfully.', '2025-08-27 14:19:54', '2025-08-27 14:19:54');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('39', 'a6a5790ecc807c81b8213a79fb5bfa2c', '1', 'A new grade has been added successfully.', '2025-08-27 14:20:55', '2025-08-27 14:20:55');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('40', '77f7f080fd5eaf3a1fa2ed33d64bfbd9', '1', 'A student has been added successfully.', '2025-08-27 14:32:29', '2025-08-27 14:32:29');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('41', 'b7aee6c909c2843c826e2df676173f5c', '1', 'A new subject has been added successfully.', '2025-08-27 14:33:50', '2025-08-27 14:33:50');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('42', 'ac5b5f67b076e2e9923e455b743434b4', '1', 'A new grade has been added successfully.', '2025-08-27 14:34:11', '2025-08-27 14:34:11');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('43', 'd875a28fed206b6827fae8c7a0654b07', '6', 'Successfully logged into the system.', '2025-08-27 14:35:21', '2025-08-27 14:35:21');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('44', '00d85fd5ad76c32ef5bf31d386eb4816', '1', 'A student has been added successfully.', '2025-08-27 14:42:59', '2025-08-27 14:42:59');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('45', 'f97c20ebbab1277eeb7b15fbd3188577', '1', 'A new subject has been added successfully.', '2025-08-27 14:43:35', '2025-08-27 14:43:35');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('46', '3948cc9ef177ea5d080d35086ceac145', '1', 'A new grade has been added successfully.', '2025-08-27 14:43:55', '2025-08-27 14:43:55');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('47', 'e6844b041d7133f712b2801f53a33c77', '7', 'Successfully logged into the system.', '2025-08-27 14:44:36', '2025-08-27 14:44:36');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('48', '47ca9545bd2daec3f7142c67c94f7122', '1', 'A student has been added successfully.', '2025-08-27 14:54:02', '2025-08-27 14:54:02');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('49', 'f9d12d6687d50370574088c3916daa33', '1', 'A new subject has been added successfully.', '2025-08-27 14:55:02', '2025-08-27 14:55:02');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('50', '05755f2bd10347599a34e1a36faf374f', '1', 'A new grade has been added successfully.', '2025-08-27 14:55:33', '2025-08-27 14:55:33');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('51', '1a7f03f32fcf16b2ee286638edc0a45d', '8', 'Successfully logged into the system.', '2025-08-27 14:57:44', '2025-08-27 14:57:44');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('52', 'f6ec0326447679ba04c2799f4bd1173a', '1', 'A student has been added successfully.', '2025-08-27 15:00:59', '2025-08-27 15:00:59');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('53', '702bdc0bac65b9a869c27b3219fef466', '1', 'A new grade has been added successfully.', '2025-08-27 15:01:28', '2025-08-27 15:01:28');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('54', 'e67e343b6f7d7558a1db3fe2c6299d26', '1', 'A student has been added successfully.', '2025-08-27 15:08:02', '2025-08-27 15:08:02');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('55', 'ac4b3a901ac6323c5e52539ed84abbb8', '1', 'A new grade has been added successfully.', '2025-08-27 15:08:28', '2025-08-27 15:08:28');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('56', '52f9f763a69da244afc49c2cbdd057ea', '1', 'A student has been updated successfully.', '2025-08-27 15:09:18', '2025-08-27 15:09:18');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('57', 'd28b2d03f4384035993eeb5090cdedfb', '1', 'A student has been updated successfully.', '2025-08-27 15:09:44', '2025-08-27 15:09:44');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('58', '816bc3500022a4922fef19f3fbddcc02', '1', 'A student has been added successfully.', '2025-08-27 15:18:50', '2025-08-27 15:18:50');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('59', 'b2f60eedb923ce60078af6f54ea394b9', '11', 'Successfully logged into the system.', '2025-08-27 15:22:36', '2025-08-27 15:22:36');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('60', '69881c79dacb9122a24de25b564bfb40', '1', 'A student has been updated successfully.', '2025-08-27 15:22:43', '2025-08-27 15:22:43');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('61', '1cf84f160808246c7a481ddda75f9a61', '1', 'A new subject has been added successfully.', '2025-08-27 15:23:31', '2025-08-27 15:23:31');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('62', 'd024dff7dad43e4fed16d3dee19cf120', '1', 'A new subject has been added successfully.', '2025-08-27 15:24:17', '2025-08-27 15:24:17');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('63', '940356643055357e33251bbfa79900a8', '1', 'A new grade has been added successfully.', '2025-08-27 15:24:35', '2025-08-27 15:24:35');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('64', 'b01cb47a173b5a03613e354dfb8b3e63', '1', 'A student has been added successfully.', '2025-08-27 15:29:36', '2025-08-27 15:29:36');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('65', 'c9c593c5439f87731690c02a8cc14576', '1', 'A new subject has been added successfully.', '2025-08-27 15:31:31', '2025-08-27 15:31:31');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('66', 'b232bd1dc7fc7f24dc0128995f7654c9', '1', 'A new grade has been added successfully.', '2025-08-27 15:32:05', '2025-08-27 15:32:05');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('67', 'd240fedfbed6ba9dedd5035fa8df31ea', '12', 'Successfully logged into the system.', '2025-08-27 15:32:50', '2025-08-27 15:32:50');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('68', '62ead02d1a4f68037a6ef8add7b75d98', '1', 'A student has been added successfully.', '2025-08-27 15:36:05', '2025-08-27 15:36:05');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('69', 'e537e581c6ee5ff4b9f81500872e3d91', '1', 'A new grade has been added successfully.', '2025-08-27 15:36:53', '2025-08-27 15:36:53');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('70', 'a67cd080109782fef5df96b4a3e541ce', '1', 'A student has been updated successfully.', '2025-08-27 15:38:32', '2025-08-27 15:38:32');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('71', 'f47d81ad3b4bea7eaad3fb96332d0bbf', '1', 'A student has been updated successfully.', '2025-08-27 15:39:43', '2025-08-27 15:39:43');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('72', '4b0e6dec76a3e4e8364262cd431ea584', '1', 'A student has been added successfully.', '2025-08-27 15:41:37', '2025-08-27 15:41:37');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('73', '119a4ce12c5493f14655b62850404337', '1', 'A new grade has been added successfully.', '2025-08-27 15:42:14', '2025-08-27 15:42:14');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('74', '43f07b15993360f27d6132f546331199', '14', 'Successfully logged into the system.', '2025-08-27 15:42:34', '2025-08-27 15:42:34');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('75', 'b5414ac239751bbf76c21678dcac223b', '1', 'Successfully logged into the system.', '2025-08-27 16:24:00', '2025-08-27 16:24:00');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('76', 'bbdfa6913fa61a5dccb27622143fbb4d', '1', 'Successfully logged into the system.', '2025-08-28 10:10:37', '2025-08-28 10:10:37');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('77', 'ef256ac4ef031ce91ebe60d4b55df6fe', '1', 'A student has been added successfully.', '2025-08-28 10:27:55', '2025-08-28 10:27:55');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('78', '65ca88d2510bf82d383efbf045e7a96d', '1', 'A student has been updated successfully.', '2025-08-28 10:29:44', '2025-08-28 10:29:44');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('79', '8920915b5bcd6ed7629ca719d74f5134', '1', 'A student has been updated successfully.', '2025-08-28 10:30:01', '2025-08-28 10:30:01');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('80', '4fda31242f9498029a74213f27387928', '1', 'A student has been updated successfully.', '2025-08-28 10:30:40', '2025-08-28 10:30:40');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('81', 'fe4f2f22adbb560a9d1a84b2bd06da72', '1', 'A new grade has been added successfully.', '2025-08-28 10:31:10', '2025-08-28 10:31:10');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('82', '2d89ef4bdf1f0651f7d512923d64f8cf', '1', 'A student has been added successfully.', '2025-08-28 10:33:03', '2025-08-28 10:33:03');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('83', '07d2f2080ca6276a6c43411b2fa01252', '1', 'A student has been deleted successfully.', '2025-08-28 10:33:32', '2025-08-28 10:33:32');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('84', '58970d6cde70f57824156edadfbab7d8', '1', 'A student has been added successfully.', '2025-08-28 10:35:44', '2025-08-28 10:35:44');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('85', 'e532150acaa909168456be9658f9c450', '1', 'A new grade has been added successfully.', '2025-08-28 10:36:10', '2025-08-28 10:36:10');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('87', '9418c4a39ab968d9bb00c7e32154c7e2', '1', 'A student has been added successfully.', '2025-08-28 10:48:10', '2025-08-28 10:48:10');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('88', '696ae9740125f28bacbc26da5d1422e2', '1', 'A new grade has been added successfully.', '2025-08-28 10:48:38', '2025-08-28 10:48:38');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('90', '494097f1e1228a9cd79b4af04a4446e3', '18', 'Successfully logged into the system.', '2025-08-28 10:49:09', '2025-08-28 10:49:09');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('91', '77ad6594ebe53142798530d4cc0bc905', '1', 'A student has been deleted successfully.', '2025-08-28 10:51:22', '2025-08-28 10:51:22');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('92', '966a6e2635c1a1f7dd0484bafa7a6325', '1', 'A student has been added successfully.', '2025-08-29 09:17:53', '2025-08-29 09:17:53');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('93', '05e7b1580ea0319c947b21f4735a9d3d', '18', 'Logged out successfully.', '2025-08-29 09:18:23', '2025-08-29 09:18:23');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('94', '896510a35f9a2c5d9d2c95655ff1945e', '19', 'Successfully logged into the system.', '2025-08-29 09:18:31', '2025-08-29 09:18:31');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('95', '2ecc9ed65c63f9c95bd38ccdfd7d56c8', '1', 'A new grade has been added successfully.', '2025-08-29 09:18:48', '2025-08-29 09:18:48');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('96', '2d9e42e491e6e78cdf500b10081ae970', '1', 'A student has been updated successfully.', '2025-08-29 09:20:04', '2025-08-29 09:20:04');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('97', 'e57be98b36f24d5444df4ea321f57e3a', '1', 'A student has been added successfully.', '2025-08-29 09:35:54', '2025-08-29 09:35:54');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('98', '6325176cd6510f476bf1c016efd8c63c', '1', 'A new grade has been added successfully.', '2025-08-29 09:36:40', '2025-08-29 09:36:40');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('99', 'e9a820183e06cb4074370da5445f3723', '20', 'Successfully logged into the system.', '2025-08-29 09:38:01', '2025-08-29 09:38:01');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('100', 'e266de4489a436684746607a838b7d8d', '1', 'A student has been added successfully.', '2025-08-29 10:14:39', '2025-08-29 10:14:39');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('101', 'f3e28f62b9d534a317cb887ef673c7ee', '1', 'A new grade has been added successfully.', '2025-08-29 10:15:20', '2025-08-29 10:15:20');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('102', '8b3eeb20788b35be2e8bd3a6e9762d8c', '1', 'Successfully logged into the system.', '2025-08-31 17:55:09', '2025-08-31 17:55:09');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('103', '7bee15575a8538de1b69e0a3888718ad', '1', 'Successfully logged into the system.', '2025-09-02 09:57:10', '2025-09-02 09:57:10');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('104', '05f8935566a55cce9e4a52ecab54f648', '1', 'A subject has been updated successfully.', '2025-09-02 11:06:38', '2025-09-02 11:06:38');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('105', '16c31a449859a18b0d3fe325c021c365', '1', 'A subject has been updated successfully.', '2025-09-02 11:06:53', '2025-09-02 11:06:53');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('106', '6b73de08b8f8050607108ace71b5b6b7', '1', 'Successfully logged into the system.', '2025-09-02 23:56:57', '2025-09-02 23:56:57');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('107', '8a69fd3ccf2b5ddb8018c4d24786fc4d', '1', 'Successfully logged into the system.', '2025-10-02 09:49:34', '2025-10-02 09:49:34');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('108', 'e947448061b64915808b77c0b9a9163f', '1', 'A new grade has been added successfully.', '2025-10-02 13:32:16', '2025-10-02 13:32:16');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('109', '53ede0dd7dd5017a6dfd90431e2cc983', '1', 'Database backup was successful.', '2025-10-02 14:05:32', '2025-10-02 14:05:32');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('110', 'c220fe837f044740da7cb990c8468253', '1', 'Successfully logged into the system.', '2025-10-06 01:32:27', '2025-10-06 01:32:27');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('111', '13e9e74d009284b406e813fe0473c819', '1', 'Successfully logged into the system.', '2025-10-06 06:36:59', '2025-10-06 06:36:59');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('112', '5fd85394f127fef0cf48cb38d1ffbd1c', '1', 'Successfully logged into the system.', '2025-10-07 22:47:38', '2025-10-07 22:47:38');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('113', 'b3964fcb29ab1b0125e9a9b69aecdf5e', '1', 'Logged out successfully.', '2025-10-07 22:47:42', '2025-10-07 22:47:42');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('114', '18209c1e4e1205847bf9cbcf913efa8d', '1', 'Successfully logged into the system.', '2025-10-08 14:30:23', '2025-10-08 14:30:23');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('115', 'c8d3e542371abad04447895844392c59', '1', 'A student has been deleted successfully.', '2025-10-08 14:32:15', '2025-10-08 14:32:15');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('116', '1fa423fd5b4a43460233d0faafb83327', '1', 'A student has been added successfully.', '2025-10-08 14:33:05', '2025-10-08 14:33:05');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('117', '4b0161fe7acc358497947b19bc1f8b20', '1', 'A new grade has been added successfully.', '2025-10-08 14:35:22', '2025-10-08 14:35:22');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('118', 'cbb032051112804da31e6c01bd01360f', '22', 'Successfully logged into the system.', '2025-10-08 14:37:25', '2025-10-08 14:37:25');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('119', 'cce8da49ecd8f249e0c90f39e4697924', '1', 'Logged out successfully.', '2025-10-08 14:38:35', '2025-10-08 14:38:35');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('120', 'd0252483afaa94becfe8c0f27fd62ecd', '1', 'Successfully logged into the system.', '2025-10-09 21:29:45', '2025-10-09 21:29:45');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('121', '773542cb2d4d7795db97770a6d033903', '1', 'Logged out successfully.', '2025-10-10 00:11:01', '2025-10-10 00:11:01');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('122', 'ab4e389bd295473b1b6d5fe3260aefc7', '1', 'Successfully logged into the system.', '2025-10-10 00:21:01', '2025-10-10 00:21:01');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Data for table `strands`
-- ----------------------------
INSERT INTO `strands` (`id`, `uuid`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES ('1', '77037994da77cc08e784a6c015ef5097', 'STEM', 'Science, Technology, Engineering and Mathematics', 'This is a test strand. Please delete this on production.', '2025-08-17 20:04:46', '2025-08-17 20:04:46');
INSERT INTO `strands` (`id`, `uuid`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES ('2', '5e64f867f591548512b2134be2a981b9', 'ABM', 'Accountancy, Business and Management', '', '2025-08-19 18:21:02', '2025-08-19 18:21:02');
INSERT INTO `strands` (`id`, `uuid`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES ('3', '7bf5af9989475c2f8102697216f05bd4', 'HUMSS', 'Humanities and Social Science', '', '2025-08-27 14:10:54', '2025-08-27 14:10:54');
INSERT INTO `strands` (`id`, `uuid`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES ('4', '79cdc4d4f623fe4d1da035ca5174433d', 'TVL', 'Technical Vocational Livelihood', '', '2025-08-27 14:11:06', '2025-08-27 14:11:06');
INSERT INTO `strands` (`id`, `uuid`, `code`, `name`, `description`, `created_at`, `updated_at`) VALUES ('5', '37782273b4c4f565ea4604b6273f7dcb', 'GAS', 'General Academic Strand', '', '2025-08-27 14:11:21', '2025-08-27 14:11:21');

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Data for table `students`
-- ----------------------------
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('1', 'b9938db453510b845c058fe79e50a568', '2', '17-00136', '1', '11', 'Valentine', 'Mark Chito', 'Rizano', 'Anteja', '1994-07-23', 'Male', '00anteja23@gmail.com', 'Project 8', '2025-08-17 20:05:14', '2025-08-17 20:05:14');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('3', '07655085aaa0822fd18269fc824f915d', '4', '122433130012', '3', '11', 'A', 'jian', '', 'sam', '2004-05-03', 'Male', 'jiancesista@gmail.com', 'brgy 15, lunang d.e.s', '2025-08-27 14:15:13', '2025-08-27 14:18:11');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('5', '0618495de99dfa505698b34ced581fd2', '6', '122654110022', '4', '11', 'culumbos', 'Kurt', 'O', 'Placiente', '2005-10-05', 'Male', 'kurtplaciente@gmail.com', 'Oras E. Samar', '2025-08-27 14:32:25', '2025-08-27 14:32:25');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('6', 'b9035f4665ac0a20c2bf3765aeca76e1', '7', '122463090040', '5', '11', 'B', 'Grethel', 'L', 'Nuguit', '2002-07-23', 'Female', 'grethelnuguit@gmail.com', 'Maslog', '2025-08-27 14:42:57', '2025-08-27 14:42:57');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('7', 'bdcdc74dd96893f5549973bdb5306c6c', '8', '12345456784', '3', '11', 'B', 'Maria fe', 'Dacoliat', 'Tabuena', '2005-01-05', 'Female', 'tabuenamafe@gmail.com', 'Brgy. Japitan Dolores E. Samar', '2025-08-27 14:54:00', '2025-08-27 14:54:00');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('8', '1b20be10e80d20298cb4c154ec13fce0', '9', '122433100013', '3', '11', 'Gemini', 'Anita', 'Labial', 'Afable', '2005-07-16', 'Female', 'anitavicent05@gmail.com', 'Dolores E. Samar', '2025-08-27 15:00:56', '2025-08-27 15:09:44');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('9', '30ecaaf26c677eb499f0224eb0b042c0', '10', '1224330903', '3', '11', 'cronus', 'jolanie nicole', 'g', 'tegerero', '2003-12-12', 'Female', 'lorezojoermhil@gmail.com', 'Dolores', '2025-08-27 15:07:59', '2025-08-27 15:22:43');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('10', 'fe44bceb2390d8641ce5733b4f29b926', '11', '122330110005', '2', '11', 'A', 'Annie', 'O', 'Montallana', '2006-12-09', 'Female', 'montallanaanamae2006@gmail.com', 'Brgy.4 can-avid', '2025-08-27 15:18:48', '2025-08-27 15:18:48');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('11', '9c6bba3eca3d3fb424ad1561db25a58e', '12', '122668110020', '4', '11', 'A', 'Patrick', 'S', 'Corongay', '2005-11-07', 'Male', 'corongaypatrick@gmail.com', 'brgy. 10', '2025-08-27 15:29:33', '2025-08-27 15:29:33');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('12', 'cb5cae10b2f79b6f3d237f219485008d', '13', '122668090106', '3', '11', 'cronus', 'Hannah', 'P.', 'Madeja', '2004-03-09', 'Female', 'madejahannah9@gmail.com', 'Oras E. Samar', '2025-08-27 15:36:01', '2025-08-27 15:39:43');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('13', '7118f784c0aecb25d165deb3e4bf2bd5', '14', '1234567890', '4', '11', 'A', 'Hanna', '', 'Madeja', '2003-01-12', 'Female', 'raizagiba915@gmail.com', 'optional', '2025-08-27 15:41:34', '2025-08-27 15:41:34');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('14', '3fe367ba359afdd2e4717c7f0b716578', '15', '122659090032', '3', '11', 'A', 'margie', 'lalosa', 'tamares', '0202-12-12', 'Female', 'margietamares5@gmail.com', 'buntay', '2025-08-28 10:27:53', '2025-08-28 10:30:40');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('17', '8aa32d6914ff9137c059b28d3549c8f9', '18', '122413100140', '3', '11', 'A', 'Rio Mark', 'Orale', 'Julianes', '2004-04-18', 'Male', 'raizagiba0@gmail.com', 'can-avid', '2025-08-28 10:48:07', '2025-08-28 10:48:07');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('18', '16e393a33cf9f04a09548fe76246f2b4', '19', '122424110001', '3', '11', '11', 'VICTOR ', 'B', 'BEDICO', '2006-02-06', 'Male', 'victor@gmail.com', 'Rawis', '2025-08-29 09:17:51', '2025-08-29 09:20:04');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('19', '252fbcc197ab20bb84eeb1bbff8c4f64', '20', '192508100006', '3', '11', 'lincon', 'michael jude', 'bajelot', 'morallos', '2004-08-10', 'Male', 'michaeljudemorallos2004@gmail.com', 'dacul', '2025-08-29 09:35:51', '2025-08-29 09:35:51');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('20', 'eafea295daf6e9efc8fdcb965124a50c', '21', '122644849876', '3', '11', 'b', 'kyla shine', 'jaromay', 'legria', '2007-08-02', 'Female', 'jaromaymary4@gmail.com', 'barangay solong can avid Eastern Samar', '2025-08-29 10:14:36', '2025-08-29 10:14:36');
INSERT INTO `students` (`id`, `uuid`, `account_id`, `lrn`, `strand_id`, `grade_level`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `sex`, `email`, `address`, `created_at`, `updated_at`) VALUES ('21', 'bd87cdd37873b52c49f68b3062bfed0c', '22', '122742090015', '2', '11', 'A', 'Cherry Joy', '', 'Bianes', '2004-03-01', 'Female', 'cherryjhoyqt@gmail.com', 'San Poli', '2025-10-08 14:33:03', '2025-10-08 14:33:03');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Data for table `subjects`
-- ----------------------------
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('2', 'd190fa8f5acd79661d91d9c5306e1259', 'Oral Communication', 'core', '11', '3', '2025-08-27 14:12:29', '2025-08-27 14:12:29');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('3', '2472b62d614dc5d3ea65aba87fa435ed', 'General Mathematics', 'core', '11', '3', '2025-08-27 14:17:45', '2025-08-27 14:17:45');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('4', '0f25213742ca622c9ccfbbc26f75b5f3', 'Earth and Life Science', 'applied and specialized', '11', '4', '2025-08-27 14:33:50', '2025-08-27 14:33:50');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('5', '0a6df8e383a6b18bb1e2ad6ea0976a9c', 'Accounting', 'core', '11', '5', '2025-08-27 14:43:34', '2025-08-27 14:43:34');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('6', '86629950507f704d9d63c8139ce3461d', 'Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino', 'core', '11', '3', '2025-08-27 14:55:02', '2025-08-27 14:55:02');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('7', '087f0251adc492d4b8fa94c027622f94', 'Physical Education & Health 1', 'applied and specialized', '11', '4', '2025-08-27 15:23:31', '2025-08-27 15:23:31');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('8', 'f4444263612580383b4aebe220d4fd46', 'Physical Education & Health 1', 'core', '11', '2', '2025-08-27 15:24:17', '2025-08-27 15:24:17');
INSERT INTO `subjects` (`id`, `uuid`, `name`, `category`, `grade_level`, `strand_id`, `created_at`, `updated_at`) VALUES ('9', '7178decfa222d203362fb77c18a6cb64', 'P.E.', 'applied and specialized', '11', '4', '2025-08-27 15:31:31', '2025-09-02 11:06:53');

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Data for table `users`
-- ----------------------------
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('1', '96dd6703677c0a448e83f3af51ef7af3', 'Administrator', 'admin', '$2y$10$fyz8zBQqlRtiCU3XNeoosO2.ld1pyYjg9HLVaRif/WbRvL0vVp4qK', 'default-user-image.png', 'admin', '2025-08-09 23:53:37', '2025-08-09 23:53:37');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('2', '1d84ee20c5a03135aae5fc54b9a03a66', 'Mark Chito R. Anteja', '17-00136', '$2y$10$cqhlizk/8UamZNIGri.IeeeuExK.HgZdoqBk/0YEjnnoUauLe3H32', 'img_68a1c57ed0ee45.86186140.jpg', 'student', '2025-08-17 20:05:14', '2025-08-17 20:05:14');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('4', '9111595c8ab134123d21bb79d28b33da', 'jian sam', '122433130012', '$2y$10$J.LfDvPGH8qXSDMwdCxgH.mBbzft0mdQ.sGHVMYO9RmgrkwAiLn4y', 'default-user-image.png', 'student', '2025-08-27 14:18:11', '2025-08-27 14:18:11');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('6', '9dd4cfdafa96d97c76211945eff4e001', 'Kurt O. Placiente', '122654110022', '$2y$10$HmnyKzFNCqHt3d4ff2qpfORgPnxS3I7F2VClXUpP0z26MKLrK7N5m', 'default-user-image.png', 'student', '2025-08-27 14:32:25', '2025-08-27 14:32:25');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('7', '864b32d3a90b5d62ac2393cf6c13b5d6', 'Grethel L. Nuguit', '122463090040', '$2y$10$bhwh6mHy3af31yf.SZ7KruZMai6UTMlwterxGoU.KaoKpD.0ubYSy', 'default-user-image.png', 'student', '2025-08-27 14:42:57', '2025-08-27 14:42:57');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('8', '2631515a7b9ea57f67645be1d050d2d9', 'Maria fe D. Tabuena', '12345456784', '$2y$10$/vCDPXd7azX7cDfwUH/tx.hen59lgGVLMxzKFHKn/kRpfd82hop.S', 'default-user-image.png', 'student', '2025-08-27 14:54:00', '2025-08-27 14:54:00');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('9', '7f7c01029a3edd7eb7594f8399fd7c81', 'Anita L. Afable', '122433100013', '$2y$10$YkGmmsfcQ0hajfTCKwIjPerBafhf.zuvw.g4eEP2xzSQp8eEbsTSe', 'default-user-image.png', 'student', '2025-08-27 15:09:44', '2025-08-27 15:09:44');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('10', '0036bc62193673f99250f426b40358a4', 'jolanie nicole G. tegerero', '1224330903', '$2y$10$zyugcH4RvWLoU8XAKaNjjeMMkDpv2Q8Z0936/fZebgdV7F57psLVW', 'default-user-image.png', 'student', '2025-08-27 15:22:43', '2025-08-27 15:22:43');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('11', '8f2654168b78e999733511cc0e668f83', 'Annie O. Montallana', '122330110005', '$2y$10$805PD6OMUUcI2b0ucLgKveR9uGvzdd0mCiJmCYKJLfVFfYL9.l4Wu', 'default-user-image.png', 'student', '2025-08-27 15:18:48', '2025-08-27 15:18:48');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('12', 'fc04c0bd8a20e2958c733eda6e21ae36', 'Patrick S. Corongay', '122668110020', '$2y$10$IEv2JX0.WS24kjY6mTJj0e/fTycgFujQuZnTxkp9vmRzPNmr/jPaq', 'default-user-image.png', 'student', '2025-08-27 15:29:33', '2025-08-27 15:29:33');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('13', 'c2fcf552abd3ace26c5f4292e4964152', 'Hannah P. Madeja', '122668090106', '$2y$10$glfQbZlpagAeD4A7zoG5Xe.7UgTZH2q8NNdhr3q3ShkFpUkbM6qy.', 'default-user-image.png', 'student', '2025-08-27 15:39:43', '2025-08-27 15:39:43');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('14', '13b238f420d86c0990c99c406a2d5704', 'Hanna Madeja', '1234567890', '$2y$10$4ysMct1hLfDoOpQpostUvum2VdBOdHEKTR382WBbVUwej6n.G7zOy', 'default-user-image.png', 'student', '2025-08-27 15:41:34', '2025-08-27 15:41:34');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('15', '29ac58534ffcdaa9bb187c3795e56171', 'margie L. tamares', '122659090032', '$2y$10$0pfjFI5ZxoBAyPNTZEHJZ.hl8iYDQqCDRgnltsfAijNtgr7UFOMSW', 'default-user-image.png', 'student', '2025-08-28 10:30:40', '2025-08-28 10:30:40');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('18', 'fc5320b284104542674c3a9924665e7f', 'Rio Mark O. Julianes', '122413100140', '$2y$10$nRMrrsv6YUWrOzq/AFWFouSexxLHxBO2CGqwNt1HB8zp0L.bnSv/u', 'default-user-image.png', 'student', '2025-08-28 10:48:07', '2025-08-28 10:48:07');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('19', 'fc773e18109639d7c92b600d3b52711c', 'VICTOR  B. BEDICO', '122424110001', '$2y$10$28wEXsJw2SmgD5Hn3boq2eN/p98HZar/Vv4i6m9t3DCzkP1VmIxNm', 'default-user-image.png', 'student', '2025-08-29 09:20:04', '2025-08-29 09:20:04');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('20', 'a27a5a0681367d8739302bd5c28172f4', 'michael jude B. morallos', '192508100006', '$2y$10$Y.p2axnCB4EMhtOyjFXyV.J3K/GiOtFTDP4P9oTTXEzQ6HS2MvCnG', 'default-user-image.png', 'student', '2025-08-29 09:35:51', '2025-08-29 09:35:51');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('21', '7b8438c98b7b7b01d1d05d957046f8cf', 'kyla shine J. legria', '122644849876', '$2y$10$8JeeXc4xVrcEXSs3v8m95.HWC5sXKuAzSPXrQvQI0Jb/oT3KZqQ2u', 'default-user-image.png', 'student', '2025-08-29 10:14:36', '2025-08-29 10:14:36');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('22', 'f5d2b535e84a975f3f11a13bcaa3ead5', 'Cherry Joy Bianes', '122742090015', '$2y$10$KmfJaOj/3EBJTSNslzD6sOM1V.Xib.BcK3ixA6WJQ8CeS5yF86JB.', 'default-user-image.png', 'student', '2025-10-08 14:33:03', '2025-10-08 14:33:03');

SET FOREIGN_KEY_CHECKS = 1;
