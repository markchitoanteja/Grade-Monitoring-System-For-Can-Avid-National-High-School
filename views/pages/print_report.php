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

// 🧩 Read and validate GET parameters
$year = isset($_GET['year']) && is_numeric($_GET['year']) ? intval($_GET['year']) : null;
$strand_id = isset($_GET['strand_id']) && is_numeric($_GET['strand_id']) ? intval($_GET['strand_id']) : null;
$subject_id = isset($_GET['subject_id']) && is_numeric($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

// 🧩 Build WHERE conditions dynamically
$where = [];
if ($year) $where[] = "YEAR(g.created_at) = {$year}";
if ($strand_id) $where[] = "s.strand_id = {$strand_id}";
if ($subject_id) $where[] = "g.subject_id = {$subject_id}";
$whereSQL = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

// 🧩 Fetch full dataset with strand/subject/student info
$grades = $db->run_custom_query("
    SELECT 
        g.*, 
        sub.name AS subject_name,
        st.name AS strand_name,
        s.last_name,
        s.first_name,
        s.middle_name
    FROM grades g
    JOIN students s ON g.student_id = s.id
    JOIN subjects sub ON g.subject_id = sub.id
    JOIN strands st ON s.strand_id = st.id
    $whereSQL
    ORDER BY st.name ASC, sub.name ASC, s.last_name ASC, s.first_name ASC
");

// 🧩 Format student names properly — ✅ Proper capitalization
foreach ($grades as &$g) {
    $lname = ucwords(strtolower(trim($g['last_name'])));
    $fname = ucwords(strtolower(trim($g['first_name'])));
    $mname = trim($g['middle_name']);
    $mInitial = $mname ? strtoupper(substr($mname, 0, 1)) . '.' : '';
    $g['student_name'] = "{$lname}, {$fname} {$mInitial}";
}

// 🧩 Determine the title text
$title_parts = [];
if ($year) $title_parts[] = "S.Y. {$year}";
if ($strand_id) {
    $strand = $db->run_custom_query("SELECT name FROM strands WHERE id = {$strand_id} LIMIT 1");
    if (!empty($strand)) $title_parts[] = $strand[0]['name'];
}
if ($subject_id) {
    $subject = $db->run_custom_query("SELECT name FROM subjects WHERE id = {$subject_id} LIMIT 1");
    if (!empty($subject)) $title_parts[] = $subject[0]['name'];
}
$title = implode(" — ", $title_parts) ?: "Grade Report";
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

        h3.subject-title {
            margin-top: 20px;
            color: #004080;
            font-weight: 600;
            font-size: 15px;
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
            <p><strong><?= htmlspecialchars($title) ?></strong></p>
        </div>

        <?php if (!empty($grades)): ?>
            <?php
            // 🔹 Group data by Strand → Subject
            $grouped = [];
            foreach ($grades as $g) {
                $grouped[$g['strand_name']][$g['subject_name']][] = $g;
            }
            ?>

            <?php foreach ($grouped as $strand_name => $subjects): ?>
                <?php foreach ($subjects as $subject_name => $records): ?>

                    <?php
                    // ✅ Detect which quarters have actual grades
                    $show = [
                        'q1' => false,
                        'q2' => false,
                        'q3' => false,
                        'q4' => false
                    ];
                    foreach ($records as $r) {
                        if ($r['quarter_1'] !== null && $r['quarter_1'] !== '' && $r['quarter_1'] != 0) $show['q1'] = true;
                        if ($r['quarter_2'] !== null && $r['quarter_2'] !== '' && $r['quarter_2'] != 0) $show['q2'] = true;
                        if ($r['quarter_3'] !== null && $r['quarter_3'] !== '' && $r['quarter_3'] != 0) $show['q3'] = true;
                        if ($r['quarter_4'] !== null && $r['quarter_4'] !== '' && $r['quarter_4'] != 0) $show['q4'] = true;
                    }
                    ?>

                    <h4 class="report-title"><?= htmlspecialchars($strand_name) ?> — <?= htmlspecialchars($subject_name) ?></h4>

                    <table class="table table-bordered table-striped mb-4">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <?php if ($show['q1']): ?><th>Quarter 1</th><?php endif; ?>
                                <?php if ($show['q2']): ?><th>Quarter 2</th><?php endif; ?>
                                <?php if ($show['q3']): ?><th>Quarter 3</th><?php endif; ?>
                                <?php if ($show['q4']): ?><th>Quarter 4</th><?php endif; ?>
                                <th>Final Grade</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $r): ?>
                                <tr>
                                    <td class="text-start"><?= htmlspecialchars($r['student_name']) ?></td>
                                    <?php if ($show['q1']): ?><td><?= $r['quarter_1'] ?: '—' ?></td><?php endif; ?>
                                    <?php if ($show['q2']): ?><td><?= $r['quarter_2'] ?: '—' ?></td><?php endif; ?>
                                    <?php if ($show['q3']): ?><td><?= $r['quarter_3'] ?: '—' ?></td><?php endif; ?>
                                    <?php if ($show['q4']): ?><td><?= $r['quarter_4'] ?: '—' ?></td><?php endif; ?>
                                    <td><?= $r['final_grade'] ?: '—' ?></td>
                                    <td><?= htmlspecialchars($r['remarks'] ?: '—') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <div class="signature-section">
                <div class="signature-line">Prepared by:</div>
                <div class="signature-line">Checked by:</div>
                <div class="signature-line">Approved by:</div>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">No grade records found for the given filters.</p>
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