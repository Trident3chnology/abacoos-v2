<?php
if (!defined('WEB_ROOT')) {
    header('Location: ../index.php');
    exit;
}
?>
<!-- Modal -->
<div class="static-modal-wrapper">
    <div class="static-modal">

        <form class="needs-validation" novalidate method="post" action="process.php?action=verify"
            enctype="multipart/form-data" name="form" id="form">

            <div class="modal-body">
                <input type="text" class="email-display" name="email" value="<?= $user_data['email']; ?>" readonly>

                <p class="verify-text">Enter the 6-digit code sent to your email</p>

                <div class="pin-input-container">
                    <input type="text" class="pin-input" maxlength="1" data-index="0">
                    <input type="text" class="pin-input" maxlength="1" data-index="1">
                    <input type="text" class="pin-input" maxlength="1" data-index="2">
                    <input type="text" class="pin-input" maxlength="1" data-index="3">
                    <input type="text" class="pin-input" maxlength="1" data-index="4">
                    <input type="text" class="pin-input" maxlength="1" data-index="5">
                </div>

            </div>

        </form>

    </div>
</div>

<script src="<?= WEB_ROOT; ?>assets/js/verification.js"></script>