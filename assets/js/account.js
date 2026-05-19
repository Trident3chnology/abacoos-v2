"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // ADD ACCOUNT
    setupValidation(
        "addAccountName",
        "addAccountNameFeedback",
        (value) => `process.php?action=check_add_account_name&addAccountName=${encodeURIComponent(value)}`
    );

    // EDIT ACCOUNT
    setupValidation(
        "editAccountName",
        "editAccountNameFeedback",
        (value) => {
            const aId = document.getElementById("a_id").value;
            return `process.php?action=check_edit_account_name&editAccountName=${encodeURIComponent(value)}&aId=${encodeURIComponent(aId)}`;
        }
    );

});

$('#modal-edit-account').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);

    const modal = $(this);
    modal.find('#a_id').val(button.data('a-id'));
    modal.find('#editAccountName').val(button.data('account-name')).trigger('input');
});

$(function () {
    function loadAccountTable() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().clear().destroy();
        }
        fetch('process.php?action=fetch_account')
            .then(response => response.json())
            .then(accounts => {
                const tbody = $('#dataTable tbody');
                tbody.empty();

                if (accounts.length > 0) {
                    accounts.forEach((account, index) => {
                        const name = $('<span>').text(account.account_name || '').html();

                        tbody.append(`
							<tr>
								<td>${index + 1}</td>
								<td>${name}</td>
								<td class="d-flex justify-content-end">
									<button class="btn btn-icon-only btn-sm btn-pill btn-primary" type="button" aria-label="Edit account"
										title="Edit account" data-toggle="modal" data-target="#modal-edit-account"
										data-a-id="${account.a_id}"
										data-account-name="${name}">
										<span aria-hidden="true" class="fas fa-edit"></span>
									</button>
									<button class="btn btn-icon-only btn-sm btn-pill btn-primary delete-account ml-4"
										data-id="${account.a_id}"
										type="button" aria-label="Delete account" title="Delete account">
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

    // DELETE ACCOUNT (Event Delegation)
    $(document).on('click', '.delete-account', function () {
        const a_id = $(this).data('id');

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
                    body: JSON.stringify({ a_id: a_id })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success', // 'success', 'error', 'warning', 'info', 'question'
                                title: 'Deleted!',
                                text: 'Account has been deleted.',
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

                            loadAccountTable(); // reload table
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

    // Load on page ready
    loadAccountTable();

    // Expose globally so it can be called after invite
    window.loadAccountTable = loadAccountTable;
});