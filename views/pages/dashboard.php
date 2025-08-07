<?php
if (!isset($_SESSION["user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];
    header("location: " . base_url());
    exit();
}

include_once "views/pages/templates/header.php";

$teacher_id = $_SESSION["user_id"];

// Dashboard metrics
$total_students = count($db->select_all("students"));
$total_grades = count($db->select_all("grades"));
$grades_data = $db->select_all("grades");
$average_grade = $grades_data
    ? number_format(array_sum(array_column($grades_data, "final_grade")) / $total_grades, 2)
    : "N/A";

$logs = $db->run_custom_query("
    SELECT l.*, u.name AS username
    FROM logs l
    JOIN users u ON l.user_id = u.id
    ORDER BY l.created_at DESC
");
?>

<style>
    .card h2 {
        font-size: 2.2rem;
    }

    .card h6 {
        font-size: 0.95rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s ease-in-out;
    }
</style>

<main id="main" class="main bg-light py-4">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Dashboard Summary Cards -->
    <section class="section ">
        <div class="row g-4">
            <!-- Total Students -->
            <div class="col-lg-4">
                <div class="card border rounded-3 shadow-sm h-100 bg-white">
                    <div class="card-body text-center p-4">
                        <div class="mb-2">
                            <i class="bi bi-people-fill fs-2 text-primary"></i>
                        </div>
                        <h6 class="fw-semibold mb-1 text-secondary">Total Students</h6>
                        <h2 class="fw-bold text-dark"><?= $total_students ?></h2>
                        <p class="text-muted small mb-0">Enrolled SHS students</p>
                    </div>
                </div>
            </div>

            <!-- Grades Recorded -->
            <div class="col-lg-4">
                <div class="card border rounded-3 shadow-sm h-100 bg-white">
                    <div class="card-body text-center p-4">
                        <div class="mb-2">
                            <i class="bi bi-journal-text fs-2 text-success"></i>
                        </div>
                        <h6 class="fw-semibold mb-1 text-secondary">Grades Recorded</h6>
                        <h2 class="fw-bold text-dark"><?= $total_grades ?></h2>
                        <p class="text-muted small mb-0">Submitted grade entries</p>
                    </div>
                </div>
            </div>

            <!-- Average Grade -->
            <div class="col-lg-4">
                <div class="card border rounded-3 shadow-sm h-100 bg-white">
                    <div class="card-body text-center p-4">
                        <div class="mb-2">
                            <i class="bi bi-bar-chart-line-fill fs-2 text-info"></i>
                        </div>
                        <h6 class="fw-semibold mb-1 text-secondary">Average Grade</h6>
                        <h2 class="fw-bold text-dark"><?= $average_grade ?></h2>
                        <p class="text-muted small mb-0">Across all subjects</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logs Section -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-clock-history me-1"></i> Recent Activity Logs</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td>
                                            <?= (new DateTime($log["created_at"]))->format("M j, Y g:i A") ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($log["username"]) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($log["activity"]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "views/pages/templates/footer.php"; ?>