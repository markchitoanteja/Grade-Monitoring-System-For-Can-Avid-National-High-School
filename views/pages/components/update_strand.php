<div class="modal fade" id="update_strand_modal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Strand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="update_strand_form">
                <div class="modal-body">
                    <div class="loading text-center py-5 d-none">
                        <h3 class="text-muted mb-3">Please Wait...</h3>
                        <i class="spinner-border"></i>
                    </div>
                    <div class="actual-form">
                        <input type="hidden" id="update_strand_id">

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="update_strand_code">Strand Code</label>
                                    <input type="text" class="form-control" id="update_strand_code" maxlength="10" required>
                                    <small class="text-danger d-none" id="error_update_strand_code">Strand code is already in use!</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="update_strand_name">Strand Name</label>
                                    <input type="text" class="form-control" id="update_strand_name" maxlength="100" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="update_strand_description">Description (Optional)</label>
                                    <textarea id="update_strand_description" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_strand_submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>