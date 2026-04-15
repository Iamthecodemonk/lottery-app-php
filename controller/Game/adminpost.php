<?php

require_once('./services/AdminService.php');

use AdminService\AdminService;
use _Helpers\RouteHelper;

// Create Admin
function AdminService_CreateAdmin() {
    RouteHelper::post(function () {
        AdminService::CreateAdmin();
    });
}

// Login Admin
function AdminService_LoginAdmin() {
    RouteHelper::post(function () {
        AdminService::LoginAdmin();
    });
}

// Logout Admin
function AdminService_LogoutAdmin() {
    RouteHelper::post(function () {
        AdminService::LogoutAdmin();
    });
}

// Update Admin
function AdminService_UpdateAdmin() {
    RouteHelper::post(function () {
        AdminService::UpdateAdmin();
    });
}

// Delete Admin
function AdminService_DeleteAdmin() {
    RouteHelper::post(function () {
        AdminService::DeleteAdmin();
    });
}
