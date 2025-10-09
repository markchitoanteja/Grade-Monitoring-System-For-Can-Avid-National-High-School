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

// Prepare filename
$filename = $year ? "CNHS_Grade_Report_{$year}.xls" : "CNHS_All_Grade_Reports.xls";

// Send Excel headers
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

echo "<html><head><meta charset='utf-8'></head><body>";
echo "<style>
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background: #f2f2f2; font-weight: bold; }
        h2, h3, h4, p { text-align: center; margin: 5px 0; }
    </style>";

echo "<h2>Can-Avid National High School</h2>";
echo "<h3>Senior High School Department</h3>";

if ($year) {
    echo "<p><strong>School Year:</strong> {$year}</p>";

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

    if ($grades) {
        // Separate grades by semester
        $first_sem = [];
        $second_sem = [];

        foreach ($grades as $g) {
            $q1 = floatval($g['quarter_1']);
            $q2 = floatval($g['quarter_2']);
            $q3 = floatval($g['quarter_3']);
            $q4 = floatval($g['quarter_4']);

            $has_first_sem = ($q1 > 0 || $q2 > 0);
            $has_second_sem = ($q3 > 0 || $q4 > 0);

            if ($has_first_sem && !$has_second_sem) {
                $first_sem[] = $g;
            } elseif ($has_second_sem && !$has_first_sem) {
                $second_sem[] = $g;
            } elseif ($has_first_sem && $has_second_sem) {
                $first_sem[] = $g;
                $second_sem[] = $g;
            }
        }

        // 🔹 FIRST SEMESTER
        echo "<h4>First Semester</h4>";
        if (!empty($first_sem)) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Quarter 1</th>
                            <th>Quarter 2</th>
                            <th>Computed Final Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead><tbody>";

            foreach ($first_sem as $g) {
                $q1 = floatval($g['quarter_1']);
                $q2 = floatval($g['quarter_2']);
                $vals = array_filter([$q1, $q2]);
                $computed = count($vals) ? number_format(array_sum($vals) / count($vals), 2) : '';

                echo "<tr>
                        <td>" . htmlspecialchars($g['student_name']) . "</td>
                        <td>" . htmlspecialchars($g['subject_name']) . "</td>
                        <td>" . ($q1 ?: '') . "</td>
                        <td>" . ($q2 ?: '') . "</td>
                        <td>{$computed}</td>
                        <td>" . htmlspecialchars($g['remarks'] ?: '') . "</td>
                    </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p style='text-align:center;'>No records found for First Semester.</p>";
        }

        // 🔹 SECOND SEMESTER
        echo "<h4>Second Semester</h4>";
        if (!empty($second_sem)) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Quarter 3</th>
                            <th>Quarter 4</th>
                            <th>Computed Final Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead><tbody>";

            foreach ($second_sem as $g) {
                $q3 = floatval($g['quarter_3']);
                $q4 = floatval($g['quarter_4']);
                $vals = array_filter([$q3, $q4]);
                $computed = count($vals) ? number_format(array_sum($vals) / count($vals), 2) : '';

                echo "<tr>
                        <td>" . htmlspecialchars($g['student_name']) . "</td>
                        <td>" . htmlspecialchars($g['subject_name']) . "</td>
                        <td>" . ($q3 ?: '') . "</td>
                        <td>" . ($q4 ?: '') . "</td>
                        <td>{$computed}</td>
                        <td>" . htmlspecialchars($g['remarks'] ?: '') . "</td>
                    </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<p style='text-align:center;'>No records found for Second Semester.</p>";
        }
    } else {
        echo "<p style='text-align:center;'>No grade records found for this year.</p>";
    }
} else {
    // Export summary for all years
    echo "<h4>All Yearly Summary</h4>";

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

    if ($grades) {
        echo "<table>
                <thead>
                    <tr>
                        <th>School Year</th>
                        <th>Total Students</th>
                        <th>Total Subjects</th>
                        <th>Total Records</th>
                    </tr>
                </thead><tbody>";

        foreach ($grades as $r) {
            echo "<tr>
                    <td>{$r['year']}</td>
                    <td>{$r['total_students']}</td>
                    <td>{$r['total_subjects']}</td>
                    <td>{$r['total_records']}</td>
                </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p style='text-align:center;'>No data available.</p>";
    }
}

echo "<p style='text-align:center; margin-top:20px; font-size:12px;'>
        Generated by: <strong>" . htmlspecialchars($_SESSION['user_name'] ?? 'Administrator') . "</strong><br>
        Date Exported: " . date('F d, Y h:i A') . "<br>
        <em>Can-Avid National High School | Senior High School Department</em>
      </p>";

echo "</body></html>";
