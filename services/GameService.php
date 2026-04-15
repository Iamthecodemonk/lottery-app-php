<?php

namespace GameService;

use PDOException;

require_once('./bootstrap.php');
require_once('./models/Game.php');
require_once __DIR__ . '/../vendor/autoload.php';

use Game\Game;

use _Helpers\ToolHelper;
use _Helpers\ServerHandler;
use _Helpers\SessionService;

use Exception;

class GameService
{
    protected static ToolHelper $toolHelper;
    protected static SessionService $sessionService;
    protected static bool $initialized = false;

    public static function init()
    {
        if (!self::$initialized) {
            self::$toolHelper = new ToolHelper();
            self::$sessionService = new SessionService();
            self::$initialized = true;
        }
    }

    public static function CreateGame()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        $id = trim((string) ($data['id'] ?? ('GAME-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)))));
        $gameName = trim((string) ($data['game_name'] ?? ''));
        $category = trim((string) ($data['category'] ?? ''));
        $status = trim((string) ($data['status'] ?? 'active'));
        $cutoffTime = $data['cutoff_time'] ?? null;
        $createdBy = $data['created_by'] ?? null;

        if (!$id || !$gameName || !$category) {
            return self::$toolHelper->ReportBox(false, 'Missing required information.', 400);
        }

        try {
            $result = Game::create($id, $gameName, $category, $status, $cutoffTime, $createdBy);
            if ($result) {
                return self::$toolHelper->ReportBox(true, [
                    'message' => 'Game created successfully.',
                    'game_id' => $id,
                ], 201);
            }
            return self::$toolHelper->ReportBox(false, 'Failed to create game.', 500);
        } catch (PDOException $e) {
            return self::$toolHelper->ReportBox(false, 'Failed to create game.', 500);
        }
    }

    public static function GetGameById()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $gameId = $data['game_id'] ?? null;
        if (!$gameId) {
            return self::$toolHelper->ReportBox(false, 'Missing game ID.', 400);
        }

        $game = Game::getById($gameId);
        if (empty($game)) {
            return self::$toolHelper->ReportBox(false, 'Game not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $game, 200);
    }

    public static function GetAllGames()
    {
        self::init();
        $games = Game::getAll();
        if (empty($games)) {
            return self::$toolHelper->ReportBox(false, 'No games found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $games, 200);
    }

    public static function GetGamesByStatus()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $status = $data['status'] ?? null;
        if (!$status) {
            return self::$toolHelper->ReportBox(false, 'Missing status.', 400);
        }

        $games = Game::getByStatus($status);
        if (empty($games)) {
            return self::$toolHelper->ReportBox(false, 'No games found with this status.', 404);
        }

        return self::$toolHelper->ReportBox(true, $games, 200);
    }

    public static function GetGamesWithAdmin()
    {
        self::init();
        $games = Game::getAllWithAdmin();
        if (empty($games)) {
            return self::$toolHelper->ReportBox(false, 'No games found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $games, 200);
    }

    public static function GetGameWithAdminById()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $gameId = $data['game_id'] ?? null;
        if (!$gameId) {
            return self::$toolHelper->ReportBox(false, 'Missing game ID.', 400);
        }

        $game = Game::getByIdWithAdmin($gameId);
        if (empty($game)) {
            return self::$toolHelper->ReportBox(false, 'Game not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $game, 200);
    }

    public static function GetGamesWithBets()
    {
        self::init();
        $games = Game::getAllWithBets();
        if (empty($games)) {
            return self::$toolHelper->ReportBox(false, 'No games found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $games, 200);
    }

    public static function UpdateGame()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];

        $gameId = $data['game_id'] ?? null;
        if (!$gameId) {
            return self::$toolHelper->ReportBox(false, 'Missing game ID.', 400);
        }

        $updateData = [];
        if (isset($data['game_name'])) $updateData['game_name'] = $data['game_name'];
        if (isset($data['category'])) $updateData['category'] = $data['category'];
        if (isset($data['status'])) $updateData['status'] = $data['status'];
        if (array_key_exists('cutoff_time', $data)) $updateData['cutoff_time'] = $data['cutoff_time'];
        if (isset($data['created_by'])) $updateData['created_by'] = $data['created_by'];

        if (empty($updateData)) {
            return self::$toolHelper->ReportBox(false, 'No data to update.', 400);
        }

        $result = Game::update($gameId, $updateData);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Game updated successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to update game.', 500);
    }

    public static function DeleteGame()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        $gameId = $data['game_id'] ?? null;

        if (!$gameId) {
            return self::$toolHelper->ReportBox(false, 'Missing game ID.', 400);
        }

        $result = Game::delete($gameId);
        if ($result) {
            return self::$toolHelper->ReportBox(true, 'Game deleted successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to delete game.', 500);
    }

    public static function GetGameCount()
    {
        self::init();
        $count = Game::countAll();
        return self::$toolHelper->ReportBox(true, ['count' => $count], 200);
    }

    public static function GetGameCountByStatus()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $status = $data['status'] ?? null;
        if (!$status) {
            return self::$toolHelper->ReportBox(false, 'Missing status.', 400);
        }

        $count = Game::countByStatus($status);
        return self::$toolHelper->ReportBox(true, ['count' => $count], 200);
    }
}
