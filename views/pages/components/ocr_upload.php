<!-- OCR Upload & Parse Modal (Font enlarged, header left-aligned) -->
<div class="modal fade" id="ocr_upload_modal" tabindex="-1" aria-labelledby="ocrUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:0.35rem;box-shadow:0 0.5rem 1rem rgb(0 0 0 / 0.11);font-size:0.92rem;background:#fff;">
            <div class="modal-header" style="border-bottom:1px solid #dee2e6;background:#f8f9fa;">
                <h5 class="modal-title w-100 fw-bold text-start" id="ocrUploadModalLabel" style="font-size:1.11rem;color:#343a40;">
                    Upload Report Card Image for Grade Extraction
                    <small class="text-muted" style="font-weight:normal;font-size:1em;">(Experimental Phase)</small>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ocr_upload_form" action="javascript:void(0);">
                <div class="modal-body p-2" style="background:#fff;">
                    <div class="mb-3">
                        <label for="ocr_image" class="form-label fw-bold" style="font-size:1em;color:#495057;">Select Report Card Image</label>
                        <input type="file"
                            class="form-control form-control-sm"
                            id="ocr_image"
                            name="image"
                            accept="image/*"
                            required
                            style="border-radius:0.35rem;font-size:1em;background:#f8f9fa;color:#495057;" />
                    </div>
                    <div class="table-responsive" style="max-height:320px;overflow-y:auto;">
                        <table class="table table-bordered align-middle table-sm mb-0" style="font-size:0.92em;background:#fff;">
                            <thead class="table-light">
                                <tr>
                                    <th colspan="4" class="text-center" style="font-size:0.99rem;">LEARNER’S PROGRESS REPORT CARD</th>
                                </tr>
                                <tr class="table-secondary">
                                    <td colspan="4" style="font-size:0.98rem;"><strong>First Semester</strong></td>
                                </tr>
                                <tr>
                                    <th class="text-center" style="width:48%;font-size:0.97rem;">Subjects</th>
                                    <th class="text-center" style="width:16%;font-size:0.97rem;">Q1</th>
                                    <th class="text-center" style="width:16%;font-size:0.97rem;">Q2</th>
                                    <th class="text-center" style="width:20%;font-size:0.97rem;">Final Grade</th>
                                </tr>
                            </thead>
                            <tbody id="ocr_parsed_grades" style="font-size:0.96em;">
                                <!-- JS populates rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="background:#f8f9fa;border-top:1px solid #dee2e6;justify-content:flex-end;padding:0.8rem 1.2rem;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" style="font-size:1em;">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold" id="ocr_submit_btn" style="font-size:1em;">Extract Grades</button>
                </div>
            </form>
        </div>
    </div>
</div>