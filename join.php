<?php
require 'layouts/header.php';
require 'bootstrap.php';

use App\Controllers\EventController;
use App\Controllers\AttendeeController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendeeController = new AttendeeController($db);
    $attendeeController->register($_GET['id'], $_POST);
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $eventController = new EventController($db);
    $event = $eventController->show($_GET['id']);   
}
?>
<section class="container">
    <div class="card border-0" style="margin:50px 0">
        <div class="card-body px-0">
            <h5 class="card-title"><?= $event['title'] ?></h5>
            <p class="card-text"><?= $event['description'] ?></p>
            <p class="card-text">Hosted By : <?= $event['hosted_by'] ?></p>
            <p class="mb-2 text-uppercase"><?= $event['datetime'] ?></p>
            <p class="mb-2 text-uppercase"><span class="badge text-bg-dark">5 Going</span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0">
                <div class="card-header border-0 bg-transparent px-0">Please fillup form to join this event</div>
                <form method="POST" action="" class="card-body px-0">
                    <div class="mb-3">
                        <label for="name" class="form-label">Fullname</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Your fullname">
                    </div>
                    <div class="mb-3">
                        <label for="mobile_no" class="form-label">Mobile no</label>
                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Your mobile no">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">&nbsp;</div>
    </div>
</section>
<?php require 'layouts/footer.php'; ?>