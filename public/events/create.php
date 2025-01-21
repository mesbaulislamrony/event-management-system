<?php

require '../../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventController = new EventController($db);
    $eventController->create($_POST);
}

?>

<form method="POST" action="">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="date" name="date" placeholder="Date" required>
    <input type="number" name="price" placeholder="Price" required>
    <button type="submit">Save</button>
</form>