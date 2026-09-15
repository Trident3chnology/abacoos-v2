<!-- Account Access Modal -->
<div class="modal fade" id="modal-access" tabindex="-1" role="dialog" aria-labelledby="modal-access" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-primary shadow-soft border-light p-4">
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="card-header text-center pb-0">
                        <h2 class="mb-0 h5">Account access</h2>
                    </div>
                    <div class="card-body">
                        <form action="#">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="mb-0" for="customSwitch1">
                                    Toggle this switch element
                                </label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1"></label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Sun Icon Only Continuous Rotation Animation (/animate) */
.sun-icon,
.wave-icon {
    display: inline-block !important;
    vertical-align: middle !important;
    animation: sunEntrance 0.75s cubic-bezier(0.16, 1, 0.3, 1), sunGentleSpin 24s linear infinite 0.75s !important;
    transform-origin: center center;
    filter: drop-shadow(0 0 12px rgba(245, 158, 11, 0.6)) !important;
}

@keyframes sunEntrance {
    0% {
        opacity: 0;
        transform: scale(0.2) rotate(-120deg);
        filter: drop-shadow(0 0 0px rgba(245, 158, 11, 0));
    }
    65% {
        transform: scale(1.22) rotate(15deg);
        filter: drop-shadow(0 0 20px rgba(245, 158, 11, 0.85));
    }
    100% {
        opacity: 1;
        transform: scale(1) rotate(0deg);
        filter: drop-shadow(0 0 12px rgba(245, 158, 11, 0.6));
    }
}

@keyframes sunGentleSpin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Sunset Icon (No Rotation) */
.sunset-icon {
    display: inline-block !important;
    vertical-align: middle !important;
    animation: pulseGlow 3s infinite ease-in-out !important;
    filter: drop-shadow(0 0 10px rgba(251, 146, 60, 0.6)) !important;
}

/* Moon Icon (No Rotation) */
.moon-icon {
    display: inline-block !important;
    vertical-align: middle !important;
    animation: pulseGlow 3s infinite ease-in-out !important;
    filter: drop-shadow(0 0 10px rgba(129, 140, 248, 0.6)) !important;
}

