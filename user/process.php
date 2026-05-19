<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'fetch_user':
		fetch_user_data();
		break;

	case 'check_email':
		check_email_data();
		break;

	case 'invite':
		invite_data();
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
	Fetch User Data
*/
function fetch_user_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id']; // single value

	header('Content-Type: application/json');

	if (!$tenantId) {
		echo json_encode(['error' => 'Tenant ID missing']);
		exit;
	}

	$stmt = $conn->prepare("SELECT tu.tu_id, tu.t_id, u.user_id, u.first_name, u.last_name, u.email, u.is_completed
							FROM bs_user u
							LEFT JOIN tenant_user tu ON tu.user_id = u.user_id
							WHERE tu.t_id = :t_id
							AND u.user_id != :user_id
							AND u.is_deleted != '1'
							ORDER BY u.first_name ASC");
	$stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
	$stmt->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
	$stmt->execute();
	$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt = null;

	echo json_encode($users);
	exit;
}

/*
	Check Email Data
*/
function check_email_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'] ?? null;
	$tenantId = $_SESSION['t_id'] ?? null;

	header('Content-Type: application/json');

	$email = $_GET['email'] ?? '';
	$response = ['status' => false, 'message' => 'Email looks good!'];

	if (!$tenantId || !$email) {
		echo json_encode($response);
		exit;
	}

	$stmt = $conn->prepare("SELECT 
								t.user AS max_users,
								COUNT(DISTINCT tu.user_id) AS total_users,
								SUM(CASE 
									WHEN u.email LIKE :email AND u.is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS email_exists
							FROM tenant t
							LEFT JOIN tenant_user tu ON tu.t_id = t.t_id
							LEFT JOIN bs_user u ON u.user_id = tu.user_id
							WHERE t.t_id = :t_id
							GROUP BY t.t_id
							LIMIT 1");
	$stmt->execute([
		':email' => '%' . $email . '%',
		':t_id' => $tenantId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($data['max_users'] != '0') {
			if ($data['total_users'] < $data['max_users']) {
				if ($data['email_exists'] > 0) {
					$response['status'] = true;
					$response['message'] = 'Email already invited.';
				}
			} else {
				$response['status'] = true;
				$response['message'] = "You've reached your subscription limit.";
			}
		}
	}

	echo json_encode($response);
	exit;
}

/*
	Invite Data
*/
function invite_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	$tenantId = $_SESSION['t_id'];

	$email = trim($_POST['email'] ?? '');

	$stmt = $conn->prepare("SELECT 
								t.user AS max_users,
								COUNT(DISTINCT tu.user_id) AS total_users,
								SUM(CASE 
									WHEN u.email LIKE :email AND u.is_deleted != '1' 
									THEN 1 ELSE 0 
								END) AS email_exists
							FROM tenant t
							LEFT JOIN tenant_user tu ON tu.t_id = t.t_id
							LEFT JOIN bs_user u ON u.user_id = tu.user_id
							WHERE t.t_id = :t_id
							GROUP BY t.t_id
							LIMIT 1");
	$stmt->execute([
		':email' => '%' . $email . '%',
		':t_id' => $tenantId
	]);
	$data = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($data) {
		if ($data['max_users'] != '0') {
			if ($data['total_users'] < $data['max_users']) {
				if ($data['email_exists'] > 0) {
					header("Location: " . WEB_ROOT . "user/?promptStatus=error&promptMessage=" . urlencode("Email already invited."));
					exit;
				}
			} else {
				header("Location: " . WEB_ROOT . "user/?promptStatus=error&promptMessage=" . urlencode("You've reached your subscription limit."));
				exit;
			}
		}
	}

	// Get inviter Name
	$gin = $conn->prepare("SELECT first_name
                        FROM bs_user 
                        WHERE user_id = :user_id 
                        AND is_deleted != '1'
                        LIMIT 1");
	$gin->execute([':user_id' => $userId]);
	$gin_data = $gin->fetch(PDO::FETCH_ASSOC);
	$gin = null;

	$inviter_name = $gin_data['first_name'];

	// Check Email
	$chk = $conn->prepare("SELECT user_id, t_id, first_name, last_name, email
                        FROM bs_user 
                        WHERE email = :email 
                        AND is_deleted != '1'
                        LIMIT 1");
	$chk->execute([':email' => $email]);
	$user = $chk->fetch(PDO::FETCH_ASSOC);
	$chk = null;

	$firstName = $user['first_name'] ?? '';
	$lastName = $user['last_name'] ?? '';

	$keyName = ($user['first_name'] || $user['last_name']) ? '<br /> Name: <b>' . htmlspecialchars(($firstName ?? '') . ' ' . ($lastName ?? ''), ENT_QUOTES, 'UTF-8') . '</b>' : '';

	if ($user) {
		$chkUserId = $user['user_id'];

		// Insert Tenant User Data
		$itud = $conn->prepare("INSERT INTO tenant_user (t_id, user_id)
												VALUES (:t_id, :user_id)");
		$itud->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
		$itud->bindParam(':user_id', $chkUserId, PDO::PARAM_INT);
		$itud->execute();

		$invitationUrl = "http://127.0.0.1/abacoos-v2/";
	} else {
		// Insert User Data
		$iud = $conn->prepare("INSERT INTO bs_user (t_id, email, date_added, added_by, is_deleted)
        									VALUES (:t_id, :email, :date_added, :added_by, '0')");
		$iud->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
		$iud->bindParam(':email', $email, PDO::PARAM_STR);
		$iud->bindParam(':date_added', $today_date1, PDO::PARAM_STR);
		$iud->bindParam(':added_by', $userId, PDO::PARAM_INT);
		$iud->execute();

		$user_id = $conn->lastInsertId();
		$uid = md5($user_id);

		// Insert Tenant User Data
		$itud = $conn->prepare("INSERT INTO tenant_user (t_id, user_id)
												VALUES (:t_id, :user_id)");
		$itud->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
		$itud->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$itud->execute();

		//  Update User Data
		$sql = $conn->prepare("UPDATE bs_user 
								SET uid = :uid
								WHERE user_id = :user_id");
		$sql->bindParam(':uid', $uid, PDO::PARAM_STR);
		$sql->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$sql->execute();

		$invitationUrl = "http://127.0.0.1/abacoos-v2/register?uid=" . $uid;
	}

	$keyword = 'Email: <b>' . htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') . '</b> ' . $keyName;

	$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'User', 'Add', :description, :action_by, :log_action_date)");
	$log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
	$log->bindParam(':description', $keyword, PDO::PARAM_STR);
	$log->bindParam(':action_by', $userId, PDO::PARAM_INT);
	$log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
	$log->execute();

	include 'send-invitation-email.php';

	header("Location: " . WEB_ROOT . "user/?promptStatus=success&promptMessage=" . urlencode("Invitation sent to " . $email . "."));
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
	$tu_id = trim($input['tu_id'] ?? '');

	if (!$tu_id) {
		echo json_encode(['status' => false, 'message' => 'Invalid ID']);
		exit;
	}

	// Get User Details
	$gud = $conn->prepare("SELECT u.user_id, u.first_name, u.last_name, u.email
							FROM tenant_user tu
							LEFT JOIN bs_user u ON u.user_id = tu.user_id
							WHERE tu.tu_id = :tu_id
							AND u.is_deleted != '1'");
	$gud->execute([':tu_id' => $tu_id]);
	$user = $gud->fetch(PDO::FETCH_ASSOC);
	$gud = null;

	$user_id = $user['user_id'];
	$firstName = $user['first_name'] ?? null;
	$lastName = $user['last_name'] ?? null;
	$email = $user['email'] ?? null;

	$keyName = ($user['first_name'] || $user['last_name']) ? '<br /> Name: <b>' . htmlspecialchars(($firstName ?? '') . ' ' . ($lastName ?? ''), ENT_QUOTES, 'UTF-8') . '</b>' : '';

	try {
		// Delete User Data
		$dud = $conn->prepare("DELETE FROM tenant_user WHERE tu_id = :tu_id");
		$dud->bindParam(':tu_id', $tu_id, PDO::PARAM_INT);
		$dud->execute();

		// Check if user still belongs to another tenant
		$guot = $conn->prepare("SELECT t_id
								FROM tenant_user
								WHERE user_id = :user_id LIMIT 1");
		$guot->execute([':user_id' => $user_id]);
		$guot_data = $guot->fetch(PDO::FETCH_ASSOC);
		$guot = null;

		$userTenantId = $guot_data['t_id'] ?? 0;

		//  Update User Data
		$uud = $conn->prepare("UPDATE bs_user 
								SET t_id = :t_id
								WHERE user_id = :user_id");
		$uud->bindParam(':t_id', $userTenantId, PDO::PARAM_STR);
		$uud->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$uud->execute();

		$keyword = 'Email: <b>' . htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') . '</b> ' . $keyName;

		$log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
												VALUES (:t_id, 'User', 'Delete', :description, :action_by, :log_action_date)");
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