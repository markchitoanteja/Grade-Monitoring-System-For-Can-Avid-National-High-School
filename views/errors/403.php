<?php
// Send 403 Forbidden header
http_response_code(403);

header('HTTP/1.1 403 Forbidden');
header('Content-Type: text/html; charset=UTF-8');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Access Not Allowed - Student Grading System</title>

    <link rel="shortcut icon" href="<?= base_url("public/assets/img/logo.png") ?>" type="image/x-icon">

    <link href="<?= base_url("public/assets/vendor/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?= base_url("public/assets/css/style.css") ?>" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">

            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1 class="text-warning">403</h1>

                <h2>Access not allowed. You do not have permission to view this page.</h2>

                <a class="btn" href="<?= base_url() ?>">Back to home</a>

                <img src="<?= base_url("public/assets/img/not-found.svg") ?>" class="img-fluid py-5" alt="Access Denied">
            </section>

        </div>
    </main>
</body>

</html>