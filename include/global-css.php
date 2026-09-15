<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="title" content="Abacoos">
<meta name="author" content="Abacoos">

<link rel="canonical" href="https://abacoos.com/" />

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="120x120" href="<?= WEB_ROOT; ?>assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?= WEB_ROOT; ?>assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?= WEB_ROOT; ?>assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="<?= WEB_ROOT; ?>assets/img/favicon/site.webmanifest">
<link rel="mask-icon" href="<?= WEB_ROOT; ?>assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<!-- Fontawesome -->
<link type="text/css" href="<?= WEB_ROOT; ?>vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

<!-- Google Fonts (UI/UX Pro Max Typography) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

<!-- Tailwind CSS CDN (Responsive Utilities) -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Pixel CSS -->
<link type="text/css" href="<?= WEB_ROOT; ?>css/neumorphism.css" rel="stylesheet">
<link type="text/css" href="<?= WEB_ROOT; ?>css/style.css?v=<?= time(); ?>" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<script src="<?= WEB_ROOT; ?>vendor/jquery/dist/jquery.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Smooth Hardware-Accelerated Page Entrance Animation (/animate) -->
<style>
@keyframes pageSmoothFadeIn {
    0% {
        opacity: 0;
        transform: translate3d(0, 6px, 0);
    }
    100% {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

#main-content-view,
.page-view-wrapper {
    animation: pageSmoothFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    will-change: opacity, transform;
    backface-visibility: hidden;
}

@media (prefers-reduced-motion: reduce) {
    #main-content-view,
    .page-view-wrapper {
        animation: none !important;
        opacity: 1 !important;
    }
}
</style>