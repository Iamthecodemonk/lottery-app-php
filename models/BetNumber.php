<?php

namespace BetNumber;

require_once('./bootstrap.php');

use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\QueryBuilder;
use \Exception;
use PDOException;

class BetNumber
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static bool $initialized = false;

    const TABLE_NAME = 'bet_numbers';

    public static function init()
    {
        if (!self::$initialized) {
            global $dsn, $username, $password;

            $db = Database::getInstance($dsn, $username, $password);
            $pdo = $db->getConnection();
            self::$sqlDB = new SQLDB($pdo);
            self::$toolHelper = new ToolHelper();
            self::$sessionService = new SessionService();
            self::$qb = new QueryBuilder($pdo);
            self::$initialized = true;
        }
    }

    public static function createBulk(string $betId, array $numbers): bool
    {
        self::init();
        $cleaned = array_values(array_filter($numbers, function ($num) {
            return $num !== null && $num !== '' && is_numeric($num);
        }));

        foreach ($cleaned as $number) {
            $hex = bin2hex(random_bytes(16));
            $id = sprintf(
                '%s-%s-%s-%s-%s',
                substr($hex, 0, 8),
                substr($hex, 8, 4),
                substr($hex, 12, 4),
                substr($hex, 16, 4),
                substr($hex, 20, 12)
            );
            self::$qb->table(self::TABLE_NAME)->insert([
                'id' => $id,
                'bet_id' => $betId,
                'number' => (int) $number,
            ]);
        }

        return true;
    }
}
