<?php

require_once('./services/GameService.php');

use GameService\GameService;
use _Helpers\RouteHelper;

// Create Game
function GameService_CreateGame() {
    RouteHelper::post(function () {
        GameService::CreateGame();
    });
}

// Update Game
function GameService_UpdateGame() {
    RouteHelper::post(function () {
        GameService::UpdateGame();
    });
}

// Delete Game
function GameService_DeleteGame() {
    RouteHelper::post(function () {
        GameService::DeleteGame();
    });
}
