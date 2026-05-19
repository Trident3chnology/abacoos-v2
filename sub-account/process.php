<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'fetch_sub_account':
		fetch_sub_account_data();
		break;

	case 'check_add_sub_account_name':
		check_add_sub_account_name_data();
		break;

	case 'add_sub_account':
		add_sub_account_data();
		break;

	case 'check_edit_sub_account_name':
		check_edit_sub_account_name_data();
		break;

	case 'edit_sub_account':
		edit_sub_account_data();
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
	Fetch Sub-Account Data
*/
function fetch_sub_account_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id']; // single value

	$accountId = $_GET['a_id'] ?? null;

	header('Content-Type: application/json');

	if (!$accountId) {
		echo json_encode(['error' => 'Account ID missing']);
		exit;
	}

	$stmt = $conn->prepare("SELECT sa_id, sub_account_name, sub_account_number
							FROM sub_account
							WHERE a_id = :a_id AND is_deleted != '1'
							ORDER BY sub_account_name DESC");
	$stmt->bindValue(':a_id', $accountId, PDO::PARAM_INT);
	$stmt->execute();
	$subAccounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt = null;

	echo json_encode($subAccounts);
	exit;
}

/*
	Check Add Sub-Account Name Data
*/
function check_add_sub_account_name_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? null;
	$tenantId = $_SESSION['t_id'] ?? null;

	header('Content-Type: application/json');

	$addSubAccountName = $_GET['addSubAccountName'] ?? '';
	$aId = $_GET['aId'] ?? '';
	$response = ['status' => false, 'message' => 'Sub-account name looks good!'];

	if (!$tenantId || !$addSubAccountName) {
		echo json_encode($response);
		exit;
	}

	// Get Tenant Sub-Account Limits
	$gtal = $conn->prepare("SELECT sub_account FROM tenant WHERE t_id = :t_id LIMIT 1");
	$gtal->execute([':t_id' => $tenantId]);
	$tenantData = $gtal->fetch(PDO::FETCH_ASSOC);
	$gtal = null;

	$subAccLimit = $tenantData['sub_account'] ?? '0'; // 0 means unlimited

	$stmt = $conn->prepare("SELECT 
								COUNT(DISTINCT sa_id) AS total_sub_accounts,
								SUM(CASE 
									WHEN sub_account_name = :sub_account_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS sub_account_name_exists
							FROM sub_account
							WHERE a_id = :a_id AND is_deleted != '1'");
	$stmt->execute([
		':sub_account_name' => $addSubAccountName,
		':a_id' => $aId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($subAccLimit != '0') {
			if ($data['total_sub_accounts'] < $subAccLimit) {
				if ($data['sub_account_name_exists'] > 0) {
					$response['status'] = true;
					$response['message'] = 'Sub-account name already exists.';
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
	Add Sub-Account Data
*/
function add_sub_account_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id'];

	$addSubAccountName = trim($_POST['addSubAccountName'] ?? '');
	$addSubAccountNumber = $_POST['addSubAccountNumber'] ?? '';
	$aId = $_POST['aId'] ?? '';

	// Get Tenant Sub-Account Limits
	$gtal = $conn->prepare("SELECT sub_account FROM tenant WHERE t_id = :t_id LIMIT 1");
	$gtal->execute([':t_id' => $tenantId]);
	$tenantData = $gtal->fetch(PDO::FETCH_ASSOC);
	$gtal = null;

	$subAccLimit = $tenantData['sub_account'] ?? '0'; // 0 means unlimited

	$stmt = $conn->prepare("SELECT 
								COUNT(DISTINCT sa_id) AS total_sub_accounts,
								SUM(CASE 
									WHEN sub_account_name = :sub_account_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS sub_account_name_exists
							FROM sub_account
							WHERE a_id = :a_id AND is_deleted != '1'");
	$stmt->execute([
		':sub_account_name' => $addSubAccountName,
		':a_id' => $aId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($subAccLimit != '0') {
			if ($data['total_sub_accounts'] < $subAccLimit) {
				if ($data['sub_account_name_exists'] > 0) {
					header("Location: " . WEB_ROOT . "sub-account/?promptStatus=error&promptMessage=" . urlencode("Sub-account name already exists."));
					exit;
				}
			} else {
				header("Location: " . WEB_ROOT . "sub-account/?promptStatus=error&promptMessage=" . urlencode("You've reached your subscription limit"));
				exit;
			}
		}
	}

	// Insert Sub-Account Data
	$itud = $conn->prepare("INSERT INTO sub_account (t_id, a_id, sub_account_name, sub_account_number, date_added, added_by)
											VALUES (:t_id, :a_id, :sub_account_name, :sub_account_number, :date_added, :added_by)");
	$itud->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$itud->bindParam(':a_id', $aId, PDO::PARAM_INT);
	$itud->bindParam(':sub_account_name', $addSubAccountName, PDO::PARAM_STR);
	$itud->bindParam(':sub_account_number', $addSubAccountNumber, PDO::PARAM_STR);
	$itud->bindParam(':date_added', $today_date1, PDO::PARAM_STR);
	$itud->bindParam(':added_by', $userId, PDO::PARAM_INT);
	$itud->execute();

	$keyword = 'Sub-Account Name: <b>' . htmlspecialchars($addSubAccountName ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />' .
				'Sub-Account Number: <b>' . htmlspecialchars($addSubAccountNumber ?? '', ENT_QUOTES, 'UTF-8') . '</b>';

	$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'Sub-Account', 'Add', :description, :action_by, :log_action_date)");
	$log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$log->bindParam(':description', $keyword, PDO::PARAM_STR);
	$log->bindParam(':action_by', $userId, PDO::PARAM_INT);
	$log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
	$log->execute();

	header("Location: " . WEB_ROOT . "sub-account/?promptStatus=success&promptMessage=" . urlencode("Sub-account added successfully."));
	exit;
}

/*
	Check Edit Sub-Account Name Data
*/
function check_edit_sub_account_name_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? null;
	$tenantId = $_SESSION['t_id'] ?? null;

	header('Content-Type: application/json');

	$editSubAccountName = $_GET['editSubAccountName'] ?? '';
	$saId = $_GET['saId'] ?? '';
	$aId = $_GET['aId'] ?? '';
	$response = ['status' => false, 'message' => 'Sub-account name looks good!'];

	if (!$tenantId || !$editSubAccountName || !$saId || !$aId) {
		echo json_encode($response);
		exit;
	}

	// Get Tenant Sub-Account Limits
	$gtal = $conn->prepare("SELECT sub_account FROM tenant WHERE t_id = :t_id LIMIT 1");
	$gtal->execute([':t_id' => $tenantId]);
	$tenantData = $gtal->fetch(PDO::FETCH_ASSOC);
	$gtal = null;

	$subAccLimit = $tenantData['sub_account'] ?? '0'; // 0 means unlimited

	$stmt = $conn->prepare("SELECT 
								COUNT(DISTINCT sa_id) AS total_sub_accounts,
								SUM(CASE 
									WHEN sub_account_name = :sub_account_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS sub_account_name_exists
							FROM sub_account
							WHERE sa_id != :sa_id AND a_id = :a_id AND is_deleted != '1'");
	$stmt->execute([
		':sub_account_name' => $editSubAccountName,
		':sa_id' => $saId,
		':a_id' => $aId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($subAccLimit != '0') {
			if ($data['total_sub_accounts'] < $subAccLimit) {
				if ($data['sub_account_name_exists'] > 0) {
					$response['status'] = true;
					$response['message'] = 'Sub-account name already exists.';
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
	Edit Sub-Account Data
*/
function edit_sub_account_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? 0;
	$tenantId = $_SESSION['t_id'] ?? 0;

	$editSubAccountName = trim($_POST['editSubAccountName'] ?? '');
	$editSubAccountNumber = $_POST['editSubAccountNumber'] ?? '';
	$sa_id = ($_POST['sa_id'] ?? '');
	$aId = $_GET['aId'] ?? '';

	// Get Tenant Sub-Account Limits
	$gtal = $conn->prepare("SELECT sub_account FROM tenant WHERE t_id = :t_id LIMIT 1");
	$gtal->execute([':t_id' => $tenantId]);
	$tenantData = $gtal->fetch(PDO::FETCH_ASSOC);
	$gtal = null;

	$subAccLimit = $tenantData['sub_account'] ?? '0'; // 0 means unlimited

	$stmt = $conn->prepare("SELECT 
								COUNT(DISTINCT sa_id) AS total_sub_accounts,
								SUM(CASE 
									WHEN sub_account_name = :sub_account_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS sub_account_name_exists
							FROM sub_account
							WHERE sa_id != :sa_id AND a_id = :a_id AND is_deleted != '1'");
	$stmt->execute([
		':sub_account_name' => $editSubAccountName,
		':sa_id' => $sa_id,
		':a_id' => $aId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($subAccLimit != '0') {
			if ($data['total_sub_accounts'] < $subAccLimit) {
				if ($data['sub_account_name_exists'] > 0) {
					header("Location: " . WEB_ROOT . "sub-account/?promptStatus=error&promptMessage=" . urlencode("Sub-account name already exists."));
					exit;
				}
			} else {
				header("Location: " . WEB_ROOT . "sub-account/?promptStatus=error&promptMessage=" . urlencode("You've reached your subscription limit"));
				exit;
			}
		}
	}

	// Get Old Sub-account Details
	$goad = $conn->prepare("SELECT sub_account_name, sub_account_number
							FROM sub_account
							WHERE sa_id = :sa_id
							AND is_deleted != '1'");
	$goad->execute([':sa_id' => $sa_id]);
	$account = $goad->fetch(PDO::FETCH_ASSOC);
	$goad = null;
	$oldSubAccountName = $account['sub_account_name'] ?? null;
	$oldSubAccountNumber = $account['sub_account_number'] ?? null;

	$keyword = 'Old Sub-account Name: <b>' . htmlspecialchars($oldSubAccountName ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />';
	$keyword .= 'Old Sub-account Number: <b>' . htmlspecialchars($oldSubAccountNumber ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />';

	//  Update Sub-account Data
	$uad = $conn->prepare("UPDATE sub_account 
							SET sub_account_name = :sub_account_name, sub_account_number = :sub_account_number
							WHERE sa_id = :sa_id");
	$uad->bindParam(':sub_account_name', $editSubAccountName, PDO::PARAM_STR);
	$uad->bindParam(':sub_account_number', $editSubAccountNumber, PDO::PARAM_STR);
	$uad->bindParam(':sa_id', $sa_id, PDO::PARAM_INT);
	$uad->execute();

	$keyword .= 'New Sub-account Name: <b>' . htmlspecialchars($editSubAccountName ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />';
	$keyword .= 'New Sub-account Number: <b>' . htmlspecialchars($editSubAccountNumber ?? '', ENT_QUOTES, 'UTF-8') . '</b>';

	$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'Sub-account', 'Edit', :description, :action_by, :log_action_date)");
	$log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$log->bindParam(':description', $keyword, PDO::PARAM_STR);
	$log->bindParam(':action_by', $userId, PDO::PARAM_INT);
	$log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
	$log->execute();

	header("Location: " . WEB_ROOT . "sub-account/?promptStatus=success&promptMessage=" . urlencode("Sub-account edited successfully."));
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
	$sa_id = trim($input['sa_id'] ?? '');

	if (!$sa_id) {
		echo json_encode(['status' => false, 'message' => 'Invalid ID']);
		exit;
	}

	// Get Sub-account Details
	$gud = $conn->prepare("SELECT sub_account_name, sub_account_number
							FROM sub_account
							WHERE sa_id = :sa_id
							AND is_deleted != '1'");
	$gud->execute([':sa_id' => $sa_id]);
	$account = $gud->fetch(PDO::FETCH_ASSOC);
	$gud = null;

	$subAccountName = $account['sub_account_name'] ?? null;
	$subAccountNumber = $account['sub_account_number'] ?? null;

	try {
		//  Update Sub-account Data
		$uad = $conn->prepare("UPDATE sub_account 
								SET date_deleted = :date_deleted, deleted_by = :deleted_by, is_deleted = '1'
								WHERE sa_id = :sa_id");
		$uad->bindParam(':date_deleted', $today_date1, PDO::PARAM_STR);
		$uad->bindParam(':deleted_by', $userId, PDO::PARAM_INT);
		$uad->bindParam(':sa_id', $sa_id, PDO::PARAM_INT);
		$uad->execute();

		$keyword = 'Sub-account Name: <b>' . htmlspecialchars($subAccountName ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />' .
					'Sub-account Number: <b>' . htmlspecialchars($subAccountNumber ?? '', ENT_QUOTES, 'UTF-8') . '</b>';

		$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'Sub-account', 'Delete', :description, :action_by, :log_action_date)");
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