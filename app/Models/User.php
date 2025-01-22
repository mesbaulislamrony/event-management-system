<?php

namespace App\Models;

use PDO;

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register($array)
    {
        $array['password'] = password_hash($array['password'], PASSWORD_BCRYPT);
        $query = "INSERT INTO users (name, mobile_no, password) VALUES (:name, :mobile_no, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $array['name']);
        $stmt->bindParam(':mobile_no', $array['mobile_no']);
        $stmt->bindParam(':password', $array['password']);
        return $stmt->execute();
    }

    public function findByMobileNo($mobile_no)
    {
        $query = "SELECT * FROM users WHERE mobile_no = :mobile_no";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mobile_no', $mobile_no);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
