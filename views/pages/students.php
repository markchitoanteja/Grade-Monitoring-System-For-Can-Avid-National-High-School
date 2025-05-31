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

<?php include_once "../views/pages/templates/header.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Students</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> All Students</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Student Number</th>
                                    <th>Full Name</th>
                                    <th>Course, Year & Section</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($students = $db->select_all("students", "id", "DESC")): ?>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td><?= $student["student_number"] ?></td>
                                            <td><?= $student["first_name"] . ' ' . (!empty($student["middle_name"]) ? substr($student["middle_name"], 0, 1) . '. ' : '') . $student["last_name"] ?></td>
                                            <td><?= $student["course"] . " " . $student["year"][0] . "-" . $student["section"] ?></td>
                                            <td class="text-center">
                                                <i class="bi bi-pencil-fill text-primary me-1 update_student" role="button" student_id="<?= $student["account_id"] ?>"></i>
                                                <i class="bi bi-trash-fill text-danger delete_student" role="button" student_id="<?= $student["account_id"] ?>"></i>
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

<?php include_once "../views/pages/components/new_student.php" ?>
<?php include_once "../views/pages/components/update_student.php" ?>

<?php include_once "../views/pages/templates/footer.php" ?>