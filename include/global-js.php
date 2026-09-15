<!-- Core -->
<script src="<?= WEB_ROOT; ?>vendor/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/headroom.js/dist/headroom.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Vendor JS -->
<script src="<?= WEB_ROOT; ?>vendor/onscreen/dist/on-screen.umd.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/nouislider/distribute/nouislider.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/jarallax/dist/jarallax.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/jquery.counterup/jquery.counterup.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/jquery-countdown/dist/jquery.countdown.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>
<script src="<?= WEB_ROOT; ?>vendor/prismjs/prism.js"></script>

<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- GSAP Animation Engine -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

<!-- Neumorphism JS -->
<script src="<?= WEB_ROOT; ?>assets/js/neumorphism.js"></script>
<script src="<?= WEB_ROOT; ?>assets/js/cardThemes.js?v=<?= time(); ?>"></script>

<script>
	// Guarantee modal dialogs always render on top of backdrops without screen blur
	$(document).on('show.bs.modal', '.modal', function () {
		$(this).appendTo('body');
	});
</script>
