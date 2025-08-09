<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["student_user_id"])) {
    header("location: " . base_url("student/dashboard"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Grade Monitoring System - Student Login</title>

    <link rel="shortcut icon" href="<?= base_url('public/assets/img/logo.png') ?>" type="image/x-icon" />
    <link rel="stylesheet" href="<?= base_url('public/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('public/assets/css/student_login.css') ?>" />
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center align-items-center vh-100">
            <div>
                <?php if (isset($_SESSION["notification"])): ?>
                    <div class="alert <?= $_SESSION["notification"]["type"] ?> text-light border-0 text-center" id="notification"><?= $_SESSION["notification"]["message"] ?></div>

                    <?php unset($_SESSION["notification"]) ?>
                <?php endif ?>

                <div class="alert alert-danger bg-danger text-light border-0 text-center d-none" id="notification">Invalid Username or Password</div>
                
                <div class="login-container">
                    <img src="<?= base_url('public/assets/img/logo.png') ?>" alt="Logo" class="logo-large" />
                    <h3 class="mb-3">Student Login</h3>
                    <p class="text-white-50 mb-4">Enter your credentials to access your account</p>

                    <form action="javascript:void(0)" id="student_login_form">
                        <div class="mb-3">
                            <label for="student_login_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="student_login_username" value="<?= isset($_SESSION['student_username']) ? $_SESSION['student_username'] : '' ?>" required />
                        </div>

                        <div class="mb-1">
                            <label for="student_login_password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="student_login_password" value="<?= isset($_SESSION['student_password']) ? $_SESSION['student_password'] : '' ?>" required />
                        </div>

                        <div class="options-row">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="student_login_remember_me" <?= isset($_SESSION['student_username']) && $_SESSION['student_password'] ? 'checked' : '' ?> />
                                <label class="form-check-label" for="student_login_remember_me">Remember Me</label>
                            </div>
                            <a href="javascript:void(0)" class="forgot-password" id="student_login_forgot_password">Forgot Password?</a>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="student_login_submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const base_url = "<?= base_url() ?>";
    </script>

    <script src="<?= base_url('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/js/student_login.js?v=1.0.1') ?>"></script>
</body>

</html>