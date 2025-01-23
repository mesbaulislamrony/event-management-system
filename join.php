<?php
require 'bootstrap.php';
require 'layouts/header.php';

use App\Controllers\HomeController;
use App\Controllers\AttendeeController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $attendeeController = new AttendeeController($db);
    $attendeeController->register($_GET['id'], $_POST);
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $homeController = new HomeController($db);
    $event = $homeController->find($_GET['id']);
}
?>
<section class="container">
    <div class="row">
        <div class="col-md-6">
            <div style="padding: 50px 0">
                <h5 class="card-title"><?= $event['title'] ?></h5>
                <p class="card-text"><?= $event['description'] ?></p>
                <p class="card-text mb-0">Hosted By : <?= $event['hosted_by'] ?></p>
                <p class="mb-2 text-uppercase"><?= $event['datetime'] ?></p>
                <p class="mb-2 text-uppercase"><span class="badge text-bg-dark"><?= $event['available'] ?> Seat available</span></p>
            </div>
        </div>
        <div class="col-md-4">
            <div style="padding: 50px 0">
                <?php if ($event['available'] > 0) { ?>
                    <div class="card border-0">
                        <div class="card-header border-0 bg-transparent">Please fillup form to join this event</div>
                        <form method="POST" action="" class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Your full name">
                            </div>
                            <div class="mb-3">
                                <label for="mobile_no" class="form-label">Mobile no</label>
                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Your mobile no">
                            </div>
                            <div class="mb-3">
                                <label for="no_of_person" class="form-label">No of person</label>
                                <input type="number" class="form-control" name="no_of_person" id="no_of_person" placeholder="Type no of person">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-2">&nbsp;</div>
    </div>
</section>
<?php require 'layouts/footer.php'; ?>