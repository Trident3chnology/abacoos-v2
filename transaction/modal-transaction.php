<div class="modal fade" id="modal-transaction" tabindex="-1" role="dialog" aria-labelledby="modal-transaction" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <style>
            /* Neumorphic Modal Type Pills & Controls (/animate) */
            /* Inactive State: Raised Neumorphic Pill */
            .type-pill-label {
                padding: 10px 16px !important;
                border-radius: 14px !important;
                background: #e6e7ee !important;
                box-shadow: 4px 4px 10px #b8b9be, -4px -4px 10px #ffffff !important;
                transition: all 0.2s cubic-bezier(0.23, 1, 0.32, 1) !important;
                border: none !important;
            }

            /* Active State: Pressed Down / Inset Well */
            .type-pill-label.active-pill {
                background: #e6e7ee !important;
                box-shadow: inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #ffffff !important;
                border: none !important;
            }

            .btn-close-neu {
                width: 34px !important;
                height: 34px !important;
                border-radius: 50% !important;
                background: #e6e7ee !important;
                box-shadow: 3px 3px 8px #b8b9be, -3px -3px 8px #ffffff !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border: none !important;
                outline: none !important;
                transition: transform 0.16s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.16s cubic-bezier(0.23, 1, 0.32, 1) !important;
                color: #64748b !important;
                cursor: pointer !important;
            }

            .btn-close-neu:hover,
            .btn-close-neu:active {
                box-shadow: inset 2px 2px 5px #b8b9be, inset -2px -2px 5px #ffffff !important;
                transform: scale(0.94) translate3d(0, 1px, 0) !important;
                color: #1e293b !important;
            }
        </style>
        <!-- Ultra-Clean Neumorphic Modal Surface (No Outer Box Shadow) -->
        <div class="modal-content border-0 rounded-2xl p-4 p-md-5 shadow-none" style="background: #e6e7ee; box-shadow: none !important;">
            
            <!-- Modal Header -->
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-gray-300/40">
                <div>
                    <h4 class="font-weight-black mb-1" style="font-size: 1.5rem; color: #0f172a; letter-spacing: -0.02em;">New Transaction</h4>
                    <p class="text-xs text-gray-500 font-weight-bold mb-0" style="color: #64748b; font-size: 0.85rem;">Log an income or expense entry</p>
                </div>
                <button type="button" class="btn-close-neu" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 1.3rem; line-height: 1;">&times;</span>
                </button>
            </div>

            <!-- Transaction Form -->
            <form class="form-submit-loader" method="post" action="process.php?action=add_transaction" enctype="multipart/form-data" name="form" id="form">

                <!-- Equal Height Single-Line Type Pill Selectors (DEBITS vs CREDITS) -->
                <div class="row mb-4">
                    <div class="col-6">
                        <label class="type-pill-label active-pill rounded-xl text-center d-flex align-items-center justify-content-center w-100 cursor-pointer mb-0">
                            <input type="radio" name="transactionType" id="transactionTypeIn" value="0" checked class="d-none">
                            <span class="font-weight-bold text-xs text-success d-inline-flex align-items-center tracking-wider">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5 align-middle"><path d="M8 2.75v10.5m-4.5-4.5l4.5 4.5 4.5-4.5"/></svg>
                                <strong class="font-weight-black mr-1" style="font-weight: 900; font-size: 0.82rem;">DEBITS</strong> (IN)
                            </span>
                        </label>
                    </div>
                    <div class="col-6">
                        <label class="type-pill-label rounded-xl text-center d-flex align-items-center justify-content-center w-100 cursor-pointer mb-0">
                            <input type="radio" name="transactionType" id="transactionTypeOut" value="1" class="d-none">
                            <span class="font-weight-bold text-xs text-danger d-inline-flex align-items-center tracking-wider">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5 align-middle"><path d="m3.75 7.25l4.5-4.5l4.5 4.5m-4.5 6V2.75"/></svg>
                                <strong class="font-weight-black mr-1" style="font-weight: 900; font-size: 0.82rem;">CREDITS</strong> (OUT)
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Date & Category Selection -->
                <div class="row mb-3">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label class="text-xs font-weight-black text-gray-600 uppercase tracking-wider mb-2 block" for="transactionDate">Date</label>
                        <input class="form-control datepicker bg-primary border-0 shadow-inset font-weight-bold text-dark rounded-xl px-3 py-2" name="transactionDate" id="transactionDate" placeholder="Select date" type="date" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="text-xs font-weight-black text-gray-600 uppercase tracking-wider mb-2 block" for="transactionCategory">Category</label>
                        <select class="custom-select bg-primary border-0 shadow-inset font-weight-bold text-dark rounded-xl px-3 py-2" name="transactionCategory" id="transactionCategory" required>
                            <option value="" disabled selected>Choose category...</option>
                        </select>
                    </div>
                </div>

                <!-- Description Input -->
                <div class="form-group mb-3">
                    <label class="text-xs font-weight-black text-gray-600 uppercase tracking-wider mb-2 block" for="transactionDescription">Description / Reference</label>
                    <input type="text" class="form-control bg-primary border-0 shadow-inset font-weight-bold text-dark rounded-xl px-3 py-2" name="transactionDescription" id="transactionDescription" placeholder="Enter description" autocomplete="off" required>
                </div>

                <!-- Amount Input -->
                <div class="form-group mb-4">
                    <label class="text-xs font-weight-black text-gray-600 uppercase tracking-wider mb-2 block" for="transactionAmount">Amount</label>
                    <div class="d-flex align-items-center bg-primary border-0 shadow-inset rounded-xl px-3 py-2">
                        <span class="font-weight-black text-dark mr-2" style="font-size: 1.35rem; color: #1e293b;">₱</span>
                        <input type="text" class="form-control bg-transparent border-0 p-0 text-dark font-weight-black font-fira-code shadow-none" name="transactionAmount" id="transactionAmount" placeholder="0.00" style="font-size: 1.35rem; height: auto;" autocomplete="off" onkeyup="formatNumber(this)" required>
                    </div>
                </div>

                <!-- Attachments Dropzone Box -->
                <div class="form-group mb-4">
                    <label class="text-xs font-weight-black text-gray-600 uppercase tracking-wider mb-2 block">Attachments / Receipts</label>
                    <div class="custom-file-dropzone shadow-inset rounded-xl p-3 text-center position-relative" style="background: #e6e7ee; border: 2px dashed #a3b1c6; cursor: pointer;">
                        <input type="file" class="custom-file-input-hidden" name="transactionAttachment[]" id="transactionAttachment" multiple style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 10;">
                        <div class="dropzone-content py-2">
                            <i class="fas fa-cloud-upload-alt mb-2" style="font-size: 1.8rem; color: #2D4CC8;"></i>
                            <div class="font-weight-bold text-gray-700 text-sm">Click or drag file to upload</div>
                            <span class="text-xs text-gray-500 uppercase tracking-wider">PNG, JPG, PDF up to 5MB</span>
                        </div>
                        <div id="transactionPreview" class="mt-2 position-relative" style="z-index: 12;"></div>
                    </div>
                </div>

                <!-- Hidden Parameters -->
                <input type="hidden" name="ttType" value="0" readonly>
                <input type="hidden" name="aId" id="transaction-a-id" readonly>
                <input type="hidden" name="saId" id="transaction-sa-id" readonly>

                <!-- Action Button -->
                <button type="submit" id="submitBtn" class="btn btn-block btn-primary shadow-soft border-0 py-3 font-weight-black text-white rounded-xl uppercase tracking-wider" style="background: linear-gradient(135deg, #2D4CC8 0%, #1e3a8a 100%); font-size: 0.95rem;">
                    <i class="fas fa-save mr-2"></i> Save Transaction
                </button>

                <button type="button" id="loadingBtn" class="btn btn-block btn-primary shadow-soft d-none py-3 font-weight-black text-white rounded-xl uppercase tracking-wider" disabled style="background: linear-gradient(135deg, #2D4CC8 0%, #1e3a8a 100%); font-size: 0.95rem;">
                    <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                    <span>Saving Transaction...</span>
                </button>
            </form>

        </div>
    </div>
