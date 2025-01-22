<?php
require 'bootstrap.php';
require 'layouts/header.php';

use App\Controllers\EventController;
use App\Controllers\AttendeeController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendeeController = new AttendeeController($db);
    $attendeeController->register($_GET['id'], $_POST);
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $attendeeController = new AttendeeController($db);
    $eventController = new EventController($db);
    $event = $eventController->show($_GET['id']);
    $tickets = $attendeeController->tickets($_GET['id']);
}
?>
<section class="container">
    <div class="row">
        <div class="col-md-6">
            <div style="padding: 50px 0">
                <h5 class="card-title"><?= $event['title'] ?></h5>
                <p class="card-text"><?= $event['description'] ?></p>
                <p class="card-text">Hosted By : <?= $event['hosted_by'] ?></p>
                <p class="mb-2 text-uppercase"><?= $event['datetime'] ?></p>
                <p class="mb-2 text-uppercase"><span class="badge text-bg-dark"><?= $event['available'] ?> Seat available</span></p>
            </div>
        </div>
        <div class="col-md-4">
            <div style="padding: 50px 0">
                <div class="card border-0">
                    <div class="card-header border-0 bg-transparent">Please fillup form to join this event</div>
                    <form method="POST" action="" class="card-body">
                        <?php if (!empty($_SESSION)) { ?>
                            <p class="card-text">Full Name : <?= $_SESSION['user']['name'] ?></p>
                            <p class="card-text">Mobile no : <?= $_SESSION['user']['mobile_no'] ?></p>
                        <?php } else { ?>
                            <div class="mb-3">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Your full name">
                            </div>
                            <div class="mb-3">
                                <label for="mobile_no" class="form-label">Mobile no</label>
                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Your mobile no">
                            </div>
                        <?php } ?>
                        <?php if ($tickets['total'] == 0) { ?>
                            <div class="mb-3">
                                <label for="no_of_person" class="form-label">No of person</label>
                                <input type="number" class="form-control" name="no_of_person" id="no_of_person" placeholder="Type no of person">
                            </div>
                        <?php } else { ?>
                            <p class="card-text">You are almost booked <?= $tickets['total'] ?> seats</p>
                        <?php } ?>
                        <?php if (empty($_SESSION)) { ?>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Your password">
                            </div>
                        <?php } ?>
                        <?php if ($tickets['total'] == 0) { ?>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        <?php } else { ?>
                            <a href="leave.php?id=<?= $_GET['id'] ?>" class="btn btn-danger">Leave</a>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2">&nbsp;</div>
    </div>
</section>
<?php require 'layouts/footer.php'; ?>