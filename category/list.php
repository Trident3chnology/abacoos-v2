<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

include 'modal-add-category.php';
include 'modal-edit-category.php';
?>
<div class="section bg-primary text-dark section-lg">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="mb-5">
					<div class="mt-4 mb-1">
						<span class="h5">List of Categories</span>
					</div>
					<div class="card mb-3 d-flex align-items-end justify-content-end">
						<button class="btn btn-icon-only btn-pill btn-primary" type="button" aria-label="Add category"
							title="Add category" data-toggle="modal" data-target="#modal-add-category">
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
<script src="<?= WEB_ROOT; ?>assets/js/category.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/formSubmitLoader.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/sweetAlert.js"></script>