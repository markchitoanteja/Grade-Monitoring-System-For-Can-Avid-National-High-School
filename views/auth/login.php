<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["user_id"])) {
    header("location: main");

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Grade Monitoring System</title>

    <link rel="shortcut icon" href="<?= base_url('public/assets/img/logo.png') ?>" type="image/x-icon">

    <link rel="stylesheet" href="<?= base_url('public/assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/login.css?v=1.0.1') ?>">
</head> 

<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
        <div>
            <?php if (isset($_SESSION["notification"])): ?>
                <div class="alert <?= $_SESSION["notification"]["type"] ?> text-light border-0 text-center" id="notification"><?= $_SESSION["notification"]["message"] ?></div>
            <?php endif ?>

            <div class="alert alert-danger bg-danger text-light border-0 text-center d-none" id="login_message">Invalid Username or Password</div>

            <div class="card py-3" style="width: 750px;">
                <div class="card-body">
                    <div class="row">
                        <!-- Login Form -->
                        <div class="col-7">
                            <h4 class="mb-3">User Login</h4>

                            <form action="javascript:void(0)" id="login_form">
                                <div class="form-group mb-3">
                                    <label for="login_username">Username</label>
                                    <input type="text" class="form-control" id="login_username" value="<?= isset($_SESSION["username"]) ? $_SESSION["username"] : null ?>" required>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="login_password">Password</label>
                                    <input type="password" class="form-control" id="login_password" value="<?= isset($_SESSION["password"]) ? $_SESSION["password"] : null ?>" required>
                                </div>
                                <div class="form-group form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="login_remember_me" <?= isset($_SESSION["username"]) && isset($_SESSION["password"]) ? "checked" : null ?>>
                                    <label class="form-check-label" for="login_remember_me">Remember Me</label>
                                </div>

                                <button type="submit" class="btn btn-primary w-100" id="login_submit">Login</button>
                            </form>
                        </div>
                        <!-- Logo and School Name -->
                        <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-light">
                            <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="Logo" style="width: 100px;">
                            <h3 class="mt-2 text-center"><b>Can-Avid National High School</b></h3>
                            <h4 class="mt-2 text-center">Can-Avid, Eastern Samar</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const base_url = "<?= base_url() ?>";
    </script>

    <script src="<?= base_url('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/login.js?v=1.1.1') ?>"></script>
</body>

</html>

<?php unset($_SESSION["notification"]) ?>