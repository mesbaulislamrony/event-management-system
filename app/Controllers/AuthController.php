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

    public function login($mobile_no, $password)
    {
        $user = $this->userModel->findByMobileNo($mobile_no);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /events/index.php");
        }
        header("Location: /index.php");
    }

    public function register($array)
    {
        $this->userModel->register($array);
        $user = $this->userModel->findByMobileNo($array['mobile_no']);

        if ($user && password_verify($array['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /events/index.php");
        }
        header("Location: /index.php");
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login.php");
    }
}
