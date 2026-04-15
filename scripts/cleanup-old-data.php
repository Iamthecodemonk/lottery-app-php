<?php
require_once __DIR__ . '/../db/Database.php';

use Database\Database;

// Simple CLI script to delete bets and results older than N days.
// Usage: php scripts/cleanup-old-data.php [--days=7] [--dry-run]

$opts = [];
$argvList = [];
if (isset($argv) && is_array($argv)) {
    $argvList = $argv;
} elseif (!empty($_SERVER['argv']) && is_array($_SERVER['argv'])) {
    $argvList = $_SERVER['argv'];
}
foreach ($argvList as $arg) {
    if (strpos($arg, '--') !== 0) continue;
    $parts = explode('=', $arg, 2);
    $key = substr($parts[0], 2);
    $val = $parts[1] ?? true;
    $opts[$key] = $val;
}

$days = isset($opts['days']) ? (int)$opts['days'] : 7;
$dryRun = isset($opts['dry-run']) || isset($opts['dryrun']) || isset($opts['dry_run']);

$cutoff = date('Y-m-d H:i:s', strtotime("-{$days} days"));
echo "Cleanup cutoff: {$cutoff} (older than {$days} days)\n";
if ($dryRun) echo "Dry run mode — no changes will be made.\n";

// Prepare stderr resource for environments where STDERR may not be defined (e.g., web)
$stderr = null;
if (defined('STDERR')) {
    $stderr = STDERR;
} else {
    $stderr = fopen('php://stderr', 'w');
}

$db = Database::getInstance()->getConnection();

try {
    // Counts
    $stmt = $db->prepare('SELECT COUNT(*) FROM bets WHERE placed_at < :cutoff');
    $stmt->execute([':cutoff' => $cutoff]);
    $betsCount = (int)$stmt->fetchColumn();

    $stmt = $db->prepare('SELECT COUNT(*) FROM bet_numbers bn JOIN bets b ON bn.bet_id = b.id WHERE b.placed_at < :cutoff');
    $stmt->execute([':cutoff' => $cutoff]);
    $betNumbersCount = (int)$stmt->fetchColumn();

    $stmt = $db->prepare('SELECT COUNT(*) FROM results WHERE published_at < :cutoff');
    $stmt->execute([':cutoff' => $cutoff]);
    $resultsCount = (int)$stmt->fetchColumn();

    $stmt = $db->prepare('SELECT COUNT(*) FROM result_details rd JOIN results r ON rd.result_id = r.id WHERE r.published_at < :cutoff');
    $stmt->execute([':cutoff' => $cutoff]);
    $resultDetailsCount = (int)$stmt->fetchColumn();

    $stmt = $db->prepare('SELECT COUNT(*) FROM result_numbers WHERE result_id IN (SELECT id FROM (SELECT id FROM results WHERE published_at < :cutoff) AS t)');
    $stmt->execute([':cutoff' => $cutoff]);
    $resultNumbersCount = (int)$stmt->fetchColumn();

    $stmt = $db->prepare('SELECT COUNT(*) FROM result_numbers_old WHERE result_id IN (SELECT id FROM (SELECT id FROM results WHERE published_at < :cutoff) AS t)');
    $stmt->execute([':cutoff' => $cutoff]);
    $resultNumbersOldCount = (int)$stmt->fetchColumn();

    echo "To delete:\n";
    echo " - Bets: {$betsCount}\n";
    echo " - Bet numbers: {$betNumbersCount}\n";
    echo " - Results: {$resultsCount}\n";
    echo " - Result details: {$resultDetailsCount}\n";
    echo " - Result numbers: {$resultNumbersCount}\n";
    echo " - Result numbers old: {$resultNumbersOldCount}\n";

    if ($dryRun) {
        echo "Dry run complete. No changes made.\n";
        exit(0);
    }

    if ($betsCount === 0 && $resultsCount === 0 && $resultNumbersCount === 0 && $resultNumbersOldCount === 0) {
        echo "Nothing to delete.\n";
        exit(0);
    }

    // Perform deletions in transaction
    $db->beginTransaction();

    // Delete bet_numbers linked to old bets
    $deleteBn = $db->prepare('DELETE bn FROM bet_numbers bn JOIN bets b ON bn.bet_id = b.id WHERE b.placed_at < :cutoff');
    $deleteBn->execute([':cutoff' => $cutoff]);

    // Delete old bets
    $deleteBets = $db->prepare('DELETE FROM bets WHERE placed_at < :cutoff');
    $deleteBets->execute([':cutoff' => $cutoff]);

    // Delete result_numbers and result_numbers_old entries for old results
    $deleteRn = $db->prepare('DELETE FROM result_numbers WHERE result_id IN (SELECT id FROM (SELECT id FROM results WHERE published_at < :cutoff) AS t)');
    $deleteRn->execute([':cutoff' => $cutoff]);

    $deleteRnOld = $db->prepare('DELETE FROM result_numbers_old WHERE result_id IN (SELECT id FROM (SELECT id FROM results WHERE published_at < :cutoff) AS t)');
    $deleteRnOld->execute([':cutoff' => $cutoff]);

    // Delete results (will cascade to result_details via FK)
    $deleteResults = $db->prepare('DELETE FROM results WHERE published_at < :cutoff');
    $deleteResults->execute([':cutoff' => $cutoff]);

    $db->commit();

    echo "Deletion complete.\n";
    echo " - Bet numbers removed: " . $deleteBn->rowCount() . "\n";
    echo " - Bets removed: " . $deleteBets->rowCount() . "\n";
    echo " - Result numbers removed: " . $deleteRn->rowCount() . "\n";
    echo " - Result numbers old removed: " . $deleteRnOld->rowCount() . "\n";
    echo " - Results removed: " . $deleteResults->rowCount() . "\n";

} catch (PDOException $e) {
    if ($db->inTransaction()) $db->rollBack();
    fwrite($stderr, "Database error: " . $e->getMessage() . "\n");
    exit(2);
} catch (Exception $e) {
    if ($db->inTransaction()) $db->rollBack();
    fwrite($stderr, "Error: " . $e->getMessage() . "\n");
    exit(3);
}

return 0;
