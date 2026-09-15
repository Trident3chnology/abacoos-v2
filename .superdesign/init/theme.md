# Theme — Abacoos v2

---

## Part 1 — Compact Token Summary

### Design System
**Style**: Neumorphism (soft UI / skeuomorphic shadows on flat surfaces)  
**Base Library**: Neumorphism UI Pro (Bootstrap 4-based)  
**Custom overrides**: `css/style.css`

### Color Palette

| Token / Purpose          | Value        |
|--------------------------|--------------|
| Background (primary)     | `#e6e7ee`    |
| Background (alt)         | `#e0e5ec`    |
| Background (subtle)      | `#f0f0f5`    |
| Background (hover)       | `#dfe0e9`    |
| Text primary             | `#44476A`    |
| Text secondary           | `#6c757d`    |
| Text on dark             | `#ECF0F3`    |
| Accent / brand blue      | `#2D4CC8`    |
| Accent hover             | `#1f3899`    |
| Success / green          | `#00c853`    |
| Danger / red             | `#dc3545`    |
| Danger hover             | `#a71d2a`    |
| Border light             | `#D1D9E6`    |
| Shadow dark              | `#b8b9be`    |
| Shadow light (highlight) | `#ffffff`    |

### Typography
- **Font**: Bootstrap/neumorphism default system font stack (no custom Google Font currently loaded)
- **Weights used**: 300 (light inputs), 500, 600, bold
- **Color**: `#44476A` (primary text), `#6c757d` (secondary/muted)

### Neumorphic Shadow System
Raised (outset):
```
box-shadow: 6px 6px 12px #b8b9be, -6px -6px 12px #ffffff
```
Pressed (inset):
```
box-shadow: inset 6px 6px 12px #b8b9be, inset -6px -6px 12px #ffffff
```
Subtle raised (cards):
```
box-shadow: 2px 2px 5px rgba(184, 185, 190, 0.15), -2px -2px 5px rgba(255, 255, 255, 0.5)
```
Subtle pressed (inputs/search):
```
box-shadow: inset 2px 2px 5px #b8b9be, inset -3px -3px 7px #ffffff
```

### Border Radius
| Component              | Radius         |
|------------------------|----------------|
| Cards / modals         | `1.55rem`      |
| Buttons / neu-btn      | `12px`         |
| Inputs / select        | `0.55rem`      |
| PIN inputs             | `14px`         |
| Bento items            | `10px`         |
| Dropdown options       | `0.4rem`       |

### Spacing / Layout
- Content section: `section.bg-primary.section-lg` with Bootstrap `.container`
- Grid: Bootstrap 4 rows + `.col-6 .col-sm-6 .col-lg-3` for account cards (4-up on desktop, 2-up on mobile)
- Card body padding: Bootstrap defaults + `p-4` on modals

### Animation
- Card hover: `transform: translateY(-2px)` + 0.3s ease transition
- Card active: inset neumorphic shadow (pressed effect)
- Modal entrance: `fadeInScale` keyframe (scale 0.9→1, opacity 0→1, 0.4s ease)
- PIN input focus: scale 0.95 + inset shadow
- Backdrop: `blur(10px)` + `rgba(0,0,0,0.25)`

### Bootstrap 4 breakpoints
- xs: <576px
- sm: ≥576px
- md: ≥768px
- lg: ≥992px
- xl: ≥1200px

---

## Part 2 — Raw Source

### `css/style.css` key variables (extracted from file)

Background base: `#e6e7ee` / `#e0e5ec`
Text: `#44476A`
Shadow pair: `#b8b9be` (dark) / `#ffffff` (light)
Radius: `1.55rem` (large), `0.55rem` (small)

### External CSS loaded
- `vendor/@fortawesome/fontawesome-free/css/all.min.css`
- `css/neumorphism.css` (Neumorphism UI Pro — 733 KB, Bootstrap 4-based design system)
- `css/style.css` (custom, 14 KB)
- CDN: FontAwesome 6, DataTables Bootstrap5, Select2
