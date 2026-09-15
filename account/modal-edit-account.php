<div class="modal fade" id="modal-edit-account" tabindex="-1" role="dialog" aria-labelledby="modal-edit-account">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document" style="max-width: 540px;">
        <div class="modal-content border-0 rounded-2xl position-relative overflow-hidden" style="background-color: #e6e7ee; border: 1px solid rgba(255, 255, 255, 0.8) !important;">
            <div class="modal-body p-4 p-md-5">
                <!-- Modal Header -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 42px; height: 42px; background: #2D4CC8; box-shadow: 0 4px 14px rgba(45, 76, 200, 0.35);">
                            <i class="fa-solid fa-pen-to-square text-white" style="font-size: 1.15rem;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-black text-dark" style="font-family: 'Outfit', sans-serif; font-size: 1.35rem; letter-spacing: -0.02em;">Edit Account</h3>
                            <p class="text-xs text-gray-500 mb-0 font-weight-bold">Update bank logo & card pattern template</p>
                        </div>
                    </div>
                    <button type="button" class="close btn-modal-close d-flex align-items-center justify-content-center rounded-circle shadow-soft border border-white p-0" data-dismiss="modal" aria-label="Close" style="width: 34px; height: 34px; background: #e6e7ee; opacity: 0.85; transition: all 200ms ease;">
                        <span aria-hidden="true" style="font-size: 1.2rem; line-height: 1; color: #475569;">×</span>
                    </button>
                </div>

                <form class="form-submit-loader" method="post" action="process.php?action=edit_account" enctype="multipart/form-data" name="form" id="form-edit-account">
                    <!-- ACCOUNT NAME INPUT (MOVED TO TOP FOR REALTIME INPUT PREVIEW) -->
                    <div class="form-group mb-4">
                        <label for="editAccountName" class="text-xs font-weight-black uppercase tracking-wider mb-2 display-block" style="color: #475569 !important; font-size: 0.75rem;">ACCOUNT NAME</label>
                        <div class="d-flex align-items-center bg-primary shadow-inset rounded-pill px-3 py-1.5">
                            <input type="text" class="form-control bg-transparent border-0 font-weight-bold text-dark p-0 shadow-none outline-none w-100" name="editAccountName" id="editAccountName" placeholder="Enter account name..." autocomplete="off" required style="color: #0f172a !important; height: 38px;">
                        </div>
                        <div id="editAccountNameFeedback"></div>
                        <input type="hidden" name="a_id" id="a_id" readonly>
                    </div>

                    <!-- Pro-Max Live Debit/Credit Card Preview (/ui-ux-pro-max) -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-xs font-weight-black text-gray-700 uppercase tracking-wider" style="color: #475569 !important; font-size: 0.75rem;">LIVE CARD PREVIEW</span>
                            <span class="badge badge-pill font-weight-bold uppercase text-xs px-2.5 py-1" id="preview-edit-status-badge" style="background: rgba(15, 23, 42, 0.75); color: #ffffff; font-size: 0.65rem; letter-spacing: 0.05em; box-shadow: inset 0 1px 2px rgba(255,255,255,0.2);">ACTIVE</span>
                        </div>

                        <div class="card border-0 rounded-2xl p-4 position-relative overflow-hidden transition-all duration-300 mx-auto w-100" id="preview-edit-card" style="background: #e6e7ee; min-height: 175px; box-shadow: 6px 6px 14px #b8b9be, -6px -6px 14px #ffffff; border: 1px solid rgba(255,255,255,0.3) !important; background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <!-- Top Row: EMV Chip & Official Bank Logo SVG -->
                            <div class="d-flex align-items-center justify-content-between mb-3 position-relative" style="z-index: 2;">
                                <!-- Metallic EMV Chip -->
                                <div class="d-flex align-items-center">
                                    <div class="rounded-lg mr-2 position-relative overflow-hidden" id="preview-edit-chip" style="width: 38px; height: 26px; background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); border: 1px solid rgba(0,0,0,0.15); box-shadow: inset 0 1px 2px rgba(255,255,255,0.6);">
                                        <div class="position-absolute w-100" style="height: 1px; background: rgba(0,0,0,0.25); top: 50%;"></div>
                                        <div class="position-absolute h-100" style="width: 1px; background: rgba(0,0,0,0.25); left: 35%;"></div>
                                        <div class="position-absolute h-100" style="width: 1px; background: rgba(0,0,0,0.25); left: 65%;"></div>
                                    </div>
                                    <i class="fa-solid fa-wifi text-gray-400 rotate-90" id="preview-edit-wifi" style="font-size: 0.85rem; opacity: 0.6;"></i>
                                </div>

                                <!-- Official Bank Logo SVG (No Text) -->
                                <div id="preview-edit-logo-container" class="d-flex align-items-center justify-content-end" style="max-width: 140px; height: 32px;">
                                    <span class="font-weight-black uppercase text-xs px-2.5 py-1 rounded-pill" id="preview-edit-logo-text" style="color: #2D4CC8; background: rgba(45, 76, 200, 0.12); font-size: 0.72rem; letter-spacing: 0.04em;">WALLET</span>
                                </div>
                            </div>

                            <!-- Real-time Cardholder Name -->
                            <div class="position-relative" style="z-index: 2;">
                                <p class="font-weight-black uppercase mb-1 text-truncate" id="preview-edit-account-name" style="font-size: 1.05rem; color: #0f172a; letter-spacing: 0.03em; font-family: 'Outfit', sans-serif;">
                                    ACCOUNT NAME
                                </p>
                            </div>

                            <!-- Bottom Row: Balance -->
                            <div class="d-flex align-items-end justify-content-between mt-auto pt-2 position-relative" style="z-index: 2;">
                                <div>
                                    <div class="h3 font-weight-black mb-0 font-fira-code" id="preview-edit-balance" style="color: #0f172a; font-size: 1.4rem;">
                                        ₱ 0.00
                                    </div>
                                    <span class="text-xs uppercase tracking-wider display-block font-weight-bold" id="preview-edit-balance-label" style="color: #64748b; font-size: 0.65rem; letter-spacing: 0.05em;">AVAILABLE BALANCE</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Logo Selection Control -->
                    <div class="form-group mb-3">
                        <label class="text-xs font-weight-black uppercase tracking-wider mb-2 display-block" style="color: #475569 !important; font-size: 0.75rem;">1. SELECT BANK LOGO</label>
                        <input type="hidden" name="bankLogo" id="edit-bank-logo" value="default">
                        <input type="hidden" name="cardTheme" id="edit-card-theme" value="default">
                        
                        <div class="bank-logo-grid d-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
                            <!-- Default No Logo Option -->
                            <button type="button" class="btn btn-bank-logo-tile btn-logo-select border-0 rounded-xl p-2 d-flex align-items-center justify-content-center transition-all duration-200" data-logo="none" data-target-modal="edit" title="No Logo" style="background: #e6e7ee; height: 46px; box-shadow: 2px 2px 6px rgba(0,0,0,0.06);">
                                <i class="fa-solid fa-ban text-gray-500 mr-1.5" style="font-size: 0.85rem;"></i>
                                <span class="font-weight-bold text-xs text-gray-700" style="font-size: 0.72rem;">No Logo</span>
                            </button>

                            <!-- Default Wallet Emblem -->
                            <button type="button" class="btn btn-bank-logo-tile btn-logo-select active border-0 rounded-xl p-2 d-flex align-items-center justify-content-center transition-all duration-200" data-logo="default" data-target-modal="edit" title="Default Wallet" style="background: #e6e7ee; height: 46px; box-shadow: inset 2px 2px 4px #b8b9be, inset -2px -2px 4px #ffffff;">
                                <i class="fa-solid fa-wallet text-primary mr-1.5" style="font-size: 0.95rem;"></i>
                                <span class="font-weight-bold text-xs text-primary" style="font-size: 0.72rem;">Wallet</span>
                            </button>

                            <button type="button" class="btn btn-bank-logo-tile btn-logo-select border-0 rounded-xl p-2 d-flex align-items-center justify-content-center transition-all duration-200" data-logo="bdo" data-target-modal="edit" title="BDO Unibank" style="background: #ffffff; height: 46px; box-shadow: 2px 2px 6px rgba(0,0,0,0.06);">
                                <img src="<?= WEB_ROOT; ?>assets/bank/bank logo/BDO Unibank Logo.svg" alt="BDO" style="max-height: 22px; max-width: 90%;">
                            </button>

                            <button type="button" class="btn btn-bank-logo-tile btn-logo-select border-0 rounded-xl p-2 d-flex align-items-center justify-content-center transition-all duration-200" data-logo="bpi" data-target-modal="edit" title="BPI Bank" style="background: #ffffff; height: 46px; box-shadow: 2px 2px 6px rgba(0,0,0,0.06);">
                                <img src="<?= WEB_ROOT; ?>assets/bank/bank logo/BPI Logo.svg" alt="BPI" style="max-height: 22px; max-width: 90%;">
                            </button>

                            <button type="button" class="btn btn-bank-logo-tile btn-logo-select border-0 rounded-xl p-2 d-flex align-items-center justify-content-center transition-all duration-200" data-logo="chinabank" data-target-modal="edit" title="China Bank" style="background: #ffffff; height: 46px; box-shadow: 2px 2px 6px rgba(0,0,0,0.06);">
                                <img src="<?= WEB_ROOT; ?>assets/bank/bank logo/China Bank Logo.svg" alt="China Bank" style="max-height: 22px; max-width: 90%;">
                            </button>

                            <button type="button" class="btn btn-bank-logo-tile btn-logo-select border-0 rounded-xl p-2 d-flex align-items-center justify-content-center transition-all duration-200" data-logo="metrobank" data-target-modal="edit" title="Metrobank" style="background: #ffffff; height: 46px; box-shadow: 2px 2px 6px rgba(0,0,0,0.06);">
                                <img src="<?= WEB_ROOT; ?>assets/bank/bank logo/Metrobank Logo.svg" alt="Metrobank" style="max-height: 22px; max-width: 90%;">
                            </button>

                            <button type="button" class="btn btn-bank-logo-tile btn-logo-select border-0 rounded-xl p-2 d-flex align-items-center justify-content-center transition-all duration-200" data-logo="pnb" data-target-modal="edit" title="PNB Bank" style="background: #ffffff; height: 46px; box-shadow: 2px 2px 6px rgba(0,0,0,0.06);">
                                <img src="<?= WEB_ROOT; ?>assets/bank/bank logo/Philippine National Bank Logo.svg" alt="PNB" style="max-height: 22px; max-width: 90%;">
                            </button>

                            <button type="button" class="btn btn-bank-logo-tile btn-logo-select border-0 rounded-xl p-2 d-flex align-items-center justify-content-center transition-all duration-200" data-logo="secbank" data-target-modal="edit" title="Security Bank" style="background: #ffffff; height: 46px; box-shadow: 2px 2px 6px rgba(0,0,0,0.06);">
                                <img src="<?= WEB_ROOT; ?>assets/bank/bank logo/Security Bank Logo.svg" alt="Security Bank" style="max-height: 22px; max-width: 90%;">
                            </button>

                            <button type="button" class="btn btn-bank-logo-tile btn-logo-select border-0 rounded-xl p-2 d-flex align-items-center justify-content-center transition-all duration-200" data-logo="unionbank" data-target-modal="edit" title="UnionBank" style="background: #ffffff; height: 46px; box-shadow: 2px 2px 6px rgba(0,0,0,0.06);">
                                <img src="<?= WEB_ROOT; ?>assets/bank/bank logo/UnionBank Logo.svg" alt="UnionBank" style="max-height: 22px; max-width: 90%;">
                            </button>
                        </div>
                    </div>

                    <!-- All 22 Visual Mini-Card Background Templates Carousel (/ui-ux-pro-max) -->
                    <div class="form-group mb-4">
                        <label class="text-xs font-weight-black uppercase tracking-wider mb-2 display-block" style="color: #475569 !important; font-size: 0.75rem;">2. SELECT CARD BACKGROUND TEMPLATE</label>
                        
                        <div class="d-flex align-items-center gap-2 template-card-container" style="gap: 10px; overflow-x: auto; padding: 4px 2px 10px 2px; scrollbar-width: thin;">
                            <button type="button" class="btn btn-template-card-tile active rounded-lg p-0 transition-all duration-200 d-flex align-items-center justify-content-center" data-template="default" data-target-modal="edit" title="Neumorphic Soft" style="width: 76px; height: 48px; background: #e6e7ee; border: 2px solid #2D4CC8 !important; box-shadow: 0 4px 12px rgba(45,76,200,0.3); flex-shrink: 0;">
                                <span class="font-weight-black text-xs text-dark" style="font-size: 0.65rem;">SOFT</span>
                            </button>

                            <!-- Bank Template 1 Collection -->
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-16" data-target-modal="edit" title="Obsidian Black" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_1/16.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-17" data-target-modal="edit" title="China Bank Red" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_1/17.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-18" data-target-modal="edit" title="Bronze Gold" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_1/18.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-19" data-target-modal="edit" title="BDO Deep Navy" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_1/19.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-23" data-target-modal="edit" title="Slate Grey" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_1/23.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-24" data-target-modal="edit" title="UnionBank Amber Orange" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_1/24.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-25" data-target-modal="edit" title="Dark Teal" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_1/25.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>

                            <!-- Bank Template 5 Collection (Verified Colors) -->
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-66" data-target-modal="edit" title="Purple Prism" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_5/66.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-67" data-target-modal="edit" title="BPI Crimson Red" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_5/67.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-68" data-target-modal="edit" title="Olive Gold" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_5/68.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-69" data-target-modal="edit" title="Security Bank Teal" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_5/69.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-70" data-target-modal="edit" title="Metrobank Royal Blue" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_5/70.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>

                            <!-- Bank Template 4 Collection -->
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-71" data-target-modal="edit" title="PNB Deep Navy" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_4/71.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-72" data-target-modal="edit" title="Coffee Brown" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_4/72.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                            <button type="button" class="btn btn-template-card-tile rounded-lg p-0 transition-all duration-200" data-template="tpl-73" data-target-modal="edit" title="Deep Cyan" style="width: 76px; height: 48px; background: url('<?= WEB_ROOT; ?>assets/bank/bank-template_4/73.svg') center/cover no-repeat; flex-shrink: 0; box-shadow: 0 2px 6px rgba(0,0,0,0.25);"></button>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn" class="btn btn-block btn-primary submitBtn shadow-soft border-0 text-white font-weight-black py-3 rounded-xl uppercase tracking-wider neu-btn-press" style="background: linear-gradient(135deg, #2D4CC8 0%, #1e3a8a 100%); font-size: 0.95rem; font-family: 'Outfit', sans-serif;">
                        <i class="fa-solid fa-check mr-2"></i> Save Changes
                    </button>

                    <button type="button" id="loadingBtn" class="btn btn-block btn-primary loadingBtn d-none" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="ml-1">Saving...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>