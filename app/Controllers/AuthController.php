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

        if (!$user) {
            $_SESSION['error'] = "Invalid mobile number.";
            header("Location: /auth/login.php");
            exit();
        }

        if (!password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Invalid password.";
            header("Location: /auth/login.php");
            exit();
        }

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /events/index.php");
            exit();
        }
        header("Location: /index.php");
        exit();
    }

    public function register($array)
    {
        $registered = $this->userModel->register($array);

        if (!$registered) {
            $_SESSION['error'] = "Mobile number already exists. Please use a different mobile number.";
            header("Location: /auth/register.php");
            exit();
        }

        $user = $this->userModel->findByMobileNo($array['mobile_no']);
        if ($user && password_verify($array['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /index.php");
            exit();
        }
        header("Location: /index.php");
        exit();
    }

    public function logout()
    {
        session_destroy();
        header("Location: /auth/login.php");
    }
}
