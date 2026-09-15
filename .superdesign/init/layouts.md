# Shared Layout Components — Abacoos v2

---

## Header / Navbar (`include/header.php`)
- **Description**: Top navigation bar with logo, nav links (Dashboard, Modules dropdown, Logout), and mobile hamburger toggle. Built with Bootstrap navbar + neumorphism theme.

```html
<header class="header-global">
    <nav id="navbar-main" aria-label="Primary navigation"
        class="navbar navbar-main navbar-expand-lg navbar-theme-primary headroom navbar-dark">
        <div class="container position-relative">
            <a class="navbar-brand shadow-soft py-2 px-3 rounded border border-light mr-lg-4" href="{WEB_ROOT}">
                <img class="navbar-brand-dark" src="{WEB_ROOT}assets/img/brand/dark.svg" alt="Logo light">
                <img class="navbar-brand-light" src="{WEB_ROOT}assets/img/brand/dark.svg" alt="Logo dark">
            </a>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{WEB_ROOT}" class="navbar-brand shadow-soft py-2 px-3 rounded border border-light">
                                <img src="{WEB_ROOT}assets/img/brand/dark.svg" alt="Abacoos logo">
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
                        <a href="{WEB_ROOT}" class="nav-link">
                            <span class="nav-link-inner-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <span class="nav-link-inner-text">Modules</span>
                            <span class="fas fa-angle-down nav-link-arrow ml-2"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{WEB_ROOT}account">Account</a></li>
                            <li><a class="dropdown-item" href="{WEB_ROOT}category">Category</a></li>
                            <li><a class="dropdown-item" href="{WEB_ROOT}transfer">Transfer</a></li>
                            <li><a class="dropdown-item" href="{WEB_ROOT}report">Report</a></li>
                            <li><a class="dropdown-item" href="{WEB_ROOT}user">User</a></li>
                            <li><a class="dropdown-item" href="{WEB_ROOT}activity-log">Activity logs</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{WEB_ROOT}?logout" class="nav-link">
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
```

---

## Template / Page Shell (`include/template.php`)
- **Description**: Root HTML shell: loads global CSS, renders header, main content area, footer, and global JS. `$content` is a path to the included page partial.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Abacoos - {$pageTitle}</title>
    <!-- global-css.php: meta tags, favicons, FontAwesome, neumorphism.css, style.css, SweetAlert2, jQuery, Select2, DataTables -->
</head>
<body>
    <!-- header.php: navbar -->
    <main>
        <!-- $content: page partial (e.g. home/home.php) -->
    </main>
    <!-- footer.php: currently commented out -->
    <!-- global-js.php: Bootstrap JS, headroom.js, etc. -->
</body>
</html>
```

---

## Footer (`include/footer.php`)
- **Description**: Currently fully commented out — no visible footer is rendered.

---

## Global CSS includes (`include/global-css.php`)
Loads in order:
1. `vendor/@fortawesome/fontawesome-free/css/all.min.css`
2. `css/neumorphism.css` (Neumorphism UI Pro — Bootstrap-based design system)
3. `css/style.css` (Custom overrides and components)
4. CDN: Font Awesome 6, DataTables Bootstrap5, SweetAlert2, jQuery, Select2
