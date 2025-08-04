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
            <div class="col-6">
                <h1>Courses</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Courses</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#new_course_modal"><i class="bi bi-plus"></i> New Course</button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> All Courses</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Description</th>
                                    <th>Years</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($courses = $db->select_all("courses", "id", "DESC")): ?>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td><?= $course["code"] ?></td>
                                            <td><?= $course["description"] ?></td>
                                            <td><?= $course["years"] ?> Year<?= intval($course["years"]) > 1 ? "s" : null ?></td>
                                            <td class="text-center">
                                                <i class="bi bi-pencil-fill text-primary me-1 update_course" role="button" course_id="<?= $course["id"] ?>"></i>
                                                <i class="bi bi-trash-fill text-danger delete_course" role="button" course_id="<?= $course["id"] ?>"></i>
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

<?php include_once "views/pages/components/new_course.php" ?>
<?php include_once "views/pages/components/update_course.php" ?>

<?php include_once "views/pages/templates/footer.php" ?>