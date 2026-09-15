<?php
$currentPage = $pageTitle ?? ($currentPage ?? 'Home');
?>
<header class="header-global py-2 py-md-3">
    <div class="container">
        
        <!-- Main Navbar Bar -->
        <div class="opt3-navbar shadow-soft-lg rounded-pill px-3 px-md-4 py-2 d-flex align-items-center justify-content-between">
            
            <!-- Brand Logo (Left) -->
            <a class="opt3-brand mr-3 mr-lg-4" href="<?= WEB_ROOT; ?>">
                <span class="opt3-brand-text">ABACOOS</span>
            </a>

            <!-- Desktop Nav Links (Left Aligned next to Logo) -->
            <div class="d-none d-md-flex align-items-center">
                <a href="<?= WEB_ROOT; ?>" class="opt3-nav-link mr-2 <?= in_array($currentPage, ['Home', 'Dashboard']) ? 'active' : ''; ?>">
                    Dashboard
                </a>
                <div class="dropdown">
                    <a href="#" class="opt3-nav-link dropdown-toggle <?= in_array($currentPage, ['Account', 'Category', 'Transfer', 'Report', 'User', 'Activity logs']) ? 'active' : ''; ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Modules
                        <i class="fas fa-chevron-down opt3-arrow ml-1"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-clean">
                        <a class="dropdown-item dropdown-item-clean" href="<?= WEB_ROOT; ?>account"><img src="<?= WEB_ROOT; ?>assets/img/icons/account-dropdown.svg" alt="Account" width="16" height="16" class="mr-2 inline-block align-middle">Account</a>
                        <a class="dropdown-item dropdown-item-clean" href="<?= WEB_ROOT; ?>category"><img src="<?= WEB_ROOT; ?>assets/img/icons/category-dropdown.svg" alt="Category" width="16" height="16" class="mr-2 inline-block align-middle">Category</a>
                        <a class="dropdown-item dropdown-item-clean" href="<?= WEB_ROOT; ?>transfer"><img src="<?= WEB_ROOT; ?>assets/img/icons/transfer-dropdown.svg" alt="Transfer" width="16" height="16" class="mr-2 inline-block align-middle">Transfer</a>
                        <a class="dropdown-item dropdown-item-clean" href="<?= WEB_ROOT; ?>report"><img src="<?= WEB_ROOT; ?>assets/img/icons/report-dropdown.svg" alt="Report" width="16" height="16" class="mr-2 inline-block align-middle">Report</a>
                        <a class="dropdown-item dropdown-item-clean" href="<?= WEB_ROOT; ?>user"><img src="<?= WEB_ROOT; ?>assets/img/icons/user-dropdown.svg" alt="User" width="16" height="16" class="mr-2 inline-block align-middle">User</a>
                        <a class="dropdown-item dropdown-item-clean" href="<?= WEB_ROOT; ?>activity-log"><img src="<?= WEB_ROOT; ?>assets/img/icons/activity-dropdown.svg" alt="Activity logs" width="16" height="16" class="mr-2 inline-block align-middle">Activity logs</a>
                    </div>
                </div>
            </div>

            <!-- Right Actions (Pushed to Right with ml-auto) -->
            <div class="d-flex align-items-center ml-auto">
                <!-- Desktop Logout Button -->
                <a href="<?= WEB_ROOT; ?>?logout" class="opt3-btn-icon text-danger d-none d-md-inline-flex" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>

                <!-- Mobile Hamburger Button -->
                <button id="mobile-menu-btn" type="button" class="opt3-btn-icon text-primary d-inline-flex d-md-none border-0" aria-label="Toggle Navigation">
                    <img src="<?= WEB_ROOT; ?>assets/img/icons/burger-menu.svg" alt="Menu" width="16" height="16" class="pointer-events-none">
                </button>
            </div>

        </div>

        <!-- Mobile Off-Canvas Drawer (Side Navigation Panel Concept) -->
        <div id="mobile-drawer-overlay" class="mobile-drawer-overlay" aria-hidden="true"></div>
        
        <aside id="mobile-drawer" class="mobile-drawer-panel" aria-label="Mobile Navigation">
            <div class="mobile-drawer-content">
                
                <!-- Drawer Header: Brand Title + Burger Close Trigger -->
                <div class="mobile-drawer-header">
                    <span class="opt3-brand-text">ABACOOS</span>

                    <button id="mobile-drawer-close" type="button" class="opt3-btn-icon text-primary border-0" aria-label="Close Navigation">
                        <img src="<?= WEB_ROOT; ?>assets/img/icons/burger-menu.svg" alt="Close Menu" width="16" height="16" class="pointer-events-none">
                    </button>
                </div>

                <!-- Navigation Links List with Stagger Animations -->
                <nav class="mobile-nav-list px-4 py-2">
                    <a href="<?= WEB_ROOT; ?>" class="opt3-mobile-sublink mobile-stagger-item <?= ($currentPage === 'Home') ? 'active' : ''; ?>">
                        <i class="fa-solid fa-house-chimney text-blue-700 mr-3"></i> Dashboard
                    </a>

                    <div class="pt-3">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider px-3 block mb-2.5">Modules</span>
                        <div class="space-y-1">
                            <a class="opt3-mobile-sublink mobile-stagger-item" href="<?= WEB_ROOT; ?>account"><img src="<?= WEB_ROOT; ?>assets/img/icons/account-dropdown.svg" alt="Account" width="18" height="18" class="mr-3.5 inline-block align-middle"> Account</a>
                            <a class="opt3-mobile-sublink mobile-stagger-item" href="<?= WEB_ROOT; ?>category"><img src="<?= WEB_ROOT; ?>assets/img/icons/category-dropdown.svg" alt="Category" width="18" height="18" class="mr-3.5 inline-block align-middle"> Category</a>
                            <a class="opt3-mobile-sublink mobile-stagger-item" href="<?= WEB_ROOT; ?>transfer"><img src="<?= WEB_ROOT; ?>assets/img/icons/transfer-dropdown.svg" alt="Transfer" width="18" height="18" class="mr-3.5 inline-block align-middle"> Transfer</a>
                            <a class="opt3-mobile-sublink mobile-stagger-item" href="<?= WEB_ROOT; ?>report"><img src="<?= WEB_ROOT; ?>assets/img/icons/report-dropdown.svg" alt="Report" width="18" height="18" class="mr-3.5 inline-block align-middle"> Report</a>
                            <a class="opt3-mobile-sublink mobile-stagger-item" href="<?= WEB_ROOT; ?>user"><img src="<?= WEB_ROOT; ?>assets/img/icons/user-dropdown.svg" alt="User" width="18" height="18" class="mr-3.5 inline-block align-middle"> User</a>
                            <a class="opt3-mobile-sublink mobile-stagger-item" href="<?= WEB_ROOT; ?>activity-log"><img src="<?= WEB_ROOT; ?>assets/img/icons/activity-dropdown.svg" alt="Activity logs" width="18" height="18" class="mr-3.5 inline-block align-middle"> Activity logs</a>
                        </div>
                    </div>

                    <!-- Mobile Logout Button -->
                    <div class="pt-4 mt-3 border-t border-gray-300/50">
                        <a href="<?= WEB_ROOT; ?>?logout" class="opt3-mobile-logout text-red-600 mobile-stagger-item">
                            <i class="fa-solid fa-right-from-bracket mr-3 text-red-600"></i> Logout
                        </a>
                    </div>
                </nav>

            </div>
        </aside>

    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuBtn = document.getElementById('mobile-menu-btn');
        const drawer = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('mobile-drawer-overlay');
        const closeBtn = document.getElementById('mobile-drawer-close');

        function openDrawer() {
            if (!drawer || !overlay) return;
            overlay.classList.add('active');
            drawer.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            if (!drawer || !overlay) return;
            drawer.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (menuBtn) menuBtn.addEventListener('click', openDrawer);
        if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
        if (overlay) overlay.addEventListener('click', closeDrawer);

        // Close on ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) {
                closeDrawer();
            }
        });
    });
</script>