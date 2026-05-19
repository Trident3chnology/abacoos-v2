<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

?>
<div class="section bg-primary text-dark section-lg">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="mb-5">
					<div class="mt-4 mb-3">
						<span class="h5">Activity Logs</span>
					</div>
					<div class="table-responsive-sm shadow-soft card">
						<table id="dataTable" class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Module</th>
									<th>Action</th>
									<th>Description</th>
									<th>Action by</th>
									<th>Date | Time</th>
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

<script src="<?= WEB_ROOT; ?>assets/js/activityLog.js"></script>