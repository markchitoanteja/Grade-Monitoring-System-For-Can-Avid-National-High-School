<?php
// Set HTTP response status code to 500
http_response_code(500);

// Prevent caching
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

// Set content type
header('Content-Type: text/html; charset=UTF-8');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>500 - Server Error | Student Grading System</title>

    <link rel="shortcut icon" href="<?= base_url("public/assets/img/logo.png") ?>" type="image/x-icon">
    <link href="<?= base_url("public/assets/vendor/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">

    <style>
        body {
            background-color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* Background shapes */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(220, 53, 69, 0.05);
            z-index: -1;
        }

        body::before {
            width: 400px;
            height: 400px;
            top: -150px;
            left: -150px;
        }

        body::after {
            width: 300px;
            height: 300px;
            bottom: -120px;
            right: -120px;
        }

        .error-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 40px 20px;
            background: linear-gradient(135deg, #fdfdfd, #ffffff);
            animation: fadeIn 0.6s ease-in-out;
        }

        .error-text {
            flex: 1 1 400px;
            max-width: 500px;
            padding: 20px;
            text-align: left;
        }

        .error-text h1 {
            font-size: 5rem;
            font-weight: 800;
            color: #dc3545;
            margin-bottom: 0.3rem;
        }

        .error-text h2 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .error-text p {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .btn-home,
        .btn-support {
            display: inline-block;
            padding: 10px 24px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-right: 10px;
        }

        .btn-home {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-home:hover {
            background-color: #b02a37;
            color: #fff;
        }

        .btn-support {
            background-color: #6c757d;
            color: #fff;
        }

        .btn-support:hover {
            background-color: #565e64;
            color: #fff;
        }

        .error-image {
            flex: 1 1 300px;
            max-width: 400px;
            padding: 20px;
            text-align: center;
        }

        .error-image img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            animation: float 3s infinite ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-text">
            <h1>500</h1>
            <h2>Internal Server Error</h2>
            <p>We’re experiencing some technical difficulties. Our team has been notified and is working to fix the problem.
                You can return to the homepage or contact our support team for assistance.</p>
            <a href="<?= base_url() ?>" class="btn-home">Back to Home</a>
            <a href="mailto:00python23@gmail.com" class="btn-support">Contact Support</a>
        </div>
        <div class="error-image">
            <img src="<?= base_url("public/assets/img/server-error.svg") ?>" alt="Server Error">
        </div>
    </div>
</body>

</html>