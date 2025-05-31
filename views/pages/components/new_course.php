<div class="modal fade" id="new_course_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="new_course_form">
                <div class="modal-body">
                    <div class="loading py-5 text-center d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form">
                        <div class="form-group mb-3">
                            <label for="new_course_code">Course Code</label>
                            <input type="text" class="form-control" id="new_course_code" required>
                            <small class="text-danger d-none" id="error_new_course_code">Course Code is already in use!</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_course_description">Course Description</label>
                            <input type="text" class="form-control" id="new_course_description" required>
                        </div>
                        <div class="form-group">
                            <label for="new_course_years">Years</label>
                            <input type="number" class="form-control" id="new_course_years" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="new_course_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>