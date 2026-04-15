<?php

namespace Bet;

require_once('./bootstrap.php');

use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\QueryBuilder;
use \Exception;
use PDOException;

class Bet
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static bool $initialized = false;

    const TABLE_NAME = 'bets';

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
        string $agentId,
        string $gameId,
        string $betTypeId,
        string $mode,
        float $stakeAmount,
        int $totalGamesPlayed = 1,
        ?string $cashbackId = null,
        string $status = 'pending'
    ): bool {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->insert([
            'id' => $id,
            'agent_id' => $agentId,
            'game_id' => $gameId,
            'bet_type_id' => $betTypeId,
            'mode' => $mode,
            'stake_amount' => $stakeAmount,
            'total_games_played' => $totalGamesPlayed,
            'cashback_id' => $cashbackId,
            'status' => $status,
            'placed_at' => date('Y-m-d H:i:s'),
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
            ->orderBy('placed_at', 'DESC')
            ->get();
    }

    public static function getByAgentId(string $agentId): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('agent_id', '=', $agentId)
            ->orderBy('placed_at', 'DESC')
            ->get();
    }

    public static function getByGameId(string $gameId): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('game_id', '=', $gameId)
            ->orderBy('placed_at', 'DESC')
            ->get();
    }

    public static function getByStatus(string $status): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('status', '=', $status)
            ->orderBy('placed_at', 'DESC')
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
            throw new Exception("Failed to delete bet: " . $e->getMessage());
        }
    }

    public static function getAllWithDetails(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'bets.id AS bet_id',
                'bets.agent_id AS bet_agent_id',
                'bets.game_id AS bet_game_id',
                'bets.bet_type_id AS bet_type_id',
                'bets.mode AS bet_mode',
                'bets.stake_amount AS bet_stake_amount',
                'bets.total_games_played AS bet_total_games_played',
                'bets.cashback_id AS bet_cashback_id',
                'bets.status AS bet_status',
                'bets.placed_at AS bet_placed_at',
                'agents.name AS agent_name',
                'agents.email AS agent_email',
                'agents.phone AS agent_phone',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
                'bet_types.name AS bet_type_name',
                'bet_types.category AS bet_type_category',
            ])
            ->leftJoin('agents', 'bets.agent_id', '=', 'agents.id')
            ->leftJoin('games', 'bets.game_id', '=', 'games.id')
            ->leftJoin('bet_types', 'bets.bet_type_id', '=', 'bet_types.id')
            ->orderBy('bets.placed_at', 'DESC')
            ->get();
    }

    public static function getByIdWithDetails(string $id): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'bets.id AS bet_id',
                'bets.agent_id AS bet_agent_id',
                'bets.game_id AS bet_game_id',
                'bets.bet_type_id AS bet_type_id',
                'bets.mode AS bet_mode',
                'bets.stake_amount AS bet_stake_amount',
                'bets.total_games_played AS bet_total_games_played',
                'bets.cashback_id AS bet_cashback_id',
                'bets.status AS bet_status',
                'bets.placed_at AS bet_placed_at',
                'agents.name AS agent_name',
                'agents.email AS agent_email',
                'agents.phone AS agent_phone',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
                'bet_types.name AS bet_type_name',
                'bet_types.category AS bet_type_category',
            ])
            ->leftJoin('agents', 'bets.agent_id', '=', 'agents.id')
            ->leftJoin('games', 'bets.game_id', '=', 'games.id')
            ->leftJoin('bet_types', 'bets.bet_type_id', '=', 'bet_types.id')
            ->where('bets.id', '=', $id)
            ->get();
    }

    public static function getAllWithNumbers(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'bets.id AS bet_id',
                'bets.agent_id AS bet_agent_id',
                'bets.game_id AS bet_game_id',
                'bets.bet_type_id AS bet_type_id',
                'bets.mode AS bet_mode',
                'bets.stake_amount AS bet_stake_amount',
                'bets.total_games_played AS bet_total_games_played',
                'bets.cashback_id AS bet_cashback_id',
                'bets.status AS bet_status',
                'bets.placed_at AS bet_placed_at',
                'bet_numbers.id AS bet_number_id',
                'bet_numbers.number AS bet_number',
            ])
            ->leftJoin('bet_numbers', 'bets.id', '=', 'bet_numbers.bet_id')
            ->orderBy('bets.placed_at', 'DESC')
            ->get();
    }

    public static function getByAgentIdWithNumbers(string $agentId): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'bets.id AS bet_id',
                'bets.agent_id AS bet_agent_id',
                'bets.game_id AS bet_game_id',
                'bets.bet_type_id AS bet_type_id',
                'bets.mode AS bet_mode',
                'bets.stake_amount AS bet_stake_amount',
                'bets.total_games_played AS bet_total_games_played',
                'bets.cashback_id AS bet_cashback_id',
                'bets.status AS bet_status',
                'bets.placed_at AS bet_placed_at',
                'games.game_name AS game_name',
                'bet_types.name AS bet_type_name',
                'bet_numbers.id AS bet_number_id',
                'bet_numbers.number AS bet_number',
            ])
            ->leftJoin('games', 'bets.game_id', '=', 'games.id')
            ->leftJoin('bet_types', 'bets.bet_type_id', '=', 'bet_types.id')
            ->leftJoin('bet_numbers', 'bets.id', '=', 'bet_numbers.bet_id')
            ->where('bets.agent_id', '=', $agentId)
            ->orderBy('bets.placed_at', 'DESC')
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
