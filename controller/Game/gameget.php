<?php

require_once('./services/GameService.php');

use GameService\GameService;
use _Helpers\RouteHelper;

// Get Game by ID
function GameService_GetGameById() {
    RouteHelper::get(function () {
        GameService::GetGameById();
    });
}

// Get All Games
function GameService_GetAllGames() {
    RouteHelper::get(function () {
        GameService::GetAllGames();
    });
}

// Get Games by Status
function GameService_GetGamesByStatus() {
    RouteHelper::get(function () {
        GameService::GetGamesByStatus();
    });
}

// Get Games With Admin
function GameService_GetGamesWithAdmin() {
    RouteHelper::get(function () {
        GameService::GetGamesWithAdmin();
    });
}

// Get Game With Admin By ID
function GameService_GetGameWithAdminById() {
    RouteHelper::get(function () {
        GameService::GetGameWithAdminById();
    });
}

// Get Games With Bets
function GameService_GetGamesWithBets() {
    RouteHelper::get(function () {
        GameService::GetGamesWithBets();
    });
}

// Get Game Count
function GameService_GetGameCount() {
    RouteHelper::get(function () {
        GameService::GetGameCount();
    });
}

// Get Game Count By Status
function GameService_GetGameCountByStatus() {
    RouteHelper::get(function () {
        GameService::GetGameCountByStatus();
    });
}
