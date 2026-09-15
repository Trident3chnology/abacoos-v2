# Shared UI Components — Abacoos v2

Framework: PHP (server-rendered HTML)
CSS Framework: Neumorphism UI (Bootstrap-based) + Custom CSS (`css/style.css`)
Icons: Font Awesome 6
JS: jQuery, SweetAlert2, DataTables, Select2

---

## Account Card (`home/home.php`)
- **Category**: Basic / Content card
- **Description**: Clickable card showing an account's name and balance, with a 3-dot menu button.

```html
<div class="btn-card card bg-primary border-light shadow-soft position-relative sub-account"
    data-a-id="{account.a_id}"
    data-account-name="{accountName}">
    <div class="position-absolute" style="top: 12px; right: 12px;">
        <button class="btn btn-link p-2" type="button" data-toggle="modal" data-target="#modal-access">
            <i class="fas fa-ellipsis-v"></i>
        </button>
    </div>
    <div class="card-body">
        <h6 class="h6 card-title mb-2">{accountName}</h6>
        <p class="card-text mb-0"><b>+00,000,000.00</b></p>
        <span class="icon-tertiary small">Balance</span>
    </div>
</div>
```

---

## Bento Grid Item (`css/style.css`)
- **Category**: Basic / Content grid item
- **Description**: A neumorphic grid cell used in bento-style layouts; holds images or file icons.

```html
<div class="bento-item">
    <span class="fas fa-times" title="Remove"></span>
    <img src="..." alt="file" />
    <div class="bento-file">filename.png</div>
</div>
```

---

## Neumorphic Button `.neu-btn`
- **Category**: Basic / Action button
- **Description**: Raised neumorphic button with pressed-in active state.

```html
<button class="neu-btn">Action</button>
```

---

## Modal — Account Access (`home/home.php`)
- **Category**: Basic / Dialog
- **Description**: Bootstrap modal with neumorphic card body; used for account quick-actions.

```html
<div class="modal fade" id="modal-access" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-primary shadow-soft border-light p-4">
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="card-header text-center pb-0">
                        <h2 class="mb-0 h5">Account access</h2>
                    </div>
                    <div class="card-body">
                        <!-- content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

---

## DataTable (`#dataTable`)
- **Category**: Basic / Table
- **Description**: Neumorphic-styled DataTable with custom header and row hover effects.

```html
<table id="dataTable" class="table">
    <thead>...</thead>
    <tbody>...</tbody>
</table>
```

---

## PIN Input
- **Category**: Basic / Form
- **Description**: 6-digit PIN entry with neumorphic raised/pressed states.

```html
<div class="pin-input-container">
    <input type="text" maxlength="1" class="pin-input" />
    <!-- × 6 -->
</div>
```

---

## Select2 Dropdown
- **Category**: Basic / Form select
- **Description**: Custom-styled Select2 matching neumorphic design system (inset shadow, #e6e7ee bg).

---

## SweetAlert2 Popup
- **Category**: Basic / Alert
- **Description**: Neumorphic-rounded popup used for confirmations and success messages. Custom popup classes via `.neu-popup`.
