<?php
require_once('./_Helpers.php');
require_once('./middleware/middleware.php');

use Middleware\Middleware;
use _Helpers\Router;

function useHomePage()
{
    $current = Middleware::currentJwtUser();
    if (!empty($current['role'])) {
        if ($current['role'] === 'admin') {
            header('Location: /lt/admin');
            exit();
        }
        if ($current['role'] === 'agent') {
            header('Location: /lt/agent');
            exit();
        }
    }

    Router::SetPage('home');
}
