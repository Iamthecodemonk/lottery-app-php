<?php
// error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);
// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);

// // Log errors instead (optional but recommended)
// ini_set('log_errors', 1);
// ini_set('error_log', __DIR__ . '/php_error.log');

// require_once('./controller/Page/UserPage.php');
// require_once('./controller/Page/AgentPage.php');
require_once('./controller/Page/Admin.php');
require_once('./controller/Page/Agent.php');
require_once('./controller/Page/Home.php');

require_once('./controller/Game/agentpost.php');
require_once('./controller/Game/agentget.php');
require_once('./controller/Game/adminpost.php');
require_once('./controller/Game/adminget.php');
require_once('./controller/Game/betpost.php');
require_once('./controller/Game/betget.php');
require_once('./controller/Game/bettypepost.php');
require_once('./controller/Game/bettypeget.php');
require_once('./controller/Game/gamepost.php');
require_once('./controller/Game/gameget.php');
require_once('./controller/Game/resultpost.php');
require_once('./controller/Game/resultget.php');
require_once('./controller/Game/gametypeget.php');

require_once('./_Helpers.php');

use _Helpers\RouteHelper;
use _Helpers\ServerHandler;
use _Helpers\ToolHelper;

$toolHelper=new ToolHelper();

$serverHandler=new ServerHandler();

$serverHandler->DebugMode(true);

// Get the current URL path including query string
// Use config.php for environment config
$config = require(__DIR__ . '/config.php');
$urlDomainPath = $config['serverpathname'];
// Define a mapping of routes to their corresponding actions


