<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'categories':
		categories_data();
		break;

	case 'add_transaction':
		add_transaction_data();
		break;

	case 'fetch_transaction':
		fetch_transaction_data();
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
	Categories Data
*/
function categories_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id']; // single value

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
}

// function upload_multi_image($inputName, $uploadDir)
// {
// 	// $dateTime = date("YmdHis");

// 	$uploadedImages = [];

// 	// Ensure the input exists before processing
// 	if (!isset($_FILES[$inputName]) || empty($_FILES[$inputName]['tmp_name'][0])) {
// 		return $uploadedImages;
// 	}

// 	$images = $_FILES[$inputName];

// 	foreach ($images['tmp_name'] as $index => $tmpName) {
// 		if (!empty($tmpName)) {
// 			$originalName = $images['name'][$index];
// 			$ext = pathinfo($images['name'][$index], PATHINFO_EXTENSION);
// 			$newFileName = md5(uniqid(rand(), true)) . "_" . date("YmdHis") . ".$ext";
// 			$filePath = $uploadDir . $newFileName;

// 			if (move_uploaded_file($tmpName, $filePath)) {
// 				$uploadedImages[] = [
// 					'original_name' => $originalName,
// 					'image' => $newFileName,
// 					'ext' => $ext
// 				];
// 			}
// 		}
// 	}

// 	return $uploadedImages;
// }

function upload_multi_image($inputName, $uploadDir)
{
	$uploadedImages = [];
	$processes = [];
	$results = [];

	$magick = "/opt/homebrew/bin/magick"; // your confirmed path
	$maxParallel = 3; // ⚠️ adjust (2–4 is safe for most machines)

	if (!isset($_FILES[$inputName]) || empty($_FILES[$inputName]['tmp_name'][0])) {
		return $uploadedImages;
	}

	$files = $_FILES[$inputName];

	foreach ($files['tmp_name'] as $index => $tmpName) {

		if (empty($tmpName))
			continue;

		$originalName = $files['name'][$index];
		$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
		$baseName = md5(uniqid(rand(), true)) . "_" . date("YmdHis");

		// =========================
		// 🖼 IMAGE → WEBP (PARALLEL)
		// =========================
		if (in_array($ext, ['jpg', 'jpeg', 'png'])) {

			$tempPath = $uploadDir . $baseName . "." . $ext;

			if (!move_uploaded_file($tmpName, $tempPath)) {
				continue;
			}

			$webpName = $baseName . ".webp";
			$webpPath = $uploadDir . $webpName;

			$command = $magick . " "
				. escapeshellarg($tempPath)
				. " -resize 1920x1920\\> -strip -quality 80 "
				. escapeshellarg($webpPath);

			// Start process (non-blocking)
			$descriptorspec = [
				1 => ["pipe", "w"], // stdout
				2 => ["pipe", "w"]  // stderr
			];

			$process = proc_open($command, $descriptorspec, $pipes);

			if (is_resource($process)) {
				$processes[] = [
					'process' => $process,
					'pipes' => $pipes,
					'temp' => $tempPath,
					'webp' => $webpName,
					'webpPath' => $webpPath,
					'original' => $originalName,
					'ext' => $ext
				];
			}

			// 🚦 LIMIT parallel jobs
			while (count($processes) >= $maxParallel) {
				usleep(100000); // 0.1s
				$processes = checkProcesses($processes, $uploadedImages);
			}

		} else {
			// =========================
			// 📎 OTHER FILES NORMAL
			// =========================
			$newFileName = $baseName . "." . $ext;
			$filePath = $uploadDir . $newFileName;

			if (move_uploaded_file($tmpName, $filePath)) {
				$uploadedImages[] = [
					'original_name' => $originalName,
					'image' => $newFileName,
					'ext' => $ext
				];
			}
		}
	}

	// ✅ Wait for remaining processes
	while (count($processes) > 0) {
		usleep(100000);
		$processes = checkProcesses($processes, $uploadedImages);
	}

	return $uploadedImages;
}

