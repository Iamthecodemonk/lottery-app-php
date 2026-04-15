<?php

require_once('./services/AdminService.php');

use AdminService\AdminService;
use _Helpers\RouteHelper;

// Get Admin by ID
function AdminService_GetAdminById() {
    RouteHelper::get(function () {
        AdminService::GetAdminById();
    });
}

// Get Admin by Email
function AdminService_GetAdminByEmail() {
    RouteHelper::get(function () {
        AdminService::GetAdminByEmail();
    });
}

// Get All Admins
function AdminService_GetAllAdmins() {
    RouteHelper::get(function () {
        AdminService::GetAllAdmins();
    });
}

// Get Admins With Games
function AdminService_GetAdminsWithGames() {
    RouteHelper::get(function () {
        AdminService::GetAdminsWithGames();
    });
}

// Get Admin Count
function AdminService_GetAdminCount() {
    RouteHelper::get(function () {
        AdminService::GetAdminCount();
    });
}
