<?php
class Database {
    private static $host = 'localhost';
    private static $dbName = 'api-opena';
    private static $username = 'root';
    private static $password = '';

    public static function getConnection() {
        try {
            $conn = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbName,
                self::$username,
                self::$password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die(json_encode(['error' => 'Conexión fallida: ' . $e->getMessage()]));
        }
    }
}
