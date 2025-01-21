<?php

namespace App\Middleware;

class Middleware
{
    public static function auth()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login.php");
            exit;
        }
    }

    public static function guest()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard.php");
            exit;
        }
    }
}
