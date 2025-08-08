<?php
// Set default timezone
date_default_timezone_set('Asia/Manila');

// Start session if none exists
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load helpers
require_once __DIR__ . '/config/helper.php';

// Load configurations and routes
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/routes.php';

// Initialize database
new Database();

// Normalize requested URI
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$basePath = trim(dirname($_SERVER['SCRIPT_NAME']), '/');

// Remove base path from URI
if ($basePath && strpos($uri, $basePath) === 0) {
    $uri = trim(substr($uri, strlen($basePath)), '/');
}

// Route request
if (isset($routes[$uri])) {
    require $routes[$uri];
} else {
    http_response_code(404);
    require __DIR__ . '/views/errors/404.php';
}
