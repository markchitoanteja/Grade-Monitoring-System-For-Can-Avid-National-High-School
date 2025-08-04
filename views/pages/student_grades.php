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

    include_once "views/pages/templates/header.php";

    $db = new Database;

    $teacher_id = $_SESSION["user_id"];

    $grade_components = $db->select_many("grade_components", "teacher_id", $teacher_id);

    $sql = "
        SELECT students.id AS student_id, students.student_number, users.name AS student_name,
               sg.course, sg.year, sg.semester, subjects.description AS subject,
               gc.id AS component_id, sg.grade AS grade
        FROM student_grades sg
        INNER JOIN students ON students.account_id = sg.student_id
        INNER JOIN users ON users.id = students.account_id
        INNER JOIN subjects ON subjects.id = sg.subject_id
        RIGHT JOIN grade_components gc ON gc.id = sg.grade_component_id
        WHERE sg.teacher_id = '$teacher_id'
        ORDER BY students.id, gc.id
    ";

    $students_grades = $db->run_custom_query($sql);

    $display_data = [];

    foreach ($students_grades as $row) {
        $student_id = $row['student_id'];
        $component_id = $row['component_id'];
        $grade = isset($row['grade']) ? $row['grade'] : 'Unavailable';

        if (!isset($display_data[$student_id])) {
            $display_data[$student_id] = [
                'student_number' => $row['student_number'],
                'student_name' => $row['student_name'],
                'course' => $row['course'],
                'year' => $row['year'],
                'semester' => $row['semester'],
                'subject' => $row['subject'],
                'grades' => []
            ];
        }

        $display_data[$student_id]['grades'][$component_id] = $grade;
    }

    function scale($grade)
    {
        $passingGrade = 75;
        $highestGrade = 100;
        $passingScale = 3.0;
        $lowestScale = 1.0;

        if ($grade < $passingGrade || $grade > $highestGrade) {
            return "Grade must be between $passingGrade and $highestGrade.";
        }

        $scaleRange = $passingScale - $lowestScale;
        $gradeRange = $highestGrade - $passingGrade;
        $scale = $passingScale - (($grade - $passingGrade) / $gradeRange) * $scaleRange;

        return round($scale, 1);
    }
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="row">
            <div class="col-6">
                <h1>Student Grades</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Student Grades</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-bar-chart me-1"></i> Grade Distribution Chart</h5>
                        <form action="javascript:void(0)" id="chart">
                            <div class="row mb-3">
                                <div class="col-lg-5">
                                    <select id="chart_student_id" class="form-select" required>
                                        <option value selected disabled>-- Select a Student --</option>

                                        <?php if ($students = $db->select_all("students", "first_name", "ASC")): ?>
                                            <?php foreach ($students as $student): ?>
                                                <option value="<?= $student["account_id"] ?>"><?= $student["first_name"] . ' ' . (!empty($student["middle_name"]) ? substr($student["middle_name"], 0, 1) . '. ' : '') . $student["last_name"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <div class="col-lg-5">
                                    <select id="chart_subject_id" class="form-select" required>
                                        <option value selected disabled>-- Select a Subject --</option>

                                        <?php $subjects = $db->select_all("subjects") ?>

                                        <?php if ($subjects): ?>
                                            <?php foreach ($subjects as $subject): ?>
                                                <option value="<?= $subject["id"] ?>"><?= $subject["description"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <button type="submit" class="btn btn-success w-100">Search</button>
                                </div>
                            </div>
                        </form>

                        <div class="loading py-5 text-center">
                            <h3 class="text-muted mb-3">Please Wait...</h3>
                            <i class="spinner-border"></i>
                        </div>

                        <div class="canvas">
                            <canvas id="lineChart" style="max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-journal-bookmark me-1"></i> All Student Grades</h5>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Student Number</th>
                                    <th>Student Name</th>
                                    <th>Course</th>
                                    <th>Year</th>
                                    <th>Semester</th>
                                    <th>Subject</th>
                                    <th>Final Grade</th>
                                    <th>Scale</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($display_data as $student): ?>
                                    <?php
                                    $grades_text = '';
                                    $final_grade = 0;
                                    $num_components = 0;
                                    $all_components_available = true;

                                    foreach ($grade_components as $component) {
                                        $component_id = $component['id'];
                                        $grade = isset($student['grades'][$component_id]) ? $student['grades'][$component_id] : 'Unavailable';

                                        if ($grade === 'Unavailable') {
                                            $all_components_available = false;
                                        } else {
                                            $final_grade += (float)$grade;
                                            $num_components++;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($student['student_number']) ?></td>
                                        <td><?= htmlspecialchars($student['student_name']) ?></td>
                                        <td><?= htmlspecialchars($student['course']) ?></td>
                                        <td><?= htmlspecialchars($student['year']) ?> Year</td>
                                        <td><?= htmlspecialchars($student['semester']) ?> Semester</td>
                                        <td><?= htmlspecialchars($student['subject']) ?></td>
                                        <td>
                                            <?php
                                            if ($all_components_available && $num_components > 0) {
                                                echo round($final_grade / $num_components, 2) . "%";
                                            } else {
                                                echo "Unavailable";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($all_components_available && $num_components > 0) {
                                                echo scale(round($final_grade / $num_components, 2));
                                            } else {
                                                echo "Unavailable";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "views/pages/templates/footer.php" ?>