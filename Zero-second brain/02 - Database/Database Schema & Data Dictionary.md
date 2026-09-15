# Database Schema & Data Dictionary — ABACOOS v2

---

## 1. Relational Database Model (`db_abacoos_v2`)

The database consists of **8 primary tables** engineered for multi-tenant data partitioning (`t_id` column).

---

## 2. Table Specifications

### A. `tenant` (Tenant Accounts)
Stores organization/household accounts and feature limits.
- `t_id` (INT, PK, Auto): Tenant unique identifier.
- `user_id` (INT): Primary tenant owner reference (`bs_user.user_id`).
- `s_id` (INT): Subscription plan reference (`subscription.s_id`).
- `account` (INT): Max main accounts limit (`0` = unli).
- `sub_account` (INT): Max sub-accounts limit (`0` = unli).
- `user` (INT): Max user invites limit (`0` = unli).
- `transfer` (INT): Flag enabling transfer module (`0` = disabled, `1` = enabled).

### B. `bs_user` (Users & Authentication)
Stores user credentials and authorization roles.
- `user_id` (INT, PK, Auto): User ID.
- `t_id` (INT): Foreign key to tenant record.
- `email` (TEXT): Unique login email address.
- `password` (TEXT): Bcrypt hashed password (`password_hash()`).
- `is_admin` (INT): Admin status (`1` = admin, `0` = standard member).
- `is_verified` (INT): Email verification status (`1` = verified).

### C. `account` (Financial Accounts)
Main financial account containers (e.g., BDO, Cash, Savings).
- `a_id` (INT, PK, Auto): Account ID.
- `t_id` (INT): Tenant ID owner.
- `account_name` (TEXT): Display name.
- `is_deleted` (INT): Soft delete flag (`1` = deleted).

### D. `sub_account` (Sub-Ledgers)
Sub-accounts nested under main accounts.
- `sa_id` (INT, PK, Auto): Sub-account ID.
- `t_id` (INT): Tenant ID.
- `a_id` (INT): Parent main account reference (`account.a_id`).
- `sub_account_name` (TEXT): Sub-account title.
- `sub_account_number` (TEXT): Account number identifier.

### E. `transaction` (Financial Ledger Entries)
Debit and credit financial entries.
- `tr_id` (INT, PK, Auto): Transaction ID.
- `t_id` (INT): Tenant ID.
- `a_id` (INT): Main account reference.
- `sa_id` (INT): Sub-account reference.
- `c_id` (INT): Category reference (`category.c_id`).
- `amount` (DECIMAL): Financial amount.
- `type` (VARCHAR): Transaction flow (`IN` / `OUT`).

### F. `category` (Transaction Categories)
Taxonomy for income and expenses.
- `c_id` (INT, PK, Auto): Category ID.
- `t_id` (INT): Tenant ID.
- `category_name` (TEXT): Category label.

### G. `activity_log` (System Audit Trail)
Tracks all security and data modification events.
- `id` (INT, PK, Auto): Log entry ID.
- `t_id` (INT): Tenant ID.
- `module` (VARCHAR): Affected system module.
- `action` (VARCHAR): Action type (`Add`, `Edit`, `Delete`, `Tenant Email Verified`).
- `description` (TEXT): Detailed change payload.
- `action_by` (INT): User ID who performed the action.
- `log_action_date` (VARCHAR): Timestamp of action.

### H. `subscription` (Subscription Tiers Master)
Defines tier packages (`Free`, `Basic`, `Pro`).
