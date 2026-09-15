# API & Data Connections — ABACOOS v2

---

## 1. AJAX Action Router Architecture

In ABACOOS v2, frontend views communicate with backend processors via asynchronous `fetch()` or jQuery `$.ajax()` endpoints using a unified action routing pattern:

`[module]/process.php?action=[action_name]`

---

## 2. Core Module Action Matrix

### A. Home / Dashboard (`home/process.php`)
- `fetch_account`: Fetches accounts owned by tenant `$_SESSION['t_id']` with total balances.

### B. Accounts (`account/process.php`)
- `check_add_account_name_data`: Verifies account name uniqueness and checks tenant account limit (`account` column in `tenant` table).
- `add_account_data`: Inserts new account if under subscription limit.
- `edit_account_data`: Updates account name.
- `delete_account_data`: Sets `is_deleted = 1` for target account.

### C. Sub-Accounts (`sub-account/process.php`)
- `check_add_sub_account_data`: Validates sub-account limit and name uniqueness.
- `add_sub_account_data`: Creates sub-account under specified `a_id`.
- `edit_sub_account_data`: Updates sub-account name & number.
- `delete_sub_account_data`: Soft deletes sub-account.

### D. Transactions (`transaction/process.php`)
- `add_transaction_data`: Records Debit/Credit ledger entry.
- `edit_transaction_data`: Modifies transaction details.
- `delete_transaction_data`: Soft deletes transaction record.

### E. Users (`user/process.php`)
- `check_invite_user_data`: Verifies tenant user limit (`user` column in `tenant` table).
- `invite_user_data`: Generates user invitation record and triggers PHPMailer invitation email.
- `delete_user_data`: Soft deletes user access.
