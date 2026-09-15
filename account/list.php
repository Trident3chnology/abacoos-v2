<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

include 'modal-add-account.php';
include 'modal-edit-account.php';
?>
<div class="section bg-primary text-dark py-3 py-md-4">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="mb-4">
					
					<!-- Header Row: Title & Add Account Button -->
					<div class="d-flex align-items-center justify-content-between mb-3">
						<span class="h5 mb-0 font-weight-bold">List of Accounts</span>

						<button class="btn btn-icon-only btn-pill btn-primary shadow-soft neu-btn-press" type="button"
							aria-label="Add account" title="Add account" data-toggle="modal" data-target="#modal-add-account">
							<span aria-hidden="true" class="fas fa-plus"></span>
						</button>
					</div>

					<!-- Table Container -->
					<div class="table-responsive-sm shadow-soft card p-3 rounded-2xl">
						<table id="dataTable" class="table table-striped w-100">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th class="text-right">Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= WEB_ROOT; ?>assets/js/setUpValidation.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/account.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/formSubmitLoader.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/sweetAlert.js"></script>