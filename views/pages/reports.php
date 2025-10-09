<?php
if (!isset($_SESSION["user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];

    header("location: " . base_url());
    exit();
} else {
    if ($_SESSION["user_type"] != "admin") {
        http_response_code(403);
        header("location: 403");
        exit();
    }
}
?>

<?php include_once "views/pages/templates/header.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Reports</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-success" id="export_reports_btn">
                        <i class="bi bi-file-earmark-excel"></i> Export All
                    </button>
                    <button class="btn btn-secondary" id="print_reports_btn">
                        <i class="bi bi-printer"></i> Print All
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-journal-bookmark me-1"></i> Yearly Grade Reports
                        </h5>

                        <?php
                        // ✅ Fetch yearly summary from grades table
                        $reports = $db->run_custom_query("
                            SELECT 
                                YEAR(created_at) AS year,
                                COUNT(*) AS total_records,
                                COUNT(DISTINCT student_id) AS total_students,
                                COUNT(DISTINCT subject_id) AS total_subjects
                            FROM grades
                            GROUP BY YEAR(created_at)
                            ORDER BY YEAR(created_at) DESC
                        ");
                        ?>

                        <table class="table datatable" id="reports_table">
                            <thead>
                                <tr>
                                    <th class="text-center">School Year</th>
                                    <th class="text-center">Total Students</th>
                                    <th class="text-center">Total Subjects</th>
                                    <th class="text-center">Total Records</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($reports): ?>
                                    <?php foreach ($reports as $report): ?>
                                        <tr>
                                            <td class="text-center"><?= htmlspecialchars($report["year"]) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($report["total_students"]) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($report["total_subjects"]) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($report["total_records"]) ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success export-year-btn" data-year="<?= $report['year'] ?>" title="Export">
                                                    <i class="bi bi-file-earmark-excel"></i>
                                                </button>
                                                <button class="btn btn-sm btn-secondary print-year-btn" data-year="<?= $report['year'] ?>" title="Print">
                                                    <i class="bi bi-printer"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No reports available yet.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "views/pages/templates/footer.php" ?>