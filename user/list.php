<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

include 'modal-invite-user.php';
?>
<div class="section bg-primary text-dark section-lg">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="mb-5">
					<div class="mt-4 mb-1">
						<span class="h5">List of Users</span>
					</div>
					<div class="card mb-3 d-flex align-items-end justify-content-end">
						<button class="btn btn-icon-only btn-pill btn-primary" type="button" aria-label="Invite user"
							title="Invite user" data-toggle="modal" data-target="#modal-invite-user">
							<span aria-hidden="true" class="fas fa-plus"></span>
						</button>
					</div>

					<div class="table-responsive-sm shadow-soft card">
						<table id="dataTable" class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Email</th>
									<th>Delete</th>
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
<script src="<?= WEB_ROOT; ?>assets/js/user.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/formSubmitLoader.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/sweetAlert.js"></script>