</div>

<div id="imageViewer" class="image-viewer" tabindex="-1" role="dialog" aria-modal="true">
    <div class="image-viewer-dialog">
        <div class="image-viewer-header">
            <div class="d-flex align-items-center">
                <div class="image-viewer-icon-badge">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="ml-2 text-left">
                    <div class="image-viewer-title">Receipt Preview</div>
                    <small class="text-muted" style="font-size: 0.75rem;">Attached transaction document</small>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <a id="viewerDownload" href="#" target="_blank" rel="noopener noreferrer" class="image-viewer-action-btn" title="Open full size in new tab">
                    <i class="fas fa-external-link-alt"></i>
                </a>
                <button type="button" id="closeViewer" class="image-viewer-close-btn ml-2" title="Close preview (Esc)" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="image-viewer-body">
            <div class="image-viewer-frame">
                <img id="viewerImg" alt="Receipt Preview">
            </div>
        </div>
        <div class="image-viewer-footer">
            <span class="text-xs text-muted d-flex align-items-center">
                <i class="fas fa-info-circle mr-1 text-primary"></i> Click outside or press <kbd class="viewer-kbd ml-1 mr-1">ESC</kbd> to close
            </span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioInputs = document.querySelectorAll('input[name="transactionType"]');
    radioInputs.forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.type-pill-label').forEach(label => label.classList.remove('active-pill'));
            this.closest('.type-pill-label').classList.add('active-pill');
        });
    });
});
</script>