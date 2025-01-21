<?php

namespace App\Models;

use \PDO;

class SessionManager
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function open($savePath, $sessionName)
    {
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($id)
    {
        print_r($id);
        exit;
        $query = "SELECT data FROM sessions WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['data'] : '';
    }

    public function write($id, $data)
    {
        $query = "REPLACE INTO sessions (id, user_id, data, last_activity) VALUES (:id, :user_id, :data, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $_SESSION['user_id'] ?? null);
        $stmt->bindParam(':data', $data);
        return $stmt->execute();
    }

    public function destroy($id)
    {
        $query = "DELETE FROM sessions WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function gc($maxLifetime)
    {
        $query = "DELETE FROM sessions WHERE last_activity < (NOW() - INTERVAL :max_lifetime SECOND)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':max_lifetime', $maxLifetime, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
