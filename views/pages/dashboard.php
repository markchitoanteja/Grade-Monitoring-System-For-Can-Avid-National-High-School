<?php
if (!isset($_SESSION["user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];

    header("location: /");

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
            <div class="col-12">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Home</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title text-white">Total Students</h5>
                                <h2><?= count($db->select_all("students")) ?></h2>
                                <p>Currently enrolled in the system</p>
                            </div>
                            <div>
                                <i class="bi bi-people-fill" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title text-white">Total Courses</h5>
                                <h2><?= count($db->select_all("courses")) ?></h2>
                                <p>Active courses this semester</p>
                            </div>
                            <div>
                                <i class="bi bi-journal-bookmark-fill" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title text-white">Total Subjects</h5>
                                <h2><?= count($db->select_all("subjects")) ?></h2>
                                <p>Total number of subjects</p>
                            </div>
                            <div>
                                <i class="bi bi-book-fill" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-clock-history me-1"></i> Recent Activities</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Date and Time</th>
                                    <th>Modifier</th>
                                    <th>Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($logs = $db->select_all("logs", "id", "DESC")): ?>
                                    <?php foreach ($logs as $log): ?>
                                        <tr>
                                            <td><?= (new DateTime($log["created_at"]))->format('F j, Y h:i A') ?></td>
                                            <td><?= $db->select_one("users", "id", $log["user_id"])["name"] ?></td>
                                            <td><?= $log["activity"] ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "views/pages/templates/footer.php" ?>