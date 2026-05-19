<?php
require_once 'global-library/database.php';
require_once 'include/functions.php';

$uid = trim($_GET['uid'] ?? '');

// Get Email from uid
$stmt = $conn->prepare("SELECT email FROM bs_user WHERE uid = :uid AND is_deleted != '1' LIMIT 1");
$stmt->execute([':uid' => $uid]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null;

$email = $user['email'] ?? '';

$data = [
    "firstName" => null,
    "lastName" => null,
    "email" => $email,
    "message" => null,
    "field" => null
];

if (isset($_POST['email'])) {
    $result = doCompleteRegistration();
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
    <title>Abacoos - Sign up</title>

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
                                <h2 class="mb-2 h2">Abacoos</h2>
                                <h6 class="mb-0 h6">Create Account</h6>
                            </div>
                            <div class="card-body">
                                <form id="form" name="frmRegister" method="post">
                                    <input type="hidden" name="uid" value="<?= htmlspecialchars($uid); ?>">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="firstName">First name</label>
                                                <input type="text" class="form-control" name="firstName" id="firstName"
                                                    value="<?= htmlspecialchars($data['firstName']); ?>"
                                                    placeholder="Enter first name" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="lastName">Last name</label>
                                                <input type="text"
                                                    class="form-control <?= ($data['field'] == 'lastName') ? 'is-invalid' : ''; ?>"
                                                    name="lastName" id="lastName"
                                                    value="<?= htmlspecialchars($data['lastName']); ?>"
                                                    placeholder="Enter last name" autocomplete="off" required>

                                                <?php if ($data['field'] == 'lastName'): ?>
                                                    <div class="invalid-feedback">
                                                        <?= $data['message']; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form -->
                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email"
                                            class="form-control <?= ($data['field'] == 'email') ? 'is-invalid' : ''; ?>"
                                            name="email" id="email" value="<?= htmlspecialchars($data['email']); ?>"
                                            placeholder="Enter email" autocomplete="off" required readonly>

                                        <?php if ($data['field'] == 'email'): ?>
                                            <div class="invalid-feedback">
                                                <?= $data['message']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- End of Form -->
                                    <div class="form-group mb-4">
                                        <!-- Form -->
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password"
                                                class="form-control <?= ($data['field'] == 'password') ? 'is-invalid' : ''; ?>"
                                                name="password" id="password" placeholder="Password" autocomplete="off"
                                                required>

                                            <?php if ($data['field'] == 'password'): ?>
                                                <div class="invalid-feedback">
                                                    <?= $data['message']; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <!-- End of Form -->
                                        <!-- Form -->
                                        <div class="form-group mb-4">
                                            <label for="confirmPassword">Confirm Password</label>
                                            <input type="password"
                                                class="form-control <?= ($data['field'] == 'confirmPassword') ? 'is-invalid' : ''; ?>"
                                                name="confirmPassword" id="confirmPassword"
                                                placeholder="Confirm password" autocomplete="off" required>

                                            <?php if ($data['field'] == 'confirmPassword'): ?>
                                                <div class="invalid-feedback">
                                                    <?= $data['message']; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <!-- End of Form -->
                                        <!-- <div class="form-check mb-4">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck6">
                                            <label class="form-check-label" for="defaultCheck6">
                                                I agree to the <a href="#">terms and conditions</a>
                                            </label>
                                        </div> -->
                                    </div>
                                    <button type="submit" id="submitBtn" class="btn btn-block btn-primary">
                                        Try it free
                                    </button>

                                    <button type="button" id="loadingBtn" class="btn btn-block btn-primary d-none"
                                        disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <span class="ml-1">Loading...</span>
                                    </button>
                                </form>
                                <div class="d-block d-sm-flex justify-content-center align-items-center mt-4">
                                    <span class="font-weight-normal">
                                        Already have an account?
                                        <a href="<?= WEB_ROOT; ?>login" class="font-weight-bold">Login here</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="<?= WEB_ROOT; ?>assets/js/formSubmitLoader.js"></script>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/global-js.php'); ?>
</body>

</html>