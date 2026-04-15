<?php

namespace ResultService;

use PDOException;

require_once('./bootstrap.php');
require_once('./models/Result.php');
require_once('./models/ResultDetail.php');
require_once __DIR__ . '/../vendor/autoload.php';

use Result\Result;
use ResultDetail\ResultDetail;

use _Helpers\ToolHelper;
use _Helpers\ServerHandler;

use Exception;

class ResultService
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

    // Publish Result (Admin flow)
    public static function PublishResult()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_POST)) {
            $data = $_POST;
        }

        $gameId = trim((string) ($data['game_id'] ?? ''));
        $resultId = trim((string) ($data['result_id'] ?? ('RES-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8)))));

        $winningNumbers = $data['winning_numbers'] ?? [];
        $machineNumbers = $data['machine_numbers'] ?? [];

        if (is_string($winningNumbers)) {
            $winningNumbers = array_filter(array_map('trim', explode(',', $winningNumbers)));
        }
        if (is_string($machineNumbers)) {
            $machineNumbers = array_filter(array_map('trim', explode(',', $machineNumbers)));
        }

        if (empty($winningNumbers) || empty($machineNumbers)) {
            return self::$toolHelper->ReportBox(false, 'Missing required information.', 400);
        }

        if (count($winningNumbers) !== 5 || count($machineNumbers) !== 5) {
            return self::$toolHelper->ReportBox(false, 'You must provide exactly 5 winning numbers and 5 machine numbers.', 400);
        }

        $validatedWinning = [];
        foreach ($winningNumbers as $entry) {
            if (!is_array($entry)) {
                return self::$toolHelper->ReportBox(false, 'Winning numbers must include game_id for each number.', 400);
            }
            $number = $entry['number'] ?? null;
            $gameId = $entry['game_id'] ?? ($entry['game_type_id'] ?? null);
            if (!is_numeric($number) || !$gameId) {
                return self::$toolHelper->ReportBox(false, 'Winning numbers must be numeric and have a game.', 400);
            }
            $validatedWinning[] = [
                'number' => (int) $number,
                'game_id' => (string) $gameId,
            ];
        }

        $validatedMachine = [];
        foreach ($machineNumbers as $entry) {
            if (!is_array($entry)) {
                return self::$toolHelper->ReportBox(false, 'Machine numbers must include game_id for each number.', 400);
            }
            $number = $entry['number'] ?? null;
            $gameId = $entry['game_id'] ?? ($entry['game_type_id'] ?? null);
            if (!is_numeric($number) || !$gameId) {
                return self::$toolHelper->ReportBox(false, 'Machine numbers must be numeric and have a game.', 400);
            }
            $validatedMachine[] = [
                'number' => (int) $number,
                'game_id' => (string) $gameId,
            ];
        }

        // Pair winning/machine entries by index (position) and require a game for each.
        if (count($validatedWinning) !== 5 || count($validatedMachine) !== 5) {
            return self::$toolHelper->ReportBox(false, 'You must provide exactly 5 winning numbers and 5 machine numbers.', 400);
        }

        $resultDetails = [];
        for ($i = 0; $i < 5; $i++) {
            $w = $validatedWinning[$i];
            $m = $validatedMachine[$i];

            $gameId = $w['game_id'] ?? $m['game_id'] ?? null;
            if (!$gameId) {
                return self::$toolHelper->ReportBox(false, 'Each entry must include a game id.', 400);
            }

            $resultDetails[] = [
                'game_id' => (string) $gameId,
                'winning_number' => $w['number'],
                'machine_number' => $m['number'],
            ];
        }

        $normalizedGameId = $gameId !== '' ? $gameId : null;
        $publish = Result::publish($resultId, $normalizedGameId, $resultDetails);
        if (!empty($publish['success'])) {
            return self::$toolHelper->ReportBox(true, [
                'message' => 'Result published successfully.',
                'result_id' => $resultId,
                'game_id' => $normalizedGameId,
                'winning_numbers' => array_values($validatedWinning),
                'machine_numbers' => array_values($validatedMachine),
            ], 201);
        }

        $errorMessage = 'Failed to publish result.';
        if (!empty($publish['error'])) {
            $errorMessage = 'Failed to publish result: ' . $publish['error'];
        }

        return self::$toolHelper->ReportBox(false, $errorMessage, 500);
    }

    public static function GetResultById()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $resultId = $data['result_id'] ?? null;
        if (!$resultId) {
            return self::$toolHelper->ReportBox(false, 'Missing result ID.', 400);
        }

        $result = Result::getById($resultId);
        if (empty($result)) {
            return self::$toolHelper->ReportBox(false, 'Result not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $result, 200);
    }

    public static function GetResultsByGame()
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

        $results = Result::getByGameId($gameId);
        if (empty($results)) {
            return self::$toolHelper->ReportBox(false, 'No results found for this game.', 404);
        }

        return self::$toolHelper->ReportBox(true, $results, 200);
    }

    public static function GetAllResults()
    {
        self::init();
        $results = Result::getAll();
        if (empty($results)) {
            return self::$toolHelper->ReportBox(false, 'No results found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $results, 200);
    }

    public static function GetAllResultsWithNumbers()
    {
        self::init();
        $results = Result::getAllWithNumbers();
        if (empty($results)) {
            return self::$toolHelper->ReportBox(false, 'No results found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $results, 200);
    }

    public static function GetResultWithNumbersById()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        if (empty($data) && !empty($_GET)) {
            $data = $_GET;
        }

        $resultId = $data['result_id'] ?? null;
        if (!$resultId) {
            return self::$toolHelper->ReportBox(false, 'Missing result ID.', 400);
        }

        $result = Result::getByIdWithNumbers($resultId);
        if (empty($result)) {
            return self::$toolHelper->ReportBox(false, 'Result not found.', 404);
        }

        return self::$toolHelper->ReportBox(true, $result, 200);
    }

    public static function GetResultsWithNumbersByGame()
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

        $results = Result::getByGameIdWithNumbers($gameId);
        if (empty($results)) {
            return self::$toolHelper->ReportBox(false, 'No results found for this game.', 404);
        }

        return self::$toolHelper->ReportBox(true, $results, 200);
    }

    public static function DeleteResult()
    {
        self::init();
        $data = ServerHandler::UseJSON() ?? [];
        $resultId = $data['result_id'] ?? null;

        if (!$resultId) {
            return self::$toolHelper->ReportBox(false, 'Missing result ID.', 400);
        }

        $numbersDeleted = ResultDetail::deleteByResultId($resultId);
        $result = Result::delete($resultId);

        if ($numbersDeleted && $result) {
            return self::$toolHelper->ReportBox(true, 'Result deleted successfully.', 200);
        }
        return self::$toolHelper->ReportBox(false, 'Failed to delete result.', 500);
    }

    public static function GetResultCount()
    {
        self::init();
        $count = Result::countAll();
        return self::$toolHelper->ReportBox(true, ['count' => $count], 200);
    }
}
