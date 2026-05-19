<div class="modal fade" id="modal-transaction" tabindex="-1" role="dialog" aria-labelledby="modal-transaction"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-primary shadow-soft border-light p-4">
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <!-- <div class="card-header pb-0">
                        <h2 class="mb-0 h5">Add Sub-account</h2>
                    </div> -->
                    <div class="card-body p-1">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Tab Nav -->
                                <div class="nav-wrapper position-relative mb-4">
                                    <ul class="nav nav-pills nav-fill flex-md-row" id="tabs-icons-text" role="tablist">
                                        <li class="nav-item mr-2">
                                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tab-transaction"
                                                data-toggle="tab" href="#tabs-transaction" role="tab"
                                                aria-controls="tabs-transaction" aria-selected="true">Transaction</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mb-sm-3 mb-md-0" id="tab-transfer" data-toggle="tab"
                                                href="#tabs-transfer" role="tab" aria-controls="tabs-transfer"
                                                aria-selected="false">Transfer</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End of Tab Nav -->
                                <!-- Tab Content -->
                                <div class="card shadow-inset bg-primary border-light p-4 rounded">
                                    <div class="card-body p-0">
                                        <div class="tab-content" id="tabcontent2">
                                            <div class="tab-pane fade show active" id="tabs-transaction" role="tabpanel"
                                                aria-labelledby="tab-transaction">
                                                <form class="form-submit-loader" method="post"
                                                    action="process.php?action=add_transaction"
                                                    enctype="multipart/form-data" name="form" id="form">
                                                    <div class="form-group mb-4">
                                                        <label class="h6" for="transactionDate">Date</label>
                                                        <div class="input-group mb-4">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><span
                                                                        class="far fa-calendar-alt"></span></span>
                                                            </div>
                                                            <input class="form-control datepicker"
                                                                name="transactionDate" id="transactionDate"
                                                                placeholder="Select date" type="text"
                                                                aria-label="Date with icon left">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label class="my-1 mr-2"
                                                            for="transactionCategory">Category</label>
                                                        <select class="custom-select my-1 mr-sm-2"
                                                            name="transactionCategory" id="transactionCategory"
                                                            required>
                                                            <option value="" disabled selected>Choose...</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="transactionDescription">Description</label>
                                                        <input type="text" class="form-control"
                                                            name="transactionDescription" id="transactionDescription"
                                                            placeholder="Enter description" autocomplete="off" required>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="transactionAmount">Amount</label>
                                                        <input type="text" class="form-control" name="transactionAmount"
                                                            id="transactionAmount" placeholder="Enter amount"
                                                            autocomplete="off" onkeyup="formatNumber(this)" required>
                                                    </div>
                                                    <div class="custom-file mb-4">
                                                        <input type="file" class="custom-file-input"
                                                            name="transactionAttachment[]" id="transactionAttachment"
                                                            multiple>
                                                        <label class="custom-file-label"
                                                            for="transactionAttachment">Choose files</label>
                                                    </div>
                                                    <div id="transactionPreview" class="mb-4"></div>
                                                    <div class="form-group mb-4">
                                                        <label for="transactionType">Type</label>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2">
                                                            <div class="form-check col-6">
                                                                <input class="form-check-input" type="radio"
                                                                    name="transactionType" id="transactionTypeIn"
                                                                    value="0" checked>
                                                                <label class="form-check-label" for="transactionTypeIn">
                                                                    IN (Debit)
                                                                </label>
                                                            </div>
                                                            <div class="form-check col-6">
                                                                <input class="form-check-input" type="radio"
                                                                    name="transactionType" id="transactionTypeOut"
                                                                    value="1">
                                                                <label class="form-check-label"
                                                                    for="transactionTypeOut">
                                                                    OUT (Credit)
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <!-- Transaction -->
                                                        <input type="hidden" name="ttType" value="0" readonly>
                                                        <input type="hidden" name="aId" id="transaction-a-id" readonly>
                                                        <input type="hidden" name="saId" id="transaction-sa-id"
                                                            readonly>
                                                    </div>

                                                    <button type="submit" id="submitBtn"
                                                        class="btn btn-block btn-primary submitBtn">Save</button>

                                                    <button type="button" id="loadingBtn"
                                                        class="btn btn-block btn-primary loadingBtn d-none" disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span>
                                                        <span class="ml-1">Loading...</span>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="tabs-transfer" role="tabpanel"
                                                aria-labelledby="tab-transfer">
                                                <p>Photo booth stumptown tote bag Banksy, elit small batch freegan
                                                    sed. Craft beer elit seitan exercitation, photo booth et 8-bit
                                                    kale chips proident chillwave deep v laborum. Aliquip veniam
                                                    delectus, Marfa eiusmod
                                                    Pinterest in do umami readymade swag.</p>
                                                <p>Day handsome addition horrible sensible goodness two contempt.
                                                    Evening for married his account removal. Estimable me disposing
                                                    of be moonlight cordially curiosity.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Tab Content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="imageViewer" class="image-viewer">
    <span id="closeViewer">&times;</span>
    <img id="viewerImg">
</div>