<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>No Function Yet</title>

    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="min-vh-100 d-flex justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="mb-5">Sorry.. This page has no function yet.</h1>
            <button class="btn btn-primary px-5 py-3 logout">Sign Out</button>
        </div>
    </div>

    <script>
        var user_id = "<?= $_SESSION["user_id"] ?>";
        var notification = <?= isset($_SESSION["notification"]) ? json_encode($_SESSION["notification"]) : json_encode(null) ?>;
    </script>   

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/js/main_pages.js"></script>
</body>