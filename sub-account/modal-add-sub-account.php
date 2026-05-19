<div class="modal fade" id="modal-add-sub-account" tabindex="-1" role="dialog" aria-labelledby="modal-add-sub-account"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-primary shadow-soft border-light p-4">
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="card-header pb-0">
                        <h2 class="mb-0 h5">Add Sub-account</h2>
                    </div>
                    <div class="card-body">
                        <form class="form-submit-loader" method="post" action="process.php?action=add_sub_account"
                            enctype="multipart/form-data" name="form" id="form">
                            <div class="form-group mb-4">
                                <label for="addSubAccountName">Sub-account Name</label>
                                <input type="text" class="form-control" name="addSubAccountName" id="addSubAccountName"
                                    placeholder="Enter sub-account name" autocomplete="off" required>
                                <div id="addSubAccountNameFeedback"></div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="addSubAccountNumber">Sub-account Number</label>
                                <input type="text" class="form-control" name="addSubAccountNumber" id="addSubAccountNumber"
                                    placeholder="Enter sub-account number" autocomplete="off" required>
                                <div id="addSubAccountNumberFeedback"></div>
                                <input type="hidden" name="aId" id="add-a-id" readonly>
                            </div>

                            <button type="submit" id="submitBtn"
                                class="btn btn-block btn-primary submitBtn">Save</button>

                            <button type="button" id="loadingBtn" class="btn btn-block btn-primary loadingBtn d-none"
                                disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="ml-1">Loading...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>