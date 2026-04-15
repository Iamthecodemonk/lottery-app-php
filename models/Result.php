<?php

namespace Result;

require_once('./bootstrap.php');

use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\QueryBuilder;
use \Exception;
use PDOException;

class Result
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static bool $initialized = false;

    const TABLE_NAME = 'results';

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

    public static function create(string $id, string $gameId, ?string $publishedAt = null): bool
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->insert([
            'id' => $id,
            'game_id' => $gameId,
            'published_at' => $publishedAt ?? date('Y-m-d H:i:s'),
        ]);
    }

    public static function publish(string $id, ?string $gameId, array $resultDetails): array
    {
        global $dsn, $username, $password;
        $db = Database::getInstance($dsn, $username, $password);
        $pdo = $db->getConnection();

        try {
            $pdo->beginTransaction();

            $stmtResult = $pdo->prepare('INSERT INTO results (id, game_id, published_at) VALUES (?, ?, ?)');
            $stmtResult->execute([$id, $gameId, date('Y-m-d H:i:s')]);

            $stmtDetail = $pdo->prepare('INSERT INTO result_details (id, result_id, game_id, winning_number, machine_number, created_at) VALUES (?, ?, ?, ?, ?, ?)');

            foreach ($resultDetails as $detail) {
                $detailId = bin2hex(random_bytes(16));
                $detailId = sprintf(
                    '%s-%s-%s-%s-%s',
                    substr($detailId, 0, 8),
                    substr($detailId, 8, 4),
                    substr($detailId, 12, 4),
                    substr($detailId, 16, 4),
                    substr($detailId, 20, 12)
                );
                $stmtDetail->execute([
                    $detailId,
                    $id,
                    (string) $detail['game_id'],
                    (int) $detail['winning_number'],
                    (int) $detail['machine_number'],
                    date('Y-m-d H:i:s')
                ]);
            }

            $pdo->commit();
            return [
                'success' => true,
                'error' => null
            ];
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Publish result failed: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public static function getById(string $id): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('id', '=', $id)
            ->get();
    }

    public static function getByGameId(string $gameId): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('game_id', '=', $gameId)
            ->orderBy('published_at', 'DESC')
            ->get();
    }

    public static function getAll(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->orderBy('published_at', 'DESC')
            ->get();
    }

    public static function getAllWithNumbers(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'results.id AS result_id',
                'results.game_id AS result_game_id',
                'results.published_at AS result_published_at',
                'result_details.id AS result_detail_id',
                'result_details.game_id AS result_detail_game_id',
                'result_details.winning_number AS result_winning_number',
                'result_details.machine_number AS result_machine_number',
                'detail_games.game_name AS result_game_name',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
            ])
            ->leftJoin('result_details', 'results.id', '=', 'result_details.result_id')
            ->leftJoin('games', 'results.game_id', '=', 'games.id')
            ->leftJoin('games', 'result_details.game_id', '=', 'detail_games.id', 'detail_games')
            ->orderBy('results.published_at', 'DESC')
            ->get();
    }

    public static function getByIdWithNumbers(string $id): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'results.id AS result_id',
                'results.game_id AS result_game_id',
                'results.published_at AS result_published_at',
                'result_details.id AS result_detail_id',
                'result_details.game_id AS result_detail_game_id',
                'result_details.winning_number AS result_winning_number',
                'result_details.machine_number AS result_machine_number',
                'detail_games.game_name AS result_game_name',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
            ])
            ->leftJoin('result_details', 'results.id', '=', 'result_details.result_id')
            ->leftJoin('games', 'results.game_id', '=', 'games.id')
            ->leftJoin('games', 'result_details.game_id', '=', 'detail_games.id', 'detail_games')
            ->where('results.id', '=', $id)
            ->orderBy('result_details.created_at', 'ASC')
            ->get();
    }

    public static function getByGameIdWithNumbers(string $gameId): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'results.id AS result_id',
                'results.game_id AS result_game_id',
                'results.published_at AS result_published_at',
                'result_details.id AS result_detail_id',
                'result_details.game_id AS result_detail_game_id',
                'result_details.winning_number AS result_winning_number',
                'result_details.machine_number AS result_machine_number',
                'detail_games.game_name AS result_game_name',
                'games.game_name AS game_name',
                'games.category AS game_category',
                'games.status AS game_status',
            ])
            ->leftJoin('result_details', 'results.id', '=', 'result_details.result_id')
            ->leftJoin('games', 'results.game_id', '=', 'games.id')
            ->leftJoin('games', 'result_details.game_id', '=', 'detail_games.id', 'detail_games')
            ->where('results.game_id', '=', $gameId)
            ->orderBy('results.published_at', 'DESC')
            ->get();
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
            throw new Exception("Failed to delete result: " . $e->getMessage());
        }
    }

    public static function countAll(): int
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->count();
    }
}
