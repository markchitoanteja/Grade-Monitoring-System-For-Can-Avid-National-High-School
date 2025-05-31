<div class="modal fade" id="update_teacher_modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="update_teacher_form">
                <div class="modal-body">
                    <div class="loading text-center py-5 d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="text-center mb-3">
                                    <img id="update_teacher_image_display" class="rounded-circle" src="assets/img/uploads/default-user-image.png" alt="User Image" style="width: 100px; height: 100px;">
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="update_teacher_image" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="update_teacher_employee_number">Employee Number</label>
                                    <input type="text" class="form-control" id="update_teacher_employee_number" required>
                                    <small class="text-danger d-none" id="error_update_teacher_employee_number">Employee Number is already in use!</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_teacher_first_name">First Name</label>
                                    <input type="text" class="form-control" id="update_teacher_first_name" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_teacher_middle_name">Middle Name (Optional)</label>
                                    <input type="text" class="form-control" id="update_teacher_middle_name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_teacher_last_name">Last Name</label>
                                    <input type="text" class="form-control" id="update_teacher_last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_teacher_birthday">Birthday</label>
                                    <input type="date" class="form-control" id="update_teacher_birthday" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_teacher_mobile_number">Mobile Number</label>
                                    <input type="number" class="form-control" id="update_teacher_mobile_number" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_teacher_email">Email</label>
                                    <input type="email" class="form-control" id="update_teacher_email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="update_teacher_address">Address</label>
                                    <textarea id="update_teacher_address" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_teacher_username">Username</label>
                                    <input type="text" class="form-control" id="update_teacher_username" required>
                                    <small class="text-danger d-none" id="error_update_teacher_username">Username is already in use!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_teacher_password">Password</label>
                                    <input type="password" class="form-control" id="update_teacher_password" placeholder="Password is hidden">
                                    <small class="text-danger d-none" id="error_update_teacher_password">Passwords do not matched!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_teacher_confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="update_teacher_confirm_password" placeholder="Password is hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="update_teacher_account_id">
                    <input type="hidden" id="update_teacher_old_image">
                    <input type="hidden" id="update_teacher_old_employee_number">
                    <input type="hidden" id="update_teacher_old_username">
                    <input type="hidden" id="update_teacher_old_password">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_teacher_submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>