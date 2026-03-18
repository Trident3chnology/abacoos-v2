<?php
if (!defined('WEB_ROOT')) {
    header('Location: ../index.php');
    exit;
}

$self = WEB_ROOT . 'index.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Abacoos - <?= $pageTitle; ?></title>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/global-css.php'); ?>

    <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

</head>

<body>
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/header.php'); ?>

    <main>
        <?php require_once $content; ?>
    </main>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/footer.php'); ?>

    <?php include($_SERVER["DOCUMENT_ROOT"] . '/' . WEB_ROOT . '/include/global-js.php'); ?>
</body>

</html>