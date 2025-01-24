<?php
require '../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventController = new EventController($db);
    $eventController->create($_POST);
}

?>
<section class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0" style="margin:50px 0">
                <div class="card-header border-0 bg-transparent px-0">Create an event</div>
                <form id="eventForm" method="POST" action="" class="card-body px-0">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title*</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Write title">
                        <div id="title-error" class="error-message d-none"></div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Write description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="hosted_by" class="form-label">Hosted By*</label>
                        <input type="text" class="form-control" name="hosted_by" id="hosted_by" placeholder="Write host name">
                        <div id="hostedby-error" class="error-message d-none"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="datetime" class="form-label">Event datetime*</label>
                                <input type="datetime-local" name="datetime" class="form-control" id="datetime">
                                <div id="datetime-error" class="error-message d-none"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="capacity" class="form-label">Seat Capacity*</label>
                                <input type="number" name="capacity" class="form-control" id="capacity" placeholder="Write seat capacity">
                                <div id="capacity-error" class="error-message d-none"></div>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#eventForm');
    const titleInput = document.getElementById('title');
    const hostedByInput = document.getElementById('hosted_by');
    const datetimeInput = document.getElementById('datetime');
    const capacityInput = document.getElementById('capacity');

    // Show error message function
    const showError = (element, errorDiv, message) => {
        element.classList.add('is-invalid');
        errorDiv.textContent = message;
        errorDiv.classList.remove('d-none');
    };

    // Hide error message function
    const hideError = (element, errorDiv) => {
        element.classList.remove('is-invalid');
        errorDiv.classList.add('d-none');
    };

    form.addEventListener('submit', function(e) {
        let hasErrors = false;

        // Reset all error messages
        const errorDivs = document.querySelectorAll('.error-message');
        errorDivs.forEach(err => {
            err.classList.add('d-none');
        });

        // Title validation
        if (!titleInput.value.trim()) {
            showError(titleInput, document.getElementById('title-error'), 'Title is required');
            hasErrors = true;
        } else {
            hideError(titleInput, document.getElementById('title-error'));
        }

        // Hosted By validation
        if (!hostedByInput.value.trim()) {
            showError(hostedByInput, document.getElementById('hostedby-error'), 'Host name is required');
            hasErrors = true;
        } else {
            hideError(hostedByInput, document.getElementById('hostedby-error'));
        }

        // Datetime validation
        if (!datetimeInput.value) {
            showError(datetimeInput, document.getElementById('datetime-error'), 'Event datetime is required');
            hasErrors = true;
        }

        // Capacity validation
        if (!capacityInput.value.trim()) {
            showError(capacityInput, document.getElementById('capacity-error'), 'Seat capacity is required');
            hasErrors = true;
        } else {
            const capacity = parseInt(capacityInput.value);
            if (isNaN(capacity) || capacity <= 0) {
                showError(capacityInput, document.getElementById('capacity-error'), 'Seat capacity must be a positive number');
                hasErrors = true;
            } else {
                hideError(capacityInput, document.getElementById('capacity-error'));
            }
        }

        if (hasErrors) {
            e.preventDefault();
        }
    });
});
</script>
<?php require '../layouts/footer.php'; ?>