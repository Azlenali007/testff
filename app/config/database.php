<?php
/**
 * Database Connection Helper (PDO Singleton)
 * N.A Fresh Fruits & Coconuts
 */

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 5,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                throw new Exception("Unable to connect to MySQL database. Please verify MySQL service and credentials.");
            }
        }
        return self::$instance;
    }

    public static function resetConnection(): void {
        self::$instance = null;
    }

    public static function testConnection(string $host, string $port, string $dbname, string $user, string $pass, bool $createDb = false): array {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 5
        ];

        // 1. First test host/auth connection without DB name
        try {
            $dsnNoDb = "mysql:host={$host};port={$port};charset=utf8mb4";
            $pdoRoot = new PDO($dsnNoDb, $user, $pass, $options);
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            // Sanitize message to never show raw password
            $safeMsg = preg_replace('/(using password: )(YES|NO)/i', '$1[PROTECTED]', $msg);
            return [
                'success' => false,
                'error' => "Connection failed: " . $safeMsg,
                'db_exists' => false
            ];
        }

        // 2. Check if database exists
        $dbCreated = false;
        try {
            $stmt = $pdoRoot->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
            $stmt->execute([$dbname]);
            $exists = (bool)$stmt->fetchColumn();

            if (!$exists && $createDb) {
                $pdoRoot->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $dbCreated = true;
                $exists = true;
            } elseif (!$exists) {
                return [
                    'success' => false,
                    'error' => "Database '{$dbname}' does not exist on MySQL server. Please create it or enable 'Attempt to create database'.",
                    'db_exists' => false
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => "Database verification error: " . $e->getMessage(),
                'db_exists' => false
            ];
        }

        // 3. Connect to the actual database
        try {
            $dsnWithDb = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
            new PDO($dsnWithDb, $user, $pass, $options);
            return [
                'success' => true,
                'error' => null,
                'db_exists' => true,
                'db_created' => $dbCreated
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => "Connected to MySQL host, but cannot access database '{$dbname}'. Ensure user has appropriate permissions.",
                'db_exists' => true
            ];
        }
    }

    public static function isReady(): bool {
        try {
            $pdo = self::getConnection();
            $stmt = $pdo->query("SHOW TABLES LIKE 'products'");
            return (bool)$stmt->fetchColumn();
        } catch (Exception $e) {
            return false;
        }
    }
}