function checkProcesses($processes, &$uploadedImages)
{
	$active = [];

	foreach ($processes as $p) {

		$status = proc_get_status($p['process']);

		if ($status['running']) {
			$active[] = $p;
		} else {

			$stdout = stream_get_contents($p['pipes'][1]);
			$stderr = stream_get_contents($p['pipes'][2]);

			fclose($p['pipes'][1]);
			fclose($p['pipes'][2]);
			proc_close($p['process']);

			if (file_exists($p['webpPath'])) {
				unlink($p['temp']); // delete original

				$uploadedImages[] = [
					'original_name' => $p['original'],
					'image' => $p['webp'],
					'ext' => 'webp'
				];
			} else {
				// fallback
				$uploadedImages[] = [
					'original_name' => $p['original'],
					'image' => basename($p['temp']),
					'ext' => $p['ext']
				];

				error_log("Conversion failed: " . $stderr);
			}
		}
	}

	return $active;
}

/*
	Add Transaction
*/
function add_transaction_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id'];

	$ttType = $_POST['ttType'] ?? 0;
	$aId = $_POST['aId'] ?? 0;
	$saId = $_POST['saId'] ?? 0;

	$uploadedFiles = upload_multi_image('transactionAttachment', SRV_ROOT . 'assets/img/upload/');

	// Get Account and Sub-Account name
	$gasan = $conn->prepare("SELECT sa.sub_account_name, a.account_name
							FROM sub_account sa
							JOIN account a ON sa.a_id = a.a_id
							WHERE sa.sa_id = :sa_id AND sa.a_id = :a_id LIMIT 1");
	$gasan->execute([
		':sa_id' => $saId,
		':a_id' => $aId
	]);
	$gasan_data = $gasan->fetch(PDO::FETCH_ASSOC);
	$gasan = null;

	if ($ttType == 0) {
		$ttTypeLabel = 'Transaction';
		$transactionDate = date("Y-m-d", strtotime($_POST['transactionDate']));
		$transactionCategory = $_POST['transactionCategory'] ?? 0;
		$transactionDescription = trim($_POST['transactionDescription'] ?? null);
		$transactionAmount = str_replace(',', '', $_POST['transactionAmount'] ?? 0.00);
		$transactionType = $_POST['transactionType'] ?? 0;
		$transactionTypeLabel = ($transactionType == 1) ? 'OUT (Credit)' : 'IN (Debit)';

		// Get Category Name
		$gcn = $conn->prepare("SELECT category_name FROM category WHERE c_id = :c_id");
		$gcn->execute([
			':c_id' => $transactionCategory
		]);
		$gcn_data = $gcn->fetch(PDO::FETCH_ASSOC);
		$gcn = null;

		if (!empty($gcn_data)) {
			$categoryName = $gcn_data['category_name'];
		} else {
			$categoryName = null;
		}

		// Insert Transaction Data
		$itd = $conn->prepare("INSERT INTO transaction (t_id, a_id, sa_id, tt_date, c_id, description, type, amount, date_added, added_by)
												VALUES (:t_id, :a_id, :sa_id, :tt_date, :c_id, :description, :type, :amount, :date_added, :added_by)");
		$itd->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
		$itd->bindParam(':a_id', $aId, PDO::PARAM_INT);
		$itd->bindParam(':sa_id', $saId, PDO::PARAM_INT);
		$itd->bindParam(':tt_date', $transactionDate, PDO::PARAM_STR);
		$itd->bindParam(':c_id', $transactionCategory, PDO::PARAM_INT);
		$itd->bindParam(':description', $transactionDescription, PDO::PARAM_STR);
		$itd->bindParam(':type', $transactionType, PDO::PARAM_STR);
		$itd->bindParam(':amount', $transactionAmount, PDO::PARAM_STR);
		$itd->bindParam(':date_added', $today_date1, PDO::PARAM_STR);
		$itd->bindParam(':added_by', $userId, PDO::PARAM_INT);
		$itd->execute();

		$transactionId = $conn->lastInsertId();

		foreach ($uploadedFiles as $file) {
			$originalName = $file['original_name'];
			$mainImage = $file['image'];
			$ext = $file['ext'];

			// echo "Uploaded: $mainImage <br>";
			$tImg = $conn->prepare("INSERT INTO transaction_img (t_id, tt_id, original_file_name, new_file_name, file_extension, date_added, added_by, is_deleted)
														VALUES (:t_id, :tt_id, :original_file_name, :new_file_name, :file_extension, :date_added, :added_by, '0')");
			$tImg->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
			$tImg->bindParam(':tt_id', $transactionId, PDO::PARAM_INT);
			$tImg->bindParam(':original_file_name', $originalName, PDO::PARAM_STR);
			$tImg->bindParam(':new_file_name', $mainImage, PDO::PARAM_STR);
			$tImg->bindParam(':file_extension', $ext, PDO::PARAM_STR);
			$tImg->bindParam(':date_added', $today_date1, PDO::PARAM_STR);
			$tImg->bindParam(':added_by', $userId, PDO::PARAM_INT);
			$tImg->execute();
		}

		$keyword = 'Account Name: <b>' . htmlspecialchars($gasan_data['account_name'] ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />' .
			'Sub-Account Name: <b>' . htmlspecialchars($gasan_data['sub_account_name'] ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />' .
			'Date: <b>' . date("M d, Y", strtotime($transactionDate)) . '</b> <br />' .
			'Category: <b>' . htmlspecialchars($categoryName ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />' .
			'Description: <b>' . htmlspecialchars($transactionDescription ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />' .
			'Amount: <b>' . number_format($transactionAmount, 2) . '</b> <br />' .
			'Type: <b>' . htmlspecialchars($transactionTypeLabel ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />';
	} elseif ($ttType == 1) {
		$ttTypeLabel = 'Transfer';
	}

	$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, :module, 'Add', :description, :action_by, :log_action_date)");
	$log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$log->bindParam(':module', $ttTypeLabel, PDO::PARAM_STR);
	$log->bindParam(':description', $keyword, PDO::PARAM_STR);
	$log->bindParam(':action_by', $userId, PDO::PARAM_INT);
	$log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
	$log->execute();

	header("Location: " . WEB_ROOT . "transaction/?promptStatus=success&promptMessage=" . urlencode("$ttTypeLabel added successfully."));
	exit;
}

/*
	Fetch Transaction Data
*/
function fetch_transaction_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id']; // single value

	$accountId = $_GET['a_id'] ?? null;
	$subAccountId = $_GET['sa_id'] ?? null;

	header('Content-Type: application/json');

	if (!$accountId) {
		echo json_encode(['error' => 'Account ID missing']);
		exit;
	}

	$stmt = $conn->prepare("SELECT t.tt_id, t.transaction_type, t.tt_date, t.c_id, c.category_name, t.description, t.type, t.from_account, t.to_account, t.remarks, t.amount
							FROM transaction t
							JOIN category c ON t.c_id = c.c_id
							WHERE t.t_id = :t_id AND t.a_id = :a_id AND t.sa_id = :sa_id AND t.is_deleted != '1'
							ORDER BY t.tt_date DESC");
	$stmt->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
	$stmt->bindValue(':a_id', $accountId, PDO::PARAM_INT);
	$stmt->bindValue(':sa_id', $subAccountId, PDO::PARAM_INT);
	$stmt->execute();
	$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt = null;

	echo json_encode($transactions);
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
	$itud = $conn->prepare("INSERT INTO sub_account (a_id, sub_account_name, sub_account_number, date_added, added_by)
											VALUES (:a_id, :sub_account_name, :sub_account_number, :date_added, :added_by)");
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