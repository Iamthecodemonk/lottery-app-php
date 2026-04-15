<?php

require_once('./services/AgentService.php');

use AgentService\AgentService;
use _Helpers\RouteHelper;

// Create Agent
function AgentService_CreateAgent() {
    RouteHelper::post(function () {
        AgentService::CreateAgent();
    });
}

// Login Agent
function AgentService_LoginAgent() {
    RouteHelper::post(function () {
        AgentService::LoginAgent();
    });
}

// Logout Agent
function AgentService_LogoutAgent() {
    RouteHelper::post(function () {
        AgentService::LogoutAgent();
    });
}

// Update Agent
function AgentService_UpdateAgent() {
    RouteHelper::post(function () {
        AgentService::UpdateAgent();
    });
}

// Suspend Agent
function AgentService_SuspendAgent() {
    RouteHelper::post(function () {
        AgentService::SuspendAgent();
    });
}

// Delete Agent
function AgentService_DeleteAgent() {
    RouteHelper::post(function () {
        AgentService::DeleteAgent();
    });
}

// Credit Agent Balance
function AgentService_CreditAgent() {
    RouteHelper::post(function () {
        AgentService::CreditAgent();
    });
}

// Debit Agent Balance
function AgentService_DebitAgent() {
    RouteHelper::post(function () {
        AgentService::DebitAgent();
    });
}
