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
?>

<?php include_once "views/pages/templates/header.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Grade Components</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Grade Components</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6"> 
                <button class="btn btn-primary float-end" id="new_grade_component" teacher_id="<?= $_SESSION["user_id"] ?>"><i class="bi bi-plus"></i> New Component</button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> All Components</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Component</th>
                                    <th>Subject</th>
                                    <th>Weight</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($grade_components = $db->select_many("grade_components", "teacher_id", $_SESSION["user_id"], "component", "ASC")): ?>
                                    <?php foreach ($grade_components as $grade_component): ?>
                                        <tr>
                                            <td><?= $grade_component["component"] ?></td>
                                            <td><?= $db->select_one("subjects", "id", $grade_component["subject_id"])["description"] ?></td>
                                            <td><?= $grade_component["weight"] ?>%</td>
                                            <td class="text-center">
                                                <i class="bi bi-pencil-fill text-primary me-1 update_grade_component" role="button" grade_component_id="<?= $grade_component["id"] ?>"></i>
                                                <i class="bi bi-trash-fill text-danger delete_grade_component" role="button" grade_component_id="<?= $grade_component["id"] ?>"></i>
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

<?php include_once "views/pages/components/new_grade_component.php" ?>
<?php include_once "views/pages/components/update_grade_component.php" ?>

<?php include_once "views/pages/templates/footer.php" ?>