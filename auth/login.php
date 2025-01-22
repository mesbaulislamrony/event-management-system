<?php
require '../layouts/header.php';
require '../bootstrap.php';

use App\Controllers\AuthController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController = new AuthController($db);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $authController->login($email, $password);
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
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Your email address">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Your password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">&nbsp;</div>
    </div>
</section>
<?php require '../layouts/footer.php'; ?>