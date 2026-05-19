<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'fetch_account':
		fetch_account_data();
		break;

	default:
		// if action is not defined or unknown
		// move to main category page
		header('Location: index.php');
}

/*
	Fetch Account Data
*/
function fetch_account_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id']; // single value

	header('Content-Type: application/json');

	$response = [];

	try {
		$stmt = $conn->prepare("SELECT a_id, account_name 
								FROM account 
								WHERE t_id = :t_id 
								AND is_deleted != '1'");
		$stmt->bindValue(':t_id', $tenantId);
		$stmt->execute();
		$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt = null;

	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
		exit;
	}

	echo json_encode([
		'status' => true,
		'data' => $response
	]);
}
?>