-- Database Backup
-- Database: student_grading_system
-- Date: 2024-12-08 18:58:38

-- Structure for table `courses`
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `code` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `years` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `courses`
INSERT INTO `courses` (`id`, `uuid`, `code`, `description`, `years`, `created_at`, `updated_at`) VALUES ('2', '8e55bc97f0ea8a1260e1df7f058fb019', 'BSIT', 'Bachelor of Science in Information Technology', '4', '2024-12-04 11:10:34', '2024-12-04 11:10:34');

-- Structure for table `grade_components`
CREATE TABLE `grade_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `component` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `grade_components`
INSERT INTO `grade_components` (`id`, `uuid`, `teacher_id`, `subject_id`, `component`, `weight`, `created_at`, `updated_at`) VALUES ('1', '2a9c369bf930981d641c40eff8893954', '5', '1', 'Quiz', '10', '2024-12-04 11:32:59', '2024-12-04 11:32:59');
INSERT INTO `grade_components` (`id`, `uuid`, `teacher_id`, `subject_id`, `component`, `weight`, `created_at`, `updated_at`) VALUES ('2', '0473a34049912a813a648e30c0f29a5b', '5', '1', 'Exam', '30', '2024-12-04 11:36:55', '2024-12-04 11:36:55');
INSERT INTO `grade_components` (`id`, `uuid`, `teacher_id`, `subject_id`, `component`, `weight`, `created_at`, `updated_at`) VALUES ('3', '3cba548b20d4eaa62e93f74490e47f0e', '5', '1', 'Attendance', '15', '2024-12-04 11:37:10', '2024-12-04 11:37:10');
INSERT INTO `grade_components` (`id`, `uuid`, `teacher_id`, `subject_id`, `component`, `weight`, `created_at`, `updated_at`) VALUES ('4', '09837ec94572e7183fcc4ffef372dd38', '5', '1', 'Recitation', '20', '2024-12-04 11:37:56', '2024-12-04 11:38:22');
INSERT INTO `grade_components` (`id`, `uuid`, `teacher_id`, `subject_id`, `component`, `weight`, `created_at`, `updated_at`) VALUES ('5', '6d3bf1601e4c83a91f5c763596f6d0bd', '5', '1', 'Project', '25', '2024-12-04 11:38:17', '2024-12-04 11:38:27');
INSERT INTO `grade_components` (`id`, `uuid`, `teacher_id`, `subject_id`, `component`, `weight`, `created_at`, `updated_at`) VALUES ('6', '527bf40d2474822da0478c728d8635ea', '7', '2', 'Quiz', '10', '2024-12-08 04:49:47', '2024-12-08 04:49:47');
INSERT INTO `grade_components` (`id`, `uuid`, `teacher_id`, `subject_id`, `component`, `weight`, `created_at`, `updated_at`) VALUES ('7', 'f39a2976ee9f3935a277b4ed840138ef', '7', '2', 'Performance', '50', '2024-12-08 04:50:51', '2024-12-08 04:50:51');
INSERT INTO `grade_components` (`id`, `uuid`, `teacher_id`, `subject_id`, `component`, `weight`, `created_at`, `updated_at`) VALUES ('8', '6635412c8da4d04091986cea1aaf42b5', '7', '2', 'Exam', '40', '2024-12-08 04:51:02', '2024-12-08 04:51:02');

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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `logs`
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('1', '0fc83029a184c9c980333933118baec1', '1', 'Logged out successfully.', '2024-12-04 10:58:36', '2024-12-04 10:58:36');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('2', 'd4e92c5417e4caff006ec5788d28ff1d', '1', 'Successfully logged into the system.', '2024-12-04 10:59:51', '2024-12-04 10:59:51');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('3', 'bcaa494aaaf1feba98013e8204456480', '1', 'A course has been added successfully.', '2024-12-04 11:10:34', '2024-12-04 11:10:34');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('4', '5cb127e985620e9a6fed36dd266103c0', '1', 'A subject has been added successfully.', '2024-12-04 11:13:01', '2024-12-04 11:13:01');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('5', 'a049b5bc3eb30aac9c36978bdd3faca9', '1', 'A teacher has been added successfully.', '2024-12-04 11:15:49', '2024-12-04 11:15:49');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('6', '1691f9cc6d2ebbacf8605c553a176b54', '1', 'A student has been added successfully.', '2024-12-04 11:19:40', '2024-12-04 11:19:40');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('7', '3b79d73758492c82a8faf9701e7bab40', '1', 'Logged out successfully.', '2024-12-04 11:31:38', '2024-12-04 11:31:38');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('8', '4aef01dfe585192cc3379354182250c2', '5', 'Successfully logged into the system.', '2024-12-04 11:31:45', '2024-12-04 11:31:45');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('9', '651b6a19c568347e8b643aa4035ac7ac', '5', 'A grade component has been added successfully.', '2024-12-04 11:32:59', '2024-12-04 11:32:59');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('10', '2783372885567b2d5ebb15f27fee50fd', '5', 'A grade component has been added successfully.', '2024-12-04 11:36:55', '2024-12-04 11:36:55');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('11', '25e734d6788911f267418ccc91adbf74', '5', 'A grade component has been added successfully.', '2024-12-04 11:37:10', '2024-12-04 11:37:10');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('12', 'a1fcb12753c1f31cf05f30568a368680', '5', 'A grade component has been added successfully.', '2024-12-04 11:37:56', '2024-12-04 11:37:56');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('13', 'b7c2e0c89f761ff603f9c536f914a0d0', '5', 'A grade component has been added successfully.', '2024-12-04 11:38:17', '2024-12-04 11:38:17');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('14', '347da681985998975979d70f3c82e69d', '5', 'A grade component has been updated successfully.', '2024-12-04 11:38:22', '2024-12-04 11:38:22');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('15', '31e7a3176c512416408ff45edd979e42', '5', 'A grade component has been updated successfully.', '2024-12-04 11:38:27', '2024-12-04 11:38:27');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('16', '77359cb5f3e16801da3345b74a53d5ff', '5', 'A grade has been added successfully.', '2024-12-04 11:45:09', '2024-12-04 11:45:09');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('17', '2528e1c67e6fa0678046166d729a2504', '5', 'Logged out successfully.', '2024-12-04 12:00:21', '2024-12-04 12:00:21');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('18', '0c7ac2955cfa69552f1d70e7fe8f376e', '6', 'Successfully logged into the system.', '2024-12-04 12:00:28', '2024-12-04 12:00:28');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('19', '5ef74461a6bdc5795089676f29be8e24', '1', 'Successfully logged into the system.', '2024-12-07 16:45:26', '2024-12-07 16:45:26');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('20', '92051d0699687698d0071565dd6522a9', '1', 'Logged out successfully.', '2024-12-07 18:29:49', '2024-12-07 18:29:49');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('21', '620ebd546c8b2947ec0422cd5e61713a', '5', 'Successfully logged into the system.', '2024-12-07 18:29:54', '2024-12-07 18:29:54');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('22', 'd815b12a2b1ac9b329275329359aecd8', '5', 'A grade has been added successfully.', '2024-12-07 18:30:17', '2024-12-07 18:30:17');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('23', '08027866e03783957b7623b70f7bd486', '5', 'The grade has been updated successfully.', '2024-12-07 18:30:34', '2024-12-07 18:30:34');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('24', '95ca62b19693987a1d973f149ee1788f', '5', 'A grade has been added successfully.', '2024-12-07 18:30:50', '2024-12-07 18:30:50');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('25', 'dd7e18a86a2430f203bdb37c02dfbc56', '5', 'A grade has been added successfully.', '2024-12-07 18:31:14', '2024-12-07 18:31:14');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('26', '3185adbdd7f9afe715246f09b5c3e2a4', '5', 'A grade has been added successfully.', '2024-12-07 18:31:35', '2024-12-07 18:31:35');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('27', 'c31a5a89a5fdb90a644d9648e292a83e', '5', 'Logged out successfully.', '2024-12-07 18:31:39', '2024-12-07 18:31:39');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('28', 'ab508878dd6b4a177e3f355fadb6e2e5', '6', 'Successfully logged into the system.', '2024-12-07 18:31:45', '2024-12-07 18:31:45');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('29', 'b5504a22c08e3c0f341f5c175bf361db', '6', 'Logged out successfully.', '2024-12-07 18:45:44', '2024-12-07 18:45:44');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('30', '457305d9fb89634da917df8b58f6d0f0', '5', 'Successfully logged into the system.', '2024-12-07 18:45:50', '2024-12-07 18:45:50');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('31', '1f17e5851ef9a7802e3dfc935139b293', '5', 'Logged out successfully.', '2024-12-07 18:53:28', '2024-12-07 18:53:28');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('32', '4c36b0f818887f1bd52395ff8fe42a7f', '1', 'Successfully logged into the system.', '2024-12-07 18:53:36', '2024-12-07 18:53:36');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('33', '1ea5060f6f39fed7db1c4aad67edb31a', '1', 'Logged out successfully.', '2024-12-08 04:40:07', '2024-12-08 04:40:07');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('34', 'd258174b9f9378c5bf410c8bda756e5d', '5', 'Successfully logged into the system.', '2024-12-08 04:40:14', '2024-12-08 04:40:14');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('35', '4148cac3b953b4f223db26380d7e57e1', '5', 'Logged out successfully.', '2024-12-08 04:42:09', '2024-12-08 04:42:09');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('36', '57cdb70a41bde5841f488ca356061e42', '1', 'Successfully logged into the system.', '2024-12-08 04:42:13', '2024-12-08 04:42:13');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('37', '7b08bfa52ecc684a67ae78e03852e9bd', '1', 'A teacher has been added successfully.', '2024-12-08 04:43:34', '2024-12-08 04:43:34');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('38', 'cceb95abed1b652663b51d54fcddf0ee', '1', 'Logged out successfully.', '2024-12-08 04:43:37', '2024-12-08 04:43:37');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('39', '9a0e6ae42254d38b7c1ec20922d1b61a', '7', 'Successfully logged into the system.', '2024-12-08 04:43:42', '2024-12-08 04:43:42');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('40', '8293e5ff3e804a73bde3b06129ad6723', '7', 'Logged out successfully.', '2024-12-08 04:44:34', '2024-12-08 04:44:34');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('41', '3b09e4b30122782c7144eabcdb5d38ed', '1', 'Successfully logged into the system.', '2024-12-08 04:44:40', '2024-12-08 04:44:40');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('42', 'a9a43b0804371fcca117cddfaa2fd2e5', '1', 'A subject has been added successfully.', '2024-12-08 04:49:21', '2024-12-08 04:49:21');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('43', '897b993d5deb100e3da6fb205ae09656', '1', 'Logged out successfully.', '2024-12-08 04:49:24', '2024-12-08 04:49:24');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('44', '60f4a686a9293614fc885ef11087f70e', '1', 'Successfully logged into the system.', '2024-12-08 04:49:25', '2024-12-08 04:49:25');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('45', 'ae1abe081800e7718e397a044fd94855', '1', 'Logged out successfully.', '2024-12-08 04:49:28', '2024-12-08 04:49:28');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('46', 'fff65b8b9ed4786fb54668e305c30369', '7', 'Successfully logged into the system.', '2024-12-08 04:49:33', '2024-12-08 04:49:33');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('47', '96bbd041063e0929083204fd0d68c1e7', '7', 'A grade component has been added successfully.', '2024-12-08 04:49:47', '2024-12-08 04:49:47');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('48', 'a7107c3705d9f06594d62812ece6ac82', '7', 'Logged out successfully.', '2024-12-08 04:50:12', '2024-12-08 04:50:12');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('49', 'aeaa546f2f3f5af4e3801705a2a1a396', '5', 'Successfully logged into the system.', '2024-12-08 04:50:15', '2024-12-08 04:50:15');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('50', '87a707fab5f2f304bebc26801ce5fad5', '5', 'Logged out successfully.', '2024-12-08 04:50:22', '2024-12-08 04:50:22');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('51', '828ae7f38a9b45388cecde18d53bc098', '7', 'Successfully logged into the system.', '2024-12-08 04:50:27', '2024-12-08 04:50:27');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('52', 'b88f40c3356fd8220df8d76c3700c0ff', '7', 'A grade component has been added successfully.', '2024-12-08 04:50:51', '2024-12-08 04:50:51');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('53', '96554037d4c0f82c0c972566a90936b3', '7', 'A grade component has been added successfully.', '2024-12-08 04:51:02', '2024-12-08 04:51:02');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('54', 'ca558990bf523809a6a74facbb854aa7', '7', 'A grade has been added successfully.', '2024-12-08 04:51:24', '2024-12-08 04:51:24');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('55', '0cfb303fb82fbd44934efb8d5ec8b387', '7', 'A grade has been added successfully.', '2024-12-08 04:51:42', '2024-12-08 04:51:42');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('56', '1d14c2518b34ebe4631e5f456a0f3e26', '7', 'A grade has been added successfully.', '2024-12-08 04:51:59', '2024-12-08 04:51:59');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('57', 'dbdb7f10b73ca4ab37933e0fc34d5e3c', '7', 'Logged out successfully.', '2024-12-08 04:52:21', '2024-12-08 04:52:21');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('58', 'fd6bc556506fd6d616eff806d2e323f0', '5', 'Successfully logged into the system.', '2024-12-08 04:52:24', '2024-12-08 04:52:24');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('59', '5430e85afa608ac09f49133ced73caaf', '5', 'Logged out successfully.', '2024-12-08 04:52:38', '2024-12-08 04:52:38');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('60', '4b889c6d9412ff20b5da2a92ee695d64', '1', 'Successfully logged into the system.', '2024-12-08 04:52:41', '2024-12-08 04:52:41');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('61', '9ef05b9ee4f253b381af718f18bef283', '1', 'Logged out successfully.', '2024-12-08 05:46:44', '2024-12-08 05:46:44');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('62', 'a59ef2e611cfece7b615e6b37f97040e', '5', 'Successfully logged into the system.', '2024-12-08 05:46:48', '2024-12-08 05:46:48');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('63', '562d07eb93f04e04304bea42a5eec8a1', '1', 'Successfully logged into the system.', '2024-12-08 14:41:10', '2024-12-08 14:41:10');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('64', '196f3ea4b44570087433607c8e826d00', '1', 'Logged out successfully.', '2024-12-08 14:41:28', '2024-12-08 14:41:28');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('65', 'b739505867188bda721c26aac35e136e', '5', 'Successfully logged into the system.', '2024-12-08 14:41:32', '2024-12-08 14:41:32');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('66', '6a4c1c9fee142bd0d1969bb4217d4243', '5', 'Logged out successfully.', '2024-12-08 17:50:14', '2024-12-08 17:50:14');
INSERT INTO `logs` (`id`, `uuid`, `user_id`, `activity`, `created_at`, `updated_at`) VALUES ('67', '6f41927d28087d5a82111801a93dd7c6', '1', 'Successfully logged into the system.', '2024-12-08 17:50:17', '2024-12-08 17:50:17');

-- Structure for table `student_grades`
CREATE TABLE `student_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `grade_component_id` int(11) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `grade` float(11,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `student_grades`
INSERT INTO `student_grades` (`id`, `uuid`, `teacher_id`, `student_id`, `subject_id`, `grade_component_id`, `course`, `year`, `semester`, `grade`, `created_at`, `updated_at`) VALUES ('1', '8f80132bc9ee6a2fc6e4e43828a7efd8', '5', '6', '1', '1', 'BSIT', '1st', '1st', '90.00', '2024-12-04 11:45:09', '2024-12-04 11:45:09');
INSERT INTO `student_grades` (`id`, `uuid`, `teacher_id`, `student_id`, `subject_id`, `grade_component_id`, `course`, `year`, `semester`, `grade`, `created_at`, `updated_at`) VALUES ('2', '84db555cb425b1769a39b8e395bc7870', '5', '6', '1', '2', 'BSIT', '1st', '1st', '87.00', '2024-12-07 18:30:17', '2024-12-07 18:30:34');
INSERT INTO `student_grades` (`id`, `uuid`, `teacher_id`, `student_id`, `subject_id`, `grade_component_id`, `course`, `year`, `semester`, `grade`, `created_at`, `updated_at`) VALUES ('3', 'ad5890d099bdd331853ca1a057dc817d', '5', '6', '1', '3', 'BSIT', '1st', '1st', '100.00', '2024-12-07 18:30:50', '2024-12-07 18:30:50');
INSERT INTO `student_grades` (`id`, `uuid`, `teacher_id`, `student_id`, `subject_id`, `grade_component_id`, `course`, `year`, `semester`, `grade`, `created_at`, `updated_at`) VALUES ('4', '63ffe8a35714e7079ed8497252368c24', '5', '6', '1', '4', 'BSIT', '1st', '1st', '85.00', '2024-12-07 18:31:14', '2024-12-07 18:31:14');
INSERT INTO `student_grades` (`id`, `uuid`, `teacher_id`, `student_id`, `subject_id`, `grade_component_id`, `course`, `year`, `semester`, `grade`, `created_at`, `updated_at`) VALUES ('5', '9f0bd5992e0dfcf1ce568c48071286c6', '5', '6', '1', '5', 'BSIT', '1st', '1st', '90.00', '2024-12-07 18:31:35', '2024-12-07 18:31:35');
INSERT INTO `student_grades` (`id`, `uuid`, `teacher_id`, `student_id`, `subject_id`, `grade_component_id`, `course`, `year`, `semester`, `grade`, `created_at`, `updated_at`) VALUES ('6', '7e1b6e3f820fc3da3cb3bee4084d1dd6', '7', '6', '2', '6', 'BSIT', '1st', '1st', '90.00', '2024-12-08 04:51:24', '2024-12-08 04:51:24');
INSERT INTO `student_grades` (`id`, `uuid`, `teacher_id`, `student_id`, `subject_id`, `grade_component_id`, `course`, `year`, `semester`, `grade`, `created_at`, `updated_at`) VALUES ('7', 'e2fa7b1c9511d85dbdf9251e309958ae', '7', '6', '2', '7', 'BSIT', '1st', '1st', '80.00', '2024-12-08 04:51:42', '2024-12-08 04:51:42');
INSERT INTO `student_grades` (`id`, `uuid`, `teacher_id`, `student_id`, `subject_id`, `grade_component_id`, `course`, `year`, `semester`, `grade`, `created_at`, `updated_at`) VALUES ('8', 'b194af72a37f42a777325e57e30c5426', '7', '6', '2', '8', 'BSIT', '1st', '1st', '75.00', '2024-12-08 04:51:59', '2024-12-08 04:51:59');

-- Structure for table `students`
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `account_id` int(11) NOT NULL,
  `student_number` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `section` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `mobile_number` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `account_id` (`account_id`),
  UNIQUE KEY `student_number` (`student_number`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `students`
INSERT INTO `students` (`id`, `uuid`, `account_id`, `student_number`, `course`, `year`, `section`, `first_name`, `middle_name`, `last_name`, `birthday`, `mobile_number`, `email`, `address`, `created_at`, `updated_at`) VALUES ('3', '341f7f5c340457a4ae9b95b3c3cb5098', '6', '22-00001', 'BSIT', '1st', 'A', 'Juan', 'Dela', 'Cruz', '2000-01-01', '09123456789', 'juandc@gmail.com', 'Can-Avid Eastern Samar', '2024-12-04 11:19:40', '2024-12-04 11:19:40');

-- Structure for table `subjects`
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `code` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `lecture_units` int(11) NOT NULL,
  `laboratory_units` int(11) NOT NULL,
  `hours_per_week` int(11) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `subjects`
INSERT INTO `subjects` (`id`, `uuid`, `code`, `description`, `lecture_units`, `laboratory_units`, `hours_per_week`, `course`, `year`, `semester`, `created_at`, `updated_at`) VALUES ('1', 'c8e6231ee2c9abf913d7adcd288a2ece', 'Comp 111', 'Introduction to Computing', '3', '0', '5', 'BSIT', '1st', '1st', '2024-12-04 11:13:00', '2024-12-04 11:13:00');
INSERT INTO `subjects` (`id`, `uuid`, `code`, `description`, `lecture_units`, `laboratory_units`, `hours_per_week`, `course`, `year`, `semester`, `created_at`, `updated_at`) VALUES ('2', '4ae1087f39b37a00a1b3064e0c2ade4e', 'Comp 112', 'Computer Programming 1', '2', '1', '5', 'BSIT', '1st', '1st', '2024-12-08 04:49:21', '2024-12-08 04:49:21');

-- Structure for table `teachers`
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(36) NOT NULL,
  `account_id` int(11) NOT NULL,
  `employee_number` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birthday` varchar(100) NOT NULL,
  `mobile_number` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `account_id` (`account_id`),
  UNIQUE KEY `employee_number` (`employee_number`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `teachers`
INSERT INTO `teachers` (`id`, `uuid`, `account_id`, `employee_number`, `first_name`, `middle_name`, `last_name`, `birthday`, `mobile_number`, `email`, `address`, `created_at`, `updated_at`) VALUES ('2', 'f4578eec70746cf17208954217fc79ea', '5', '20-00001', 'Jane', '', 'Doe', '1994-01-01', '09123456789', 'jane@gmail.com', 'Can-Avid, Eastern Samar', '2024-12-04 11:15:49', '2024-12-04 11:15:49');
INSERT INTO `teachers` (`id`, `uuid`, `account_id`, `employee_number`, `first_name`, `middle_name`, `last_name`, `birthday`, `mobile_number`, `email`, `address`, `created_at`, `updated_at`) VALUES ('3', '2c86d19404e8f3b9023ba035b547c6a8', '7', '17-00136', 'Mark Chito', 'Rizano', 'Anteja', '1994-07-23', '09511816599', '00anteja23@gmail.com', 'Project 8, Dao, Oras, Eastern Samar', '2024-12-08 04:43:34', '2024-12-08 04:43:34');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Data for table `users`
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('1', 'b901333e60d63fe8c71116ff4195118f', 'Administrator', 'admin', '$2y$10$bP0N9otIzsPR3jV87tL5gOgCO/UGs8dJwSXgum/wAmLu2cawPKAhC', 'default-user-image.png', 'admin', '2024-11-09 11:48:08', '2024-11-09 11:48:08');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('5', 'b3b5fb7eba3a569cfbaf5a978ee0a715', 'Jane Doe', 'jane', '$2y$10$5K6J4LT57Ez.hqSALcki5uYdcToEiC29A2aKkfA0aj9Y7NruKYEYy', 'img_674fc96504e7c1.77564053.webp', 'teacher', '2024-12-04 11:15:49', '2024-12-04 11:15:49');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('6', '8c1f0e1d9e7afa506c2a8043553b5b47', 'Juan D. Cruz', 'juan', '$2y$10$g9y5W/JsUYi0Nq4JgzhVvecVFR1qY3IiQp2bs8So4IEB.ngP/UE7a', 'img_674fca4cbff303.97158649.webp', 'student', '2024-12-04 11:19:40', '2024-12-04 11:19:40');
INSERT INTO `users` (`id`, `uuid`, `name`, `username`, `password`, `image`, `user_type`, `created_at`, `updated_at`) VALUES ('7', '952c8f6e892fdcb6189de595cf778ab5', 'Mark Chito R. Anteja', 'chito23', '$2y$10$YjH9yZk.X1Otf9UJ.7wz4OJaGM04NFwm72lN4gjTgfqzmtE06PeXy', 'img_6754b376882d29.95563283.jpg', 'teacher', '2024-12-08 04:43:34', '2024-12-08 04:43:34');

