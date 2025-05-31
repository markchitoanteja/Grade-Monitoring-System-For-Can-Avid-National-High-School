<div class="modal fade" id="update_student_modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="update_student_form">
                <div class="modal-body">
                    <div class="loading text-center py-5 d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="text-center mb-3">
                                    <img id="update_student_image_display" class="rounded-circle" src="assets/img/uploads/default-user-image.png" alt="User Image" style="width: 100px; height: 100px;">
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="update_student_image" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_student_number">Student Number</label>
                                    <input type="text" class="form-control" id="update_student_student_number" required>
                                    <small class="text-danger d-none" id="error_update_student_student_number">Student Number is already in use!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_course">Course</label>
                                    <select id="update_student_course" class="form-select" required>
                                        <?php if ($courses = $db->select_all("courses", "code", "ASC")): ?>
                                            <?php foreach ($courses as $course): ?>
                                                <option value="<?= $course["code"] ?>"><?= $course["description"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="update_student_year">Year</label>
                                    <select id="update_student_year" class="form-select" required disabled>
                                        <!-- Data from AJAX -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="update_student_section">Section</label>
                                    <input type="text" class="form-control" id="update_student_section" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_first_name">First Name</label>
                                    <input type="text" class="form-control" id="update_student_first_name" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_middle_name">Middle Name (Optional)</label>
                                    <input type="text" class="form-control" id="update_student_middle_name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_last_name">Last Name</label>
                                    <input type="text" class="form-control" id="update_student_last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_birthday">Birthday</label>
                                    <input type="date" class="form-control" id="update_student_birthday" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_mobile_number">Mobile Number</label>
                                    <input type="number" class="form-control" id="update_student_mobile_number" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_email">Email</label>
                                    <input type="email" class="form-control" id="update_student_email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="update_student_address">Address</label>
                                    <textarea id="update_student_address" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_username">Username</label>
                                    <input type="text" class="form-control" id="update_student_username" required>
                                    <small class="text-danger d-none" id="error_update_student_username">Username is already in use!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_password">Password</label>
                                    <input type="password" class="form-control" id="update_student_password" placeholder="Password is hidden">
                                    <small class="text-danger d-none" id="error_update_student_password">Passwords do not matched!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="update_student_confirm_password" placeholder="Password is hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="update_student_account_id">
                    <input type="hidden" id="update_student_old_image">
                    <input type="hidden" id="update_student_old_student_number">
                    <input type="hidden" id="update_student_old_username">
                    <input type="hidden" id="update_student_old_password">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_student_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>