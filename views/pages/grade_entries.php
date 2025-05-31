<?php
if (!isset($_SESSION["user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];

    header("location: /");

    exit();
} else {
    if ($_SESSION["user_type"] != "teacher") {
        http_response_code(403);

        header("location: 403");

        exit();
    }
}

$able_to_put_grades = $db->check_subject_weight($_SESSION["user_id"]);
?>

<?php include_once "../views/pages/templates/header.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Grade Entries</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Grade Entries</li>
                    </ol>
                </nav>
            </div>
            <?php if ($able_to_put_grades): ?>
                <div class="col-6">
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#new_student_grade_modal"><i class="bi bi-plus"></i> New Grade</button>
                </div>
            <?php endif ?>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <?php if (!$able_to_put_grades): ?>
                    <div class="py-5">
                        <h1 class="text-center text-muted">You need to complete 100% of the grade components for at least one subject.</h1>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> All Grade Entries</h5>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Student Number</th>
                                        <th>Student Name</th>
                                        <th>Course</th>
                                        <th>Year</th>
                                        <th>Semester</th>
                                        <th>Subject</th>
                                        <th>Grade Component</th>
                                        <th>Grade</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($student_grades = $db->select_many("student_grades", "teacher_id", $_SESSION["user_id"], "id", "DESC")): ?>
                                        <?php foreach ($student_grades as $student_grade): ?>
                                            <tr>
                                                <td><?= $db->select_one("students", "account_id", $student_grade["student_id"])["student_number"] ?></td>
                                                <td><?= $db->select_one("users", "id", $student_grade["student_id"])["name"] ?></td>
                                                <td><?= $student_grade["course"] ?></td>
                                                <td><?= $student_grade["year"] ?> Year</td>
                                                <td><?= $student_grade["semester"] ?> Semester</td>
                                                <td><?= $db->select_one("subjects", "id", $student_grade["subject_id"])["description"] ?></td>
                                                <td><?= $db->select_one("grade_components", "id", $student_grade["grade_component_id"])["component"] ?></td>
                                                <td><?= $student_grade["grade"] ?>%</td>
                                                <td class="text-center">
                                                    <i class="bi bi-pencil-fill text-primary me-1 update_student_grade" role="button" student_grade_id="<?= $student_grade["id"] ?>"></i>
                                                    <i class="bi bi-trash-fill text-danger delete_student_grade" role="button" student_grade_id="<?= $student_grade["id"] ?>"></i>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>
</main>

<?php include_once "../views/pages/components/new_student_grade.php" ?>
<?php include_once "../views/pages/components/update_student_grade.php" ?>

<?php include_once "../views/pages/templates/footer.php" ?>