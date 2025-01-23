<?php

namespace App\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use PDO;

class HomeController
{
    private $conn;
    private $eventModel;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->eventModel = new Event($db);
    }

    public function index()
    {
        $query = "SELECT events.id, title, description, hosted_by, datetime, capacity, SUM(attendee_events.no_of_person) as total FROM events
        LEFT JOIN attendee_events ON attendee_events.event_id = events.id GROUP BY events.id ORDER BY events.id DESC";
        $stmt = $this->conn->query($query);
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($event) {
            $event['datetime'] = Carbon::parse($event['datetime'])->toDayDateTimeString();
            $event['available'] = ($event['capacity'] - $event['total']);
            return $event;
        }, $events);
    }

    public function find($id)
    {
        $query = "SELECT events.id, title, description, hosted_by, datetime, capacity, IFNULL(SUM(attendee_events.no_of_person), 0) as total FROM events
        LEFT JOIN attendee_events ON attendee_events.event_id = events.id WHERE events.id = :id GROUP BY events.id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
        $event['datetime'] = Carbon::parse($event['datetime'])->toDayDateTimeString();
        $event['available'] = ($event['capacity'] - $event['total']);
        return $event;
    }
}
