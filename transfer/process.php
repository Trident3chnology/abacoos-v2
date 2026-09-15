<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {

	case 'fetch_accounts_data':
		fetch_accounts_data();
		break;

	case 'fetch_categories':
		fetch_categories_data();
		break;

	case 'process_transfer':
		process_transfer_data();
		break;

	default:
		header('Content-Type: application/json');
		echo json_encode(['status' => false, 'message' => 'Invalid action']);
		exit;
}

/*
	Fetch Accounts & Sub-Accounts List with Balances
*/
function fetch_accounts_data()
{
	include '../global-library/database.php';
	$tenantId = $_SESSION['t_id'] ?? 0;

	header('Content-Type: application/json');

	if (!$tenantId) {
		echo json_encode(['status' => false, 'message' => 'Tenant ID missing']);
		exit;
	}

	try {
		$stmt = $conn->prepare("
			SELECT 
				COALESCE(sa.sa_id, a.a_id) AS sa_id,
				COALESCE(sa.sub_account_name, 'Main') AS sub_account_name,
				COALESCE(sa.sub_account_number, '') AS sub_account_number,
				a.a_id,
				a.account_name,
				COALESCE(a.card_theme, 'default') AS card_theme,
				COALESCE(
					SUM(
						CASE 
							WHEN t.type = 0 THEN t.amount 
							WHEN t.type = 1 THEN -t.amount 
							ELSE 0 
						END
					), 0
				) AS balance
			FROM account a
			LEFT JOIN sub_account sa ON sa.a_id = a.a_id AND sa.is_deleted != '1'
			LEFT JOIN transaction t ON sa.sa_id = t.sa_id AND t.is_deleted != '1'
			WHERE a.t_id = :t_id 
			  AND a.is_deleted != '1'
			GROUP BY sa.sa_id, sa.sub_account_name, sa.sub_account_number, a.a_id, a.account_name, a.card_theme
			ORDER BY a.account_name ASC, sa.sa_id ASC
		");
		$stmt->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
		$stmt->execute();
		$subAccounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode([
			'status' => true,
			'data' => $subAccounts
		]);
	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}
	exit;
}

/*
	Fetch Categories List
*/
function fetch_categories_data()
{
	include '../global-library/database.php';
	$tenantId = $_SESSION['t_id'] ?? 0;

	header('Content-Type: application/json');

	try {
		$stmt = $conn->prepare("SELECT c_id, category_name FROM category WHERE t_id = :t_id AND is_deleted != '1' ORDER BY category_name ASC");
		$stmt->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
		$stmt->execute();
		$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode([
			'status' => true,
			'data' => $categories
		]);
	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}
	exit;
}

/*
	Process Inter-Account Transfer
*/
function process_transfer_data()
{
	global $conn, $today_date1;
	if (empty($today_date1)) {
		$today_date1 = date("Y-m-d H:i:s");
	}

	$userId = $_SESSION['user_id'] ?? 0;
	$tenantId = $_SESSION['t_id'] ?? 0;

	header('Content-Type: application/json');

	$fromSaId = (int)($_POST['fromAccount'] ?? 0);
	$toSaId = (int)($_POST['toAccount'] ?? 0);
	$rawAmount = trim($_POST['transferAmount'] ?? '0');
	$amount = (float)str_replace(',', '', $rawAmount);
	$cId = (int)($_POST['transferCategory'] ?? 0);
	$rawDate = trim($_POST['transferDate'] ?? '');

	// Format date safely
	if (!empty($rawDate)) {
		$transferDate = date('Y-m-d', strtotime($rawDate));
	} else {
		$transferDate = date('Y-m-d');
	}

	if (!$fromSaId || !$toSaId || $amount <= 0) {
		echo json_encode(['status' => false, 'message' => 'Please fill in valid source, target, and transfer amount.']);
		exit;
	}

	if ($fromSaId === $toSaId) {
		echo json_encode(['status' => false, 'message' => 'Source and Target sub-accounts cannot be the same.']);
		exit;
	}

	try {
		$conn->beginTransaction();

		// Fetch Source Sub-account & Account Details
		$stmtFrom = $conn->prepare("SELECT sa.sub_account_name, a.a_id, a.account_name FROM sub_account sa JOIN account a ON sa.a_id = a.a_id WHERE sa.sa_id = :sa_id LIMIT 1");
		$stmtFrom->execute([':sa_id' => $fromSaId]);
		$fromData = $stmtFrom->fetch(PDO::FETCH_ASSOC);

		// Fetch Target Sub-account & Account Details
		$stmtTo = $conn->prepare("SELECT sa.sub_account_name, a.a_id, a.account_name FROM sub_account sa JOIN account a ON sa.a_id = a.a_id WHERE sa.sa_id = :sa_id LIMIT 1");
		$stmtTo->execute([':sa_id' => $toSaId]);
		$toData = $stmtTo->fetch(PDO::FETCH_ASSOC);

		if (!$fromData || !$toData) {
			$conn->rollBack();
			echo json_encode(['status' => false, 'message' => 'Selected sub-accounts are invalid.']);
			exit;
		}

		// Verify sufficient source balance
		$stmtBal = $conn->prepare("
			SELECT COALESCE(SUM(CASE WHEN type = 0 THEN amount WHEN type = 1 THEN -amount ELSE 0 END), 0) AS balance
			FROM transaction
			WHERE sa_id = :sa_id AND is_deleted != '1'
		");
		$stmtBal->execute([':sa_id' => $fromSaId]);
		$balRow = $stmtBal->fetch(PDO::FETCH_ASSOC);
		$currentBal = (float)($balRow['balance'] ?? 0);

		if ($currentBal < $amount) {
			$conn->rollBack();
			$fmtBal = number_format($currentBal, 2);
			echo json_encode(['status' => false, 'message' => "Insufficient funds in {$fromData['account_name']} ({$fromData['sub_account_name']}). Available balance: ₱{$fmtBal}."]);
			exit;
		}

		$descOut = "Transfer OUT to " . $toData['account_name'] . " (" . $toData['sub_account_name'] . ")";
		$descIn = "Transfer IN from " . $fromData['account_name'] . " (" . $fromData['sub_account_name'] . ")";

		// Fetch valid fallback category if unselected (c_id cannot be null in database)
		if ($cId <= 0) {
			$stmtCat = $conn->prepare("SELECT c_id FROM category WHERE t_id = :t_id AND is_deleted != '1' ORDER BY c_id ASC LIMIT 1");
			$stmtCat->execute([':t_id' => $tenantId]);
			$catRow = $stmtCat->fetch(PDO::FETCH_ASSOC);
			$catId = $catRow ? (int)$catRow['c_id'] : 0;
		} else {
			$catId = $cId;
		}

		// 1. Insert OUT Transaction (Source) -> type = 1 (OUT), transaction_type = 1 (transfer)
		$stmtOut = $conn->prepare("
			INSERT INTO transaction (t_id, transaction_type, a_id, sa_id, tt_date, c_id, description, type, from_account, to_account, amount, date_added, added_by)
			VALUES (:t_id, 1, :a_id, :sa_id, :tt_date, :c_id, :description, 1, :from_account, :to_account, :amount, :date_added, :added_by)
		");
		$stmtOut->execute([
			':t_id' => $tenantId,
			':a_id' => $fromData['a_id'],
			':sa_id' => $fromSaId,
			':tt_date' => $transferDate,
			':c_id' => $catId,
			':description' => $descOut,
			':from_account' => $fromSaId,
			':to_account' => $toSaId,
			':amount' => $amount,
			':date_added' => $today_date1,
			':added_by' => $userId
		]);
		$outTtId = $conn->lastInsertId();

		// 2. Insert IN Transaction (Target) -> type = 0 (IN), transaction_type = 1 (transfer)
		$stmtIn = $conn->prepare("
			INSERT INTO transaction (t_id, transaction_type, a_id, sa_id, tt_date, c_id, description, type, from_account, to_account, amount, date_added, added_by)
			VALUES (:t_id, 1, :a_id, :sa_id, :tt_date, :c_id, :description, 0, :from_account, :to_account, :amount, :date_added, :added_by)
		");
		$stmtIn->execute([
			':t_id' => $tenantId,
			':a_id' => $toData['a_id'],
			':sa_id' => $toSaId,
			':tt_date' => $transferDate,
			':c_id' => $catId,
			':description' => $descIn,
			':from_account' => $fromSaId,
			':to_account' => $toSaId,
			':amount' => $amount,
			':date_added' => $today_date1,
			':added_by' => $userId
		]);

		// 3. Handle Receipt Uploads if provided
		if (isset($_FILES['transactionAttachment']) && !empty($_FILES['transactionAttachment']['tmp_name'][0])) {
			$uploadDir = SRV_ROOT . 'assets/img/upload/';
			foreach ($_FILES['transactionAttachment']['tmp_name'] as $idx => $tmpName) {
				if (empty($tmpName)) continue;
				$origName = $_FILES['transactionAttachment']['name'][$idx];
				$ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
				$newName = md5(uniqid(rand(), true)) . "_" . date("YmdHis") . "." . $ext;
				if (move_uploaded_file($tmpName, $uploadDir . $newName)) {
					$stmtImg = $conn->prepare("
						INSERT INTO transaction_img (t_id, tt_id, original_file_name, new_file_name, file_extension, date_added, added_by, is_deleted)
						VALUES (:t_id, :tt_id, :original_file_name, :new_file_name, :file_extension, :date_added, :added_by, '0')
					");
					$stmtImg->execute([
						':t_id' => $tenantId,
						':tt_id' => $outTtId,
						':original_file_name' => $origName,
						':new_file_name' => $newName,
						':file_extension' => $ext,
						':date_added' => $today_date1,
						':added_by' => $userId
					]);
				}
			}
		}

		// 4. Log Activity
		$formattedAmount = "₱" . number_format($amount, 2);
		$logDesc = "Transferred <b>{$formattedAmount}</b> from <b>{$fromData['account_name']} ({$fromData['sub_account_name']})</b> to <b>{$toData['account_name']} ({$toData['sub_account_name']})</b>.";
		$stmtLog = $conn->prepare("
			INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
			VALUES (:t_id, 'Transfer', 'Add', :description, :action_by, :log_action_date)
		");
		$stmtLog->execute([
			':t_id' => $tenantId,
			':description' => $logDesc,
			':action_by' => $userId,
			':log_action_date' => $today_date1
		]);

		$conn->commit();

		echo json_encode([
			'status' => true,
			'message' => "Transfer of {$formattedAmount} completed successfully."
		]);
	} catch (Exception $e) {
		$conn->rollBack();
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}
	exit;
}
?>
