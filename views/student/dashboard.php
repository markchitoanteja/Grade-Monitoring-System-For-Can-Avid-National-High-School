<?php
if (!isset($_SESSION["student_user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];

    header("location: " . base_url("student/login"));

    exit();
}
?>

<?php include_once "views/student/templates/header.php"; ?>

<?php
$sql = "
SELECT
    COUNT(DISTINCT s.id) AS total_subjects_enrolled,
    COUNT(DISTINCT CASE WHEN g.final_grade IS NOT NULL AND g.final_grade > 0 THEN g.subject_id END) AS total_subjects_with_grades,
    ROUND(AVG(CASE WHEN g.final_grade IS NOT NULL AND g.final_grade > 0 THEN g.final_grade END), 2) AS average_grade,
    MAX(CASE WHEN g.final_grade IS NOT NULL AND g.final_grade > 0 THEN g.final_grade END) AS highest_grade,
    MIN(CASE WHEN g.final_grade IS NOT NULL AND g.final_grade > 0 THEN g.final_grade END) AS lowest_grade
FROM students st
INNER JOIN strands str ON st.strand_id = str.id
INNER JOIN subjects s 
    ON s.strand_id = st.strand_id 
    AND s.grade_level = st.grade_level
LEFT JOIN grades g 
    ON g.student_id = st.id 
    AND g.subject_id = s.id
WHERE st.account_id = " . intval($_SESSION['student_user_id']);

$metrics = $db->run_custom_query($sql)[0];

$sql = "
SELECT 
    subj.name AS subject,
    subj.grade_level,
    g.final_grade,
    g.remarks
FROM grades g
INNER JOIN subjects subj ON g.subject_id = subj.id
INNER JOIN students st ON g.student_id = st.id
WHERE st.account_id = " . intval($_SESSION['student_user_id']) . "
ORDER BY g.updated_at DESC
LIMIT 5
";

$recent_grades = $db->run_custom_query($sql);
?>

<style>
    .metric-card {
        border-radius: 12px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .icon-box {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<main id="main" class="main bg-light py-4">
    <!-- Welcome Banner -->
    <div class="d-flex align-items-center justify-content-between p-3 mb-4 rounded shadow-sm" style="background-color: #0d6efd; color: #fff;">
        <div>
            <h4 class="fw-bold mb-1">Welcome back, <?= $user_data['name'] ?>!</h4>
            <p class="mb-0 small">
                <i class="bi bi-mortarboard-fill"></i>
                <strong>Strand:</strong> <?= $user_data['strand_code'] ?> - <?= $user_data['strand_name'] ?><br>
                <i class="bi bi-card-text"></i>
                <strong>LRN:</strong> <?= $user_data['lrn'] ?>
            </p>
        </div>
        <i class="bi bi-person-circle fs-1 opacity-75"></i>
    </div>

    <!-- Metrics Section -->
    <div class="row g-3">
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-journal-bookmark fs-1 text-primary"></i>
                    <h4 class="mb-0"><?= $metrics['total_subjects_enrolled'] ?></h4>
                    <small class="text-muted">Subjects Enrolled</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-check2-circle fs-1 text-success"></i>
                    <h4 class="mb-0"><?= $metrics['total_subjects_with_grades'] ?></h4>
                    <small class="text-muted">Subjects with Grades</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-graph-up fs-1 text-info"></i>
                    <h4 class="mb-0"><?= $metrics['average_grade'] ?: '-' ?></h4>
                    <small class="text-muted">Average Grade</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-arrow-up-short fs-1 text-warning"></i>
                    <h4 class="mb-0"><?= $metrics['highest_grade'] ?: '-' ?></h4>
                    <small class="text-muted">Highest Grade</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <i class="bi bi-arrow-down-short fs-1 text-danger"></i>
                    <h4 class="mb-0"><?= $metrics['lowest_grade'] ?: '-' ?></h4>
                    <small class="text-muted">Lowest Grade</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Grades -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-journal-text me-1"></i> Recent Grades</h5>

                    <div class="table-responsive">
                        <table class="table datatable align-middle table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Grade Level</th>
                                    <th>Final Grade</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recent_grades)): ?>
                                    <?php foreach ($recent_grades as $grade): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($grade['subject']) ?></td>
                                            <td>Grade <?= htmlspecialchars($grade['grade_level']) ?></td>
                                            <td>
                                                <?php if (empty($grade['final_grade']) || $grade['final_grade'] == 0.00): ?>
                                                    <span class="text-muted">Not Yet Available</span>
                                                <?php else: ?>
                                                    <?= htmlspecialchars($grade['final_grade']) ?>%
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (empty($grade['final_grade']) || $grade['final_grade'] == 0.00): ?>
                                                    <span class="badge bg-secondary">Pending</span>
                                                <?php elseif ($grade['final_grade'] >= 75): ?>
                                                    <span class="badge bg-success">Passed</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Failed</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No grades available</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once "views/student/templates/footer.php"; ?>