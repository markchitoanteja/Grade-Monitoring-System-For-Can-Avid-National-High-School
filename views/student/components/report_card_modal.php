<?php
// Assuming student account id is stored in session for the logged in student
$account_id = intval($_SESSION['student_user_id'] ?? 0);
if (!$account_id) {
    echo "Student not found.";
    return;
}

// Fetch the student ID first
$sql_student = "SELECT id FROM students WHERE account_id = $account_id LIMIT 1";
$student_result = $db->run_custom_query($sql_student);
if (empty($student_result)) {
    echo "Student record not found.";
    return;
}
$student_id = $student_result[0]['id'];

// Fetch grades with subjects info for this student
$sql = "
SELECT 
    subj.name AS subject,
    subj.category AS category,
    g.quarter_1, g.quarter_2, g.quarter_3, g.quarter_4
FROM grades g
JOIN subjects subj ON g.subject_id = subj.id
WHERE g.student_id = $student_id
ORDER BY FIELD(subj.category, 'core', 'applied and specialized'), subj.name
";

$grades = $db->run_custom_query($sql);

$first_semester = ['core' => [], 'applied and specialized' => []];
$second_semester = ['core' => [], 'applied and specialized' => []];
$first_sem_grades = [];
$second_sem_grades = [];

$first_sem_has_missing = false;
$second_sem_has_missing = false;

foreach ($grades as $row) {
    $category = $row['category'];

    $q1 = floatval($row['quarter_1']);
    $q2 = floatval($row['quarter_2']);
    $q3 = floatval($row['quarter_3']);
    $q4 = floatval($row['quarter_4']);

    // Compute final grades only if both quarters > 0, else null
    $final_grade_first_sem = ($q1 > 0 && $q2 > 0) ? round(($q1 + $q2) / 2, 2) : null;
    $final_grade_second_sem = ($q3 > 0 && $q4 > 0) ? round(($q3 + $q4) / 2, 2) : null;

    // Mark if there's any missing or zero final grade in the semester
    if ($final_grade_first_sem === null) {
        $first_sem_has_missing = true;
    }
    if ($final_grade_second_sem === null) {
        $second_sem_has_missing = true;
    }

    $row['final_grade_first_sem'] = $final_grade_first_sem;
    $row['final_grade_second_sem'] = $final_grade_second_sem;

    $first_semester[$category][] = $row;
    $second_semester[$category][] = $row;

    if ($final_grade_first_sem !== null) {
        $first_sem_grades[] = $final_grade_first_sem;
    }
    if ($final_grade_second_sem !== null) {
        $second_sem_grades[] = $final_grade_second_sem;
    }
}

$first_sem_avg = (!$first_sem_has_missing && count($first_sem_grades) > 0)
    ? round(array_sum($first_sem_grades) / count($first_sem_grades), 2)
    : '-';

$second_sem_avg = (!$second_sem_has_missing && count($second_sem_grades) > 0)
    ? round(array_sum($second_sem_grades) / count($second_sem_grades), 2)
    : '-';

function displayGrade($grade)
{
    if ($grade === null || floatval($grade) == 0.00) {
        return '-';
    }
    return number_format(floatval($grade), 2);
}

// Helper to check if category has any subject with grades for the semester
function categoryHasGrades($subjects, $semester)
{
    foreach ($subjects as $subj) {
        if ($semester === 1 && $subj['final_grade_first_sem'] !== null) {
            return true;
        }
        if ($semester === 2 && $subj['final_grade_second_sem'] !== null) {
            return true;
        }
    }
    return false;
}
?>

<div class="modal fade" id="reportCardModal" tabindex="-1" aria-labelledby="reportCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="reportCardModalLabel" style="font-size:1rem;">
                    <strong>LEARNER'S PROGRESS REPORT CARD</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                <div class="table-responsive">
                    <!-- First Semester Table -->
                    <table class="table table-bordered mb-3 align-middle table-sm" style="font-size:0.85rem;">
                        <thead class="table-light">
                            <tr>
                                <th colspan="5" class="text-center" style="font-size:0.92rem;">First Semester</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="width:45%">Subjects</th>
                                <th class="text-center" style="width:13%">Q1</th>
                                <th class="text-center" style="width:13%">Q2</th>
                                <th class="text-center" style="width:18%">Final Grade</th>
                                <th style="width:11%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-secondary">
                                <td colspan="5"><strong>Core Subjects</strong></td>
                            </tr>
                            <?php if (categoryHasGrades($first_semester['core'], 1)): ?>
                                <?php foreach ($first_semester['core'] as $grade): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($grade['subject']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['quarter_1']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['quarter_2']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['final_grade_first_sem']) ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>

                            <tr class="table-secondary">
                                <td colspan="5"><strong>Applied and Specialized Subjects</strong></td>
                            </tr>
                            <?php if (categoryHasGrades($first_semester['applied and specialized'], 1)): ?>
                                <?php foreach ($first_semester['applied and specialized'] as $grade): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($grade['subject']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['quarter_1']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['quarter_2']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['final_grade_first_sem']) ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>

                            <tr class="table-light">
                                <td colspan="4" class="text-end"><strong>General Average for the Semester</strong></td>
                                <td class="text-center"><?= $first_sem_avg ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-responsive">
                    <!-- Second Semester Table -->
                    <table class="table table-bordered align-middle table-sm" style="font-size:0.85rem;">
                        <thead class="table-light">
                            <tr>
                                <th colspan="5" class="text-center" style="font-size:0.92rem;">Second Semester</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="width:45%">Subjects</th>
                                <th class="text-center" style="width:13%">Q3</th>
                                <th class="text-center" style="width:13%">Q4</th>
                                <th class="text-center" style="width:18%">Final Grade</th>
                                <th style="width:11%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-secondary">
                                <td colspan="5"><strong>Core Subjects</strong></td>
                            </tr>
                            <?php if (categoryHasGrades($second_semester['core'], 2)): ?>
                                <?php foreach ($second_semester['core'] as $grade): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($grade['subject']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['quarter_3']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['quarter_4']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['final_grade_second_sem']) ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>

                            <tr class="table-secondary">
                                <td colspan="5"><strong>Applied and Specialized Subjects</strong></td>
                            </tr>
                            <?php if (categoryHasGrades($second_semester['applied and specialized'], 2)): ?>
                                <?php foreach ($second_semester['applied and specialized'] as $grade): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($grade['subject']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['quarter_3']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['quarter_4']) ?></td>
                                        <td class="text-center"><?= displayGrade($grade['final_grade_second_sem']) ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>

                            <tr class="table-light">
                                <td colspan="4" class="text-end"><strong>General Average for the Semester</strong></td>
                                <td class="text-center"><?= $second_sem_avg ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>