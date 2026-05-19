<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'fetch_account':
		fetch_account_data();
		break;

	case 'check_add_account_name':
		check_add_account_name_data();
		break;

	case 'add_account':
		add_account_data();
		break;

	case 'check_edit_account_name':
		check_edit_account_name_data();
		break;

	case 'edit_account':
		edit_account_data();
		break;

	case 'delete':
		delete_data();
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

	if (!$tenantId) {
		echo json_encode(['error' => 'Tenant ID missing']);
		exit;
	}

	$stmt = $conn->prepare("SELECT a_id, account_name
							FROM account
							WHERE t_id = :t_id AND is_deleted != '1'
							ORDER BY account_name DESC");
	$stmt->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
	$stmt->execute();
	$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt = null;

	echo json_encode($accounts);
	exit;
}

/*
	Check Add Account Name Data
*/
function check_add_account_name_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? null;
	$tenantId = $_SESSION['t_id'] ?? null;

	header('Content-Type: application/json');

	$addAccountName = $_GET['addAccountName'] ?? '';
	$response = ['status' => false, 'message' => 'Account name looks good!'];

	if (!$tenantId || !$addAccountName) {
		echo json_encode($response);
		exit;
	}

	// Get Tenant Account Limits
	$gtal = $conn->prepare("SELECT account FROM tenant WHERE t_id = :t_id LIMIT 1");
	$gtal->execute([':t_id' => $tenantId]);
	$tenantData = $gtal->fetch(PDO::FETCH_ASSOC);
	$gtal = null;

	$accLimit = $tenantData['account'] ?? '0'; // 0 means unlimited

	$stmt = $conn->prepare("SELECT 
								COUNT(DISTINCT a_id) AS total_accounts,
								SUM(CASE 
									WHEN account_name = :account_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS account_name_exists
							FROM account
							WHERE t_id = :t_id AND is_deleted != '1'");
	$stmt->execute([
		':account_name' => $addAccountName,
		':t_id' => $tenantId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($accLimit != '0') {
			if ($data['total_accounts'] < $accLimit) {
				if ($data['account_name_exists'] > 0) {
					$response['status'] = true;
					$response['message'] = 'Account name already exists.';
				}
			} else {
				$response['status'] = true;
				$response['message'] = "You've reached your subscription limit";
			}
		}
	}

	echo json_encode($response);
	exit;
}

/*
	Add Account Data
*/
function add_account_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id'];

	$addAccountName = trim($_POST['addAccountName'] ?? '');

	// Get Tenant Account Limits
	$gtal = $conn->prepare("SELECT account FROM tenant WHERE t_id = :t_id LIMIT 1");
	$gtal->execute([':t_id' => $tenantId]);
	$tenantData = $gtal->fetch(PDO::FETCH_ASSOC);
	$gtal = null;

	$accLimit = $tenantData['account'] ?? '0'; // 0 means unlimited

	$stmt = $conn->prepare("SELECT 
								COUNT(DISTINCT a_id) AS total_accounts,
								SUM(CASE 
									WHEN account_name = :account_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS account_name_exists
							FROM account
							WHERE t_id = :t_id AND is_deleted != '1'");
	$stmt->execute([
		':account_name' => $addAccountName,
		':t_id' => $tenantId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($accLimit != '0') {
			if ($data['total_accounts'] < $accLimit) {
				if ($data['account_name_exists'] > 0) {
					header("Location: " . WEB_ROOT . "account/?promptStatus=error&promptMessage=" . urlencode("Account name already exists."));
					exit;
				}
			} else {
				header("Location: " . WEB_ROOT . "account/?promptStatus=error&promptMessage=" . urlencode("You've reached your subscription limit"));
				exit;
			}
		}
	}

	// Insert Account Data
	$itud = $conn->prepare("INSERT INTO account (t_id, account_name, date_added, added_by)
										VALUES (:t_id, :account_name, :date_added, :added_by)");
	$itud->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$itud->bindParam(':account_name', $addAccountName, PDO::PARAM_STR);
	$itud->bindParam(':date_added', $today_date1, PDO::PARAM_STR);
	$itud->bindParam(':added_by', $userId, PDO::PARAM_INT);
	$itud->execute();

	$keyword = 'Account Name: <b>' . htmlspecialchars($addAccountName ?? '', ENT_QUOTES, 'UTF-8') . '</b>';

	$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'Account', 'Add', :description, :action_by, :log_action_date)");
	$log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$log->bindParam(':description', $keyword, PDO::PARAM_STR);
	$log->bindParam(':action_by', $userId, PDO::PARAM_INT);
	$log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
	$log->execute();

	header("Location: " . WEB_ROOT . "account/?promptStatus=success&promptMessage=" . urlencode("Account added successfully."));
	exit;
}

/*
	Check Edit Account Name Data
*/
function check_edit_account_name_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? null;
	$tenantId = $_SESSION['t_id'] ?? null;

	header('Content-Type: application/json');

	$editAccountName = $_GET['editAccountName'] ?? '';
	$aId = $_GET['aId'] ?? '';
	$response = ['status' => false, 'message' => 'Account name looks good!'];

	if (!$tenantId || !$editAccountName || !$aId) {
		echo json_encode($response);
		exit;
	}

	// Get Tenant Account Limits
	$gtal = $conn->prepare("SELECT account FROM tenant WHERE t_id = :t_id LIMIT 1");
	$gtal->execute([':t_id' => $tenantId]);
	$tenantData = $gtal->fetch(PDO::FETCH_ASSOC);
	$gtal = null;

	$accLimit = $tenantData['account'] ?? '0'; // 0 means unlimited

	$stmt = $conn->prepare("SELECT 
								COUNT(DISTINCT a_id) AS total_accounts,
								SUM(CASE 
									WHEN account_name = :account_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS account_name_exists
							FROM account
							WHERE t_id = :t_id AND a_id != :a_id AND is_deleted != '1'");
	$stmt->execute([
		':account_name' => $editAccountName,
		':t_id' => $tenantId,
		':a_id' => $aId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($accLimit != '0') {
			if ($data['total_accounts'] < $accLimit) {
				if ($data['account_name_exists'] > 0) {
					$response['status'] = true;
					$response['message'] = 'Account name already exists.';
				}
			} else {
				$response['status'] = true;
				$response['message'] = "You've reached your subscription limit";
			}
		}
	}

	echo json_encode($response);
	exit;
}

/*
	Edit Account Data
*/
function edit_account_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? 0;
	$tenantId = $_SESSION['t_id'] ?? 0;

	$editAccountName = trim($_POST['editAccountName'] ?? '');
	$a_id = ($_POST['a_id'] ?? '');

	// Get Tenant Account Limits
	$gtal = $conn->prepare("SELECT account FROM tenant WHERE t_id = :t_id LIMIT 1");
	$gtal->execute([':t_id' => $tenantId]);
	$tenantData = $gtal->fetch(PDO::FETCH_ASSOC);
	$gtal = null;

	$accLimit = $tenantData['account'] ?? '0'; // 0 means unlimited

	$stmt = $conn->prepare("SELECT 
								COUNT(DISTINCT a_id) AS total_accounts,
								SUM(CASE 
									WHEN account_name = :account_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS account_name_exists
							FROM account
							WHERE t_id = :t_id AND a_id != :a_id AND is_deleted != '1'");
	$stmt->execute([
		':account_name' => $editAccountName,
		':t_id' => $tenantId,
		':a_id' => $aId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($accLimit != '0') {
			if ($data['total_accounts'] < $accLimit) {
				if ($data['account_name_exists'] > 0) {
					header("Location: " . WEB_ROOT . "account/?promptStatus=error&promptMessage=" . urlencode("Account name already exists."));
					exit;
				}
			} else {
				header("Location: " . WEB_ROOT . "account/?promptStatus=error&promptMessage=" . urlencode("You've reached your subscription limit"));
				exit;
			}
		}
	}

	// Get Old Account Details
	$goad = $conn->prepare("SELECT account_name
							FROM account
							WHERE a_id = :a_id
							AND is_deleted != '1'");
	$goad->execute([':a_id' => $a_id]);
	$account = $goad->fetch(PDO::FETCH_ASSOC);
	$goad = null;
	$oldAccountName = $account['account_name'] ?? null;

	$keyword = 'Old Account Name: <b>' . htmlspecialchars($oldAccountName ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />';

	//  Update Account Data
	$uad = $conn->prepare("UPDATE account 
							SET account_name = :account_name
							WHERE a_id = :a_id");
	$uad->bindParam(':account_name', $editAccountName, PDO::PARAM_STR);
	$uad->bindParam(':a_id', $a_id, PDO::PARAM_INT);
	$uad->execute();

	$keyword .= 'New Account Name: <b>' . htmlspecialchars($editAccountName ?? '', ENT_QUOTES, 'UTF-8') . '</b>';

	$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'Account', 'Edit', :description, :action_by, :log_action_date)");
	$log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$log->bindParam(':description', $keyword, PDO::PARAM_STR);
	$log->bindParam(':action_by', $userId, PDO::PARAM_INT);
	$log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
	$log->execute();

	header("Location: " . WEB_ROOT . "account/?promptStatus=success&promptMessage=" . urlencode("Account edited successfully."));
	exit;
}

/*
	Delete Data
*/
function delete_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? 0;
	$tenantId = $_SESSION['t_id'] ?? 0;

	header('Content-Type: application/json');

	$input = json_decode(file_get_contents("php://input"), true);
	$a_id = trim($input['a_id'] ?? '');

	if (!$a_id) {
		echo json_encode(['status' => false, 'message' => 'Invalid ID']);
		exit;
	}

	// Get Account Details
	$gud = $conn->prepare("SELECT account_name
							FROM account
							WHERE a_id = :a_id
							AND is_deleted != '1'");
	$gud->execute([':a_id' => $a_id]);
	$account = $gud->fetch(PDO::FETCH_ASSOC);
	$gud = null;

	$accountName = $account['account_name'] ?? null;

	try {
		//  Update Account Data
		$uad = $conn->prepare("UPDATE account 
								SET date_deleted = :date_deleted, deleted_by = :deleted_by, is_deleted = '1'
								WHERE a_id = :a_id");
		$uad->bindParam(':date_deleted', $today_date1, PDO::PARAM_STR);
		$uad->bindParam(':deleted_by', $userId, PDO::PARAM_INT);
		$uad->bindParam(':a_id', $a_id, PDO::PARAM_INT);
		$uad->execute();

		$keyword = 'Account Name: <b>' . htmlspecialchars($accountName ?? '', ENT_QUOTES, 'UTF-8') . '</b>';

		$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'Account', 'Delete', :description, :action_by, :log_action_date)");
		$log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
		$log->bindParam(':description', $keyword, PDO::PARAM_STR);
		$log->bindParam(':action_by', $userId, PDO::PARAM_INT);
		$log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
		$log->execute();

		echo json_encode(['status' => true]);

	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}

	exit;
}

?>