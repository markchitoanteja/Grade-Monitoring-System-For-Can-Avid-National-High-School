<?php
if (!isset($_SESSION["student_user_id"])) {
    $_SESSION["notification"] = [
        "type" => "alert-danger bg-danger",
        "message" => "You must login first!",
    ];

    header("location: " . base_url("student/login"));

    exit();
}
?>

<?php include_once "views/student/templates/header.php"; ?>

<main id="main" class="main bg-light py-4">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>My Grades</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('student/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Grades</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</main>

<?php include_once "views/student/templates/footer.php"; ?>