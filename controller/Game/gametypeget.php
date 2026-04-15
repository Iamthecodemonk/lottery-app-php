<?php

require_once('./services/GameTypeService.php');

use GameTypeService\GameTypeService;
use _Helpers\RouteHelper;

function GameTypeService_GetAllGameTypes()
{
    RouteHelper::get(function () {
        GameTypeService::GetAllGameTypes();
    });
}
