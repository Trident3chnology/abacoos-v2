# Design System — Abacoos v2

## Product Context
**Abacoos** is a personal/family accounting & bookkeeping web app. Users manage multiple accounts (bank, cash, savings, etc.), log transactions, and track balances. The primary action on the dashboard is selecting an account to drill into sub-ledger transactions.

**Key pages**: Dashboard (account grid), Sub-Account (transactions), Account Management, Category, Transfer, Reports, Activity Log.

**Target audience**: Individual users and small households managing their own finances. Desktop-first, but responsive down to mobile.

---

## Branding & Visual Identity
- **Style**: Neumorphism (soft UI) — raised and pressed surfaces on a light gray base
- **Mood**: Clean, trustworthy, calm. Financial app — conveys safety and clarity.
- **Logo**: `assets/img/brand/dark.svg` (SVG logo mark)

---

## Color Palette

| Role                    | Value        |
|-------------------------|--------------|
| Surface / bg-primary    | `#e6e7ee`    |
| Surface alt             | `#e0e5ec`    |
| Surface subtle          | `#f0f0f5`    |
| Surface hover           | `#dfe0e9`    |
| Text primary            | `#44476A`    |
| Text secondary / muted  | `#6c757d`    |
| Text on dark            | `#ECF0F3`    |
| Brand accent blue       | `#2D4CC8`    |
| Brand accent hover      | `#1f3899`    |
| Success green           | `#00c853`    |
| Danger red              | `#dc3545`    |
| Shadow dark             | `#b8b9be`    |
| Shadow light            | `#ffffff`    |
| Border                  | `#D1D9E6`    |

---

## Typography
- **Font family**: System font stack (Bootstrap default) — no custom font currently
- **Recommended upgrade**: Inter or DM Sans for a more polished feel
- **Weight scale**: 300 (inputs/light), 400 (body), 500 (muted labels), 600 (headings/emphasis), 700+ (balance figures)
- **Primary text color**: `#44476A`
- **Secondary/muted**: `#6c757d`

---

## Shadow & Depth (Neumorphic)

| State         | Shadow                                                                 |
|---------------|------------------------------------------------------------------------|
| Raised (card) | `6px 6px 12px #b8b9be, -6px -6px 12px #ffffff`                        |
| Pressed       | `inset 6px 6px 12px #b8b9be, inset -6px -6px 12px #ffffff`            |
| Subtle raised | `2px 2px 5px rgba(184,185,190,0.15), -2px -2px 5px rgba(255,255,255,0.5)` |
| Subtle pressed| `inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #ffffff`              |

---

## Border Radius

| Component          | Radius     |
|--------------------|------------|
| Cards / Modals     | `1.55rem`  |
| Buttons            | `12px`     |
| Inputs / Selects   | `0.55rem`  |
| PIN inputs         | `14px`     |
| Bento items        | `10px`     |
| Dropdown options   | `0.4rem`   |

---

## Spacing
- Base unit: Bootstrap 4 spacing (4px increments)
- Section padding: `section-lg` class (large vertical padding)
- Card body: Bootstrap defaults + p-4 for modal cards
- Account card grid: 4 columns on desktop, 2 on mobile (`col-6 col-lg-3`)

---

## Component Patterns

### Account Card (Dashboard)
- Raised neumorphic surface on `#e6e7ee` background
- Hover: `translateY(-2px)` lift
- Active/click: inset pressed shadow
- Contains: account name (h6), balance (bold), "Balance" label (muted small), 3-dot menu (top-right absolute)

### Navigation Bar
- `navbar-dark` variant on neumorphism primary bg
- Logo with neumorphic pill border + shadow
- Links: Dashboard, Modules (dropdown), Logout
- Mobile: hamburger collapse

### Modals
- Blur backdrop: `blur(10px)` + `rgba(0,0,0,0.25)`
- Neumorphic card body (raised shadow, `1.55rem` radius)
- Entrance animation: `fadeInScale` 0.4s

### DataTable
- Full neumorphic surface with no visible borders
- Header: subtle bottom shadow separator
- Row hover: slight translateY lift + shadow

---

## Motion / Animation

| Animation        | Details                                          |
|------------------|--------------------------------------------------|
| Card hover       | `translateY(-2px)`, 0.3s ease                    |
| Card active      | Inset pressed shadow, 0s                         |
| Modal entrance   | `fadeInScale`: scale 0.9→1, opacity 0→1, 0.4s   |
| PIN focus        | `scale(0.95)` + inset shadow                     |
| Backdrop         | `blur(10px)` blur                                |

---

## Layout Structure
- Full-width page with Bootstrap 4 container (max-width ~1140px)
- Navbar fixed at top
- Content: `<main>` with `section.bg-primary.section-lg` wrapper
- Dashboard grid: `.row` with `.col-6.col-sm-6.col-lg-3.mb-5` per account card
- No sidebar — pure top-nav + content layout

---

## Project-Specific Requirements
- Neumorphism design must be preserved — all new UI should match the raised/pressed soft shadow aesthetic
- Background color `#e6e7ee` / `#e0e5ec` must be maintained throughout
- Text color `#44476A` is the primary dark tone — do not use pure black
- Font Awesome icons for all iconography
- Bootstrap 4 grid system for layout
- All interactive elements should have hover + active neumorphic feedback
- Financial data (balance, amounts) displayed with bold weight
- Keep UI calm and uncluttered — avoid bright gradients or high-contrast elements that would undermine the soft neumorphic feel
