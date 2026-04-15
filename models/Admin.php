<?php

namespace Admin;

require_once('./bootstrap.php');

use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\QueryBuilder;
use \Exception;
use PDOException;

class Admin
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static bool $initialized = false;

    const TABLE_NAME = 'admins';

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

    public static function create(
        string $id,
        string $name,
        string $email,
        string $password
    ): bool {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->insert([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function getById(string $id): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('id', '=', $id)
            ->get();
    }

    public static function getByEmail(string $email): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('email', '=', $email)
            ->get();
    }

    public static function getAll(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function authenticate(string $email, string $password): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('email', '=', $email)
            ->where('password', '=', $password)
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
            throw new Exception("Failed to delete admin: " . $e->getMessage());
        }
    }

    public static function getAllWithGames(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'admins.id AS admin_id',
                'admins.name AS admin_name',
                'admins.email AS admin_email',
                'admins.created_at AS admin_created_at',
                'games.id AS game_id',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
                'games.cutoff_time AS game_cutoff_time',
                'games.created_at AS game_created_at',
            ])
            ->leftJoin('games', 'admins.id', '=', 'games.created_by')
            ->orderBy('admins.created_at', 'DESC')
            ->get();
    }

    public static function getByIdWithGames(string $id): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'admins.id AS admin_id',
                'admins.name AS admin_name',
                'admins.email AS admin_email',
                'admins.created_at AS admin_created_at',
                'games.id AS game_id',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
                'games.cutoff_time AS game_cutoff_time',
                'games.created_at AS game_created_at',
            ])
            ->leftJoin('games', 'admins.id', '=', 'games.created_by')
            ->where('admins.id', '=', $id)
            ->orderBy('games.created_at', 'DESC')
            ->get();
    }

    public static function countAll(): int
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->count();
    }
}
