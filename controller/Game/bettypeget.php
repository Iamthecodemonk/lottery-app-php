<?php

require_once('./services/BetTypeService.php');

use BetTypeService\BetTypeService;
use _Helpers\RouteHelper;

// Get All Bet Types
function BetTypeService_GetAllBetTypes() {
    RouteHelper::get(function () {
        BetTypeService::GetAllBetTypes();
    });
}

// Get Bet Types By Category
function BetTypeService_GetBetTypesByCategory() {
    RouteHelper::get(function () {
        BetTypeService::GetBetTypesByCategory();
    });
}
