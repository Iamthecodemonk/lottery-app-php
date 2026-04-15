<?php

namespace Agent;

require_once('./bootstrap.php');

use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\QueryBuilder;
use \Exception;
use PDOException;

class Agent
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static bool $initialized = false;

    const TABLE_NAME = 'agents';

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
        string $phone,
        int $suspendAgent = 0,
        float $balance = 0
    ): bool {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->insert([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'suspendAgent' => $suspendAgent,
            'balance' => $balance,
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

    public static function update(string $id, array $data): bool
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->where('id', '=', $id)
            ->update($data);
    }

    public static function suspend(string $id, bool $isSuspended): bool
    {
        self::init();
        $response = self::$qb->forceCleanUpdate(self::TABLE_NAME, ['id' => $id], [
            'suspendAgent' => $isSuspended ? 1 : 0,
        ]);
        return (bool) ($response['success'] ?? false);
    }

    public static function adjustBalance(string $id, float $delta): bool
    {
        self::init();
        global $dsn, $username, $password;
        $db = Database::getInstance($dsn, $username, $password);
        $pdo = $db->getConnection();

        $stmt = $pdo->prepare('UPDATE agents SET balance = balance + ? WHERE id = ? AND balance + ? >= 0');
        $stmt->execute([$delta, $id, $delta]);
        return $stmt->rowCount() > 0;
    }

    public static function delete(string $id): bool
    {
        self::init();
        global $dsn, $username, $password;
        $db = Database::getInstance($dsn, $username, $password);
        $pdo = $db->getConnection();

        try {
            $pdo->beginTransaction();

            // Find bets belonging to this agent
            $stmt = $pdo->prepare('SELECT id FROM bets WHERE agent_id = ?');
            $stmt->execute([$id]);
            $betIds = $stmt->fetchAll(\PDO::FETCH_COLUMN);

            if (!empty($betIds)) {
                // Delete bet numbers first
                $placeholders = implode(',', array_fill(0, count($betIds), '?'));
                $stmtNumbers = $pdo->prepare("DELETE FROM bet_numbers WHERE bet_id IN ($placeholders)");
                $stmtNumbers->execute($betIds);

                // Delete bets
                $stmtBets = $pdo->prepare("DELETE FROM bets WHERE id IN ($placeholders)");
                $stmtBets->execute($betIds);
            }

            // Delete agent
            $stmtAgent = $pdo->prepare('DELETE FROM agents WHERE id = ?');
            $stmtAgent->execute([$id]);

            $pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw new Exception("Failed to delete agent: " . $e->getMessage());
        }
    }

    public static function getAllWithBets(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'agents.id AS agent_id',
                'agents.name AS agent_name',
                'agents.email AS agent_email',
                'agents.phone AS agent_phone',
                'agents.suspendAgent AS agent_suspended',
                'agents.created_at AS agent_created_at',
                'bets.id AS bet_id',
                'bets.game_id AS bet_game_id',
                'bets.bet_type_id AS bet_type_id',
                'bets.mode AS bet_mode',
                'bets.stake_amount AS bet_stake_amount',
                'bets.total_games_played AS bet_total_games_played',
                'bets.cashback_id AS bet_cashback_id',
                'bets.status AS bet_status',
                'bets.placed_at AS bet_placed_at',
            ])
            ->leftJoin('bets', 'agents.id', '=', 'bets.agent_id')
            ->orderBy('agents.created_at', 'DESC')
            ->get();
    }

    public static function getByIdWithBets(string $id): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'agents.id AS agent_id',
                'agents.name AS agent_name',
                'agents.email AS agent_email',
                'agents.phone AS agent_phone',
                'agents.suspendAgent AS agent_suspended',
                'agents.created_at AS agent_created_at',
                'bets.id AS bet_id',
                'bets.game_id AS bet_game_id',
                'bets.bet_type_id AS bet_type_id',
                'bets.mode AS bet_mode',
                'bets.stake_amount AS bet_stake_amount',
                'bets.total_games_played AS bet_total_games_played',
                'bets.cashback_id AS bet_cashback_id',
                'bets.status AS bet_status',
                'bets.placed_at AS bet_placed_at',
            ])
            ->leftJoin('bets', 'agents.id', '=', 'bets.agent_id')
            ->where('agents.id', '=', $id)
            ->orderBy('bets.placed_at', 'DESC')
            ->get();
    }

    public static function countAll(): int
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->count();
    }

    public static function countSuspended(): int
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->where('suspendAgent', '=', 1)
            ->count();
    }
}
