<?php

namespace Game;

require_once('./bootstrap.php');

use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\QueryBuilder;
use \Exception;
use PDOException;

class Game
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static bool $initialized = false;

    const TABLE_NAME = 'games';

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
        string $gameName,
        string $category,
        string $status = 'active',
        ?string $cutoffTime = null,
        ?string $createdBy = null
    ): bool {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->insert([
            'id' => $id,
            'game_name' => $gameName,
            'category' => $category,
            'status' => $status,
            'cutoff_time' => $cutoffTime,
            'created_by' => $createdBy,
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

    public static function getAll(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function getByStatus(string $status): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('status', '=', $status)
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
            throw new Exception("Failed to delete game: " . $e->getMessage());
        }
    }

    public static function getAllWithAdmin(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'games.id AS game_id',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
                'games.cutoff_time AS game_cutoff_time',
                'games.created_at AS game_created_at',
                'admins.id AS admin_id',
                'admins.name AS admin_name',
                'admins.email AS admin_email',
            ])
            ->leftJoin('admins', 'games.created_by', '=', 'admins.id')
            ->orderBy('games.created_at', 'DESC')
            ->get();
    }

    public static function getByIdWithAdmin(string $id): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'games.id AS game_id',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
                'games.cutoff_time AS game_cutoff_time',
                'games.created_at AS game_created_at',
                'admins.id AS admin_id',
                'admins.name AS admin_name',
                'admins.email AS admin_email',
            ])
            ->leftJoin('admins', 'games.created_by', '=', 'admins.id')
            ->where('games.id', '=', $id)
            ->get();
    }

    public static function getAllWithBets(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'games.id AS game_id',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
                'games.cutoff_time AS game_cutoff_time',
                'games.created_at AS game_created_at',
                'bets.id AS bet_id',
                'bets.agent_id AS bet_agent_id',
                'bets.bet_type_id AS bet_type_id',
                'bets.mode AS bet_mode',
                'bets.stake_amount AS bet_stake_amount',
                'bets.total_games_played AS bet_total_games_played',
                'bets.cashback_id AS bet_cashback_id',
                'bets.status AS bet_status',
                'bets.placed_at AS bet_placed_at',
            ])
            ->leftJoin('bets', 'games.id', '=', 'bets.game_id')
            ->orderBy('games.created_at', 'DESC')
            ->get();
    }

    public static function countAll(): int
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->count();
    }

    public static function countByStatus(string $status): int
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->where('status', '=', $status)
            ->count();
    }
}
