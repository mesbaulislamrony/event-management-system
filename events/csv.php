<?php
require '../bootstrap.php';

use App\Controllers\AttendeeController;
use App\Middleware\Middleware;

Middleware::auth();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $attendeeController = new AttendeeController($db);
    $event = $attendeeController->download($_GET['id']);
}
