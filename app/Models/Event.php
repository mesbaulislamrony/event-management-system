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
        $array['datetime'] = Carbon::parse($array['datetime'])->format('Y-m-d H:i:s');
        $query = "INSERT INTO events (title, description, hosted_by, datetime, capacity, created_by) VALUES (:title, :description, :hosted_by, :datetime, :capacity, :created_by)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $array['title']);
        $stmt->bindParam(':description', $array['description']);
        $stmt->bindParam(':hosted_by', $array['hosted_by']);
        $stmt->bindParam(':datetime', $array['datetime']);
        $stmt->bindParam(':capacity', $array['capacity']);
        $stmt->bindParam(':created_by', $_SESSION['user']['id']);
        $stmt->execute();
    }

    public function index()
    {
        $query = "SELECT events.id, title, description, hosted_by, datetime, capacity, IFNULL(SUM(attendee_events.no_of_person), 0) as total FROM events
        LEFT JOIN attendee_events ON attendee_events.event_id = events.id WHERE events.created_by = " . $_SESSION['user']['id'] . " GROUP BY events.id ORDER BY events.id DESC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function destroy($id)
    {
        $query = "SELECT attendee_id FROM attendee_events WHERE event_id = " . $id;
        $stmt = $this->conn->query($query);
        $attendee_events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($attendee_events)) {
            $query = "DELETE FROM attendees WHERE id IN (" . implode(',', array_column($attendee_events, 'attendee_id')) . ")";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $query = "DELETE FROM attendee_events WHERE event_id = :event_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':event_id', $id);
            $stmt->execute();
        }

        $query = "DELETE FROM events WHERE id = :id AND created_by = " . $_SESSION['user']['id'];
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function update($id, $array)
    {
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
        $query = "SELECT events.id, title, description, hosted_by, datetime, capacity, IFNULL(SUM(attendee_events.no_of_person), 0) as total FROM events
        LEFT JOIN attendee_events ON attendee_events.event_id = events.id WHERE events.id = :id AND created_by = :created_by GROUP BY events.id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':created_by', $_SESSION['user']['id']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
