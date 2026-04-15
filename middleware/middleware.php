<?php

namespace Middleware;


require_once('./bootstrap.php');


use Database\Database;
use _Helpers\SQLDB;
use _Helpers\ToolHelper;
use _Helpers\SessionService;
use _Helpers\ServerHandler;
use _Helpers\QueryBuilder;
use _Helpers\JWT;
class Middleware
{
    protected static SQLDB $sqlDB;
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static QueryBuilder $qb;
    protected static JWT $jwt;
    protected static bool $initialized = false;

    // Initialize dependencies once
    public static function init()
    {
        if (!self::$initialized) {
            global $dsn, $username, $password; // Use global variables from db_credentials.php

            $pdo = Database::getInstance()->getConnection();
            self::$sqlDB = new SQLDB($pdo);
            self::$toolHelper = new ToolHelper();
            self::$sessionService = new SessionService();
            self::$qb = new QueryBuilder($pdo);
            self::$jwt = new JWT();
            self::$initialized = true;
        }
    }

    private static function getBearerToken(): ?string
    {
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['Authorization'] ?? '';
        if (!$header && function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                $header = $headers['Authorization'];
            }
        }

        if (is_string($header) && stripos($header, 'Bearer ') === 0) {
            return trim(substr($header, 7));
        }

        // Fallback to cookie token (for browser page loads)
        if (!empty($_COOKIE['admin_token'])) {
            return $_COOKIE['admin_token'];
        }
        if (!empty($_COOKIE['agent_token'])) {
            return $_COOKIE['agent_token'];
        }
        if (!empty($_COOKIE['token'])) {
            return $_COOKIE['token'];
        }

        // Optional query param fallback
        if (!empty($_GET['token'])) {
            return $_GET['token'];
        }

        return null;
    }

    private static function isAgentSuspended(?string $agentId): bool
    {
        if (!$agentId) {
            return false;
        }
        self::init();
        $agent = self::$qb->table('agents')
            ->select(['suspendAgent'])
            ->where('id', '=', $agentId)
            ->get();
        if (empty($agent)) {
            return false;
        }
        return !empty($agent[0]['suspendAgent']);
    }

    private static function clearAgentCookies(): void
    {
        $isSecure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
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
    }

    public static function currentJwtUser(): ?array
    {
        self::init();
        $token = self::getBearerToken();
        if (!$token) {
            return null;
        }
        $payload = self::$jwt->decodeJWT($token);
        return is_array($payload) ? $payload : null;
    }

    public static function redirectIfJwtAuthenticated(?string $redirectUrl = '/lt/admin', array $allowedRoles = []): void
    {
        self::init();
        $token = self::getBearerToken();
        if (!$token) {
            return;
        }

        $payload = self::$jwt->decodeJWT($token);
        if (!$payload) {
            return;
        }

        if (!empty($allowedRoles)) {
            $role = $payload['role'] ?? null;
            if (!$role || !in_array($role, $allowedRoles, true)) {
                return;
            }
        }

        if (($payload['role'] ?? null) === 'agent') {
            $agentId = $payload['id'] ?? null;
            if (self::isAgentSuspended($agentId)) {
                self::clearAgentCookies();
                return;
            }
        }

        header('Location: ' . $redirectUrl);
        exit();
    }

    public static function requireJwt(array $allowedRoles = [], ?string $redirectUrl = null): bool
    {
        self::init();
        $token = self::getBearerToken();

        if (!$token) {
            if ($redirectUrl) {
                header('Location: ' . $redirectUrl);
            } else {
                self::$toolHelper->ReportBox(false, 'Unauthorized: missing token.', 401);
            }
            return false;
        }

        $payload = self::$jwt->decodeJWT($token);
        if (!$payload) {
            if ($redirectUrl) {
                header('Location: ' . $redirectUrl);
            } else {
                self::$toolHelper->ReportBox(false, 'Unauthorized: invalid or expired token.', 401);
            }
            return false;
        }

        if (!empty($allowedRoles)) {
            $role = $payload['role'] ?? null;
            if (!$role || !in_array($role, $allowedRoles, true)) {
                if ($redirectUrl) {
                    header('Location: ' . $redirectUrl);
                } else {
                    self::$toolHelper->ReportBox(false, 'Forbidden: insufficient role.', 403);
                }
                return false;
            }
        }

        if (($payload['role'] ?? null) === 'agent') {
            $agentId = $payload['id'] ?? null;
            if (self::isAgentSuspended($agentId)) {
                self::clearAgentCookies();
                if ($redirectUrl) {
                    header('Location: ' . $redirectUrl);
                } else {
                    self::$toolHelper->ReportBox(false, 'Agent account is suspended. Please contact admin.', 403);
                }
                return false;
            }
        }

        return true;
    }
}
