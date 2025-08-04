<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>No Function Yet</title>

    <link rel="shortcut icon" href="<?= base_url("public/assets/img/logo.png") ?>" type="image/x-icon">

    <link href="<?= base_url("public/assets/vendor/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
</head>

<body>
    <div class="min-vh-100 d-flex justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="mb-5">Sorry.. This page has no function yet.</h1>
            <button class="btn btn-primary px-5 py-3 logout">Sign Out</button>
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