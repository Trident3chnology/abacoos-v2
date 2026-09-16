<?php
require_once 'global-library/database.php';
require_once 'include/functions.php';

$data = [
    "emailAddress" => null,
    "message" => null,
    "field" => null
];

if (isset($_POST['txtEmailAddress'])) {
    $result = doLogin();
    if (!empty($result) && is_array($result)) {
        $data = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Abacoos - Sign in</title>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/global-css.php'); ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --neu-bg: #e6e7ee;
            --neu-text: #44476A;
            --neu-muted: #7e879b;
            --neu-primary: #2D4CC8;
            --neu-primary-hover: #1f3bb3;
            --neu-shadow-dark: #b8b9be;
            --neu-shadow-light: #ffffff;
        }

        body {
            background-color: var(--neu-bg);
            color: var(--neu-text);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .auth-canvas {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.25rem;
            position: relative;
            background: 
                radial-gradient(circle at 18% 18%, rgba(45, 76, 200, 0.06) 0%, transparent 45%),
                radial-gradient(circle at 82% 82%, rgba(45, 76, 200, 0.05) 0%, transparent 45%),
                var(--neu-bg);
        }

        .auth-card {
            max-width: 440px;
            width: 100%;
            background: var(--neu-bg);
            border-radius: 1.75rem;
            box-shadow: 14px 14px 28px var(--neu-shadow-dark), -14px -14px 28px var(--neu-shadow-light);
            border: 1px solid rgba(255, 255, 255, 0.85);
            padding: 2.75rem 2.25rem 2.25rem;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .auth-title {
            font-weight: 900;
            font-style: italic;
            font-size: 2.2rem;
            letter-spacing: -0.02em;
            color: var(--neu-primary);
            line-height: 1.1;
            margin-bottom: 0.35rem;
        }

        .auth-pill-hint {
            display: inline-flex;
            align-items: center;
            background: rgba(45, 76, 200, 0.08);
            color: var(--neu-primary);
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 0.35rem 0.95rem;
            border-radius: 50px;
            margin-top: 0.25rem;
            margin-bottom: 1.85rem;
        }

        .neu-label {
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--neu-text);
            margin-bottom: 0.45rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .neu-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .neu-input-icon {
            position: absolute;
            left: 1.1rem;
            color: var(--neu-muted);
            font-size: 0.95rem;
            pointer-events: none;
            z-index: 5;
            transition: color 0.2s ease;
        }

        .neu-input {
            width: 100%;
            height: 50px;
            padding-left: 2.85rem;
            padding-right: 1.15rem;
            border-radius: 14px;
            background: var(--neu-bg);
            border: 1.5px solid transparent;
            box-shadow: inset 3px 3px 6px var(--neu-shadow-dark), inset -3px -3px 6px var(--neu-shadow-light);
            color: var(--neu-text);
            font-size: 0.93rem;
            font-weight: 600;
            transition: all 0.22s ease;
        }

        .neu-input::placeholder {
            color: #9aa1b3;
            font-weight: 400;
        }

        .neu-input:focus {
            outline: none;
            border-color: var(--neu-primary);
            background: #f0f2f8;
            box-shadow: inset 1.5px 1.5px 4px var(--neu-shadow-dark), inset -1.5px -1.5px 4px var(--neu-shadow-light), 0 0 0 3px rgba(45, 76, 200, 0.15);
        }

        .neu-input-wrapper:focus-within .neu-input-icon {
            color: var(--neu-primary);
        }

        .neu-input.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: inset 2px 2px 4px var(--neu-shadow-dark), inset -2px -2px 4px var(--neu-shadow-light), 0 0 0 3px rgba(220, 53, 69, 0.15) !important;
        }

        .neu-input-password {
            padding-right: 3.1rem;
        }

        .neu-password-toggle {
            position: absolute;
            right: 0.65rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--neu-muted);
            padding: 0.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: color 0.15s ease;
            z-index: 6;
        }

        .neu-password-toggle:hover {
            color: var(--neu-primary);
        }

        .neu-btn-primary {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--neu-primary) 0%, var(--neu-primary-hover) 100%);
            color: #ffffff !important;
            font-weight: 700;
            font-size: 0.96rem;
            letter-spacing: 0.02em;
            box-shadow: 0 8px 20px -4px rgba(45, 76, 200, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
        }

        .neu-btn-primary:hover {
            transform: translateY(-1.5px);
            box-shadow: 0 12px 24px -4px rgba(45, 76, 200, 0.55);
            color: #ffffff !important;
            text-decoration: none;
        }

        .neu-btn-primary:active {
            transform: translateY(1px);
            box-shadow: 0 4px 10px rgba(45, 76, 200, 0.4);
        }

        .neu-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.75rem 0 1.25rem;
            color: var(--neu-muted);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .neu-divider::before,
        .neu-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #d3d7e2;
        }

        .neu-divider span {
            padding: 0 0.85rem;
        }

        .neu-btn-secondary {
            width: 100%;
            height: 46px;
            border-radius: 14px;
            background: var(--neu-bg);
            color: var(--neu-text) !important;
            font-weight: 700;
            font-size: 0.88rem;
            box-shadow: 4px 4px 10px var(--neu-shadow-dark), -4px -4px 10px var(--neu-shadow-light);
            border: 1px solid rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.22s ease;
            text-decoration: none;
        }

        .neu-btn-secondary:hover {
            color: var(--neu-primary) !important;
            transform: translateY(-1.5px);
            box-shadow: 6px 6px 14px var(--neu-shadow-dark), -6px -6px 14px var(--neu-shadow-light);
            text-decoration: none;
        }

        .neu-btn-secondary:active {
            transform: translateY(1px);
            box-shadow: inset 2px 2px 5px var(--neu-shadow-dark), inset -2px -2px 5px var(--neu-shadow-light);
        }

        .auth-footer-shield {
            font-size: 0.78rem;
            color: var(--neu-muted);
            text-align: center;
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .invalid-alert-pill {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 0.6rem 0.9rem;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 1.15rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 576px) {
            .auth-card {
                padding: 2.25rem 1.4rem 1.75rem;
                border-radius: 1.35rem;
            }
            .auth-title {
                font-size: 1.65rem;
            }
        }
    </style>
</head>

<body>
    <main>
        <section class="auth-canvas">
            <div class="auth-card animate__animated animate__fadeIn">
                <!-- Header Branding -->
                <div class="text-center">
                    <div class="auth-title">ABACOOS</div>
                    <div class="auth-pill-hint">
                        <i class="fa-solid fa-lock mr-1" style="font-size: 0.72rem;"></i> Sign in to your account
                    </div>
                </div>

                <!-- Validation Error Message Alert -->
                <?php if (!empty($data['message'])): ?>
                    <div class="invalid-alert-pill">
                        <i class="fa-solid fa-circle-exclamation text-danger"></i>
                        <span><?= htmlspecialchars($data['message']); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form id="form" name="frmLogin" method="post" class="form-submit-loader">
                    <!-- Email Field -->
                    <div class="form-group mb-1">
                        <label for="email" class="neu-label">Email Address</label>
                        <div class="neu-input-wrapper">
                            <i class="fa-regular fa-envelope neu-input-icon"></i>
                            <input type="email"
                                class="neu-input <?= ($data['field'] == 'email') ? 'is-invalid' : ''; ?>"
                                name="txtEmailAddress" id="email"
                                value="<?= htmlspecialchars($data['emailAddress'] ?? ''); ?>"
                                placeholder="name@example.com" autocomplete="email" required autofocus>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group mb-2">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <label for="password" class="neu-label mb-0">Password</label>
                        </div>
                        <div class="neu-input-wrapper">
                            <i class="fa-solid fa-lock neu-input-icon"></i>
                            <input type="password"
                                class="neu-input neu-input-password <?= ($data['field'] == 'password') ? 'is-invalid' : ''; ?>"
                                name="txtPassword" id="password" placeholder="Enter your password" autocomplete="current-password"
                                required>
                            <button type="button" id="togglePasswordBtn" class="neu-password-toggle" title="Show or hide password" aria-label="Toggle password visibility">
                                <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit CTA Button -->
                    <div class="mt-4">
                        <button type="submit" id="submitBtn" class="neu-btn-primary submitBtn">
                            <span>Sign in</span>
                            <i class="fa-solid fa-arrow-right ml-2" style="font-size: 0.85rem;"></i>
                        </button>

                        <button type="button" id="loadingBtn" class="neu-btn-primary loadingBtn d-none" disabled>
                            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                            <span>Authenticating...</span>
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="neu-divider">
                    <span>New to Abacoos?</span>
                </div>

                <!-- Create Account Link Button -->
                <div>
                    <a href="<?= WEB_ROOT; ?>sign-up" class="neu-btn-secondary">
                        <i class="fa-solid fa-user-plus mr-2" style="font-size: 0.82rem; color: var(--neu-primary);"></i>
                        <span>Create an account</span>
                    </a>
                </div>

                <!-- Trust Indicator -->
                <div class="auth-footer-shield">
                    <i class="fa-solid fa-shield-halved text-success"></i>
                    <span>Secure multi-tenant encrypted ledger</span>
                </div>
            </div>
        </section>
    </main>

    <script src="<?= WEB_ROOT; ?>assets/js/sweetAlert.js"></script>
    <script src="<?= WEB_ROOT; ?>assets/js/formSubmitLoader.js"></script>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/global-js.php'); ?>

    <!-- Interactive Polish: Password Visibility Reveal -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const pwdInput = document.getElementById('password');
            const eyeIcon = document.getElementById('togglePasswordIcon');

            if (toggleBtn && pwdInput && eyeIcon) {
                toggleBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const isPassword = pwdInput.type === 'password';
                    pwdInput.type = isPassword ? 'text' : 'password';
                    eyeIcon.className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
                });
            }
        });
    </script>
</body>

</html>