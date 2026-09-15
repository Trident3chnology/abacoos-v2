<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

include 'modal-transaction.php';
include 'modal-edit-sub-account.php';
?>

<style>
	/* Neumorphic Hover & Click Animation for Add Transaction Button (/animate) */
	#btn-add-transaction-modal,
	.neu-btn-press {
		transition: transform 0.16s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.16s cubic-bezier(0.23, 1, 0.32, 1), background-color 0.16s ease !important;
		will-change: transform, box-shadow;
		outline: none !important;
	}

	/* Neumorphic Receipt Badge Button */
	.neu-receipt-btn {
		background: #e6e7ee !important;
		border: 1px solid rgba(255, 255, 255, 0.9) !important;
		box-shadow: 2px 2px 5px #b8b9be, -2px -2px 5px #ffffff !important;
		border-radius: 6px !important;
		padding: 0.15rem 0.55rem !important;
		color: #1e293b !important;
		display: inline-flex !important;
		align-items: center !important;
		font-size: 0.72rem !important;
		font-weight: 700 !important;
		line-height: 1.2 !important;
		cursor: pointer !important;
		transition: transform 0.15s ease, box-shadow 0.15s ease, color 0.15s ease !important;
		vertical-align: middle !important;
		user-select: none !important;
	}

	.neu-receipt-btn:hover {
		transform: translateY(-1px) !important;
		box-shadow: 3px 3px 7px #b8b9be, -3px -3px 7px #ffffff !important;
		color: #2D4CC8 !important;
	}

	.neu-receipt-btn:active {
		transform: scale(0.96) !important;
		box-shadow: inset 1px 1px 3px #b8b9be, inset -1px -1px 3px #ffffff !important;
	}

	#btn-add-transaction-modal:hover,
	#btn-add-transaction-modal:active,
	#btn-add-transaction-modal.pressed,
	.neu-btn-press:hover,
	.neu-btn-press:active,
	.neu-btn-press.pressed {
		box-shadow: inset 3px 3px 6px #b8b9be, inset -3px -3px 6px #ffffff !important;
		transform: scale(0.95) translate3d(0, 2px, 0) !important;
		background-color: #e0e4ee !important;
	}

	/* Subtle Premium Summary KPI Cards Hover Animation (/animate) */
	.kpi-card-animate {
		position: relative;
		overflow: hidden;
		transition: transform 0.25s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.25s cubic-bezier(0.23, 1, 0.32, 1) !important;
		will-change: transform, box-shadow;
		cursor: pointer !important;
	}

	.kpi-card-animate::before {
		content: '';
		position: absolute;
		top: 0;
		left: -100%;
		width: 100%;
		height: 100%;
		background: linear-gradient(90deg,
				rgba(255, 255, 255, 0) 0%,
				rgba(255, 255, 255, 0.12) 50%,
				rgba(255, 255, 255, 0) 100%);
		transform: skewX(-20deg) translate3d(0, 0, 0);
		transition: transform 0.75s cubic-bezier(0.23, 1, 0.32, 1);
		pointer-events: none;
		z-index: 2;
	}

	.kpi-card-animate:hover {
		transform: translate3d(0, -3px, 0) !important;
		box-shadow: 0 14px 28px -4px rgba(15, 23, 42, 0.3) !important;
	}

	.kpi-card-animate:hover::before {
		transform: skewX(-20deg) translate3d(250%, 0, 0);
	}

	.kpi-card-animate:active {
		transform: scale(0.99) translate3d(0, 1px, 0) !important;
		box-shadow: 0 6px 12px -4px rgba(15, 23, 42, 0.2) !important;
	}

	/* =========================================================
	   MOBILE RESPONSIVE TRANSACTION CARDS (@media max-width: 768px)
	   Transforms squished table into an app-like feed on mobile
	   Zero alterations to desktop display (min-width: 769px)
	   ========================================================= */
	@media (max-width: 768px) {
		.card-transaction-table {
			padding: 1.15rem 0.85rem !important;
			border-radius: 1.25rem !important;
		}

		/* Search & Length Controls Layout */
		.dataTables_wrapper .row:first-child {
			display: flex !important;
			flex-direction: column-reverse !important;
			gap: 12px !important;
			margin-bottom: 1.25rem !important;
		}

		.dataTables_wrapper .dataTables_filter {
			width: 100% !important;
			text-align: left !important;
			float: none !important;
		}

		.dataTables_wrapper .dataTables_filter label {
			display: flex !important;
			align-items: center !important;
			width: 100% !important;
			margin-bottom: 0 !important;
			font-size: 0.82rem !important;
			font-weight: 700 !important;
			color: #334155 !important;
			gap: 8px !important;
		}

		.dataTables_wrapper .dataTables_filter input {
			flex: 1 1 0 !important;
			width: 100% !important;
			min-width: 0 !important;
			margin-left: 0 !important;
			height: 42px !important;
			padding: 0.5rem 0.85rem !important;
			font-size: 0.88rem !important;
			background: #dfe4ec !important;
			box-shadow: inset 2px 2px 5px #b8b9be, inset -2px -2px 5px #ffffff !important;
			border: 1px solid rgba(209, 217, 230, 0.9) !important;
			border-radius: 8px !important;
			color: #0f172a !important;
			font-weight: 600 !important;
			outline: none !important;
		}

		.dataTables_wrapper .dataTables_filter input:focus {
			border-color: #2D4CC8 !important;
			box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff, 0 0 0 3px rgba(45, 76, 200, 0.2) !important;
		}

		.dataTables_wrapper .dataTables_length {
			width: 100% !important;
			text-align: left !important;
			float: none !important;
		}

		.dataTables_wrapper .dataTables_length label {
			display: flex !important;
			align-items: center !important;
			justify-content: space-between !important;
			width: 100% !important;
			margin-bottom: 0 !important;
			font-size: 0.82rem !important;
			font-weight: 600 !important;
			color: #64748b !important;
		}

		.dataTables_wrapper .dataTables_length select {
			height: 38px !important;
			min-width: 75px !important;
			background: #dfe4ec !important;
			box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff !important;
			border: 1px solid rgba(209, 217, 230, 0.9) !important;
			border-radius: 8px !important;
			color: #0f172a !important;
			font-weight: 700 !important;
			padding: 0.25rem 0.65rem !important;
			outline: none !important;
		}

		/* Hide the rigid desktop table header on mobile */
		#dataTable thead {
			display: none !important;
		}

		/* Reset table display */
		#dataTable,
		#dataTable tbody {
			display: block !important;
			width: 100% !important;
			border: none !important;
		}

		/* Remove DataTables row striping and hover inset box-shadow on cells in mobile */
		#dataTable tbody tr > *,
		#dataTable tbody tr td,
		#dataTable.table-striped tbody tr.odd > *,
		#dataTable.table-striped tbody tr.even > *,
		#dataTable.table-striped tbody tr:nth-of-type(odd) > *,
		#dataTable.table-striped tbody tr:nth-of-type(even) > *,
		table.dataTable.table-striped > tbody > tr:nth-of-type(odd) > *,
		table.dataTable.table-striped > tbody > tr:nth-of-type(even) > *,
		table.dataTable.table-striped > tbody > tr.odd > *,
		table.dataTable.table-striped > tbody > tr.even > *,
		table.dataTable > tbody > tr > *,
		table.dataTable.table-hover > tbody > tr:hover > * {
			box-shadow: none !important;
			background-color: transparent !important;
			background: transparent !important;
		}

		/* Each row becomes an elevated Neumorphic Card */
		#dataTable tbody tr.transaction-row,
		#dataTable tbody tr {
			display: grid !important;
			grid-template-columns: 1fr auto !important;
			row-gap: 8px !important;
			column-gap: 12px !important;
			align-items: center !important;
			width: 100% !important;
			background: #e6e7ee !important;
			border-radius: 1.15rem !important;
			box-shadow: 4px 4px 10px #b8b9be, -4px -4px 10px #ffffff !important;
			border: 1px solid rgba(255, 255, 255, 0.85) !important;
			margin-bottom: 1rem !important;
			padding: 1.1rem !important;
			transition: transform 0.16s ease !important;
		}

		#dataTable tbody tr:active {
			transform: scale(0.99) !important;
		}

		/* Hide index on mobile cards */
		#dataTable tbody tr td.cell-index,
		#dataTable tbody tr td:nth-child(1) {
			display: none !important;
		}

		/* Date: Top-Left Header */
		#dataTable tbody tr td.cell-date,
		#dataTable tbody tr td:nth-child(2) {
			grid-column: 1 !important;
			grid-row: 1 !important;
			padding: 0 !important;
			border: none !important;
			background: transparent !important;
			font-size: 0.8rem !important;
			font-weight: 700 !important;
			color: #475569 !important;
			display: flex !important;
			align-items: center !important;
		}

		#dataTable tbody tr td.cell-date::before,
		#dataTable tbody tr td:nth-child(2)::before {
			content: '\f073';
			font-family: 'Font Awesome 5 Free';
			font-weight: 400;
			margin-right: 6px;
			font-size: 0.8rem;
			color: #2D4CC8;
		}

		/* Amount: Top-Right (Prominent & Colored) */
		#dataTable tbody tr td.cell-amount,
		#dataTable tbody tr td:nth-child(5) {
			grid-column: 2 !important;
			grid-row: 1 !important;
			padding: 0 !important;
			border: none !important;
			background: transparent !important;
			font-size: 1.2rem !important;
			font-weight: 800 !important;
			text-align: right !important;
			justify-self: end !important;
			white-space: nowrap !important;
			letter-spacing: -0.01em !important;
		}

		/* Details & Category: Middle (Full-Width) */
		#dataTable tbody tr td.cell-details,
		#dataTable tbody tr td:nth-child(4) {
			grid-column: 1 / -1 !important;
			grid-row: 2 !important;
			padding: 4px 0 !important;
			border: none !important;
			background: transparent !important;
		}

		#dataTable tbody tr td.cell-details .tx-desc,
		#dataTable tbody tr td.cell-details .font-weight-bold {
			font-size: 0.92rem !important;
			color: #0f172a !important;
			line-height: 1.35 !important;
			margin-bottom: 3px !important;
		}

		#dataTable tbody tr td.cell-details .tx-cat,
		#dataTable tbody tr td.cell-details .text-xs {
			font-size: 0.76rem !important;
			color: #475569 !important;
			font-weight: 600 !important;
		}

		/* Account & Sub-Account: Bottom-Left */
		#dataTable tbody tr td.cell-account,
		#dataTable tbody tr td:nth-child(3) {
			grid-column: 1 !important;
			grid-row: 3 !important;
			padding: 8px 0 0 0 !important;
			border-top: 1px solid rgba(203, 213, 225, 0.8) !important;
			background: transparent !important;
			font-size: 0.8rem !important;
			color: #334155 !important;
			display: flex !important;
			align-items: center !important;
			flex-wrap: wrap !important;
			gap: 4px !important;
		}

		#dataTable tbody tr td.cell-account::before,
		#dataTable tbody tr td:nth-child(3)::before {
			content: '\f555';
			font-family: 'Font Awesome 5 Free';
			font-weight: 900;
			margin-right: 5px;
			font-size: 0.78rem;
			color: #64748b;
		}

		/* Running Balance: Bottom-Right */
		#dataTable tbody tr td.cell-balance,
		#dataTable tbody tr td:nth-child(6) {
			grid-column: 2 !important;
			grid-row: 3 !important;
			padding: 8px 0 0 0 !important;
			border-top: 1px solid rgba(203, 213, 225, 0.8) !important;
			background: transparent !important;
			font-size: 0.84rem !important;
			font-weight: 800 !important;
			color: #0f172a !important;
			text-align: right !important;
			justify-self: end !important;
			white-space: nowrap !important;
		}

		#dataTable tbody tr td.cell-balance::before,
		#dataTable tbody tr td:nth-child(6)::before {
			content: 'Bal: ';
			font-size: 0.7rem;
			font-weight: 700;
			color: #64748b;
			text-transform: uppercase;
			letter-spacing: 0.04em;
			margin-right: 3px;
		}

		/* Handle empty table state */
		#dataTable tbody tr td.dataTables_empty {
			grid-column: 1 / -1 !important;
			text-align: center !important;
			padding: 2rem 1rem !important;
			font-weight: 600 !important;
			color: #64748b !important;
			border: none !important;
		}

		/* Pagination controls on mobile */
		.dataTables_wrapper .row:last-child {
			display: flex !important;
			flex-direction: column !important;
			align-items: center !important;
			gap: 12px !important;
			margin-top: 1.25rem !important;
		}

		.dataTables_wrapper .dataTables_info {
			text-align: center !important;
			font-size: 0.8rem !important;
			font-weight: 600 !important;
			color: #64748b !important;
			padding-top: 0 !important;
			width: 100% !important;
		}

		.dataTables_wrapper .dataTables_paginate {
			display: flex !important;
			justify-content: center !important;
			width: 100% !important;
		}

		.dataTables_wrapper .dataTables_paginate .pagination {
			display: flex !important;
			gap: 6px !important;
			justify-content: center !important;
			flex-wrap: wrap !important;
			margin: 0 !important;
		}

		.dataTables_wrapper .dataTables_paginate .page-item .page-link {
			border-radius: 8px !important;
			background: #e6e7ee !important;
			box-shadow: 2px 2px 5px #b8b9be, -2px -2px 5px #ffffff !important;
			border: 1px solid rgba(255, 255, 255, 0.9) !important;
			color: #1e293b !important;
			font-weight: 700 !important;
			font-size: 0.82rem !important;
			padding: 0.45rem 0.85rem !important;
		}

		.dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
			background: #2D4CC8 !important;
			color: #ffffff !important;
			box-shadow: 2px 2px 6px rgba(45, 76, 200, 0.4) !important;
			border-color: #2D4CC8 !important;
		}
	}
