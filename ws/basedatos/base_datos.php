<?php

class Database
{
    private $host = 'localhost';
    private $dbname = 'monfab';
    private $username = 'root';
    private $password = '';
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $e->getMessage()]);
            exit;
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
?>