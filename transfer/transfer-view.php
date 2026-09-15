<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}
?>

<div class="row">

	<!-- Left Column: Transfer Selection Cards -->
	<div class="col-12 col-lg-4 mb-4 mb-lg-0">
		<div class="card bg-primary border-light shadow-soft rounded-2xl p-4 h-100" style="overflow: visible !important;">
			<span class="text-xs font-weight-black text-gray-700 uppercase tracking-wider block mb-4"
				style="color: #475569 !important;">
				Transfer Selection
			</span>

			<!-- Source Account Card (Dark Royal Blue Gradient) -->
			<div class="card border-0 rounded-2xl p-4 mb-3 position-relative text-white shadow-lg mx-auto w-100 overflow-hidden"
				id="card-source-summary"
				style="background: linear-gradient(135deg, #1e1b4b 0%, #1e3a8a 50%, #0f172a 100%); min-height: 165px; max-width: 320px; box-shadow: 0 10px 25px -5px rgba(30, 27, 75, 0.4);">
				<div class="card-specular-sheen" id="sheen-source"></div>
				<div class="d-flex align-items-center justify-content-between mb-3">
					<div class="d-flex align-items-center">
						<div class="d-flex align-items-center justify-content-center rounded-circle mr-2"
							style="width: 26px; height: 26px; background: rgba(255,255,255,0.15);">
							<svg width="14px" height="14px" viewBox="0 0 24 24" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M22 9V17C22 18.1046 21.1046 19 20 19H4C2.89543 19 2 18.1046 2 17V7C2 5.89543 2.89543 5 4 5H20C21.1046 5 22 5.89543 22 7V9ZM22 9H6"
									stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								</path>
							</svg>
						</div>
						<span class="font-weight-black uppercase tracking-wider text-xs"
							style="font-size: 0.72rem; color: #a5b4fc;">SOURCE</span>
					</div>
					<!-- EMV Credit Card Chip -->
					<div class="rounded"
						style="width: 32px; height: 22px; background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); border: 1px solid rgba(255,255,255,0.3); border-radius: 4px;">
					</div>
				</div>

				<p class="font-weight-bold uppercase mb-3 text-truncate" id="lbl-source-name"
					style="font-size: 0.85rem; color: #ffffff; letter-spacing: 0.02em;">
					<span class="skeleton-line" style="width: 75%;"></span>
				</p>

				<div class="d-flex align-items-end justify-content-between mt-auto">
					<div>
						<span class="text-xs uppercase tracking-wider display-block font-weight-bold mb-1"
							id="lbl-source-balance-label" style="color: #93c5fd; font-size: 0.65rem;">AVAILABLE
							BALANCE</span>
						<div class="h3 font-weight-black mb-0 font-fira-code text-white" id="lbl-source-balance">
							<span class="skeleton-line" style="width: 110px; height: 1.5rem;"></span>
						</div>
					</div>
					<!-- Card Logo Badge Container -->
					<div class="d-flex align-items-center justify-content-end" id="lbl-source-logo-container"
						style="max-width: 100px; height: 26px;">
						<div class="rounded-circle"
							style="width: 20px; height: 20px; background: rgba(255,255,255,0.3); margin-right: -6px;">
						</div>
						<div class="rounded-circle"
							style="width: 20px; height: 20px; background: rgba(255,255,255,0.5);"></div>
					</div>
				</div>
			</div>

			<!-- Directional Flow Swap Arrow Divider -->
			<div class="text-center my-2 position-relative" style="z-index: 5;">
				<button type="button"
					class="btn btn-swap-divider d-inline-flex align-items-center justify-content-center border-0 rounded-circle p-0 transition-all duration-200 neu-btn-press"
					id="btn-swap-accounts" title="Swap Debit and Credit Accounts" style="width: 38px; height: 38px; background: #e6e7ee; box-shadow: 4px 4px 10px #b8b9be, -4px -4px 10px #ffffff;">
					<img src="<?= WEB_ROOT; ?>assets/img/icons/transfer-dropdown.svg" alt="Swap" id="img-swap-icon" style="width: 20px; height: 20px;">
				</button>
			</div>

			<!-- Target Account Card (Dark Emerald Green Gradient) -->
			<div class="card border-0 rounded-2xl p-4 mt-1 mb-4 position-relative text-white shadow-lg mx-auto w-100 overflow-hidden"
				id="card-target-summary"
				style="background: linear-gradient(135deg, #064e3b 0%, #047857 50%, #022c22 100%); min-height: 165px; max-width: 320px; box-shadow: 0 10px 25px -5px rgba(6, 78, 59, 0.4);">
				<div class="card-specular-sheen" id="sheen-target"></div>
				<div class="d-flex align-items-center justify-content-between mb-3">
					<div class="d-flex align-items-center">
						<div class="d-flex align-items-center justify-content-center rounded-circle mr-2"
							style="width: 26px; height: 26px; background: rgba(255,255,255,0.15);">
							<svg width="14px" height="14px" viewBox="0 0 24 24" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path
									d="M22 9V17C22 18.1046 21.1046 19 20 19H4C2.89543 19 2 18.1046 2 17V7C2 5.89543 2.89543 5 4 5H20C21.1046 5 22 5.89543 22 7V9ZM22 9H6"
									stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								</path>
							</svg>
						</div>
						<span class="font-weight-black uppercase tracking-wider text-xs"
							style="font-size: 0.72rem; color: #6ee7b7;">TARGET</span>
					</div>
					<!-- EMV Credit Card Chip -->
					<div class="rounded"
						style="width: 32px; height: 22px; background: linear-gradient(135deg, #e2e8f0 0%, #94a3b8 100%); border: 1px solid rgba(255,255,255,0.3); border-radius: 4px;">
					</div>
				</div>

				<p class="font-weight-bold uppercase mb-3 text-truncate" id="lbl-target-name"
					style="font-size: 0.85rem; color: #ffffff; letter-spacing: 0.02em;">
					<span class="skeleton-line" style="width: 75%;"></span>
				</p>

				<div class="d-flex align-items-end justify-content-between mt-auto">
					<div>
						<span class="text-xs uppercase tracking-wider display-block font-weight-bold mb-1"
							id="lbl-target-balance-label" style="color: #a7f3d0; font-size: 0.65rem;">CURRENT
							BALANCE</span>
						<div class="h3 font-weight-black mb-0 font-fira-code text-white" id="lbl-target-balance">
							<span class="skeleton-line" style="width: 110px; height: 1.5rem;"></span>
						</div>
					</div>
					<!-- Card Logo Badge Container -->
					<div class="d-flex align-items-center justify-content-end" id="lbl-target-logo-container"
						style="max-width: 100px; height: 26px;">
						<div class="rounded-circle"
							style="width: 20px; height: 20px; background: rgba(255,255,255,0.3); margin-right: -6px;">
						</div>
						<div class="rounded-circle"
							style="width: 20px; height: 20px; background: rgba(255,255,255,0.5);"></div>
					</div>
				</div>
			</div>

			<!-- Helper Hint -->
			<div class="mt-auto pt-3 border-top border-gray-300/40 text-xs text-gray-600 d-flex align-items-center"
				style="color: #64748b !important;">
				<i class="fa-solid fa-circle-info mr-2 text-primary"></i>
				<span>Select source and target sub-accounts to preview live balances.</span>
			</div>
		</div>
	</div>

	<!-- Right Column: Interactive Transfer Form -->
	<div class="col-12 col-lg-8">
		<div class="card bg-primary border-light shadow-soft rounded-2xl p-4 p-md-5">
			<form id="form-transfer" enctype="multipart/form-data" method="POST">

				<!-- Row 1: Debit From & Credit To Selectors -->
				<div class="row">
					<div class="col-12 col-md-6 mb-4">
						<label
							class="text-xs font-weight-black text-gray-700 uppercase tracking-wider mb-2 display-block"
							for="sel-debit-from" style="color: #334155 !important;">
							Debit From (Source)
						</label>
						<div class="d-flex align-items-center bg-primary shadow-inset rounded-pill px-3 py-1.5">
							<div class="mr-2 d-flex align-items-center justify-content-center flex-shrink-0">
								<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M22 9V17C22 18.1046 21.1046 19 20 19H4C2.89543 19 2 18.1046 2 17V7C2 5.89543 2.89543 5 4 5H20C21.1046 5 22 5.89543 22 7V9ZM22 9H6"
										stroke="#2D4CC8" stroke-width="2" stroke-linecap="round"
										stroke-linejoin="round"></path>
								</svg>
							</div>
							<select id="sel-debit-from" name="fromAccount"
								class="custom-select bg-transparent border-0 text-dark font-weight-bold p-0 shadow-none outline-none w-100"
								style="color: #0f172a !important; height: 38px; background-color: transparent !important; border: 0 !important; box-shadow: none !important; outline: none !important;"
								required>
								<option value="">Select Source Sub-Account</option>
							</select>
						</div>
					</div>

					<div class="col-12 col-md-6 mb-4">
						<label
							class="text-xs font-weight-black text-gray-700 uppercase tracking-wider mb-2 display-block"
							for="sel-credit-to" style="color: #334155 !important;">
							Credit To (Target)
						</label>
						<div class="d-flex align-items-center bg-primary shadow-inset rounded-pill px-3 py-1.5">
							<div class="mr-2 d-flex align-items-center justify-content-center flex-shrink-0">
								<svg width="18px" height="18px" viewBox="0 0 24 24" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
										d="M22 9V17C22 18.1046 21.1046 19 20 19H4C2.89543 19 2 18.1046 2 17V7C2 5.89543 2.89543 5 4 5H20C21.1046 5 22 5.89543 22 7V9ZM22 9H6"
										stroke="#059669" stroke-width="2" stroke-linecap="round"
										stroke-linejoin="round"></path>
								</svg>
							</div>
							<select id="sel-credit-to" name="toAccount"
								class="custom-select bg-transparent border-0 text-dark font-weight-bold p-0 shadow-none outline-none w-100"
								style="color: #0f172a !important; height: 38px; background-color: transparent !important; border: 0 !important; box-shadow: none !important; outline: none !important;"
								required>
								<option value="">Select Target Sub-Account</option>
							</select>
						</div>
					</div>
				</div>

				<!-- Row 2: Transfer Amount Section -->
				<div class="mb-4">
					<label class="text-xs font-weight-black uppercase tracking-wider mb-2 display-block"
						for="txt-transfer-amount" style="color: #475569 !important; font-size: 0.75rem;">
						TRANSFER AMOUNT
					</label>

					<div
						class="d-flex align-items-center justify-content-between bg-primary shadow-inset rounded-pill px-3 py-2">
						<div class="d-flex align-items-center flex-grow-1 mr-2 position-relative">
							<span class="font-weight-black mr-1 currency-peso" id="lbl-peso-symbol"
								style="color: #94a3b8; font-size: 0.92rem; line-height: 1; vertical-align: super; transform: translateY(-0.25em); transition: color 180ms ease;">₱</span>
							<input type="text" id="txt-transfer-amount" name="transferAmount"
								class="form-control bg-transparent border-0 font-weight-black mb-0 p-0 outline-none shadow-none w-100"
								placeholder="0.00" required autocomplete="off"
								style="font-family: 'Outfit', sans-serif !important; font-size: 1.45rem; height: auto; background-color: transparent !important; border: 0 !important; box-shadow: none !important; letter-spacing: -0.01em;">
						</div>
						<button type="button"
							class="btn btn-xs btn-primary shadow-soft rounded-pill font-weight-black px-3 py-1 btn-preset-max flex-shrink-0"
							style="font-size: 0.7rem; color: #2D4CC8 !important; background: #e6e7ee;">
							MAX
						</button>
					</div>
				</div>

				<!-- Row 3: Category & Transfer Date -->
				<div class="row">
					<div class="col-12 col-md-6 mb-4">
						<label
							class="text-xs font-weight-black text-gray-700 uppercase tracking-wider mb-2 display-block"
							for="sel-transfer-category" style="color: #334155 !important;">
							Category
						</label>
						<div class="d-flex align-items-center bg-primary shadow-inset rounded-pill px-3 py-1.5">
							<div class="mr-2 d-flex align-items-center justify-content-center flex-shrink-0">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
									<g fill="none" stroke="#64748b" stroke-linecap="round" stroke-linejoin="round"
										stroke-width="1.5">
										<circle cx="17" cy="7" r="3" fill="#64748b" />
										<circle cx="7" cy="17" r="3" fill="#64748b" />
										<path
											d="M14 14h6v5a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-5ZM4 4h6v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4Z"
											fill="#64748b" />
									</g>
								</svg>
							</div>
							<select id="sel-transfer-category" name="transferCategory"
								class="custom-select bg-transparent border-0 text-dark font-weight-bold p-0 shadow-none outline-none w-100"
								style="color: #0f172a !important; height: 38px; background-color: transparent !important; border: 0 !important; box-shadow: none !important; outline: none !important;">
								<option value="">Internal Savings / Transfer</option>
							</select>
						</div>
					</div>

					<div class="col-12 col-md-6 mb-4">
						<label
							class="text-xs font-weight-black text-gray-700 uppercase tracking-wider mb-2 display-block"
							for="txt-transfer-date" style="color: #334155 !important;">
							Transfer Date
						</label>
						<div class="d-flex align-items-center bg-primary shadow-inset rounded-pill px-3 py-1.5">
							<div class="mr-2 d-flex align-items-center justify-content-center flex-shrink-0">
								<i class="fa-solid fa-calendar-days" style="color: #64748b;"></i>
							</div>
							<input type="date" id="txt-transfer-date" name="transferDate"
								class="form-control bg-transparent border-0 text-dark font-weight-bold p-0 shadow-none outline-none w-100"
								style="color: #0f172a !important; height: 38px; background-color: transparent !important; border: 0 !important; box-shadow: none !important; outline: none !important;"
								value="<?= date('Y-m-d'); ?>" required>
						</div>
					</div>
				</div>

				<!-- Submit Button -->
				<button type="submit" id="btn-submit-transfer"
					class="btn btn-block btn-primary shadow-soft border-0 text-white font-weight-black py-3 rounded-xl uppercase tracking-wider"
					style="background: linear-gradient(135deg, #2D4CC8 0%, #1e3a8a 100%); font-size: 1rem;">
					<i class="fa-solid fa-arrow-right-arrow-left mr-2"></i> Confirm Transfer
				</button>
				<p class="text-center text-xs font-weight-bold uppercase tracking-wider mt-3 mb-0"
					style="color: #64748b !important;">
					Funds will be transferred instantly between sub-accounts
				</p>

			</form>
		</div>
	</div>

