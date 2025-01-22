<?php
require '../bootstrap.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventController = new EventController($db);
    $event = $eventController->delete($_POST['id']);
}
