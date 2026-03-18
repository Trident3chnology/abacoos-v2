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
	$stmt = $conn->prepare("SELECT user_id, password 
							FROM bs_user 
							WHERE email = :email 
							AND is_deleted != '1'
							LIMIT 1");
	$stmt->execute([':email' => $emailAddress]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$user) {
		return [
			"field" => "email",
			"emailAddress" => null,
			"message" => "Invalid email address, please try again."
		];
	}

	// Verify password
	if (!password_verify($password, $user['password'])) {
		return [
			"field" => "password",
			"emailAddress" => $emailAddress,
			"message" => "Invalid password, please try again."
		];
	}

	// Login success
	$_SESSION['user_id'] = $user['user_id'];

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
?>