<?php

require '../../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventController = new EventController($db);
    $eventController->update($_GET['id'], $_POST);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $eventController = new EventController($db);
    $event = $eventController->show($_GET['id']);
}
?>

<form method="POST" action="">
    <input type="text" name="title" placeholder="Title" value="<?= $event['title'] ?>" required>
    <textarea name="description" placeholder="Description"><?= $event['description'] ?></textarea>
    <input type="date" name="date" placeholder="Date" value="<?= $event['date'] ?>" required>
    <button type="submit">Save</button>
</form>