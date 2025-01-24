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
        $query = "SELECT COUNT(*) as total FROM users WHERE mobile_no = :mobile_no";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':mobile_no', $array['mobile_no']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['total'] > 0) {
            $_SESSION['error'] = 'Mobile number already exists';
            return false;
        }

        $query = "INSERT INTO users (name, mobile_no, password) VALUES (:name, :mobile_no, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $array['name']);
        $stmt->bindParam(':mobile_no', $array['mobile_no']);
        $stmt->bindParam(':password', password_hash($array['password'], PASSWORD_DEFAULT));
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
