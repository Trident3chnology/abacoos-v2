<?php
if (!defined('WEB_ROOT')) {
	header('Location: index');
	exit;
}

if (isset($_GET['logout'])) {
	doLogout();
}

function checkUser()
{
	if (!isset($_SESSION['user_id'])) {
		header('Location: ' . WEB_ROOT . 'login');
		exit;
	}

}

function doLogin()
{
	include SRV_ROOT . 'global-library/database.php';

	$emailAddress = trim($_POST['txtEmailAddress'] ?? '');
	$password = $_POST['txtPassword'] ?? '';

	if ($emailAddress === '') {
		return [
			"field" => "email",
			"emailAddress" => null,
			"message" => "You must enter your email address"
		];
	}

	if ($password === '') {
		return [
			"field" => "password",
			"emailAddress" => $emailAddress,
			"message" => "You must enter the password"
		];
	}

	// Get User
	$stmt = $conn->prepare("SELECT t_id, user_id, first_name, password 
							FROM bs_user 
							WHERE email = :email 
							AND is_deleted != '1'
							LIMIT 1");
	$stmt->execute([':email' => $emailAddress]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if (!$user) {
		return [
			"field" => "email",
			"emailAddress" => null,
			"message" => "Invalid email address, please try again."
		];
	}

	// Verify password
	if (!password_verify($password, $user['password'])) {
		$userFirstName = $user['first_name'];

		$userAgent = $_SERVER['HTTP_USER_AGENT'];

		$device = getDeviceType($userAgent);
		$os = getOS($userAgent);
		$browser = getBrowser($userAgent);

		include 'login-attempt-email.php';

		return [
			"field" => "password",
			"emailAddress" => $emailAddress,
			"message" => "Invalid password, please try again."
		];
	}

	// Convert existing t_id string to array
	// $tId = !empty($user['t_id']) ? explode(',', $user['t_id']) : [];
	// $tId[0];

	// Login success
	$_SESSION['user_id'] = $user['user_id'];
	$_SESSION['t_id'] = $user['t_id'];

	$update = $conn->prepare("UPDATE bs_user 
								SET last_login = :last_login 
								WHERE user_id = :user_id");
	$update->execute([
		':last_login' => $today_date1,
		':user_id' => $user['user_id']
	]);

	header("Location: " . WEB_ROOT);
	exit;
}

function generateVerificationCode($length = 6)
{
	$characters = '0123456789';
	$code = '';
	for ($i = 0; $i < $length; $i++) {
		$code .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $code;
}

function doRegister()
{
	include SRV_ROOT . 'global-library/database.php';

	$firstName = trim($_POST['firstName'] ?? '');
	$lastName = trim($_POST['lastName'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$password = $_POST['password'] ?? '';
	$confirmPassword = $_POST['confirmPassword'] ?? '';

	$verifyCode = generateVerificationCode();
	$verifyCodeHash = password_hash($verifyCode, PASSWORD_DEFAULT);

	// Check Email
	$stmt = $conn->prepare("SELECT first_name, email
							FROM bs_user
							WHERE email = :email 
							AND is_deleted != '1'");
	$stmt->execute([':email' => $email]);
	$checkStmt = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt = null;

	if ($checkStmt) {
		$stmtFirstName = $checkStmt['first_name'];

		$userAgent = $_SERVER['HTTP_USER_AGENT'];

		$device = getDeviceType($userAgent);
		$os = getOS($userAgent);
		$browser = getBrowser($userAgent);

		include 'registration-attempt-alert-email.php';

		return [
			"firstName" => $firstName,
			"lastName" => $lastName,
			"email" => $email,
			"message" => "Email address already exists, try logging in.",
			"field" => "email"
		];
	}

	if ($password !== $confirmPassword) {
		return [
			"firstName" => $firstName,
			"lastName" => $lastName,
			"email" => $email,
			"message" => "Passwords do not match",
			"field" => "confirmPassword"
		];
	}

	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	// Insert User Data
	$sql = $conn->prepare("INSERT INTO bs_user (first_name, last_name, email, password, verification_code, is_completed, date_added, is_deleted)
										VALUES (:first_name, :last_name, :email, :password, :verification_code, '1', :date_added, '0')");
	$sql->bindParam(':first_name', $firstName, PDO::PARAM_STR);
	$sql->bindParam(':last_name', $lastName, PDO::PARAM_STR);
	$sql->bindParam(':email', $email, PDO::PARAM_STR);
	$sql->bindParam(':password', $hashed_password, PDO::PARAM_STR);
	$sql->bindParam(':verification_code', $verifyCodeHash, PDO::PARAM_STR);
	$sql->bindParam(':date_added', $today_date1, PDO::PARAM_STR);
	$sql->execute();

	$userId = $conn->lastInsertId();
	$uid = md5($userId);

	// Insert Tenant Data
	$itd = $conn->prepare("INSERT INTO tenant (user_id, s_id, account, sub_account, transfer, check_book, user)
										VALUES (:user_id, '1', '1', '1', '0', '0', '1')");
	$itd->bindParam(':user_id', $userId, PDO::PARAM_INT);
	$itd->execute();

	$t_id = $conn->lastInsertId();

	$update = $conn->prepare("UPDATE bs_user 
								SET t_id = :t_id, added_by = :added_by, last_login = :last_login, uid = :uid
								WHERE user_id = :user_id");
	$update->bindParam(':t_id', $t_id, PDO::PARAM_INT); // Default tenant ID
	$update->bindParam(':added_by', $userId, PDO::PARAM_STR);
	$update->bindParam(':last_login', $today_date1, PDO::PARAM_STR);
	$update->bindParam(':uid', $uid, PDO::PARAM_STR);
	$update->bindParam(':user_id', $userId, PDO::PARAM_INT);
	$update->execute();

	include 'send-verification-code-email.php';

	header("Location: " . WEB_ROOT . 'login?promptStatus=success&promptMessage=' . urlencode('Verification code sent to ' . $email . '. Please check your email to complete the registration process.'));
	exit;
}

function doCompleteRegistration()
{
	include SRV_ROOT . 'global-library/database.php';

	$uid = trim($_POST['uid'] ?? '');
	$firstName = trim($_POST['firstName'] ?? '');
	$lastName = trim($_POST['lastName'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$password = $_POST['password'] ?? '';
	$confirmPassword = $_POST['confirmPassword'] ?? '';

	$verifyCode = generateVerificationCode();
	$verifyCodeHash = password_hash($verifyCode, PASSWORD_DEFAULT);

	if ($password !== $confirmPassword) {
		return [
			"firstName" => $firstName,
			"lastName" => $lastName,
			"email" => $email,
			"message" => "Passwords do not match",
			"field" => "confirmPassword"
		];
	}

	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	// Update User Data
	$update = $conn->prepare("UPDATE bs_user 
								SET first_name = :first_name, last_name = :last_name, password = :password,
									verification_code = :verification_code, is_completed = '1', last_login = :last_login
								WHERE uid = :uid");
	$update->bindParam(':first_name', $firstName, PDO::PARAM_STR);
	$update->bindParam(':last_name', $lastName, PDO::PARAM_STR);
	$update->bindParam(':password', $hashed_password, PDO::PARAM_STR);
	$update->bindParam(':verification_code', $verifyCodeHash, PDO::PARAM_STR);
	$update->bindParam(':last_login', $today_date1, PDO::PARAM_STR);
	$update->bindParam(':uid', $uid, PDO::PARAM_STR);
	$update->execute();

	include 'send-verification-code-email.php';

	header("Location: " . WEB_ROOT . 'login?promptStatus=success&promptMessage=' . urlencode('Verification code sent to ' . $email . '. Please check your email to complete the registration process.'));
	exit;
}

/*
	Logout a user
*/
function doLogout()
{
	if (isset($_SESSION['user_id'])) {
		unset($_SESSION['user_id']);

		session_unset();
		session_destroy();

		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		}
	}

	header('Location:' . WEB_ROOT . '');
	exit;
}

function getDeviceType($userAgent)
{
	if (preg_match('/mobile/i', $userAgent)) {
		return 'Mobile';
	} elseif (preg_match('/tablet|ipad/i', $userAgent)) {
		return 'Tablet';
	} else {
		return 'Desktop';
	}
}

function getOS($userAgent)
{
	$osArray = [
		'Windows' => 'Windows NT',
		'Mac OS' => 'Macintosh',
		'iOS' => 'iPhone|iPad',
		'Android' => 'Android',
		'Linux' => 'Linux'
	];

	foreach ($osArray as $os => $value) {
		if (preg_match("/$value/i", $userAgent)) {
			return $os;
		}
	}

	return "Unknown OS";
}

function getBrowser($userAgent)
{
	$browsers = [
		'Chrome' => 'Chrome',
		'Firefox' => 'Firefox',
		'Safari' => 'Safari',
		'Edge' => 'Edg',
		'Opera' => 'Opera'
	];

	foreach ($browsers as $browser => $value) {
		if (preg_match("/$value/i", $userAgent)) {
			return $browser;
		}
	}

	return "Unknown Browser";
}
?>