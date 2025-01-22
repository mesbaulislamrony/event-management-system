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

    public function join($event_id, $attendee_id, $array)
    {
        $today = Carbon::now()->format('Y-m-d H:i:s');
        $query = "INSERT INTO user_has_events (user_id, event_id, registered_at, no_of_person) VALUES (:user_id, :event_id, :registered_at, :no_of_person)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $attendee_id);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':registered_at', $today);
        $stmt->bindParam(':no_of_person', $array['no_of_person']);
        return $stmt->execute();
    }

    public function noOftickets($id)
    {
        $user_id = $_SESSION['user']['id'];
        $query = "SELECT IFNULL(SUM(user_has_events.no_of_person), 0) as total FROM user_has_events WHERE event_id = :event_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
