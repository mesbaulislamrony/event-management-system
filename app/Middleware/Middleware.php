<?php

namespace App\Middleware;

class Middleware
{
    public static function auth()
    {
        if (empty($_SESSION)) {
            header("Location: /auth/login.php");
            exit();
        }
    }

    public static function guest()
    {
        if (!empty($_SESSION) && array_key_exists('user', $_SESSION)) {
            header("Location: /events/index.php");
            exit();
        }
    }
}
