<?php
require_once('./_Helpers.php');
require_once('./middleware/middleware.php');

use Middleware\Middleware;

use _Helpers\Router;
use _Helpers\SessionService;

const USER_REDIRECT_URL = '/lt/';
function useSignUpUserPage(){
    // Middleware::redirectIfAuthenticatedUser(USER_REDIRECT_URL);
    Router::SetPage('admin/signup');
}
function useLoginAdminPage(){
    Middleware::redirectIfJwtAuthenticated('/lt/admin', ['admin']);
    Router::SetPage('admin/login');
}
function useAdminLogoutPage(){
    $isSecure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    setcookie('admin_token', '', [
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
function usePasswordResetRequestPage(){
    // Middleware::redirectIfAuthenticatedUser(USER_REDIRECT_URL);
    Router::SetPage('admin/passwordresetrequest');
}
function usePasswordResetPage(){
    // Middleware::redirectIfAuthenticatedUser(USER_REDIRECT_URL);
    Router::SetPage('admin/passwordreset');
}

function useAgentManagementPage(){
    Middleware::requireJwt(['admin'], '/lt/admin/login');
    Router::SetPage('admin/admin-agents');
}

function useAdminDashboardPage(){
    Middleware::requireJwt(['admin'], '/lt/admin/login');
    Router::SetPage('admin/admin-dashboard');
}
function useAdminCashBackMonitorPage(){
    Middleware::requireJwt(['admin'], '/lt/admin/login');
    Router::SetPage('admin/admin-cashback-monitor');
}
function useAdminGamesPage(){
    Middleware::requireJwt(['admin'], '/lt/admin/login');
    Router::SetPage('admin/admin-games');
}
function useAdminBetTypesPage(){
    Middleware::requireJwt(['admin'], '/lt/admin/login');
    Router::SetPage('admin/admin-bet-types');
}
function useAdminLottoMonitorPage(){
    Middleware::requireJwt(['admin'], '/lt/admin/login');
    Router::SetPage('admin/admin-lotto-monitor');
}
function useAdminResultsPage(){
    Middleware::requireJwt(['admin'], '/lt/admin/login');
    Router::SetPage('admin/admin-results');
}
function useAdminSalesPage(){
    Middleware::requireJwt(['admin'], '/lt/admin/login');
    Router::SetPage('admin/admin-sales');
}
function useAdminAccountPage(){
    Middleware::requireJwt(['admin'], '/lt/admin/login');
    Router::SetPage('admin/admin-account');
}
function use404Page(){
    Router::SetPage('404');
}
function use403Page(){
    Router::SetPage('403');
}
