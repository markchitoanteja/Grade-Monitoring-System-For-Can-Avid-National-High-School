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

$db = new Database();

$strands = $db->select_all("strands", "name", "ASC");
?>

<?php include_once "views/pages/templates/header.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Students</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Students</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#new_student_modal"><i class="bi bi-plus"></i> New Student</button>
            </div>
        </div>
    </div>

    <section class="section">
        <?php
        $studentCounts = [];
        $results = $db->run_custom_query("
            SELECT strand_id, COUNT(*) as total
            FROM students
            GROUP BY strand_id
        ");

        $totalStudents = 0;

        if ($results) {
            foreach ($results as $row) {
                $studentCounts[$row['strand_id']] = (int)$row['total'];
                $totalStudents += (int)$row['total'];
            }
        }
        ?>

        <?php if ($totalStudents > 0): ?>
            <!-- Strand Filter Cards -->
            <div id="strandCarousel" class="carousel slide" data-bs-interval="false">
                <div class="carousel-inner">
                    <!-- First item (All Students + first 3 strands) -->
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <!-- All Students Card -->
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card strand-card text-center active" data-strand="all">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <i class="bi bi-people fs-2 text-primary"></i>
                                        <h6 class="card-title mt-2 mb-0">All Students</h6>
                                    </div>
                                </div>
                            </div>

                            <?php if ($strands): ?>
                                <?php $count = 0; ?>
                                <?php foreach ($strands as $strand): ?>
                                    <?php if ($count > 0 && $count % 3 === 0): ?>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                        <?php endif; ?>

                        <?php
                                    $strandId = $strand['id'];
                                    $studentCount = $studentCounts[$strandId] ?? 0;
                                    $isDisabled = $studentCount === 0;
                        ?>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card strand-card text-center <?= $isDisabled ? 'disabled' : '' ?>"
                                data-strand="<?= $strandId ?>"
                                style="<?= $isDisabled ? 'pointer-events:none;opacity:0.5;' : '' ?>">
                                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-journal-bookmark fs-2 text-success mb-2"></i>
                                    <h6 class="strand-code fw-bold mb-1"><?= htmlspecialchars($strand["code"]) ?></h6>
                                    <p class="strand-name small text-muted mb-0 text-truncate" style="max-width:95%;">
                                        <?= htmlspecialchars($strand["name"]) ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <?php $count++; ?>
                    <?php endforeach ?>
                <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#strandCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#strandCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

        <?php endif; ?>

        <!-- Students Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> Students</h5>

                        <table class="table" id="studentsTable">
                            <thead>
                                <tr>
                                    <th>Learner Reference Number</th>
                                    <th>Full Name</th>
                                    <th>Strand</th>
                                    <th>Grade Level & Section</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($students = $db->select_all("students", "id", "DESC")): ?>
                                    <?php foreach ($students as $student): ?>
                                        <?php $strand = $db->select_one("strands", "id", $student["strand_id"]); ?>
                                        <tr data-strand="<?= $strand["id"] ?>">
                                            <td><?= $student["lrn"] ?></td>
                                            <td>
                                                <?= $student["first_name"] . ' ' .
                                                    (!empty($student["middle_name"]) ? substr($student["middle_name"], 0, 1) . '. ' : '') .
                                                    $student["last_name"] ?>
                                            </td>
                                            <td><?= $strand["code"] ?></td>
                                            <td><?= $student["grade_level"] . "-" . $student["section"] ?></td>
                                            <td class="text-center">
                                                <i class="bi bi-pencil-fill text-primary me-1 update_student_btn" role="button" data-account_id="<?= $student["account_id"] ?>"></i>
                                                <i class="bi bi-trash-fill text-danger delete_student_btn" role="button" data-account_id="<?= $student["account_id"] ?>"></i>
                                            </td>
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

<?php include_once "views/pages/components/new_student.php" ?>
<?php include_once "views/pages/components/update_student.php" ?>

<?php include_once "views/pages/templates/footer.php" ?>