</style>
<div class="section bg-primary text-dark section-lg py-4 py-md-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">

				<!-- Module Header Title & Action Bar -->
				<div class="mb-4">
					<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
						<div>
							<h1 class="h3 font-weight-bold text-dark mb-1">Transaction Page</h1>
							<p class="text-gray-500 mb-0 font-weight-normal">Overview of financial activity across your accounts and sub-accounts</p>
						</div>
						<div class="mt-3 mt-md-0">
							<button
								class="btn btn-primary btn-pill shadow-soft border-light px-4 py-2 font-weight-bold d-inline-flex align-items-center neu-btn-press"
								type="button" id="btn-add-transaction-modal">
								<span class="fas fa-plus mr-2 text-primary-dark"></span> Add Transaction
							</button>
						</div>
					</div>
				</div>

				<!-- Summary KPI Cards -->
				<div class="row mb-4">

							<!-- Inflow Card (Dark Emerald Gradient) -->
							<div class="col-12 col-md-4 mb-3 mb-md-0">
								<div class="card border-0 rounded-2xl p-4 position-relative text-white overflow-hidden shadow-lg h-100 kpi-card-animate"
									style="background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #022c22 100%); box-shadow: 0 10px 25px -5px rgba(6, 78, 59, 0.4);">
									<div class="d-flex align-items-center justify-content-between mb-3">
										<span class="uppercase tracking-wider text-xs"
											style="font-size: 0.72rem; color: #6ee7b7; font-weight: 600;">TOTAL INFLOW
											(<strong class="text-white font-weight-black"
												style="font-size: 0.88rem; letter-spacing: 0.05em;">DEBITS</strong>)</span>
										<div class="d-flex align-items-center justify-content-center rounded-circle"
											style="width: 32px; height: 32px; background: rgba(255,255,255,0.15);">
											<i class="fas fa-arrow-down text-white" style="font-size: 0.95rem;"></i>
										</div>
									</div>
									<div class="mt-auto">
										<h3 class="font-weight-black mb-0 font-fira-code text-white" id="stat-inflow"
											style="font-size: 1.5rem;">+₱0.00</h3>
									</div>
								</div>
							</div>

							<!-- Outflow Card (Dark Ruby/Crimson Gradient) -->
							<div class="col-12 col-md-4 mb-3 mb-md-0">
								<div class="card border-0 rounded-2xl p-4 position-relative text-white overflow-hidden shadow-lg h-100 kpi-card-animate"
									style="background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 50%, #450a0a 100%); box-shadow: 0 10px 25px -5px rgba(127, 29, 29, 0.4);">
									<div class="d-flex align-items-center justify-content-between mb-3">
										<span class="uppercase tracking-wider text-xs"
											style="font-size: 0.72rem; color: #fca5a5; font-weight: 600;">TOTAL OUTFLOW
											(<strong class="text-white font-weight-black"
												style="font-size: 0.88rem; letter-spacing: 0.05em;">CREDITS</strong>)</span>
										<div class="d-flex align-items-center justify-content-center rounded-circle"
											style="width: 32px; height: 32px; background: rgba(255,255,255,0.15);">
											<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
												viewBox="0 0 16 16" fill="none" stroke="#ffffff" stroke-width="2"
												stroke-linecap="round" stroke-linejoin="round">
												<path d="m3.75 7.25l4.5-4.5l4.5 4.5m-4.5 6V2.75" />
											</svg>
										</div>
									</div>
									<div class="mt-auto">
										<h3 class="font-weight-black mb-0 font-fira-code text-white" id="stat-outflow"
											style="font-size: 1.5rem;">-₱0.00</h3>
									</div>
								</div>
							</div>

							<!-- Net Balance Card (Dark Royal Navy/Indigo Gradient) -->
							<div class="col-12 col-md-4">
								<div class="card border-0 rounded-2xl p-4 position-relative text-white overflow-hidden shadow-lg h-100 kpi-card-animate"
									style="background: linear-gradient(135deg, #1e1b4b 0%, #1e3a8a 50%, #0f172a 100%); box-shadow: 0 10px 25px -5px rgba(30, 27, 75, 0.4);">
									<div class="d-flex align-items-center justify-content-between mb-3">
										<span class="font-weight-black uppercase tracking-wider text-xs"
											style="font-size: 0.72rem; color: #a5b4fc;">NET LEDGER BALANCE</span>
										<div class="d-flex align-items-center justify-content-center rounded-circle"
											style="width: 32px; height: 32px; background: rgba(255,255,255,0.15);">
											<i class="fas fa-wallet text-white" style="font-size: 0.95rem;"></i>
										</div>
									</div>
									<div class="mt-auto">
										<h3 class="font-weight-black mb-0 font-fira-code text-white"
											id="stat-net-balance" style="font-size: 1.5rem;">₱0.00</h3>
									</div>
								</div>
							</div>

						</div>

						<!-- Master Transactions Data Table -->
						<div class="card bg-primary border-light shadow-soft rounded-2xl p-4 card-transaction-table">
							<div class="table-responsive-sm">
								<table id="dataTable" class="table table-striped w-100 align-items-center">
									<thead>
										<tr>
											<th class="border-0 rounded-start">#</th>
											<th class="border-0">Date</th>
											<th class="border-0">Account & Sub-Account</th>
											<th class="border-0">Details & Category</th>
											<th class="border-0">Amount</th>
											<th class="border-0 rounded-end">Running Balance</th>
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

	<script>
		window.WEB_ROOT = "<?= WEB_ROOT; ?>";

		document.addEventListener("DOMContentLoaded", function () {
			// Add Transaction Modal Trigger with Tactile Press Animation (/animate)
			$('#btn-add-transaction-modal').on('click', function (e) {
				e.preventDefault();
				const $btn = $(this);
				$btn.addClass('pressed');
				setTimeout(function () {
					$btn.removeClass('pressed');
					$('#modal-transaction').modal('show');
				}, 130);
			});
		});
	</script>
	<script src="<?= WEB_ROOT; ?>assets/js/imageViewer.js"></script>
	<script src="<?= WEB_ROOT; ?>assets/js/formatNumber.js"></script>
	<script src="<?= WEB_ROOT; ?>assets/js/setUpValidation.js"></script>
	<script src="<?= WEB_ROOT; ?>assets/js/sweetAlert.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			let accountsData = [];
			let currentAccountId = sessionStorage.getItem('a_id') || 'all';
			let currentSubAccountId = sessionStorage.getItem('sa_id') || 'all';

			// Handle full dropzone attachment preview & click-to-enlarge viewer
			function handleFilePreview(inputId, previewId) {
				const fileInput = document.getElementById(inputId);
				const previewContainer = document.getElementById(previewId);
				if (!fileInput || !previewContainer) return;

				const dropzone = fileInput.closest('.custom-file-dropzone');
				const dropzoneContent = dropzone ? dropzone.querySelector('.dropzone-content') : null;

				fileInput.addEventListener('change', function () {
					previewContainer.innerHTML = '';
					const files = Array.from(this.files);

					if (files.length === 0) {
						if (dropzoneContent) dropzoneContent.style.display = 'block';
						return;
					}

					if (dropzoneContent) dropzoneContent.style.display = 'none';

					const wrapper = document.createElement('div');
					wrapper.className = 'd-flex flex-wrap align-items-center justify-content-center gap-3 p-2 w-100 position-relative';
					wrapper.style.zIndex = '15';

					files.forEach((file) => {
						const previewCard = document.createElement('div');
						previewCard.className = 'position-relative rounded-2xl overflow-hidden shadow-sm border border-white/60 p-2 text-center bg-white';
						previewCard.style.cssText = 'min-width: 150px; max-width: 100%; transition: all 0.2s ease;';

						if (file.type.startsWith('image/')) {
							const reader = new FileReader();
							reader.onload = function (e) {
								previewCard.innerHTML = `
								<div class="position-relative overflow-hidden rounded-xl mb-2 preview-img-trigger" style="height: 110px; cursor: pointer;" title="Click to enlarge preview">
									<img src="${e.target.result}" class="w-100 h-100" style="object-fit: cover; border-radius: 8px;">
									<div class="position-absolute w-100 h-100 top-0 left-0 d-flex align-items-center justify-content-center text-white" style="background: rgba(0,0,0,0.35); opacity: 0; transition: opacity 0.2s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
										<i class="fas fa-search-plus" style="font-size: 1.4rem;"></i>
									</div>
								</div>
								<div class="d-flex align-items-center justify-content-between px-1">
									<span class="text-truncate font-weight-bold text-dark text-xs" style="max-width: 100px;" title="${file.name}">${file.name}</span>
									<span class="text-muted text-xs">(${(file.size / 1024).toFixed(1)} KB)</span>
								</div>
							`;

								previewCard.querySelector('.preview-img-trigger').addEventListener('click', function (evt) {
									evt.stopPropagation();
									if (typeof openViewer === 'function') {
										openViewer(e.target.result);
									}
								});
							};
							reader.readAsDataURL(file);
						} else {
							let iconClass = 'fa-file-alt text-secondary';
							if (file.type === 'application/pdf') iconClass = 'fa-file-pdf text-danger';

							previewCard.innerHTML = `
							<div class="py-3 px-2 d-flex flex-column align-items-center justify-content-center">
								<i class="fas ${iconClass} mb-2" style="font-size: 2rem;"></i>
								<span class="text-truncate font-weight-bold text-dark text-xs w-100" title="${file.name}">${file.name}</span>
								<span class="text-muted text-xs mt-1">(${(file.size / 1024).toFixed(1)} KB)</span>
							</div>
						`;
						}

						wrapper.appendChild(previewCard);
					});

					// Clear/Remove File Button
					const actionWrapper = document.createElement('div');
					actionWrapper.className = 'w-100 text-center mt-2';
					const clearBtn = document.createElement('button');
					clearBtn.type = 'button';
					clearBtn.className = 'btn btn-xs btn-outline-danger rounded-pill px-3 py-1 font-weight-bold';
					clearBtn.style.zIndex = '16';
					clearBtn.innerHTML = '<i class="fas fa-trash-alt mr-1"></i> Remove File';
					clearBtn.addEventListener('click', function (e) {
						e.stopPropagation();
						fileInput.value = '';
						previewContainer.innerHTML = '';
						if (dropzoneContent) dropzoneContent.style.display = 'block';
					});

					actionWrapper.appendChild(clearBtn);
					wrapper.appendChild(actionWrapper);
					previewContainer.appendChild(wrapper);
				});
			}

			handleFilePreview('transactionAttachment', 'transactionPreview');

			// Set default transaction date to today (YYYY-MM-DD)
			const today = new Date();
			const month = String(today.getMonth() + 1).padStart(2, '0');
			const day = String(today.getDate()).padStart(2, '0');
			const year = today.getFullYear();
			const todayFormatted = `${year}-${month}-${day}`;
			if (document.getElementById('transactionDate')) {
				document.getElementById('transactionDate').value = todayFormatted;
			}

			// Load Category Options for Modal
			function loadCategoryOptions() {
				fetch('process.php?action=categories')
					.then(res => res.json())
					.then(res => {
						const select = $('#transactionCategory');
						select.html('<option value="" disabled selected>Choose category...</option>');
						if (res.status && Array.isArray(res.data)) {
							res.data.forEach(cat => {
								select.append(`<option value="${cat.c_id}">${cat.category_name}</option>`);
							});
						}
					})
					.catch(err => console.error('Error loading category options:', err));
			}
			loadCategoryOptions();

			// Load Account and Sub-Account options
			function loadAccountOptions() {
				fetch('process.php?action=fetch_account_options')
					.then(res => res.json())
					.then(res => {
						if (res.status && Array.isArray(res.data)) {
							accountsData = res.data;
							syncModalHiddenInputs();
						}
					})
					.catch(err => console.error('Error loading account options:', err));
			}

			function syncModalHiddenInputs() {
				const hiddenA = document.getElementById('transaction-a-id');
				const hiddenSa = document.getElementById('transaction-sa-id');

				let targetAId = currentAccountId;
				let targetSaId = currentSubAccountId;

				if ((targetAId === 'all' || !targetAId) && accountsData.length > 0) {
					targetAId = accountsData[0].a_id;
				}

				if ((targetSaId === 'all' || !targetSaId) && accountsData.length > 0) {
					const targetAcc = accountsData.find(a => a.a_id == targetAId) || accountsData[0];
					if (targetAcc && Array.isArray(targetAcc.sub_accounts) && targetAcc.sub_accounts.length > 0) {
						targetSaId = targetAcc.sub_accounts[0].sa_id;
					}
				}

				if (hiddenA) hiddenA.value = targetAId || '';
				if (hiddenSa) hiddenSa.value = targetSaId || '';
			}

			$('#modal-transaction').on('show.bs.modal', function () {
				syncModalHiddenInputs();
				loadCategoryOptions();
			});

			function loadTransactionTable() {
				if ($.fn.DataTable.isDataTable('#dataTable')) {
					$('#dataTable').DataTable().clear().destroy();
				}

				// Render skeleton loading shimmer placeholders
				document.getElementById('stat-inflow').innerHTML = '<span class="skeleton-line" style="width: 90px; height: 1.5rem;"></span>';
				document.getElementById('stat-outflow').innerHTML = '<span class="skeleton-line" style="width: 90px; height: 1.5rem;"></span>';
				document.getElementById('stat-net-balance').innerHTML = '<span class="skeleton-line" style="width: 90px; height: 1.5rem;"></span>';

				const tbody = $('#dataTable tbody');
				tbody.html(`
				<tr class="transaction-row">
					<td class="cell-index"><span class="skeleton-dark-line" style="width: 18px;"></span></td>
					<td class="cell-date"><span class="skeleton-dark-line" style="width: 75px;"></span></td>
					<td class="cell-account"><span class="skeleton-dark-line" style="width: 140px;"></span></td>
					<td class="cell-details"><span class="skeleton-dark-line" style="width: 170px;"></span></td>
					<td class="cell-amount"><span class="skeleton-dark-line" style="width: 70px;"></span></td>
					<td class="cell-balance"><span class="skeleton-dark-line" style="width: 85px;"></span></td>
				</tr>
				<tr class="transaction-row">
					<td class="cell-index"><span class="skeleton-dark-line" style="width: 18px;"></span></td>
					<td class="cell-date"><span class="skeleton-dark-line" style="width: 75px;"></span></td>
					<td class="cell-account"><span class="skeleton-dark-line" style="width: 140px;"></span></td>
					<td class="cell-details"><span class="skeleton-dark-line" style="width: 170px;"></span></td>
					<td class="cell-amount"><span class="skeleton-dark-line" style="width: 70px;"></span></td>
					<td class="cell-balance"><span class="skeleton-dark-line" style="width: 85px;"></span></td>
				</tr>
				<tr class="transaction-row">
					<td class="cell-index"><span class="skeleton-dark-line" style="width: 18px;"></span></td>
					<td class="cell-date"><span class="skeleton-dark-line" style="width: 75px;"></span></td>
					<td class="cell-account"><span class="skeleton-dark-line" style="width: 140px;"></span></td>
					<td class="cell-details"><span class="skeleton-dark-line" style="width: 170px;"></span></td>
					<td class="cell-amount"><span class="skeleton-dark-line" style="width: 70px;"></span></td>
					<td class="cell-balance"><span class="skeleton-dark-line" style="width: 85px;"></span></td>
				</tr>
			`);

				const aId = currentAccountId || 'all';
				const saId = currentSubAccountId || 'all';
				const type = 'all';

				fetch(`process.php?action=fetch_transaction&a_id=${encodeURIComponent(aId)}&sa_id=${encodeURIComponent(saId)}&type=${encodeURIComponent(type)}`)
					.then(response => response.json())
					.then(res => {
						setTimeout(() => {
							tbody.empty();

							let transactions = [];
							if (res.status && Array.isArray(res.data)) {
								transactions = res.data;
							} else if (Array.isArray(res)) {
								transactions = res; // fallback
							}

							// Update Summary KPI Metrics with smooth crossfade (/animate)
							if (res.summary) {
								const inEl = document.getElementById('stat-inflow');
								const outEl = document.getElementById('stat-outflow');
								const netEl = document.getElementById('stat-net-balance');

								if (inEl) {
									inEl.className = 'font-weight-black mb-0 font-fira-code text-white content-fade-in';
									inEl.textContent = '+₱' + Number(res.summary.total_inflow).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
								}
								if (outEl) {
									outEl.className = 'font-weight-black mb-0 font-fira-code text-white content-fade-in';
									outEl.textContent = '-₱' + Number(res.summary.total_outflow).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
								}
								if (netEl) {
									netEl.className = 'font-weight-black mb-0 font-fira-code text-white content-fade-in';
									const netVal = Number(res.summary.net_balance);
									netEl.textContent = (netVal < 0 ? '-₱' : '₱') + Math.abs(netVal).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
								}
							}

							if (transactions.length > 0) {
								let balance = 0;
								// Step 1: Compute running balance chronologically
								const calculatedRows = transactions.map((transaction) => {
									const amount = Number(transaction.amount || 0);
									const isOut = transaction.type == 1;
									if (isOut) {
										balance -= amount;
									} else {
										balance += amount;
									}
									return {
										transaction: transaction,
										amount: amount,
										isOut: isOut,
										runningBalance: balance
									};
								});

								// Step 2: Reverse array so newest entries show at top
								const reversedRows = calculatedRows.reverse();

								reversedRows.forEach((row, index) => {
									const t = row.transaction;
									const accLabel = t.account_name ? `${$('<span>').text(t.account_name).html()} <span class="text-gray-400">/</span> <strong class="text-dark">${$('<span>').text(t.sub_account_name || '').html()}</strong>` : '-';

									let attachmentBadge = '';
									if (t.attachments && t.attachments.length > 0) {
										const count = t.attachments.length;
										const firstImg = t.attachments[0];
										const attachmentsJson = encodeURIComponent(JSON.stringify(t.attachments));
										attachmentBadge = `
											<button type="button" class="neu-receipt-btn ml-1" data-attachments="${attachmentsJson}" data-url="${firstImg.url}" data-ext="${firstImg.ext}" title="View ${count} Receipt(s)">
												<i class="fas fa-receipt mr-1" style="color: #2D4CC8;"></i>
												<span>${count > 1 ? count + ' Receipts' : 'Receipt'}</span>
											</button>
										`;
									}

									tbody.append(`
								<tr class="transaction-row">
									<td class="cell-index">${index + 1}</td>

									<td class="cell-date">${formatDate(t.tt_date || '')}</td>

									<td class="cell-account">${accLabel}</td>

									<td class="cell-details">
										<div class="font-weight-bold tx-desc">${$('<span>').text(t.description || '').html()}</div>
										<div class="text-xs text-gray-500 my-1 tx-cat">${$('<span>').text(t.category_name || '').html()}</div>
										<div class="d-flex align-items-center flex-wrap" style="gap: 6px;">
											<span class="badge ${row.isOut ? 'badge-danger' : 'badge-success'} tx-badge">
												${row.isOut ? 'OUT (Credit)' : 'IN (Debit)'}
											</span>
											${attachmentBadge}
										</div>
									</td>

									<td class="cell-amount ${row.isOut ? 'text-danger font-weight-bold' : 'text-success font-weight-bold'}">
										${row.isOut ? '-' : '+'}${row.amount.toLocaleString('en-US', {
										minimumFractionDigits: 2,
										maximumFractionDigits: 2
									})}
									</td>

									<td class="cell-balance font-weight-bold text-dark">
										₱${row.runningBalance.toLocaleString('en-US', {
										minimumFractionDigits: 2,
										maximumFractionDigits: 2
									})}
									</td>
								</tr>
							`);
								});
							}

							// Initialize DataTable
							$('#dataTable').DataTable({
								pageLength: 10,
								responsive: true,
								destroy: true,
								language: {
									search: "Search:",
									lengthMenu: "Show _MENU_ entries",
									info: "Showing _START_ to _END_ of _TOTAL_ entries",
									paginate: {
										first: "First",
										last: "Last",
										next: "Next",
										previous: "Previous"
									}
								}
							});
						}, 350);
					})
					.catch(error => {
						console.error('Error fetching transactions:', error);
					});
			}

			function formatDate(dateStr) {
				const date = new Date(dateStr);
				if (isNaN(date)) return dateStr;
				return date.toLocaleDateString('en-US', {
					month: 'short',
					day: '2-digit',
					year: 'numeric'
				});
			}

			// Initial loads
			loadAccountOptions();
			loadTransactionTable();

			// Expose globally
			window.loadTransactionTable = loadTransactionTable;

			// Click handler to view transaction receipts
			$(document).on('click', '.neu-receipt-btn', function (e) {
				e.preventDefault();
				e.stopPropagation();

				const rawData = $(this).attr('data-attachments');
				let attachments = [];
				try {
					attachments = JSON.parse(decodeURIComponent(rawData));
				} catch (err) {
					const fallbackUrl = $(this).data('url');
					const fallbackExt = $(this).data('ext');
					if (fallbackUrl) attachments = [{ url: fallbackUrl, ext: fallbackExt }];
				}

				if (!attachments.length) return;

				if (attachments.length === 1) {
					const file = attachments[0];
					if (file.ext === 'pdf') {
						window.open(file.url, '_blank');
					} else if (typeof openViewer === 'function') {
						openViewer(file.url);
					} else {
						window.open(file.url, '_blank');
					}
				} else {
					let modalHtml = '<div class="d-flex flex-wrap justify-content-center p-2" style="gap: 12px;">';
					attachments.forEach((att, i) => {
						if (att.ext === 'pdf') {
							modalHtml += `<a href="${att.url}" target="_blank" class="btn btn-sm btn-primary d-inline-flex align-items-center"><i class="fas fa-file-pdf mr-1"></i> Document ${i + 1}</a>`;
						} else {
							modalHtml += `<div class="position-relative" style="cursor: pointer;" onclick="openViewer('${att.url}'); Swal.close();"><img src="${att.url}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px; border: 2px solid #2D4CC8; box-shadow: 0 4px 10px rgba(0,0,0,0.15);" title="Click to enlarge"><div class="text-xs text-muted text-center mt-1">Receipt ${i + 1}</div></div>`;
						}
					});
					modalHtml += '</div>';

					Swal.fire({
						title: 'Attached Receipts',
						html: modalHtml,
						showConfirmButton: false,
						showCloseButton: true,
						customClass: {
							popup: 'rounded-2xl'
						}
					});
				}
			});
		});
	</script>