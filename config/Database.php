<?php

function loadEnv($path)
{
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) continue;

        // Split by the first "=" found
        list($name, $value) = explode('=', $line, 2);

        $name = trim($name);
        $value = trim($value);

        // Put into environment and $_ENV superglobal
        putenv(sprintf('%s=%s', $name, $value));
        $_ENV[$name] = $value;
    }
}

class Database
{
    private static $instance = null;
    private $dbConnection;

    // Private constructor to prevent direct instantiation
    private function __construct()
    {
        $envPath = __DIR__ . '/../.env';
        if (file_exists($envPath)) {
            loadEnv($envPath);
        }

        // Use null coalescing to prevent errors if keys are missing
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $dbname = $_ENV['DB_NAME'] ?? '';
        $username = $_ENV['DB_USER'] ?? '';
        $password = $_ENV['DB_PASS'] ?? '';

        try {
            $this->dbConnection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

    // Singleton pattern to get the same instance of the connection
    public static function getConnection()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->dbConnection;
    }
}
