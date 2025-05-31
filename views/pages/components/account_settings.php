<div class="modal fade" id="account_settings_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Account Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="acccount_settings_form">
                <div class="modal-body">
                    <div class="loading py-5 text-center">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>

                    <div class="actual-form d-none">
                        <div class="mb-3">
                            <div class="text-center mb-3">
                                <img id="account_settings_image_display" class="rounded-circle" alt="User Image" style="width: 100px; height: 100px;">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control-file" id="account_settings_image" accept="image/*">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="account_settings_name">Name</label>
                            <input type="text" class="form-control" id="account_settings_name" required <?= $_SESSION["user_type"] != "admin" ? "readonly" : "" ?>>
                        </div>
                        <div class="form-group mb-3">
                            <label for="account_settings_username">Username</label>
                            <input type="text" class="form-control" id="account_settings_username" required>
                            <small class="text-danger d-none" id="error_account_settings_username"> Username is already in use!</small>
                        </div>
                        <div class="form-group mb-3">
                            <label for="account_settings_password">New Password</label>
                            <input type="password" class="form-control" id="account_settings_password" placeholder="Password is hidden">
                            <small class="text-danger d-none" id="error_account_settings_password">Passwords do not match!</small>
                        </div>
                        <div class="form-group">
                            <label for="account_settings_confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="account_settings_confirm_password" placeholder="Password is hidden">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="account_settings_id">
                    <input type="hidden" id="account_settings_old_password">
                    <input type="hidden" id="account_settings_old_image">

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="account_settings_submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>