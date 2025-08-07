<div class="modal fade" id="update_subject_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="update_subject_form">
                <input type="hidden" id="update_subject_id">

                <div class="modal-body">
                    <div class="loading py-5 text-center d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form">
                        <div class="alert alert-danger text-center d-none" id="update_subject_error_message">This subject already exists.</div>

                        <div class="mb-3">
                            <label for="update_subject_name" class="form-label">Subject Name</label>
                            <input type="text" class="form-control" id="update_subject_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="update_subject_category" class="form-label">Category</label>
                            <select class="form-select" id="update_subject_category" required>
                                <option value="" selected disabled></option>
                                <option value="core">Core</option>
                                <option value="applied and specialized">Applied and Specialized</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="update_subject_grade_level" class="form-label">Grade Level</label>
                            <select class="form-select" id="update_subject_grade_level" required>
                                <option value="" selected disabled></option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="update_subject_strand_id" class="form-label">Strand</label>
                            <select class="form-select" id="update_subject_strand_id" required>
                                <?php
                                $db = new Database();
                                $strands = $db->select_all("strands", "code", "ASC");
                                ?>

                                <option value="" selected disabled></option>
                                <?php if ($strands): ?>
                                    <?php foreach ($strands as $strand): ?>
                                        <option value="<?= $strand["id"] ?>"><?= $strand["code"] ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_subject_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>