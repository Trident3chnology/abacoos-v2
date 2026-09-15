# Extractable Components — Abacoos v2

---

## Layout Components (appear on most pages)

### NavBar
- Source: `include/header.php`
- Category: layout
- Description: Top navigation bar with logo, Dashboard link, Modules dropdown menu, and Logout link
- Extractable props: `activeItem` (string, default: "home"), `webRoot` (string, default: "/")
- Hardcoded: Logo SVG path, nav item labels ("Dashboard", "Modules", "Logout"), dropdown items, all CSS classes

### PageShell
- Source: `include/template.php`
- Category: layout
- Description: Root HTML wrapper that loads global CSS/JS and wraps header + main + footer
- Extractable props: `pageTitle` (string), `content` (HTML slot)
- Hardcoded: DOCTYPE, charset, favicon paths, all script/link tags

---

## Basic Components (used across pages)

### AccountCard
- Source: `home/home.php` (inline in JS template literal)
- Category: basic
- Description: Neumorphic clickable card showing account name and balance with a 3-dot options menu
- Extractable props: `accountName` (string), `accountId` (string), `balance` (string, default: "+00,000,000.00")
- Hardcoded: Card CSS classes (`btn-card`, `bg-primary`, `border-light`, `shadow-soft`), ellipsis icon, "Balance" label, shadow/radius tokens

### AccountGrid
- Source: `home/home.php` (section wrapper)
- Category: basic
- Description: Full-bleed neumorphic section containing the responsive grid of AccountCards
- Extractable props: `cards` (array of AccountCard data)
- Hardcoded: Section class (`section.bg-primary.section-lg`), container, row structure, column classes

### ModalDialog
- Source: `home/home.php` (`#modal-access`)
- Category: basic
- Description: Bootstrap modal with neumorphic card body; used for account quick-actions
- Extractable props: `modalId` (string), `title` (string), `content` (HTML slot)
- Hardcoded: Modal CSS classes, close button, neumorphic card styles

### NeuButton
- Source: `css/style.css` (`.neu-btn`)
- Category: basic
- Description: Raised neumorphic button with pressed active state
- Extractable props: `label` (string), `type` (string, default: "button")
- Hardcoded: Border-radius `12px`, shadow values, background `#e6e7ee`, text color `#44476A`

### NeuPopup (SweetAlert2)
- Source: `css/style.css` (`.neu-popup`)
- Category: basic
- Description: SweetAlert2 popup styled with neumorphic border-radius and box-shadow
- Extractable props: none (configured via JS)
- Hardcoded: Border-radius `1.55rem`, background `#e6e7ee`, shadow values

### DataTable
- Source: `css/style.css` (`#dataTable` styles)
- Category: basic
- Description: Neumorphic-styled DataTable with custom header, row hover, and pagination
- Extractable props: none (DOM-based)
- Hardcoded: All shadow/color/radius values

### PINInput
- Source: `login.php` (`.pin-input-container` / `.pin-input`)
- Category: basic
- Description: 6-digit PIN entry row with neumorphic raised/pressed focus states
- Extractable props: `length` (number, default: 6)
- Hardcoded: Width `55px`, height `55px`, font-size, border-radius `14px`, shadow values

### Select2Field
- Source: `css/style.css` (Select2 overrides)
- Category: basic
- Description: Select2 dropdown styled to match neumorphic design (inset shadow, matching bg)
- Extractable props: `placeholder` (string)
- Hardcoded: Height, padding, border, background `#e6e7ee`, shadow values
