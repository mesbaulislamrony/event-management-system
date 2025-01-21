<?php
class Attendee
{
    private $conn;
    private $table = "event_attendees";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($event_id, $name, $email)
    {
        $query = "INSERT INTO " . $this->table . " (event_id, attendee_name, attendee_email) VALUES (:event_id, :name, :email)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
}
