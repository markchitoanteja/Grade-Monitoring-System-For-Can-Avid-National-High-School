<?php
$db = new Database();

$current_page = basename($_SERVER['REQUEST_URI']);

$sql = "SELECT 
    users.id AS user_id, users.uuid AS user_uuid, users.name AS name, users.username, users.image, users.user_type, 
    students.id AS student_id, students.uuid AS student_uuid, students.lrn, students.strand_id, students.grade_level, students.section, students.first_name, students.middle_name, students.last_name, students.birthday, students.sex, students.email, students.address, students.created_at AS student_created_at, students.updated_at AS student_updated_at,
    strands.code AS strand_code, strands.name AS strand_name
    FROM students
    INNER JOIN users ON students.account_id = users.id
    INNER JOIN strands ON students.strand_id = strands.id
    WHERE users.id = " . intval($_SESSION['student_user_id']);

$user_data = $db->run_custom_query($sql)[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= ucfirst($current_page) ?> - Grade Monitoring System</title>

    <link rel="shortcut icon" href="<?= base_url('public/assets/img/logo.png') ?>" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="<?= base_url('public/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/assets/vendor/simple-datatables/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/assets/vendor/sweetalert2/css/sweetalert2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('public/assets/css/style.css?v=1.0') ?>" rel="stylesheet">
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="<?= base_url('student/dashboard') ?>" class="logo d-flex align-items-center">
                <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="">
                <span class="d-none d-lg-block">Grading System</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-label="User profile dropdown">
                        <img src="<?= base_url('public/assets/img/uploads/' . $user_data['image']) ?>" alt="Profile" class="rounded-circle" style="width: 35px; height: 35px;">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            <?= $user_data["name"] ?>
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $user_data["name"] ?></h6>
                            <span><?= ucfirst($user_data["user_type"]) ?></span>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" id="account_settings">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#about_us_modal">
                                <i class="bi bi-people"></i>
                                <span>About Us</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center logout" href="javascript:void(0)">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link <?= $current_page != "dashboard" ? "collapsed" : null ?>" href="dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Profile -->
            <li class="nav-item">
                <a class="nav-link <?= $current_page != "profile" ? "collapsed" : null ?>" href="profile">
                    <i class="bi bi-person"></i>
                    <span>My Profile</span>
                </a>
            </li>

            <!-- Grades -->
            <li class="nav-item">
                <a class="nav-link <?= $current_page != "grades" ? "collapsed" : null ?>" href="grades">
                    <i class="bi bi-book"></i>
                    <span>My Grades</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <a class="nav-link collapsed logout" href="javascript:void(0)">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
            </li>
        </ul>
    </aside>