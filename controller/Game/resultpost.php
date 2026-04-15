<?php

require_once('./services/ResultService.php');

use ResultService\ResultService;
use _Helpers\RouteHelper;

// Publish Result
function ResultService_PublishResult() {
    RouteHelper::post(function () {
        ResultService::PublishResult();
    });
}

// Delete Result
function ResultService_DeleteResult() {
    RouteHelper::post(function () {
        ResultService::DeleteResult();
    });
}
