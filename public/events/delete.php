<?php

require '../../bootstrap.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $eventController = new EventController($db);
    $event = $eventController->delete($_GET['id']);
}
