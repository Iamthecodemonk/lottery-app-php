<?php

namespace GameTypeService;

require_once('./bootstrap.php');
require_once('./models/GameType.php');

use GameType\GameType;
use _Helpers\ToolHelper;

class GameTypeService
{
    protected static ToolHelper $toolHelper;
    protected static bool $initialized = false;

    public static function init()
    {
        if (!self::$initialized) {
            self::$toolHelper = new ToolHelper();
            self::$initialized = true;
        }
    }

    public static function GetAllGameTypes()
    {
        self::init();
        $types = GameType::getAll();
        if (empty($types)) {
            return self::$toolHelper->ReportBox(false, 'No game types found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $types, 200);
    }
}
