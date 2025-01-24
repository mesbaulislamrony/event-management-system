<?php
require '../bootstrap.php';
require '../layouts/header.php';

use App\Controllers\EventController;
use App\Middleware\Middleware;

Middleware::auth();

$eventController = new EventController($db);
$data = $eventController->index();
$events = $data['events'];

?>
<section class="container">
    <div class="card border-0" style="margin:50px 0">
        <h4 class="flex">Your Events <small class="float-end" style="font-size: 16px"><a href='/events/create.php'>Create an event</a></small></h4>
        <?php if (count($events) > 0) { ?>
            <table class="table">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Datetime</th>
                    <th>Capacity</th>
                    <th>Available</th>
                    <th class="text-end">Action</th>
                </tr>
                <?php foreach ($events as $row) { ?>
                    <tr>
                        <td>
                            <p class="mb-0"><?= $row["title"] ?></p>
                            <p class="mb-0" style="font-size: 14px"><strong>Hosted By : <?= $row["hosted_by"] ?></strong></p>
                        </td>
                        <td><?= $row["description"] ?></td>
                        <td><?= $row["datetime"] ?></td>
                        <td><?= $row["capacity"] ?></td>
                        <td><?= $row["available"] ?></td>
                        <td class="text-end">
                            <a href='/events/show.php?id=<?= $row["id"] ?>'>Show</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <?php if ($data['totalPages'] > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($data['currentPage'] > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $data['currentPage'] - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                        <li class="page-item <?= $i === $data['currentPage'] ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($data['currentPage'] < $data['totalPages']): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $data['currentPage'] + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
        <?php } ?>
        <?php if (count($events) == 0) { ?>
            <p>No events found.</p>
        <?php } ?>
    </div>
</section>
<?php require '../layouts/footer.php'; ?>