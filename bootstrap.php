<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('./_Helpers.php');
require_once('./db/db_credentials.php');
require_once('./db/Database.php');
require_once('./src/paystack/src/autoload.php');

// use PDOException;
