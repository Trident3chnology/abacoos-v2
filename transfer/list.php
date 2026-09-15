<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}
?>

<div class="section bg-primary text-dark py-3 py-md-4">
	<div class="container">

		<!-- Header Title & Action Bar -->
		<div class="mb-4">
			<div>
				<h1 class="h3 font-weight-bold text-dark mb-1">Internal Transfers</h1>
				<p class="text-gray-500 mb-0 font-weight-normal">Move funds instantly between your sub-accounts</p>
			</div>
		</div>

		<?php include __DIR__ . '/transfer-view.php'; ?>

	</div>
</div>

<script src="<?= WEB_ROOT; ?>assets/js/sweetAlert.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/transfer.js?v=<?= time(); ?>"></script>