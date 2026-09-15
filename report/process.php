<?php
require_once __DIR__ . '/../global-library/database.php';
require_once __DIR__ . '/../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
	case 'filter_options':
		filter_options_data();
		break;

	case 'fetch_report_summary':
		fetch_report_summary_data();
		break;

	case 'fetch_account_breakdown':
		fetch_account_breakdown_data();
		break;

	case 'fetch_category_breakdown':
		fetch_category_breakdown_data();
		break;

	case 'fetch_audit_transactions':
		fetch_audit_transactions_data();
		break;

	case 'export_csv':
		export_csv_data();
		break;

	default:
		header('Content-Type: application/json');
		echo json_encode(['status' => false, 'message' => 'Invalid action']);
		exit;
}

/**
 * Fetch Filter Options (Accounts, Categories)
 */
function filter_options_data()
{
	global $conn;
	$tenantId = $_SESSION['t_id'] ?? 0;

	header('Content-Type: application/json');

	try {
		// Fetch Accounts
		$stmtAcc = $conn->prepare("SELECT a_id, account_name FROM account WHERE t_id = :t_id AND is_deleted != '1' ORDER BY account_name ASC");
		$stmtAcc->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
		$stmtAcc->execute();
		$accounts = $stmtAcc->fetchAll(PDO::FETCH_ASSOC);

		// Fetch Categories
		$stmtCat = $conn->prepare("SELECT c_id, category_name FROM category WHERE t_id = :t_id AND is_deleted != '1' ORDER BY category_name ASC");
		$stmtCat->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
		$stmtCat->execute();
		$categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode([
			'status' => true,
			'accounts' => $accounts,
			'categories' => $categories
		]);
	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}
}

/**
 * Build SQL Where conditions based on GET parameters with exact date slicing
 */
function build_report_filters(&$params)
{
	$tenantId = $_SESSION['t_id'] ?? 0;
	$whereClauses = ["t.t_id = :t_id", "t.is_deleted != '1'"];
	$params[':t_id'] = $tenantId;

	$startDate = trim($_GET['start_date'] ?? '');
	$endDate = trim($_GET['end_date'] ?? '');
	$accountId = trim($_GET['a_id'] ?? 'all');
	$categoryId = trim($_GET['c_id'] ?? 'all');
	$type = trim($_GET['type'] ?? 'all');

	// Exact Date Comparison using 10-char YYYY-MM-DD slicing to prevent any datetime mismatch
	if (!empty($startDate)) {
		$whereClauses[] = "SUBSTRING(t.tt_date, 1, 10) >= :start_date";
		$params[':start_date'] = $startDate;
	}

	if (!empty($endDate)) {
		$whereClauses[] = "SUBSTRING(t.tt_date, 1, 10) <= :end_date";
		$params[':end_date'] = $endDate;
	}

	if ($accountId !== 'all' && !empty($accountId)) {
		$whereClauses[] = "t.a_id = :a_id";
		$params[':a_id'] = $accountId;
	}

	if ($categoryId !== 'all' && !empty($categoryId)) {
		$whereClauses[] = "t.c_id = :c_id";
		$params[':c_id'] = $categoryId;
	}

	if ($type === '0') {
		$whereClauses[] = "t.type = 0";
	} elseif ($type === '1') {
		$whereClauses[] = "t.type = 1";
	} elseif ($type === 'transfer') {
		$whereClauses[] = "t.transaction_type = 1";
	}

	return implode(' AND ', $whereClauses);
}

/**
 * Fetch Overall KPI Summary for Report
 */