</div>

<style>
	/* 3D Card Orbit Swap Motion & Lighting Effects (/animate) */
	#card-source-summary,
	#card-target-summary {
		will-change: transform, opacity, box-shadow;
		transform-origin: center center;
		backface-visibility: hidden;
		-webkit-backface-visibility: hidden;
	}

	#img-swap-icon {
		transition: transform 380ms cubic-bezier(0.34, 1.56, 0.64, 1);
		display: inline-block;
	}

	#btn-swap-accounts {
		transition: transform 200ms cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 200ms ease !important;
	}

	#btn-swap-accounts:active {
		transform: scale(0.88) !important;
	}

	/* Dynamic Metallic Specular Light Sheen Overlay (/animate) */
	.card-specular-sheen {
		position: absolute;
		top: -50%;
		left: -60%;
		width: 220%;
		height: 200%;
		background: linear-gradient(
			115deg,
			rgba(255, 255, 255, 0) 0%,
			rgba(255, 255, 255, 0.05) 38%,
			rgba(255, 255, 255, 0.4) 50%,
			rgba(255, 255, 255, 0.05) 62%,
			rgba(255, 255, 255, 0) 100%
		);
		transform: translateX(-100%);
		pointer-events: none;
		z-index: 15;
		opacity: 0;
	}

	.card-sheen-active {
		opacity: 1 !important;
		animation: cardSheenSweep 420ms ease-in-out forwards;
	}

	@keyframes cardSheenSweep {
		0% {
			transform: translateX(-90%);
			opacity: 0.1;
		}
		50% {
			opacity: 1;
		}
		100% {
			transform: translateX(90%);
			opacity: 0;
		}
	}

	/* Swap Button Haptic Pulse */
	.btn-swap-pulse {
		animation: swapBtnPulse 380ms cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
	}

	@keyframes swapBtnPulse {
		0% {
			transform: scale(0.86);
			box-shadow: 0 0 0 0 rgba(45, 76, 200, 0.4), 4px 4px 10px #b8b9be, -4px -4px 10px #ffffff;
		}
		50% {
			transform: scale(1.16);
			box-shadow: 0 0 0 12px rgba(45, 76, 200, 0), 6px 6px 14px #b8b9be, -6px -6px 14px #ffffff;
		}
		100% {
			transform: scale(1);
			box-shadow: 4px 4px 10px #b8b9be, -4px -4px 10px #ffffff;
		}
	}

	@media (prefers-reduced-motion: reduce) {
		#card-source-summary,
		#card-target-summary {
			transition: opacity 120ms ease !important;
			transform: none !important;
		}
		.card-specular-sheen,
		.btn-swap-pulse {
			animation: none !important;
		}
	}

	/* Single Stationary Neumorphic Modal & In-Place Morph (/animate) */
	#modal-transfer-process .modal-content {
		background-color: #e6e7ee !important;
		border: 1px solid rgba(255, 255, 255, 0.8) !important;
		box-shadow: none !important;
		border-radius: 1.25rem !important;
	}

	#modal-transfer-content-wrapper {
		transition: opacity 220ms ease-in-out, transform 220ms ease-in-out !important;
	}

	.modal-content-fade-out {
		opacity: 0 !important;
		transform: scale(0.96) !important;
	}

	.modal-content-fade-in {
		opacity: 1 !important;
		transform: scale(1) !important;
	}

	#lottie-container {
		width: 160px !important;
		height: 160px !important;
		min-height: 160px !important;
		margin: 0 auto !important;
	}

	/* Fix Select2 Double Container & Double Border Effect */
	.shadow-inset .select2-container {
		width: 100% !important;
		flex: 1 1 auto !important;
	}

	.shadow-inset .select2-container--default .select2-selection--single {
		background-color: transparent !important;
		border: none !important;
		box-shadow: none !important;
		height: 38px !important;
		display: flex !important;
		align-items: center !important;
		outline: none !important;
	}

	.shadow-inset .select2-container--default .select2-selection--single .select2-selection__rendered {
		color: #0f172a !important;
		font-weight: 700 !important;
		line-height: normal !important;
		padding-left: 0 !important;
		padding-right: 28px !important;
		font-size: 0.9rem !important;
	}

	.shadow-inset .select2-container--default .select2-selection--single .select2-selection__arrow {
		height: 38px !important;
		top: 0 !important;
		right: 14px !important;
	}

	.shadow-inset .select2-container--default .select2-selection--single .select2-selection__arrow b {
		border-color: #64748b transparent transparent transparent !important;
	}

	/* Button Micro-Animations & Tactile Feedback (/animate) */
	#btn-submit-transfer {
		transition: transform 220ms cubic-bezier(0.16, 1, 0.3, 1),
			box-shadow 220ms cubic-bezier(0.16, 1, 0.3, 1),
			filter 200ms ease !important;
	}

	#btn-submit-transfer:hover {
		transform: translateY(-2px) !important;
		filter: brightness(1.08) !important;
		box-shadow: 0 12px 24px -6px rgba(45, 76, 200, 0.5), 0 4px 12px rgba(45, 76, 200, 0.3) !important;
	}

	#btn-submit-transfer:active {
		transform: translateY(1px) scale(0.98) !important;
		filter: brightness(0.96) !important;
		box-shadow: 0 4px 10px -2px rgba(45, 76, 200, 0.3) !important;
	}

	#btn-cancel-transfer {
		transition: transform 200ms cubic-bezier(0.16, 1, 0.3, 1),
			box-shadow 200ms ease,
			background-color 200ms ease,
			color 200ms ease !important;
	}

	#btn-cancel-transfer:hover {
		transform: translateY(-1px) !important;
		background-color: #dcdde4 !important;
		color: #0f172a !important;
		box-shadow: inset 2px 2px 5px #b8b9be, inset -2px -2px 5px #ffffff !important;
	}

	#btn-cancel-transfer:active {
		transform: translateY(1px) scale(0.96) !important;
	}

	#btn-proceed-transfer {
		transition: transform 220ms cubic-bezier(0.16, 1, 0.3, 1),
			box-shadow 220ms cubic-bezier(0.16, 1, 0.3, 1),
			filter 200ms ease !important;
	}

	#btn-proceed-transfer:hover {
		transform: translateY(-2px) !important;
		filter: brightness(1.08) !important;
		box-shadow: 0 10px 24px -4px rgba(30, 58, 138, 0.5) !important;
	}

	#btn-proceed-transfer:active {
		transform: translateY(1px) scale(0.97) !important;
		filter: brightness(0.96) !important;
	}

	#btn-done-transfer-success {
		transition: transform 220ms cubic-bezier(0.16, 1, 0.3, 1),
			box-shadow 220ms cubic-bezier(0.16, 1, 0.3, 1),
			filter 200ms ease !important;
	}

	#btn-done-transfer-success:hover {
		transform: translateY(-2px) !important;
		filter: brightness(1.08) !important;
		box-shadow: 0 10px 24px -4px rgba(45, 76, 200, 0.5) !important;
	}

	#btn-done-transfer-success:active {
		transform: translateY(1px) scale(0.97) !important;
		filter: brightness(0.96) !important;
	}

	#btn-swap-accounts {
		transition: transform 380ms cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 200ms ease !important;
	}

	#btn-swap-accounts:hover {
		transform: rotate(180deg) scale(1.08) !important;
		box-shadow: 6px 6px 14px #b8b9be, -6px -6px 14px #ffffff !important;
	}

	#btn-swap-accounts:active {
		transform: rotate(180deg) scale(0.92) !important;
	}

	.btn-preset-max {
		transition: transform 180ms cubic-bezier(0.16, 1, 0.3, 1), box-shadow 180ms ease !important;
	}

	.btn-preset-max:hover {
		transform: translateY(-1px) scale(1.04) !important;
	}

	.btn-preset-max:active {
		transform: translateY(1px) scale(0.95) !important;
	}

	/* UI/UX Pro Max Bold Typography System (Outfit + Plus Jakarta Sans) */
	#modal-transfer-process {
		font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
	}

	#lbl-modal-title {
		font-family: 'Outfit', sans-serif !important;
		font-weight: 800 !important;
		font-size: 1.45rem !important;
		color: #0f172a !important;
		letter-spacing: -0.02em !important;
	}

	#lbl-modal-subtitle {
		font-family: 'Plus Jakarta Sans', sans-serif !important;
		font-weight: 600 !important;
		font-size: 0.88rem !important;
		color: #475569 !important;
	}

	.receipt-header-label {
		font-family: 'Plus Jakarta Sans', sans-serif !important;
		font-weight: 800 !important;
		font-size: 0.78rem !important;
		color: #334155 !important;
		letter-spacing: 0.05em !important;
	}

	#lbl-modal-amount {
		font-family: 'Outfit', sans-serif !important;
		font-weight: 800 !important;
		font-size: 1.4rem !important;
		letter-spacing: -0.01em !important;
		color: #2D4CC8 !important;
	}

	#lbl-modal-amount.text-success {
		color: #059669 !important;
	}

	/* Modern Proportional Currency Typography System (/ui-ux-pro-max) */
	.currency-peso {
		font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
		font-size: 0.65em !important;
		font-weight: 800 !important;
		vertical-align: super !important;
		line-height: 1 !important;
		margin-right: 2px !important;
		display: inline-block !important;
		transform: translateY(-0.18em) !important;
		opacity: 0.95 !important;
	}

	.currency-amount {
		font-family: 'Outfit', sans-serif !important;
		font-weight: 800 !important;
		letter-spacing: -0.02em !important;
	}

	.receipt-row-label {
		font-family: 'Plus Jakarta Sans', sans-serif !important;
		font-weight: 700 !important;
		font-size: 0.85rem !important;
		color: #475569 !important;
	}

	.receipt-row-value {
		font-family: 'Plus Jakarta Sans', sans-serif !important;
		font-weight: 800 !important;
		font-size: 0.9rem !important;
		color: #0f172a !important;
	}

	#btn-cancel-transfer,
	#btn-proceed-transfer,
	#btn-done-transfer-success,
	#btn-submit-transfer {
		font-family: 'Outfit', sans-serif !important;
		font-weight: 800 !important;
		letter-spacing: 0.03em !important;
	}
