<?php

require_once('./services/AgentService.php');

use AgentService\AgentService;
use _Helpers\RouteHelper;

// Get Agent by ID
function AgentService_GetAgentById() {
    RouteHelper::get(function () {
        AgentService::GetAgentById();
    });
}

// Get Agent by Email
function AgentService_GetAgentByEmail() {
    RouteHelper::get(function () {
        AgentService::GetAgentByEmail();
    });
}

// Get All Agents
function AgentService_GetAllAgents() {
    RouteHelper::get(function () {
        AgentService::GetAllAgents();
    });
}

// Get Agents With Bets
function AgentService_GetAgentsWithBets() {
    RouteHelper::get(function () {
        AgentService::GetAgentsWithBets();
    });
}

// Get Agent With Bets By ID
function AgentService_GetAgentWithBetsById() {
    RouteHelper::get(function () {
        AgentService::GetAgentWithBetsById();
    });
}

// Get Agent Count
function AgentService_GetAgentCount() {
    RouteHelper::get(function () {
        AgentService::GetAgentCount();
    });
}

// Get Suspended Agent Count
function AgentService_GetSuspendedAgentCount() {
    RouteHelper::get(function () {
        AgentService::GetSuspendedAgentCount();
    });
}

// Get Agent Transactions
function AgentService_GetAgentTransactions() {
    RouteHelper::get(function () {
        AgentService::GetAgentTransactions();
    });
}

// Get all agent transactions
function AgentService_GetAllAgentTransactions() {
    RouteHelper::get(function () {
        AgentService::GetAllAgentTransactions();
    });
}
