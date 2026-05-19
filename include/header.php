<header class="header-global">
    <nav id="navbar-main" aria-label="Primary navigation"
        class="navbar navbar-main navbar-expand-lg navbar-theme-primary headroom navbar-dark">
        <div class="container position-relative">
            <a class="navbar-brand shadow-soft py-2 px-3 rounded border border-light mr-lg-4" href="<?= WEB_ROOT; ?>">
                <img class="navbar-brand-dark" src="<?= WEB_ROOT; ?>assets/img/brand/dark.svg" alt="Logo light">
                <img class="navbar-brand-light" src="<?= WEB_ROOT; ?>assets/img/brand/dark.svg" alt="Logo dark">
            </a>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="<?= WEB_ROOT; ?>"
                                class="navbar-brand shadow-soft py-2 px-3 rounded border border-light">
                                <img src="<?= WEB_ROOT; ?>assets/img/brand/dark.svg" alt="Abacoos logo">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <a href="#navbar_global" class="fas fa-times" data-toggle="collapse"
                                data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false"
                                title="close" aria-label="Toggle navigation"></a>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
                    <li class="nav-item">
                        <a href="<?= WEB_ROOT; ?>" class="nav-link">
                            <span class="nav-link-inner-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <span class="nav-link-inner-text">Modules</span>
                            <span class="fas fa-angle-down nav-link-arrow ml-2"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= WEB_ROOT; ?>account">Account</a></li>
                            <li><a class="dropdown-item" href="<?= WEB_ROOT; ?>category">Category</a></li>
                            <li><a class="dropdown-item" href="<?= WEB_ROOT; ?>transfer">Transfer</a></li>
                            <li><a class="dropdown-item" href="<?= WEB_ROOT; ?>report">Report</a></li>
                            <li><a class="dropdown-item" href="<?= WEB_ROOT; ?>user">User</a></li>
                            <li><a class="dropdown-item" href="<?= WEB_ROOT; ?>activity-log">Activity logs</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="<?= WEB_ROOT; ?>?logout" class="nav-link">
                            <span class="nav-link-inner-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <button class="navbar-toggler ml-2" type="button" data-toggle="collapse" data-target="#navbar_global"
                    aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </nav>
</header>