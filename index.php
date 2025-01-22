<?php
require 'layouts/header.php';
require 'bootstrap.php';

use App\Controllers\HomeController;
use App\Middleware\Middleware;

Middleware::guest();

$homeController = new HomeController($db);
$result = $homeController->list();

?>
<section class="container">
    <div class="row">
        <div class="col-md-12"> 
            <div style="padding: 50px 0"> 
                <h1>Welcome to Event Management System</h1>
                <p>This is a simple event management system that allows you to create and join events.</p>
            </div>
        </div>
    </div>
</section>
<section class="container">
    <div class="jumbotron"> 
        <h3>Upcoming online events</h3>
    </div>
    <?php if (count($result) > 0) { ?>
        <?php foreach ($result as $key => $row) { ?>
        <div class="card border-0">
            <div class="card-body px-0 <?= $key % 2 == 0 ? 'text-end' : '' ?>">
                <h5 class="card-title"><?= $row["title"] ?></h5>
                <p class="card-text">Hosted By : <?= $row["hosted_by"] ?></p>
                <p class="mb-2 text-uppercase"><?= $row["datetime"] ?></p>
                <p class="mb-2 text-uppercase"><span class="badge text-bg-dark">5 Seat Available</span></p>
                <a href="/join.php?id=<?= $row["id"] ?>" class="btn btn-primary">Join Now</a>
            </div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if (count($result) == 0) { ?>
        <p>No events found.</p>
    <?php } ?>
</section>
<?php include_once 'layouts/footer.php'; ?>