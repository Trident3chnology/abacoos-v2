# Documentation Standards & Folder Structure Guide — Obsidian Vault

---

## 1. Overview & Directory Organization Standard

This vault follows the **PARA / Numbered Category Folder Standard** for software engineering projects. Every file is explicitly designated to prevent clutter and maintain traceability.

```
Zero-second brain/
├── 01 - Architecture/
│   └── System Architecture & Technical Specification.md
├── 02 - Database/
│   └── Database Schema & Data Dictionary.md
├── 03 - Modules/
│   ├── Accounts & Sub-Accounts.md
│   ├── Authentication & Onboarding.md
│   └── Transactions & Categories.md
├── 04 - API & Connections/
│   └── API & Data Connections.md
└── 05 - Guidelines/
    └── Codebase Standards & Maintenance.md
```

---

## 2. File Designation Rules

1. **Folder Category Numbering**:
   - `01 - Architecture`: System-level design, layout wrappers, global flows.
   - `02 - Database`: Data models, ERDs, schema dictionaries, SQL migration logs.
   - `03 - Modules`: Feature-specific documentation, user stories, modal behaviors.
   - `04 - API & Connections`: Process routing, AJAX endpoints, response schemas.
   - `05 - Guidelines`: Coding standards, folder structure rules, deployment procedures.

2. **File Naming Convention**:
   - Use clear, descriptive **Title Case** names (`System Architecture & Technical Specification.md`).
   - Avoid duplicate file extensions (e.g., `filename.md.md`).
   - Avoid loose unorganized root notes.

3. **Obsidian Wiki-Links & Code Links**:
   - Every file link should feature both Obsidian internal links `[[01 - Architecture/...]]` and clickable absolute filesystem URLs `[file.php](file:///c:/...)` for IDE compatibility.
