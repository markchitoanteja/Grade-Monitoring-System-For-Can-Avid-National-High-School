<div class="modal fade" id="new_student_grade_modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Student Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="new_student_grade_form">
                <div class="modal-body">
                    <div class="loading py-5 text-center d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>

                    <div class="actual-form">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="new_student_grade_student_id">Student Name</label>
                                    <select id="new_student_grade_student_id" class="form-select" required>
                                        <option value selected disabled></option>
                                        <?php if ($students = $db->select_all("students", "first_name", "ASC")): ?>
                                            <?php foreach ($students as $student): ?>
                                                <option value="<?= $student["account_id"] ?>"><?= $student["first_name"] . ' ' . (!empty($student["middle_name"]) ? substr($student["middle_name"], 0, 1) . '. ' : '') . $student["last_name"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="new_student_grade_course">Course</label>
                                    <select id="new_student_grade_course" class="form-select" required disabled>
                                        <!-- Data from AJAX -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="new_student_grade_year">Year</label>
                                    <select id="new_student_grade_year" class="form-select" required disabled>
                                        <!-- Data from AJAX -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="new_student_grade_semester">Semester</label>
                                    <select id="new_student_grade_semester" class="form-select" required>
                                        <option value selected disabled></option>
                                        <option value="1st">1st Semester</option>
                                        <option value="2nd">2nd Semester</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="new_student_grade_subject_id">Subject</label>
                                    <select id="new_student_grade_subject_id" class="form-select" required disabled>
                                        <!-- Data from AJAX -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="new_student_grade_grade_component_id">Grade Component</label>
                                    <select id="new_student_grade_grade_component_id" class="form-select" required disabled>
                                        <!-- Data from AJAX -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="new_student_grade_grade">Total Grade</label>
                                    <input type="text" class="form-control" id="new_student_grade_grade" required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="grade_calculator">
                            <div class="col-lg-12">
                                <div class="p-3 border rounded">
                                    <h6 id="grade_calculator_title"></h6>
                                    <div id="grades_list" class="mb-2"></div>
                                    <div class="form-group mb-2">
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="new_grade_input" placeholder="Enter a grade">
                                            <button class="btn btn-secondary" type="button" id="add_grade_button">Add Grade</button>
                                        </div>
                                        <small class="text-danger mt-1 d-none" id="error_new_grade_input">Please add at least one grade.</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-success" id="calculate_average_button" type="button">Calculate Average</button>
                                        <button class="btn btn-danger" id="clear_grades_button" type="button">Clear</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="new_student_grade_teacher_id" value="<?= $_SESSION["user_id"] ?>">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="new_student_grade_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>