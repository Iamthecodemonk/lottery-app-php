<?php

require_once('./services/BetService.php');

use BetService\BetService;
use _Helpers\RouteHelper;

// Get Bet by ID
function BetService_GetBetById() {
    RouteHelper::get(function () {
        BetService::GetBetById();
    });
}

// Get All Bets
function BetService_GetAllBets() {
    RouteHelper::get(function () {
        BetService::GetAllBets();
    });
}

// Get Bets by Agent
function BetService_GetBetsByAgent() {
    RouteHelper::get(function () {
        BetService::GetBetsByAgent();
    });
}

// Get Bets by Game
function BetService_GetBetsByGame() {
    RouteHelper::get(function () {
        BetService::GetBetsByGame();
    });
}

// Get Bets by Status
function BetService_GetBetsByStatus() {
    RouteHelper::get(function () {
        BetService::GetBetsByStatus();
    });
}

// Get All Bets With Details
function BetService_GetAllBetsWithDetails() {
    RouteHelper::get(function () {
        BetService::GetAllBetsWithDetails();
    });
}

// Get Bet With Details By ID
function BetService_GetBetWithDetailsById() {
    RouteHelper::get(function () {
        BetService::GetBetWithDetailsById();
    });
}

// Get All Bets With Numbers
function BetService_GetAllBetsWithNumbers() {
    RouteHelper::get(function () {
        BetService::GetAllBetsWithNumbers();
    });
}

// Get Bets With Numbers By Agent
function BetService_GetBetsWithNumbersByAgent() {
    RouteHelper::get(function () {
        BetService::GetBetsWithNumbersByAgent();
    });
}

// Get Bet Types
function BetService_GetBetTypes() {
    RouteHelper::get(function () {
        BetService::GetBetTypes();
    });
}

// Get Bet Types By Category
function BetService_GetBetTypesByCategory() {
    RouteHelper::get(function () {
        BetService::GetBetTypesByCategory();
    });
}

// Get Bet Count
function BetService_GetBetCount() {
    RouteHelper::get(function () {
        BetService::GetBetCount();
    });
}

// Get Bet Count By Status
function BetService_GetBetCountByStatus() {
    RouteHelper::get(function () {
        BetService::GetBetCountByStatus();
    });
}
