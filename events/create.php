<?php
require '../layouts/header.php';
require '../bootstrap.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventController = new EventController($db);
    $eventController->create($_POST);
}

?>
<section class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0" style="margin:50px 0">
                <div class="card-header border-0 bg-transparent">Create an event</div>
                <form method="POST" action="" class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Write title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Write description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="hosted_by" class="form-label">Hosted By</label>
                        <input type="text" class="form-control" name="hosted_by" id="hosted_by" placeholder="Write host name">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="datetime" class="form-label">Event datetime</label>
                                <input type="datetime-local" name="datetime" class="form-control" id="datetime">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="limit" class="form-label">Seat Limits</label>
                                <input type="number" name="limit" class="form-control" id="limit" placeholder="Write seat limits">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">&nbsp;</div>
    </div>
</section>
<?php require '../layouts/footer.php'; ?>