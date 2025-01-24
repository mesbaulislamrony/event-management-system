<?php
require '../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\AuthController;
use App\Middleware\Middleware;

Middleware::guest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($db);
    $mobile_no = $_POST['mobile_no'];
    $password = $_POST['password'];
    $authController->login($mobile_no, $password);
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
                <div class="card-header border-0 bg-transparent">Login</div>
                <form id="loginForm" method="POST" action="" class="card-body">
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
function showError(input, errorElement, message) {
    input.classList.add('is-invalid');
    errorElement.textContent = message;
    errorElement.classList.remove('d-none');
}

function hideError(input, errorElement) {
    input.classList.remove('is-invalid');
    errorElement.classList.add('d-none');
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    let hasErrors = false;
    
    // Mobile validation
    const mobileInput = document.getElementById('mobile');
    if (!mobileInput.value.trim()) {
        showError(mobileInput, document.getElementById('mobile-error'), 'Mobile no is required');
        hasErrors = true;
    } else if (mobileInput.value.length < 11) {
        showError(mobileInput, document.getElementById('mobile-error'), 'Mobile no must be at least 11 characters long');
        hasErrors = true;
    } else {
        hideError(mobileInput, document.getElementById('mobile-error'));
    }
    
    // Password validation
    const passwordInput = document.getElementById('password');
    if (!passwordInput.value) {
        showError(passwordInput, document.getElementById('password-error'), 'Password is required');
        hasErrors = true;
    } else if (passwordInput.value.length < 6) {
        showError(passwordInput, document.getElementById('password-error'), 'Password must be at least 6 characters long');
        hasErrors = true;
    } else {
        hideError(passwordInput, document.getElementById('password-error'));
    }
    
    if (hasErrors) {
        e.preventDefault();
    }
});
</script>
<?php require '../layouts/footer.php'; ?>