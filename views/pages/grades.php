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
                        <i class="bi bi-camera me-1"></i> OCR Upload
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
                                    <th>Average Grade</th>
                                    <th>Semester</th>
                                    <th>Final Grade</th>
                                    <th>Remarks</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $grades = $db->run_custom_query("
                                    SELECT 
                                        grades.id, 
                                        CONCAT(students.first_name, ' ', students.last_name) AS student_name, 
                                        subjects.name AS subject_name, 
                                        grades.quarter_1, grades.quarter_2, grades.quarter_3, grades.quarter_4,
                                        grades.final_grade, 
                                        grades.remarks 
                                    FROM grades 
                                    JOIN students ON grades.student_id = students.id 
                                    JOIN subjects ON grades.subject_id = subjects.id 
                                    ORDER BY grades.id DESC
                                ");
                                ?>

                                <?php if ($grades): ?>
                                    <?php foreach ($grades as $grade): ?>
                                        <?php
                                        // Determine semester: if Q1 or Q2 is not empty => semester 1; else if Q3 or Q4 not empty => semester 2
                                        $q1 = floatval($grade['quarter_1']);
                                        $q2 = floatval($grade['quarter_2']);
                                        $q3 = floatval($grade['quarter_3']);
                                        $q4 = floatval($grade['quarter_4']);

                                        $semester = "";
                                        $average = null;

                                        // Calculate semester and average
                                        if (($q1 > 0 || $q2 > 0) && !($q3 > 0 || $q4 > 0)) {
                                            $semester = "1st Semester";
                                            $count = 0;
                                            $sum = 0;
                                            if ($q1 > 0) {
                                                $sum += $q1;
                                                $count++;
                                            }
                                            if ($q2 > 0) {
                                                $sum += $q2;
                                                $count++;
                                            }
                                            $average = $count > 0 ? $sum / $count : null;
                                        } elseif (($q3 > 0 || $q4 > 0) && !($q1 > 0 || $q2 > 0)) {
                                            $semester = "2nd Semester";
                                            $count = 0;
                                            $sum = 0;
                                            if ($q3 > 0) {
                                                $sum += $q3;
                                                $count++;
                                            }
                                            if ($q4 > 0) {
                                                $sum += $q4;
                                                $count++;
                                            }
                                            $average = $count > 0 ? $sum / $count : null;
                                        } else {
                                            // If both semesters have data or no quarters entered, consider semester as 'Mixed' or 'N/A'
                                            $semester = "Mixed / N/A";
                                            $average = null;
                                        }

                                        $final_grade_display = ($grade["final_grade"] == "0.00" || $grade["final_grade"] == "") ? "Not Yet Available" : htmlspecialchars(number_format($grade["final_grade"], 2) . "%");
                                        $remarks_display = ($grade["remarks"] == "") ? "Not Yet Available" : htmlspecialchars($grade["remarks"]);

                                        $average_display = is_null($average) ? "Not Yet Available" : number_format($average, 2) . "%";
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($grade["student_name"]) ?></td>
                                            <td><?= htmlspecialchars($grade["subject_name"]) ?></td>
                                            <td><?= $average_display ?></td>
                                            <td><?= htmlspecialchars($semester) ?></td>
                                            <td><?= $final_grade_display ?></td>
                                            <td><?= $remarks_display ?></td>
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