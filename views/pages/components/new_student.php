<div class="modal fade" id="new_student_modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="new_student_form">
                <div class="modal-body">
                    <div class="loading text-center py-5 d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="text-center mb-3">
                                    <img id="new_student_image_display" class="rounded-circle" src="public/assets/img/uploads/default-user-image.png" alt="User Image" style="width: 100px; height: 100px;">
                                </div>
                                <div class="form-group">
                                    <input type="file" class="form-control-file" id="new_student_image" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_student_number">Student Number</label>
                                    <input type="text" class="form-control" id="new_student_student_number" required>
                                    <small class="text-danger d-none" id="error_new_student_student_number">Student Number is already in use!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_course">Course</label>
                                    <select id="new_student_course" class="form-select" required>
                                        <option value selected disabled></option>
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
                                    <label for="new_student_year">Year</label>
                                    <select id="new_student_year" class="form-select" required disabled>
                                        <!-- Data from AJAX -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="new_student_section">Section</label>
                                    <input type="text" class="form-control" id="new_student_section" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_first_name">First Name</label>
                                    <input type="text" class="form-control" id="new_student_first_name" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_middle_name">Middle Name (Optional)</label>
                                    <input type="text" class="form-control" id="new_student_middle_name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_last_name">Last Name</label>
                                    <input type="text" class="form-control" id="new_student_last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_birthday">Birthday</label>
                                    <input type="date" class="form-control" id="new_student_birthday" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_mobile_number">Mobile Number</label>
                                    <input type="number" class="form-control" id="new_student_mobile_number" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_email">Email</label>
                                    <input type="email" class="form-control" id="new_student_email" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="new_student_address">Address</label>
                                    <textarea id="new_student_address" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_username">Username</label>
                                    <input type="text" class="form-control" id="new_student_username" required>
                                    <small class="text-danger d-none" id="error_new_student_username">Username is already in use!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_password">Password</label>
                                    <input type="password" class="form-control" id="new_student_password" required>
                                    <small class="text-danger d-none" id="error_new_student_password">Passwords do not matched!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="new_student_confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="new_student_confirm_password" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="new_student_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>