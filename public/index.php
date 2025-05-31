<?php
date_default_timezone_set('Asia/Manila');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../config/database.php';

// Automatically detect base path
$scriptName = dirname($_SERVER['SCRIPT_NAME']); // e.g. /Students-Grading-System/public
$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string
$uri = parse_url($requestUri, PHP_URL_PATH);

// Remove base path from URI
$basePath = rtrim($scriptName, '/');
$uri = '/' . ltrim($uri, '/');
$uri = preg_replace("#^{$basePath}#", '', $uri);

// Clean the route
$uri = trim($uri, '/');

// Route the request
if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
} else {
    http_response_code(404);
    require __DIR__ . '/../views/errors/404.php';
}
