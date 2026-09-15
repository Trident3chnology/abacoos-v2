<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}
?>

<!-- Chart.js CDN for Modern Interactive Visualizations -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<style>
	:root {
		--ease-out: cubic-bezier(0.23, 1, 0.32, 1);
		--ease-in-out: cubic-bezier(0.77, 0, 0.175, 1);
	}

	/* High-Contrast Neumorphic Theme Tokens & Typography (ui-ux-pro-max) */
	.neu-raised-card {
		background: #e6e7ee;
		box-shadow: 6px 6px 14px #b8b9be, -6px -6px 14px #ffffff;
		border-radius: 1.55rem;
		border: 1px solid rgba(255, 255, 255, 0.85);
		transition: transform 220ms var(--ease-out), box-shadow 220ms var(--ease-out);
	}

	@media (hover: hover) and (pointer: fine) {
		.neu-raised-card:hover {
			transform: translateY(-2px);
			box-shadow: 8px 8px 18px #b4b5ba, -8px -8px 18px #ffffff;
		}
	}

	.neu-pressed-container {
		background: #dfe4ec;
		box-shadow: inset 3px 3px 6px #b8b9be, inset -3px -3px 6px #ffffff;
		border-radius: 1.25rem;
		border: 1px solid rgba(255, 255, 255, 0.6);
	}

	.neu-segmented-track {
		background: #d8dee8;
		box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff;
		border-radius: 8px;
		padding: 3px;
		display: inline-flex;
		align-items: center;
		flex-wrap: wrap;
		gap: 2px;
	}

	.neu-filter-pill {
		background: transparent;
		border: 1px solid transparent;
		border-radius: 6px;
		color: #334155 !important;
		font-weight: 700 !important;
		font-size: 0.8rem;
		padding: 0.35rem 0.75rem;
		transition: color 150ms var(--ease-out), background-color 150ms var(--ease-out), transform 160ms var(--ease-out), box-shadow 160ms var(--ease-out);
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		user-select: none;
		line-height: 1.2;
	}

	@media (hover: hover) and (pointer: fine) {
		.neu-filter-pill:hover {
			color: #0f172a !important;
			background: rgba(255, 255, 255, 0.5);
		}
	}

	.neu-filter-pill:active {
		transform: scale(0.96);
	}

	.neu-filter-pill.active {
		background: #2D4CC8 !important;
		color: #ffffff !important;
		box-shadow: 2px 2px 6px rgba(45, 76, 200, 0.35), -1px -1px 2px rgba(255, 255, 255, 0.3) !important;
		border-color: #2D4CC8 !important;
	}

	.neu-input-inset {
		background: #dfe4ec !important;
		box-shadow: inset 2px 2px 5px #b8b9be, inset -2px -2px 5px #ffffff !important;
		border: 1px solid rgba(209, 217, 230, 0.9) !important;
		border-radius: 6px !important;
		color: #0f172a !important;
		font-weight: 600 !important;
		font-size: 0.85rem;
		padding: 0.45rem 0.85rem;
		height: 38px;
		transition: border-color 150ms var(--ease-out), box-shadow 150ms var(--ease-out);
	}

	.neu-input-inset::placeholder {
		color: #64748b !important;
		font-weight: 500;
		opacity: 0.9;
	}

	.neu-input-inset option {
		background: #ffffff !important;
		color: #0f172a !important;
		font-weight: 600;
	}

	.neu-input-inset:focus {
		outline: none !important;
		border-color: #2D4CC8 !important;
		box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff, 0 0 0 3px rgba(45, 76, 200, 0.2) !important;
	}

	.neu-filter-select-wrapper {
		position: relative;
		display: inline-flex;
		align-items: center;
	}

	.neu-filter-select-wrapper .neu-select-icon {
		position: absolute;
		left: 14px;
		top: 50%;
		transform: translateY(-50%);
		font-size: 0.85rem;
		color: #64748b;
		pointer-events: none;
		z-index: 3;
		line-height: 1;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		transition: color 150ms var(--ease-out);
	}

	.neu-filter-select-wrapper:focus-within .neu-select-icon {
		color: #2D4CC8;
	}

	.neu-action-btn {
		background: #e6e7ee;
		box-shadow: 3px 3px 8px #b8b9be, -3px -3px 8px #ffffff;
		border: 1px solid rgba(255, 255, 255, 0.9);
		border-radius: 8px;
		color: #1e293b !important;
		font-weight: 700 !important;
		font-size: 0.85rem;
		padding: 0.55rem 1.15rem;
		transition: transform 160ms var(--ease-out), box-shadow 160ms var(--ease-out), color 160ms var(--ease-out);
		display: inline-flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		user-select: none;
	}

	@media (hover: hover) and (pointer: fine) {
		.neu-action-btn:hover {
			transform: translateY(-2px);
			color: #059669 !important;
			box-shadow: 5px 5px 12px #b0b1b6, -5px -5px 12px #ffffff;
		}
	}

	.neu-action-btn:active {
		transform: scale(0.97) translateY(1px);
		box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff;
	}

	.btn-print-premium {
		background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
		color: #ffffff !important;
		font-weight: 700 !important;
		font-size: 0.86rem !important;
		padding: 0.55rem 1.25rem !important;
		border-radius: 8px !important;
		border: 1px solid rgba(255, 255, 255, 0.3) !important;
		box-shadow: 3px 3px 8px #b8b9be, -3px -3px 8px #ffffff, 0 4px 12px rgba(29, 78, 216, 0.35) !important;
		display: inline-flex !important;
		align-items: center !important;
		justify-content: center !important;
		cursor: pointer !important;
		transition: transform 160ms var(--ease-out), box-shadow 160ms var(--ease-out), background 160ms var(--ease-out) !important;
		letter-spacing: 0.02em !important;
		user-select: none !important;
	}

	.btn-print-premium i {
		color: #ffffff !important;
		font-size: 0.95rem !important;
		transition: transform 180ms var(--ease-out) !important;
	}

	@media (hover: hover) and (pointer: fine) {
		.btn-print-premium:hover {
			background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
			box-shadow: 4px 4px 12px #b0b1b6, -4px -4px 12px #ffffff, 0 6px 18px rgba(37, 99, 235, 0.45) !important;
			transform: translateY(-2px) !important;
			color: #ffffff !important;
		}

		.btn-print-premium:hover i {
			transform: scale(1.15) rotate(-5deg) !important;
		}
	}

	.btn-print-premium:active {
		transform: scale(0.97) translateY(1px) !important;
		box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.3) !important;
	}

	.neu-btn-circle {
		width: 38px !important;
		height: 38px !important;
		min-width: 38px !important;
		min-height: 38px !important;
		max-width: 38px !important;
		max-height: 38px !important;
		aspect-ratio: 1 / 1 !important;
		border-radius: 50% !important;
		padding: 0 !important;
		margin: 0 !important;
		display: inline-flex !important;
		align-items: center !important;
		justify-content: center !important;
		flex-shrink: 0 !important;
		background: #e6e7ee !important;
		box-shadow: 3px 3px 7px #b8b9be, -3px -3px 7px #ffffff !important;
		border: 1px solid rgba(255, 255, 255, 0.9) !important;
		color: #1e293b !important;
		transition: transform 160ms var(--ease-out), box-shadow 160ms var(--ease-out), color 160ms var(--ease-out) !important;
		cursor: pointer !important;
		line-height: 1 !important;
	}

	@media (hover: hover) and (pointer: fine) {
		.neu-btn-circle:hover {
			transform: translateY(-1px) scale(1.05) !important;
			color: #2D4CC8 !important;
			box-shadow: 4px 4px 10px #b0b1b6, -4px -4px 10px #ffffff !important;
		}
	}

	.neu-btn-circle:active {
		transform: scale(0.94) !important;
		box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff !important;
	}

	.neu-badge-tag {
		display: inline-flex;
		align-items: center;
		font-size: 0.76rem;
		font-weight: 700;
		color: #1e293b !important;
		background: #e6e7ee;
		box-shadow: 2px 2px 5px #b8b9be, -2px -2px 5px #ffffff;
		border: 1px solid rgba(255, 255, 255, 0.9);
		border-radius: 6px;
		padding: 0.28rem 0.65rem;
		letter-spacing: 0.02em;
		line-height: 1.2;
		user-select: none;
	}

	.neu-badge-verified {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 0.76rem;
		font-weight: 700;
		color: #1d4ed8 !important;
		background: rgba(37, 99, 235, 0.08);
		border: 1px solid rgba(37, 99, 235, 0.25);
		box-shadow: 1px 1px 3px rgba(37, 99, 235, 0.05);
		border-radius: 6px;
		padding: 0.28rem 0.65rem;
		letter-spacing: 0.02em;
		line-height: 1.2;
		user-select: none;
	}

	.neu-badge-verified i {
		color: #2563eb !important;
		font-size: 0.8rem;
	}

	.neu-account-card {
		background: #e6e7ee;
		box-shadow: 5px 5px 12px #b8b9be, -5px -5px 12px #ffffff;
		border-radius: 1.35rem;
		border: 1px solid rgba(255, 255, 255, 0.85);
		transition: transform 220ms var(--ease-out), box-shadow 220ms var(--ease-out);
	}

	@media (hover: hover) and (pointer: fine) {
		.neu-account-card:hover {
			transform: translateY(-3px);
			box-shadow: 8px 8px 16px #b0b1b6, -8px -8px 16px #ffffff;
		}
	}

	.neu-progress-bar-bg {
		background: #d8dee8;
		box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff;
		border-radius: 50rem;
		overflow: hidden;
		height: 9px;
	}

	.neu-table-row {
		transition: background-color 150ms var(--ease-out);
	}

	.neu-table-row:hover {
		background-color: rgba(223, 224, 233, 0.7);
	}

	/* =========================================================
	   NEUMORPHIC SKELETON LOADERS & SMOOTH ANIMATION TOKENS (/animate)
	   ========================================================= */
	.neu-skeleton {
		background: linear-gradient(
			90deg,
			#d8dee8 0%,
			#f1f5f9 50%,
			#d8dee8 100%
		);
		background-size: 200% 100%;
		animation: neuSkeletonShimmer 1.5s infinite linear;
		border-radius: 6px;
		display: inline-block;
		color: transparent !important;
		border: none !important;
		pointer-events: none;
		user-select: none;
		vertical-align: middle;
	}

	.neu-skeleton-circle {
		border-radius: 50% !important;
	}

	.neu-skeleton-card {
		background: #e6e7ee;
		box-shadow: 5px 5px 12px #b8b9be, -5px -5px 12px #ffffff;
		border-radius: 1.35rem;
		border: 1px solid rgba(255, 255, 255, 0.85);
		padding: 1.5rem;
	}

	@keyframes neuSkeletonShimmer {
		0% {
			background-position: 200% 0;
		}
		100% {
			background-position: -200% 0;
		}
	}

	/* Smooth GPU-Accelerated Entrance Transition */
	.content-enter-smooth {
		animation: smoothFadeSlideUp 220ms var(--ease-out) forwards;
		will-change: transform, opacity;
	}

	@keyframes smoothFadeSlideUp {
		0% {
			opacity: 0;
			transform: translateY(6px);
		}
		100% {
			opacity: 1;
			transform: translateY(0);
		}
	}

	/* Micro-stagger utilities for clean group entrances */
	.stagger-1 { animation-delay: 30ms; }
	.stagger-2 { animation-delay: 60ms; }
	.stagger-3 { animation-delay: 90ms; }
	.stagger-4 { animation-delay: 120ms; }
	.stagger-5 { animation-delay: 150ms; }
	.stagger-6 { animation-delay: 180ms; }

	/* Strict Reduced-Motion Compliance */
	@media (prefers-reduced-motion: reduce) {
		.neu-skeleton {
			animation: none !important;
			background: #dfe4ec !important;
		}
		.content-enter-smooth {
			animation: none !important;
			opacity: 1 !important;
			transform: none !important;
			transition: opacity 150ms ease !important;
		}
	}

	.neu-progress-bar-bg {
		background: #d8dee8;
		box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff;
		border-radius: 50rem;
		overflow: hidden;
		height: 9px;
	}

	.neu-table-row {
		transition: background-color 0.15s ease;
	}

	.neu-table-row:hover {
		background-color: rgba(223, 224, 233, 0.7);
	}

	/* High Contrast Typography Tokens */
	.font-weight-black {
		font-weight: 800 !important;
	}

	.text-contrast-title {
		color: #0f172a !important;
		font-weight: 800 !important;
	}

	.text-contrast-body {
		color: #334155 !important;
		font-weight: 500 !important;
	}

	.text-contrast-muted {
		color: #475569 !important;
		font-weight: 600 !important;
	}

	.text-contrast-label {
		color: #1e293b !important;
		font-weight: 700 !important;
		letter-spacing: 0.05em;
	}

	/* =========================================================
	   MOBILE RESPONSIVE ENHANCEMENTS (@media max-width: 768px)
	   Spacious, touch-friendly mobile UX without touching desktop
	   ========================================================= */
	@media (max-width: 768px) {
		/* Header action buttons side-by-side with equal balance */
		.neu-header-actions {
			width: 100% !important;
		}

		.neu-header-actions .neu-action-btn,
		.neu-header-actions .btn-print-premium {
			flex: 1 1 0 !important;
			min-width: 0 !important;
			padding: 0.6rem 0.5rem !important;
			font-size: 0.82rem !important;
			justify-content: center !important;
			text-align: center !important;
		}

		/* Range presets: horizontal smooth swipe without awkward wrapping */
		.neu-presets-wrapper {
			width: 100% !important;
		}

		.neu-segmented-track {
			display: flex !important;
			flex-wrap: nowrap !important;
			overflow-x: auto !important;
			-webkit-overflow-scrolling: touch !important;
			scrollbar-width: none !important;
			width: 100% !important;
			max-width: 100% !important;
			padding: 4px 6px !important;
			gap: 4px !important;
		}

		.neu-segmented-track::-webkit-scrollbar {
			display: none !important;
		}

		.neu-filter-pill {
			flex-shrink: 0 !important;
			white-space: nowrap !important;
			padding: 0.42rem 0.82rem !important;
			font-size: 0.78rem !important;
			min-height: 36px !important;
			display: inline-flex !important;
			align-items: center !important;
			justify-content: center !important;
		}

		/* Custom date row full width balanced inputs */
		.neu-custom-date-row {
			width: 100% !important;
		}

		#custom-date-container {
			width: 100% !important;
			display: flex !important;
			align-items: center !important;
			justify-content: space-between !important;
			gap: 6px !important;
		}

		#filter-start-date,
		#filter-end-date {
			width: 100% !important;
			flex: 1 1 0 !important;
			min-width: 0 !important;
			text-align: center !important;
			font-size: 0.8rem !important;
			padding: 0.4rem 0.4rem !important;
		}

		.neu-date-separator {
			margin: 0 4px !important;
			font-size: 0.78rem !important;
			flex-shrink: 0 !important;
		}

		/* Tier 2 dropdown filters stacked & full-width */
		.neu-filter-tier2-row {
			gap: 10px !important;
		}

		.neu-filter-dropdowns-group {
			width: 100% !important;
			flex-direction: column !important;
			gap: 10px !important;
		}

		.neu-filter-select-wrapper {
			width: 100% !important;
			display: flex !important;
			align-items: center !important;
			position: relative !important;
		}

		.neu-filter-select-wrapper select.neu-input-inset {
			width: 100% !important;
			min-width: 100% !important;
			display: block !important;
			height: 44px !important;
			font-size: 0.88rem !important;
			padding-left: 40px !important;
		}

		.neu-filter-select-wrapper .neu-select-icon {
			left: 14px !important;
			top: 50% !important;
			transform: translateY(-50%) !important;
		}

		/* Search input in table card */
		.neu-table-search-box,
		.neu-table-search-box .position-relative {
			width: 100% !important;
			max-width: 100% !important;
		}

		/* KPI numbers fit gracefully without overflow on narrow screens */
		#kpi-total-inflow,
		#kpi-total-outflow,
		#kpi-net-cashflow {
			font-size: 1.55rem !important;
		}

		/* Card padding optimized for mobile */
		.neu-raised-card {
			padding: 1.15rem 1rem !important;
			border-radius: 1.15rem !important;
		}
	}

	@page {
		size: auto;
		margin: 0mm !important;
	}

	/* =========================================================
	   EXECUTIVE PRINT STYLESHEET (Clean Professional Paper Output)
	   ========================================================= */
	@media print {
		/* 1. Page settings & remove default browser header/footer text (Date, Title, URL) */
		html,
		body {
			margin: 0 !important;
			padding: 0 !important;
			background: #ffffff !important;
			-webkit-print-color-adjust: exact !important;
			print-color-adjust: exact !important;
		}

		/* 2. Strip all printed URL hrefs generated by Bootstrap / Browser */
		a[href]:after,
		a[href]:before,
		abbr[title]:after {
			content: "" !important;
			display: none !important;
		}

		a {
			text-decoration: none !important;
			color: inherit !important;
		}

		/* 3. Hide all non-printable navigation, buttons, and filter controls */
		header,
		.header-global,
		.opt3-navbar,
		#mobile-drawer,
		#mobile-drawer-overlay,
		footer,
		.footer,
		.no-print,
		.d-print-none,
		#btn-export-csv,
		#btn-print-report,
		.neu-action-btn,
		.btn-print-premium,
		#btn-reset-filter,
		.neu-btn-circle,
		#audit-table-search,
		.spinner-border,
		#chart-empty-state,
		#custom-date-container {
			display: none !important;
		}

		/* 4. Ink-friendly pure white background & high contrast text with clean paper margins */
		.section.bg-primary {
			padding: 12mm 15mm !important;
			margin: 0 !important;
			background: #ffffff !important;
		}

		.container,
		.row,
		.col-lg-12 {
			padding-left: 0 !important;
			padding-right: 0 !important;
			margin-left: 0 !important;
			margin-right: 0 !important;
			width: 100% !important;
			max-width: 100% !important;
		}

		/* 5. Clean structured cards on paper */
		.neu-raised-card,
		.neu-account-card {
			border: 1px solid #cbd5e1 !important;
			border-radius: 8px !important;
			padding: 1rem !important;
			margin-bottom: 1.25rem !important;
			page-break-inside: avoid !important;
		}

		.neu-pressed-container {
			border: 1px solid #e2e8f0 !important;
			border-radius: 6px !important;
			background: #f8fafc !important;
		}

		/* 6. Clean itemized ledger table */
		.table-responsive {
			overflow: visible !important;
		}

		table#audit-ledger-table {
			width: 100% !important;
			border-collapse: collapse !important;
			font-size: 0.8rem !important;
		}

		table#audit-ledger-table th {
			background-color: #f1f5f9 !important;
			color: #0f172a !important;
			border-top: 1px solid #0f172a !important;
			border-bottom: 2px solid #0f172a !important;
			font-weight: 800 !important;
			text-transform: uppercase !important;
			padding: 8px 10px !important;
		}

		table#audit-ledger-table td {
			border-bottom: 1px solid #e2e8f0 !important;
			padding: 8px 10px !important;
			color: #0f172a !important;
		}

		table#audit-ledger-table tr {
			page-break-inside: avoid !important;
		}

		.neu-table-row:hover {
			background: transparent !important;
		}

		.badge {
			border: 1px solid #94a3b8 !important;
			background: transparent !important;
			color: #0f172a !important;
			box-shadow: none !important;
		}
	}
