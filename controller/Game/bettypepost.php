<?php

require_once('./services/BetTypeService.php');

use BetTypeService\BetTypeService;
use _Helpers\RouteHelper;

// Create Bet Type
function BetTypeService_CreateBetType() {
    RouteHelper::post(function () {
        BetTypeService::CreateBetType();
    });
}

// Update Bet Type
function BetTypeService_UpdateBetType() {
    RouteHelper::post(function () {
        BetTypeService::UpdateBetType();
    });
}

// Delete Bet Type
function BetTypeService_DeleteBetType() {
    RouteHelper::post(function () {
        BetTypeService::DeleteBetType();
    });
}
