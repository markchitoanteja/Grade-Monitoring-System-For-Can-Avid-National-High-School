<div class="modal fade" id="new_grade_modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Student Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="new_grade_form">
                <div class="modal-body">
                    <div class="loading text-center py-5 d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form">
                        <div class="alert alert-danger text-center d-none" id="new_grade_error">
                            A grade for this student and subject already exists. Please use the edit form to update the record.
                        </div>

                        <!-- Student & Subject -->
                        <h6 class="text-primary border-bottom pb-2 mb-3">Student & Subject Information</h6>
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <label for="new_grade_student_id" class="fw-semibold">Student</label>
                                <select class="form-control" id="new_grade_student_id" required>
                                    <option value="" selected disabled></option>
                                    <?php $students = $db->select_all("students", "last_name", "ASC") ?>
                                    <?php if ($students): ?>
                                        <?php foreach ($students as $student): ?>
                                            <option value="<?= $student["id"] ?>">
                                                <?= $student["last_name"] . ", " . $student["first_name"] . " " . $student["middle_name"] ?>
                                            </option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="new_grade_subject" class="fw-semibold">Subject</label>
                                <select class="form-control" id="new_grade_subject" required>
                                    <option value="" selected disabled></option>
                                </select>
                            </div>
                        </div>

                        <!-- First Semester -->
                        <h6 class="text-primary border-bottom pb-2 mb-3">First Semester Grades</h6>
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <label for="new_grade_quarter_1" class="fw-semibold">Quarter 1</label>
                                <input type="number" min="0" max="100" step="0.01" class="form-control" id="new_grade_quarter_1" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="new_grade_quarter_2" class="fw-semibold">Quarter 2</label>
                                <input type="number" min="0" max="100" step="0.01" class="form-control" id="new_grade_quarter_2">
                            </div>
                        </div>

                        <!-- Second Semester -->
                        <h6 class="text-primary border-bottom pb-2 mb-3">Second Semester Grades</h6>
                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <label for="new_grade_quarter_3" class="fw-semibold">Quarter 3</label>
                                <input type="number" min="0" max="100" step="0.01" class="form-control" id="new_grade_quarter_3">
                            </div>
                            <div class="col-lg-6">
                                <label for="new_grade_quarter_4" class="fw-semibold">Quarter 4</label>
                                <input type="number" min="0" max="100" step="0.01" class="form-control" id="new_grade_quarter_4">
                            </div>
                        </div>

                        <!-- Final Result -->
                        <h6 class="text-primary border-bottom pb-2 mb-3">Final Result</h6>
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="new_grade_final" class="fw-semibold">Final Grade</label>
                                <input type="number" min="0" max="100" step="0.01" class="form-control" id="new_grade_final" placeholder="Not Yet Available" readonly>
                            </div>
                            <div class="col-lg-6">
                                <label for="new_grade_remarks" class="fw-semibold">Remarks</label>
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