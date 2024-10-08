<?php
class Database {
    private static $pdo = null;

    private function __construct() {}

    public static function getConnection() {
        if (self::$pdo === null) {
            $host = 'ewr1.clusters.zeabur.com';
            $db = 'zeabur';
            $user = 'root';
            $pass = 'SMvp0xu4Ccw5Ist7r9THyfqU81263KXE';
            $port = '32080';
            $charset = 'utf8mb4';
            $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        return self::$pdo;
    }
}
?>
