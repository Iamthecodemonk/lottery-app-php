<?php

namespace ResultNumber;

require_once('./bootstrap.php');

use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\QueryBuilder;
use \Exception;
use PDOException;

class ResultNumber
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static bool $initialized = false;

    const TABLE_NAME = 'result_numbers';

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

    public static function create(string $id, string $resultId, string $gameTypeId, int $number, string $type): bool
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->insert([
            'id' => $id,
            'result_id' => $resultId,
            'game_type_id' => $gameTypeId,
            'number' => $number,
            'type' => $type,
        ]);
    }

    public static function getByResultId(string $resultId): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('result_id', '=', $resultId)
            ->orderBy('type', 'ASC')
            ->get();
    }

    public static function getByResultIdAndType(string $resultId, string $type): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('result_id', '=', $resultId)
            ->where('type', '=', $type)
            ->get();
    }

    public static function deleteByResultId(string $resultId): bool
    {
        self::init();
        try {
            self::$qb->table(self::TABLE_NAME)
                ->where('result_id', '=', $resultId)
                ->delete();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Failed to delete result numbers: " . $e->getMessage());
        }
    }
}
