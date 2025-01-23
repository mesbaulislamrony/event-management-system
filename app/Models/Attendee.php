<?php

namespace App\Models;

use PDO;
use Carbon\Carbon;

class Attendee
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($array)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $query = "INSERT INTO attendees (name, mobile_no, registered_at) VALUES (:name, :mobile_no, :registered_at)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $array['name']);
        $stmt->bindParam(':mobile_no', $array['mobile_no']);
        $stmt->bindParam(':registered_at', $today);
        return $stmt->execute();
    }

    public function join($event_id, $attendee, $array)
    {
        $query = "INSERT INTO attendee_events (attendee_id, event_id, no_of_person) VALUES (:attendee_id, :event_id, :no_of_person)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':attendee_id', $attendee['id']);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':no_of_person', $array['no_of_person']);
        return $stmt->execute();
    }

    public function findByMobileNo($mobile_no)
    {
        $query = "SELECT * FROM attendees WHERE mobile_no = :mobile_no";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mobile_no', $mobile_no);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $query = "SELECT attendee_events.attendee_id FROM attendee_events WHERE event_id = :event_id";
        $stmt = $this->conn->query($query);
        $stmt->bindParam(':event_id', $id);
        $attendee_events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $query = "DELETE FROM attendees WHERE id IN " . implode(',', array_column($attendee_events, 'attendee_id'));
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $query = "DELETE FROM attendee_events WHERE event_id = :event_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $id);
        $stmt->execute();
    }

    public function csv($id)
    {
        $query = "SELECT attendees.name, attendees.mobile_no, attendee_events.no_of_person FROM attendees 
        INNER JOIN attendee_events ON attendees.id = attendee_events.attendee_id WHERE attendee_events.event_id = :event_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
