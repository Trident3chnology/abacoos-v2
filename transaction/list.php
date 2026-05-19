<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

include 'modal-transaction.php';
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
								<li class="breadcrumb-item"><a id="account-name" href="../sub-account"></a></li>
								<li class="breadcrumb-item active" aria-current="page"><a id="sub-account-name"
										href="../transaction"></a></li>
							</ol>
						</nav>
					</div>
					<div class="card mb-3 d-flex align-items-end justify-content-end">
						<button class="btn btn-icon-only btn-pill btn-primary" type="button"
							aria-label="Add sub-account" title="Add sub-account" data-toggle="modal"
							data-target="#modal-transaction">
							<span aria-hidden="true" class="fas fa-plus"></span>
						</button>
					</div>

					<div class="table-responsive-sm shadow-soft card">
						<table id="dataTable" class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Details</th>
									<th>Amount</th>
									<th>Balance</th>
									<th>Edit</th>
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

<script src="<?= WEB_ROOT; ?>assets/js/imageViewer.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/formatNumber.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/setUpValidation.js"></script>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		// EDIT SUB-ACCOUNT
		setupValidation(
			"editSubAccountName",
			"editSubAccountNameFeedback",
			(value) => {
				const saId = document.getElementById("sa_id").value;
				const aId = document.getElementById("edit-a-id").value;
				return `process.php?action=check_edit_sub_account_name&editSubAccountName=${encodeURIComponent(value)}&saId=${encodeURIComponent(saId)}&aId=${encodeURIComponent(aId)}`;
			}
		);

	});

	$('#modal-edit-sub-account').on('show.bs.modal', function (event) {
		const button = $(event.relatedTarget);

		const modal = $(this);
		modal.find('#sa_id').val(button.data('sa-id'));
		modal.find('#editSubAccountName').val(button.data('sub-account-name')).trigger('input');
		modal.find('#editSubAccountNumber').val(button.data('sub-account-number')).trigger('input');
	});

	// CATEGORIES (for both Transaction and Transfer)
	async function loadCategories() {
		try {
			const res = await fetch('process.php?action=categories');
			const data = await res.json();

			if (!data.status) return;

			const transactionSelect = document.getElementById('transactionCategory');
			// const transferSelect = document.getElementById('transferCategory');

			populateSelect(transactionSelect, data.data);
			// populateSelect(transferSelect, data.data);

			// ✅ init AFTER options are loaded
			initSelect2();

		} catch (error) {
			console.error('Error loading categories:', error);
		}
	}

	document.addEventListener('DOMContentLoaded', loadCategories);

	function populateSelect(select, data) {
		select.innerHTML = '<option value="" disabled selected>Choose...</option>';

		data.forEach(cat => {
			const option = document.createElement('option');
			option.value = cat.c_id;
			option.textContent = cat.category_name;
			select.appendChild(option);
		});
	}

	function initSelect2() {
		// $('#transactionCategory, #transferCategory').select2({
		$('#transactionCategory').select2({
			placeholder: "Choose or type category",
			allowClear: true,
			tags: true, // 🔥 allows typing new values
			width: '100%'
		});
	}

	document.addEventListener('DOMContentLoaded', loadCategories);

	// Attachment filename display
	function handleFilePreview(inputId, previewId) {
		const input = document.getElementById(inputId);
		const preview = document.getElementById(previewId);

		let fileStore = new DataTransfer(); // holds current files

		input.addEventListener('change', function () {
			const newFiles = Array.from(this.files);

			// add new files to store
			newFiles.forEach(file => fileStore.items.add(file));

			renderPreview();
			input.files = fileStore.files; // sync back
		});

		function renderPreview() {
			preview.innerHTML = '';
			preview.classList.add('bento-grid');

			const files = Array.from(fileStore.files);

			// update label
			const label = input.nextElementSibling;
			label.textContent = files.length
				? `${files.length} file(s) selected`
				: 'Choose files';

			files.forEach((file, index) => {
				const reader = new FileReader();
				const item = document.createElement('div');
				item.className = 'bento-item';

				item.style.animationDelay = `${index * 0.05}s`;

				// remove button
				const removeBtn = document.createElement('span');
				removeBtn.innerHTML = '✕';

				removeBtn.addEventListener('click', () => {
					removeFile(index);
				});

				if (file.type.startsWith('image/')) {
					reader.onload = function (e) {
						item.innerHTML = `
							<img src="${e.target.result}" style="cursor:pointer;">
							<div class="bento-file">${file.name}</div>
						`;

						// click to open fullscreen
						item.querySelector('img').addEventListener('click', () => {
							openViewer(e.target.result);
						});

						item.appendChild(removeBtn);
					};
					reader.readAsDataURL(file);

				} else {
					item.innerHTML = `
					<div class="bento-icon">📄</div>
					<div class="bento-file">${file.name}</div>
				`;
					item.appendChild(removeBtn);
				}

				preview.appendChild(item);
			});
		}

		function removeFile(index) {
			const items = preview.querySelectorAll('.bento-item');
			const target = items[index];

			// animate out
			target.style.transition = '0.25s ease';
			target.style.opacity = '0';
			target.style.transform = 'scale(0.8)';

			setTimeout(() => {
				const dt = new DataTransfer();
				const files = Array.from(fileStore.files);

				files.splice(index, 1);

				files.forEach(file => dt.items.add(file));
				fileStore = dt;

				input.files = fileStore.files;
				renderPreview();
			}, 200);
		}
	}

	// init
	handleFilePreview('transactionAttachment', 'transactionPreview');
	// handleFilePreview('transferAttachment', 'transferPreview');

	$(function () {
		// ✅ STEP 1: Get data from URL FIRST
		const accountId = sessionStorage.getItem('a_id');
		const accountName = sessionStorage.getItem('account_name');
		const subAccountId = sessionStorage.getItem('sa_id');
		const subAccountName = sessionStorage.getItem('sub_account_name');

		const today = new Date();

		const month = String(today.getMonth() + 1).padStart(2, '0');
		const day = String(today.getDate()).padStart(2, '0');
		const year = today.getFullYear();

		if (accountId && subAccountId) {
			// display or use it
			document.getElementById('account-name').textContent = accountName;
			document.getElementById('sub-account-name').textContent = subAccountName;

			// Transaction
			document.getElementById('transactionDate').value = `${month}/${day}/${year}`;
			document.getElementById('transaction-a-id').value = accountId;
			document.getElementById('transaction-sa-id').value = subAccountId;

			document.getElementById('edit-a-id').value = accountId; // Modal Edit
		}

		function loadTransactionTable() {
			if ($.fn.DataTable.isDataTable('#dataTable')) {
				$('#dataTable').DataTable().clear().destroy();
			}
			fetch('process.php?action=fetch_transaction' + '&a_id=' + encodeURIComponent(accountId) + '&sa_id=' + encodeURIComponent(subAccountId))
				.then(response => response.json())
				.then(transactions => {
					const tbody = $('#dataTable tbody');
					tbody.empty();

					if (transactions.length > 0) {
						let balance = 0;
						transactions.forEach((transaction, index) => {
							const amount = Number(transaction.amount || 0);
							const isOut = transaction.type == 1;

							// Running balance (correct ledger logic)
							if (isOut) {
								balance -= amount;
							} else {
								balance += amount;
							}

							tbody.append(`
								<tr>
									<td>${index + 1}</td>

									<td>${formatDate(transaction.tt_date || '')}</td>

									<td>
										${$('<span>').text(transaction.description || '').html()}
										<br><br>
										${$('<span>').text(transaction.category_name || '').html()}
										<br>
										<span class="badge ${isOut ? 'badge-danger' : 'badge-success'}">
											${isOut ? 'OUT (Credit)' : 'IN (Debit)'}
										</span>
									</td>

									<td class="${isOut ? 'text-danger' : 'text-success'}">
										${isOut ? '-' : '+'}${amount.toLocaleString('en-US', {
													minimumFractionDigits: 2,
													maximumFractionDigits: 2
												})}
									</td>

									<td>
										${balance.toLocaleString('en-US', {
													minimumFractionDigits: 2,
													maximumFractionDigits: 2
												})}
									</td>

									<td></td>
									<td></td>

								</tr>
							`);
						});
					}

					// Initialize DataTable
					$('#dataTable').DataTable({
						pageLength: 10,
						responsive: true,
						destroy: true, // extra safety
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
				})
				.catch(error => {
					console.error('Error fetching accounts:', error);
				});
		}

		// DELETE SUB-ACCOUNT (Event Delegation)
		$(document).on('click', '.delete-sub-account', function () {
			const sa_id = $(this).data('id');

			Swal.fire({
				icon: 'question', // 'success', 'error', 'warning', 'info', 'question'
				title: 'Are you sure?',
				text: "This action cannot be undone!",
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#6c757d',
				confirmButtonText: 'Yes, delete it!',
				background: '#e0e5ec',
				customClass: {
					popup: 'neu-popup',
					title: 'neu-title',
					confirmButton: 'neu-btn',
					cancelButton: 'neu-btn'
				},
				buttonsStyling: false
			}).then((result) => {
				if (result.isConfirmed) {

					fetch('process.php?action=delete', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json'
						},
						body: JSON.stringify({ sa_id: sa_id })
					})
						.then(response => response.json())
						.then(data => {
							if (data.status) {
								Swal.fire({
									icon: 'success', // 'success', 'error', 'warning', 'info', 'question'
									title: 'Deleted!',
									text: 'Sub-account has been deleted.',
									timer: 2500,
									showConfirmButton: false,
									background: '#e0e5ec',
									customClass: {
										popup: 'neu-popup',
										title: 'neu-title',
										confirmButton: 'neu-btn',
										cancelButton: 'neu-btn'
									},
									buttonsStyling: false
								});

								loadTransactionTable(); // reload table
							} else {
								Swal.fire('Error', data.message || 'Delete failed', 'error');
							}
						})
						.catch(error => {
							console.error('Delete error:', error);
							Swal.fire('Error', 'Something went wrong', 'error');
						});
				}
			});
		});

		let isRedirecting = false;

		$(document).on('click', '.transaction', function (e) {
			// Clear any previous account ID on load
			sessionStorage.removeItem('sa_id');
			sessionStorage.removeItem('sub_account_name');

			// 🛑 Prevent modal trigger click (3 dots or inside button)
			if ($(e.target).closest('[data-toggle="modal"]').length) return;

			if (isRedirecting) return; // prevent double click spam
			isRedirecting = true;

			const subAccountId = $(this).data('sa-id');
			const subAccountName = $(this).data('sub-account-name');

			if (!subAccountId) {
				isRedirecting = false;
				return;
			}

			// 💡 Optional: add click feedback
			$(this).addClass('active');

			sessionStorage.setItem('sa_id', subAccountId);
			sessionStorage.setItem('sub_account_name', subAccountName);

			// slight delay for UX feel
			setTimeout(() => {
				window.location.href = `../transaction/`;
			}, 100);
		});


		function formatDate(dateStr) {
			const date = new Date(dateStr);
			if (isNaN(date)) return dateStr;
			return date.toLocaleDateString('en-US', {
				month: 'short',   // M
				day: '2-digit',   // d
				year: 'numeric'  // Y
			});
		}

		// Load on page ready
		loadTransactionTable();

		// Expose globally so it can be called after invite
		window.loadTransactionTable = loadTransactionTable;
	});
</script>
<script src="<?= WEB_ROOT; ?>assets/js/formSubmitLoader.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/sweetAlert.js"></script>