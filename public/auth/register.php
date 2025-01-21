<?php

require '../../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\AuthController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($db);
    $authController->register($_POST);
}

?>

<form method="POST" action="">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>