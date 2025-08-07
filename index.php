<?php

// Set default timezone
date_default_timezone_set('Asia/Manila');

// Start session if none exists
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Helper function for generating base URLs
function base_url($path = '')
{
    // Localhost
    $base = 'http://localhost/Grade-Monitoring-System-For-Can-Avid-National-High-School/';
    // Online
    // $base = 'https://grade-monitoring-system.essuc.online/';

    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

// Load essential configuration and route files
require_once 'config/database.php';
require_once 'routes/web.php';

new Database();

// Automatically detect and normalize URI
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$requestUri = $_SERVER['REQUEST_URI'];
$uri = parse_url($requestUri, PHP_URL_PATH);

// Remove base path and clean the URI
$basePath = rtrim($scriptName, '/');
$uri = '/' . ltrim($uri, '/');
$uri = preg_replace("#^{$basePath}#", '', $uri);
$uri = trim($uri, '/');

// Route handling
if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    http_response_code(404);
    require 'views/errors/404.php';
}
