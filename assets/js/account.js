"use strict";

document.addEventListener("DOMContentLoaded", function () {
    // ADD ACCOUNT VALIDATION
    setupValidation(
        "addAccountName",
        "addAccountNameFeedback",
        (value) => `process.php?action=check_add_account_name&addAccountName=${encodeURIComponent(value)}`
    );

    // EDIT ACCOUNT VALIDATION
    setupValidation(
        "editAccountName",
        "editAccountNameFeedback",
        (value) => {
            const aId = document.getElementById("a_id").value;
            return `process.php?action=check_edit_account_name&editAccountName=${encodeURIComponent(value)}&aId=${encodeURIComponent(aId)}`;
        }
    );
});

// Update Live Modal Card Preview (/ui-ux-pro-max)
function applyCardPreview(modalPrefix, logoKey, templateKey, nameText) {
    const combinedKey = `${logoKey || 'default'}_${templateKey || 'default'}`;
    const theme = typeof getBankCardTheme === 'function' ? getBankCardTheme(combinedKey) : null;

    const card = $(`#preview-${modalPrefix}-card`);
    const nameEl = $(`#preview-${modalPrefix}-account-name`);
    const balEl = $(`#preview-${modalPrefix}-balance`);
    const labelEl = $(`#preview-${modalPrefix}-balance-label`);
    const logoContainer = $(`#preview-${modalPrefix}-logo-container`);
    const statusBadge = $(`#preview-${modalPrefix}-status-badge`);

    if (theme && theme.svgUrl) {
        card.css({
            'background': `url('${theme.svgUrl}') center/cover no-repeat`,
            'box-shadow': theme.shadow
        });
    } else {
        card.css({
            'background': theme ? theme.bg : '#e6e7ee',
            'box-shadow': theme ? theme.shadow : '6px 6px 14px #b8b9be, -6px -6px 14px #ffffff'
        });
    }

    const textColor = theme ? theme.textColor : '#0f172a';
    const subTextColor = theme ? theme.subTextColor : '#64748b';

    nameEl.css('color', textColor);
    if (nameText && nameText.trim().length > 0) {
        nameEl.text(nameText.toUpperCase());
    } else {
        nameEl.text(modalPrefix === 'add' ? 'NEW ACCOUNT' : 'ACCOUNT NAME');
    }

    balEl.css('color', textColor);
    labelEl.css('color', subTextColor);

    // Render Official SVG Bank Logo or "No Logo"
    if (logoKey === 'none') {
        logoContainer.empty().css('display', 'none');
    } else {
        logoContainer.css('display', 'flex');
        if (theme && theme.logoUrl) {
            logoContainer.html(`
                <img src="${theme.logoUrl}" alt="${theme.logoText}" style="max-height: 28px; max-width: 120px; object-fit: contain; filter: ${theme.logoFilter || 'none'}; transition: all 200ms ease;">
            `);
        } else {
            logoContainer.html(`
                <span class="font-weight-black uppercase text-xs px-2.5 py-1 rounded-pill" style="color: ${theme ? theme.badgeText : '#2D4CC8'}; background: ${theme ? theme.badgeBg : 'rgba(45, 76, 200, 0.12)'}; font-size: 0.72rem; letter-spacing: 0.04em;">${theme ? theme.logoText : 'WALLET'}</span>
            `);
        }
    }

    // High contrast ACTIVE status badge
    if (theme && theme.isNeumorphic) {
        statusBadge.css({
            'background': '#e6e7ee',
            'color': '#0f172a',
            'box-shadow': 'inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff'
        });
    } else {
        statusBadge.css({
            'background': 'rgba(15, 23, 42, 0.75)',
            'color': '#ffffff',
            'box-shadow': 'inset 0 1px 2px rgba(255,255,255,0.2)'
        });
    }
}