</style>

<!-- Single Stationary Neumorphic Transfer Modal (/animate) -->
<div class="modal fade" id="modal-transfer-process" tabindex="-1" role="dialog" aria-hidden="true"
	data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document" style="max-width: 440px;">
		<div class="modal-content border-0 rounded-2xl p-4 p-md-5 text-center position-relative overflow-hidden">

			<!-- Dynamic Content Morphing Wrapper -->
			<div id="modal-transfer-content-wrapper">

				<!-- In-place Lottie Animation Container -->
				<div class="d-flex justify-content-center align-items-center mb-2" id="lottie-container"></div>

				<!-- Header Title & Subtitle (UI/UX Pro Max Bold Typography) -->
				<h4 class="mb-1" id="lbl-modal-title">Confirm Transfer?</h4>
				<p class="mb-4" id="lbl-modal-subtitle">Please review your transfer details before sending.</p>

				<!-- Transfer Summary Receipt Box -->
				<div class="shadow-inset rounded-xl p-3.5 mb-4 text-left"
					style="background: #e6e7ee; border: 1px solid rgba(255,255,255,0.6);">
					<div
						class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom border-gray-300/50">
						<span class="receipt-header-label uppercase">Transfer Amount</span>
						<span class="h5 mb-0 text-primary" id="lbl-modal-amount">₱0.00</span>
					</div>
					<div class="d-flex justify-content-between align-items-center mb-2">
						<span class="receipt-row-label">From Source</span>
						<span class="receipt-row-value text-truncate" id="lbl-modal-source"
							style="max-width: 200px;">--</span>
					</div>
					<div class="d-flex justify-content-between align-items-center">
						<span class="receipt-row-label">To Target</span>
						<span class="receipt-row-value text-truncate" id="lbl-modal-target"
							style="max-width: 200px;">--</span>
					</div>
				</div>

				<!-- Action Button Container (Stage 1: Cancel/Confirm, Stage 2: Done) -->
				<div id="modal-actions-container">
					<div class="row" id="row-confirm-actions">
						<div class="col-6 pr-2">
							<button type="button"
								class="btn btn-primary shadow-soft btn-pill w-100 py-2.5 text-secondary neu-btn-press"
								data-dismiss="modal" id="btn-cancel-transfer">
								Cancel
							</button>
						</div>
						<div class="col-6 pl-2">
							<button type="button"
								class="btn btn-primary shadow-soft btn-pill w-100 py-2.5 text-white neu-btn-press"
								id="btn-proceed-transfer"
								style="background: linear-gradient(135deg, #2D4CC8 0%, #1e3a8a 100%);">
								Confirm Send
							</button>
						</div>
					</div>
					<div id="row-success-actions" style="display: none;">
						<button type="button"
							class="btn btn-primary shadow-soft btn-pill w-100 py-2.5 text-white neu-btn-press"
							data-dismiss="modal" id="btn-done-transfer-success"
							style="background: linear-gradient(135deg, #2D4CC8 0%, #1e3a8a 100%) !important; color: #ffffff !important; font-size: 0.95rem;">
							Done
						</button>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>