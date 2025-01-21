<?php

require '../../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::guest();

$eventController = new EventController($db);
$result = $eventController->list();

echo '<br>';

if (count($result) > 0) {
    foreach ($result as $row) {
        echo "Title: " . $row["title"] . "<br>";
        echo "Description: " . $row["description"] . "<br>";
        echo "Date: " . $row["date"] . "<br>";
        echo "<a href='/events/show.php?id=" . $row["id"] . "'>Show</a>";
        echo "<a href='/events/edit.php?id=" . $row["id"] . "'>Edit</a>";
        echo "<a href='/events/delete.php?id=" . $row["id"] . "'>Delete</a>";
        echo "<hr>";
    }
} else {
    echo "0 results";
}
