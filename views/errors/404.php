<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Page Not Found - Student Grading System</title>

    <link rel="shortcut icon" href="<?= base_url("public/assets/img/logo.png") ?>" type="image/x-icon">

    <link href="<?= base_url("public/assets/vendor/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?= base_url("public/assets/css/style.css") ?>" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container">

            <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                <h1>404</h1>
                
                <h2>The page you are looking for doesn't exist.</h2>
                
                <a class="btn" href="<?= base_url() ?>">Back to home</a>

                <img src="<?= base_url("public/assets/img/not-found.svg") ?>" class="img-fluid py-5" alt="Page Not Found">
            </section>

        </div>
    </main>
</body>

</html>