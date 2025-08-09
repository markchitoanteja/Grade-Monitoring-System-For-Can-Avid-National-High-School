<?php
if (!isset($_SESSION["student_user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];

    header("location: " . base_url("student/login"));
    exit();
}

include_once "views/student/templates/header.php";

// Get student ID for queries
$account_id = intval($_SESSION['student_user_id']);

$sql_student = "SELECT id FROM students WHERE account_id = $account_id LIMIT 1";
$student_data = $db->run_custom_query($sql_student);
if (empty($student_data)) {
    echo "<div class='alert alert-danger'>Student not found.</div>";
    include_once "views/student/templates/footer.php";
    exit();
}
$student_id = $student_data[0]['id'];

// Fetch all subjects for the student's strand and grade level
$sql_subjects = "
SELECT s.id, s.name, s.grade_level, s.category
FROM students st
INNER JOIN strands str ON st.strand_id = str.id
INNER JOIN subjects s ON s.strand_id = st.strand_id AND s.grade_level = st.grade_level
WHERE st.id = $student_id
ORDER BY s.category, s.name
";

$subjects = $db->run_custom_query($sql_subjects);

// Fetch all grades for the student, all quarters
$sql_grades = "
SELECT g.subject_id, g.quarter_1, g.quarter_2, g.quarter_3, g.quarter_4
FROM grades g
WHERE g.student_id = $student_id
";

$grades_data = $db->run_custom_query($sql_grades);

// Map grades by subject_id for quick lookup
$grades_by_subject = [];
foreach ($grades_data as $g) {
    $grades_by_subject[$g['subject_id']] = [
        'quarter_1' => floatval($g['quarter_1']),
        'quarter_2' => floatval($g['quarter_2']),
        'quarter_3' => floatval($g['quarter_3']),
        'quarter_4' => floatval($g['quarter_4']),
    ];
}

// Helper function to compute final sem grade or null if no grades
function computeFinalGrade($qA, $qB)
{
    if ($qA > 0 && $qB > 0) {
        return round(($qA + $qB) / 2, 2);
    }
    // If only one quarter has grade, consider just that grade
    if ($qA > 0) return round($qA, 2);
    if ($qB > 0) return round($qB, 2);
    return null; // no grades yet
}

// Prepare arrays for metrics calculation
$subjects_enrolled = count($subjects);
$subjects_with_grades_first_sem = 0;
$subjects_with_grades_second_sem = 0;

$grades_first_sem = [];
$grades_second_sem = [];

// We'll also prepare an array to display recent grades per semester
$recent_grades = [];

foreach ($subjects as $subject) {
    $sid = $subject['id'];
    $q1 = $grades_by_subject[$sid]['quarter_1'] ?? 0;
    $q2 = $grades_by_subject[$sid]['quarter_2'] ?? 0;
    $q3 = $grades_by_subject[$sid]['quarter_3'] ?? 0;
    $q4 = $grades_by_subject[$sid]['quarter_4'] ?? 0;

    $final_first_sem = computeFinalGrade($q1, $q2);
    $final_second_sem = computeFinalGrade($q3, $q4);

    if ($final_first_sem !== null) {
        $subjects_with_grades_first_sem++;
        $grades_first_sem[] = $final_first_sem;
    }

    if ($final_second_sem !== null) {
        $subjects_with_grades_second_sem++;
        $grades_second_sem[] = $final_second_sem;
    }

    // We'll prepare recent grades array with both semesters info for display in the table
    $recent_grades[] = [
        'subject' => $subject['name'],
        'grade_level' => $subject['grade_level'],
        'final_grade_first_sem' => $final_first_sem,
        'final_grade_second_sem' => $final_second_sem,
        'remarks_first_sem' => ($final_first_sem === null) ? 'Pending' : ($final_first_sem >= 75 ? 'Passed' : 'Failed'),
        'remarks_second_sem' => ($final_second_sem === null) ? 'Pending' : ($final_second_sem >= 75 ? 'Passed' : 'Failed'),
    ];
}

// Calculate averages for each semester
$average_first_sem = count($grades_first_sem) ? round(array_sum($grades_first_sem) / count($grades_first_sem), 2) : null;
$average_second_sem = count($grades_second_sem) ? round(array_sum($grades_second_sem) / count($grades_second_sem), 2) : null;

// For overall metrics - you can choose to show either combined or just first semester metrics or split cards
// Here, let's display total subjects, total subjects with grades (first sem + second sem combined unique),
// and show average per semester on separate cards

// Unique subjects with grades in either semester:
$total_subjects_with_grades = 0;
foreach ($recent_grades as $rg) {
    if ($rg['final_grade_first_sem'] !== null || $rg['final_grade_second_sem'] !== null) {
        $total_subjects_with_grades++;
    }
}

// Highest and lowest grade across all final grades (both semesters)
$all_final_grades = array_merge($grades_first_sem, $grades_second_sem);
$highest_grade = count($all_final_grades) ? max($all_final_grades) : null;
$lowest_grade = count($all_final_grades) ? min($all_final_grades) : null;

// Helper function for display grade or dash
function displayGradeOrDash($grade)
{
    return ($grade === null) ? '-' : $grade . '%';
}
?>

<style>
    .metric-card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background: white;
        text-align: center;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .metric-icon {
        font-size: 3rem;
        margin-bottom: 10px;
        color: var(--bs-primary);
    }
</style>

<main id="main" class="main bg-light py-4">
    <div class="pagetitle">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="fs-4 mb-1">My Grades</h1>
                <nav>
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item"><a href="<?= base_url('student/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Grades</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-4">
                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#reportCardModal">
                    <i class="bi bi-file-earmark-text me-1"></i>
                    My Report Card
                </button>
            </div>
        </div>
    </div>

    <section class="section">
        <!-- Metrics Section -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="metric-card">
                    <i class="bi bi-journal-bookmark metric-icon text-primary"></i>
                    <h4 class="mb-0"><?= $subjects_enrolled ?></h4>
                    <small class="text-muted">Subjects Enrolled</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <i class="bi bi-check2-circle metric-icon text-success"></i>
                    <h4 class="mb-0"><?= $total_subjects_with_grades ?></h4>
                    <small class="text-muted">Subjects with Grades</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <i class="bi bi-calculator metric-icon text-info"></i>
                    <h4 class="mb-0"><?= displayGradeOrDash($average_first_sem) ?></h4>
                    <small class="text-muted">Avg Grade - 1st Sem</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <i class="bi bi-calculator metric-icon text-info"></i>
                    <h4 class="mb-0"><?= displayGradeOrDash($average_second_sem) ?></h4>
                    <small class="text-muted">Avg Grade - 2nd Sem</small>
                </div>
            </div>
        </div>

        <!-- Recent Grades Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-text me-1"></i> Recent Grades</h5>
                        <div class="table-responsive">
                            <table class="table datatable align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Subject</th>
                                        <th>Grade Level</th>
                                        <th>Semester</th>
                                        <th>Final Grade</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recent_grades)): ?>
                                        <?php
                                        // Flatten array to show each subject per semester (if they have grades)
                                        foreach ($recent_grades as $rg):
                                            // First semester row if has grade
                                            if ($rg['final_grade_first_sem'] !== null):
                                        ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($rg['subject']) ?></td>
                                                    <td>Grade <?= htmlspecialchars($rg['grade_level']) ?></td>
                                                    <td>First Semester</td>
                                                    <td><?= htmlspecialchars($rg['final_grade_first_sem']) ?>%</td>
                                                    <td>
                                                        <?php if ($rg['remarks_first_sem'] === 'Pending'): ?>
                                                            <span class="badge bg-secondary">Pending</span>
                                                        <?php elseif ($rg['remarks_first_sem'] === 'Passed'): ?>
                                                            <span class="badge bg-success">Passed</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Failed</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            endif;

                                            // Second semester row if has grade
                                            if ($rg['final_grade_second_sem'] !== null):
                                            ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($rg['subject']) ?></td>
                                                    <td>Grade <?= htmlspecialchars($rg['grade_level']) ?></td>
                                                    <td>Second Semester</td>
                                                    <td><?= htmlspecialchars($rg['final_grade_second_sem']) ?>%</td>
                                                    <td>
                                                        <?php if ($rg['remarks_second_sem'] === 'Pending'): ?>
                                                            <span class="badge bg-secondary">Pending</span>
                                                        <?php elseif ($rg['remarks_second_sem'] === 'Passed'): ?>
                                                            <span class="badge bg-success">Passed</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Failed</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No grades available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "views/student/components/report_card_modal.php"; ?>

<?php include_once "views/student/templates/footer.php"; ?>