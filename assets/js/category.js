"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // ADD CATEGORY
    setupValidation(
        "addCategoryName",
        "addCategoryNameFeedback",
        (value) => `process.php?action=check_add_category_name&addCategoryName=${encodeURIComponent(value)}`
    );

    // EDIT CATEGORY
    setupValidation(
        "editCategoryName",
        "editCategoryNameFeedback",
        (value) => {
            const cId = document.getElementById("c_id").value;
            return `process.php?action=check_edit_category_name&editCategoryName=${encodeURIComponent(value)}&cId=${encodeURIComponent(cId)}`;
        }
    );

});

$('#modal-edit-category').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);

    const modal = $(this);
    modal.find('#c_id').val(button.data('c-id'));
    modal.find('#editCategoryName').val(button.data('category-name')).trigger('input');
});

$(function () {
    function loadCategoryTable() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().clear().destroy();
        }
        fetch('process.php?action=fetch_category')
            .then(response => response.json())
            .then(categories => {
                const tbody = $('#dataTable tbody');
                tbody.empty();

                if (categories.length > 0) {
                    categories.forEach((category, index) => {
                        const name = $('<span>').text(category.category_name || '').html();

                        tbody.append(`
							<tr>
								<td>${index + 1}</td>
								<td>${name}</td>
								<td class="d-flex justify-content-end">
									<button class="btn btn-icon-only btn-sm btn-pill btn-primary" type="button" aria-label="Edit category"
										title="Edit category" data-toggle="modal" data-target="#modal-edit-category"
										data-c-id="${category.c_id}"
										data-category-name="${name}">
										<span aria-hidden="true" class="fas fa-edit"></span>
									</button>
									<button class="btn btn-icon-only btn-sm btn-pill btn-primary delete-category ml-4"
										data-id="${category.c_id}"
										type="button" aria-label="Delete category" title="Delete category">
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
                console.error('Error fetching categories:', error);
            });
    }

    // DELETE CATEGORY (Event Delegation)
    $(document).on('click', '.delete-category', function () {
        const c_id = $(this).data('id');

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
                    body: JSON.stringify({ c_id: c_id })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success', // 'success', 'error', 'warning', 'info', 'question'
                                title: 'Deleted!',
                                text: 'Category has been deleted.',
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

                            loadCategoryTable(); // reload table
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
    loadCategoryTable();

    // Expose globally so it can be called after invite
    window.loadCategoryTable = loadCategoryTable;
});