// Bank Logo Selection Handler
$(document).on('click', '.btn-logo-select', function (e) {
    e.preventDefault();
    const btn = $(this);
    const targetModal = btn.data('target-modal');
    const logoKey = btn.data('logo');

    $(`.btn-logo-select[data-target-modal="${targetModal}"]`).removeClass('active').css({
        'box-shadow': '2px 2px 6px rgba(0,0,0,0.06)',
        'transform': 'none'
    });

    btn.addClass('active').css({
        'box-shadow': 'inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff',
        'transform': 'scale(0.97)'
    });

    $(`#${targetModal}-bank-logo`).val(logoKey);

    // Auto switch to default template for this bank if valid
    const logoData = typeof BANK_LOGOS !== 'undefined' ? BANK_LOGOS[logoKey] : null;
    let templateKey = $('#' + targetModal + '-card-theme').val();
    if (logoData && logoData.defaultTemplate && logoKey !== 'none') {
        templateKey = logoData.defaultTemplate;
        $(`#${targetModal}-card-theme`).val(templateKey);

        $(`.btn-template-card-tile[data-target-modal="${targetModal}"], .btn-template-select[data-target-modal="${targetModal}"]`).removeClass('active').css({
            'border': '1px solid rgba(255,255,255,0.4) !important',
            'box-shadow': '0 2px 6px rgba(0,0,0,0.25)',
            'transform': 'none'
        });
        $(`.btn-template-card-tile[data-target-modal="${targetModal}"][data-template="${templateKey}"], .btn-template-select[data-target-modal="${targetModal}"][data-template="${templateKey}"]`).addClass('active').css({
            'border': '2px solid #2D4CC8 !important',
            'box-shadow': '0 4px 14px rgba(45,76,200,0.45)',
            'transform': 'scale(0.96)'
        });
    }

    const nameInputVal = targetModal === 'add' ? $('#addAccountName').val() : $('#editAccountName').val();
    applyCardPreview(targetModal, logoKey, templateKey, nameInputVal);
});

// Card Background Template Selection Handler (Visual Mini-Card Thumbnails)
$(document).on('click', '.btn-template-card-tile, .btn-template-select', function (e) {
    e.preventDefault();
    const btn = $(this);
    const targetModal = btn.data('target-modal');
    const templateKey = btn.data('template');

    $(`.btn-template-card-tile[data-target-modal="${targetModal}"], .btn-template-select[data-target-modal="${targetModal}"]`).removeClass('active').css({
        'border': '1px solid rgba(255,255,255,0.4) !important',
        'box-shadow': '0 2px 6px rgba(0,0,0,0.25)',
        'transform': 'none'
    });

    btn.addClass('active').css({
        'border': '2px solid #2D4CC8 !important',
        'box-shadow': '0 4px 14px rgba(45,76,200,0.45)',
        'transform': 'scale(0.96)'
    });

    $(`#${targetModal}-card-theme`).val(templateKey);

    const logoKey = $(`#${targetModal}-bank-logo`).val() || 'default';
    const nameInputVal = targetModal === 'add' ? $('#addAccountName').val() : $('#editAccountName').val();
    applyCardPreview(targetModal, logoKey, templateKey, nameInputVal);
});

// Realtime Input Typing Preview (High Performance requestAnimationFrame /animate)
let rafAddTimer, rafEditTimer;

$(document).on('input', '#addAccountName', function () {
    const val = $(this).val();
    if (rafAddTimer) cancelAnimationFrame(rafAddTimer);
    rafAddTimer = requestAnimationFrame(() => {
        const logoKey = $('#add-bank-logo').val() || 'default';
        const templateKey = $('#add-card-theme').val() || 'default';
        applyCardPreview('add', logoKey, templateKey, val);
    });
});

$(document).on('input', '#editAccountName', function () {
    const val = $(this).val();
    if (rafEditTimer) cancelAnimationFrame(rafEditTimer);
    rafEditTimer = requestAnimationFrame(() => {
        const logoKey = $('#edit-bank-logo').val() || 'default';
        const templateKey = $('#edit-card-theme').val() || 'default';
        applyCardPreview('edit', logoKey, templateKey, val);
    });
});

// Modal Show Bindings
$('#modal-add-account').on('show.bs.modal', function () {
    $('#add-bank-logo').val('default');
    $('#add-card-theme').val('default');

    $('.btn-logo-select[data-target-modal="add"]').removeClass('active').css({
        'box-shadow': '2px 2px 6px rgba(0,0,0,0.06)'
    });
    $('.btn-logo-select[data-target-modal="add"][data-logo="default"]').addClass('active').css({
        'box-shadow': 'inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff'
    });

    $('.btn-template-card-tile[data-target-modal="add"]').removeClass('active').css({
        'border': '1px solid rgba(255,255,255,0.4) !important',
        'box-shadow': '0 2px 6px rgba(0,0,0,0.25)'
    });
    $('.btn-template-card-tile[data-target-modal="add"][data-template="default"]').addClass('active').css({
        'border': '2px solid #2D4CC8 !important',
        'box-shadow': '0 4px 14px rgba(45,76,200,0.45)'
    });

    applyCardPreview('add', 'default', 'default', $('#addAccountName').val());
});

