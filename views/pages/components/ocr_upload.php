<!-- OCR Upload & Parse Modal -->
<div class="modal fade" id="ocr_upload_modal" tabindex="-1" aria-labelledby="ocrUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:0.5rem;box-shadow:0 0.5rem 1rem rgb(0 0 0 / 0.11);position:relative;font-size:0.93rem;background:#f8f9fa;">
            <div class="modal-header" style="border-bottom:1px solid #bfc2c5;background:#f2f2f2;">
                <h5 class="modal-title fw-bold" id="ocrUploadModalLabel" style="font-size:1.07em;color:#495057;">Upload Report Card Image for Grade Extraction <small class="text-muted">(Experimental Phase)</small></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ocr_upload_form" action="javascript:void(0);">
                <div class="modal-body" style="padding:1.1rem 1.4rem;background:#f8f9fa;">
                    <div class="mb-3">
                        <label for="ocr_image" class="form-label fw-bold" style="font-size:1em;color:#495057;">Select Report Card Image</label>
                        <input type="file"
                            class="form-control form-control-lg"
                            id="ocr_image"
                            name="image"
                            accept="image/*"
                            required
                            style="border-radius:0.4rem;box-shadow:inset 0 1px 2px rgb(0 0 0 / 0.075);font-size:0.96em;background:#f5f6fa;color:#495057;" />
                    </div>
                    <div class="table-responsive"
                        style="max-height:320px;overflow-y:auto;border-radius:0.5rem;box-shadow:inset 0 0 5px rgb(0 0 0 / 0.08);background:#f8f9fa;">
                        <table class="table table-bordered align-middle text-center mb-0"
                            style="border-collapse:separate;border-spacing:0;border-radius:0.5rem;overflow:hidden;font-size:0.93em;background:#f8f9fa;">
                            <thead class="table-light sticky-top"
                                style="font-weight:600;background-color:#f2f2f2;border-bottom:2px solid #bfc2c5;font-size:0.95em;">
                                <tr>
                                    <th colspan="4" class="fs-6 text-center" style="border-bottom:none;background:#f8f9fa;font-size:1em;color:#212529;">
                                        LEARNER’S PROGRESS REPORT CARD
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-start" style="font-size:0.98em;background:#e9ecef;color:#495057;border-bottom:1px solid #bfc2c5;">
                                        First Semester
                                    </th>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="width:48%;text-align:left;padding-left:1rem;background:#f2f2f2;color:#212529;">Subjects</th>
                                    <th colspan="2" style="width:32%;background:#f2f2f2;color:#212529;">Quarter</th>
                                    <th rowspan="2" style="width:20%;background:#f2f2f2;color:#212529;">Semester Final Grade</th>
                                </tr>
                                <tr>
                                    <th style="width:16%;background:#f2f2f2;color:#212529;">1</th>
                                    <th style="width:16%;background:#f2f2f2;color:#212529;">2</th>
                                </tr>
                            </thead>
                            <tbody id="ocr_parsed_grades" style="font-size:0.92em;">
                                <!-- JS populates rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:none;justify-content:flex-end;padding:0.9rem 1.4rem;background:#f2f2f2;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-size:0.97em;">Close</button>
                    <button type="submit" class="btn btn-primary fw-semibold" id="ocr_submit_btn" style="font-size:0.97em;">Extract Grades</button>
                </div>
            </form>
        </div>
    </div>
</div>