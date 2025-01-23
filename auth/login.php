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
                <div class="card-header border-0 bg-transparent">Login</div>
                <form method="POST" action="" class="card-body">
                    <div class="mb-3">
                        <label for="mobile_no" class="form-label">Mobile no*</label>
                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Your mobile no" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password*</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">&nbsp;</div>
    </div>
</section>
<?php require '../layouts/footer.php'; ?>