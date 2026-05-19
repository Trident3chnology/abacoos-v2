<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

include 'modal-add-sub-account.php';
include 'modal-edit-sub-account.php';
?>
<div class="section bg-primary text-dark section-lg">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="mb-5">
					<div class="mt-4 mb-0">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb breadcrumb-gray breadcrumb-transparent">
								<li class="breadcrumb-item"><a href="../">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page"><a id="account-name" href="../sub-account"></a></li>
							</ol>
						</nav>
					</div>
					<div class="card mb-3 d-flex align-items-end justify-content-end">
						<button class="btn btn-icon-only btn-pill btn-primary" type="button"
							aria-label="Add sub-account" title="Add sub-account" data-toggle="modal"
							data-target="#modal-add-sub-account">
							<span aria-hidden="true" class="fas fa-plus"></span>
						</button>
					</div>

					<div class="table-responsive-sm shadow-soft card">
						<table id="dataTable" class="table table-striped">
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