"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // ADD SUB-ACCOUNT
    setupValidation(
        "addSubAccountName",
        "addSubAccountNameFeedback",
        (value) => {
            const aId = sessionStorage.getItem('a_id');
            return `process.php?action=check_add_sub_account_name&addSubAccountName=${encodeURIComponent(value)}&aId=${encodeURIComponent(aId)}`;
        }
    );

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

function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

$(function () {
    // ✅ STEP 1: Get data from URL FIRST
    const accountId = sessionStorage.getItem('a_id');
    const accountName = sessionStorage.getItem('account_name');

    if (accountId) {
        // display or use it
        document.getElementById('account-name').textContent = accountName;
        
        document.getElementById('add-a-id').value = accountId; // Modal Add
        document.getElementById('edit-a-id').value = accountId; // Modal Edit
    }

    function loadSubAccountTable() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().clear().destroy();
        }
        fetch('process.php?action=fetch_sub_account' + '&a_id=' + encodeURIComponent(accountId))
            .then(response => response.json())
            .then(subAccounts => {
                const tbody = $('#dataTable tbody');
                tbody.empty();

                if (subAccounts.length > 0) {
                    subAccounts.forEach((subAccount, index) => {
                        const name = $('<span>').text(subAccount.sub_account_name || '').html();

                        tbody.append(`
							<tr class="transaction" data-sa-id="${subAccount.sa_id}" data-sub-account-name="${name}">
								<td>${index + 1}</td>
								<td>
									${name}
								</td>
								<td class="d-flex justify-content-end">
									<button class="btn btn-icon-only btn-sm btn-pill btn-primary" type="button" aria-label="Edit sub-account"
										title="Edit sub-account" data-toggle="modal" data-target="#modal-edit-sub-account"
										data-sa-id="${subAccount.sa_id}"
										data-sub-account-name="${name}"
										data-sub-account-number="${subAccount.sub_account_number || ''}">
										<span aria-hidden="true" class="fas fa-edit"></span>
									</button>
									<button class="btn btn-icon-only btn-sm btn-pill btn-primary delete-sub-account ml-4"
										data-id="${subAccount.sa_id}"
										type="button" aria-label="Delete Sub-account" title="Delete Sub-account">
										<span aria-hidden="true" class="fas fa-trash"></span>
									</button>
								</td>
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

                            loadSubAccountTable(); // reload table
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

    // Load on page ready
    loadSubAccountTable();

    // Expose globally so it can be called after invite
    window.loadSubAccountTable = loadSubAccountTable;
});