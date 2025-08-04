<div class="modal fade" id="new_teacher_modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="new_teacher_form">
                <div class="modal-body">
                    <div class="loading text-center py-5 d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="text-center mb-3">
                                    <img id="new_teacher_image_display" class="rounded-circle" src="public/assets/img/uploads/default-user-image.png" alt="User Image" style="width: 100px; height: 100px;">
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="new_teacher_image" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="new_teacher_employee_number">Employee Number</label>
                                    <input type="text" class="form-control" id="new_teacher_employee_number" required>
                                    <small class="text-danger d-none" id="error_new_teacher_employee_number">Employee Number is already in use!</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_teacher_first_name">First Name</label>
                                    <input type="text" class="form-control" id="new_teacher_first_name" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_teacher_middle_name">Middle Name (Optional)</label>
                                    <input type="text" class="form-control" id="new_teacher_middle_name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_teacher_last_name">Last Name</label>
                                    <input type="text" class="form-control" id="new_teacher_last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_teacher_birthday">Birthday</label>
                                    <input type="date" class="form-control" id="new_teacher_birthday" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_teacher_mobile_number">Mobile Number</label>
                                    <input type="number" class="form-control" id="new_teacher_mobile_number" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_teacher_email">Email</label>
                                    <input type="email" class="form-control" id="new_teacher_email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="new_teacher_address">Address</label>
                                    <textarea id="new_teacher_address" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_teacher_username">Username</label>
                                    <input type="text" class="form-control" id="new_teacher_username" required>
                                    <small class="text-danger d-none" id="error_new_teacher_username">Username is already in use!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_teacher_password">Password</label>
                                    <input type="password" class="form-control" id="new_teacher_password" required>
                                    <small class="text-danger d-none" id="error_new_teacher_password">Passwords do not matched!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_teacher_confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="new_teacher_confirm_password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="new_teacher_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>