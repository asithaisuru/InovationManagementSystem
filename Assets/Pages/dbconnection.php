<?php
require_once __DIR__ . '/../../vendor/autoload.php';
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
// $dotenv->load();

// // Database connection
// $connection = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
// if (!$connection) {
//     die("Connection failed: " . mysqli_connect_error());
// }
class DBConnection {
    private $connection;

    public function __construct() {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->connection = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}

$dbConnection = new DBConnection();
$connection = $dbConnection->getConnection();