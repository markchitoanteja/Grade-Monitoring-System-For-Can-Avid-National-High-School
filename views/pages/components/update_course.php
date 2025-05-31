<div class="modal fade" id="update_course_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="update_course_form">
                <div class="modal-body">
                    <div class="loading py-5 text-center">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form d-none">
                        <div class="form-group mb-3">
                            <label for="update_course_code">Course Code</label>
                            <input type="text" class="form-control" id="update_course_code" required>
                            <small class="text-danger d-none" id="error_update_course_code">Course Code is already in use!</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="update_course_description">Course Description</label>
                            <input type="text" class="form-control" id="update_course_description" required>
                        </div>
                        <div class="form-group">
                            <label for="update_course_years">Years</label>
                            <input type="number" class="form-control" id="update_course_years" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="update_course_id">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_course_submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>