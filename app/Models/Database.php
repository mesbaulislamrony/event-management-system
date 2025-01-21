<?php

namespace App\Models;

use \PDO;
use \PDOException;

class Database
{
    private $conn;

    public function connect()
    {
        $config = require __DIR__ . '/../../config/database.php';
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$config['db']['host']};dbname={$config['db']['name']}",
                $config['db']['user'],
                $config['db']['password']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }

        return $this->conn;
    }
}
