<?php
require 'bootstrap.php';
require 'layouts/header.php';

use App\Controllers\HomeController;

$homeController = new HomeController($db);
$event = $homeController->find($_GET['id']);

if (!$event) {
    header('Location: /index.php');
    exit;
}
?>

<section class="container">
    <div class="card border-0" style="margin:50px 0">
        <div class="row">
            <div class="col-md-6">
                <div class="card-body px-0">
                    <h5 class="card-title"><?= $event['title'] ?></h5>
                    <p class="card-text"><?= $event['description'] ?></p>
                    <p class="mb-1">Hosted By : <?= $event['hosted_by'] ?></p>
                    <p class="mb-1">Datetime : <span class="text-uppercase"><?= $event['datetime'] ?><span></p>
                    <p class="mb-4 text-uppercase"><span class="badge text-bg-dark"><?= $event['available'] ?> Seat available</span></p>
                </div>
            </div>
            <div class="col-md-6">
                <div id="formAlert" class="alert d-none" role="alert"></div>
                <form id="joinForm" class="card-body px-0">
                    <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full name*</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Your full name">
                        <div id="name-error" class="error-message text-danger d-none"></div>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile no*</label>
                        <input type="text" class="form-control" name="mobile_no" id="mobile" placeholder="Your mobile no">
                        <div id="mobile-error" class="error-message text-danger d-none"></div>
                    </div>
                    <div class="mb-3">
                        <label for="person" class="form-label">No of person*</label>
                        <input type="number" class="form-control" name="no_of_person" id="person" placeholder="Type no of person">
                        <div id="person-error" class="error-message text-danger d-none"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
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

function showAlert(type, message) {
    const alertElement = document.getElementById('formAlert');
    alertElement.className = `alert alert-${type}`;
    alertElement.textContent = message;
    alertElement.classList.remove('d-none');
}

document.getElementById('joinForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let hasErrors = false;
    
    document.querySelectorAll('.error-message').forEach(el => el.classList.add('d-none'));
    document.getElementById('formAlert').classList.add('d-none');
    
    const nameInput = document.getElementById('name');
    const mobileInput = document.getElementById('mobile');
    const personInput = document.getElementById('person');
    
    if (!nameInput.value.trim()) {
        showError(nameInput, document.getElementById('name-error'), 'Full name is required');
        hasErrors = true;
    }
    
    if (!mobileInput.value.trim()) {
        showError(mobileInput, document.getElementById('mobile-error'), 'Mobile no is required');
        hasErrors = true;
    } else if (mobileInput.value.length < 11) {
        showError(mobileInput, document.getElementById('mobile-error'), 'Mobile no must be at least 11 characters long');
        hasErrors = true;
    }
    
    if (!personInput.value.trim()) {
        showError(personInput, document.getElementById('person-error'), 'No of person is required');
        hasErrors = true;
    } else {
        const number = parseInt(personInput.value);
        if (isNaN(number) || number <= 0) {
            showError(personInput, document.getElementById('person-error'), 'No of person must be a positive number');
            hasErrors = true;
        } else if (number > <?= $event['available'] ?>) {
            showError(personInput, document.getElementById('person-error'), 'No of person must be less than <?= $event['available'] ?>');
            hasErrors = true;
        }
    }
    
    if (hasErrors) {
        return;
    }
    
    const formData = {
        event_id: <?= $event['id'] ?>,
        name: nameInput.value.trim(),
        mobile_no: mobileInput.value.trim(),
        no_of_person: parseInt(personInput.value)
    };
    
    fetch('/api/join.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            showAlert('danger', data.error);
        } else {
            showAlert('success', data.message);
            document.getElementById('joinForm').reset();
            setTimeout(() => {
                window.location.href = '/index.php';
            }, 2000);
        }
    })
    .catch(error => {
        showAlert('danger', 'An error occurred. Please try again.');
        console.error('Error:', error);
    });
});
</script>

<?php require 'layouts/footer.php'; ?>