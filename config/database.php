<?php
class Database {
    private static $pdo = null;

    private function __construct() {}

    public static function getConnection() {
        if (self::$pdo === null) {
            $host = 'autorack.proxy.rlwy.net';
            $db = 'railway';
            $user = 'root';
            $pass = 'UUpQHwzjgIwufwXJSGrswXAhvlVkPibH';
            $port = '58897';
            $charset = 'utf8mb4';
            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
                self::$pdo->exec("SET time_zone = 'America/Asuncion';"); // Ajusta a tu zona horaria
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$pdo;
    }
}
	