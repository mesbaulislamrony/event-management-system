<?php

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            header("Location: /events/list.php");
        }
        header("Location: /index.php");
    }

    public function register($array)
    {
        $this->userModel->register($array);
        $user = $this->userModel->findByEmail($array['email']);

        if ($user && password_verify($array['password'], $user['password'])) {
            header("Location: /events/list.php");
        }
        header("Location: /index.php");
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login.php");
    }
}
