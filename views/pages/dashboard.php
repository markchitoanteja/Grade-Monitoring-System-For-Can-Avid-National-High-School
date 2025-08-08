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

// Dashboard metrics
$total_students = count($db->select_all("students"));
$total_grades = count($db->select_all("grades"));
$total_strands = count($db->select_all("strands"));
$total_subjects = count($db->select_all("subjects"));

$logs = $db->run_custom_query("SELECT l.*, u.name AS username FROM logs l JOIN users u ON l.user_id = u.id ORDER BY l.created_at DESC");
?>

<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: linear-gradient(145deg, #ffffff, #f9f9f9);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
    }

    .icon-info {
        background: rgba(23, 162, 184, 0.15);
        color: #17a2b8;
    }

    .icon-primary {
        background: rgba(0, 123, 255, 0.15);
        color: #007bff;
    }

    .icon-warning {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }

    .icon-success {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .stat-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #6c757d;
        margin-top: 10px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: bold;
        color: #343a40;
        margin-bottom: 5px;
    }

    .stat-sub {
        font-size: 0.8rem;
        color: #adb5bd;
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
        <!-- Cards -->
        <div class="row g-4">
            <!-- Number of Strands -->
            <div class="col-lg-3 col-md-6">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle icon-info">
                            <i class="bi bi-diagram-3-fill fs-3"></i>
                        </div>
                        <div class="stat-title">Number of Strands</div>
                        <div class="stat-value"><?= $total_strands ?></div>
                        <div class="stat-sub">Available SHS strands</div>
                    </div>
                </div>
            </div>

            <!-- Total Students -->
            <div class="col-lg-3 col-md-6">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle icon-primary">
                            <i class="bi bi-people-fill fs-3"></i>
                        </div>
                        <div class="stat-title">Total Students</div>
                        <div class="stat-value"><?= $total_students ?></div>
                        <div class="stat-sub">Enrolled SHS students</div>
                    </div>
                </div>
            </div>

            <!-- Total Subjects -->
            <div class="col-lg-3 col-md-6">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle icon-warning">
                            <i class="bi bi-book-fill fs-3"></i>
                        </div>
                        <div class="stat-title">Total Subjects</div>
                        <div class="stat-value"><?= $total_subjects ?></div>
                        <div class="stat-sub">Available SHS subjects</div>
                    </div>
                </div>
            </div>

            <!-- Grades Recorded -->
            <div class="col-lg-3 col-md-6">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-circle icon-success">
                            <i class="bi bi-journal-text fs-3"></i>
                        </div>
                        <div class="stat-title">Grades Recorded</div>
                        <div class="stat-value"><?= $total_grades ?></div>
                        <div class="stat-sub">Submitted grade entries</div>
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