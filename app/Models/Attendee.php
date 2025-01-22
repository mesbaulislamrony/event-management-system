<?php

namespace App\Models;

use Carbon\Carbon;
use PDO;

class Attendee
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($array)
    {
        $query = "INSERT INTO attendees (name, mobile_no) VALUES (:name, :mobile_no)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $array['name']);
        $stmt->bindParam(':mobile_no', $array['mobile_no']);
        return $stmt->execute();
    }

    public function join($event_id, $attendee_id)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $query = "INSERT INTO attendee_has_events (attendee_id, event_id, registration_at) VALUES (:attendee_id, :event_id, :registration_at)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':attendee_id', $attendee_id);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':registration_at', $today);
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

    public function checkAlreadyExists($event_id, $attendee_id)
    {
        $query = "SELECT * FROM attendee_has_events WHERE event_id = :event_id AND attendee_id = :attendee_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':attendee_id', $attendee_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
