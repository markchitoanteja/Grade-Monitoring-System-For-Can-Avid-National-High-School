<div class="modal fade" id="update_grade_component_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Grade Component</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="update_grade_component_form">
                <div class="modal-body">
                    <div class="loading py-5 text-center d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>

                    <div class="actual-form">
                        <div class="form-group mb-3">
                            <label for="update_grade_component_subject_id">Subject</label>
                            <select id="update_grade_component_subject_id" class="form-select" require>
                                <?php if ($subjects = $db->select_all("subjects", "year", "ASC")): ?>
                                    <?php foreach ($subjects as $subject): ?>
                                        <option value="<?= $subject["id"] ?>"><?= $subject["description"] ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                            <small class="text-danger d-none" id="error_new_grade_component_subject_id">Component is already in use in this subject!</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="update_grade_component_component">Component (eg. Quiz, Recitation, etc)</label>
                            <input type="text" class="form-control" id="update_grade_component_component" required>
                            <small class="text-danger d-none" id="error_update_grade_component_component">Component is already in use in this subject!</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="update_grade_component_weight">Weight (eg. 10%, 25%, etc)</label>
                            <input type="number" class="form-control" id="update_grade_component_weight" required>
                            <small class="text-danger d-none" id="error_update_grade_component_weight">The total weight of grade components for this subject exceeds 100%</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="update_grade_component_id">
                    <input type="hidden" id="update_grade_component_teacher_id">
                    <input type="hidden" id="update_grade_component_old_weight">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_grade_component_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>