/* Card Entrance Animation & Smooth Skeleton Fade (/animate) */
.card-fade-in {
    opacity: 0;
    transform: translateY(12px) scale(0.98);
    animation: cardEntrance 0.38s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes cardEntrance {
    0% {
        opacity: 0;
        transform: translateY(12px) scale(0.98);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Card Hover Lift & Tap-to-View Reveal Motion (/animate) */
.sub-account {
    transition: transform 220ms cubic-bezier(0.23, 1, 0.32, 1), box-shadow 220ms cubic-bezier(0.23, 1, 0.32, 1) !important;
    will-change: transform;
}

.sub-account .card-tap-hint-footer,
.sub-account .card-tap-hint-divider {
    transition: opacity 220ms cubic-bezier(0.23, 1, 0.32, 1), transform 220ms cubic-bezier(0.23, 1, 0.32, 1) !important;
    will-change: opacity, transform;
}

.sub-account .card-tap-hint-footer i,
.sub-account .card-tap-hint-divider i {
    transition: transform 220ms cubic-bezier(0.23, 1, 0.32, 1) !important;
    will-change: transform;
}

@media (hover: hover) and (pointer: fine) {
    .sub-account:hover {
        transform: translateY(-6px) scale(1.015);
    }
    
    .sub-account .card-tap-hint-footer,
    .sub-account .card-tap-hint-divider {
        opacity: 0;
        transform: translateY(6px);
    }
    
    .sub-account:hover .card-tap-hint-footer,
    .sub-account:hover .card-tap-hint-divider {
        opacity: 1;
        transform: translateY(0);
    }
    
    .sub-account:hover .card-tap-hint-footer i,
    .sub-account:hover .card-tap-hint-divider i {
        transform: translateX(4px);
    }
}

@media (prefers-reduced-motion: reduce) {
    .sub-account {
        transition: opacity 200ms ease !important;
    }
    .sub-account:hover {
        transform: none !important;
    }
    .sub-account .card-tap-hint-footer,
    .sub-account .card-tap-hint-divider {
        opacity: 1 !important;
        transform: none !important;
    }
}

/* CardSwap 3D Mobile Showcase Stage (Only < 768px, Desktop is 100% unchanged) */
@media (max-width: 767.98px) {
    #account-container {
        position: relative !important;
        perspective: 1200px !important;
        transform-style: preserve-3d !important;
        height: 290px !important;
        margin: 55px auto 35px auto !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        left: 0 !important;
        right: 0 !important;
    }
    #account-container .card-fade-in {
        position: absolute !important;
        top: 65px !important;
        left: 50% !important;
        width: 350px !important;
        max-width: 92vw !important;
        margin: 0 !important;
        padding: 0 !important;
        opacity: 1 !important;
        animation: none !important;
        transform-style: preserve-3d !important;
        will-change: transform !important;
    }
}

/* Quick Actions Micro-Animations (/animate) */
.quick-action-pill {
    background-color: #e6e7ee;
    transition: transform 220ms cubic-bezier(0.23, 1, 0.32, 1), box-shadow 220ms cubic-bezier(0.23, 1, 0.32, 1), background-color 220ms ease;
    color: #44476a !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 78px !important;
    padding: 10px 4px !important;
    border-radius: 18px !important;
    will-change: transform, box-shadow;
    touch-action: manipulation;
    -webkit-tap-highlight-color: transparent;
    box-sizing: border-box !important;
}

.quick-action-pill img {
    transition: transform 220ms cubic-bezier(0.34, 1.56, 0.64, 1), filter 220ms ease;
    will-change: transform;
}

.quick-action-pill:hover,
.quick-action-pill:focus,
.quick-action-pill.is-touch-hover {
    transform: translateY(-4px) scale(1.03) !important;
    box-shadow: 8px 8px 18px #b8b9be, -8px -8px 18px #ffffff !important;
    text-decoration: none !important;
    color: #26547c !important;
}

.quick-action-pill:hover img,
.quick-action-pill:focus img,
.quick-action-pill.is-touch-hover img {
    transform: scale(1.18) translateY(-2px);
    filter: drop-shadow(0 4px 6px rgba(38, 84, 124, 0.25));
}

.quick-action-pill:active,
.quick-action-pill.is-touch-pressed {
    transform: translateY(2px) scale(0.95) !important;
    box-shadow: inset 3px 3px 6px #b8b9be, inset -3px -3px 6px #ffffff !important;
    transition-duration: 80ms !important;
}

.quick-action-pill:active img,
.quick-action-pill.is-touch-pressed img {
    transform: scale(0.90);
}

.action-pill-text {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: -0.01em;
    white-space: nowrap;
    transition: color 220ms ease;
}
</style>

<!-- Dashboard Main Section -->
<div class="section bg-primary text-dark py-4 py-md-5">
    <div class="container">

        <!-- Greeting Header -->
        <div class="dashboard-greeting mb-4 mb-md-5">
            <h1 class="greeting-text mb-2">
                <span id="dynamic-greeting-text">Good morning</span>
                <img id="dynamic-greeting-icon" src="<?= WEB_ROOT; ?>assets/img/icons/sun-icon.svg" class="sun-icon" alt="Sun" width="48" height="48"><?= !empty($userName) ? ', ' . htmlspecialchars($userName) : ''; ?>
            </h1>
            <p class="greeting-tagline">Here's a quick overview of your accounts today.</p>
        </div>

        <!-- Account Cards Grid with Server-Side Skeleton Loading State -->
        <?php
            $initialSkeletonCount = (isset($_SESSION['account_count']) && $_SESSION['account_count'] > 0) ? (int)$_SESSION['account_count'] : 3;
        ?>
        <div class="row" id="account-container">
            <?php for ($i = 0; $i < $initialSkeletonCount; $i++): ?>
                <div class="col-12 col-sm-6 col-lg-4 mb-4 skeleton-card-item">
                    <div class="card bg-primary border-light shadow-soft p-4 rounded-2xl position-relative overflow-hidden" style="min-height: 180px;">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="skeleton-circle" style="width: 44px; height: 44px; border-radius: 50%;"></div>
                            <div class="skeleton-line" style="width: 50px; height: 18px; border-radius: 12px;"></div>
                        </div>
                        <div class="skeleton-line mb-3" style="width: 60%; height: 18px; border-radius: 6px;"></div>
                        <div class="skeleton-line mb-2" style="width: 80%; height: 32px; border-radius: 8px;"></div>
                        <div class="d-flex align-items-center justify-content-between pt-2 mt-2" style="border-top: 1px solid rgba(0,0,0,0.06);">
                            <div class="skeleton-line" style="width: 100px; height: 12px; border-radius: 4px;"></div>
                            <div class="skeleton-line" style="width: 14px; height: 14px; border-radius: 50%;"></div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Quick Actions Section (Mobile Only - < 768px) -->
        <div class="dashboard-quick-actions pt-4 mb-3 d-block d-md-none">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h5 font-weight-bold text-dark mb-0">Quick Actions</h2>
            </div>
            <div class="row row-cols-4 no-gutters text-center mx-n1">
                <!-- Transfer -->
                <div class="col px-1">
                    <a href="<?= WEB_ROOT; ?>transfer" class="quick-action-pill shadow-soft text-decoration-none">
                        <img src="<?= WEB_ROOT; ?>assets/img/icons/transfer-dropdown.svg" alt="Transfer" width="22" height="22" class="mb-1.5">
                        <span class="action-pill-text">Transfer</span>
                    </a>
                </div>
                <!-- Accounts -->
                <div class="col px-1">
                    <a href="<?= WEB_ROOT; ?>account" class="quick-action-pill shadow-soft text-decoration-none">
                        <img src="<?= WEB_ROOT; ?>assets/img/icons/account-dropdown.svg" alt="Accounts" width="22" height="22" class="mb-1.5">
                        <span class="action-pill-text">Accounts</span>
                    </a>
                </div>
                <!-- Reports -->
                <div class="col px-1">
                    <a href="<?= WEB_ROOT; ?>report" class="quick-action-pill shadow-soft text-decoration-none">
                        <img src="<?= WEB_ROOT; ?>assets/img/icons/report-dropdown.svg" alt="Reports" width="22" height="22" class="mb-1.5">
                        <span class="action-pill-text">Reports</span>
                    </a>
                </div>
                <!-- Logs -->
                <div class="col px-1">
                    <a href="<?= WEB_ROOT; ?>activity-log" class="quick-action-pill shadow-soft text-decoration-none">
                        <img src="<?= WEB_ROOT; ?>assets/img/icons/activity-dropdown.svg" alt="Logs" width="22" height="22" class="mb-1.5">
                        <span class="action-pill-text">Logs</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const WEB_ROOT = '<?= WEB_ROOT; ?>';

    $(function () {

        // Dynamic Time-of-Day Greeting & Icon Logic
        function updateTimeBasedGreeting() {
            const hour = new Date().getHours();
            const greetingTextEl = document.getElementById('dynamic-greeting-text');
            const greetingIconEl = document.getElementById('dynamic-greeting-icon');

            if (!greetingTextEl || !greetingIconEl) return;

            if (hour >= 5 && hour < 12) {
                // Morning (5:00 AM - 11:59 AM)
                greetingTextEl.textContent = 'Good morning';
                greetingIconEl.src = WEB_ROOT + 'assets/img/icons/sun-icon.svg';
                greetingIconEl.className = 'sun-icon';
                greetingIconEl.alt = 'Sun';
            } else if (hour >= 12 && hour < 18) {
                // Afternoon (12:00 PM - 5:59 PM)
                greetingTextEl.textContent = 'Good afternoon';
                greetingIconEl.src = WEB_ROOT + 'assets/img/icons/sunset-icon.svg';
                greetingIconEl.className = 'sunset-icon';
                greetingIconEl.alt = 'Sunset';
            } else {
                // Evening / Night (6:00 PM - 4:59 AM)
                greetingTextEl.textContent = 'Good evening';
                greetingIconEl.src = WEB_ROOT + 'assets/img/icons/moon-icon.svg';
                greetingIconEl.className = 'moon-icon';
                greetingIconEl.alt = 'Moon';
            }
        }

        updateTimeBasedGreeting();

        // Icon map — picks a crisp Font Awesome icon per account type
        const iconMap = [
            { keywords: ['cash', 'petty', 'pocket'], icon: 'fa-solid fa-wallet' },
            { keywords: ['bank', 'checking', 'bdo', 'bpi', 'metro', 'unionbank'], icon: 'fa-solid fa-building-columns' },
            { keywords: ['savings', 'saving', 'time deposit'], icon: 'fa-solid fa-piggy-bank' },
            { keywords: ['credit', 'card'], icon: 'fa-solid fa-credit-card' },
            { keywords: ['invest', 'stock', 'fund'], icon: 'fa-solid fa-chart-line' },
            { keywords: ['loan', 'mortgage', 'home'], icon: 'fa-solid fa-house' },
            { keywords: ['business', 'company'], icon: 'fa-solid fa-briefcase' },
        ];

        function getIcon(accountName) {
            const name = accountName.toLowerCase();
            for (const entry of iconMap) {
                if (entry.keywords.some(kw => name.includes(kw))) {
                    return entry.icon;
                }
            }
            return 'fa-solid fa-vault'; // default fallback
        }

        let isLoading = false;

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.innerText = text;
            return div.innerHTML;
        }

        function renderSkeletonCards(count) {
            let html = '';
            for (let i = 0; i < count; i++) {
                html += `
                    <div class="col-12 col-sm-6 col-lg-4 mb-4 skeleton-card-item">
                        <div class="card bg-primary border-light shadow-soft p-4 rounded-2xl position-relative overflow-hidden" style="min-height: 180px;">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="skeleton-circle" style="width: 44px; height: 44px; border-radius: 50%;"></div>
                                <div class="skeleton-line" style="width: 50px; height: 18px; border-radius: 12px;"></div>
                            </div>
                            <div class="skeleton-line mb-3" style="width: 60%; height: 18px; border-radius: 6px;"></div>
                            <div class="skeleton-line mb-2" style="width: 80%; height: 32px; border-radius: 8px;"></div>
                            <div class="d-flex align-items-center justify-content-between pt-2 mt-2" style="border-top: 1px solid rgba(0,0,0,0.06);">
                                <div class="skeleton-line" style="width: 100px; height: 12px; border-radius: 4px;"></div>
                                <div class="skeleton-line" style="width: 14px; height: 14px; border-radius: 50%;"></div>
                            </div>
                        </div>
                    </div>`;
            }
            return html;
        }

        function getExpectedAccountCount() {
            const cached = localStorage.getItem('abacoos_account_count');
            if (cached && !isNaN(cached) && parseInt(cached) > 0) {
                return parseInt(cached);
            }
            return <?= (int)$initialSkeletonCount; ?>;
        }

        async function loadAccount() {
            if (isLoading) return;
            isLoading = true;

            const container = document.getElementById('account-container');
            const expectedCount = getExpectedAccountCount();

            // If empty or showing initial skeletons, render exact matching skeleton placeholders
            if (!container.children.length || container.querySelector('.skeleton-card-item')) {
                container.innerHTML = renderSkeletonCards(expectedCount);
            }

            try {
                const response = await fetch('home/process.php?action=fetch_account');
                const res = await response.json();

                if (!res || !res.status) {
                    container.innerHTML = `<div class="col-12 text-center text-dark font-italic">Failed to load accounts</div>`;
                    return;
                }

                if (!res.data || res.data.length === 0) {
                    localStorage.setItem('abacoos_account_count', 0);
                    container.innerHTML = `<div class="col-12 text-center text-dark font-italic">No accounts found</div>`;
                    return;
                }

                // Remember actual account count for instant zero-shift skeleton rendering on next load
                localStorage.setItem('abacoos_account_count', res.data.length);

                const fragment = document.createDocumentFragment();

                res.data.forEach((account, idx) => {
                    const accountName = escapeHtml(account.account_name);
                    
                    // Format balance dynamically from database into integer part and superscript cents
                    let rawBalance = account.balance ? parseFloat(account.balance) : 0;
                    let formattedBalance = rawBalance.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    let balanceParts = formattedBalance.split('.');
                    let pesoSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="18" height="18" style="display:inline-block; vertical-align:-3px; margin-right:3px; fill:currentColor;"><path d="M208 96C190.3 96 176 110.3 176 128L176 192L152 192C138.7 192 128 202.7 128 216C128 229.3 138.7 240 152 240L176 240L176 272L152 272C138.7 272 128 282.7 128 296C128 309.3 138.7 320 152 320L176 320L176 512C176 529.7 190.3 544 208 544C225.7 544 240 529.7 240 512L240 416L336 416C401.6 416 458 376.5 482.7 320L520 320C533.3 320 544 309.3 544 296C544 282.7 533.3 272 520 272L495.2 272C495.7 266.7 496 261.4 496 256C496 250.6 495.7 245.3 495.2 240L520 240C533.3 240 544 229.3 544 216C544 202.7 533.3 192 520 192L482.7 192C458 135.5 401.6 96 336 96L208 96zM407.6 192L240 192L240 160L336 160C364.4 160 390 172.4 407.6 192zM240 240L430.7 240C431.6 245.2 432 250.5 432 256C432 261.5 431.5 266.8 430.7 272L240 272L240 240zM407.6 320C390 339.6 364.5 352 336 352L240 352L240 320L407.6 320z"/></svg>`;
                    let intPart = pesoSvg + balanceParts[0];
                    let centsPart = '.' + (balanceParts[1] || '00');

                    // Alternating themes fallback (ACTIVE, MARKET, SAVING)
                    const themes = [
                        { tag: 'ACTIVE', colorClass: 'icon-color-blue' },
                        { tag: 'MARKET', colorClass: 'icon-color-orange' },
                        { tag: 'SAVING', colorClass: 'icon-color-green' }
                    ];
                    const theme = themes[idx % themes.length];

                    // Theme lookup from global cardThemes.js
                    const themeKey = account.card_theme || 'default';
                    const bankTheme = (themeKey && typeof getBankCardTheme === 'function')
                        ? getBankCardTheme(themeKey)
                        : null;

                    const isCustomCard = bankTheme && bankTheme.template && bankTheme.template.id !== 'default';

                    const wrapper = document.createElement('div');
                    wrapper.className = 'col-12 col-sm-6 col-lg-4 mb-4 card-fade-in';
                    wrapper.style.animationDelay = `${idx * 0.05}s`;

                    if (isCustomCard) {
                        let logoHtml = '';
                        if (bankTheme.logoUrl) {
                            logoHtml = `<img src="${bankTheme.logoUrl}" alt="${bankTheme.logoText || ''}" style="max-height: 26px; max-width: 110px; object-fit: contain; filter: ${bankTheme.logoFilter || 'brightness(0) invert(1)'}; transition: all 200ms ease;">`;
                        } else {
                            logoHtml = `<span class="font-weight-black uppercase text-xs px-2.5 py-1 rounded-pill" style="color: ${bankTheme.badgeText || '#2D4CC8'}; background: ${bankTheme.badgeBg || 'rgba(45, 76, 200, 0.12)'}; font-size: 0.72rem; letter-spacing: 0.04em;">${bankTheme.logoText || 'WALLET'}</span>`;
                        }

                        let textColor = bankTheme.textColor || '#ffffff';
                        let subTextColor = bankTheme.subTextColor || 'rgba(255,255,255,0.78)';
                        let shadow = bankTheme.shadow || '0 12px 28px -6px rgba(0,0,0,0.45)';
                        let bgStyle = bankTheme.svgUrl
                            ? `background-color: ${bankTheme.bg || '#00026C'} !important; background-image: url('${bankTheme.svgUrl}?v=<?= time(); ?>') !important; background-position: center !important; background-size: cover !important; background-repeat: no-repeat !important;`
                            : `background: ${bankTheme.bg || '#e6e7ee'} !important;`;

                        wrapper.innerHTML = `
                            <div class="card border-0 rounded-2xl p-4 position-relative overflow-hidden transition-all duration-300 mx-auto w-100 sub-account d-flex flex-column h-100"
                                data-a-id="${account.a_id}"
                                data-account-name="${accountName}"
                                style="${bgStyle} min-height: 180px; box-shadow: ${shadow} !important; border: none !important; border-style: none !important; border-color: transparent !important; border-radius: 1.25rem !important; overflow: hidden !important; cursor: pointer; color: ${textColor} !important;">

                                <!-- Clean 3-dot options menu trigger (No white rounded background) -->
                                <div class="position-absolute" style="top: 14px; right: 14px; z-index: 10;">
                                    <button class="btn btn-link p-1 border-0 shadow-none outline-none" type="button" data-toggle="modal" data-target="#modal-access" style="width: 24px; height: 24px; font-size: 0.85rem; color: ${textColor} !important; opacity: 0.75; background: transparent !important; box-shadow: none !important;" title="Account Options">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>

                                <!-- Top Row: EMV Chip & Official Bank Logo SVG -->
                                <div class="d-flex align-items-center justify-content-between mb-3 position-relative" style="z-index: 2;">
                                    <!-- Metallic EMV Chip -->
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-lg mr-2 position-relative overflow-hidden" style="width: 38px; height: 26px; background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%); border: 1px solid rgba(0,0,0,0.15); box-shadow: inset 0 1px 2px rgba(255,255,255,0.6);">
                                            <div class="position-absolute w-100" style="height: 1px; background: rgba(0,0,0,0.25); top: 50%;"></div>
                                            <div class="position-absolute h-100" style="width: 1px; background: rgba(0,0,0,0.25); left: 35%;"></div>
                                            <div class="position-absolute h-100" style="width: 1px; background: rgba(0,0,0,0.25); left: 65%;"></div>
                                        </div>
                                        <i class="fa-solid fa-wifi rotate-90" style="font-size: 0.85rem; opacity: 0.65; color: ${textColor} !important;"></i>
                                    </div>

                                    <!-- Official Bank Logo SVG -->
                                    <div class="d-flex align-items-center justify-content-end mr-4" style="max-width: 130px; height: 30px;">
                                        ${logoHtml}
                                    </div>
                                </div>

                                <!-- Cardholder Name -->
                                <div class="position-relative mb-2" style="z-index: 2;">
                                    <p class="font-weight-black uppercase mb-1 text-truncate" style="font-size: 1.05rem; color: ${textColor} !important; letter-spacing: 0.03em; font-family: 'Outfit', sans-serif;">
                                        ${accountName}
                                    </p>
                                </div>

                                <!-- Balance -->
                                <div class="d-flex align-items-end justify-content-between mt-auto mb-2 position-relative" style="z-index: 2;">
                                    <div>
                                        <div class="h3 font-weight-black mb-0 font-fira-code" style="color: ${textColor} !important; font-size: 1.4rem;">
                                            ${intPart}<span class="cents-clean" style="font-size: 0.75em; vertical-align: super; color: ${textColor} !important;">${centsPart}</span>
                                        </div>
                                        <span class="text-xs uppercase tracking-wider display-block font-weight-bold" style="color: ${subTextColor} !important; font-size: 0.65rem; letter-spacing: 0.05em;">AVAILABLE BALANCE</span>
                                    </div>
                                </div>

                                <!-- Bottom Tap Hint Footer -->
                                <div class="d-flex align-items-center justify-content-between pt-2 mt-2 position-relative card-tap-hint-footer" style="border-top: 1px solid rgba(255,255,255,0.2); font-size: 0.68rem; font-weight: 800; letter-spacing: 0.04em; color: ${subTextColor} !important; z-index: 2;">
                                    <span>TAP TO VIEW DETAILS</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>
                        `;
                    } else {
                        // Standard Neumorphic Card Design
                        wrapper.innerHTML = `
                            <div class="btn-card card bg-primary border-light shadow-soft position-relative sub-account card-concept-target"
                                data-a-id="${account.a_id}"
                                data-account-name="${accountName}">

                                <!-- 3-dot options menu trigger -->
                                <div class="position-absolute" style="top: 14px; right: 14px; z-index: 10;">
                                    <button class="btn btn-link p-1 text-gray-500 opt3-btn-icon border-0" type="button" data-toggle="modal" data-target="#modal-access" style="width: 26px; height: 26px; font-size: 0.7rem;" title="Account Options">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body account-card-body p-4">

                                    <!-- Top Header Row: Inset Icon Circle + Inset Category Tag -->
                                    <div class="d-flex align-items-center justify-content-between mb-3.5">
                                        <div class="card-icon-circle-inset ${theme.colorClass}">
                                            <img src="${WEB_ROOT}assets/img/icons/account-card.svg" alt="Icon" width="20" height="20" class="svg-theme-icon">
                                        </div>

                                        <span class="card-status-pill-inset mr-4">
                                            ${theme.tag}
                                        </span>
                                    </div>

                                    <!-- Dynamic Account Name Label -->
                                    <p class="card-account-label-clean mb-1">${accountName}</p>

                                    <!-- Dynamic Balance Amount with Superscript Cents -->
                                    <div class="card-balance-clean mb-0">
                                        ${intPart}<span class="cents-clean">${centsPart}</span>
                                    </div>
                                    <span class="card-balance-sublabel mb-3">Available Balance</span>

                                    <!-- Bottom Tap Hint Footer -->
                                    <div class="card-tap-hint-divider mt-auto pt-3">
                                        <span>TAP TO VIEW DETAILS</span>
                                        <i class="fa-solid fa-arrow-right ml-1"></i>
                                    </div>

                                </div>
                            </div>
                        `;
                    }

                    fragment.appendChild(wrapper);
                });

                // Smooth cross-fade transition from skeletons to real cards
                const skeletons = container.querySelectorAll('.skeleton-card-item');
                if (skeletons.length > 0) {
                    skeletons.forEach(s => {
                        s.style.transition = 'opacity 0.14s ease-out, transform 0.14s ease-out';
                        s.style.opacity = '0';
                        s.style.transform = 'translateY(-4px)';
                    });
                    setTimeout(() => {
                        container.innerHTML = '';
                        container.appendChild(fragment);
                        initMobileCardSwap();
                    }, 130);
                } else {
                    container.innerHTML = '';
                    container.appendChild(fragment);
                    initMobileCardSwap();
                }

            } catch (err) {
                console.error(err);
                container.innerHTML = `<div class="col-12 text-center text-dark font-italic">Error loading accounts</div>`;
            } finally {
                isLoading = false;
            }
        }

        let cardSwapTl = null;
        let cardOrder = [];

        function initMobileCardSwap() {
            if (cardSwapTl) cardSwapTl.kill();

            const isMobile = window.innerWidth < 768;
            const container = document.getElementById('account-container');
            const cards = container ? Array.from(container.querySelectorAll('.card-fade-in')) : [];

            if (!container || cards.length === 0) return;

            if (!isMobile) {
                // Desktop View: Reset all GSAP inline transforms so standard grid is 100% untouched
                cards.forEach(card => {
                    if (typeof gsap !== 'undefined') gsap.set(card, { clearProps: 'all' });
                    $(card).off('.cardswap');
                });
                return;
            }

            if (cards.length < 2 || typeof gsap === 'undefined') return;

            // Mobile View (< 768px): Purely Manual 3D Stacked Card Swap (No Auto Swap)
            cardOrder = cards.map((_, idx) => idx);
            const total = cards.length;
            const verticalDistance = 14;
            const depthDistance = 25;

            const makeSlot = (i) => ({
                x: 0,
                y: -i * verticalDistance,
                z: -i * depthDistance,
                scale: Math.max(0.88, 1 - (i * 0.022)),
                zIndex: total - i
            });

            const placeNow = (el, slot) => {
                el.style.animation = 'none';
                el.style.opacity = '1';
                gsap.set(el, {
                    x: 0,
                    y: slot.y,
                    z: slot.z,
                    scale: slot.scale,
                    xPercent: -50,
                    yPercent: 0,
                    opacity: 1,
                    skewY: 0,
                    transformOrigin: 'center top',
                    zIndex: slot.zIndex,
                    force3D: true
                });
            };

            cards.forEach((card, i) => {
                placeNow(card, makeSlot(i));
            });

            let isAnimating = false;

            const manualSwapFrontToBack = () => {
                if (isAnimating || cardOrder.length < 2) return;
                isAnimating = true;

                const [front, ...rest] = cardOrder;
                const elFront = cards[front];
                if (!elFront) { isAnimating = false; return; }

                const backSlot = makeSlot(total - 1);
                const tl = gsap.timeline({
                    onComplete: () => {
                        cardOrder = [...rest, front];
                        isAnimating = false;
                    }
                });
                cardSwapTl = tl;

                // 1. Front card arcs downward and outward with 3D physical tilt (rotateX, rotateZ, translateZ)
                tl.to(elFront, {
                    y: '+=240',
                    z: 90,
                    rotateX: -12,
                    rotateZ: -2,
                    scale: 1.02,
                    duration: 0.32,
                    ease: 'power3.out'
                });

                // 2. Promote the remaining cards forward in depth smoothly
                tl.addLabel('promote', '-=0.22');
                rest.forEach((idx, i) => {
                    const el = cards[idx];
                    if (!el) return;
                    const slot = makeSlot(i);
                    tl.set(el, { zIndex: slot.zIndex }, 'promote');
                    tl.to(
                        el,
                        {
                            x: 0,
                            y: slot.y,
                            z: slot.z,
                            scale: slot.scale,
                            rotateX: 0,
                            rotateZ: 0,
                            duration: 0.42,
                            ease: 'cubic-bezier(0.23, 1, 0.32, 1)'
                        },
                        `promote+=${i * 0.03}`
                    );
                });

                // 3. Send top card to the back slot with elastic spring snap
                tl.addLabel('return', '-=0.18');
                tl.call(() => {
                    gsap.set(elFront, { zIndex: backSlot.zIndex });
                }, undefined, 'return');

                tl.to(
                    elFront,
                    {
                        x: 0,
                        y: backSlot.y,
                        z: backSlot.z,
                        scale: backSlot.scale,
                        rotateX: 0,
                        rotateZ: 0,
                        duration: 0.48,
                        ease: 'back.out(1.4)'
                    },
                    'return'
                );
            };

            // Real-time 1:1 Touch Physics & Manual Tap Handlers
            let startY = 0;
            let currentDragY = 0;

            cards.forEach((card, cardIndex) => {
                const $card = $(card);
                $card.off('.cardswap');

                $card.on('touchstart.cardswap', function (e) {
                    if (isAnimating) return;
                    if (e.originalEvent && e.originalEvent.touches) {
                        startY = e.originalEvent.touches[0].clientY;
                        currentDragY = 0;
                    }
                });

                $card.on('touchmove.cardswap', function (e) {
                    if (isAnimating) return;
                    const posInOrder = cardOrder.indexOf(cardIndex);
                    if (posInOrder === 0 && e.originalEvent && e.originalEvent.touches) {
                        const touchY = e.originalEvent.touches[0].clientY;
                        const diffY = touchY - startY;
                        if (diffY > 0) {
                            currentDragY = diffY;
                            // Real-time physical 3D drag feedback
                            gsap.set(card, {
                                y: currentDragY * 0.85,
                                z: currentDragY * 0.4,
                                rotateX: Math.min(15, currentDragY * 0.08 * -1),
                                rotateZ: Math.min(4, currentDragY * 0.02 * -1)
                            });
                        }
                    }
                });

                $card.on('touchend.cardswap', function (e) {
                    if (isAnimating) return;
                    const posInOrder = cardOrder.indexOf(cardIndex);
                    if (posInOrder === 0 && currentDragY > 45) {
                        currentDragY = 0;
                        manualSwapFrontToBack();
                    } else if (posInOrder === 0 && currentDragY > 0) {
                        currentDragY = 0;
                        // Snap back elastic
                        gsap.to(card, {
                            y: 0,
                            z: 0,
                            rotateX: 0,
                            rotateZ: 0,
                            duration: 0.35,
                            ease: 'elastic.out(0.8, 0.5)'
                        });
                    }
                });

                // Tapping a background peeking card brings it to front
                $card.on('click.cardswap', function (e) {
                    if ($(e.target).closest('[data-toggle="modal"]').length) return;
                    const posInOrder = cardOrder.indexOf(cardIndex);
                    if (posInOrder > 0) {
                        manualSwapFrontToBack();
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });
            });
        }

        $(window).on('resize', function () {
            initMobileCardSwap();
        });

        let isRedirecting = false;

        $(document).on('click', '.sub-account', function (e) {
            sessionStorage.removeItem('a_id');
            sessionStorage.removeItem('account_id');

            // Prevent modal trigger click (3 dots)
            if ($(e.target).closest('[data-toggle="modal"]').length) return;

            if (isRedirecting) return;
            isRedirecting = true;

            const accountId = $(this).data('a-id');
            const accountName = $(this).data('account-name');

            if (!accountId) {
                isRedirecting = false;
                return;
            }

            $(this).addClass('active');

            sessionStorage.setItem('a_id', accountId);
            sessionStorage.setItem('account_name', accountName);

            setTimeout(() => {
                window.location.href = `sub-account/`;
            }, 100);
        });

        // Touch & Press Micro-Animations for Quick Action Pills
        $(document).on('touchstart', '.quick-action-pill', function () {
            $(this).addClass('is-touch-pressed');
        });

        $(document).on('touchend touchcancel', '.quick-action-pill', function () {
            const $el = $(this);
            $el.removeClass('is-touch-pressed').addClass('is-touch-hover');
            setTimeout(() => {
                $el.removeClass('is-touch-hover');
            }, 300);
        });

        // Initial load
        loadAccount();

        // Expose globally
        window.loadAccount = loadAccount;
    });
</script>