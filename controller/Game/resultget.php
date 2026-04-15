<?php

require_once('./services/ResultService.php');

use ResultService\ResultService;
use _Helpers\RouteHelper;

// Get Result by ID
function ResultService_GetResultById() {
    RouteHelper::get(function () {
        ResultService::GetResultById();
    });
}

// Get Results by Game
function ResultService_GetResultsByGame() {
    RouteHelper::get(function () {
        ResultService::GetResultsByGame();
    });
}

// Get All Results
function ResultService_GetAllResults() {
    RouteHelper::get(function () {
        ResultService::GetAllResults();
    });
}

// Get All Results With Numbers
function ResultService_GetAllResultsWithNumbers() {
    RouteHelper::get(function () {
        ResultService::GetAllResultsWithNumbers();
    });
}

// Get Result With Numbers By ID
function ResultService_GetResultWithNumbersById() {
    RouteHelper::get(function () {
        ResultService::GetResultWithNumbersById();
    });
}

// Get Results With Numbers By Game
function ResultService_GetResultsWithNumbersByGame() {
    RouteHelper::get(function () {
        ResultService::GetResultsWithNumbersByGame();
    });
}

// Get Result Count
function ResultService_GetResultCount() {
    RouteHelper::get(function () {
        ResultService::GetResultCount();
    });
}
