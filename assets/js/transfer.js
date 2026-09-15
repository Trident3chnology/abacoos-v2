"use strict";

document.addEventListener("DOMContentLoaded", function () {
    let subAccountsData = [];
    let categoriesData = [];

    // Palette: account colours follow the account, NOT the position (/animate)
    const CARD_PALETTE = [
        { bg: 'linear-gradient(135deg,#0d1b46 0%,#172a68 50%,#0a1128 100%)', shadow: 'rgba(13,27,70,0.55)',   label: '#93c5fd' },
        { bg: 'linear-gradient(135deg,#013a20 0%,#065f46 50%,#022c22 100%)', shadow: 'rgba(1,58,32,0.55)',    label: '#a7f3d0' },
        { bg: 'linear-gradient(135deg,#3b0764 0%,#7e22ce 50%,#1e0038 100%)', shadow: 'rgba(59,7,100,0.55)',   label: '#e9d5ff' },
        { bg: 'linear-gradient(135deg,#431407 0%,#b45309 50%,#1c0701 100%)', shadow: 'rgba(180,83,9,0.55)',   label: '#fde68a' },
        { bg: 'linear-gradient(135deg,#0c1a2e 0%,#0e4d7b 50%,#051020 100%)', shadow: 'rgba(14,77,123,0.55)', label: '#bae6fd' },
        { bg: 'linear-gradient(135deg,#1a0a2e 0%,#6d28d9 50%,#0d0517 100%)', shadow: 'rgba(109,40,217,0.55)', label: '#ddd6fe' },
    ];

    // Returns the palette entry assigned to an account (stable by sa_id)
    function paletteFor(item) {
        const idx = item && item.sa_id ? Math.abs(parseInt(item.sa_id, 10)) % CARD_PALETTE.length : 0;
        return CARD_PALETTE[idx];
    }

    // Helper: Pesos Currency Formatter
    function formatPesos(amount) {
        const val = parseFloat(amount) || 0;
        return '₱ ' + val.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Apply card theme: custom SVG bank templates & colors travel WITH the account (/animate)
    function applyTransferCardTheme(prefix, selectedItem) {
        const cardEl = $(`#card-${prefix}-summary`);
        const nameEl = $(`#lbl-${prefix}-name`);
        const balEl = $(`#lbl-${prefix}-balance`);
        const labelEl = $(`#lbl-${prefix}-balance-label`);
        const logoContainer = $(`#lbl-${prefix}-logo-container`);
        const badgeTagEl = $(`#lbl-${prefix}-tag`);

        const themeKey = selectedItem ? selectedItem.card_theme : null;
        const bankTheme = (themeKey && typeof getBankCardTheme === 'function')
            ? getBankCardTheme(themeKey)
            : null;

        const palette = paletteFor(selectedItem);
        const isCustomCard = bankTheme && bankTheme.template && bankTheme.template.id !== 'default';

        if (isCustomCard) {
            let textColor = bankTheme.textColor || '#ffffff';
            let subTextColor = bankTheme.subTextColor || 'rgba(255,255,255,0.78)';
            let shadow = bankTheme.shadow || `0 12px 28px -6px ${palette.shadow}`;

            if (bankTheme.svgUrl) {
                cardEl.attr('style', `
                    background-color: ${bankTheme.bg || '#00026C'} !important;
                    background-image: url('${bankTheme.svgUrl}?v=${new Date().getTime()}') !important;
                    background-position: center !important;
                    background-size: cover !important;
                    background-repeat: no-repeat !important;
                    min-height: 165px;
                    max-width: 320px;
                    box-shadow: ${shadow} !important;
                    border: none !important;
                    border-radius: 1.25rem !important;
                    overflow: hidden !important;
                    color: ${textColor} !important;
                `);
            } else {
                cardEl.attr('style', `
                    background: ${bankTheme.bg || palette.bg} !important;
                    min-height: 165px;
                    max-width: 320px;
                    box-shadow: ${shadow} !important;
                    border: none !important;
                    border-radius: 1.25rem !important;
                    overflow: hidden !important;
                    color: ${textColor} !important;
                `);
            }

            nameEl.css({ 'color': textColor, 'opacity': '1' });
            balEl.css({ 'color': textColor, 'opacity': '1' });
            if (labelEl.length) labelEl.css('color', subTextColor);
            if (badgeTagEl.length) badgeTagEl.css('color', subTextColor);

            // Official Bank Logo SVG
            if (bankTheme.logoUrl) {
                logoContainer.css('display', 'flex').html(`
                    <img src="${bankTheme.logoUrl}" alt="${bankTheme.logoText || 'Bank'}" style="max-height:24px; max-width:95px; object-fit:contain; filter:${bankTheme.logoFilter || 'brightness(0) invert(1)'}; transition:all 200ms ease;">
                `);
            } else if (bankTheme.logoText) {
                logoContainer.css('display', 'flex').html(`
                    <span class="font-weight-black uppercase text-xs px-2.5 py-0.5 rounded-pill" style="color:${bankTheme.badgeText || '#2D4CC8'}; background:${bankTheme.badgeBg || 'rgba(45, 76, 200, 0.12)'}; font-size:0.65rem; letter-spacing:0.04em;">${bankTheme.logoText}</span>
                `);
            } else {
                logoContainer.css('display', 'flex').html(`
                    <div class="rounded-circle" style="width:20px;height:20px;background:rgba(255,255,255,0.3);margin-right:-6px;"></div>
                    <div class="rounded-circle" style="width:20px;height:20px;background:rgba(255,255,255,0.5);"></div>
                `);
            }
        } else {
            // Standard fallback palette
            cardEl.attr('style', `
                background: ${palette.bg} !important;
                min-height: 165px;
                max-width: 320px;
                box-shadow: 0 12px 28px -6px ${palette.shadow} !important;
                border: none !important;
                border-radius: 1.25rem !important;
                overflow: hidden !important;
                color: #ffffff !important;
            `);

            nameEl.css({ 'color': '#ffffff', 'opacity': '1' });
            balEl.css({ 'color': '#ffffff', 'opacity': '1' });
            if (labelEl.length) labelEl.css('color', palette.label);
            if (badgeTagEl.length) badgeTagEl.css('color', palette.label);

            logoContainer.css('display', 'flex').html(`
                <div class="rounded-circle" style="width:20px;height:20px;background:rgba(255,255,255,0.3);margin-right:-6px;"></div>
                <div class="rounded-circle" style="width:20px;height:20px;background:rgba(255,255,255,0.5);"></div>
            `);
        }
    }

    // Load Sub-Accounts for Select Dropdowns & Live Balance Sync
    function loadAccountsData(isInitial = true) {
        fetch('process.php?action=fetch_accounts_data')
            .then(response => response.json())
            .then(res => {
                const subAccounts = (res && res.status && Array.isArray(res.data)) ? res.data : [];
                subAccountsData = subAccounts;
                const selDebit = $('#sel-debit-from');
                const selCredit = $('#sel-credit-to');

                const curDebit = isInitial ? (localStorage.getItem('transfer_last_debit') || selDebit.val()) : selDebit.val();
                const curCredit = isInitial ? (localStorage.getItem('transfer_last_credit') || selCredit.val()) : selCredit.val();

                selDebit.empty().append('<option value="">Select Source Sub-Account</option>');
                selCredit.empty().append('<option value="">Select Target Sub-Account</option>');

                if (subAccounts.length > 0) {
                    subAccounts.forEach(item => {
                        const optionHtml = `<option value="${item.sa_id}">${item.account_name} - ${item.sub_account_name} (${formatPesos(item.balance)})</option>`;
                        selDebit.append(optionHtml);
                        selCredit.append(optionHtml);
                    });
                }

                if (curDebit && selDebit.find(`option[value="${curDebit}"]`).length) {
                    selDebit.val(curDebit).trigger('change', [{ silent: true }]);
                    const selectedSource = subAccountsData.find(item => item.sa_id == curDebit);
                    applyTransferCardTheme('source', selectedSource);
                    if (selectedSource) {
                        $('#lbl-source-name').text(`${selectedSource.account_name} (${selectedSource.sub_account_name})`);
                        $('#lbl-source-balance').html(formatPesos(selectedSource.balance));
                    }
                } else if (subAccounts.length > 0) {
                    selDebit.val(subAccounts[0].sa_id).trigger('change');
                }

                if (curCredit && selCredit.find(`option[value="${curCredit}"]`).length) {
                    selCredit.val(curCredit).trigger('change', [{ silent: true }]);
                    const selectedTarget = subAccountsData.find(item => item.sa_id == curCredit);
                    applyTransferCardTheme('target', selectedTarget);
                    if (selectedTarget) {
                        $('#lbl-target-name').text(`${selectedTarget.account_name} (${selectedTarget.sub_account_name})`);
                        $('#lbl-target-balance').html(formatPesos(selectedTarget.balance));
                    }
                } else if (subAccounts.length > 1) {
                    selCredit.val(subAccounts[1].sa_id).trigger('change');
                }
            })
            .catch(err => console.error('Error fetching sub-accounts:', err));
    }

    // Perform initial load
    loadAccountsData(true);

    // Load Categories for Select Dropdown
    fetch('process.php?action=fetch_categories')
        .then(response => response.json())
        .then(res => {
            const categories = (res && res.status && Array.isArray(res.data)) ? res.data : [];
            categoriesData = categories;
            const selCat = $('#sel-transfer-category');
            selCat.empty().append('<option value="">Internal Savings / Transfer</option>');

            if (categories.length > 0) {
                categories.forEach(cat => {
                    selCat.append(`<option value="${cat.c_id}">${cat.category_name}</option>`);
                });
            }
        })
        .catch(err => console.error('Error fetching categories:', err));

    // Update Source Card Preview with smooth, clean text transition (/animate)
    $('#sel-debit-from').on('change', function (e, data) {
        if (data && data.silent) return;
        const val = $(this).val();
        if (val) {
            localStorage.setItem('transfer_last_debit', val);
        }
        const selected = subAccountsData.find(item => item.sa_id == val);
        const nameEl = $('#lbl-source-name');
        const balEl = $('#lbl-source-balance');

        applyTransferCardTheme('source', selected);

        nameEl.add(balEl).css({
            'transition': 'opacity 150ms cubic-bezier(0.23, 1, 0.32, 1)',
            'opacity': '0.3'
        });

        setTimeout(() => {
            if (selected) {
                nameEl.text(`${selected.account_name} (${selected.sub_account_name})`);
                balEl.html(formatPesos(selected.balance));
            } else {
                nameEl.text('DEBIT FROM ACCOUNT');
                balEl.html(formatPesos(0));
            }
            nameEl.add(balEl).css('opacity', '1');
        }, 50);
    });

    // Update Target Card Preview with smooth, clean text transition (/animate)
    $('#sel-credit-to').on('change', function (e, data) {
        if (data && data.silent) return;
        const val = $(this).val();
        if (val) {
            localStorage.setItem('transfer_last_credit', val);
        }
        const selected = subAccountsData.find(item => item.sa_id == val);
        const nameEl = $('#lbl-target-name');
        const balEl = $('#lbl-target-balance');

        applyTransferCardTheme('target', selected);

        nameEl.add(balEl).css({
            'transition': 'opacity 150ms cubic-bezier(0.23, 1, 0.32, 1)',
            'opacity': '0.3'
        });

        setTimeout(() => {
            if (selected) {
                nameEl.text(`${selected.account_name} (${selected.sub_account_name})`);
                balEl.html(formatPesos(selected.balance));
            } else {
                nameEl.text('CREDIT TO ACCOUNT');
                balEl.html(formatPesos(0));
            }
            nameEl.add(balEl).css('opacity', '1');
        }, 50);
    });

    // 3D Parallax Orbit FLIP 60fps Card Swap (/animate)
    // Cards orbit past each other in 3D space (perspective, tilt, depth layering, elastic spring).
    // 100% GPU compositor accelerated, 0ms start latency, zero opacity flicker.
    let isSwapping = false;
    let swapRotation = 0;

    document.addEventListener('click', function (e) {
        var btnEl = e.target.closest('#btn-swap-accounts');
        if (!btnEl) return;

        var selDebit  = document.getElementById('sel-debit-from');
        var selCredit = document.getElementById('sel-credit-to');
        if (!selDebit || !selCredit) return;

        if (isSwapping) return;
        isSwapping = true;

        var sourceEl = document.getElementById('card-source-summary');
        var targetEl = document.getElementById('card-target-summary');
        var iconEl   = document.getElementById('img-swap-icon');

        if (!sourceEl || !targetEl) {
            isSwapping = false;
            return;
        }

        var debitVal  = selDebit.value;
        var creditVal = selCredit.value;

        // 1. Measure exact vertical offset before state change
        var srcRect = sourceEl.getBoundingClientRect();
        var tgtRect = targetEl.getBoundingClientRect();
        var distY   = Math.round(tgtRect.top - srcRect.top) || 215;

        // 2. Rotate swap icon + trigger button shockwave pulse
        swapRotation += 180;
        if (iconEl) {
            iconEl.style.transition = 'transform 380ms cubic-bezier(0.34, 1.56, 0.64, 1)';
            iconEl.style.transform  = 'rotate(' + swapRotation + 'deg)';
        }

        btnEl.classList.remove('btn-swap-pulse');
        void btnEl.offsetWidth;
        btnEl.classList.add('btn-swap-pulse');

        // Trigger metallic specular light sheen sweep on both cards
        var sheenSource = document.getElementById('sheen-source');
        var sheenTarget = document.getElementById('sheen-target');
        if (sheenSource) {
            sheenSource.classList.remove('card-sheen-active');
            void sheenSource.offsetWidth;
            sheenSource.classList.add('card-sheen-active');
        }
        if (sheenTarget) {
            sheenTarget.classList.remove('card-sheen-active');
            void sheenTarget.offsetWidth;
            sheenTarget.classList.add('card-sheen-active');
        }

        // 3. Update DOM select values and card contents/theme immediately
        selDebit.value  = creditVal;
        selCredit.value = debitVal;

        if (creditVal) localStorage.setItem('transfer_last_debit', creditVal);
        if (debitVal)  localStorage.setItem('transfer_last_credit', debitVal);

        var newSource = subAccountsData.find(function (item) { return item.sa_id == creditVal; });
        var newTarget = subAccountsData.find(function (item) { return item.sa_id == debitVal;  });

        applyTransferCardTheme('source', newSource);
        applyTransferCardTheme('target', newTarget);

        if (newSource) {
            document.getElementById('lbl-source-name').textContent  = newSource.account_name + ' (' + newSource.sub_account_name + ')';
            document.getElementById('lbl-source-balance').innerHTML = formatPesos(newSource.balance);
        } else {
            document.getElementById('lbl-source-name').textContent  = 'DEBIT FROM ACCOUNT';
            document.getElementById('lbl-source-balance').innerHTML = formatPesos(0);
        }

        if (newTarget) {
            document.getElementById('lbl-target-name').textContent  = newTarget.account_name + ' (' + newTarget.sub_account_name + ')';
            document.getElementById('lbl-target-balance').innerHTML = formatPesos(newTarget.balance);
        } else {
            document.getElementById('lbl-target-name').textContent  = 'CREDIT TO ACCOUNT';
            document.getElementById('lbl-target-balance').innerHTML = formatPesos(0);
        }

        // 4. INVERT STEP: 3D Parallax positioning (Source lifts forward/right; Target dips back/left)
        sourceEl.style.transition = 'none';
        targetEl.style.transition = 'none';

        sourceEl.style.transform  = 'perspective(800px) translate3d(14px, ' + distY + 'px, 35px) rotateZ(-3.5deg) rotateX(6deg) scale(1.03)';
        targetEl.style.transform  = 'perspective(800px) translate3d(-14px, -' + distY + 'px, -25px) rotateZ(3.5deg) rotateX(-6deg) scale(0.94)';
        
        sourceEl.style.zIndex     = '20';
        targetEl.style.zIndex     = '5';
        targetEl.style.opacity    = '0.88';

        sourceEl.style.boxShadow  = '0 22px 40px -8px rgba(0, 0, 0, 0.45)';
        targetEl.style.boxShadow  = '0 8px 18px -4px rgba(0, 0, 0, 0.2)';

        // Force browser layout flush
        void sourceEl.offsetHeight;

        // 5. PLAY STEP: 3D Spring Orbit to resting position
        requestAnimationFrame(function () {
            var springEase = 'cubic-bezier(0.34, 1.45, 0.64, 1)';
            var animProps = 'transform 360ms ' + springEase + ', box-shadow 360ms ease, opacity 360ms ease';

            sourceEl.style.transition = animProps;
            targetEl.style.transition = animProps;

            sourceEl.style.transform  = 'perspective(800px) translate3d(0, 0, 0) rotateZ(0deg) rotateX(0deg) scale(1)';
            targetEl.style.transform  = 'perspective(800px) translate3d(0, 0, 0) rotateZ(0deg) rotateX(0deg) scale(1)';
            targetEl.style.opacity    = '1';

            setTimeout(function () {
                sourceEl.style.transition = '';
                targetEl.style.transition = '';
                sourceEl.style.transform  = '';
                targetEl.style.transform  = '';
                sourceEl.style.zIndex     = '';
                targetEl.style.zIndex     = '';
                sourceEl.style.boxShadow  = '';
                targetEl.style.boxShadow  = '';
                targetEl.style.opacity    = '';
                btnEl.classList.remove('btn-swap-pulse');
                if (sheenSource) sheenSource.classList.remove('card-sheen-active');
                if (sheenTarget) sheenTarget.classList.remove('card-sheen-active');
                isSwapping = false;

                if (typeof $ !== 'undefined') {
                    $(selDebit).trigger('change', [{ silent: true }]);
                    $(selCredit).trigger('change', [{ silent: true }]);
                }
            }, 420);
        });
    });

    // MAX Preset Button Handler
    $('.btn-preset-max').on('click', function () {
        const debitVal = $('#sel-debit-from').val();
        const selected = subAccountsData.find(item => item.sa_id == debitVal);
        if (selected) {
            $('#txt-transfer-amount').val(parseFloat(selected.balance).toFixed(2)).trigger('input');
        }
    });

    // Live Auto-comma formatting & ₱ symbol color toggle
    $(document).on('input keyup', '#txt-transfer-amount', function () {
        let inputEl = this;
        let originalValue = inputEl.value;

        let cleanVal = originalValue.replace(/[^0-9.]/g, '');
        const parts = cleanVal.split('.');
        if (parts.length > 2) {
            cleanVal = parts[0] + '.' + parts.slice(1).join('');
        }

        if (parts[0]) {
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }
        const formatted = parts.join('.');

        if (inputEl.value !== formatted) {
            inputEl.value = formatted;
        }

        const pesoSymbol = $('#lbl-peso-symbol');
        if (cleanVal.length > 0 && parseFloat(cleanVal) > 0) {
            pesoSymbol.css('color', '#2D4CC8');
        } else {
            pesoSymbol.css('color', '#94a3b8');
        }
    });

    // Submit Transfer Form Handler
    $('#form-transfer').on('submit', function (e) {
        e.preventDefault();

        const fromAccount = $('#sel-debit-from').val();
        const toAccount = $('#sel-credit-to').val();
        const rawAmount = $('#txt-transfer-amount').val().replace(/,/g, '');
        const categoryId = $('#sel-transfer-category').val();
        const transferDate = $('#txt-transfer-date').val();

        if (!fromAccount || !toAccount) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Selection Required',
                    text: 'Please select both source and target sub-accounts.',
                    confirmButtonText: 'OK'
                });
            }
            return;
        }

        if (fromAccount === toAccount) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Selection',
                    text: 'Source and target sub-accounts cannot be the same.',
                    confirmButtonText: 'OK'
                });
            }
            return;
        }

        const amount = parseFloat(rawAmount);
        if (isNaN(amount) || amount <= 0) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Amount',
                    text: 'Please enter a valid transfer amount greater than 0.',
                    confirmButtonText: 'OK'
                });
            }
            return;
        }

        const sourceSub = subAccountsData.find(item => item.sa_id == fromAccount);
        if (sourceSub && amount > parseFloat(sourceSub.balance)) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Insufficient Balance',
                    text: `Available balance in ${sourceSub.sub_account_name} is ${formatPesos(sourceSub.balance)}.`,
                    confirmButtonText: 'OK'
                });
            }
            return;
        }

        // Show Single Stationary Neumorphic Modal with Lottie Loader (/animate)
        showTransferProcessModal(fromAccount, toAccount, amount, categoryId, transferDate);
    });

    function showTransferProcessModal(fromAccount, toAccount, amount, categoryId, transferDate) {
        const modal = $('#modal-transfer-process');
        const contentWrapper = $('#modal-transfer-content-wrapper');

        const sourceSub = subAccountsData.find(item => item.sa_id == fromAccount);
        const targetSub = subAccountsData.find(item => item.sa_id == toAccount);

        const sourceLabel = sourceSub ? `${sourceSub.account_name} (${sourceSub.sub_account_name})` : '--';
        const targetLabel = targetSub ? `${targetSub.account_name} (${targetSub.sub_account_name})` : '--';

        // Stage 1: Render Confirmation Modal View (With Cancel and Confirm Send buttons)
        contentWrapper.removeClass('modal-content-fade-out modal-content-fade-in').html(`
            <div id="lottie-container" class="mb-2 d-flex align-items-center justify-content-center"></div>
            <h4 class="font-weight-black mb-1" id="lbl-modal-title" style="font-family: 'Outfit', sans-serif; color: #0f172a;">Confirm Transfer?</h4>
            <p class="text-xs font-weight-bold text-gray-500 mb-4" id="lbl-modal-subtitle">Please review your transfer details before sending.</p>
            
            <div class="shadow-inset rounded-xl p-3.5 mb-4 text-left" style="background: #e6e7ee; border: 1px solid rgba(255,255,255,0.6);">
                <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom border-gray-300/50">
                    <span class="receipt-header-label uppercase" style="font-size: 0.72rem; color: #64748b; font-weight: 800;">Transfer Amount</span>
                    <span class="h5 mb-0 text-primary font-weight-black" id="lbl-modal-amount" style="color: #2D4CC8 !important;">${formatPesos(amount)}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="receipt-row-label" style="font-size: 0.78rem; color: #475569; font-weight: 700;">From Source</span>
                    <span class="receipt-row-value text-truncate font-weight-bold" id="lbl-modal-source" style="max-width: 210px; font-size: 0.82rem; color: #0f172a;">${sourceLabel}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="receipt-row-label" style="font-size: 0.78rem; color: #475569; font-weight: 700;">To Target</span>
                    <span class="receipt-row-value text-truncate font-weight-bold" id="lbl-modal-target" style="max-width: 210px; font-size: 0.82rem; color: #0f172a;">${targetLabel}</span>
                </div>
            </div>

            <div id="modal-actions-container">
                <div class="row">
                    <div class="col-6 pr-2">
                        <button type="button" class="btn btn-primary shadow-soft btn-pill w-100 py-2.5 text-secondary neu-btn-press" data-dismiss="modal" id="btn-cancel-transfer">
                            Cancel
                        </button>
                    </div>
                    <div class="col-6 pl-2">
                        <button type="button" class="btn btn-primary shadow-soft btn-pill w-100 py-2.5 text-white neu-btn-press" id="btn-proceed-transfer" style="background: linear-gradient(135deg, #2D4CC8 0%, #1e3a8a 100%); font-weight: 800;">
                            Confirm Send
                        </button>
                    </div>
                </div>
            </div>
        `);

        modal.modal({ backdrop: 'static', keyboard: false });
        renderLottieAnimation('assets/animation/SbUEdyd89J.json', true);

        // Handle "Confirm Send" button click inside modal (Stage 2)
        $(document).off('click', '#btn-proceed-transfer').on('click', '#btn-proceed-transfer', function () {
            contentWrapper.addClass('modal-content-fade-out');

            setTimeout(() => {
                // Morph to Processing View
                contentWrapper.html(`
                    <div class="text-center py-4">
                        <div id="lottie-container" class="mb-3 d-flex align-items-center justify-content-center"></div>
                        <h4 class="font-weight-black mb-1" style="font-family: 'Outfit', sans-serif; color: #0f172a;">Processing Transfer...</h4>
                        <p class="text-xs font-weight-bold text-gray-500 mb-0">Executing secure internal transfer</p>
                    </div>
                `);

                contentWrapper.removeClass('modal-content-fade-out').addClass('modal-content-fade-in');
                renderLottieAnimation('assets/animation/SbUEdyd89J.json', true);

                // Send AJAX Request
                fetch('process.php?action=process_transfer', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        fromAccount: fromAccount,
                        toAccount: toAccount,
                        transferAmount: amount,
                        transferCategory: categoryId || '',
                        transferDate: transferDate || ''
                    })
                })
                    .then(res => res.json())
                    .then(res => {
                        setTimeout(() => {
                            contentWrapper.addClass('modal-content-fade-out');

                            setTimeout(() => {
                                if (res.status === true) {
                                    contentWrapper.html(`
                                        <div class="text-center py-4">
                                            <div id="lottie-container" class="mb-3 d-flex align-items-center justify-content-center"></div>
                                            <h4 class="font-weight-black mb-1" style="font-family: 'Outfit', sans-serif; color: #0f172a;">Transfer Successful!</h4>
                                            <p class="text-xs font-weight-bold text-gray-500 mb-4">${res.message || 'Funds successfully moved.'}</p>
                                            <button type="button" class="btn btn-primary shadow-soft font-weight-black px-4 py-2.5 rounded-pill text-white neu-btn-press" id="btn-transfer-done" style="background: linear-gradient(135deg, #2D4CC8 0%, #1e3a8a 100%);">
                                                Done
                                            </button>
                                        </div>
                                    `);
                                    renderLottieAnimation('assets/animation/Success.json', false);
                                } else {
                                    contentWrapper.html(`
                                        <div class="text-center py-4">
                                            <div class="rounded-circle bg-danger text-white d-inline-flex align-items-center justify-content-center mb-3 shadow-soft" style="width: 70px; height: 70px;">
                                                <i class="fa-solid fa-triangle-exclamation" style="font-size: 2rem;"></i>
                                            </div>
                                            <h4 class="font-weight-black text-danger mb-1" style="font-family: 'Outfit', sans-serif;">Transfer Failed</h4>
                                            <p class="text-xs font-weight-bold text-gray-600 mb-4">${res.message || 'An error occurred during transfer.'}</p>
                                            <button type="button" class="btn btn-secondary shadow-soft font-weight-bold px-4 py-2 rounded-xl" data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    `);
                                }

                                contentWrapper.removeClass('modal-content-fade-out').addClass('modal-content-fade-in');

                                $(document).off('click', '#btn-transfer-done').on('click', '#btn-transfer-done', function () {
                                    modal.modal('hide');
                                    $('#txt-transfer-amount').val('').trigger('input');
                                    loadAccountsData(false);
                                });

                            }, 220);
                        }, 800);
                    })
                    .catch(err => {
                        console.error('Transfer process error:', err);
                        contentWrapper.html(`
                            <div class="text-center py-4">
                                <h4 class="font-weight-black text-danger mb-1">Server Error</h4>
                                <p class="text-xs text-gray-600 mb-4">Network or server error encountered.</p>
                                <button type="button" class="btn btn-secondary shadow-soft font-weight-bold px-4 py-2 rounded-xl" data-dismiss="modal">
                                    Close
                                </button>
                            </div>
                        `);
                    });
            }, 200);
        });
    }

    function renderLottieAnimation(jsonRelativePath, loop = true) {
        const container = document.getElementById('lottie-container');
        if (!container) return;
        container.innerHTML = '';

        const jsonUrl = (typeof window.WEB_ROOT !== 'undefined' ? window.WEB_ROOT : '/abacoos-v2/') + jsonRelativePath;

        if (typeof lottie !== 'undefined' && typeof lottie.loadAnimation === 'function') {
            lottie.loadAnimation({
                container: container,
                renderer: 'svg',
                loop: loop,
                autoplay: true,
                path: jsonUrl
            });
        } else {
            container.innerHTML = `<lottie-player src="${jsonUrl}" background="transparent" speed="1" style="width: 160px; height: 160px;" autoplay ${loop ? 'loop' : ''}></lottie-player>`;
        }
    }
});
