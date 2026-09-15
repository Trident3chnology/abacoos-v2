# Routes — Abacoos v2

Routing is PHP file-based (no framework router). Each page is an `index.php` that sets `$content`, `$pageTitle`, and `$currentPage`, then `require_once 'include/template.php'`.

---

| URL Path       | Entry File            | Content Partial         | Page Title      | Layout                        |
|----------------|-----------------------|-------------------------|-----------------|-------------------------------|
| `/`            | `index.php`           | `home/home.php`         | Dashboard       | header + main + global-js     |
| `/account/`    | `account/index.php`   | `account/...`           | Accounts        | header + main + global-js     |
| `/category/`   | `category/index.php`  | `category/...`          | Category        | header + main + global-js     |
| `/transaction/`| `transaction/index.php`| `transaction/...`      | Transactions    | header + main + global-js     |
| `/sub-account/`| `sub-account/index.php`| `sub-account/...`      | Sub Account     | header + main + global-js     |
| `/user/`       | `user/index.php`      | `user/...`              | User            | header + main + global-js     |
| `/activity-log/`| `activity-log/index.php`| `activity-log/...`   | Activity Log    | header + main + global-js     |
| `/login.php`   | `login.php`           | (self-contained)        | Login           | minimal (no header)           |
| `/register.php`| `register.php`        | (self-contained)        | Register        | minimal (no header)           |

---

## Key Page Summaries

### / (Dashboard / Home)
Entry: `index.php` → content: `home/home.php`
- Shows a grid of account cards (`.sub-account` / `.btn-card`)
- Cards are fetched async via `home/process.php?action=fetch_account`
- Each card shows: account name + balance placeholder
- 3-dot button opens `#modal-access` modal
- Clicking a card saves `a_id` + `account_name` to sessionStorage, redirects to `/sub-account/`
- Layout: `section.bg-primary.section-lg` → `.container` → `.row#account-container` (grid of `.col-6.col-lg-3`)

### /sub-account/ (Sub Account detail)
- Shows transactions or sub-ledger entries for a selected account
- Accessed after selecting an account on the dashboard

### /account/ (Account Management)
- DataTable listing all accounts
- Add / edit / delete account functionality

### /login.php
- Neumorphic PIN-based login or password login
- Static modal wrapper for PIN input
