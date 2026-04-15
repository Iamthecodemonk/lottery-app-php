<?php

namespace BetTypeService;

use PDOException;

require_once('./bootstrap.php');
require_once('./models/BetType.php');
require_once __DIR__ . '/../vendor/autoload.php';

use BetType\BetType;

use _Helpers\ToolHelper;
use _Helpers\ServerHandler;

class BetTypeService
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

    public static function CreateBetType()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        $id = trim((string) ($data['id'] ?? ('BT-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)))));
        $name = trim((string) ($data['name'] ?? ''));
        $category = trim((string) ($data['category'] ?? ''));

        if (!$id || !$name || !$category) {
            return self::$toolHelper->ReportBox(false, 'Missing required information.', 400);
        }

        try {
            $result = BetType::create($id, $name, $category);
            if ($result) {
                return self::$toolHelper->ReportBox(true, [
                    'message' => 'Bet type created successfully.',
                    'bet_type_id' => $id,
                ], 201);
            }
            return self::$toolHelper->ReportBox(false, 'Failed to create bet type.', 500);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                return self::$toolHelper->ReportBox(false, 'Bet type with this ID already exists.', 409);
            }
            return self::$toolHelper->ReportBox(false, 'Failed to create bet type.', 500);
        }
    }

    public static function GetAllBetTypes()
    {
        self::init();
        $types = BetType::getAll();
        if (empty($types)) {
            return self::$toolHelper->ReportBox(false, 'No bet types found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $types, 200);
    }

    public static function GetBetTypesByCategory()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $category = strtolower(trim((string) ($data['category'] ?? '')));
        if (!$category) {
            return self::$toolHelper->ReportBox(false, 'Missing category.', 400);
        }

        if ($category === 'lotto') {
            $all = BetType::getAll();
            $types = array_values(array_filter($all, function ($row) {
                $value = strtolower(trim((string) ($row['category'] ?? '')));
                return $value === '' || $value === 'lotto' || $value === 'placebet';
            }));
        } else {
            $types = BetType::getByCategory($category);
        }

        if (empty($types)) {
            return self::$toolHelper->ReportBox(false, 'No bet types found for this category.', 404);
        }

        return self::$toolHelper->ReportBox(true, $types, 200);
    }

    public static function UpdateBetType()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];

        $betTypeId = $data['bet_type_id'] ?? null;
        if (!$betTypeId) {
            return self::$toolHelper->ReportBox(false, 'Missing bet type ID.', 400);
        }

        $updateData = [];
        if (isset($data['name'])) $updateData['name'] = $data['name'];
        if (isset($data['category'])) $updateData['category'] = $data['category'];

        if (empty($updateData)) {
            return self::$toolHelper->ReportBox(false, 'No data to update.', 400);
        }

        $result = BetType::update($betTypeId, $updateData);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Bet type updated successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to update bet type.', 500);
    }

    public static function DeleteBetType()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        $betTypeId = $data['bet_type_id'] ?? null;

        if (!$betTypeId) {
            return self::$toolHelper->ReportBox(false, 'Missing bet type ID.', 400);
        }

        $result = BetType::delete($betTypeId);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Bet type deleted successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to delete bet type.', 500);
    }
}
