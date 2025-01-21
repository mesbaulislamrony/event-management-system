<?php

require '../../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\AuthController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $authController = new AuthController($db);
    $authController->login($email, $password);
}

?>

<form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>