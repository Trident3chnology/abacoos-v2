<div class="modal fade" id="modal-edit-category" tabindex="-1" role="dialog" aria-labelledby="modal-edit-category">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-width: 440px;">
        <div class="modal-content border-0 rounded-2xl position-relative overflow-hidden" style="background-color: #e6e7ee; border: 1px solid rgba(255, 255, 255, 0.8) !important;">
            <div class="modal-body p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 40px; height: 40px; background: #2D4CC8; box-shadow: 0 4px 12px rgba(45, 76, 200, 0.3);">
                            <i class="fa-solid fa-pen-to-square text-white" style="font-size: 1.1rem;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-black text-dark" style="font-family: 'Outfit', sans-serif; font-size: 1.35rem; letter-spacing: -0.02em;">Edit Category</h3>
                            <p class="text-xs text-gray-500 mb-0 font-weight-bold">Update category details</p>
                        </div>
                    </div>
                    <button type="button" class="close btn-modal-close d-flex align-items-center justify-content-center rounded-circle shadow-soft border border-white p-0" data-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; background: #e6e7ee; opacity: 0.85; transition: all 200ms ease;">
                        <span aria-hidden="true" style="font-size: 1.2rem; line-height: 1; color: #475569;">×</span>
                    </button>
                </div>

                <form class="form-submit-loader" method="post" action="process.php?action=edit_category" enctype="multipart/form-data" name="form" id="form">
                    <div class="form-group mb-4">
                        <label for="editCategoryName" class="text-xs font-weight-black uppercase tracking-wider mb-2 display-block" style="color: #475569 !important; font-size: 0.75rem;">Category Name</label>
                        <div class="d-flex align-items-center bg-primary shadow-inset rounded-pill px-3 py-1.5">
                            <input type="text" class="form-control bg-transparent border-0 font-weight-bold text-dark p-0 shadow-none outline-none w-100" name="editCategoryName" id="editCategoryName" placeholder="Enter category name..." autocomplete="off" required style="color: #0f172a !important; height: 38px;">
                        </div>
                        <div id="editCategoryNameFeedback"></div>
                        <input type="hidden" name="c_id" id="c_id" readonly>
                    </div>

                    <button type="submit" id="submitBtn" class="btn btn-block btn-primary submitBtn shadow-soft border-0 text-white font-weight-black py-3 rounded-xl uppercase tracking-wider neu-btn-press" style="background: linear-gradient(135deg, #2D4CC8 0%, #1e3a8a 100%); font-size: 0.95rem; font-family: 'Outfit', sans-serif;">
                        <i class="fa-solid fa-check mr-2"></i> Save Changes
                    </button>

                    <button type="button" id="loadingBtn" class="btn btn-block btn-primary loadingBtn d-none" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="ml-1">Saving...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>