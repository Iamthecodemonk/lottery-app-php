<?php

namespace Database;

class Database {
    private static ?Database $instance = null;
    private \PDO $connection;

    private function __construct($dsn, $username, $password) {
        try {
            $this->connection = new \PDO($dsn, $username, $password);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Error connecting to the database: " . $e->getMessage());
        }
    }

    public static function getInstance($dsn = null, $username = null, $password = null) {
        if (self::$instance === null) {
            if (!$dsn || !$username) {
                $credentials = require(__DIR__ . "/db_credentials.php");
                $dsn = $credentials['dsn'];
                $username = $credentials['username'];
                $password = $credentials['password'];
            }
            self::$instance = new self($dsn, $username, $password);
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
