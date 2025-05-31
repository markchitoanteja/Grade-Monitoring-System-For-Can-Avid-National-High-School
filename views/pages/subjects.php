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
                <h1>Subjects</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Subjects</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#new_subject_modal"><i class="bi bi-plus"></i> New Subject</button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> All Subjects</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Subject Code</th>
                                    <th>Descriptive Title</th>
                                    <th>Course</th>
                                    <th class="text-center">Total Units</th>
                                    <th class="text-center">Lec Units</th>
                                    <th class="text-center">Lab Units</th>
                                    <th class="text-center">Hours/Week</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($subjects = $db->select_all("subjects", "id", "DESC")): ?>
                                    <?php foreach ($subjects as $subjects): ?>
                                        <tr>
                                            <td><?= $subjects["code"] ?></td>
                                            <td><?= $subjects["description"] ?></td>
                                            <td><?= $subjects["course"] ?></td>
                                            <td class="text-center"><?= intval($subjects["lecture_units"]) + intval($subjects["laboratory_units"]) ?> Unit<?= intval($subjects["lecture_units"]) + intval($subjects["laboratory_units"]) > 1 ? "s" : null ?></td>
                                            <td class="text-center"><?= $subjects["lecture_units"] ?> Unit<?= intval($subjects["lecture_units"]) > 1 ? "s" : null ?></td>
                                            <td class="text-center"><?= $subjects["laboratory_units"] ?> Unit<?= intval($subjects["laboratory_units"]) > 1 ? "s" : null ?></td>
                                            <td class="text-center"><?= $subjects["hours_per_week"] ?> Hour<?= intval($subjects["hours_per_week"]) > 1 ? "s" : null ?></td>
                                            <td class="text-center">
                                                <i class="bi bi-pencil-fill text-primary me-1 update_subject" role="button" subject_id="<?= $subjects["id"] ?>"></i>
                                                <i class="bi bi-trash-fill text-danger delete_subject" role="button" subject_id="<?= $subjects["id"] ?>"></i>
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

<?php include_once "../views/pages/components/new_subject.php" ?>
<?php include_once "../views/pages/components/update_subject.php" ?>

<?php include_once "../views/pages/templates/footer.php" ?>