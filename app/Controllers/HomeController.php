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
        $query = "SELECT events.id, title, description, hosted_by, datetime, capacity, SUM(user_has_events.no_of_person) as available FROM events
        LEFT JOIN user_has_events ON user_has_events.event_id = events.id GROUP BY events.id ORDER BY events.id DESC";
        $stmt = $this->conn->query($query);
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($event) {
            $event['datetime'] = Carbon::parse($event['datetime'])->toDayDateTimeString();
            $event['available'] = ($event['capacity'] - $event['available']);
            return $event;
        }, $events);
    }
}
