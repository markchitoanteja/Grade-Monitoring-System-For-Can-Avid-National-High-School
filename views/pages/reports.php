<?php
// 🔒 Access control
if (!isset($_SESSION["user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];
    header("location: " . base_url());
    exit();
}

if ($_SESSION["user_type"] !== "admin") {
    http_response_code(403);
    header("location: 403");
    exit();
}

include_once "views/pages/templates/header.php";
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Reports</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-journal-bookmark me-1"></i>
                            Grade Reports by Strand, Subject & Year
                        </h5>

                        <?php
                        // 🧠 Fetch report data
                        $sql = "
                            SELECT 
                                YEAR(g.created_at) AS year,
                                st.id AS strand_id,
                                st.name AS strand_name,
                                sub.id AS subject_id,
                                sub.name AS subject_name,
                                s.last_name,
                                s.first_name,
                                s.middle_name,
                                g.quarter_1,
                                g.quarter_2,
                                g.final_grade,
                                g.remarks
                            FROM grades g
                            JOIN students s ON g.student_id = s.id
                            JOIN strands st ON s.strand_id = st.id
                            JOIN subjects sub ON g.subject_id = sub.id
                            ORDER BY year DESC, st.name, sub.name, s.last_name, s.first_name
                        ";

                        $rows = $db->run_custom_query($sql);
                        $reports = [];

                        // 🧱 Group by Year → Strand → Subject
                        foreach ($rows as $r) {
                            $year = $r['year'];
                            $strand = $r['strand_name'];
                            $subject = $r['subject_name'];

                            // ✅ Correct name format: "Anteja, Mark Chito R."
                            $lname = ucwords(strtolower($r['last_name']));
                            $fname = ucwords(strtolower($r['first_name']));
                            $mname = trim($r['middle_name']);
                            $mInitial = $mname ? strtoupper(substr($mname, 0, 1)) . '.' : '';
                            $studentName = "{$lname}, {$fname} {$mInitial}";

                            $reports[$year][$strand][$subject][] = [
                                'student_name' => $studentName,
                                'quarter_1' => $r['quarter_1'],
                                'quarter_2' => $r['quarter_2'],
                                'final_grade' => $r['final_grade'],
                                'remarks' => $r['remarks'],
                                'strand_id' => $r['strand_id'],
                                'subject_id' => $r['subject_id']
                            ];
                        }
                        ?>

                        <?php if (!empty($reports)): ?>
                            <?php foreach ($reports as $year => $strands): ?>
                                <div class="mb-5">
                                    <h2 class="fw-bold text-dark border-bottom pb-2 mb-4">
                                        School Year <?= htmlspecialchars($year) ?>
                                    </h2>

                                    <?php foreach ($strands as $strand => $subjects): ?>
                                        <div class="mb-4">
                                            <h3 class="fw-bold text-primary border-bottom pb-2">
                                                <?= htmlspecialchars($strand) ?>
                                            </h3>

                                            <?php foreach ($subjects as $subject => $grades): ?>
                                                <div class="card mb-3 shadow-sm">
                                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong><?= htmlspecialchars($subject) ?></strong>
                                                        </div>
                                                        <div class="d-flex gap-2">
                                                            <button
                                                                class="btn btn-sm btn-success export-btn"
                                                                data-strand-id="<?= htmlspecialchars($grades[0]['strand_id']) ?>"
                                                                data-subject-id="<?= htmlspecialchars($grades[0]['subject_id']) ?>"
                                                                data-year="<?= htmlspecialchars($year) ?>">
                                                                <i class="bi bi-file-earmark-excel"></i> Export
                                                            </button>
                                                            <button
                                                                class="btn btn-sm btn-secondary print-btn"
                                                                data-strand-id="<?= htmlspecialchars($grades[0]['strand_id']) ?>"
                                                                data-subject-id="<?= htmlspecialchars($grades[0]['subject_id']) ?>"
                                                                data-year="<?= htmlspecialchars($year) ?>">
                                                                <i class="bi bi-printer"></i> Print
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <h6 class="text-muted mt-3 mb-2">First Semester</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-sm align-middle">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th>Student Name</th>
                                                                        <th class="text-center">Quarter 1</th>
                                                                        <th class="text-center">Quarter 2</th>
                                                                        <th class="text-center">Final Grade</th>
                                                                        <th class="text-center">Remarks</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($grades as $g): ?>
                                                                        <tr>
                                                                            <td><?= htmlspecialchars($g['student_name']) ?></td>
                                                                            <td class="text-center"><?= htmlspecialchars($g['quarter_1']) ?></td>
                                                                            <td class="text-center"><?= htmlspecialchars($g['quarter_2']) ?></td>
                                                                            <td class="text-center"><?= htmlspecialchars($g['final_grade']) ?></td>
                                                                            <td class="text-center"><?= htmlspecialchars($g['remarks']) ?></td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center">No reports available yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "views/pages/templates/footer.php"; ?>

<script>
    document.querySelectorAll('.print-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const {
                strandId,
                subjectId,
                year
            } = btn.dataset;
            const url = `${base_url}print_report?year=${year}&strand_id=${strandId}&subject_id=${subjectId}`;
            window.open(url, '_blank');
        });
    });

    document.querySelectorAll('.export-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const {
                strandId,
                subjectId,
                year
            } = btn.dataset;
            const url = `${base_url}export_report?year=${year}&strand_id=${strandId}&subject_id=${subjectId}`;
            window.location.href = url;
        });
    });
</script>