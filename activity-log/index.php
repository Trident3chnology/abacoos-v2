<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$pageTitle = 'Activity logs';

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {
	case 'list':
		$content = 'list.php';
		break;

	default:
		$content = 'list.php';
}

require_once '../include/template.php';
?>