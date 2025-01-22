<?php
require '../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\AuthController;
use App\Middleware\Middleware;

Middleware::auth();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $authController = new AuthController($db);
    $authController->logout();
}
