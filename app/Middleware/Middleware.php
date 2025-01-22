<?php

namespace App\Middleware;

class Middleware
{
    public static function auth()
    {
        if (empty($_SESSION)) {
            header("Location: /auth/login.php");
        }
    }

    public static function guest()
    {
        if (!empty($_SESSION)) {
            header("Location: /events/index.php");
        }
    }
}
