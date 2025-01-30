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

    public function store($array)
    {
        $array['date'] = Carbon::parse($array['date'])->format('Y-m-d');
        $array['start_time'] = Carbon::parse($array['start_time'])->format('H:i:s');
        $array['end_time'] = Carbon::parse($array['end_time'])->format('H:i:s');
        $query = "INSERT INTO events (title, description, hosted_by, location, date, start_time, end_time, capacity, created_by) VALUES (:title, :description, :hosted_by, :location, :date, :start_time, :end_time, :capacity, :created_by)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $array['title']);
        $stmt->bindParam(':description', $array['description']);
        $stmt->bindParam(':hosted_by', $array['hosted_by']);
        $stmt->bindParam(':location', $array['location']);
        $stmt->bindParam(':date', $array['date']);
        $stmt->bindParam(':start_time', $array['start_time']);
        $stmt->bindParam(':end_time', $array['end_time']);
        $stmt->bindParam(':capacity', $array['capacity']);
        $stmt->bindParam(':created_by', $_SESSION['user']['id']);
        $stmt->execute();
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
        $array['date'] = Carbon::parse($array['date'])->format('Y-m-d');
        $array['start_time'] = Carbon::parse($array['start_time'])->format('H:i:s');
        $array['end_time'] = Carbon::parse($array['end_time'])->format('H:i:s');
        $query = "UPDATE events SET title = :title, description = :description, hosted_by = :hosted_by, location = :location, date = :date, start_time = :start_time, end_time = :end_time, capacity = :capacity WHERE id = :id AND created_by = " . $_SESSION['user']['id'];
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $array['title']);
        $stmt->bindParam(':description', $array['description']);
        $stmt->bindParam(':hosted_by', $array['hosted_by']);
        $stmt->bindParam(':location', $array['location']);
        $stmt->bindParam(':date', $array['date']);
        $stmt->bindParam(':start_time', $array['start_time']);
        $stmt->bindParam(':end_time', $array['end_time']);
        $stmt->bindParam(':capacity', $array['capacity']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function find($id)
    {
        $query = "SELECT events.id, title, description, hosted_by, location, date, start_time, end_time, capacity, IFNULL(SUM(attendee_events.no_of_person), 0) as total FROM events
        LEFT JOIN attendee_events ON attendee_events.event_id = events.id WHERE events.id = :id AND created_by = :created_by GROUP BY events.id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':created_by', $_SESSION['user']['id']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function paginate($offset, $perPage)
    {
        $query = "SELECT events.id, title, description, hosted_by, location, date, start_time, end_time, capacity, IFNULL(SUM(attendee_events.no_of_person), 0) as total FROM events
        LEFT JOIN attendee_events ON attendee_events.event_id = events.id WHERE created_by = :created_by GROUP BY events.id
        ORDER BY events.date DESC 
        LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':created_by', $_SESSION['user']['id']);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count()
    {
        $query = "SELECT COUNT(*) as total FROM events WHERE created_by = :created_by";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':created_by', $_SESSION['user']['id']);
        $stmt->execute();
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function findByEventId($event_id)
    {
        $query = "SELECT attendees.name, attendees.mobile_no, attendee_events.no_of_person FROM attendee_events
        INNER JOIN events ON attendee_events.event_id = events.id
        INNER JOIN attendees ON attendees.id = attendee_events.attendee_id WHERE events.id = :event_id AND created_by = :created_by ORDER BY attendee_events.id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':created_by', $_SESSION['user']['id']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
