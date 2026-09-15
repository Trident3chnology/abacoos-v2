<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'fetch_account':
		fetch_account_data();
		break;

	case 'fetch_recent_activity':
		fetch_recent_activity_data();
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
		$stmt = $conn->prepare("
			SELECT 
				a.a_id, 
				a.account_name,
				COALESCE(a.card_theme, 'default') AS card_theme,
				COALESCE((
					SELECT SUM(
						CASE 
							WHEN t.type = 0 THEN t.amount 
							WHEN t.type = 1 THEN -t.amount 
							ELSE 0 
						END
					)
					FROM sub_account sa
					LEFT JOIN transaction t ON sa.sa_id = t.sa_id AND t.is_deleted != '1'
					WHERE sa.a_id = a.a_id AND sa.is_deleted != '1'
				), 0) AS balance
			FROM account a
			WHERE a.t_id = :t_id 
			  AND a.is_deleted != '1'
			ORDER BY a.account_name ASC
		");
		$stmt->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
		$stmt->execute();
		$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$_SESSION['account_count'] = count($response);
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

/*
	Fetch Recent Activity Data for Dashboard Stream
*/
function fetch_recent_activity_data()
{
	include '../global-library/database.php';
	$tenantId = $_SESSION['t_id'];

	header('Content-Type: application/json');

	try {
		$stmt = $conn->prepare("
			SELECT 
				id,
				module,
				action,
				description,
				action_by,
				log_action_date
			FROM activity_log
			WHERE t_id = :t_id
			ORDER BY id DESC
			LIMIT 5
		");
		$stmt->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
		$stmt->execute();
		$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode([
			'status' => true,
			'data' => $logs
		]);
	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}
}
?>