$routes = [
    /**
     * pages
     * admin pages
     */
    $urlDomainPath.'admin' => 'useAdminDashboardPage',
    $urlDomainPath.'admin/agentsmanagement' => 'useAgentManagementPage',
    $urlDomainPath.'admin/cashbackmonitor' => 'useAdminCashBackMonitorPage',
    $urlDomainPath.'admin/games' => 'useAdminGamesPage',
    $urlDomainPath.'admin/bettypes' => 'useAdminBetTypesPage',
    $urlDomainPath.'admin/lottomonitor' => 'useAdminLottoMonitorPage',
    $urlDomainPath.'admin/results' => 'useAdminResultsPage',
    $urlDomainPath.'admin/sales' => 'useAdminSalesPage',
    $urlDomainPath.'admin/account' => 'useAdminAccountPage',
    $urlDomainPath.'admin/login' => 'useLoginAdminPage',
    $urlDomainPath.'admin/logout' => 'useAdminLogoutPage',

    $urlDomainPath => 'useHomePage',

    /**
     * pages
     * admin pages
     */
    $urlDomainPath.'agent' => 'useAgentDashboardPage',
    $urlDomainPath.'agent/cashback' => 'useAgentCashBackPage',
    $urlDomainPath.'agent/receipt' => 'useAgentReceiptPage',
    $urlDomainPath.'agent/results' => 'useAgentResultsPage',
    $urlDomainPath.'agent/lotto' => 'useAgentPlayPage',
    $urlDomainPath.'agent/login' => 'useLoginAgentPage',
    $urlDomainPath.'agent/logout' => 'useAgentLogoutPage',
    $urlDomainPath.'agent/account' => 'useAgentAccountPage',
    
    /**
     * API endpoints
     */
    //Course management
    /*     * General pages
     */
    $urlDomainPath.'404' => 'use404Page',
    $urlDomainPath.'403' => 'use403Page',
    // $urlDomainPath.'unauthorized' => 'useGeneralUnauthorizedPage',

    // Agent API
    $urlDomainPath.'api/agent/create' => 'AgentService_CreateAgent',
    $urlDomainPath.'api/agent/login' => 'AgentService_LoginAgent',
    $urlDomainPath.'api/agent/logout' => 'AgentService_LogoutAgent',
    $urlDomainPath.'api/agent/update' => 'AgentService_UpdateAgent',
    $urlDomainPath.'api/agent/suspend' => 'AgentService_SuspendAgent',
    $urlDomainPath.'api/agent/delete' => 'AgentService_DeleteAgent',
    $urlDomainPath.'api/agent/credit' => 'AgentService_CreditAgent',
    $urlDomainPath.'api/agent/debit' => 'AgentService_DebitAgent',

    $urlDomainPath.'api/agent/get-by-id' => 'AgentService_GetAgentById',
    $urlDomainPath.'api/agent/get-by-email' => 'AgentService_GetAgentByEmail',
    $urlDomainPath.'api/agent/all' => 'AgentService_GetAllAgents',
    $urlDomainPath.'api/agent/with-bets' => 'AgentService_GetAgentsWithBets',
    $urlDomainPath.'api/agent/with-bets-by-id' => 'AgentService_GetAgentWithBetsById',
    $urlDomainPath.'api/agent/count' => 'AgentService_GetAgentCount',
    $urlDomainPath.'api/agent/suspended-count' => 'AgentService_GetSuspendedAgentCount',
    $urlDomainPath.'api/agent/transactions' => 'AgentService_GetAgentTransactions',
    $urlDomainPath.'api/agent/transactions-all' => 'AgentService_GetAllAgentTransactions',

    // Admin API
    $urlDomainPath.'api/admin/create' => 'AdminService_CreateAdmin',
    $urlDomainPath.'api/admin/login' => 'AdminService_LoginAdmin',
    $urlDomainPath.'api/admin/logout' => 'AdminService_LogoutAdmin',
    $urlDomainPath.'api/admin/update' => 'AdminService_UpdateAdmin',
    $urlDomainPath.'api/admin/delete' => 'AdminService_DeleteAdmin',

    $urlDomainPath.'api/admin/get-by-id' => 'AdminService_GetAdminById',
    $urlDomainPath.'api/admin/get-by-email' => 'AdminService_GetAdminByEmail',
    $urlDomainPath.'api/admin/all' => 'AdminService_GetAllAdmins',
    $urlDomainPath.'api/admin/with-games' => 'AdminService_GetAdminsWithGames',
    $urlDomainPath.'api/admin/count' => 'AdminService_GetAdminCount',

    // Bet API
    $urlDomainPath.'api/bet/create' => 'BetService_CreateBet',
    $urlDomainPath.'api/bet/update' => 'BetService_UpdateBet',
    $urlDomainPath.'api/bet/delete' => 'BetService_DeleteBet',

    $urlDomainPath.'api/bet/get-by-id' => 'BetService_GetBetById',
    $urlDomainPath.'api/bet/all' => 'BetService_GetAllBets',
    $urlDomainPath.'api/bet/by-agent' => 'BetService_GetBetsByAgent',
    $urlDomainPath.'api/bet/by-game' => 'BetService_GetBetsByGame',
    $urlDomainPath.'api/bet/by-status' => 'BetService_GetBetsByStatus',
    $urlDomainPath.'api/bet/with-details' => 'BetService_GetAllBetsWithDetails',
    $urlDomainPath.'api/bet/with-details-by-id' => 'BetService_GetBetWithDetailsById',
    $urlDomainPath.'api/bet/with-numbers' => 'BetService_GetAllBetsWithNumbers',
    $urlDomainPath.'api/bet/with-numbers-by-agent' => 'BetService_GetBetsWithNumbersByAgent',
    $urlDomainPath.'api/bet/count' => 'BetService_GetBetCount',
    $urlDomainPath.'api/bet/count-by-status' => 'BetService_GetBetCountByStatus',

    // Bet Types API
    $urlDomainPath.'api/bet-type/create' => 'BetTypeService_CreateBetType',
    $urlDomainPath.'api/bet-type/update' => 'BetTypeService_UpdateBetType',
    $urlDomainPath.'api/bet-type/delete' => 'BetTypeService_DeleteBetType',
    $urlDomainPath.'api/bet-type/all' => 'BetTypeService_GetAllBetTypes',
    $urlDomainPath.'api/bet-type/by-category' => 'BetTypeService_GetBetTypesByCategory',

    // Game API
    $urlDomainPath.'api/game/create' => 'GameService_CreateGame',
    $urlDomainPath.'api/game/update' => 'GameService_UpdateGame',
    $urlDomainPath.'api/game/delete' => 'GameService_DeleteGame',

    $urlDomainPath.'api/game/get-by-id' => 'GameService_GetGameById',
    $urlDomainPath.'api/game/all' => 'GameService_GetAllGames',
    $urlDomainPath.'api/game/by-status' => 'GameService_GetGamesByStatus',
    $urlDomainPath.'api/game/with-admin' => 'GameService_GetGamesWithAdmin',
    $urlDomainPath.'api/game/with-admin-by-id' => 'GameService_GetGameWithAdminById',
    $urlDomainPath.'api/game/with-bets' => 'GameService_GetGamesWithBets',
    $urlDomainPath.'api/game/count' => 'GameService_GetGameCount',
    $urlDomainPath.'api/game/count-by-status' => 'GameService_GetGameCountByStatus',

    // Result API
    $urlDomainPath.'api/result/publish' => 'ResultService_PublishResult',
    $urlDomainPath.'api/result/delete' => 'ResultService_DeleteResult',

    $urlDomainPath.'api/result/get-by-id' => 'ResultService_GetResultById',
    $urlDomainPath.'api/result/by-game' => 'ResultService_GetResultsByGame',
    $urlDomainPath.'api/result/all' => 'ResultService_GetAllResults',
    $urlDomainPath.'api/result/with-numbers' => 'ResultService_GetAllResultsWithNumbers',
    $urlDomainPath.'api/result/with-numbers-by-id' => 'ResultService_GetResultWithNumbersById',
    $urlDomainPath.'api/result/with-numbers-by-game' => 'ResultService_GetResultsWithNumbersByGame',
    $urlDomainPath.'api/result/count' => 'ResultService_GetResultCount',

    // Game Type API
    $urlDomainPath.'api/game-type/all' => 'GameTypeService_GetAllGameTypes',
   
];
RouteHelper::loadRoute($serverHandler->GetRequestUri(),$routes);//load all routes with the load route function
// echo "ddd";
function use404()
{
    // echo "Page Not found";
    // Redirect to the 404 page

    header("HTTP/1.0 404 Not Found");
    header('Location: /kv/404');
}
// standard 404 page
use404();
