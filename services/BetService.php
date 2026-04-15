<?php

namespace BetService;

use PDOException;

require_once('./bootstrap.php');
require_once('./models/Bet.php');
require_once('./models/BetNumber.php');
require_once('./models/BetType.php');
require_once('./models/Agent.php');
require_once('./models/WalletTransaction.php');
require_once __DIR__ . '/../vendor/autoload.php';

use Bet\Bet;
use BetNumber\BetNumber;
use BetType\BetType;
use Agent\Agent;
use WalletTransaction\WalletTransaction;

use _Helpers\ToolHelper;
use _Helpers\ServerHandler;
use _Helpers\SessionService;

use Exception;

class BetService
{
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static bool $initialized = false;

    public static function init()
    {
        if (!self::$initialized) {
            self::$toolHelper = new ToolHelper();
            self::$sessionService = new SessionService();
            self::$initialized = true;
        }
    }

    public static function CreateBet()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        $id = trim((string) ($data['id'] ?? ('BET-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)))));
        $agentId = trim((string) ($data['agent_id'] ?? ''));
        $gameId = trim((string) ($data['game_id'] ?? ''));
        $betTypeId = trim((string) ($data['bet_type_id'] ?? ''));
        $mode = trim((string) ($data['mode'] ?? 'placebet'));
        $stakeAmount = (float) ($data['stake_amount'] ?? 0);
        $totalGamesPlayed = (int) ($data['total_games_played'] ?? 1);
        $cashbackId = $data['cashback_id'] ?? null;
        $status = trim((string) ($data['status'] ?? 'pending'));
        $numbers = $data['numbers'] ?? ($data['bet_numbers'] ?? []);

        if (!$id || !$agentId || !$gameId || !$betTypeId || !$mode || !$stakeAmount) {
            return self::$toolHelper->ReportBox(false, 'Missing required information.', 400);
        }

        try {
            $grandStake = $stakeAmount * max(1, $totalGamesPlayed);
            $deducted = Agent::adjustBalance($agentId, -$grandStake);
            if (!$deducted) {
                return self::$toolHelper->ReportBox(false, 'Insufficient balance to place bet.', 400);
            }

            $result = Bet::create(
                $id,
                $agentId,
                $gameId,
                $betTypeId,
                $mode,
                $stakeAmount,
                $totalGamesPlayed,
                $cashbackId,
                $status
            );
            if ($result) {
                if (is_array($numbers) && !empty($numbers)) {
                    BetNumber::createBulk($id, $numbers);
                }
                $agent = Agent::getById($agentId);
                $agentRow = $agent[0] ?? null;
                if ($agentRow) {
                    $txnId = bin2hex(random_bytes(16));
                    $txnId = sprintf(
                        '%s-%s-%s-%s-%s',
                        substr($txnId, 0, 8),
                        substr($txnId, 8, 4),
                        substr($txnId, 12, 4),
                        substr($txnId, 16, 4),
                        substr($txnId, 20, 12)
                    );
                    WalletTransaction::create([
                        'id' => $txnId,
                        'agent_id' => $agentId,
                        'type' => 'debit',
                        'amount' => $grandStake,
                        'balance_after' => (float) ($agentRow['balance'] ?? 0),
                        'reference' => $id,
                        'note' => $mode === 'cashback' ? 'Cashback bet' : 'Lotto bet'
                    ]);
                }
                return self::$toolHelper->ReportBox(true, [
                    'message' => 'Bet created successfully.',
                    'bet_id' => $id,
                ], 201);
            }
            // Refund if bet creation failed
            Agent::adjustBalance($agentId, $grandStake);
            return self::$toolHelper->ReportBox(false, 'Failed to create bet.', 500);
        } catch (PDOException $e) {
            if (isset($grandStake)) {
                Agent::adjustBalance($agentId, $grandStake);
            }
            return self::$toolHelper->ReportBox(false, 'Failed to create bet.', 500);
        }
    }

    public static function GetBetById()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $betId = $data['bet_id'] ?? null;
        if (!$betId) {
            return self::$toolHelper->ReportBox(false, 'Missing bet ID.', 400);
        }

        $bet = Bet::getById($betId);
        if (empty($bet)) {
            return self::$toolHelper->ReportBox(false, 'Bet not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $bet, 200);
    }

    public static function GetAllBets()
    {
        self::init();
        $bets = Bet::getAll();
        if (empty($bets)) {
            return self::$toolHelper->ReportBox(false, 'No bets found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $bets, 200);
    }

    public static function GetBetsByAgent()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $agentId = $data['agent_id'] ?? null;
        if (!$agentId) {
            return self::$toolHelper->ReportBox(false, 'Missing agent ID.', 400);
        }

        $bets = Bet::getByAgentId($agentId);
        if (empty($bets)) {
            return self::$toolHelper->ReportBox(false, 'No bets found for this agent.', 404);
        }

        return self::$toolHelper->ReportBox(true, $bets, 200);
    }

    public static function GetBetsByGame()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $gameId = $data['game_id'] ?? null;
        if (!$gameId) {
            return self::$toolHelper->ReportBox(false, 'Missing game ID.', 400);
        }

        $bets = Bet::getByGameId($gameId);
        if (empty($bets)) {
            return self::$toolHelper->ReportBox(false, 'No bets found for this game.', 404);
        }

        return self::$toolHelper->ReportBox(true, $bets, 200);
    }

    public static function GetBetsByStatus()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $status = $data['status'] ?? null;
        if (!$status) {
            return self::$toolHelper->ReportBox(false, 'Missing status.', 400);
        }

        $bets = Bet::getByStatus($status);
        if (empty($bets)) {
            return self::$toolHelper->ReportBox(false, 'No bets found with this status.', 404);
        }

        return self::$toolHelper->ReportBox(true, $bets, 200);
    }

    public static function GetAllBetsWithDetails()
    {
        self::init();
        $bets = Bet::getAllWithDetails();
        if (empty($bets)) {
            return self::$toolHelper->ReportBox(false, 'No bets found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $bets, 200);
    }

    public static function GetBetWithDetailsById()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $betId = $data['bet_id'] ?? null;
        if (!$betId) {
            return self::$toolHelper->ReportBox(false, 'Missing bet ID.', 400);
        }

        $bet = Bet::getByIdWithDetails($betId);
        if (empty($bet)) {
            return self::$toolHelper->ReportBox(false, 'Bet not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $bet, 200);
    }

    public static function GetAllBetsWithNumbers()
    {
        self::init();
        $bets = Bet::getAllWithNumbers();
        if (empty($bets)) {
            return self::$toolHelper->ReportBox(false, 'No bets found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $bets, 200);
    }

    public static function GetBetsWithNumbersByAgent()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $agentId = $data['agent_id'] ?? null;
        if (!$agentId) {
            return self::$toolHelper->ReportBox(false, 'Missing agent ID.', 400);
        }

        $bets = Bet::getByAgentIdWithNumbers($agentId);
        if (empty($bets)) {
            return self::$toolHelper->ReportBox(false, 'No bets found for this agent.', 404);
        }

        return self::$toolHelper->ReportBox(true, $bets, 200);
    }

    public static function GetBetTypes()
    {
        self::init();
        $types = BetType::getAll();
        if (empty($types)) {
            return self::$toolHelper->ReportBox(false, 'No bet types found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $types, 200);
    }

    public static function GetBetTypesByCategory()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $category = strtolower(trim((string) ($data['category'] ?? '')));
        if (!$category) {
            return self::$toolHelper->ReportBox(false, 'Missing category.', 400);
        }

        if ($category === 'lotto') {
            $category = 'placebet';
        }

        $types = BetType::getByCategory($category);
        if (empty($types)) {
            return self::$toolHelper->ReportBox(false, 'No bet types found for this category.', 404);
        }

        return self::$toolHelper->ReportBox(true, $types, 200);
    }

    public static function UpdateBet()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];

        $betId = $data['bet_id'] ?? null;
        if (!$betId) {
            return self::$toolHelper->ReportBox(false, 'Missing bet ID.', 400);
        }

        $updateData = [];
        if (isset($data['agent_id'])) $updateData['agent_id'] = $data['agent_id'];
        if (isset($data['game_id'])) $updateData['game_id'] = $data['game_id'];
        if (isset($data['bet_type_id'])) $updateData['bet_type_id'] = $data['bet_type_id'];
        if (isset($data['mode'])) $updateData['mode'] = $data['mode'];
        if (isset($data['stake_amount'])) $updateData['stake_amount'] = $data['stake_amount'];
        if (isset($data['total_games_played'])) $updateData['total_games_played'] = $data['total_games_played'];
        if (array_key_exists('cashback_id', $data)) $updateData['cashback_id'] = $data['cashback_id'];
        if (isset($data['status'])) $updateData['status'] = $data['status'];

        if (empty($updateData)) {
            return self::$toolHelper->ReportBox(false, 'No data to update.', 400);
        }

        $result = Bet::update($betId, $updateData);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Bet updated successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to update bet.', 500);
    }

    public static function DeleteBet()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        $betId = $data['bet_id'] ?? null;

        if (!$betId) {
            return self::$toolHelper->ReportBox(false, 'Missing bet ID.', 400);
        }

        $result = Bet::delete($betId);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Bet deleted successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to delete bet.', 500);
    }

    public static function GetBetCount()
    {
        self::init();
        $count = Bet::countAll();
        return self::$toolHelper->ReportBox(true, ['count' => $count], 200);
    }

    public static function GetBetCountByStatus()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $status = $data['status'] ?? null;
        if (!$status) {
            return self::$toolHelper->ReportBox(false, 'Missing status.', 400);
        }

        $count = Bet::countByStatus($status);
        return self::$toolHelper->ReportBox(true, ['count' => $count], 200);
    }
}
