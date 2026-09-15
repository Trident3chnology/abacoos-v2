<?php
require_once 'global-library/database.php';
require_once 'include/functions.php';

checkUser();

if (isset($_SESSION['user_id'])):
	$userId = $_SESSION['user_id'];
	$stmtUser = $conn->prepare("SELECT first_name FROM bs_user WHERE user_id = :user_id LIMIT 1");
	$stmtUser->execute([':user_id' => $userId]);
	$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
	$userName = $userData['first_name'] ?? '';
endif;

$currentPage = 'Home';
$content = 'home/home.php';
$pageTitle = 'Dashboard';

require_once 'include/template.php';
?>