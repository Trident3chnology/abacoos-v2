"use strict";

$(function () {
    function loadActivityLogsTable() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().clear().destroy();
        }
        fetch('process.php?action=fetch_activity_logs')
            .then(response => response.json())
            .then(logs => {
                const tbody = $('#dataTable tbody');
                tbody.empty();

                if (logs.length > 0) {
                    logs.forEach((log, index) => {
                        const module = $('<span>').text(log.module || '').html();
                        const action = $('<span>').text(log.action || '').html();
                        const actionBy = $('<span>').text((log.first_name || '') + ' ' + (log.last_name || '')).html();
                        const loggedDate = formatDate(log.log_action_date);
                        const dateTime = $('<span>').text(loggedDate || '').html();

                        tbody.append(`
							<tr>
								<td>${index + 1}</td>
								<td>${module}</td>
								<td>${action}</td>
								<td><span>${log.description}</span></td>
								<td>${actionBy}</td>
								<td>${dateTime}</td>
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
                console.error('Error fetching activity logs:', error);
            });
    }

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        if (isNaN(date)) return dateStr;
        return date.toLocaleDateString('en-US', {
            month: 'short',   // M
            day: '2-digit',   // d
            year: 'numeric',  // Y
            hour: '2-digit',  // h
            minute: '2-digit',
            hour12: true      // a (AM/PM)
        });
    }

    // Load on page ready
    loadActivityLogsTable();

    // Expose globally so it can be called after invite
    window.loadActivityLogsTable = loadActivityLogsTable;
});