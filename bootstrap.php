<?php
ob_start();
require __DIR__ . '/vendor/autoload.php';

use App\Models\SessionManager;
use App\Models\Database;

$db = (new Database())->connect();
// new SessionManager($db);
