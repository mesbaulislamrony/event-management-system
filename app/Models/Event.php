<?php

namespace App\Models;

use Carbon\Carbon;
use PDO;

class Event
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($array)
    {
        try {
            $user_id = 3;
            $array['datetime'] = Carbon::parse($array['datetime'])->format('Y-m-d H:i:s');
            $query = "INSERT INTO events (title, description, hosted_by, datetime, price, created_by) VALUES (:title, :description, :hosted_by, :datetime, :price, :created_by)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $array['title']);
            $stmt->bindParam(':description', $array['description']);
            $stmt->bindParam(':hosted_by', $array['hosted_by']);
            $stmt->bindParam(':datetime', $array['datetime']);
            $stmt->bindParam(':price', $array['price']);
            $stmt->bindParam(':created_by', $user_id);
            $stmt->execute();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
    }

    public function getAll()
    {
        $query = "SELECT * FROM events";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $query = "DELETE FROM events WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function update($id, $array)
    {
        $query = "UPDATE events SET title = :title, description = :description, hosted_by = :hosted_by, datetime = :datetime, price = :price WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $array['title']);
        $stmt->bindParam(':description', $array['description']);
        $stmt->bindParam(':hosted_by', $array['hosted_by']);
        $stmt->bindParam(':datetime', $array['datetime']);
        $stmt->bindParam(':price', $array['price']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function find($id)
    {
        $query = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
