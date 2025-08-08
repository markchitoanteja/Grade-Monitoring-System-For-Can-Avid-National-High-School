<?php

/**
 * Generate a full base URL for the application.
 *
 * This helper ensures a consistent base URL throughout the app.
 * You can pass a relative path to append to the base.
 *
 * Examples:
 *   base_url(); // http://localhost/Grade-Monitoring-System-For-Can-Avid-National-High-School/
 *   base_url('dashboard'); // http://localhost/Grade-Monitoring-System-For-Can-Avid-National-High-School/dashboard
 *
 * @param string $path Optional relative path to append.
 * @return string Fully-qualified URL.
 */
function base_url(string $path = ''): string
{
    // Choose your environment
    $base = 'http://localhost/Grade-Monitoring-System-For-Can-Avid-National-High-School/';
    // $base = 'https://grade-monitoring-system.essuc.online/';

    return rtrim($base, '/') . '/' . ltrim($path, '/');
}
