<?php

require_once('./services/BetService.php');

use BetService\BetService;
use _Helpers\RouteHelper;

// Create Bet
function BetService_CreateBet() {
    RouteHelper::post(function () {
        BetService::CreateBet();
    });
}

// Update Bet
function BetService_UpdateBet() {
    RouteHelper::post(function () {
        BetService::UpdateBet();
    });
}

// Delete Bet
function BetService_DeleteBet() {
    RouteHelper::post(function () {
        BetService::DeleteBet();
    });
}
