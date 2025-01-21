<?php

namespace App\Models;

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
        $query = "INSERT INTO events (title, description, date) VALUES (:title, :description, :date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $array['title']);
        $stmt->bindParam(':description', $array['description']);
        $stmt->bindParam(':date', $array['date']);
        return $stmt->execute();
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
        $query = "UPDATE events SET title = :title, description = :description, date = :date WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $array['title']);
        $stmt->bindParam(':description', $array['description']);
        $stmt->bindParam(':date', $array['date']);
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