$('#modal-edit-account').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const modal = $(this);
    const aId = button.data('a-id');
    const accountName = button.data('account-name');
    const rawTheme = button.data('card-theme') || 'default';

    const parts = rawTheme.split('_');
    const logoKey = parts[0] || 'default';
    const templateKey = parts[1] || 'default';

    modal.find('#a_id').val(aId);
    modal.find('#editAccountName').val(accountName);
    modal.find('#edit-bank-logo').val(logoKey);
    modal.find('#edit-card-theme').val(templateKey);

    $('.btn-logo-select[data-target-modal="edit"]').removeClass('active').css({
        'box-shadow': '2px 2px 6px rgba(0,0,0,0.06)'
    });
    $(`.btn-logo-select[data-target-modal="edit"][data-logo="${logoKey}"]`).addClass('active').css({
        'box-shadow': 'inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff'
    });

    $('.btn-template-card-tile[data-target-modal="edit"]').removeClass('active').css({
        'border': '1px solid rgba(255,255,255,0.4) !important',
        'box-shadow': '0 2px 6px rgba(0,0,0,0.25)'
    });
    $(`.btn-template-card-tile[data-target-modal="edit"][data-template="${templateKey}"]`).addClass('active').css({
        'border': '2px solid #2D4CC8 !important',
        'box-shadow': '0 4px 14px rgba(45,76,200,0.45)'
    });

    applyCardPreview('edit', logoKey, templateKey, accountName);
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
                        const themeKey = account.card_theme || 'default';
                        const theme = typeof getBankCardTheme === 'function' ? getBankCardTheme(themeKey) : null;
                        let bankBadgeHtml = '';

                        if (theme && theme.logoUrl) {
                            bankBadgeHtml = `
                                <div class="mr-3 rounded-lg d-flex align-items-center justify-content-center shadow-soft" style="width: 44px; height: 30px; background: #ffffff; border: 1px solid rgba(0,0,0,0.08); flex-shrink: 0; padding: 3px;">
                                    <img src="${theme.logoUrl}" alt="${theme.logoText}" style="max-height: 20px; max-width: 38px; object-fit: contain;">
                                </div>
                            `;
                        } else if (theme && theme.logo && theme.logo.id === 'none') {
                            bankBadgeHtml = `
                                <div class="mr-3 rounded-lg d-flex align-items-center justify-content-center shadow-soft" style="width: 44px; height: 30px; background: #e6e7ee; border: 1px solid rgba(255,255,255,0.6); flex-shrink: 0;">
                                    <i class="fa-solid fa-ban text-gray-400" style="font-size: 0.85rem;"></i>
                                </div>
                            `;
                        } else {
                            bankBadgeHtml = `
                                <div class="mr-3 rounded-lg d-flex align-items-center justify-content-center shadow-soft" style="width: 44px; height: 30px; background: #e6e7ee; border: 1px solid rgba(255,255,255,0.6); flex-shrink: 0;">
                                    <i class="fa-solid fa-wallet text-primary" style="font-size: 0.95rem;"></i>
                                </div>
                            `;
                        }

                        tbody.append(`
							<tr>
								<td class="align-middle">${index + 1}</td>
								<td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        ${bankBadgeHtml}
                                        <span class="font-weight-bold text-dark" style="font-size: 0.95rem;">${name}</span>
                                    </div>
                                </td>
								<td class="d-flex justify-content-end align-middle">
									<button class="btn btn-icon-only btn-sm btn-pill btn-primary" type="button" aria-label="Edit account"
										title="Edit account" data-toggle="modal" data-target="#modal-edit-account"
										data-a-id="${account.a_id}"
										data-account-name="${name}"
										data-card-theme="${themeKey}">
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
            })
            .catch(error => {
                console.error('Error fetching accounts:', error);
            });
    }

    // DELETE ACCOUNT (Event Delegation)
    $(document).on('click', '.delete-account', function () {
        const a_id = $(this).data('id');

        Swal.fire({
            icon: 'question',
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `process.php?action=delete&a_id=${a_id}`;
            }
        });
    });

    loadAccountTable();
});