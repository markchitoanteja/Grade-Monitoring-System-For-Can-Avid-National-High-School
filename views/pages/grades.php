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
                <h1>Grades</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Grades</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-success" id="ocr_upload_btn">
                        <i class="bi bi-upload"></i> Upload Image
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new_grade_modal">
                        <i class="bi bi-plus"></i> New Grade
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
                            <i class="bi bi-journal-bookmark me-1"></i> All Grades
                        </h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Subject</th>
                                    <th>Final Grade</th>
                                    <th>Remarks</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $grades = $db->run_custom_query("SELECT grades.id, CONCAT(students.first_name, ' ', students.last_name) AS student_name, subjects.name AS subject_name, grades.final_grade, grades.remarks FROM grades JOIN students ON grades.student_id = students.id JOIN subjects ON grades.subject_id = subjects.id ORDER BY grades.id DESC") ?>

                                <?php if ($grades): ?>
                                    <?php foreach ($grades as $grade): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($grade["student_name"]) ?></td>
                                            <td><?= htmlspecialchars($grade["subject_name"]) ?></td>
                                            <td><?= $grade["final_grade"] == "0.00" ? "Not Yet Available" : htmlspecialchars($grade["final_grade"]) ?></td>
                                            <td><?= $grade["remarks"] == "" ? "Not Yet Available" : htmlspecialchars($grade["remarks"]) ?></td>
                                            <td class="text-center">
                                                <i class="bi bi-pencil-fill text-primary me-1 update_grade_btn" role="button" data-id="<?= $grade['id'] ?>"></i>
                                                <i class="bi bi-trash-fill text-danger delete_grade_btn" role="button" data-id="<?= $grade['id'] ?>"></i>
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

<?php include_once "views/pages/components/new_grade.php" ?>
<?php include_once "views/pages/components/update_grade.php" ?>
<?php include_once "views/pages/components/ocr_upload.php" ?>

<?php include_once "views/pages/templates/footer.php" ?>