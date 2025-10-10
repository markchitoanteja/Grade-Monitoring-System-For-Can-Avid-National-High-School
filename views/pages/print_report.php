<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION["user_id"]) || ($_SESSION["user_type"] ?? '') !== "admin") {
    http_response_code(403);
    echo "Forbidden";
    exit();
}

require_once __DIR__ . '/../../config/helper.php';
require_once __DIR__ . '/../../config/database.php';

if (!isset($db)) {
    $db = new Database();
}

$year = isset($_GET['year']) && is_numeric($_GET['year']) ? intval($_GET['year']) : null;

if ($year) {
    $grades = $db->run_custom_query("
        SELECT 
            CONCAT(students.first_name, ' ', students.last_name) AS student_name,
            subjects.name AS subject_name,
            grades.quarter_1, grades.quarter_2, grades.quarter_3, grades.quarter_4,
            grades.final_grade, grades.remarks
        FROM grades
        JOIN students ON grades.student_id = students.id
        JOIN subjects ON grades.subject_id = subjects.id
        WHERE YEAR(grades.created_at) = {$year}
        ORDER BY students.last_name, students.first_name, subjects.name
    ");
    $title = "Grade Report — School Year {$year}";
} else {
    $grades = $db->run_custom_query("
        SELECT 
            YEAR(created_at) AS year,
            COUNT(*) AS total_records,
            COUNT(DISTINCT student_id) AS total_students,
            COUNT(DISTINCT subject_id) AS total_subjects
        FROM grades
        GROUP BY YEAR(created_at)
        ORDER BY YEAR(created_at) DESC
    ");
    $title = "All Yearly Grade Reports";
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link href="<?= base_url() ?>public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url('public/assets/img/logo.png') ?>" type="image/x-icon">

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #fff;
        }

        .school-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #004080;
            padding-bottom: 15px;
        }

        .school-header img {
            height: 80px;
            margin-bottom: 10px;
        }

        .school-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            color: #004080;
        }

        .school-header h3 {
            margin: 2px 0;
            font-size: 16px;
            color: #333;
        }

        .school-header p {
            font-size: 13px;
            color: #666;
        }

        h4.report-title {
            text-align: center;
            margin: 20px 0;
            font-weight: 600;
            color: #004080;
        }

        h3.sem-title {
            background: #e9f2ff;
            padding: 8px 10px;
            border-left: 4px solid #004080;
            margin-top: 30px;
            font-weight: 600;
            color: #004080;
        }

        .table {
            font-size: 13px;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: 600;
            color: #003366;
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        footer {
            margin-top: 60px;
            text-align: center;
            font-size: 12px;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .signature-section {
            margin-top: 60px;
            text-align: center;
        }

        .signature-line {
            display: inline-block;
            width: 200px;
            margin: 20px 30px;
            border-top: 1px solid #333;
            font-size: 12px;
            padding-top: 5px;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: none;
            }

            .table th {
                background: #e9f2ff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            h3.sem-title {
                background: #e9f2ff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container mt-4">
        <!-- 🔹 SCHOOL HEADER -->
        <div class="school-header">
            <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="School Logo">
            <h2>Can-Avid National High School</h2>
            <h3>Senior High School Department</h3>
            <?php if ($year): ?>
                <p><strong>School Year:</strong> <?= htmlspecialchars($year) ?></p>
            <?php else: ?>
                <p><strong>All Yearly Summary Report</strong></p>
            <?php endif; ?>
        </div>

        <h4 class="report-title"><?= htmlspecialchars($title) ?></h4>

        <?php if ($year && !empty($grades)): ?>
            <?php
            $first_sem = [];
            $second_sem = [];

            foreach ($grades as $g) {
                $q1 = floatval($g['quarter_1']);
                $q2 = floatval($g['quarter_2']);
                $q3 = floatval($g['quarter_3']);
                $q4 = floatval($g['quarter_4']);

                $has_first_sem = ($q1 > 0 || $q2 > 0);
                $has_second_sem = ($q3 > 0 || $q4 > 0);

                if ($has_first_sem) $first_sem[] = $g;
                if ($has_second_sem) $second_sem[] = $g;
            }
            ?>

            <!-- 🔹 FIRST SEMESTER -->
            <h3 class="sem-title">First Semester</h3>
            <?php if (!empty($first_sem)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Quarter 1</th>
                            <th>Quarter 2</th>
                            <th>Computed Final Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($first_sem as $g): ?>
                            <?php
                            $q1 = floatval($g['quarter_1']);
                            $q2 = floatval($g['quarter_2']);
                            $vals = array_filter([$q1, $q2]);
                            $computed = count($vals) ? number_format(array_sum($vals) / count($vals), 2) : '—';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($g['student_name']) ?></td>
                                <td><?= htmlspecialchars($g['subject_name']) ?></td>
                                <td><?= $q1 ?: '—' ?></td>
                                <td><?= $q2 ?: '—' ?></td>
                                <td><?= $computed ?></td>
                                <td><?= htmlspecialchars($g['remarks'] ?: '—') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center text-muted">No records found for First Semester.</p>
            <?php endif; ?>

            <!-- 🔹 SECOND SEMESTER -->
            <h3 class="sem-title">Second Semester</h3>
            <?php if (!empty($second_sem)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Quarter 3</th>
                            <th>Quarter 4</th>
                            <th>Computed Final Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($second_sem as $g): ?>
                            <?php
                            $q3 = floatval($g['quarter_3']);
                            $q4 = floatval($g['quarter_4']);
                            $vals = array_filter([$q3, $q4]);
                            $computed = count($vals) ? number_format(array_sum($vals) / count($vals), 2) : '—';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($g['student_name']) ?></td>
                                <td><?= htmlspecialchars($g['subject_name']) ?></td>
                                <td><?= $q3 ?: '—' ?></td>
                                <td><?= $q4 ?: '—' ?></td>
                                <td><?= $computed ?></td>
                                <td><?= htmlspecialchars($g['remarks'] ?: '—') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center text-muted">No records found for Second Semester.</p>
            <?php endif; ?>

            <!-- 🔹 Signature Section -->
            <div class="signature-section">
                <div class="signature-line">Prepared by:</div>
                <div class="signature-line">Checked by:</div>
                <div class="signature-line">Approved by:</div>
            </div>

        <?php elseif (!$year && !empty($grades)): ?>
            <!-- 🔹 ALL YEAR SUMMARY -->
            <h3 class="sem-title">All Yearly Summary</h3>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>School Year</th>
                        <th>Total Students</th>
                        <th>Total Subjects</th>
                        <th>Total Records</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($grades as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['year']) ?></td>
                            <td><?= $r['total_students'] ?></td>
                            <td><?= $r['total_subjects'] ?></td>
                            <td><?= $r['total_records'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center text-muted">No grade records found.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>
            Printed by: <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Administrator') ?></strong><br>
            Date Printed: <?= date('F d, Y h:i A') ?><br>
            <em>Can-Avid National High School — Senior High School Department</em>
        </p>
    </footer>
</body>

</html>