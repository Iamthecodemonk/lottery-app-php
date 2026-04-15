<?php

namespace AgentService;

use PDOException;

require_once('./bootstrap.php');
require_once('./models/Agent.php');
require_once('./models/WalletTransaction.php');
require_once __DIR__ . '/../vendor/autoload.php';

use Agent\Agent;
use WalletTransaction\WalletTransaction;

use _Helpers\ToolHelper;
use _Helpers\ServerHandler;
use _Helpers\JWT;

use Exception;

class AgentService
{
    protected static ToolHelper $toolHelper;
    protected static JWT $jwt;
    protected static bool $initialized = false;

    public static function init()
    {
        if (!self::$initialized) {
            self::$toolHelper = new ToolHelper();
            self::$jwt = new JWT();
            self::$initialized = true;
        }
    }

    public static function CreateAgent()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        $id = trim((string) ($data['id'] ?? ('AGENT-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)))));
        $name = trim((string) ($data['name'] ?? ''));
        $email = trim((string) ($data['email'] ?? ''));
        $phone = trim((string) ($data['phone'] ?? ''));
        $suspendAgent = (int) ($data['suspendAgent'] ?? 0);
        $balance = (float) ($data['balance'] ?? 0);

        if (!$id || !$name || !$email || !$phone) {
            return self::$toolHelper->ReportBox(false, 'Missing required information.', 400);
        }

        $existing = Agent::getByEmail($email);
        if (!empty($existing)) {
            return self::$toolHelper->ReportBox(false, 'Agent with this email already exists.', 409);
        }

        try {
            $result = Agent::create($id, $name, $email, $phone, $suspendAgent, $balance);
            if ($result) {
                $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                $safeId = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
                $emailSubject = 'Agent Account Created';
                $emailBody = "
                    <div style=\"font-family: Arial, sans-serif; color: #1f2937;\">
                        <h2 style=\"margin: 0 0 12px;\">Welcome, Agent</h2>
                        <p style=\"margin: 0 0 12px;\">Hello {$safeName},</p>
                        <p style=\"margin: 0 0 12px;\">You are now an agent.</p>
                        <p style=\"margin: 0 0 12px;\"><strong>Your Agent ID:</strong> {$safeId}</p>
                        <p style=\"margin: 0;\">Use this Agent ID with your email to log in.</p>
                    </div>
                ";
                self::$toolHelper->sendMail($email, $emailSubject, $emailBody);

                return self::$toolHelper->ReportBox(true, [
                    'message' => 'Agent created successfully.',
                    'agent_id' => $id,
                ], 201);
            }
            return self::$toolHelper->ReportBox(false, 'Failed to create agent.', 500);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                return self::$toolHelper->ReportBox(false, 'Agent with this email already exists.', 409);
            }
            return self::$toolHelper->ReportBox(false, 'Failed to create agent.', 500);
        }
    }

    public static function LoginAgent()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        $agentId = trim((string) ($data['agent_id'] ?? ''));
        $email = trim((string) ($data['email'] ?? ''));

        if (!$agentId || !$email) {
            return self::$toolHelper->ReportBox(false, 'Missing required information.', 400);
        }

        $agent = Agent::getById($agentId);
        if (empty($agent)) {
            return self::$toolHelper->ReportBox(false, 'Invalid agent credentials.', 401);
        }

        $agentRow = $agent[0];
        if (($agentRow['email'] ?? '') !== $email) {
            return self::$toolHelper->ReportBox(false, 'Invalid agent credentials.', 401);
        }
        if (!empty($agentRow['suspendAgent'])) {
            return self::$toolHelper->ReportBox(false, 'Agent account is suspended. Please contact admin.', 403);
        }

        $token = self::$jwt->encodeJWT([
            'id' => $agentRow['id'] ?? $agentId,
            'email' => $agentRow['email'] ?? $email,
            'role' => 'agent',
            'name' => $agentRow['name'] ?? null,
        ]);

        $isSecure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        setcookie('agent_token', $token, [
            'expires' => time() + (60 * 60),
            'path' => '/',
            'secure' => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        setcookie('agent_id', $agentRow['id'] ?? $agentId, [
            'expires' => time() + (60 * 60),
            'path' => '/',
            'secure' => $isSecure,
            'httponly' => false,
            'samesite' => 'Lax',
        ]);

        return self::$toolHelper->ReportBox(true, [
            'message' => 'Agent login successful.',
            'agent' => $agentRow,
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in_minutes' => 60
        ], 200);
    }

    public static function LogoutAgent()
    {
        self::init();

        $isSecure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        // Clear agent cookies for browser sessions if present.
        setcookie('agent_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        setcookie('token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        setcookie('agent_id', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => $isSecure,
            'httponly' => false,
            'samesite' => 'Lax',
        ]);

        // JWT is stateless; client should discard token.
        return self::$toolHelper->ReportBox(true, 'Agent logout successful.', 200);
    }

    public static function GetAgentById()
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

        $agent = Agent::getById($agentId);
        if (empty($agent)) {
            return self::$toolHelper->ReportBox(false, 'Agent not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $agent, 200);
    }

    public static function GetAgentByEmail()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $email = $data['email'] ?? null;
        if (!$email) {
            return self::$toolHelper->ReportBox(false, 'Missing email.', 400);
        }

        $agent = Agent::getByEmail($email);
        if (empty($agent)) {
            return self::$toolHelper->ReportBox(false, 'Agent not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $agent, 200);
    }

    public static function GetAllAgents()
    {
        self::init();
        $agents = Agent::getAll();
        if (empty($agents)) {
            return self::$toolHelper->ReportBox(false, 'No agents found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $agents, 200);
    }

    public static function GetAgentsWithBets()
    {
        self::init();
        $agents = Agent::getAllWithBets();
        if (empty($agents)) {
            return self::$toolHelper->ReportBox(false, 'No agents found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $agents, 200);
    }

    public static function GetAgentWithBetsById()
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

        $agent = Agent::getByIdWithBets($agentId);
        if (empty($agent)) {
            return self::$toolHelper->ReportBox(false, 'Agent not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $agent, 200);
    }

    public static function UpdateAgent()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];

        $agentId = $data['agent_id'] ?? null;
        if (!$agentId) {
            return self::$toolHelper->ReportBox(false, 'Missing agent ID.', 400);
        }

        $updateData = [];
        if (isset($data['name'])) $updateData['name'] = $data['name'];
        if (isset($data['email'])) $updateData['email'] = $data['email'];
        if (isset($data['phone'])) $updateData['phone'] = $data['phone'];
        if (isset($data['suspendAgent'])) $updateData['suspendAgent'] = (int) $data['suspendAgent'];

        if (empty($updateData)) {
            return self::$toolHelper->ReportBox(false, 'No data to update.', 400);
        }

        $result = Agent::update($agentId, $updateData);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Agent updated successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to update agent.', 500);
    }

    public static function SuspendAgent()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        $agentId = $data['agent_id'] ?? null;
        $suspendValue = isset($data['suspendAgent']) ? (int) $data['suspendAgent'] : 1;
        $isSuspended = $suspendValue === 1;

        if (!$agentId) {
            return self::$toolHelper->ReportBox(false, 'Missing agent ID.', 400);
        }

        $result = Agent::suspend($agentId, $isSuspended);
        if ($result) {
            $agent = Agent::getById($agentId);
            return self::$toolHelper->ReportBox(true, [
                'message' => 'Agent status updated successfully.',
                'suspendAgent' => $suspendValue,
                'agent' => $agent[0] ?? null,
            ], 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to update agent status.', 500);
    }

    public static function DeleteAgent()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        $agentId = $data['agent_id'] ?? null;

        if (!$agentId) {
            return self::$toolHelper->ReportBox(false, 'Missing agent ID.', 400);
        }

        $result = Agent::delete($agentId);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Agent deleted successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to delete agent.', 500);
    }

    public static function GetAgentCount()
    {
        self::init();
        $count = Agent::countAll();
        return self::$toolHelper->ReportBox(true, ['count' => $count], 200);
    }

    public static function GetSuspendedAgentCount()
    {
        self::init();
        $count = Agent::countSuspended();
        return self::$toolHelper->ReportBox(true, ['count' => $count], 200);
    }

    public static function CreditAgent()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        $agentId = $data['agent_id'] ?? null;
        $amount = isset($data['amount']) ? (float) $data['amount'] : 0;

        if (!$agentId) {
            return self::$toolHelper->ReportBox(false, 'Missing agent ID.', 400);
        }
        if ($amount < 100 || $amount > 20000) {
            return self::$toolHelper->ReportBox(false, 'Amount must be between 100 and 20,000.', 400);
        }

        $updated = Agent::adjustBalance($agentId, $amount);
        if (!$updated) {
            return self::$toolHelper->ReportBox(false, 'Failed to credit agent.', 500);
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
                'type' => 'credit',
                'amount' => $amount,
                'balance_after' => (float) ($agentRow['balance'] ?? 0),
                'reference' => null,
                'note' => 'Admin credit'
            ]);
        }
        return self::$toolHelper->ReportBox(true, [
            'message' => 'Agent credited successfully.',
            'agent' => $agentRow,
        ], 200);
    }

    public static function DebitAgent()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        $agentId = $data['agent_id'] ?? null;
        $amount = isset($data['amount']) ? (float) $data['amount'] : 0;

        if (!$agentId) {
            return self::$toolHelper->ReportBox(false, 'Missing agent ID.', 400);
        }
        if ($amount < 100 || $amount > 20000) {
            return self::$toolHelper->ReportBox(false, 'Amount must be between 100 and 20,000.', 400);
        }

        $updated = Agent::adjustBalance($agentId, -$amount);
        if (!$updated) {
            return self::$toolHelper->ReportBox(false, 'Insufficient balance to debit.', 400);
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
                'amount' => $amount,
                'balance_after' => (float) ($agentRow['balance'] ?? 0),
                'reference' => null,
                'note' => 'Admin debit'
            ]);
        }

        return self::$toolHelper->ReportBox(true, [
            'message' => 'Agent debited successfully.',
            'agent' => $agentRow,
        ], 200);
    }

    public static function GetAgentTransactions()
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

        $rows = WalletTransaction::getByAgentId($agentId);
        if (empty($rows)) {
            return self::$toolHelper->ReportBox(false, 'No transactions found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $rows, 200);
    }

    public static function GetAllAgentTransactions()
    {
        self::init();
        $rows = WalletTransaction::getAllWithAgents();
        if (empty($rows)) {
            return self::$toolHelper->ReportBox(false, 'No transactions found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $rows, 200);
    }
}
