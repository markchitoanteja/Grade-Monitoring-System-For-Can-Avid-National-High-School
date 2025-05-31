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
                <h1>Teachers</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Teachers</li>
                    </ol>
                </nav>
            </div>
            <div class="col-6">
                <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#new_teacher_modal"><i class="bi bi-plus"></i> New Teacher</button>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> All Teachers</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Employee Number</th>
                                    <th>Name</th>
                                    <th>Birthday</th>
                                    <th>Mobile Number</th>
                                    <th>Email</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($teachers = $db->select_all("teachers", "id", "DESC")): ?>
                                    <?php foreach ($teachers as $teacher): ?>
                                        <tr>
                                            <td><?= $teacher["employee_number"] ?></td>
                                            <td> <?= $teacher["first_name"] . ' ' . (!empty($teacher["middle_name"]) ? substr($teacher["middle_name"], 0, 1) . '. ' : '') . $teacher["last_name"] ?></td>
                                            <td><?= date("F j, Y", strtotime($teacher["birthday"])) ?></td>
                                            <td><?= $teacher["mobile_number"] ?></td>
                                            <td><?= $teacher["email"] ?></td>
                                            <td class="text-center">
                                                <i class="bi bi-pencil-fill text-primary me-1 update_teacher" role="button" teacher_id="<?= $teacher["account_id"] ?>"></i>
                                                <i class="bi bi-trash-fill text-danger delete_teacher" role="button" teacher_id="<?= $teacher["account_id"] ?>"></i>
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

<?php include_once "../views/pages/components/new_teacher.php" ?>
<?php include_once "../views/pages/components/update_teacher.php" ?>

<?php include_once "../views/pages/templates/footer.php" ?>