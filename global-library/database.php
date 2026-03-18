<?php
ini_set('max_execution_time', 2400);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set("Asia/Manila");

// Date Variables
$today_date1 = date("Y-m-d H:i:s");
$today_date2 = date("Y-m-d");
$today_date3 = date("M d, Y");
$today_date4 = date("M d, Y | h:i a");
$today_month = date("m");
$today_year = date("Y");
$today_day = date("l");
$today_time = date("H");
$today_a = date("a");

// Database Config
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'db_abacoos_v2';

try {
    $conn = new PDO(
        "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => true, // reuse connections
        ]
    );
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Session User
$userId = $_SESSION['user_id'] ?? null;
$user_data = null;

if ($userId) {
    $stmt = $conn->prepare("SELECT *
                                    FROM bs_user 
                                    WHERE user_id = :user_id AND is_deleted != '1'
                                    LIMIT 1");

    $stmt->execute(['user_id' => $userId]);
    $user_data = $stmt->fetch();
}

// Paths
$thisFile = str_replace('\\', '/', __FILE__);

$srvRoot = str_replace('global-library/database.php', '', $thisFile);
$webRoot = '/abacoos-v2/';

if (!defined('WEB_ROOT')) {
    define('WEB_ROOT', $webRoot);
}

if (!defined('SRV_ROOT')) {
    define('SRV_ROOT', $srvRoot);
}
?>