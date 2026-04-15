<?php

namespace AdminService;

use PDOException;

require_once('./bootstrap.php');
require_once('./models/Admin.php');
require_once __DIR__ . '/../vendor/autoload.php';

use Admin\Admin;

use _Helpers\ToolHelper;
use _Helpers\ServerHandler;
use _Helpers\JWT;

use Exception;

class AdminService
{
    protected static ToolHelper $toolHelper;
    protected static JWT $jwt;
    protected static bool $initialized = false;

    public static function init()
    {
        if (!self::$initialized) {
            self::$toolHelper = new ToolHelper();
            self::$jwt = new JWT();
            self::$initialized = true;
        }
    }

    public static function CreateAdmin()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        $id = trim((string) ($data['id'] ?? ('ADMIN-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)))));
        $name = trim((string) ($data['name'] ?? ''));
        $email = trim((string) ($data['email'] ?? ''));
        $password = trim((string) ($data['password'] ?? ''));

        if (!$id || !$name || !$email || !$password) {
            return self::$toolHelper->ReportBox(false, 'Missing required information.', 400);
        }

        $existing = Admin::getByEmail($email);
        if (!empty($existing)) {
            return self::$toolHelper->ReportBox(false, 'Admin with this email already exists.', 409);
        }

        try {
            $result = Admin::create($id, $name, $email, $password);
            if ($result) {
                return self::$toolHelper->ReportBox(true, [
                    'message' => 'Admin created successfully.',
                    'admin_id' => $id,
                ], 201);
            }
            return self::$toolHelper->ReportBox(false, 'Failed to create admin.', 500);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                return self::$toolHelper->ReportBox(false, 'Admin with this email already exists.', 409);
            }
            return self::$toolHelper->ReportBox(false, 'Failed to create admin.', 500);
        }
    }

    public static function LoginAdmin()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        $email = trim((string) ($data['email'] ?? ''));
        $password = trim((string) ($data['password'] ?? ''));

        if (!$email || !$password) {
            return self::$toolHelper->ReportBox(false, 'Missing required information.', 400);
        }

        $admins = Admin::authenticate($email, $password);
        if (empty($admins)) {
            return self::$toolHelper->ReportBox(false, 'Invalid admin credentials.', 401);
        }

        $admin = $admins[0];

        $token = self::$jwt->encodeJWT([
            'id' => $admin['id'] ?? null,
            'email' => $admin['email'] ?? $email,
            'role' => 'admin',
            'name' => $admin['name'] ?? null,
        ]);

        $isSecure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        setcookie('admin_token', $token, [
            'expires' => time() + (60 * 60),
            'path' => '/',
            'secure' => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        return self::$toolHelper->ReportBox(true, [
            'message' => 'Admin login successful.',
            'admin' => $admin,
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in_minutes' => 60
        ], 200);
    }

    public static function LogoutAdmin()
    {
        self::init();

        $isSecure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        // Clear admin cookies for browser sessions.
        setcookie('admin_token', '', [
            'expires' => time() - 3600,
            'path' => '/',
            'secure' => $isSecure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        // setcookie('token', '', [
        //     'expires' => time() - 3600,
        //     'path' => '/',
        //     'secure' => $isSecure,
        //     'httponly' => true,
        //     'samesite' => 'Lax',
        // ]);

        // JWT is stateless; client should discard token.
        return self::$toolHelper->ReportBox(true, 'Admin logout successful.', 200);
    }

    public static function GetAdminById()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $adminId = $data['admin_id'] ?? null;
        if (!$adminId) {
            return self::$toolHelper->ReportBox(false, 'Missing admin ID.', 400);
        }

        $admin = Admin::getById($adminId);
        if (empty($admin)) {
            return self::$toolHelper->ReportBox(false, 'Admin not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $admin, 200);
    }

    public static function GetAdminByEmail()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $email = $data['email'] ?? null;
        if (!$email) {
            return self::$toolHelper->ReportBox(false, 'Missing email.', 400);
        }

        $admin = Admin::getByEmail($email);
        if (empty($admin)) {
            return self::$toolHelper->ReportBox(false, 'Admin not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $admin, 200);
    }

    public static function GetAllAdmins()
    {
        self::init();
        $admins = Admin::getAll();
        if (empty($admins)) {
            return self::$toolHelper->ReportBox(false, 'No admins found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $admins, 200);
    }

    public static function GetAdminsWithGames()
    {
        self::init();
        $admins = Admin::getAllWithGames();
        if (empty($admins)) {
            return self::$toolHelper->ReportBox(false, 'No admins found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $admins, 200);
    }

    public static function UpdateAdmin()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];

        $adminId = $data['admin_id'] ?? null;
        if (!$adminId) {
            return self::$toolHelper->ReportBox(false, 'Missing admin ID.', 400);
        }

        $updateData = [];
        if (isset($data['name'])) $updateData['name'] = $data['name'];
        if (isset($data['email'])) $updateData['email'] = $data['email'];
        if (isset($data['password'])) $updateData['password'] = $data['password'];

        if (empty($updateData)) {
            return self::$toolHelper->ReportBox(false, 'No data to update.', 400);
        }

        $result = Admin::update($adminId, $updateData);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Admin updated successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to update admin.', 500);
    }

    public static function DeleteAdmin()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];

        $adminId = $data['admin_id'] ?? null;
        if (!$adminId) {
            return self::$toolHelper->ReportBox(false, 'Missing admin ID.', 400);
        }

        $result = Admin::delete($adminId);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Admin deleted successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to delete admin.', 500);
    }

    public static function GetAdminCount()
    {
        self::init();
        $count = Admin::countAll();
        return self::$toolHelper->ReportBox(true, ['count' => $count], 200);
    }
}
