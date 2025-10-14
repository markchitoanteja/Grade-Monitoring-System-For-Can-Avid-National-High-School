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

// Get all strands
$strands = $db->select_all("strands", "name", "ASC");

// Get subject counts per strand
$subjectCounts = [];
$results = $db->run_custom_query("
    SELECT strand_id, COUNT(*) as total
    FROM subjects
    GROUP BY strand_id
");

$totalSubjects = 0;
if ($results) {
    foreach ($results as $row) {
        $subjectCounts[$row['strand_id']] = (int)$row['total'];
        $totalSubjects += (int)$row['total'];
    }
}
?>

<?php include_once "views/pages/templates/header.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Subjects</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Subjects</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#new_subject_modal">
                    <i class="bi bi-plus"></i> New Subject
                </button>
            </div>
        </div>
    </div>

    <section class="section">

        <?php if ($totalSubjects > 0): ?>
            <!-- Strand Filter Carousel -->
            <div id="strandCarousel" class="carousel slide mb-3" data-bs-interval="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <!-- All Subjects Card -->
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card strand-card text-center active" data-strand="all">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <i class="bi bi-people fs-2 text-primary"></i>
                                        <h6 class="card-title mt-2 mb-0">All Subjects</h6>
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
                                    $subjectCount = $subjectCounts[$strandId] ?? 0;
                                    $isDisabled = $subjectCount === 0;
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
                    <?php endforeach; ?>
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

        <!-- Subjects Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-journal-bookmark me-1"></i> All Subjects
                        </h5>

                        <table class="table" id="subjectsTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Grade Level</th>
                                    <th>Strand</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $subjects = $db->select_all("subjects", "id", "DESC") ?>
                                <?php if ($subjects): ?>
                                    <?php foreach ($subjects as $subject): ?>
                                        <?php $strand = $db->select_one("strands", "id", $subject["strand_id"]); ?>
                                        <tr>
                                            <td><?= htmlspecialchars($subject["name"]) ?></td>
                                            <td><?= $subject["category"] == "applied and specialized" ? "Applied and Specialized" : "Core" ?></td>
                                            <td>Grade <?= htmlspecialchars($subject["grade_level"]) ?></td>
                                            <td><?= htmlspecialchars($strand["code"]) ?></td>
                                            <td class="text-center">
                                                <i class="bi bi-pencil-fill text-primary me-1 update_subject_btn" role="button" data-id="<?= $subject["id"] ?>"></i>
                                                <i class="bi bi-trash-fill text-danger delete_subject_btn" role="button" data-id="<?= $subject["id"] ?>"></i>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </section>
</main>

<?php include_once "views/pages/components/new_subject.php" ?>
<?php include_once "views/pages/components/update_subject.php" ?>
<?php include_once "views/pages/templates/footer.php" ?>