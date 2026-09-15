<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

include 'modal-add-sub-account.php';
include 'modal-edit-sub-account.php';
?>
<div class="section bg-primary text-dark py-3 py-md-4">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="mb-4">
					
					<!-- Header Row: Breadcrumbs & Add Sub-Account Button -->
					<div class="d-flex align-items-center justify-content-between mb-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb breadcrumb-gray breadcrumb-transparent p-0 m-0">
								<li class="breadcrumb-item"><a href="../" class="font-weight-bold">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">
									<a id="account-name" href="../sub-account" class="font-weight-bold text-dark"></a>
								</li>
							</ol>
						</nav>

						<button class="btn btn-icon-only btn-pill btn-primary shadow-soft neu-btn-press" type="button"
							aria-label="Add sub-account" title="Add sub-account" data-toggle="modal"
							data-target="#modal-add-sub-account">
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
<script src="<?= WEB_ROOT; ?>assets/js/subAccount.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/formSubmitLoader.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/sweetAlert.js"></script>