<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'fetch_category':
		fetch_category_data();
		break;

	case 'check_add_category_name':
		check_add_category_name_data();
		break;

	case 'add_category':
		add_category_data();
		break;

	case 'check_edit_category_name':
		check_edit_category_name_data();
		break;

	case 'edit_category':
		edit_category_data();
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
	Fetch Category Data
*/
function fetch_category_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id']; // single value

	header('Content-Type: application/json');

	if (!$tenantId) {
		echo json_encode(['error' => 'Tenant ID missing']);
		exit;
	}

	$stmt = $conn->prepare("SELECT c_id, category_name
							FROM category
							WHERE t_id = :t_id AND is_deleted != '1'
							ORDER BY category_name DESC");
	$stmt->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
	$stmt->execute();
	$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt = null;

	echo json_encode($categories);
	exit;
}

/*
	Check Add Category Name Data
*/
function check_add_category_name_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? null;
	$tenantId = $_SESSION['t_id'] ?? null;

	header('Content-Type: application/json');

	$addCategoryName = $_GET['addCategoryName'] ?? '';
	$response = ['status' => false, 'message' => 'Category name looks good!'];

	if (!$tenantId || !$addCategoryName) {
		echo json_encode($response);
		exit;
	}

	$stmt = $conn->prepare("SELECT
								SUM(CASE 
									WHEN category_name = :category_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS category_name_exists
							FROM category
							WHERE t_id = :t_id AND is_deleted != '1'");
	$stmt->execute([
		':category_name' => $addCategoryName,
		':t_id' => $tenantId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($data['category_name_exists'] > 0) {
			$response['status'] = true;
			$response['message'] = 'Category name already exists.';
		}
	}

	echo json_encode($response);
	exit;
}

/*
	Add Category Data
*/
function add_category_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id'];

	$addCategoryName = trim($_POST['addCategoryName'] ?? '');

	$stmt = $conn->prepare("SELECT
								SUM(CASE 
									WHEN category_name = :category_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS category_name_exists
							FROM category
							WHERE t_id = :t_id AND is_deleted != '1'");
	$stmt->execute([
		':category_name' => $addCategoryName,
		':t_id' => $tenantId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($data['category_name_exists'] > 0) {
			header("Location: " . WEB_ROOT . "category/?promptStatus=error&promptMessage=" . urlencode("Category name already exists."));
			exit;
		}
	}

	// Insert Category Data
	$itud = $conn->prepare("INSERT INTO category (t_id, category_name, date_added, added_by)
										VALUES (:t_id, :category_name, :date_added, :added_by)");
	$itud->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$itud->bindParam(':category_name', $addCategoryName, PDO::PARAM_STR);
	$itud->bindParam(':date_added', $today_date1, PDO::PARAM_STR);
	$itud->bindParam(':added_by', $userId, PDO::PARAM_INT);
	$itud->execute();

	$keyword = 'Category Name: <b>' . htmlspecialchars($addCategoryName ?? '', ENT_QUOTES, 'UTF-8') . '</b>';

	$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'Category', 'Add', :description, :action_by, :log_action_date)");
	$log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$log->bindParam(':description', $keyword, PDO::PARAM_STR);
	$log->bindParam(':action_by', $userId, PDO::PARAM_INT);
	$log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
	$log->execute();

	header("Location: " . WEB_ROOT . "category/?promptStatus=success&promptMessage=" . urlencode("Category added successfully."));
	exit;
}

/*
	Check Edit Category Name Data
*/
function check_edit_category_name_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? null;
	$tenantId = $_SESSION['t_id'] ?? null;

	header('Content-Type: application/json');

	$editCategoryName = $_GET['editCategoryName'] ?? '';
	$cId = $_GET['cId'] ?? '';
	$response = ['status' => false, 'message' => 'Category name looks good!'];

	if (!$tenantId || !$editCategoryName || !$cId) {
		echo json_encode($response);
		exit;
	}

	$stmt = $conn->prepare("SELECT 
								SUM(CASE 
									WHEN category_name = :category_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS category_name_exists
							FROM category
							WHERE t_id = :t_id AND c_id != :c_id AND is_deleted != '1'");
	$stmt->execute([
		':category_name' => $editCategoryName,
		':t_id' => $tenantId,
		':c_id' => $cId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($data['category_name_exists'] > 0) {
			$response['status'] = true;
			$response['message'] = 'Category name already exists.';
		}
	}

	echo json_encode($response);
	exit;
}

/*
	Edit Category Data
*/
function edit_category_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? 0;
	$tenantId = $_SESSION['t_id'] ?? 0;

	$editCategoryName = trim($_POST['editCategoryName'] ?? '');
	$c_id = ($_POST['c_id'] ?? '');

	$stmt = $conn->prepare("SELECT 
								SUM(CASE 
									WHEN category_name = :category_name AND is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS category_name_exists
							FROM category
							WHERE t_id = :t_id AND c_id != :c_id AND is_deleted != '1'");
	$stmt->execute([
		':category_name' => $editCategoryName,
		':t_id' => $tenantId,
		':c_id' => $cId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($data['category_name_exists'] > 0) {
			header("Location: " . WEB_ROOT . "category/?promptStatus=error&promptMessage=" . urlencode("Category name already exists."));
			exit;
		}
	}

	// Get Old Category Details
	$gocd = $conn->prepare("SELECT category_name
							FROM category
							WHERE c_id = :c_id
							AND is_deleted != '1'");
	$gocd->execute([':c_id' => $c_id]);
	$category = $gocd->fetch(PDO::FETCH_ASSOC);
	$gocd = null;
	$oldCategoryName = $category['category_name'] ?? null;

	$keyword = 'Old Category Name: <b>' . htmlspecialchars($oldCategoryName ?? '', ENT_QUOTES, 'UTF-8') . '</b> <br />';

	//  Update Category Data
	$ucd = $conn->prepare("UPDATE category 
							SET category_name = :category_name
							WHERE c_id = :c_id");
	$ucd->bindParam(':category_name', $editCategoryName, PDO::PARAM_STR);
	$ucd->bindParam(':c_id', $c_id, PDO::PARAM_INT);
	$ucd->execute();

	$keyword .= 'New Category Name: <b>' . htmlspecialchars($editCategoryName ?? '', ENT_QUOTES, 'UTF-8') . '</b>';

	$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'Category', 'Edit', :description, :action_by, :log_action_date)");
	$log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$log->bindParam(':description', $keyword, PDO::PARAM_STR);
	$log->bindParam(':action_by', $userId, PDO::PARAM_INT);
	$log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
	$log->execute();

	header("Location: " . WEB_ROOT . "category/?promptStatus=success&promptMessage=" . urlencode("Category edited successfully."));
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
	$c_id = trim($input['c_id'] ?? '');

	if (!$c_id) {
		echo json_encode(['status' => false, 'message' => 'Invalid ID']);
		exit;
	}

	// Get Category Details
	$gud = $conn->prepare("SELECT category_name
							FROM category
							WHERE c_id = :c_id
							AND is_deleted != '1'");
	$gud->execute([':c_id' => $c_id]);
	$category = $gud->fetch(PDO::FETCH_ASSOC);
	$gud = null;

	$categoryName = $category['category_name'] ?? null;

	try {
		//  Update Category Data
		$ucd = $conn->prepare("UPDATE category 
								SET date_deleted = :date_deleted, deleted_by = :deleted_by, is_deleted = '1'
								WHERE c_id = :c_id");
		$ucd->bindParam(':date_deleted', $today_date1, PDO::PARAM_STR);
		$ucd->bindParam(':deleted_by', $userId, PDO::PARAM_INT);
		$ucd->bindParam(':c_id', $c_id, PDO::PARAM_INT);
		$ucd->execute();

		$keyword = 'Category Name: <b>' . htmlspecialchars($categoryName ?? '', ENT_QUOTES, 'UTF-8') . '</b>';

		$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'Category', 'Delete', :description, :action_by, :log_action_date)");
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