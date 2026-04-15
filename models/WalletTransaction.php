<?php

namespace WalletTransaction;

require_once('./bootstrap.php');

use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\QueryBuilder;

class WalletTransaction
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static bool $initialized = false;

    const TABLE_NAME = 'wallet_transactions';

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

    public static function create(array $data): bool
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)->insert([
            'id' => $data['id'],
            'agent_id' => $data['agent_id'],
            'type' => $data['type'],
            'amount' => $data['amount'],
            'balance_after' => $data['balance_after'],
            'reference' => $data['reference'] ?? null,
            'note' => $data['note'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function getByAgentId(string $agentId): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select('*')
            ->where('agent_id', '=', $agentId)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function getAllWithAgents(): array
    {
        self::init();
        return self::$qb->table(self::TABLE_NAME)
            ->select([
                'wallet_transactions.id',
                'wallet_transactions.agent_id',
                'wallet_transactions.type',
                'wallet_transactions.amount',
                'wallet_transactions.balance_after',
                'wallet_transactions.reference',
                'wallet_transactions.note',
                'wallet_transactions.created_at',
                'agents.name AS agent_name',
                'agents.email AS agent_email'
            ])
            ->join('agents', 'wallet_transactions.agent_id', '=', 'agents.id')
            ->orderBy('wallet_transactions.created_at', 'DESC')
            ->get();
    }
}
