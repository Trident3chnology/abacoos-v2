"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // ADD USER
    setupValidation(
        "email",
        "emailFeedback",
        (value) => `process.php?action=check_email&email=${encodeURIComponent(value)}`
    );
});

$(function () {
    function loadUserTable() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().clear().destroy();
        }
        fetch('process.php?action=fetch_user')
            .then(response => response.json())
            .then(users => {
                const tbody = $('#dataTable tbody');
                tbody.empty();

                if (users.length > 0) {
                    users.forEach((user, index) => {
                        const name = $('<span>').text((user.first_name || '') + ' ' + (user.last_name || '')).html();
                        const email = $('<span>').text(user.email || '').html();

                        tbody.append(`
							<tr>
								<td>${index + 1}</td>
								<td>${name}</td>
								<td>${email}</td>
								<td class="d-flex justify-content-center">
									<button class="btn btn-icon-only btn-sm btn-pill btn-primary delete-user"
										data-id="${user.tu_id}"
										type="button" aria-label="Delete user" title="Delete user">
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
                console.error('Error fetching users:', error);
            });
    }

    // DELETE USER (Event Delegation)
    $(document).on('click', '.delete-user', function () {
        const tu_id = $(this).data('id');

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
                    body: JSON.stringify({ tu_id: tu_id })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success', // 'success', 'error', 'warning', 'info', 'question'
                                title: 'Deleted!',
                                text: 'User has been deleted.',
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

                            loadUserTable(); // reload table
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
    loadUserTable();

    // Expose globally so it can be called after invite
    window.loadUserTable = loadUserTable;
});