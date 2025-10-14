<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION["user_id"]) || ($_SESSION["user_type"] ?? '') !== "admin") {
    http_response_code(403);
    echo "Forbidden";
    exit();
}

require_once __DIR__ . '/../../config/helper.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($db)) {
    $db = new Database();
}

// 🔹 Read filters
$year = isset($_GET['year']) && is_numeric($_GET['year']) ? intval($_GET['year']) : null;
$strand_id = isset($_GET['strand_id']) && is_numeric($_GET['strand_id']) ? intval($_GET['strand_id']) : null;
$subject_id = isset($_GET['subject_id']) && is_numeric($_GET['subject_id']) ? intval($_GET['subject_id']) : null;

// 🔹 Build WHERE clause
$where = [];
if ($year) $where[] = "YEAR(g.created_at) = {$year}";
if ($strand_id) $where[] = "s.strand_id = {$strand_id}";
if ($subject_id) $where[] = "g.subject_id = {$subject_id}";
$whereSQL = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

// 🔹 Fetch grades
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
    ORDER BY st.name, sub.name, s.last_name, s.first_name
");

// 🔹 Format student names
foreach ($grades as &$g) {
    $lname = ucfirst(strtolower(trim($g['last_name'])));
    $fname = ucfirst(strtolower(trim($g['first_name'])));
    $mname = trim($g['middle_name']);
    $mInitial = $mname ? strtoupper(substr($mname, 0, 1)) . '.' : '';
    $g['student_name'] = "{$lname}, {$fname} {$mInitial}";
}
unset($g); // 🔥 FIX: break reference to prevent duplicated student rows

// 🔹 Title
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
$filename = str_replace(" ", "_", $title) . ".pdf";

// 🔹 Start HTML
ob_start();
?>

<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 140px 40px 100px 40px;
        }

        body {
            font-family: "Segoe UI", "DejaVu Sans", Arial, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.4;
            background-color: #fff;
        }

        /* === HEADER === */
        header.school-header {
            position: fixed;
            top: -120px;
            left: 0;
            right: 0;
            text-align: center;
            border-bottom: 3px solid #004080;
            padding-bottom: 12px;
        }

        header.school-header img {
            height: 80px;
            margin-bottom: 8px;
        }

        header.school-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            color: #004080;
        }

        header.school-header h3 {
            margin: 3px 0;
            font-size: 16px;
            color: #333;
        }

        header.school-header p {
            font-size: 13px;
            color: #666;
        }

        /* === FOOTER === */
        footer {
            position: fixed;
            bottom: -70px;
            left: 0;
            right: 0;
            height: 60px;
            border-top: 1px solid #aaa;
            text-align: center;
            font-size: 10px;
            color: #555;
        }

        .page-number:after {
            content: counter(page);
        }

        /* === TABLES & TITLES === */
        h3.section-title {
            background: #f0f6ff;
            border-left: 5px solid #004080;
            padding: 8px 10px;
            color: #004080;
            font-weight: bold;
            margin-top: 40px;
            margin-bottom: 10px;
            font-size: 13px;
        }

        h4.subject-title {
            color: #003366;
            font-weight: bold;
            margin-top: 20px;
            font-size: 12.5px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11.5px;
            margin-top: 8px;
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #e8f0fa;
            color: #003366;
            font-weight: bold;
        }

        td.text-start {
            text-align: left;
        }

        tr:nth-child(even) td {
            background-color: #fafafa;
        }

        /* === SIGNATURES === */
        .signature-section {
            margin-top: 80px;
            text-align: center;
        }

        .signature-line {
            display: inline-block;
            width: 200px;
            margin: 25px;
            border-top: 1px solid #333;
            font-size: 11px;
            padding-top: 5px;
        }

        .no-data {
            text-align: center;
            color: #777;
            font-style: italic;
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <header class="school-header">
        <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="School Logo">
        <h2>Can-Avid National High School</h2>
        <h3>Senior High School Department</h3>
        <p><strong><?= htmlspecialchars($title) ?></strong></p>
    </header>

    <main>
        <?php if (!empty($grades)): ?>
            <?php
            // 🔹 Group by Strand → Subject
            $grouped = [];
            foreach ($grades as $g) {
                $grouped[$g['strand_name']][$g['subject_name']][] = $g;
            }

            foreach ($grouped as $strand_name => $subjects):
            ?>
                <?php foreach ($subjects as $subject_name => $records): ?>
                    <?php
                    // 🔹 Detect which quarters have grades
                    $visibleQuarters = [];
                    foreach (['quarter_1', 'quarter_2', 'quarter_3', 'quarter_4'] as $q) {
                        foreach ($records as $r) {
                            if (!empty($r[$q]) && $r[$q] > 0) {
                                $visibleQuarters[$q] = true;
                                break;
                            }
                        }
                    }
                    ?>

                    <table style="margin-top: 100px;">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <?php if (!empty($visibleQuarters['quarter_1'])): ?><th>Quarter 1</th><?php endif; ?>
                                <?php if (!empty($visibleQuarters['quarter_2'])): ?><th>Quarter 2</th><?php endif; ?>
                                <?php if (!empty($visibleQuarters['quarter_3'])): ?><th>Quarter 3</th><?php endif; ?>
                                <?php if (!empty($visibleQuarters['quarter_4'])): ?><th>Quarter 4</th><?php endif; ?>
                                <th>Final Grade</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $r): ?>
                                <tr>
                                    <td class="text-start"><?= htmlspecialchars($r['student_name']) ?></td>
                                    <?php if (!empty($visibleQuarters['quarter_1'])): ?><td><?= $r['quarter_1'] ?: '—' ?></td><?php endif; ?>
                                    <?php if (!empty($visibleQuarters['quarter_2'])): ?><td><?= $r['quarter_2'] ?: '—' ?></td><?php endif; ?>
                                    <?php if (!empty($visibleQuarters['quarter_3'])): ?><td><?= $r['quarter_3'] ?: '—' ?></td><?php endif; ?>
                                    <?php if (!empty($visibleQuarters['quarter_4'])): ?><td><?= $r['quarter_4'] ?: '—' ?></td><?php endif; ?>
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
            <p class="no-data">No grade records found for the selected filters.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>
            Printed by: <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Administrator') ?></strong> |
            Date Printed: <?= date('F d, Y h:i A') ?><br>
            <span class="page-number">Page </span><br>
            <em>Can-Avid National High School — Senior High School Department</em>
        </p>
    </footer>
</body>

</html>

<?php
$html = ob_get_clean();

// 🔹 Dompdf setup
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// 🔹 Output PDF
$dompdf->stream($filename, ["Attachment" => true]);
exit;
?>