# Pages — Abacoos v2

---

## / (Dashboard / Home)
Entry: `index.php` → `home/home.php`

```
index.php
├── include/template.php (shell)
│   ├── include/global-css.php
│   │   ├── vendor/@fortawesome/fontawesome-free/css/all.min.css
│   │   ├── css/neumorphism.css
│   │   └── css/style.css
│   ├── include/header.php
│   │   └── (navbar: logo, Dashboard link, Modules dropdown, Logout)
│   ├── home/home.php  ← MAIN CONTENT
│   │   ├── #modal-access (account access modal)
│   │   └── .section.bg-primary > .container > .row#account-container
│   │       └── [dynamic] .col-6.col-lg-3 > .btn-card.sub-account (account cards)
│   └── include/global-js.php
│       └── (Bootstrap JS, headroom.js, etc.)
```

**Renders**: a full-bleed neumorphic background section (`bg-primary`) containing a 4-up grid of account cards loaded asynchronously from `home/process.php?action=fetch_account`. Each card has account name, balance placeholder, and a 3-dot options button.

---

## /account/ (Account Management)
Entry: `account/index.php`

```
account/index.php
├── include/template.php (shell)
│   ├── include/header.php
│   ├── account/[content partial]
│   │   └── #dataTable (neumorphic DataTable listing)
│   └── include/global-js.php
```

---

## /sub-account/ (Sub Account / Ledger)
Entry: `sub-account/index.php`

```
sub-account/index.php
├── include/template.php (shell)
│   ├── include/header.php
│   ├── sub-account/[content partial]
│   │   └── Transaction list or DataTable
│   └── include/global-js.php
```

---

## /transaction/ (Transactions)
Entry: `transaction/index.php`

```
transaction/index.php
├── include/template.php (shell)
│   ├── include/header.php
│   ├── transaction/[content partial]
│   └── include/global-js.php
```

---

## /login.php
Entry: `login.php` (self-contained, no shared template)

```
login.php
├── include/global-css.php
├── .static-modal-wrapper > .static-modal (neumorphic PIN/password login card)
│   ├── .email-display (pressed inset showing user email)
│   ├── .pin-input-container > .pin-input × 6 (PIN digits)
│   └── .neu-btn (submit)
└── inline JS (PIN input navigation, fetch submit)
```
