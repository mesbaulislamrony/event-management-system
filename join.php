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
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                <?= $_SESSION['error']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                        <form id="joinForm" method="POST" action="" class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full name*</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Your full name">
                                <div id="name-error" class="error-message d-none"></div>
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile no*</label>
                                <input type="text" class="form-control" name="mobile_no" id="mobile" placeholder="Your mobile no">
                                <div id="mobile-error" class="error-message d-none"></div>
                            </div>
                            <div class="mb-3">
                                <label for="person" class="form-label">No of person*</label>
                                <input type="number" class="form-control" name="no_of_person" id="person" placeholder="Type no of person">
                                <div id="person-error" class="error-message d-none"></div>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#joinForm');
    const nameInput = document.getElementById('name');
    const mobileInput = document.getElementById('mobile');
    const personInput = document.getElementById('person');

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

        // Name validation
        if (!nameInput.value.trim()) {
            showError(nameInput, document.getElementById('name-error'), 'Name is required');
            hasErrors = true;
        } else {
            hideError(nameInput, document.getElementById('name-error'));
        }

        // Mobile no validation
        if (!mobileInput.value.trim()) {
            showError(mobileInput, document.getElementById('mobile-error'), 'Mobile no is required');
            hasErrors = true;
        } else if (mobileInput.value.length < 11) {
            showError(mobileInput, document.getElementById('mobile-error'), 'Mobile no must be at least 11 characters long');
            hasErrors = true;
        } else {
            hideError(mobileInput, document.getElementById('mobile-error'));
        }

        // No of person validation
        if (!personInput.value.trim()) {
            showError(personInput, document.getElementById('person-error'), 'No of person is required');
            hasErrors = true;
        } else if (personInput.value.length < 1) {
            showError(personInput, document.getElementById('person-error'), 'No of person must be at least 1 characters long');
            hasErrors = true;
        } else {
            const number = parseInt(personInput.value);
            if (isNaN(number) || number <= 0) {
                showError(personInput, document.getElementById('person-error'), 'No of person must be a positive number');
                hasErrors = true;
            } else if (number > "<?= $event['available'] ?>") {
                showError(personInput, document.getElementById('person-error'), 'No of person must be less than <?= $event['available'] ?>');
                hasErrors = true;
            } else {
                hideError(personInput, document.getElementById('person-error'));
            }
        }

        if (hasErrors) {
            e.preventDefault();
        }
    });
});
</script>
<?php require 'layouts/footer.php'; ?>