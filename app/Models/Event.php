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
        $user_id = $_SESSION['user']['id'];
        $array['datetime'] = Carbon::parse($array['datetime'])->format('Y-m-d H:i:s');
        $query = "INSERT INTO events (title, description, hosted_by, datetime, capacity, created_by) VALUES (:title, :description, :hosted_by, :datetime, :capacity, :created_by)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $array['title']);
        $stmt->bindParam(':description', $array['description']);
        $stmt->bindParam(':hosted_by', $array['hosted_by']);
        $stmt->bindParam(':datetime', $array['datetime']);
        $stmt->bindParam(':capacity', $array['capacity']);
        $stmt->bindParam(':created_by', $user_id);
        $stmt->execute();
    }

    public function getAll()
    {
        $user_id = $_SESSION['user']['id'];
        $query = "SELECT events.id, title, description, hosted_by, datetime, capacity, IFNULL(SUM(user_has_events.no_of_person), 0) as available FROM events
        LEFT JOIN user_has_events ON user_has_events.event_id = events.id WHERE events.created_by = " . $user_id . " GROUP BY events.id ORDER BY events.id DESC";
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
        $user_id = $_SESSION['user']['id'];
        $query = "UPDATE events SET title = :title, description = :description, hosted_by = :hosted_by, datetime = :datetime, capacity = :capacity WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $array['title']);
        $stmt->bindParam(':description', $array['description']);
        $stmt->bindParam(':hosted_by', $array['hosted_by']);
        $stmt->bindParam(':datetime', $array['datetime']);
        $stmt->bindParam(':capacity', $array['capacity']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function find($id)
    {
        $query = "SELECT events.id, title, description, hosted_by, datetime, capacity FROM events WHERE events.id = :id";
        $query = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function userHasEvents($id)
    {
        $query = "SELECT IFNULL(SUM(user_has_events.no_of_person), 0) as total FROM user_has_events WHERE event_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
