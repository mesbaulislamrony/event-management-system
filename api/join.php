<?php
require '../bootstrap.php';

use App\Controllers\Api\AttendeeController;

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}
$attendeeController = new AttendeeController($db);
$data = json_decode(file_get_contents('php://input'), true);
$attendeeController->join($data);
