<?php
require_once('./_Helpers.php');
require_once('./middleware/middleware.php');

use Middleware\Middleware;

use _Helpers\Router;
use _Helpers\SessionService;

// const USER_REDIRECT_URL = '/lt/';
function useLoginAgentPage(){
    Middleware::redirectIfJwtAuthenticated('/lt/agent', ['agent']);
    Router::SetPage('agent/agent-login');
}
function useAgentLogoutPage(){
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
    header('Location: /lt/');
    exit();
}
function useAgentDashboardPage(){
    Middleware::requireJwt(['agent'], '/lt/agent/login');
    Router::SetPage('agent/agent-dashboard');
}
function useAgentCashBackPage(){
    Middleware::requireJwt(['agent'], '/lt/agent/login');
    Router::SetPage('agent/agent-cashback');
}
function useAgentReceiptPage(){
    Middleware::requireJwt(['agent'], '/lt/agent/login');
    Router::SetPage('agent/agent-receipt');
}
function useAgentResultsPage(){
    Middleware::requireJwt(['agent'], '/lt/agent/login');
    Router::SetPage('agent/agent-results');
}
function useAgentPlayPage(){
    Middleware::requireJwt(['agent'], '/lt/agent/login');
    Router::SetPage('agent/agent-play');
}
function useAgentAccountPage(){
    Middleware::requireJwt(['agent'], '/lt/agent/login');
    Router::SetPage('agent/agent-account');
}

