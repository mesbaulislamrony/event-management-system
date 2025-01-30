<?php
require '../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventController = new EventController($db);
    $eventController->update($_GET['id'], $_POST);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $eventController = new EventController($db);
    $event = $eventController->edit($_GET['id']);
}
?>

<section class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0" style="margin:50px 0">
                <?php if(!empty($event)) { ?>
                <div class="card-header border-0 bg-transparent px-0">Edit event</div>
                <form id="eventForm" method="POST" action="" class="card-body px-0">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title*</label>
                        <input type="text" class="form-control" name="title" value="<?= $event['title'] ?>" id="title" placeholder="Write title">
                        <div id="title-error" class="error-message d-none"></div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Write description"><?= $event['description'] ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="hosted_by" class="form-label">Hosted By*</label>
                                <input type="text" class="form-control" name="hosted_by" value="<?= $event['hosted_by'] ?>" id="hosted_by" placeholder="Write host name">
                                <div id="hosted-error" class="error-message d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Location*</label>
                                <input type="text" class="form-control" name="location" value="<?= $event['location'] ?>" id="location" placeholder="Write event location">
                                <div id="location-error" class="error-message d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date" class="form-label">Event date*</label>
                                <input type="date" name="date" value="<?= $event['date'] ?>" class="form-control" id="date">
                                <div id="date-error" class="error-message d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Seat Capacity*</label>
                                <input type="number" name="capacity" value="<?= $event['capacity'] ?>" class="form-control" id="capacity" placeholder="Write seat capacity">
                                <div id="capacity-error" class="error-message d-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_time" class="form-label">Event start time*</label>
                                <input type="time" name="start_time" value="<?= $event['start_time'] ?>" class="form-control" id="start_time">
                                <div id="start-time-error" class="error-message d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">Event end time*</label>
                                <input type="time" name="end_time" value="<?= $event['end_time'] ?>" class="form-control" id="end_time">
                                <div id="end-time-error" class="error-message d-none"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/events/index.php" class="btn btn-secondary">Cancel</a>
                </form>
                <?php } else { ?>
                    <p class="mb-3">Event not found</p>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-4">&nbsp;</div>
    </div>
</section>
<script>
    const form = document.querySelector('#eventForm');
    const titleInput = document.getElementById('title');
    const hostedByInput = document.getElementById('hosted_by');
    const locationInput = document.getElementById('location');
    const dateInput = document.getElementById('date');
    const capacityInput = document.getElementById('capacity');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');

    const showError = (element, errorDiv, message) => {
        element.classList.add('is-invalid');
        errorDiv.textContent = message;
        errorDiv.classList.remove('d-none');
    };

    const hideError = (element, errorDiv) => {
        element.classList.remove('is-invalid');
        errorDiv.classList.add('d-none');
    };

    form.addEventListener('submit', function(e) {
        let hasErrors = false;

        const errorDivs = document.querySelectorAll('.error-message');
        errorDivs.forEach(err => {
            err.classList.add('d-none');
        });

        if (!titleInput.value.trim()) {
            showError(titleInput, document.getElementById('title-error'), 'Title is required');
            hasErrors = true;
        } else {
            hideError(titleInput, document.getElementById('title-error'));
        }

        if (!hostedByInput.value.trim()) {
            showError(hostedByInput, document.getElementById('hosted-error'), 'Hosted By is required');
            hasErrors = true;
        } else {
            hideError(hostedByInput, document.getElementById('hosted-error'));
        }

        if (!locationInput.value.trim()) {
            showError(locationInput, document.getElementById('location-error'), 'Location is required');
            hasErrors = true;
        } else {
            hideError(locationInput, document.getElementById('location-error'));
        }

        if (!dateInput.value.trim()) {
            showError(dateInput, document.getElementById('date-error'), 'Date is required');
            hasErrors = true;
        } else {
            hideError(dateInput, document.getElementById('date-error'));
        }


        if (!startTimeInput.value.trim()) {
            showError(startTimeInput, document.getElementById('start-time-error'), 'Start time is required');
            hasErrors = true;
        } else {
            hideError(startTimeInput, document.getElementById('start-time-error'));
        }


        if (!endTimeInput.value.trim()) {
            showError(endTimeInput, document.getElementById('end-time-error'), 'End time is required');
            hasErrors = true;
        } else {
            hideError(endTimeInput, document.getElementById('end-time-error'));
        }

        if (!capacityInput.value.trim()) {
            showError(capacityInput, document.getElementById('capacity-error'), 'Capacity is required');
            hasErrors = true;
        } else if (parseInt(capacityInput.value) <= 0) {
            showError(capacityInput, document.getElementById('capacity-error'), 'Capacity must be greater than 0');
            hasErrors = true;
        } else {
            hideError(capacityInput, document.getElementById('capacity-error'));
        }

        if (hasErrors) {
            e.preventDefault();
        }
    });
</script>
<?php require '../layouts/footer.php'; ?>