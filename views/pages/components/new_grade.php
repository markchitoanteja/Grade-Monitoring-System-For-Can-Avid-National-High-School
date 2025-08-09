<div class="modal fade" id="new_grade_modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Student Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="new_grade_form" novalidate>
                <div class="modal-body">
                    <div class="loading text-center py-5 d-none">
                        <h3 class="text-muted mb-3">Loading...</h3>
                        <div class="spinner-border" role="status" aria-hidden="true"></div>
                    </div>

                    <div class="actual-form">
                        <div class="alert alert-danger text-center d-none" id="new_grade_error" role="alert">
                            Grade record exists. Use Edit to update.
                        </div>

                        <!-- Student & Subject -->
                        <h6 class="text-primary border-bottom pb-2 mb-3">Student & Subject</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="new_grade_student_id" class="form-label fw-semibold">Student</label>
                                <select class="form-select" id="new_grade_student_id" required>
                                    <option value="" disabled selected></option>
                                    <?php $students = $db->select_all("students", "last_name", "ASC") ?>
                                    <?php if ($students): ?>
                                        <?php foreach ($students as $student): ?>
                                            <option value="<?= $student["id"] ?>">
                                                <?= htmlspecialchars($student["last_name"] . ", " . $student["first_name"] . " " . $student["middle_name"]) ?>
                                            </option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="new_grade_subject" class="form-label fw-semibold">Subject</label>
                                <select class="form-select" id="new_grade_subject" required>
                                    <option value="" disabled selected></option>
                                </select>
                            </div>
                        </div>

                        <!-- Semester Selection -->
                        <h6 class="text-primary border-bottom pb-2 mb-3">Semester</h6>
                        <div class="mb-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="new_grade_semester" id="semester_1" value="1" required checked>
                                <label class="form-check-label" for="semester_1">First Semester</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="new_grade_semester" id="semester_2" value="2" required>
                                <label class="form-check-label" for="semester_2">Second Semester</label>
                            </div>
                        </div>

                        <!-- First Semester Grades -->
                        <div id="first_semester_grades" style="display:none;">
                            <h6 class="text-primary border-bottom pb-2 mb-3">First Semester Grades</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="new_grade_quarter_1" class="form-label fw-semibold">Quarter 1</label>
                                    <input type="number" min="0" max="100" step="0.01" class="form-control semester-quarter" id="new_grade_quarter_1" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="new_grade_quarter_2" class="form-label fw-semibold">Quarter 2</label>
                                    <input type="number" min="0" max="100" step="0.01" class="form-control semester-quarter" id="new_grade_quarter_2" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Second Semester Grades -->
                        <div id="second_semester_grades" style="display:none;">
                            <h6 class="text-primary border-bottom pb-2 mb-3">Second Semester Grades</h6>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="new_grade_quarter_3" class="form-label fw-semibold">Quarter 3</label>
                                    <input type="number" min="0" max="100" step="0.01" class="form-control semester-quarter" id="new_grade_quarter_3" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="new_grade_quarter_4" class="form-label fw-semibold">Quarter 4</label>
                                    <input type="number" min="0" max="100" step="0.01" class="form-control semester-quarter" id="new_grade_quarter_4" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Final Result -->
                        <h6 class="text-primary border-bottom pb-2 mb-3">Final Result</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="new_grade_final" class="form-label fw-semibold">Final Grade</label>
                                <input type="number" min="0" max="100" step="0.01" class="form-control" id="new_grade_final" placeholder="Not Yet Available" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="new_grade_remarks" class="form-label fw-semibold">Remarks</label>
                                <input type="text" class="form-control" id="new_grade_remarks" placeholder="Not Yet Available" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="new_grade_submit">Add Grade</button>
                </div>
            </form>
        </div>
    </div>
</div>