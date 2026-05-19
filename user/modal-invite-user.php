<div class="modal fade" id="modal-invite-user" tabindex="-1" role="dialog" aria-labelledby="modal-invite-user"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-primary shadow-soft border-light p-4">
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="card-header pb-0">
                        <h2 class="mb-0 h5">Invite User</h2>
                    </div>
                    <div class="card-body">
                        <form class="form-submit-loader" method="post" action="process.php?action=invite" enctype="multipart/form-data" name="form"
                            id="form">
                            <div class="form-group mb-4">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Enter email" autocomplete="off" required>
                                <div id="emailFeedback"></div>
                            </div>

                            <button type="submit" id="submitBtn" class="btn btn-block btn-primary submitBtn">Invite</button>

                            <button type="button" id="loadingBtn" class="btn btn-block btn-primary loadingBtn d-none" disabled>
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