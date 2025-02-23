<?php
require '../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventController = new EventController($db);
    $event = $eventController->delete($_POST['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $eventController = new EventController($db);
    $event = $eventController->show($_GET['id']);
}

?>
<section class="container">
    <div class="card border-0" style="margin:50px 0">
        <?php if(!empty($event)) { ?>
        <div class="card-body px-0">
            <h5 class="card-title"><?= $event['title'] ?></h5>
            <p class="card-text"><?= $event['description'] ?></p>
            <p class="mb-1">Hosted By : <?= $event['hosted_by'] ?></p>
            <p class="mb-1">Datetime : <span class="text-uppercase"><?= $event['datetime'] ?><span></p>
            <p class="mb-1">Capacity : <?= $event['capacity'] ?></p>
            <p class="mb-4 text-uppercase"><span class="badge text-bg-dark"><?= $event['available'] ?> Seat available</span></p>
            <a href="/events/edit.php?id=<?= $event["id"] ?>" class="btn btn-primary">Edit</a>
            <a href="/events/csv.php?id=<?= $event["id"] ?>" class="btn btn-success">Download Attendee CSV</a>
            <form id="deleteForm" method="POST" action="" class="d-inline" onsubmit="return confirmDelete()">
                <input type="hidden" name="id" value="<?= $event["id"] ?>">
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            <a href="/events/index.php" class="btn btn-secondary">Cancel</a>
        </div>
        <?php } else { ?>
            <p class="mb-3">Event not found</p>
        <?php } ?>
    </div>
</section>
<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this event? This action cannot be undone.');
}
</script>
<?php require '../layouts/footer.php'; ?>