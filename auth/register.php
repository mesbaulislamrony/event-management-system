<?php
require '../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\AuthController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($db);
    $authController->register($_POST);
}

?>
<section class="container">
    <div class="row">
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">
            <div class="card border-0" style="margin:50px 0">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <?= $_SESSION['error']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <div class="card-header border-0 bg-transparent">Register</div>
                <form id="registerForm" method="POST" action="" class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name*</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Your full name">
                        <div id="name-error" class="error-message d-none"></div>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile no*</label>
                        <input type="text" class="form-control" name="mobile_no" id="mobile" placeholder="Your mobile no">
                        <div id="mobile-error" class="error-message d-none"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password*</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Your password">
                        <div id="password-error" class="error-message d-none"></div>
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
    const form = document.querySelector('#registerForm');
    const nameInput = document.getElementById('name');
    const mobileInput = document.getElementById('mobile');
    const passwordInput = document.getElementById('password');

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
        } else {
            hideError(mobileInput, document.getElementById('mobile-error'));
        }

        // Password validation
        if (!passwordInput.value.trim()) {
            showError(passwordInput, document.getElementById('password-error'), 'Password is required');
            hasErrors = true;
        } else {
            hideError(passwordInput, document.getElementById('password-error'));
        }

        if (hasErrors) {
            e.preventDefault();
        }
    });
});
</script>
<?php include_once '../layouts/footer.php'; ?>