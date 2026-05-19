<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'fetch_activity_logs':
		fetch_activity_logs_data();
		break;

	default:
		// if action is not defined or unknown
		// move to main category page
		header('Location: index.php');
}

/*
	Fetch Activity Logs Data
*/
function fetch_activity_logs_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id'];

	header('Content-Type: application/json');

	if (!$tenantId) {
		echo json_encode(['error' => 'Tenant ID missing']);
		exit;
	}

	$stmt = $conn->prepare("SELECT al.*, u.first_name, u.last_name
							FROM activity_log al
							LEFT JOIN bs_user u ON al.action_by = u.user_id
							WHERE al.t_id = :t_id
							ORDER BY al.log_action_date DESC");
	$stmt->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
	$stmt->execute();
	$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt = null;

	echo json_encode($logs);
	exit;
}
?>