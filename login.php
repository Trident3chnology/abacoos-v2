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
                                <h2 class="h4">Sign in to our platform</h2>
                            </div>
                            <div class="card-body">
                                <form id="loginform" name="frmLogin" method="post">
                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email"
                                            class="form-control <?= ($data['field'] == 'email') ? 'is-invalid' : ''; ?>"
                                            name="txtEmailAddress" id="email"
                                            value="<?= htmlspecialchars($data['emailAddress']); ?>"
                                            placeholder="Enter email" autocomplete="off">

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
                                            name="txtPassword" id="password" placeholder="Password" autocomplete="off">

                                        <?php if ($data['field'] == 'password'): ?>
                                            <div class="invalid-feedback">
                                                <?= $data['message']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button type="submit" class="btn btn-block btn-primary">Sign in</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/global-js.php'); ?>
</body>

</html>