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
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $array['name']);
        $stmt->bindParam(':email', $array['email']);
        $stmt->bindParam(':password', $array['password']);
        return $stmt->execute();
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
