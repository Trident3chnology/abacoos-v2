/**
 * Abacoos v2 - Financial Reports & Audit Module (Option B)
 * Precision Date Handling, Real-time High-Contrast Neumorphic KPI Metrics,
 * Multi-Account Audit Cards, Interactive Category Breakdown Donut Chart,
 * and Master Audit Ledger (UI/UX Pro Max certified).
 */

$(document).ready(function () {
	let categoryChart = null;
	let allTransactions = [];

	// Format helper: formats Date object as YYYY-MM-DD
	function formatDate(d) {
		const year = d.getFullYear();
		const month = String(d.getMonth() + 1).padStart(2, '0');
		const day = String(d.getDate()).padStart(2, '0');
		return `${year}-${month}-${day}`;
	}

	// Format helper: formats Date object for human readable UI display
	function formatDisplayDate(d) {
		return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
	}

	// Initialize Default Date Preset (This Month)
	initDatePresets();

	// Load Dropdown Options (Accounts & Categories)
	loadFilterOptions();

	// Fetch Initial Data
	refreshAllReportData();

	// ============================================
	// EVENT LISTENERS
	// ============================================

	// Preset Pills Click
	$(document).on('click', '.filter-preset-pill', function () {
		$('.filter-preset-pill').removeClass('active');
		$(this).addClass('active');

		const preset = $(this).data('range');
		applyDatePreset(preset);
		refreshAllReportData();
	});

	// Date Inputs Change (Automatically switches preset pill to 'Custom')
	$('#filter-start-date, #filter-end-date').on('change', function () {
		$('.filter-preset-pill').removeClass('active');
		$('.filter-preset-pill[data-range="custom"]').addClass('active');
		updatePeriodLabel();
		refreshAllReportData();
	});

	// Dropdown Filters Change (Account & Category)
	$('#filter-account, #filter-category').on('change', function () {
		refreshAllReportData();
	});

	// Reset Filters Button
	$('#btn-reset-filter').on('click', function () {
		$('#filter-account').val('all');
		$('#filter-category').val('all');
		$('#audit-table-search').val('');
		$('.filter-preset-pill').removeClass('active');
		$('.filter-preset-pill[data-range="this_month"]').addClass('active');
		applyDatePreset('this_month');
		refreshAllReportData();
	});

	// Table Search Filter (Instant responsive search)
	$('#audit-table-search').on('keyup', function () {
		const query = $(this).val().toLowerCase().trim();
		filterAuditTable(query);
	});

	// CSV Export Button
	$('#btn-export-csv').on('click', function () {
		const startDate = $('#filter-start-date').val();
		const endDate = $('#filter-end-date').val();
		const accountId = $('#filter-account').val();
		const categoryId = $('#filter-category').val();

		const url = `process.php?action=export_csv&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}&a_id=${encodeURIComponent(accountId)}&c_id=${encodeURIComponent(categoryId)}`;
		window.location.href = url;
	});

	// Print Report Button (Format clean executive print header)
	$('#btn-print-report').on('click', function (e) {
		e.preventDefault();

		const periodText = $('#report-period-label').text() || 'This Month';
		const accountText = $('#filter-account option:selected').text() || 'All Accounts';
		const categoryText = $('#filter-category option:selected').text() || 'All Categories';

		$('#print-header-period').text('Period: ' + periodText);
		$('#print-header-scope').text(`Scope: ${accountText} | ${categoryText}`);
		$('#print-header-timestamp').text('Printed: ' + new Date().toLocaleString('en-US', {
			month: 'short',
			day: 'numeric',
			year: 'numeric',
			hour: '2-digit',
			minute: '2-digit'
		}));

		window.print();
	});

	// ============================================
	// ACCURATE DATE PRESET HANDLING
	// ============================================

	function initDatePresets() {
		applyDatePreset('this_month');
	}

	function applyDatePreset(preset) {
		const now = new Date();
		let start = '';
		let end = '';

		if (preset === 'today') {
			const todayStr = formatDate(now);
			start = todayStr;
			end = todayStr;
			$('#report-period-label, #report-period-badge-mobile').text('Today (' + formatDisplayDate(now) + ')');
		} else if (preset === 'this_week') {
			// Current week: Monday to Sunday
			const dayOfWeek = now.getDay();
			const distanceToMonday = now.getDate() - dayOfWeek + (dayOfWeek === 0 ? -6 : 1);
			const monday = new Date(now.getFullYear(), now.getMonth(), distanceToMonday);
			const sunday = new Date(monday.getFullYear(), monday.getMonth(), monday.getDate() + 6);

			start = formatDate(monday);
			end = formatDate(sunday);
			$('#report-period-label, #report-period-badge-mobile').text('This Week (' + formatDisplayDate(monday) + ' – ' + formatDisplayDate(sunday) + ')');
		} else if (preset === 'this_month') {
			// Entire current month: 1st day to last calendar day of the month
			const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
			const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

			start = formatDate(firstDay);
			end = formatDate(lastDay);
			$('#report-period-label, #report-period-badge-mobile').text('This Month (' + now.toLocaleString('default', { month: 'long', year: 'numeric' }) + ')');
		} else if (preset === 'last_month') {
			// Full previous calendar month
			const firstDayLastMonth = new Date(now.getFullYear(), now.getMonth() - 1, 1);
			const lastDayLastMonth = new Date(now.getFullYear(), now.getMonth(), 0);

			start = formatDate(firstDayLastMonth);
			end = formatDate(lastDayLastMonth);
			$('#report-period-label, #report-period-badge-mobile').text('Last Month (' + firstDayLastMonth.toLocaleString('default', { month: 'long', year: 'numeric' }) + ')');
		} else if (preset === 'last_30_days') {
			const past = new Date();
			past.setDate(past.getDate() - 30);

			start = formatDate(past);
			end = formatDate(now);
			$('#report-period-label, #report-period-badge-mobile').text('Last 30 Days (' + formatDisplayDate(past) + ' – ' + formatDisplayDate(now) + ')');
		} else if (preset === 'this_year') {
			// Full calendar year
			const firstDayYear = new Date(now.getFullYear(), 0, 1);
			const lastDayYear = new Date(now.getFullYear(), 11, 31);

			start = formatDate(firstDayYear);
			end = formatDate(lastDayYear);
			$('#report-period-label, #report-period-badge-mobile').text('Year ' + now.getFullYear());
		} else if (preset === 'all_time') {
			start = '';
			end = '';
			$('#report-period-label, #report-period-badge-mobile').text('All Time Records');
		} else if (preset === 'custom') {
			updatePeriodLabel();
			return;
		}

		$('#filter-start-date').val(start);
		$('#filter-end-date').val(end);

		// Smooth auto-scroll active preset pill into view if track is horizontally scrollable
		const activePill = $(`.filter-preset-pill[data-range="${preset}"]`);
		if (activePill.length) {
			const track = activePill.closest('.neu-segmented-track');
			if (track.length && track[0].scrollWidth > track.innerWidth()) {
				const pillLeft = activePill.position().left + track.scrollLeft();
				const targetScroll = pillLeft - (track.width() / 2) + (activePill.outerWidth() / 2);
				track.animate({ scrollLeft: Math.max(0, targetScroll) }, 200);
			}
		}
	}

	function updatePeriodLabel() {
		const s = $('#filter-start-date').val();
		const e = $('#filter-end-date').val();
		let text = 'All Time Records';
		if (s && e) {
			text = `${s} to ${e}`;
		} else if (s) {
			text = `From ${s}`;
		} else if (e) {
			text = `Until ${e}`;
		}
		$('#report-period-label, #report-period-badge-mobile').text(text);
	}

	function getFilterParams() {
		return {
			start_date: $('#filter-start-date').val() || '',
			end_date: $('#filter-end-date').val() || '',
			a_id: $('#filter-account').val() || 'all',
			c_id: $('#filter-category').val() || 'all'
		};
	}

	// ============================================
	// AJAX DATA LOADERS
	// ============================================

	function loadFilterOptions() {
		$.getJSON('process.php?action=filter_options', function (res) {
			if (res.status) {
				const accSelect = $('#filter-account');
				accSelect.find('option:not(:first)').remove();
				(res.accounts || []).forEach(acc => {
					accSelect.append(new Option(acc.account_name, acc.a_id));
				});

				const catSelect = $('#filter-category');
				catSelect.find('option:not(:first)').remove();
				(res.categories || []).forEach(cat => {
					catSelect.append(new Option(cat.category_name, cat.c_id));
				});
			}
		});
	}

	// ============================================
	// SKELETON LOADERS & MICRO-ANIMATIONS (/animate)
	// ============================================

	function showAllSkeletons() {
		showKpiSkeletons();
		showAccountSkeletons();
		showCategorySkeletons();
		showAuditTableSkeletons();
	}

	function showKpiSkeletons() {
		$('#kpi-total-inflow').html('<span class="neu-skeleton" style="width: 140px; height: 1.75rem;">&nbsp;</span>');
		$('#kpi-total-outflow').html('<span class="neu-skeleton" style="width: 140px; height: 1.75rem;">&nbsp;</span>');
		$('#kpi-net-cashflow').html('<span class="neu-skeleton" style="width: 140px; height: 1.75rem;">&nbsp;</span>');
		$('#kpi-savings-rate').html('<span class="neu-skeleton" style="width: 45px; height: 1rem;">&nbsp;</span>');
		$('#insight-retention-rate').html('<span class="neu-skeleton" style="width: 65px; height: 1.5rem;">&nbsp;</span>');
		$('#insight-avg-outflow').html('<span class="neu-skeleton" style="width: 100px; height: 1.5rem;">&nbsp;</span>');
	}

	function showAccountSkeletons() {
		const skeletonCard = `
			<div class="col-12 col-md-6 col-xl-4 mb-4">
				<div class="neu-skeleton-card h-100 d-flex flex-column">
					<div class="d-flex align-items-center justify-content-between mb-3">
						<div class="d-flex align-items-center">
							<div class="neu-skeleton neu-skeleton-circle mr-2.5" style="width: 38px; height: 38px;"></div>
							<div>
								<div class="neu-skeleton mb-1" style="width: 110px; height: 16px;"></div>
								<div class="neu-skeleton" style="width: 70px; height: 12px;"></div>
							</div>
						</div>
						<div class="neu-skeleton rounded-pill" style="width: 75px; height: 22px;"></div>
					</div>
					<div class="mb-3 pb-2.5 border-bottom" style="border-color: #cbd5e1 !important;">
						<div class="neu-skeleton mb-1" style="width: 100px; height: 12px;"></div>
						<div class="neu-skeleton" style="width: 150px; height: 26px;"></div>
					</div>
					<div class="neu-pressed-container px-3 py-2.5 mb-3 d-flex align-items-center justify-content-between">
						<div class="d-flex align-items-center">
							<div class="neu-skeleton neu-skeleton-circle mr-2" style="width: 24px; height: 24px;"></div>
							<div>
								<div class="neu-skeleton mb-1" style="width: 45px; height: 10px;"></div>
								<div class="neu-skeleton" style="width: 65px; height: 16px;"></div>
							</div>
						</div>
						<div style="width: 1px; height: 28px; background: #cbd5e1;"></div>
						<div class="d-flex align-items-center">
							<div class="neu-skeleton neu-skeleton-circle mr-2" style="width: 24px; height: 24px;"></div>
							<div>
								<div class="neu-skeleton mb-1" style="width: 45px; height: 10px;"></div>
								<div class="neu-skeleton" style="width: 65px; height: 16px;"></div>
							</div>
						</div>
					</div>
					<div class="d-flex align-items-baseline justify-content-between mb-2">
						<div class="neu-skeleton" style="width: 70px; height: 14px;"></div>
						<div class="neu-skeleton" style="width: 90px; height: 18px;"></div>
					</div>
					<div class="pt-3 border-top mt-auto" style="border-color: #cbd5e1 !important;">
						<div class="neu-skeleton mb-2" style="width: 100%; height: 8px; border-radius: 50rem;"></div>
						<div class="neu-skeleton" style="width: 100%; height: 32px; border-radius: 6px;"></div>
					</div>
				</div>
			</div>
		`;
		$('#account-cards-container').html(skeletonCard + skeletonCard + skeletonCard);
	}

	function showCategorySkeletons() {
		let rows = '';
		for (let i = 0; i < 4; i++) {
			rows += `
				<div class="d-flex align-items-center justify-content-between py-2.5 border-bottom" style="border-color: #cbd5e1 !important;">
					<div class="d-flex align-items-center">
						<div class="neu-skeleton neu-skeleton-circle mr-2" style="width: 12px; height: 12px;"></div>
						<div class="neu-skeleton" style="width: 110px; height: 14px;"></div>
					</div>
					<div class="d-flex align-items-center">
						<div class="neu-skeleton mr-2" style="width: 70px; height: 14px;"></div>
						<div class="neu-skeleton" style="width: 40px; height: 20px; border-radius: 6px;"></div>
					</div>
				</div>
			`;
		}
		$('#category-ranked-list').html(rows);
	}

	function showAuditTableSkeletons() {
		let rows = '';
		for (let i = 0; i < 5; i++) {
			rows += `
				<tr class="border-bottom" style="border-color: #cbd5e1 !important;">
					<td class="py-3 px-3"><div class="neu-skeleton" style="width: 80px; height: 14px;"></div></td>
					<td class="py-3 px-3">
						<div class="d-flex align-items-center">
							<div class="neu-skeleton neu-skeleton-circle mr-2.5" style="width: 22px; height: 22px;"></div>
							<div>
								<div class="neu-skeleton mb-1" style="width: 140px; height: 14px;"></div>
								<div class="neu-skeleton" style="width: 85px; height: 10px;"></div>
							</div>
						</div>
					</td>
					<td class="py-3 px-3"><div class="neu-skeleton rounded-pill" style="width: 80px; height: 22px;"></div></td>
					<td class="py-3 px-3">
						<div class="neu-skeleton mb-1" style="width: 100px; height: 14px;"></div>
						<div class="neu-skeleton" style="width: 60px; height: 10px;"></div>
					</td>
					<td class="py-3 px-3 text-center"><div class="neu-skeleton rounded-pill" style="width: 60px; height: 22px;"></div></td>
					<td class="py-3 px-3 text-right"><div class="neu-skeleton" style="width: 90px; height: 16px;"></div></td>
				</tr>
			`;
		}
		$('#audit-table-body').html(rows);
		$('#audit-table-empty').addClass('d-none');
	}

	function refreshAllReportData() {
		const params = getFilterParams();

		showAllSkeletons();

		fetchReportSummary(params);
		fetchAccountBreakdown(params);
		fetchCategoryBreakdown(params);
		fetchAuditTransactions(params);
	}

	/**
	 * 1. Global KPI Metrics Summary (High Contrast & Smooth Transitions)
	 */
	function fetchReportSummary(params) {
		$.getJSON('process.php?action=fetch_report_summary', params, function (res) {
			if (res.status && res.data) {
				const d = res.data;
				$('#kpi-total-inflow').html(`<span class="content-enter-smooth">${d.formatted_inflow}</span>`);
				$('#kpi-total-outflow').html(`<span class="content-enter-smooth">${d.formatted_outflow}</span>`);
				$('#kpi-net-cashflow').html(`<span class="content-enter-smooth">${d.formatted_net}</span>`);

				// Highlight Net in Bold Indigo (#1d4ed8) or Crimson (#b91c1c)
				if (d.net_cashflow >= 0) {
					$('#kpi-net-cashflow').css('color', '#1d4ed8');
				} else {
					$('#kpi-net-cashflow').css('color', '#b91c1c');
				}

				$('#kpi-savings-rate').html(`<span class="content-enter-smooth">${d.savings_rate}%</span>`);
				$('#insight-retention-rate').html(`<span class="content-enter-smooth">${d.savings_rate}%</span>`);
				$('#kpi-total-records').html(`<span class="content-enter-smooth">${d.total_count}</span>`);
				$('#kpi-avg-transaction').html(`<span class="content-enter-smooth">${d.formatted_avg}</span>`);
			}
		});
	}

	/**
	 * 2. Multi-Account Audit Breakdown Cards (High Contrast & High Legibility)
	 */
	function fetchAccountBreakdown(params) {
		const container = $('#account-cards-container');

		$.getJSON('process.php?action=fetch_account_breakdown', params, function (res) {
			container.empty();

			if (!res.status || !res.data || res.data.length === 0) {
				container.html(`
					<div class="col-12 text-center py-4" style="color: #475569;">
						<i class="fas fa-university fa-2x mb-2 text-primary"></i>
						<p class="text-xs font-weight-bold mb-0" style="color: #334155;">No active accounts registered for this tenant.</p>
					</div>
				`);
				$('#total-volume-indicator').text('₱0.00');
				$('#insight-top-account').text('None');
				return;
			}

			$('#total-volume-indicator').text('₱' + (res.total_volume || 0).toLocaleString('en-US', { minimumFractionDigits: 2 }));

			// Identify account with largest activity volume
			let topAcc = res.data[0];
			res.data.forEach(acc => {
				if (acc.volume > (topAcc ? topAcc.volume : 0)) {
					topAcc = acc;
				}
			});
			if (topAcc && topAcc.volume > 0) {
				$('#insight-top-account').text(topAcc.account_name);
			} else {
				$('#insight-top-account').text('None');
			}

			// Render individual account audit cards with staggered smooth entrance
			res.data.forEach((acc, idx) => {
				const isNetPositive = acc.net >= 0;
				const netColor = isNetPositive ? '#1d4ed8' : '#b91c1c';
				const staggerClass = `stagger-${Math.min(idx + 1, 6)}`;

				const cardHtml = `
					<div class="col-12 col-md-6 col-xl-4 mb-4 content-enter-smooth ${staggerClass}">
						<div class="neu-account-card p-4 h-100 d-flex flex-column justify-content-between">
							
							<div>
								<!-- Card Header: Title + Sub-Account Count & Tx Count -->
								<div class="d-flex align-items-center justify-content-between mb-3">
									<div class="d-flex align-items-center">
										<div class="rounded-circle d-flex align-items-center justify-content-center mr-2.5" 
											style="width: 38px; height: 38px; background: rgba(45, 76, 200, 0.14); color: #2D4CC8;">
											<i class="fas fa-wallet" style="font-size: 1rem;"></i>
										</div>
										<div>
											<h5 class="h6 font-weight-black mb-0" style="color: #0f172a; font-size: 1.05rem;">${escapeHtml(acc.account_name)}</h5>
											<span style="color: #475569; font-weight: 600; font-size: 0.78rem;">${acc.sub_account_count} Sub-Account${acc.sub_account_count === 1 ? '' : 's'}</span>
										</div>
									</div>
									<span class="badge badge-pill text-xs font-weight-bold px-2.5 py-1" style="background: #e2e8f0; color: #0f172a; border: 1px solid #cbd5e1;">
										${acc.tx_count} period tx
									</span>
								</div>

								<!-- Live Account Balance Hero -->
								<div class="mb-3 pb-2.5 border-bottom" style="border-color: #cbd5e1 !important;">
									<div class="text-xs font-weight-bold text-uppercase tracking-wider" style="color: #64748b; font-size: 0.72rem;">Live Account Balance</div>
									<div class="font-weight-bold" style="font-size: 1.45rem; color: #0f172a; line-height: 1.2; font-weight: 800;">${acc.formatted_balance}</div>
								</div>

								<!-- Sleek Neumorphic Inset Flow Strip -->
								<div class="neu-pressed-container px-3 py-2.5 mb-3 d-flex align-items-center justify-content-between">
									<div class="d-flex align-items-center">
										<div class="rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 26px; height: 26px; background: rgba(0, 200, 83, 0.15); color: #047857;">
											<i class="fas fa-arrow-down" style="font-size: 0.72rem;"></i>
										</div>
										<div>
											<div style="font-size: 0.68rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Inflow</div>
											<div class="font-weight-bold" style="font-size: 0.95rem; color: #047857; font-weight: 800;">${acc.formatted_inflow}</div>
										</div>
									</div>

									<div style="width: 1px; height: 30px; background: #cbd5e1;"></div>

									<div class="d-flex align-items-center">
										<div class="rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 26px; height: 26px; background: rgba(220, 53, 69, 0.15); color: #b91c1c;">
											<i class="fas fa-arrow-up" style="font-size: 0.72rem;"></i>
										</div>
										<div>
											<div style="font-size: 0.68rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Outflow</div>
											<div class="font-weight-bold" style="font-size: 0.95rem; color: #b91c1c; font-weight: 800;">${acc.formatted_outflow}</div>
										</div>
									</div>
								</div>

								<!-- Period Net Cashflow -->
								<div class="d-flex align-items-baseline justify-content-between mb-2">
									<span class="text-xs font-weight-bold text-uppercase" style="color: #475569;">Period Net:</span>
									<span class="font-weight-bold" style="font-size: 1.15rem; color: ${netColor}; font-weight: 800;">${acc.formatted_net}</span>
								</div>
							</div>

							<!-- Utilization Bar & Quick Audit Filter Action -->
							<div class="pt-3 border-top mt-auto" style="border-color: #cbd5e1 !important;">
								<div class="d-flex justify-content-between text-xs mb-1 font-weight-bold" style="color: #1e293b;">
									<span>Period Activity Share</span>
									<span style="color: #0f172a; font-weight: 800;">${acc.utilization_percent}%</span>
								</div>
								<div class="neu-progress-bar-bg mb-3">
									<div class="h-100 rounded-pill" style="width: ${acc.utilization_percent}%; background-color: #2D4CC8;"></div>
								</div>
								
								<button type="button" class="btn btn-sm btn-block neu-action-btn btn-audit-account font-weight-bold" data-account-id="${acc.a_id}" style="color: #0f172a; font-size: 0.82rem; padding: 0.48rem 0.8rem;">
									<i class="fas fa-filter mr-1.5 text-primary"></i> Audit Account Ledger
								</button>
							</div>

						</div>
					</div>
				`;
				container.append(cardHtml);
			});

			// Attach Quick Audit Filter Click Handler
			$('.btn-audit-account').on('click', function () {
				const aId = $(this).data('account-id');
				$('#filter-account').val(aId).trigger('change');
				$('html, body').animate({
					scrollTop: $('#audit-ledger-table').offset().top - 120
				}, 400);
			});

		});
	}

	/**
	 * 3. Category Spending Breakdown (Donut Chart + List)
	 */
	function fetchCategoryBreakdown(params) {
		$.getJSON('process.php?action=fetch_category_breakdown', params, function (res) {
			const rankedList = $('#category-ranked-list');
			rankedList.empty();

			if (!res.status || !res.categories || res.categories.length === 0) {
				$('#category-count-badge').text('0 Categories');
				$('#chart-empty-state').removeClass('d-none');
				if (categoryChart) {
					categoryChart.destroy();
					categoryChart = null;
				}
				rankedList.html('<p class="text-xs font-weight-bold text-center py-4" style="color: #475569;">No expense records found in this range.</p>');
				$('#insight-top-category').text('None');
				$('#insight-avg-outflow').text('₱0.00');
				return;
			}

			$('#chart-empty-state').addClass('d-none');
			const catCount = res.categories.length;
			$('#category-count-badge').text(catCount + (catCount === 1 ? ' Category' : ' Categories'));

			// Top spending category
			const topCat = res.categories[0];
			$('#insight-top-category').text(topCat.category_name);

			// Average outflow
			const totalExpense = res.total_expense || 0;
			const totalTxCount = res.categories.reduce((acc, c) => acc + c.tx_count, 0);
			const avgOutflow = totalTxCount > 0 ? (totalExpense / totalTxCount) : 0;
			$('#insight-avg-outflow').text('₱' + avgOutflow.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

			// Render Chart.js Donut
			renderCategoryDonut(res.chart);

			// Render ranked list with high contrast & micro-stagger
			res.categories.forEach((cat, idx) => {
				const staggerClass = `stagger-${Math.min(idx + 1, 6)}`;
				const itemHtml = `
					<div class="d-flex align-items-center justify-content-between py-2.5 border-bottom content-enter-smooth ${staggerClass}" style="border-color: #cbd5e1 !important;">
						<div class="d-flex align-items-center">
							<span class="rounded-circle mr-2 d-inline-block" style="width: 12px; height: 12px; background-color: ${cat.color};"></span>
							<span class="text-xs font-weight-black text-truncate" style="max-width: 160px; color: #0f172a;">${escapeHtml(cat.category_name)}</span>
						</div>
						<div class="d-flex align-items-center">
							<span class="text-xs font-weight-bold mr-2" style="color: #0f172a; font-weight: 800 !important;">${cat.formatted_amount}</span>
							<span class="badge text-xs font-weight-bold" style="background: #2D4CC8; color: #ffffff; padding: 4px 8px; border-radius: 6px; font-weight: 800 !important;">${cat.percentage}%</span>
						</div>
					</div>
				`;
				rankedList.append(itemHtml);
			});
		});
	}

	function renderCategoryDonut(chartData) {
		const canvas = document.getElementById('categoryDonutChart');
		if (!canvas) return;
		const ctx = canvas.getContext('2d');

		if (categoryChart) {
			categoryChart.destroy();
		}

		categoryChart = new Chart(ctx, {
			type: 'doughnut',
			data: {
				labels: chartData.labels,
				datasets: [{
					data: chartData.values,
					backgroundColor: chartData.colors,
					borderWidth: 2,
					borderColor: '#e6e7ee',
					hoverOffset: 6
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: true,
				cutout: '68%',
				plugins: {
					legend: {
						display: false
					},
					tooltip: {
						backgroundColor: '#0f172a',
						titleColor: '#ffffff',
						bodyColor: '#ffffff',
						titleFont: { weight: 'bold' },
						bodyFont: { weight: 'bold', family: 'Fira Code, monospace' },
						padding: 10,
						cornerRadius: 8,
						callbacks: {
							label: function (ctx) {
								const val = ctx.raw || 0;
								return ` ₱${val.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
							}
						}
					}
				}
			}
		});
	}

	/**
	 * 4. Detailed Audit Ledger Table (High Contrast & High Legibility)
	 */
	function fetchAuditTransactions(params) {
		showAuditTableSkeletons();

		$.getJSON('process.php?action=fetch_audit_transactions', params, function (res) {
			if (res.status && res.data) {
				allTransactions = res.data;
				renderAuditTable(allTransactions);
			} else {
				allTransactions = [];
				renderAuditTable([]);
			}
		});
	}

	function renderAuditTable(transactions) {
		const tbody = $('#audit-table-body');
		tbody.empty();

		if (!transactions || transactions.length === 0) {
			$('#audit-table-empty').removeClass('d-none').addClass('content-enter-smooth');
			$('#audit-table-count').text(0);
			return;
		}

		$('#audit-table-empty').addClass('d-none');
		$('#audit-table-count').html(`<span class="content-enter-smooth">${transactions.length}</span>`);

		transactions.forEach((t, idx) => {
			const amountColor = t.is_debit ? '#047857' : (t.is_transfer ? '#1d4ed8' : '#b91c1c');
			const iconClass = t.is_debit ? 'fa-arrow-down text-success' : (t.is_transfer ? 'fa-exchange-alt text-primary' : 'fa-arrow-up text-danger');
			const staggerClass = `stagger-${Math.min(idx + 1, 6)}`;

			// High-contrast type badges
			let badgeStyle = '';
			if (t.is_transfer) {
				badgeStyle = 'background: #2563eb; color: #ffffff;';
			} else if (t.is_debit) {
				badgeStyle = 'background: #059669; color: #ffffff;';
			} else {
				badgeStyle = 'background: #dc2626; color: #ffffff;';
			}

			const rowHtml = `
				<tr class="neu-table-row border-bottom content-enter-smooth ${staggerClass}" style="border-color: #cbd5e1 !important;">
					<td class="py-3 px-3 text-xs font-weight-black text-nowrap" style="color: #0f172a;">${t.date}</td>
					<td class="py-3 px-3">
						<div class="d-flex align-items-center">
							<i class="fas ${iconClass} mr-2.5" style="font-size: 0.95rem;"></i>
							<div>
								<div class="font-weight-black text-xs mb-0" style="color: #0f172a;">${t.description}</div>
								${t.remarks ? `<small class="font-weight-bold" style="font-size: 0.76rem; color: #475569;">${t.remarks}</small>` : ''}
							</div>
						</div>
					</td>
					<td class="py-3 px-3">
						<span class="badge badge-pill px-2.5 py-1 text-xs font-weight-bold" style="background: #e2e8f0; color: #0f172a; border: 1px solid #cbd5e1;">
							${t.category}
						</span>
					</td>
					<td class="py-3 px-3">
						<span class="font-weight-black" style="color: #0f172a; font-size: 0.85rem;">${t.account}</span>
						<div class="font-weight-semibold" style="color: #475569; font-size: 0.78rem;">${t.sub_account}</div>
					</td>
					<td class="py-3 px-3 text-center">
						<span class="badge px-2.5 py-1 text-xs font-weight-black" style="${badgeStyle} letter-spacing: 0.04em; border-radius: 20px;">
							${t.type_label}
						</span>
					</td>
					<td class="py-3 px-3 text-right font-weight-bold" style="font-size: 1.05rem; color: ${amountColor}; font-weight: 800;">
						${t.formatted_amount}
					</td>
				</tr>
			`;
			tbody.append(rowHtml);
		});
	}

	function filterAuditTable(query) {
		if (!query) {
			renderAuditTable(allTransactions);
			return;
		}

		const filtered = allTransactions.filter(t => {
			return (
				t.description.toLowerCase().includes(query) ||
				t.category.toLowerCase().includes(query) ||
				t.account.toLowerCase().includes(query) ||
				t.sub_account.toLowerCase().includes(query) ||
				t.date.toLowerCase().includes(query) ||
				(t.remarks && t.remarks.toLowerCase().includes(query))
			);
		});

		renderAuditTable(filtered);
	}

	function escapeHtml(string) {
		const entityMap = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#39;'
		};
		return String(string).replace(/[&<>"']/g, function (s) {
			return entityMap[s];
		});
	}

});
