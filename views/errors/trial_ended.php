<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trial Period Expired</title>

    <link rel="shortcut icon" href="<?= base_url("public/assets/img/logo.png") ?>" type="image/x-icon">
    <link href="<?= base_url("public/assets/vendor/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .message-container {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 600px;
        }
    </style>
</head>

<body>
    <div class="min-vh-100 d-flex justify-content-center align-items-center">
        <div class="text-center message-container">
            <h1 class="mb-4">Trial Period Ended</h1>
            <p class="lead">We're sorry, but your trial period has expired. Thank you for trying our service!</p>
            <p>To continue using our features, please consider contacting your developer.</p>
            <hr class="my-4">
            <p>Need help? <a href="https://www.facebook.com/markchito/">Contact your Developer</a></p>
            <button class="btn btn-secondary mt-3 logout">Sign Out</button>
        </div>
    </div>

    <script>
        const base_url = "<?= base_url() ?>";
        const user_id = "<?= $_SESSION["user_id"] ?>";
        const notification = <?= isset($_SESSION["notification"]) ? json_encode($_SESSION["notification"]) : json_encode(null) ?>;
        const current_page = "";
    </script>

    <script src="<?= base_url("public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
    <script src="<?= base_url("public/assets/vendor/jquery/jquery.min.js") ?>"></script>
    <script src="<?= base_url("public/assets/js/main_pages.js?v=1.0") ?>"></script>
</body>

</html>