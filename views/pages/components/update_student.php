<div class="modal fade" id="update_student_modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="update_student_form">
                <input type="hidden" id="update_student_account_id">
                <input type="hidden" id="update_student_old_image">

                <div class="modal-body">
                    <div class="loading text-center py-5 d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form">
                        <div class="row mb-3">
                            <div class="col-lg-12 d-flex flex-column align-items-center">
                                <div class="mb-2">
                                    <img id="update_student_image_display" src="<?= base_url('public/assets/img/uploads/default-user-image.png') ?>" alt="User Image" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 2px solid #dee2e6;">
                                </div>
                                <label for="update_student_image" style="background-color: #0d6efd; color: white; padding: 8px 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#0b5ed7'" onmouseout="this.style.backgroundColor='#0d6efd'">Upload Photo</label>
                                <input type="file" id="update_student_image" accept="image/*" style="display: none;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_lrn">Learner Reference Number</label>
                                    <input type="text" class="form-control" id="update_student_lrn" required>
                                    <small class="text-danger d-none" id="error_update_student_lrn">LRN is already in use!</small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_strand_id">Strand</label>
                                    <select id="update_student_strand_id" class="form-select" required>
                                        <option value selected disabled></option>
                                        <?php if ($strand = $db->select_all("strands", "code", "ASC")): ?>
                                            <?php foreach ($strands as $strand): ?>
                                                <option value="<?= $strand["id"] ?>"><?= $strand["code"] ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="update_student_grade_level">Grade Level</label>
                                    <select id="update_student_grade_level" class="form-select" required>
                                        <option value selected disabled></option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
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
                                    <label for="update_student_sex">Sex</label>
                                    <select class="form-select" id="update_student_sex" required>
                                        <option value selected disabled></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="update_student_email">Email</label>
                                    <input type="email" class="form-control" id="update_student_email" required>
                                    <small class="text-danger d-none" id="error_update_student_email">Email is already in use!</small>
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
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_student_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>