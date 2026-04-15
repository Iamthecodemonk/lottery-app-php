<?php

namespace BetType;

require_once('./bootstrap.php');

use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\QueryBuilder;
use \Exception;
use PDOException;

class BetType
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static bool $initialized = false;

    const TABLE_NAME = 'bet_types';

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

    public static function getAll(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function create(string $id, string $name, string $category): bool
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->insert([
            'id' => $id,
            'name' => $name,
            'category' => $category,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function getByCategory(string $category): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('category', '=', $category)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function update(string $id, array $data): bool
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->where('id', '=', $id)
            ->update($data);
    }

    public static function delete(string $id): bool
    {
        self::init();
        try {
            self::$qb->table(self::TABLE_NAME)
                ->where('id', '=', $id)
                ->delete();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Failed to delete bet type: " . $e->getMessage());
        }
    }
}