function fetch_report_summary_data()
{
	global $conn;
	header('Content-Type: application/json');

	try {
		$params = [];
		$whereSql = build_report_filters($params);

		$sql = "SELECT 
					COUNT(t.tt_id) AS total_count,
					COALESCE(SUM(CASE WHEN t.type = 0 THEN t.amount ELSE 0 END), 0) AS total_inflow,
					COALESCE(SUM(CASE WHEN t.type = 1 THEN t.amount ELSE 0 END), 0) AS total_outflow,
					COALESCE(SUM(CASE WHEN t.transaction_type = 1 THEN t.amount ELSE 0 END), 0) AS total_transfers,
					COALESCE(AVG(t.amount), 0) AS avg_amount
				FROM transaction t
				WHERE $whereSql";

		$stmt = $conn->prepare($sql);
		foreach ($params as $k => $v) {
			$stmt->bindValue($k, $v, is_numeric($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
		}
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$totalInflow = (float)($row['total_inflow'] ?? 0);
		$totalOutflow = (float)($row['total_outflow'] ?? 0);
		$netCashflow = $totalInflow - $totalOutflow;
		$totalCount = (int)($row['total_count'] ?? 0);
		$avgAmount = (float)($row['avg_amount'] ?? 0);
		$totalTransfers = (float)($row['total_transfers'] ?? 0);

		// Calculate savings / retention rate %
		$savingsRate = $totalInflow > 0 ? round(($netCashflow / $totalInflow) * 100, 1) : 0;

		echo json_encode([
			'status' => true,
			'data' => [
				'total_inflow' => $totalInflow,
				'total_outflow' => $totalOutflow,
				'net_cashflow' => $netCashflow,
				'total_count' => $totalCount,
				'avg_amount' => $avgAmount,
				'total_transfers' => $totalTransfers,
				'savings_rate' => $savingsRate,
				'formatted_inflow' => '₱' . number_format($totalInflow, 2),
				'formatted_outflow' => '₱' . number_format($totalOutflow, 2),
				'formatted_net' => ($netCashflow >= 0 ? '+₱' : '-₱') . number_format(abs($netCashflow), 2),
				'formatted_avg' => '₱' . number_format($avgAmount, 2),
				'formatted_transfers' => '₱' . number_format($totalTransfers, 2)
			]
		]);
	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}
}

/**
 * Fetch Multi-Account Audit Breakdown (Cards)
 * Provides both current live balance and period debits/credits
 */
function fetch_account_breakdown_data()
{
	global $conn;
	header('Content-Type: application/json');

	try {
		$tenantId = $_SESSION['t_id'] ?? 0;
		$startDate = trim($_GET['start_date'] ?? '');
		$endDate = trim($_GET['end_date'] ?? '');

		// 1. Get all tenant accounts with live total balance (matching dashboard formula)
		$sqlAccounts = "SELECT 
							a.a_id, 
							a.account_name, 
							COALESCE(a.card_theme, 'default') AS card_theme,
							COUNT(DISTINCT sa.sa_id) AS sub_account_count,
							COALESCE((
								SELECT SUM(
									CASE 
										WHEN t2.type = 0 THEN t2.amount 
										WHEN t2.type = 1 THEN -t2.amount 
										ELSE 0 
									END
								)
								FROM sub_account sa2
								LEFT JOIN transaction t2 ON sa2.sa_id = t2.sa_id AND t2.is_deleted != '1'
								WHERE sa2.a_id = a.a_id AND sa2.is_deleted != '1'
							), 0) AS current_balance
						FROM account a
						LEFT JOIN sub_account sa ON a.a_id = sa.a_id AND sa.is_deleted != '1'
						WHERE a.t_id = :t_id AND a.is_deleted != '1'
						GROUP BY a.a_id, a.account_name, a.card_theme
						ORDER BY a.account_name ASC";
		$stmtAcc = $conn->prepare($sqlAccounts);
		$stmtAcc->bindValue(':t_id', $tenantId, PDO::PARAM_INT);
		$stmtAcc->execute();
		$accounts = $stmtAcc->fetchAll(PDO::FETCH_ASSOC);

		// 2. Get transaction stats per account within filtered date range
		$dateFilter = "";
		$params = [':t_id' => $tenantId];
		if (!empty($startDate)) {
			$dateFilter .= " AND SUBSTRING(t.tt_date, 1, 10) >= :start_date";
			$params[':start_date'] = $startDate;
		}
		if (!empty($endDate)) {
			$dateFilter .= " AND SUBSTRING(t.tt_date, 1, 10) <= :end_date";
			$params[':end_date'] = $endDate;
		}

		$sqlTx = "SELECT 
					t.a_id,
					COUNT(t.tt_id) AS tx_count,
					COALESCE(SUM(CASE WHEN t.type = 0 THEN t.amount ELSE 0 END), 0) AS inflow,
					COALESCE(SUM(CASE WHEN t.type = 1 THEN t.amount ELSE 0 END), 0) AS outflow
				  FROM transaction t
				  WHERE t.t_id = :t_id AND t.is_deleted != '1' $dateFilter
				  GROUP BY t.a_id";
		$stmtTx = $conn->prepare($sqlTx);
		foreach ($params as $k => $v) {
			$stmtTx->bindValue($k, $v, is_numeric($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
		}
		$stmtTx->execute();
		$txRows = $stmtTx->fetchAll(PDO::FETCH_ASSOC);

		$statsByAccount = [];
		$totalVolumeAll = 0;
		foreach ($txRows as $tx) {
			$aid = $tx['a_id'];
			$vol = (float)$tx['inflow'] + (float)$tx['outflow'];
			$totalVolumeAll += $vol;
			$statsByAccount[$aid] = [
				'tx_count' => (int)$tx['tx_count'],
				'inflow' => (float)$tx['inflow'],
				'outflow' => (float)$tx['outflow'],
				'net' => (float)$tx['inflow'] - (float)$tx['outflow'],
				'volume' => $vol
			];
		}

		$accountBreakdown = [];
		foreach ($accounts as $acc) {
			$aid = $acc['a_id'];
			$stats = $statsByAccount[$aid] ?? [
				'tx_count' => 0,
				'inflow' => 0.0,
				'outflow' => 0.0,
				'net' => 0.0,
				'volume' => 0.0
			];

			$utilization = $totalVolumeAll > 0 ? round(($stats['volume'] / $totalVolumeAll) * 100, 1) : 0;
			$currBal = (float)$acc['current_balance'];

			$accountBreakdown[] = [
				'a_id' => $aid,
				'account_name' => $acc['account_name'],
				'card_theme' => $acc['card_theme'],
				'sub_account_count' => (int)$acc['sub_account_count'],
				'current_balance' => $currBal,
				'formatted_balance' => ($currBal >= 0 ? '₱' : '-₱') . number_format(abs($currBal), 2),
				'tx_count' => $stats['tx_count'],
				'inflow' => $stats['inflow'],
				'outflow' => $stats['outflow'],
				'net' => $stats['net'],
				'volume' => $stats['volume'],
				'utilization_percent' => $utilization,
				'formatted_inflow' => '₱' . number_format($stats['inflow'], 2),
				'formatted_outflow' => '₱' . number_format($stats['outflow'], 2),
				'formatted_net' => ($stats['net'] >= 0 ? '+₱' : '-₱') . number_format(abs($stats['net']), 2)
			];
		}

		echo json_encode([
			'status' => true,
			'data' => $accountBreakdown,
			'total_volume' => $totalVolumeAll
		]);
	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}
}

/**
 * Fetch Category Breakdown for Donut Chart & List
 * Excludes internal transfers (transaction_type = 0) so spending categories are 100% accurate
 */
function fetch_category_breakdown_data()
{
	global $conn;
	header('Content-Type: application/json');

	try {
		$params = [];
		$whereSql = build_report_filters($params);

		// Category Outflow breakdown (Expenses only, transaction_type = 0)
		$sql = "SELECT 
					COALESCE(c.category_name, 'Uncategorized') AS category_name,
					COUNT(t.tt_id) AS tx_count,
					COALESCE(SUM(t.amount), 0) AS total_amount
				FROM transaction t
				LEFT JOIN category c ON t.c_id = c.c_id
				WHERE $whereSql AND t.type = 1 AND t.transaction_type = 0
				GROUP BY c.c_id, c.category_name
				ORDER BY total_amount DESC";

		$stmt = $conn->prepare($sql);
		foreach ($params as $k => $v) {
			$stmt->bindValue($k, $v, is_numeric($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
		}
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$totalExpense = 0;
		foreach ($rows as $r) {
			$totalExpense += (float)$r['total_amount'];
		}

		$categoryList = [];
		$labels = [];
		$values = [];

		$colors = [
			'#2D4CC8', '#00c853', '#dc3545', '#f59e0b', '#8b5cf6', 
			'#06b6d4', '#ec4899', '#3b82f6', '#10b981', '#6366f1'
		];

		foreach ($rows as $idx => $r) {
			$amt = (float)$r['total_amount'];
			$pct = $totalExpense > 0 ? round(($amt / $totalExpense) * 100, 1) : 0;
			$color = $colors[$idx % count($colors)];

			$labels[] = $r['category_name'];
			$values[] = $amt;

			$categoryList[] = [
				'category_name' => $r['category_name'],
				'tx_count' => (int)$r['tx_count'],
				'total_amount' => $amt,
				'percentage' => $pct,
				'formatted_amount' => '₱' . number_format($amt, 2),
				'color' => $color
			];
		}

		echo json_encode([
			'status' => true,
			'total_expense' => $totalExpense,
			'formatted_total' => '₱' . number_format($totalExpense, 2),
			'chart' => [
				'labels' => $labels,
				'values' => $values,
				'colors' => array_slice($colors, 0, count($labels))
			],
			'categories' => $categoryList
		]);
	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}
}

/**
 * Fetch Paginated / Filtered Audit Transactions
 */
function fetch_audit_transactions_data()
{
	global $conn;
	header('Content-Type: application/json');

	try {
		$params = [];
		$whereSql = build_report_filters($params);

		$sql = "SELECT 
					t.tt_id,
					t.tt_date,
					t.transaction_type,
					t.type,
					t.amount,
					t.description,
					t.remarks,
					COALESCE(c.category_name, CASE WHEN t.transaction_type = 1 THEN 'Transfer' ELSE 'None' END) AS category_name,
					COALESCE(a.account_name, 'Unknown Account') AS account_name,
					COALESCE(sa.sub_account_name, 'General') AS sub_account_name
				FROM transaction t
				LEFT JOIN category c ON t.c_id = c.c_id
				LEFT JOIN account a ON t.a_id = a.a_id
				LEFT JOIN sub_account sa ON t.sa_id = sa.sa_id
				WHERE $whereSql
				ORDER BY SUBSTRING(t.tt_date, 1, 10) DESC, t.tt_id DESC
				LIMIT 1000";

		$stmt = $conn->prepare($sql);
		foreach ($params as $k => $v) {
			$stmt->bindValue($k, $v, is_numeric($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
		}
		$stmt->execute();
		$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$formatted = [];
		foreach ($transactions as $t) {
			$amt = (float)$t['amount'];
			$isDebit = ((int)$t['type'] === 0);
			$isTransfer = ((int)$t['transaction_type'] === 1);

			$rawDate = $t['tt_date'] ?? '';
			$displayDate = (!empty($rawDate) && strtotime($rawDate)) ? date('M d, Y', strtotime($rawDate)) : 'N/A';

			$formatted[] = [
				'tt_id' => $t['tt_id'],
				'date' => $displayDate,
				'raw_date' => $rawDate,
				'description' => htmlspecialchars($t['description'] ?? 'No description'),
				'category' => htmlspecialchars($t['category_name']),
				'account' => htmlspecialchars($t['account_name']),
				'sub_account' => htmlspecialchars($t['sub_account_name']),
				'type' => (int)$t['type'],
				'is_debit' => $isDebit,
				'is_transfer' => $isTransfer,
				'type_label' => $isTransfer ? 'TRANSFER' : ($isDebit ? 'INFLOW (DEBIT)' : 'OUTFLOW (CREDIT)'),
				'type_badge_class' => $isTransfer ? 'badge-info' : ($isDebit ? 'badge-success' : 'badge-danger'),
				'amount' => $amt,
				'formatted_amount' => ($isDebit ? '+₱' : '-₱') . number_format($amt, 2),
				'remarks' => htmlspecialchars($t['remarks'] ?? '')
			];
		}

		echo json_encode([
			'status' => true,
			'count' => count($formatted),
			'data' => $formatted
		]);
	} catch (Exception $e) {
		echo json_encode([
			'status' => false,
			'message' => $e->getMessage()
		]);
	}
}

/**
 * Export CSV Report with strict date filters and clean column headers
 */
function export_csv_data()
{
	global $conn;
	try {
		$params = [];
		$whereSql = build_report_filters($params);

		$sql = "SELECT 
					SUBSTRING(t.tt_date, 1, 10) AS tt_date,
					a.account_name,
					COALESCE(sa.sub_account_name, 'General') AS sub_account_name,
					COALESCE(c.category_name, CASE WHEN t.transaction_type = 1 THEN 'Transfer' ELSE 'None' END) AS category_name,
					t.description,
					CASE 
						WHEN t.transaction_type = 1 THEN 'Transfer'
						WHEN t.type = 0 THEN 'Inflow (Debit)'
						ELSE 'Outflow (Credit)'
					END AS tx_type,
					t.amount,
					t.remarks
				FROM transaction t
				LEFT JOIN category c ON t.c_id = c.c_id
				LEFT JOIN account a ON t.a_id = a.a_id
				LEFT JOIN sub_account sa ON t.sa_id = sa.sa_id
				WHERE $whereSql
				ORDER BY SUBSTRING(t.tt_date, 1, 10) DESC, t.tt_id DESC";

		$stmt = $conn->prepare($sql);
		foreach ($params as $k => $v) {
			$stmt->bindValue($k, $v, is_numeric($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
		}
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$filename = "abacoos_financial_audit_" . date('Ymd_His') . ".csv";

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);

		$output = fopen('php://output', 'w');
		// Add UTF-8 BOM for Excel compatibility
		fputs($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

		// Header Row
		fputcsv($output, ['Date', 'Account', 'Sub-Account', 'Category', 'Description', 'Transaction Type', 'Amount (PHP)', 'Remarks']);

		foreach ($rows as $row) {
			fputcsv($output, [
				$row['tt_date'],
				$row['account_name'] ?? 'N/A',
				$row['sub_account_name'],
				$row['category_name'],
				$row['description'],
				$row['tx_type'],
				number_format((float)$row['amount'], 2, '.', ''),
				$row['remarks'] ?? ''
			]);
		}

		fclose($output);
		exit;
	} catch (Exception $e) {
		die("CSV Export Error: " . $e->getMessage());
	}
}
?>
