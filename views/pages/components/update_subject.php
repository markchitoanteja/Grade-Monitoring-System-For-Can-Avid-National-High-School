<div class="modal fade" id="update_subject_modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="update_subject_form">
                <div class="modal-body">
                    <div class="loading py-5 text-center d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form d-none">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="update_subject_code">Subject Code</label>
                                    <input type="text" class="form-control" id="update_subject_code" required>
                                    <small class="text-danger d-none" id="error_update_subject_code">Subject Code is already in use!</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="update_subject_description">Descriptive Title</label>
                                    <input type="text" class="form-control" id="update_subject_description" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_subject_lecture_units">Lecture Units</label>
                                    <input type="number" class="form-control" id="update_subject_lecture_units" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_subject_laboratory_units">Laboratory Units</label>
                                    <input type="number" class="form-control" id="update_subject_laboratory_units" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_subject_hours_per_week">Hours/Week</label>
                                    <input type="number" class="form-control" id="update_subject_hours_per_week" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="update_subject_course">Course</label>
                                <select id="update_subject_course" class="form-select">
                                    <?php if ($courses = $db->select_all("courses", "code", "ASC")): ?>
                                        <?php foreach ($courses as $course): ?>
                                            <option value="<?= $course["code"] ?>"><?= $course["description"] ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="update_subject_year">Year</label>
                                <select id="update_subject_year" class="form-select" disabled>
                                    <!-- Data From AJAX -->
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="update_subject_semester">Semester</label>
                                <select id="update_subject_semester" class="form-select">
                                    <option value="1st">1st Semester</option>
                                    <option value="2nd">2nd Semester</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="update_subject_id">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_subject_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>