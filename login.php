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
    <!-- Primary Meta Tags -->
    <title>Abacoos - Sign in</title>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/global-css.php'); ?>

    <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

</head>

<body>
    <main>
        <!-- Section -->
        <section class="min-vh-100 d-flex bg-primary align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-5 justify-content-center">
                        <div class="card bg-primary shadow-soft border-light p-4">
                            <div class="card-header text-center pb-0">
                                <h2 class="mb-0 h2">Abacoos</h2>
                            </div>
                            <div class="card-body">
                                <form id="form" name="frmLogin" method="post">
                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email"
                                            class="form-control <?= ($data['field'] == 'email') ? 'is-invalid' : ''; ?>"
                                            name="txtEmailAddress" id="email"
                                            value="<?= htmlspecialchars($data['emailAddress']); ?>"
                                            placeholder="Enter email" autocomplete="off" required>

                                        <?php if ($data['field'] == 'email'): ?>
                                            <div class="invalid-feedback">
                                                <?= $data['message']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="password">Password</label>
                                        <input type="password"
                                            class="form-control <?= ($data['field'] == 'password') ? 'is-invalid' : ''; ?>"
                                            name="txtPassword" id="password" placeholder="Password" autocomplete="off"
                                            required>

                                        <?php if ($data['field'] == 'password'): ?>
                                            <div class="invalid-feedback">
                                                <?= $data['message']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button type="submit" id="submitBtn" class="btn btn-block btn-primary">Sign in</button>

                                    <button type="button" id="loadingBtn" class="btn btn-block btn-primary d-none"
                                        disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <span class="ml-1">Loading...</span>
                                    </button>
                                </form>
                                <div class="d-block d-sm-flex justify-content-center align-items-center mt-4">
                                    <span class="font-weight-normal">
                                        Not registered?
                                        <a href="<?= WEB_ROOT; ?>sign-up" class="font-weight-bold">Create
                                            account</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="<?= WEB_ROOT; ?>assets/js/sweetAlert.js"></script>

    <script src="<?= WEB_ROOT; ?>assets/js/formSubmitLoader.js"></script>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/global-js.php'); ?>
</body>

</html>