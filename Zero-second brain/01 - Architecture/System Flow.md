# ABACOOS v2 - System Flow & System File Connection Map

---

## 1. Database Connection & Infrastructure Setup
- **Database Connection File**: [[global-library/database.php]] ([`database.php`](file:///c:/xampp2/htdocs/abacoos-v2/global-library/database.php))
  - **Session Management**: Automatically executes `session_start()` if no active session is detected.
  - **Timezone & Date Utilities**: Configured to `Asia/Manila`. Exports `$today_date1`, `$today_date2`, `$today_date3`, `$today_date4`, `$today_month`, `$today_year`, `$today_day`, `$today_time`.
  - **Database Connection (PDO)**:
    - Host: `localhost`
    - User: `root`
    - Database Name: `db_abacoos_v2`
    - Charset: `utf8mb4`
    - PDO Attributes: `ERRMODE_EXCEPTION`, `FETCH_ASSOC`, `PDO::ATTR_PERSISTENT => true`.
  - **User Context Initialization**: Fetches `$userId` and `$tenantId` from `$_SESSION`, querying `bs_user` into global `$user_data`.
  - **System Path Constants**:
    - `SRV_ROOT`: Server root filesystem path.
    - `WEB_ROOT`: Web application base URL path (`/abacoos-v2/`).

---

## 2. Global Includes & Framework Components (`include/`)
- [[include/functions.php]] ([`functions.php`](file:///c:/xampp2/htdocs/abacoos-v2/include/functions.php)): Business logic and auth (`checkUser()`, `doLogin()`, `doRegister()`, `doCompleteRegistration()`, `doLogout()`).
- [[include/template.php]] ([`template.php`](file:///c:/xampp2/htdocs/abacoos-v2/include/template.php)): Main view layout wrapper loading header, left navigation, `$content`, and footer.
- [[include/header.php]] ([`header.php`](file:///c:/xampp2/htdocs/abacoos-v2/include/header.php)): Top navigation bar, session profile widget, CSS links.
- [[include/footer.php]] ([`footer.php`](file:///c:/xampp2/htdocs/abacoos-v2/include/footer.php)): Page footer and JavaScript imports.
- [[include/left-menu.php]] ([`left-menu.php`](file:///c:/xampp2/htdocs/abacoos-v2/include/left-menu.php)): Primary sidebar menu.
- [[include/right-menu.php]] ([`right-menu.php`](file:///c:/xampp2/htdocs/abacoos-v2/include/right-menu.php)): Secondary slide-over menu.
- [[include/global-css.php]] ([`global-css.php`](file:///c:/xampp2/htdocs/abacoos-v2/include/global-css.php)): Centralized CSS includes.
- [[include/global-js.php]] ([`global-js.php`](file:///c:/xampp2/htdocs/abacoos-v2/include/global-js.php)): Centralized JavaScript includes.
- [[include/process.php]] ([`process.php`](file:///c:/xampp2/htdocs/abacoos-v2/include/process.php)): Global request action router.
- **Email Notifications**:
  - [[include/login-attempt-email.php]] & [[include/login-attempt-email.html]]: Password mismatch alert email.
  - [[include/registration-attempt-alert-email.php]] & [[include/registration-attempt-alert-email.html]]: Duplicate sign-up security notification.
  - [[include/send-verification-code-email.php]] & [[include/send-verification-code-email.html]]: Registration verification code email.

---

## 3. System Architecture & Connection Diagram

```
                          +------------------------+
                          | global-library/        |
                          | database.php           |
                          +-----------+------------+
                                      | (PDO, Session, Path Constants)
                                      v
                          +------------------------+
                          | include/functions.php  |
                          +-----------+------------+
                                      |
         +----------------------------+----------------------------+
         | (Auth Check & Routing)                                  | (Template System)
         v                                                         v
+------------------+                                     +-------------------+
| Entry Point      |                                     | include/          |
| index.php        |                                     | template.php      |
+--------+---------+                                     +---------+---------+
         |                                                         |
         +-----------------+                                       | (Renders Layout)
         | Includes        |                                       v
         v                 v                             +-------------------+
  home/home.php     login.php / sign-up.php              | header.php        |
                                                         | left-menu.php     |
                                                         | Page Content      |
                                                         | footer.php        |
                                                         +-------------------+
```

---

## 4. Module Flows & Directory Mapping

### A. Authentication & User Onboarding
- **Files**:
  - [[login.php]] ([`login.php`](file:///c:/xampp2/htdocs/abacoos-v2/login.php))
  - [[sign-up.php]] ([`sign-up.php`](file:///c:/xampp2/htdocs/abacoos-v2/sign-up.php))
  - [[register.php]] ([`register.php`](file:///c:/xampp2/htdocs/abacoos-v2/register.php))
- **Process**:
  1. Signup calls `doRegister()`, creating user record in `bs_user`, initializing tenant record in `tenant` table, and sending verification code.
  2. Login executes `doLogin()`, verifying credentials with `password_verify()`. Failed logins generate device/IP audit security alerts. Successful logins set session `user_id` & `t_id`.

### B. Dashboard (`home/`)
- **Files**:
  - [[index.php]] ([`index.php`](file:///c:/xampp2/htdocs/abacoos-v2/index.php))
  - [[home/home.php]] ([`home.php`](file:///c:/xampp2/htdocs/abacoos-v2/home/home.php))
  - [[home/process.php]] ([`process.php`](file:///c:/xampp2/htdocs/abacoos-v2/home/process.php))

### C. Financial Accounts (`account/`)
- **Files**:
  - [[account/index.php]]
  - [[account/list.php]]
  - [[account/modal-add-account.php]]
  - [[account/modal-edit-account.php]]
  - [[account/process.php]]

### D. Sub-Accounts (`sub-account/`)
- **Files**:
  - [[sub-account/index.php]]
  - [[sub-account/list.php]]
  - [[sub-account/modal-add-sub-account.php]]
  - [[sub-account/modal-edit-sub-account.php]]
  - [[sub-account/process.php]]

### E. Category Management (`category/`)
- **Files**:
  - [[category/index.php]]
  - [[category/list.php]]
  - [[category/modal-add-category.php]]
  - [[category/modal-edit-category.php]]
  - [[category/process.php]]

### F. Internal Transfers (`transfer/`)
- **Files**:
  - [[transfer/index.php]] ([`index.php`](file:///c:/xampp2/htdocs/abacoos-v2/transfer/index.php)): Entry point setting `$pageTitle = 'Transfer'`.
  - [[transfer/list.php]] ([`list.php`](file:///c:/xampp2/htdocs/abacoos-v2/transfer/list.php)): Dual-column Neumorphic interface (Left: Source & Target account preview cards; Right: Transfer form with ₱ Pesos presets, category tag, date, and receipt upload dropzone).
  - [[transfer/process.php]] ([`process.php`](file:///c:/xampp2/htdocs/abacoos-v2/transfer/process.php)): Inter-account transaction processing (`process_transfer_data`), executing atomic double-entry transactions (`type = 1` for OUT, `type = 0` for IN) and recording WebP converted attachments and activity logs.
  - [[assets/js/transfer.js]] ([`transfer.js`](file:///c:/xampp2/htdocs/abacoos-v2/assets/js/transfer.js)): Client-side balance calculation, preset amount buttons (+₱50, +₱100, +₱500, MAX), drag-and-drop file feedback, and AJAX form submission.

### G. User Management (`user/`)
- **Files**:
  - [[user/index.php]]
  - [[user/list.php]]
  - [[user/modal-invite-user.php]]
  - [[user/send-invitation-email.php]]
  - [[user/process.php]]

### H. Activity Logging (`activity-log/`)
- **Files**:
  - [[activity-log/index.php]]
  - [[activity-log/list.php]]
  - [[activity-log/process.php]]

---

## 5. Database Schema Scripts (`database/`)
- [[database/db_abacoos_v2-081226.sql]]
- [[database/db_abacoos_v2-070826.sql]]
- [[database/db_app.sql]]
