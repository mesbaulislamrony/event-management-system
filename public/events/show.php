<?php

require '../../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $eventController = new EventController($db);
    $event = $eventController->show($_GET['id']);
}
echo '<pre>';
print_r($event);
