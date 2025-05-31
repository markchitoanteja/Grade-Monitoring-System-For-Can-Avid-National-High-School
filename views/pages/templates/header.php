<?php
$current_page = basename($_SERVER['REQUEST_URI']);

$user_data = $db->select_one("users", "id", $_SESSION["user_id"]);

if ($_SESSION["user_type"] == "teacher") {
    $teacher_student_data = $db->select_one("teachers", "account_id", $_SESSION["user_id"]);
}

if ($_SESSION["user_type"] == "student") {
    $teacher_student_data = $db->select_one("students", "account_id", $_SESSION["user_id"]);
}

function get_initials($first_name)
{
    $nameParts = explode(" ", $first_name);
    $initials = "";

    foreach ($nameParts as $part) {
        if (!empty($part)) {
            $initials .= strtoupper($part[0]) . ". ";
        }
    }

    return trim($initials);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= ucfirst($current_page) ?> - Grade Monitoring System</title>

    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="assets/vendor/sweetalert2/css/sweetalert2.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">Grading System</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="assets/img/uploads/<?= $user_data["image"] ?>" alt="Profile" class="rounded-circle" style="width: 35px; height: 35px;">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION["user_type"] != "admin" ? get_initials($teacher_student_data["first_name"]) . " " . $teacher_student_data["last_name"] : $user_data["name"] ?></span>
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
            <?php if ($_SESSION["user_type"] == "admin"): ?>
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "dashboard" ? "collapsed" : null ?>" href="dashboard">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Courses -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "courses" ? "collapsed" : null ?>" href="courses">
                        <i class="bi bi-journal-bookmark-fill"></i>
                        <span>Courses</span>
                    </a>
                </li>

                <!-- Subjects -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "subjects" ? "collapsed" : null ?>" href="subjects">
                        <i class="bi bi-book-fill"></i>
                        <span>Subjects</span>
                    </a>
                </li>

                <!-- Teachers -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "teachers" ? "collapsed" : null ?>" href="teachers">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Teachers</span>
                    </a>
                </li>

                <!-- Students -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "students" ? "collapsed" : null ?>" href="students">
                        <i class="bi bi-people-fill"></i>
                        <span>Students</span>
                    </a>
                </li>
                
                <!-- Backup and Restore -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "backup_and_restore" ? "collapsed" : null ?>" href="backup_and_restore">
                        <i class="bi bi-database"></i>
                        <span>Backup and Restore</span>
                    </a>
                </li>
            <?php endif ?>

            <?php if ($_SESSION["user_type"] == "teacher"): ?>
                <!-- Grade Components -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "grade_components" ? "collapsed" : null ?>" href="grade_components">
                        <i class="bi bi-pie-chart-fill"></i>
                        <span>Grade Components</span>
                    </a>
                </li>
                <!-- Grades Entry -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "grade_entries" ? "collapsed" : null ?>" href="grade_entries">
                        <i class="bi bi-pencil-fill"></i>
                        <span>Grade Entries</span>
                    </a>
                </li>
                <!-- Student Grades-->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "student_grades" ? "collapsed" : null ?>" href="student_grades">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Student Grades</span>
                    </a>
                </li>
            <?php endif ?>

            <?php if ($_SESSION["user_type"] == "student"): ?>
                <!-- My Grades -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page != "my_grades" ? "collapsed" : null ?>" href="my_grades">
                        <i class="bi bi-journal-text"></i>
                        <span>My Grades</span>
                    </a>
                </li>
            <?php endif ?>

            <!-- Logout -->
            <li class="nav-item">
                <a class="nav-link collapsed logout" href="javascript:void(0)">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </a>
            </li>
        </ul>
    </aside>