</style>

<div class="section bg-primary text-dark section-lg py-4 py-md-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">

				<!-- Dedicated Executive Print Header (Visible ONLY on Print) -->
				<div class="d-none d-print-block mb-4 pb-3 border-bottom" style="border-color: #0f172a !important;">
					<div class="d-flex justify-content-between align-items-end">
						<div>
							<span class="text-uppercase font-weight-black text-muted" style="font-size: 0.72rem; letter-spacing: 0.1em;">Official Statement &bull; Confidential</span>
							<h2 class="font-weight-black text-dark mb-1" style="font-size: 1.5rem; letter-spacing: -0.02em;">ABACOOS FINANCIAL REPORT & AUDIT</h2>
							<p class="text-muted mb-0" style="font-size: 0.82rem;">Enterprise Multi-Account Cashflow Ledger & Audited Expenditure Analysis</p>
						</div>
						<div class="text-right">
							<div class="font-weight-black text-dark" style="font-size: 0.92rem;" id="print-header-period">Period: This Month</div>
							<div class="text-muted" style="font-size: 0.78rem;" id="print-header-scope">Scope: All Accounts</div>
							<div class="text-muted" style="font-size: 0.75rem;" id="print-header-timestamp">Printed: <?= date('M d, Y h:i A'); ?></div>
						</div>
					</div>
				</div>

				<!-- 1. Header & Quick Actions Bar (Screen Only) -->
				<div class="mb-4 no-print">
					<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
						<div>
							<h1 class="h3 font-weight-black text-contrast-title mb-1">Financial Reports & Audit</h1>
							<p class="text-contrast-body mb-0" style="font-size: 0.95rem;">Multi-account cashflow intelligence, expense distribution, and transaction auditing ledger</p>
						</div>
						
						<!-- Action Buttons (CSV Export & Print) -->
						<div class="mt-3 mt-md-0 d-flex align-items-center flex-wrap neu-header-actions" style="gap: 10px;">
							<button type="button" id="btn-export-csv" class="neu-action-btn">
								<i class="fas fa-file-csv mr-2 text-success" style="font-size: 1rem;"></i> Export CSV
							</button>
							<button type="button" id="btn-print-report" class="btn-print-premium">
								<i class="fas fa-print mr-2"></i> Print Report
							</button>
						</div>
					</div>
				</div>

				<!-- 2. Interactive Date & Filter Bar (Screen Only) -->
				<div class="neu-raised-card p-3 p-md-4 mb-4 no-print">
					<!-- Tier 1: Time Horizon & Date Range Scope -->
					<div class="d-flex flex-column flex-xl-row align-items-xl-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: rgba(209, 217, 230, 0.7) !important; gap: 12px;">
						
						<!-- Presets Segmented Group -->
						<div class="d-flex align-items-center flex-wrap neu-presets-wrapper" style="gap: 8px;">
							<div class="d-flex align-items-center justify-content-between w-100 d-xl-none mb-1">
								<span class="text-xs font-weight-bold text-contrast-label text-uppercase d-flex align-items-center">
									<i class="far fa-calendar-alt text-primary mr-1.5" style="font-size: 0.85rem;"></i> Range:
								</span>
								<span class="neu-badge-tag" id="report-period-badge-mobile" style="color: #1d4ed8 !important; background: rgba(37, 99, 235, 0.08); border: 1px solid rgba(37, 99, 235, 0.2); font-size: 0.72rem;">This Month</span>
							</div>
							<span class="text-xs font-weight-bold text-contrast-label mr-1 text-uppercase d-none d-xl-inline-flex align-items-center">
								<i class="far fa-calendar-alt text-primary mr-1.5" style="font-size: 0.85rem;"></i> Range:
							</span>
							<div class="neu-segmented-track">
								<button type="button" class="neu-filter-pill filter-preset-pill" data-range="today">Today</button>
								<button type="button" class="neu-filter-pill filter-preset-pill" data-range="this_week">This Week</button>
								<button type="button" class="neu-filter-pill filter-preset-pill active" data-range="this_month">This Month</button>
								<button type="button" class="neu-filter-pill filter-preset-pill" data-range="last_month">Last Month</button>
								<button type="button" class="neu-filter-pill filter-preset-pill" data-range="last_30_days">Last 30 Days</button>
								<button type="button" class="neu-filter-pill filter-preset-pill" data-range="this_year">This Year</button>
								<button type="button" class="neu-filter-pill filter-preset-pill" data-range="all_time">All Time</button>
								<button type="button" class="neu-filter-pill filter-preset-pill" data-range="custom">Custom</button>
							</div>
						</div>

						<!-- Custom Date Inputs & Active Period Label -->
						<div class="d-flex align-items-center flex-wrap neu-custom-date-row" style="gap: 8px;">
							<div class="d-flex align-items-center" id="custom-date-container">
								<input type="date" id="filter-start-date" class="neu-input-inset" title="Start Date" style="width: 140px; font-size: 0.82rem;">
								<span class="mx-2 font-weight-bold neu-date-separator" style="color: #64748b; font-size: 0.82rem;">to</span>
								<input type="date" id="filter-end-date" class="neu-input-inset" title="End Date" style="width: 140px; font-size: 0.82rem;">
							</div>
							<span class="neu-badge-tag ml-1 d-none d-xl-inline-flex" id="report-period-label" style="color: #1d4ed8 !important; background: rgba(37, 99, 235, 0.08); border: 1px solid rgba(37, 99, 235, 0.2);">This Month</span>
						</div>

					</div>

					<!-- Tier 2: Dimensional Filters & Quick Reset -->
					<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between neu-filter-tier2-row" style="gap: 12px;">
						
						<!-- Dropdown Filters with Icon Indicators -->
						<div class="d-flex align-items-center flex-wrap neu-filter-dropdowns-group" style="gap: 12px;">
							<div class="d-flex align-items-center justify-content-between w-100 d-md-none mb-1">
								<span class="text-xs font-weight-bold text-contrast-label text-uppercase d-flex align-items-center">
									<i class="fas fa-sliders-h text-primary mr-1.5" style="font-size: 0.82rem;"></i> Filters:
								</span>
								<div class="d-flex align-items-center cursor-pointer" onclick="$('#btn-reset-filter').click();" style="gap: 6px;">
									<button type="button" class="neu-btn-circle" style="width: 28px !important; height: 28px !important; min-width: 28px !important; min-height: 28px !important;" title="Reset all filters">
										<i class="fas fa-redo-alt" style="font-size: 0.72rem;"></i>
									</button>
									<span class="text-xs font-weight-bold text-contrast-muted" style="user-select: none; font-size: 0.75rem;">Reset</span>
								</div>
							</div>

							<span class="text-xs font-weight-bold text-contrast-label mr-1 text-uppercase d-none d-md-inline-flex align-items-center">
								<i class="fas fa-sliders-h text-primary mr-1.5" style="font-size: 0.82rem;"></i> Filters:
							</span>

							<!-- Account Filter -->
							<div class="position-relative d-inline-flex align-items-center neu-filter-select-wrapper">
								<i class="fas fa-wallet neu-select-icon" style="left: 14px; top: 50%; transform: translateY(-50%); font-size: 0.85rem; color: #64748b; pointer-events: none; z-index: 3;"></i>
								<select id="filter-account" class="neu-input-inset" style="padding-left: 40px !important; min-width: 180px; cursor: pointer;">
									<option value="all">All Accounts</option>
								</select>
							</div>

							<!-- Category Filter -->
							<div class="position-relative d-inline-flex align-items-center neu-filter-select-wrapper">
								<i class="fas fa-tags neu-select-icon" style="left: 14px; top: 50%; transform: translateY(-50%); font-size: 0.85rem; color: #64748b; pointer-events: none; z-index: 3;"></i>
								<select id="filter-category" class="neu-input-inset" style="padding-left: 40px !important; min-width: 180px; cursor: pointer;">
									<option value="all">All Categories</option>
								</select>
							</div>
						</div>

						<!-- Reset Filter Action (Desktop Only) -->
						<div class="d-none d-md-flex align-items-center" style="gap: 8px;">
							<button type="button" id="btn-reset-filter" class="neu-btn-circle" title="Reset all filters to default" aria-label="Reset Filters">
								<i class="fas fa-redo-alt" style="font-size: 0.85rem;"></i>
							</button>
							<span class="text-xs font-weight-bold text-contrast-muted cursor-pointer" onclick="$('#btn-reset-filter').click();" title="Reset all filters to default" style="user-select: none;">Reset Filters</span>
						</div>

					</div>
				</div>

				<!-- 3. Global KPI Cards Row (High-Contrast & High-Legibility) -->
				<div class="row mb-4">
					<!-- Inflow Card -->
					<div class="col-12 col-md-4 mb-3 mb-md-0">
						<div class="neu-raised-card p-4 h-100 position-relative overflow-hidden">
							<div class="d-flex align-items-center justify-content-between mb-2">
								<span class="text-xs font-weight-bold text-uppercase tracking-wider" style="color: #065f46; font-size: 0.78rem;">Total Inflow (Debits)</span>
								<div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(0, 200, 83, 0.16); color: #047857;">
									<i class="fas fa-arrow-down" style="font-size: 0.95rem;"></i>
								</div>
							</div>
							<h3 class="font-weight-bold mb-1" id="kpi-total-inflow" style="font-size: 1.75rem; color: #047857; font-weight: 800;">
								<span class="neu-skeleton" style="width: 140px; height: 1.75rem;">&nbsp;</span>
							</h3>
							<div class="text-xs" style="color: #334155; font-weight: 600;">
								<span class="text-success font-weight-bold mr-1"><i class="fas fa-check-circle"></i> Inflow</span> credited to accounts
							</div>
						</div>
					</div>

					<!-- Outflow Card -->
					<div class="col-12 col-md-4 mb-3 mb-md-0">
						<div class="neu-raised-card p-4 h-100 position-relative overflow-hidden">
							<div class="d-flex align-items-center justify-content-between mb-2">
								<span class="text-xs font-weight-bold text-uppercase tracking-wider" style="color: #991b1b; font-size: 0.78rem;">Total Outflow (Credits)</span>
								<div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(220, 53, 69, 0.16); color: #b91c1c;">
									<i class="fas fa-arrow-up" style="font-size: 0.95rem;"></i>
								</div>
							</div>
							<h3 class="font-weight-bold mb-1" id="kpi-total-outflow" style="font-size: 1.75rem; color: #b91c1c; font-weight: 800;">
								<span class="neu-skeleton" style="width: 140px; height: 1.75rem;">&nbsp;</span>
							</h3>
							<div class="text-xs" style="color: #334155; font-weight: 600;">
								<span class="text-danger font-weight-bold mr-1"><i class="fas fa-arrow-circle-up"></i> Outflow</span> spent / withdrawn
							</div>
						</div>
					</div>

					<!-- Net Cashflow Card -->
					<div class="col-12 col-md-4">
						<div class="neu-raised-card p-4 h-100 position-relative overflow-hidden">
							<div class="d-flex align-items-center justify-content-between mb-2">
								<span class="text-xs font-weight-bold text-uppercase tracking-wider" style="color: #1e3a8a; font-size: 0.78rem;">Net Cashflow</span>
								<div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(45, 76, 200, 0.16); color: #1d4ed8;">
									<i class="fas fa-balance-scale" style="font-size: 0.95rem;"></i>
								</div>
							</div>
							<h3 class="font-weight-bold mb-1" id="kpi-net-cashflow" style="font-size: 1.75rem; color: #1d4ed8; font-weight: 800;">
								<span class="neu-skeleton" style="width: 140px; height: 1.75rem;">&nbsp;</span>
							</h3>
							<div class="text-xs" style="color: #334155; font-weight: 600;" id="kpi-savings-rate-label">
								<span class="font-weight-bold text-primary mr-1" id="kpi-savings-rate"><span class="neu-skeleton" style="width: 45px; height: 1rem;">&nbsp;</span></span> net retention rate
							</div>
						</div>
					</div>
				</div>

				<!-- 4. Multi-Account Audit Breakdown Cards (Core Star Feature of Option B) -->
				<div class="mb-5">
					<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-3" style="gap: 8px;">
						<div>
							<h4 class="h5 font-weight-black text-contrast-title mb-1">
								<i class="fas fa-university text-primary mr-2"></i>Multi-Account Audit Breakdown
							</h4>
							<p class="text-contrast-body mb-0" style="font-size: 0.88rem;">Audited cash movement, credits, debits, and balance contribution per account</p>
						</div>
						<div class="font-weight-bold" style="font-size: 0.88rem; color: #1e293b;">
							Total Volume: <span class="font-weight-black text-primary" id="total-volume-indicator">₱0.00</span>
						</div>
					</div>

					<!-- Container populated dynamically via report.js -->
					<div class="row" id="account-cards-container">
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
						<div class="col-12 col-md-6 col-xl-4 mb-4 d-none d-md-block">
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
						<div class="col-12 col-md-6 col-xl-4 mb-4 d-none d-xl-block">
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
					</div>
				</div>

				<!-- 5. Category Distribution & Analytics Breakdown Row -->
				<div class="row mb-5">
					<!-- Donut Chart & Category Spending -->
					<div class="col-12 col-lg-5 mb-4 mb-lg-0">
						<div class="neu-raised-card p-4 h-100">
							<div class="d-flex align-items-center justify-content-between mb-3">
								<h5 class="h6 font-weight-black text-contrast-title mb-0">Expense by Category</h5>
								<span class="neu-badge-tag" id="category-count-badge">0 Categories</span>
							</div>
							
							<!-- Donut Canvas Container -->
							<div class="position-relative d-flex justify-content-center my-3" style="max-height: 220px;">
								<canvas id="categoryDonutChart" width="220" height="220"></canvas>
								<div id="chart-empty-state" class="position-absolute d-none text-center" style="top: 38%; left: 0; right: 0; color: #475569;">
									<i class="fas fa-chart-pie fa-2x mb-2" style="color: #64748b;"></i>
									<p class="text-xs font-weight-bold mb-0" style="color: #334155;">No expense records in range</p>
								</div>
							</div>

							<!-- Ranked Category List -->
							<div class="mt-4" id="category-ranked-list" style="max-height: 220px; overflow-y: auto;">
								<div class="d-flex align-items-center justify-content-between py-2.5 border-bottom" style="border-color: #cbd5e1 !important;">
									<div class="d-flex align-items-center">
										<div class="neu-skeleton neu-skeleton-circle mr-2" style="width: 12px; height: 12px;"></div>
										<div class="neu-skeleton" style="width: 110px; height: 14px;"></div>
									</div>
									<div class="d-flex align-items-center">
										<div class="neu-skeleton mr-2" style="width: 75px; height: 14px;"></div>
										<div class="neu-skeleton" style="width: 40px; height: 20px; border-radius: 6px;"></div>
									</div>
								</div>
								<div class="d-flex align-items-center justify-content-between py-2.5 border-bottom" style="border-color: #cbd5e1 !important;">
									<div class="d-flex align-items-center">
										<div class="neu-skeleton neu-skeleton-circle mr-2" style="width: 12px; height: 12px;"></div>
										<div class="neu-skeleton" style="width: 90px; height: 14px;"></div>
									</div>
									<div class="d-flex align-items-center">
										<div class="neu-skeleton mr-2" style="width: 65px; height: 14px;"></div>
										<div class="neu-skeleton" style="width: 40px; height: 20px; border-radius: 6px;"></div>
									</div>
								</div>
								<div class="d-flex align-items-center justify-content-between py-2.5 border-bottom" style="border-color: #cbd5e1 !important;">
									<div class="d-flex align-items-center">
										<div class="neu-skeleton neu-skeleton-circle mr-2" style="width: 12px; height: 12px;"></div>
										<div class="neu-skeleton" style="width: 130px; height: 14px;"></div>
									</div>
									<div class="d-flex align-items-center">
										<div class="neu-skeleton mr-2" style="width: 80px; height: 14px;"></div>
										<div class="neu-skeleton" style="width: 40px; height: 20px; border-radius: 6px;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Cashflow Trajectory & Summary Insights -->
					<div class="col-12 col-lg-7">
						<div class="neu-raised-card p-4 h-100 d-flex flex-column">
							<div class="d-flex align-items-center justify-content-between mb-3">
								<div>
									<h5 class="h6 font-weight-black text-contrast-title mb-0">Audit Summary & Balance Health</h5>
									<p class="text-contrast-body text-xs mb-0">Ledger balance velocity and account health index</p>
								</div>
								<span class="neu-badge-verified">
									<i class="fas fa-shield-alt"></i> Verified Audit
								</span>
							</div>

							<!-- Audit Metrics Bento Grid -->
							<div class="row flex-grow-1">
								<div class="col-12 col-md-6 mb-3">
									<div class="neu-pressed-container p-3 h-100 d-flex flex-column justify-content-between">
										<div class="text-xs font-weight-bold text-uppercase mb-2" style="color: #1e3a8a; letter-spacing: 0.05em;">Net Cash Retention</div>
										<h4 class="font-weight-bold text-primary mb-1" id="insight-retention-rate" style="font-size: 1.5rem; font-weight: 800;">0%</h4>
										<p class="text-xs mb-0" style="color: #334155; font-weight: 500;">Proportion of gross inflow retained after all outflows.</p>
									</div>
								</div>

								<div class="col-12 col-md-6 mb-3">
									<div class="neu-pressed-container p-3 h-100 d-flex flex-column justify-content-between">
										<div class="text-xs font-weight-bold text-uppercase mb-2" style="color: #991b1b; letter-spacing: 0.05em;">Average Outflow Velocity</div>
										<h4 class="font-weight-bold text-danger mb-1" id="insight-avg-outflow" style="font-size: 1.5rem; font-weight: 800;">₱0.00</h4>
										<p class="text-xs mb-0" style="color: #334155; font-weight: 500;">Average size of expenses registered across all accounts.</p>
									</div>
								</div>

								<div class="col-12 col-md-6 mb-3 mb-md-0">
									<div class="neu-pressed-container p-3 h-100 d-flex flex-column justify-content-between">
										<div class="text-xs font-weight-bold text-uppercase mb-2" style="color: #0f172a; letter-spacing: 0.05em;">Top Active Account</div>
										<h4 class="font-weight-black mb-1" id="insight-top-account" style="font-size: 1.25rem; color: #0f172a;">None</h4>
										<p class="text-xs mb-0" style="color: #334155; font-weight: 500;">Highest transaction volume account in this reporting period.</p>
									</div>
								</div>

								<div class="col-12 col-md-6">
									<div class="neu-pressed-container p-3 h-100 d-flex flex-column justify-content-between">
										<div class="text-xs font-weight-bold text-uppercase mb-2" style="color: #0f172a; letter-spacing: 0.05em;">Dominant Spending Category</div>
										<h4 class="font-weight-black mb-1" id="insight-top-category" style="font-size: 1.25rem; color: #0f172a;">None</h4>
										<p class="text-xs mb-0" style="color: #334155; font-weight: 500;">Single largest expense destination in this reporting period.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- 6. Comprehensive Audit Ledger Table (Option B) -->
				<div class="neu-raised-card p-4">
					<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom border-secondary" style="border-color: rgba(209, 217, 230, 0.8) !important;">
						<div>
							<h4 class="h5 font-weight-black text-contrast-title mb-1">
								<i class="fas fa-clipboard-list text-primary mr-2"></i>Detailed Audit Ledger
							</h4>
							<p class="text-contrast-body text-xs mb-0" style="font-size: 0.85rem;">Itemized line-by-line transactions verified for this reporting timeframe</p>
						</div>
						
						<!-- Search Filter Box -->
						<div class="mt-3 mt-md-0 d-flex align-items-center neu-table-search-box">
							<div class="position-relative" style="width: 280px;">
								<i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.85rem; color: #64748b; pointer-events: none;"></i>
								<input type="text" id="audit-table-search" class="neu-input-inset w-100" style="padding-left: 36px !important;" placeholder="Search description, account...">
							</div>
						</div>
					</div>

					<!-- Table Container -->
					<div class="table-responsive">
						<table class="table table-borderless align-items-center mb-0" id="audit-ledger-table">
							<thead>
								<tr class="text-uppercase border-bottom" style="border-color: #cbd5e1 !important; color: #0f172a; font-size: 0.78rem; font-weight: 800; letter-spacing: 0.05em;">
									<th class="py-3 px-3">Date</th>
									<th class="py-3 px-3">Description</th>
									<th class="py-3 px-3">Category</th>
									<th class="py-3 px-3">Account & Sub-Account</th>
									<th class="py-3 px-3 text-center">Type</th>
									<th class="py-3 px-3 text-right">Amount</th>
								</tr>
							</thead>
							<tbody id="audit-table-body">
								<!-- Initial Skeleton Rows for instant visual feedback -->
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
								<tr class="border-bottom" style="border-color: #cbd5e1 !important;">
									<td class="py-3 px-3"><div class="neu-skeleton" style="width: 80px; height: 14px;"></div></td>
									<td class="py-3 px-3">
										<div class="d-flex align-items-center">
											<div class="neu-skeleton neu-skeleton-circle mr-2.5" style="width: 22px; height: 22px;"></div>
											<div>
												<div class="neu-skeleton mb-1" style="width: 160px; height: 14px;"></div>
												<div class="neu-skeleton" style="width: 70px; height: 10px;"></div>
											</div>
										</div>
									</td>
									<td class="py-3 px-3"><div class="neu-skeleton rounded-pill" style="width: 75px; height: 22px;"></div></td>
									<td class="py-3 px-3">
										<div class="neu-skeleton mb-1" style="width: 110px; height: 14px;"></div>
										<div class="neu-skeleton" style="width: 50px; height: 10px;"></div>
									</td>
									<td class="py-3 px-3 text-center"><div class="neu-skeleton rounded-pill" style="width: 60px; height: 22px;"></div></td>
									<td class="py-3 px-3 text-right"><div class="neu-skeleton" style="width: 85px; height: 16px;"></div></td>
								</tr>
								<tr class="border-bottom" style="border-color: #cbd5e1 !important;">
									<td class="py-3 px-3"><div class="neu-skeleton" style="width: 80px; height: 14px;"></div></td>
									<td class="py-3 px-3">
										<div class="d-flex align-items-center">
											<div class="neu-skeleton neu-skeleton-circle mr-2.5" style="width: 22px; height: 22px;"></div>
											<div>
												<div class="neu-skeleton mb-1" style="width: 130px; height: 14px;"></div>
												<div class="neu-skeleton" style="width: 90px; height: 10px;"></div>
											</div>
										</div>
									</td>
									<td class="py-3 px-3"><div class="neu-skeleton rounded-pill" style="width: 85px; height: 22px;"></div></td>
									<td class="py-3 px-3">
										<div class="neu-skeleton mb-1" style="width: 95px; height: 14px;"></div>
										<div class="neu-skeleton" style="width: 65px; height: 10px;"></div>
									</td>
									<td class="py-3 px-3 text-center"><div class="neu-skeleton rounded-pill" style="width: 60px; height: 22px;"></div></td>
									<td class="py-3 px-3 text-right"><div class="neu-skeleton" style="width: 95px; height: 16px;"></div></td>
								</tr>
							</tbody>
						</table>
					</div>

					<!-- Empty State Container -->
					<div id="audit-table-empty" class="text-center py-5 d-none">
						<div class="d-inline-flex align-items-center justify-content-center rounded-circle neu-pressed-container p-4 mb-3" style="color: #475569;">
							<i class="fas fa-folder-open fa-2x"></i>
						</div>
						<h5 class="h6 font-weight-black text-contrast-title mb-1">No Transactions Found</h5>
						<p class="text-contrast-body text-xs mb-0">There are no transactions matching the selected dates and filters.</p>
					</div>

					<!-- Table Footer / Count -->
					<div class="d-flex align-items-center justify-content-between mt-3 pt-3 border-top" style="border-color: #cbd5e1 !important; font-size: 0.85rem;">
						<div style="color: #1e293b; font-weight: 600;">
							Showing <span id="audit-table-count" class="font-weight-black text-primary">0</span> transaction records
						</div>
						<div class="text-right d-print-none">
							<a href="<?= WEB_ROOT; ?>transaction" class="font-weight-black text-primary hover:underline">
								Open Full Transactions Page <i class="fas fa-arrow-right ml-1"></i>
							</a>
						</div>
					</div>
				</div>

				<!-- Dedicated Executive Print Footer (Visible ONLY on Print) -->
				<div class="d-none d-print-block mt-4 pt-3 border-top text-center text-muted" style="border-color: #cbd5e1 !important; font-size: 0.75rem;">
					<span>Generated by Abacoos Financial System &bull; Confidential Auditing Record</span>
				</div>

			</div>
		</div>
	</div>
</div>

<!-- Report Logic JS -->
<script src="<?= WEB_ROOT; ?>assets/js/report.js?v=<?= time(); ?>"></script>
