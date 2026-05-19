<?php
require_once '../global-library/database.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'verify':
		verify_data();
		break;

	default:
		// if action is not defined or unknown
		// move to main category page
		header('Location: index.php');
}

function verify_data()
{
	include '../global-library/database.php';

	header('Content-Type: application/json');

	// Decode JSON input
	$input = json_decode(file_get_contents('php://input'), true);

	$userId = $_SESSION['user_id'] ?? null;
	$tenantId = $_SESSION['t_id'] ?? null;
	$email = trim($input['email'] ?? '');
	$pin = trim($input['pin'] ?? '');

	if (!$userId || !$email || !$pin) {
		http_response_code(400);
		echo json_encode([
			'status' => 'error',
			'message' => 'Missing required data.'
		]);
		exit;
	}

	// ✅ Use exact match for email (LIKE with %...% is unsafe for email lookups)
	$gev = $conn->prepare("SELECT verification_code FROM bs_user WHERE user_id = :user_id AND email = :email AND is_deleted != '1'");
	$gev->bindParam(':user_id', $userId, PDO::PARAM_INT);
	$gev->bindParam(':email', $email, PDO::PARAM_STR);
	$gev->execute();
	$gev_data = $gev->fetch(PDO::FETCH_ASSOC);

	if (!$gev_data) {
		http_response_code(404);
		echo json_encode([
			'status' => 'error',
			'message' => 'No verification record found.'
		]);
		exit;
	}

	$hashedCode = $gev_data['verification_code'];

	// ✅ Verify hashed PIN (stored with password_hash)
	if (password_verify($pin, $hashedCode)) {
		// ✅ Update verification status safely
		$sql = $conn->prepare("UPDATE bs_user SET is_verified = '1' WHERE user_id = :user_id AND email = :email AND is_deleted != 1");
		$sql->bindParam(':user_id', $userId, PDO::PARAM_INT);
		$sql->bindParam(':email', $email, PDO::PARAM_STR);
		$sql->execute();

		// Get Tenant Subscription
		$gts = $conn->prepare("SELECT s.s_type
								FROM tenant t
								JOIN subscription s ON t.s_id = s.s_id
								WHERE t.t_id = :tenantId");
		$gts->bindParam(':tenantId', $tenantId, PDO::PARAM_INT);
		$gts->execute();
		$gts_data = $gts->fetch(PDO::FETCH_ASSOC);

		// $subscription = ($gts_data) ? $gts_data['s_type'] : 'No active subscription';

		// $keyword = 'Email: ' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . ' <br />Subscription: ' . htmlspecialchars($subscription, ENT_QUOTES, 'UTF-8');

		// $log = $conn->prepare("INSERT INTO activity_log (t_id, module, action, description, action_by, log_action_date)
		// 										VALUES (:t_id, 'Tenant', 'Tenant Email Verified', :description, :action_by, :log_action_date)");
		// $log->bindParam(':t_id', $tenantId, PDO::PARAM_INT);
		// $log->bindParam(':description', $keyword, PDO::PARAM_STR);
		// $log->bindParam(':action_by', $userId, PDO::PARAM_INT);
		// $log->bindParam(':log_action_date', $today_date1, PDO::PARAM_STR);
		// $log->execute();

		echo json_encode([
			'status' => 'success',
			'message' => 'Verification successful!'
		]);

	} else {
		echo json_encode([
			'status' => 'error',
			'message' => 'Invalid verification code.'
		]);
	}
}
?>